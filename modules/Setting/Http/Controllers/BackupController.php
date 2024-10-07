<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\Setting\Jobs\CleanBackupJob;
use Modules\Setting\Jobs\CreateBackupJob;
use ZipArchive;

class BackupController extends Controller
{

    public function __construct()
    {
        $this->middleware(['demo'])->only(['createBackup', 'destroy','destroyAll', 'factoryReset', 'delete', 'clean']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $disks = $this->getFiles();
        return view('setting::backup.index', compact('disks'));
    }

    /**
     * Create Backup
     *
     * @return mixed
     */
    public function createBackup(Request $request)
    {
        $this->create();
        return response()->json(['status' => 'success', 'message' => localize('backup_created')], 200);
    }

    /**
     * Download Backup
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download(Request $request)
    {

        if ($request->url && $request->disk) {
            return $this->downloadBackup($request->disk, $request->url);
        }

        return abort(404);
    }

    //Password Check For Import Database
    public function passwordCheck(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => localize('password_required')]);
        }

        $password = $request->password;

        if (Hash::check($password, Auth::user()->password)) {
            return response()->json(['passwordCheck' => 'success']);
        } else {
            return response()->json(['status' => 'error', 'message' => localize('password_not_matched')]);
        }

    }

    //Import Database
    public function databaseImport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'database_import' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => localize('database_import_required')]);
        }

        if ($request->hasFile('database_import')) {
            $request_file = $request->file('database_import');

            // Step 1: Delete all tables
            $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
            Schema::disableForeignKeyConstraints();

            foreach ($tables as $table) {
                Schema::dropIfExists($table);
            }

            Schema::enableForeignKeyConstraints();

            // Step 2: Unzip the backup file
            $destinationPath = storage_path('app/database-file/'); // Change this to the desired destination folder

            $zip = new ZipArchive;
            $file = $zip->open($request_file);

            if ($file === true) {
                $zip->extractTo($destinationPath);
                $zip->close();
            }

            // Step 3: Import the SQL file
            $sqlFile = storage_path('app/database-file/db-dumps/mysql-sales_erp_laravel.sql'); // Change this to the correct file path
            $sql = File::get($sqlFile);
            DB::connection()->getPdo()->exec($sql);

            return response()->json(['status' => 'success', 'message' => localize('database_import_successfully')]);
        }

    }

    //Import Database By Name
    public function databaseImportByName(Request $request)
    {
        $explodeFileName = explode('/', $request->file_name);
        $filePath = $explodeFileName[0];
        $fileName = $explodeFileName[1];
        $requestFilePath = storage_path('app/' . $filePath . '/' . $fileName);

        // Step 1: Delete all tables
        $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
        Schema::disableForeignKeyConstraints();

        foreach ($tables as $table) {
            Schema::dropIfExists($table);
        }

        Schema::enableForeignKeyConstraints();

        // Step 2: Unzip the backup file
        $destinationPath = storage_path('app/database-file/'); // Change this to the desired destination folder

        $zip = new ZipArchive;
        $file = $zip->open($requestFilePath);

        if ($file === true) {
            $zip->extractTo($destinationPath);
            $zip->close();
        }

        // Step 3: Import the SQL file
        $sqlFile = storage_path('app/database-file/db-dumps/mysql-sales_erp_laravel.sql'); // Change this to the correct file path
        $sql = File::get($sqlFile);
        DB::connection()->getPdo()->exec($sql);

        return response()->json(['status' => 'success', 'message' => localize('database_import_successfully')]);

    }

    /**
     * Delete Backup
     *
     * @return mixed
     */
    public function destroy(Request $request)
    {

        if ($request->url && $request->disk) {
            $this->delete($request->disk, $request->url);
        }

        return response()->json(['status' => 'success', 'message' => localize('backup_deleted')], 200);
    }

    /**
     * Delete All Backup
     *
     * @return mixed
     */
    public function destroyAll()
    {
        $this->clean();

        return response()->success([], 'Old Backup deleted successfully', 200);
    }

    // Factory Reset
    public function factoryReset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => localize('password_required')]);
        }

        $password = $request->password;

        if (Hash::check($password, Auth::user()->password)) {
            $tables = [
                'acc_vouchers',
                'acc_transactions',
                'acc_opening_balances',
                'salary_generates',
                'salary_sheet_generates',
                'loans',
                'apply_leaves',
                'attendances',
                'manual_attendances',
                'employee_salary_types',
                'salary_advances',
                'leave_type_years',
                'activity_log',
            ];

            foreach ($tables as $table) {
                DB::table($table)->truncate();
            }

            return response()->json(['status' => 'success', 'message' => localize('factory_reset_successfully')]);
        } else {
            return response()->json(['status' => 'error', 'message' => localize('password_not_matched')]);
        }

    }

///
    /**
     * Get All Backup Files
     *
     * @return array<\Illuminate\Support\Collection>
     */
    private function getFiles(string $disk = '')
    {
        $disks = [];
        foreach (config('backup.backup.destination.disks') as $key => $disk) {
            $storageFiles = Storage::disk($disk)->files(config('backup.backup.name'));

            //   array map and filter by last modified Descending
            $disks[$disk] = collect($storageFiles)->map(function ($file) use ($disk) {
                return [
                    'disk' => $disk,
                    'name' => $file,
                    'size' => Storage::disk($disk)->size($file),
                    'last_modified' => date('Y-m-d H:i:s', Storage::disk($disk)->lastModified($file)),
                    'url' => $file,
                ];
            });
            $disks[$disk] = $disks[$disk]->sortBy(function ($item) {
                return $item['last_modified'];
            })->reverse();

        }

        return $disks;
    }

    /**
     * Create Backup File
     *
     * @return bool
     */
    private function create(string $option = 'only-db')
    {
        CreateBackupJob::dispatch($option);
        return true;
    }

    /**
     * Download Backup File
     *
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function downloadBackup(string $disk, string $file)
    {

        if (!Storage::disk($disk)->exists($file)) {
            return abort(404);
        }

        ob_end_clean();
        $file = Storage::disk($disk)->download($file);

        return $file;
    }

    /**
     * Delete Backup File
     *
     * @return bool
     */
    private function delete(string $disk, string $file)
    {

        if (!Storage::disk($disk)->exists($file)) {
            return abort(404);
        }

        $file = Storage::disk($disk)->delete($file);

        return $file;
    }

    /**
     * Delete All Backup Files
     *
     * @return bool
     */
    private function clean()
    {
        CleanBackupJob::dispatch();
        Session::flash('success', 'Your request has been accepted by the server. Please wait for a few moments.');
        return true;
    }

}

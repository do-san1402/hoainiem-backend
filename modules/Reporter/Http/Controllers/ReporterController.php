<?php

namespace Modules\Reporter\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Reporter\Entities\Reporter;
use Modules\Reporter\Entities\Department;
use Modules\Setting\Entities\Country;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Reporter\DataTables\ReporterDataTable;
use Intervention\Image\Facades\Image;

class ReporterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_reporter')->only('index');
        $this->middleware('permission:create_reporter')->only(['create', 'store']);
        $this->middleware('permission:update_reporter')->only(['edit', 'update']);
        $this->middleware('permission:delete_reporter')->only('destroy');

        $this->middleware(['demo'])->only(['store', 'update', 'reporterStatusEdit', 'destroy']);

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ReporterDataTable $dataTable)
    {
        return $dataTable->render('reporter::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $departments = Department::get();
        $countries   = Country::where('is_active', 1)->get();
        return view('reporter::create', compact('departments', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $request->validate([
            'password' => 'required',
            'email' => 'required|email|unique:reporters,email|max:100',
            'name' => 'required|max:255',
            'mobile' => 'required|max:20',
            'user_type' => 'required',
        ]);

        DB::beginTransaction();
        try {
            // create new user for this employee
            $user = new User();
            $user->user_type_id = 2;
            $user->user_name = strtolower($request->name);
            $user->full_name = strtolower($request->name);
            $user->email = $request->email;
            $user->contact_no = $request->mobile;
            $user->password = $password_hash =  Hash::make($request->password);
            $user->is_active = true;
            $user->save();
            $user->assignRole(2);

            $reporter = new Reporter();
            $reporter->fill($request->all());
            $reporter->user_id = $user->id;
            $reporter->password = $password_hash;
            $reporter->status = 1;

            $reporter->save();

            DB::commit();

            // If the creation was successful, redirect with success message
            return response()->json(['error' => false, 'msg' => localize('data_saved_successfully')]);

        } catch (\Exception $e) {
            DB::rollback();
            activity()
                ->causedBy(auth()->user())
                ->log('An error occurred: ' . $e->getMessage());
            return response()->json(['error' => true, 'msg' => 'Failed to save data: ' . $e->getMessage()]);
        }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('reporter::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Reporter $reporter)
    {
        $departments = Department::get();
        $countries   = Country::where('is_active', 1)->get();
        return view('reporter::edit', compact('departments', 'countries', 'reporter'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $reporter_info =  Reporter::where('id', $id)->firstOrFail();

        $request->validate([
            'email' => 'required|email|max:100|unique:reporters,email,' . $reporter_info->id,
            'name' => 'required|max:255',
            'mobile' => 'required|max:20',
            'user_type' => 'required',
        ]);

        DB::beginTransaction();
        try {

            $password_hash = null;

            // Update user information
            $user = User::where('id', $reporter_info->user_id)->firstOrFail();
            $user->user_name = strtolower($request->name);
            $user->full_name = strtolower($request->name);
            $user->email = $request->email;
            $user->contact_no = $request->mobile;
            if($request->password != null){
                $user->password = $password_hash  = Hash::make($request->password);
            }

            $reporter_info->fill($request->all());
            $reporter_info->password = $password_hash;

            // Picture save
            if ($request->hasFile('photo')) {
                if ($reporter_info->photo) {
                    Storage::disk('public')->delete($reporter_info->photo);
                }
                $request_file = $request->file('photo');
                $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
                $path = $request_file->storeAs('reporter', $filename, 'public');
                $reporter_info->photo = $path;

                //create folder if not exists
                if (!file_exists(public_path('storage/users'))) {
                    mkdir(public_path('storage/users'), 0777, true);
                }

                $destination = public_path('storage/' . $user->profile_image ?? null);
                if ($user->profile_image != null && file_exists($destination)) {
                    unlink($destination);
                }
                $user_img_path = Storage::disk('public')->putFileAs('users', $request_file, $filename);
                Image::make($request_file)->save(public_path('storage/' . $user_img_path));
                $user->profile_image = $user_img_path;
            }

            // User Update
            $user->save();

            // Reporter Update
            $reporter_info->save();

            DB::commit();

            // If the creation was successful, redirect with success message
            return response()->json(['error' => false, 'msg' => localize('data_updated_successfully')]);

        } catch (\Exception $e) {
            DB::rollback();
            activity()
                ->causedBy(auth()->user())
                ->log('An error occurred: ' . $e->getMessage());
            return response()->json(['error' => true, 'msg' => 'Failed to update data: ' . $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Reporter $reporter)
    {
        try {

            $reporter->delete();

            // Delete user information
            $user = User::where('id', $reporter->user_id)->first();
            $user->delete();

            // If the creation was successful, redirect with success message
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            return response()->json(['fail' => 'fail']);
        }
    }

    /**
     * Update the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function reporterStatusEdit(Reporter $reporter)
    {
        $status = ($reporter->status==1?'0':'1');

        try {

            $reporter_up = $reporter->update([
                'status' => $status
            ]);

            // Update user information
            $user = User::where('id', $reporter->user_id)->first();
            $user->is_active = $status;
            $user->save();

            // If the creation was successful, redirect with success message
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            return response()->json(['fail' => 'fail']);
        }
    }

}

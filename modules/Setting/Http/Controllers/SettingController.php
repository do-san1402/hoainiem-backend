<?php

namespace Modules\Setting\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Modules\Setting\Entities\SMS;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Country;
use Modules\Setting\Entities\Currency;
use Modules\Setting\Entities\TaxSetting;
use Illuminate\Support\Facades\Validator;
use Modules\Setting\Entities\ActivityLog;
use Modules\Setting\Entities\Application;
use Modules\Setting\Entities\EmailConfig;
use Illuminate\Contracts\Support\Renderable;
use Modules\Setting\Http\DataTables\TaxGroupDataTable;
use Modules\Setting\Http\DataTables\ActivityLogDataTable;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_tax_settings')->only('tax_settings');
        $this->middleware('permission:create_tax_settings')->only(['store_tax_settings']);

        $this->middleware('permission:read_tax_settings')->only('tax_settings');
        $this->middleware('permission:create_tax_settings')->only(['store_tax_settings']);

        $this->middleware(['demo'])->only(['deleteTaxGroup','activityLogDestroy', 'multipleDeleteActivityLog']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function settings()
    {
        return view('setting::settings');
    }

    public function index()
    {
        return view('setting::index', [
            'users' => User::orderBy('id', 'desc')->get(),
            'app' => Application::first(),
            'countries' => Country::withoutGlobalScopes([Asc::class])->get(),
            'currencies' => Currency::withoutGlobalScopes([Asc::class])->get(),
            'mail' => EmailConfig::first(),
            'sms' => SMS::first(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function tax_settings(TaxGroupDataTable $dataTable)
    {
        $count = 1;
        $taxes = TaxSetting::where('tax_type', 2)->get();
        return $dataTable->render('setting::tax_setting.tax_setting', compact('count', 'taxes'));
    }

    public function store_tax_settings(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'tax_name.*' => 'required',
            'tax_number.*' => 'required',
            'tax_percentage.*' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'message' => $validation->errors()]);
        }

        $count = count($request->tax_name);

        //delete removed tax
        $taxes = TaxSetting::all();
        foreach ($taxes as $key => $value) {
            if (!in_array($value->tax_number, $request->tax_number)) {
                if ($value->tax_type == 2) {

                    $tax = TaxSetting::whereRaw('JSON_CONTAINS(`tax_group_id`, \'["' . $value->id . '"]\')')->get();
                    //delete tax all
                    if ($tax) {
                        foreach ($tax as $key => $value) {
                            $value->delete();
                        }
                    }
                    $value->delete();
                }
            }
        }

        for ($i = 0; $i < $count; $i++) {
            $taxNumber = TaxSetting::where('tax_number', $request->tax_number[$i])->first();
            $tax = $taxNumber ? TaxSetting::find($taxNumber->id) : new TaxSetting();
            $tax->tax_number = $request->tax_number[$i];
            $tax->tax_name = $request->tax_name[$i];
            $tax->tax_percentage = $request->tax_percentage[$i];
            $tax->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Tax Settings Saved Successfully']);
    }

    public function store_tax_group(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'tax_group_name' => 'required',
            'tax_setting_id.*' => 'required',
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'message' => $validation->errors()]);
        }

        //calculate tax percentage
        $taxPercentage = 0;
        foreach ($request->tax_setting_id as $key => $value) {
            $taxPercentage += TaxSetting::find($value)->tax_percentage;
        }

        if ($request->tax_group_id != null) {
            $taxGroup = TaxSetting::find($request->tax_group_id);
            $taxGroup->tax_name = $request->tax_group_name;
            $taxGroup->tax_group_id = json_encode($request->tax_setting_id);
            $taxGroup->tax_percentage = $taxPercentage;
            $taxGroup->tax_type = 1;
            $taxGroup->save();
        } else {
            $addGroupTax = new TaxSetting();
            $addGroupTax->tax_name = $request->tax_group_name;
            $addGroupTax->tax_group_id = json_encode($request->tax_setting_id);
            $addGroupTax->tax_percentage = $taxPercentage;
            $addGroupTax->tax_type = 1;
            $addGroupTax->save();
        }
        return response()->json(['status' => 'success', 'message' => 'Tax Group Setting Saved Successfully']);
    }

    //send all tax settings data to select2
    public function getTaxSettings(Request $request)
    {
        $taxes = TaxSetting::where('tax_name', 'LIKE', '%' . $request->input('term', '') . '%')->get();
        return response()->json($taxes);
    }
    //send all tax settings data to select2
    public function getTaxSettingsForTaxGroup(Request $request)
    {
        $taxes = TaxSetting::where('tax_type', 2)->where('tax_name', 'LIKE', '%' . $request->input('term', '') . '%')->get();
        return response()->json($taxes);
    }

    //get tax group data by id
    public function getTaxGroupById(Request $request)
    {
        $taxGroup = TaxSetting::find($request->id);
        $tax_id = $taxGroup->tax_group_id = json_decode($taxGroup->tax_group_id);
        $taxGroup->tax_group = TaxSetting::whereIn('id', $tax_id)->get();
        return response()->json($taxGroup);
    }

    //delete tax group
    public function deleteTaxGroup(Request $request)
    {
        $taxGroup = TaxSetting::find($request->id);
        //find this tax id in tax_group_id column
        $taxGroup->delete();
        return response()->json(['status' => 'success', 'message' => 'Tax Group Deleted Successfully']);
    }

    public function activityLog(ActivityLogDataTable $datatables)
    {
        return $datatables->render('setting::activity_log');
    }

    public function activityLogDestroy($id)
    {
        DB::beginTransaction();
        try {

            ActivityLog::findOrFail($id)->delete();

            DB::commit();
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('fail', localize('data_save_error'));
        }
    }

    public function multipleDeleteActivityLog(Request $request)
    {
        $ids = $request->ids;
        ActivityLog::whereIn('id', explode(",", $ids))->delete();
        return response()->json(['status' => true, 'message' => localize('activity_logs_deleted_successfully')]);

    }
}

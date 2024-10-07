<?php
namespace Modules\Setting\Http\Controllers;

use Str;
use URL;
use File;
use App\Scopes\Asc;
use App\Traits\PictureTrait;
use Illuminate\Http\Request;
use App\Traits\PictureResizeTrait;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Setting\Entities\Currency;
use Modules\Setting\Entities\Country;

class CurrencyController extends Controller
{
    use PictureTrait ,PictureResizeTrait;

    public function __construct()
    {
        $this->middleware('permission:read_currency')->only('index');
        $this->middleware('permission:create_currency')->only(['store']);
        $this->middleware('permission:update_currency')->only(['edit, update']);
        $this->middleware('permission:destroy_currency')->only(['destroy']);
    }

    public function index(){

        $currencies = Currency::withoutGlobalScopes([Asc::class])->get();
        return view('setting::currency.index',[
            'currencies' => $currencies,
            
        ]);
     }


    public function create(){
        $countries = Country::where('is_active', 1)->get();
        return view('setting::currency.create',[
            'countries' =>  $countries,
            
        ]);
     }

    public function store(Request $request){

           $this->validate($request,[
               'title' => 'required|string',
               'country_id' => 'required',
               'symbol' => 'required'
           ]);

           $currency = new Currency();
           $currency->fill($request->all());
           $currency->save();
           Toastr::success('Currency added successfully :)','Success');
           return redirect()->back()->with('success' , 'Data added successfully');

    }

    public function edit($id){
        $currency = Currency::findOrFail($id);
        $countries = Country::where('is_active', 1)->get();

        return view('setting::currency.edit',[
            'countries' =>  $countries,
            'currency' => $currency,
        ]);
    }

    public function update(Request $request , $id){
        $this->validate($request,[
            'title' => 'required|string',
            'country_id' => 'required',
            'symbol' => 'required'
        ]);

        $currency = Currency::findOrFail($id);
        $currency->fill($request->all());
        $currency->save();

        Toastr::success('Currency Updated successfully :)','Success');
        return redirect()->route('currencies.index')->with('success' , 'Data updated successfully');

    }

    public function status($id){
        $currency = Currency::findOrFail($id);
        $currency->status = $currency->status == 1 ? 0 : 1;
        $currency->save();

        Toastr::success('Currency status changed successfully :)','Success');
        return redirect()->back()->with('success' , 'Status Changed successfully');
    }

    public function destroy($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        Toastr::success('Currency Deleted successfully :)','Success');
        return response()->json(['success' => 'Data Deleted Successfully']);
    }
}

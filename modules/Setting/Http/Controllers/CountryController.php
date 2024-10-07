<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\Setting\Entities\Country;
use Illuminate\Contracts\Support\Renderable;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_delivery')->only('index', 'show');
        $this->middleware('permission:create_delivery')->only(['create', 'store']);
        $this->middleware('permission:update_delivery')->only(['edit', 'update']);
        $this->middleware('permission:delete_delivery')->only('destroy');
    }
    
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('setting::country.index', [
            'countries' => Country::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_name' => 'required',
            'country_code' => 'required'
        ]);
        Country::create($request->all());
        Toastr::success('Country added successfully :)','Success');
        return redirect()->route('countries.index');  
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('setting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('setting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $uuid)
    {
        $request->validate([
            'country_name' => 'required',
            'country_code' => 'required'
        ]);
        $country = Country::where('uuid', $uuid)->firstOrFail();
        $country->update($request->all());
        Toastr::success('Country updated successfully :)','Success');
        return redirect()->route('countries.index');  
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($uuid)
    {        
        Country::where('uuid', $uuid)->delete();
        Toastr::success('Country Deleted successfully :)','Success');
        return response()->json(['success' => 'success']);
    }
}

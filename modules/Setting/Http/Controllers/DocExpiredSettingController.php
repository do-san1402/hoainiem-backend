<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\DocExpiredSetting;

class DocExpiredSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $doc_expired_setup = DocExpiredSetting::first();
        return view('setting::docexpired-setup.index', compact('doc_expired_setup'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'primary_expiration_alert' => 'required',
            'secondary_expiration_alert' => 'required',
        ]);

        DocExpiredSetting::truncate();
        DocExpiredSetting::create([
            'primary_expiration_alert' => $request->primary_expiration_alert,
            'secondary_expiration_alert' => $request->secondary_expiration_alert,
        ]);

        return redirect()->route('docexpired-setup.index')->with('success', localize('data_save'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

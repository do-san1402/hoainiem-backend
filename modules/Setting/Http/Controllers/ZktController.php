<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Setting\Entities\Zkt;
use Modules\Setting\Http\DataTables\ZktDataTable;

class ZktController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ZktDataTable $datatables)
    {
        return $datatables->render('setting::zkt.index');
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('setting::zkt.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required',
            'ip_address' => 'required',
            'status' => 'required',
        ]);
        $zkt = new Zkt();
        $zkt->fill($request->all());
        $inserted = $zkt->save();

        if ($inserted) {
            return response()->json(['error' => false, 'msg' => 'Added Successfully']);
        } else {
            return response()->json(['error' => true, 'msg' => 'Something Went Wrong']);
        }
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
        $data = Zkt::findOrFail($id);
        return response()->view('setting::zkt.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'device_id' => 'required',
            'ip_address' => 'required',
            'status' => 'required',
        ]);

        $zktUpdate = Zkt::findOrFail($id);
        $updated = $zktUpdate->update($request->all());

        if ($updated) {
            return response()->json(['error' => false, 'msg' => 'Updated Successfully']);
        } else {
            return response()->json(['error' => true, 'msg' => 'Something Went Wrong']);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {

            Zkt::findOrFail($id)->delete();

            DB::commit();
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->back()->with('fail', localize('data_save_error'));
        }
    }
}

<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;

class SubscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_subscribers')->only('index');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $dbData = DB::table('subscriptions')
            ->join('categories', 'categories.id', '=', 'subscriptions.category')
            ->select('subscriptions.*', 'categories.category_name')
            ->where('subscriptions.deleted_at', Null)
            ->orderBy('subscriptions.id', 'DESC')
            ->get();

        // dd($dbData);

        return view('setting::subscription.index', compact('dbData'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('setting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
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

<?php

namespace Modules\Advertisement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Setting\Entities\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Modules\Advertisement\Entities\Advertisement;
use Modules\Advertisement\DataTables\AdvertisementDataTable;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_advertise')->only('index');
        $this->middleware('permission:create_advertise')->only(['create','store']);
        $this->middleware('permission:update_advertise')->only(['edit','update', 'updateLgStatus', 'updateSmStatus']);
        $this->middleware('permission:delete_advertise')->only('destroy');
        $this->middleware('demo')->only(['updateLgStatus','updateSmStatus','store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(AdvertisementDataTable $dataTable)
    {
        return $dataTable->render('advertisement::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $ac = Setting::select('details')->where('id', 16)->first();
        $active_theme = json_decode($ac->details);

        $active = 1;

        return view('advertisement::create', compact('active_theme', 'active'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $path = '';
        $request->validate([
            'page' => 'required',
            'ad_position' => 'required',
            'ad_type' => 'required',
        ]);

        $ad_type = $request->ad_type;
        $embed_code_link = '';
        if ($ad_type == 1) {
            $request->validate([
                'embed_code' => 'required', // Additional validation rule
            ]);
            $google_ad_client = '<script><script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client='. trim($request->embed_code).'" crossorigin="anonymous"></script> <ins class="adsbygoogle"   style="display:block" data-ad-client="'. trim($request->embed_code).'" data-ad-slot="8352319773" data-ad-format="auto" data-full-width-responsive="true"></ins></script>';
            $embed_code_link = $google_ad_client;

        } elseif ($ad_type == 2) {

            $request->validate([
                'ad_url'   => 'required',
                'ad_image' => 'required|file|mimes:gif,jpg,jpeg,png,webp|max:1024', // 1024 KB
            ]);

            if ($request->hasFile('ad_image')) {
                $request_file = $request->file('ad_image');
                $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
                $path = $request_file->storeAs('ad_image', $filename, 'public');

                $ad_img = asset('storage/' . $path);
                $ad_img_url = $this->addhttp(trim(@$request->ad_url));
                $embed_code_link = '<a target="_blank" href="' . $ad_img_url . '"><img width="100%" src="' . $ad_img . '" alt=""></a>';
            }
        }

        try {

            $advertisement = Advertisement::create([
                'theme'            => $request->theme,
                'page'             => $request->page,
                'ad_position'      => $request->ad_position,
                'embed_code'       => $embed_code_link,
            ]);

            // If the creation was successful, redirect with success message
            return response()->json(['error' => false, 'msg' => localize('data_saved_successfully')]);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            // You can customize the error message based on the type of exception
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
        return view('advertisement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Advertisement $advertise)
    {
        return view('advertisement::edit', compact('advertise'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $advertise = Advertisement::findOrFail($id);

        $request->validate([
            'page' => 'required',
            'ad_position' => 'required',
            'ad_type' => 'required',
        ]);

        $path =  '';
        $ad_type = $request->ad_type;
        $embed_code_link = '';
        if ($ad_type == 1) {
            $request->validate([
                'embed_code' => 'required', // Additional validation rule
            ]);
            $google_ad_client = '<script>
                                      (adsbygoogle = window.adsbygoogle || []).push({
                                        google_ad_client: "'. trim($request->embed_code).'",
                                        enable_page_level_ads: true
                                      });
                                    </script>';
            $embed_code_link = $google_ad_client;

        } elseif ($ad_type == 2) {

            $request->validate([
                'ad_url'   => 'required',
                'ad_image' => 'required|file|mimes:gif,jpg,jpeg,png,webp|max:1024', // 1024 KB
            ]);

            if ($request->hasFile('ad_image')) {

                $request_file = $request->file('ad_image');
                $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
                $path = $request_file->storeAs('ad_image', $filename, 'public');

                $ad_img = asset('storage/' . $path);
                $ad_img_url = $this->addhttp(trim(@$request->ad_url));
                $embed_code_link = '<a target="_blank" href="' . $ad_img_url . '"><img width="100%" src="' . $ad_img . '" alt=""></a>';
            }
        }

        try {

            $advertise_up = $advertise->update([
                'page'             => $request->page,
                'ad_position'      => $request->ad_position,
                'embed_code'       => $embed_code_link,
            ]);

            // If the creation was successful, redirect with success message
            return response()->json(['error' => false, 'msg' => localize('data_updated_successfully')]);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            // You can customize the error message based on the type of exception
            return response()->json(['error' => true, 'msg' => 'Failed to update data: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Advertisement $advertise)
    {

        $advertise->delete();

        return response()->json(['success' => 'success']);
    }

    /**
     * Update the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function updateLgStatus(Advertisement $advertise)
    {
        $status = ($advertise->large_status==1?'0':'1');

        try {

            $advertise_up = $advertise->update([
                'large_status'    => $status
            ]);

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
    public function updateSmStatus(Advertisement $advertise)
    {
        $status = ($advertise->mobile_status==1?'0':'1');

        try {

            $advertise_up = $advertise->update([
                'mobile_status'    => $status
            ]);

            // If the creation was successful, redirect with success message
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            return response()->json(['fail' => 'fail']);
        }
    }

    #----------------------------------
    #      To add http dynamically
    #----------------------------------
    function addhttp($url) {

        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }


}

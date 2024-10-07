<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Setting\Entities\TopBreaking;
use Modules\Setting\Entities\Setting;
use App\Models\HomePagePosition;

class ViewSetupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['demo'])->only(['store', 'homePageSettingsStore', 'contactPageSetupStore', 'homePageSettingsSave']);
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('setting::index');
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
     * Display a listing of the resource.
     * @return Renderable
     */
    public function setupTopBreaking()
    {
        $top_breaking = TopBreaking::first();
        $categories   = Category::where('category_type', 2)->get();
        return view('setting::web_setup.setup_top_breaking', compact('categories', 'top_breaking'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $record = TopBreaking::first();
        $data = [
            'category_slug'    => $request->category_slug,
            'title'            => $request->title,
            'background_color' => $request->background_color,
            'status'           => $request->status,
        ];

        if($record == null){

            try {

                $record_create = TopBreaking::create($data);

                // If the creation was successful, redirect with success message
                return response()->json(['error' => false, 'msg' => localize('data_saved_successfully')]);
            } catch (\Exception $e) {
                // If an exception occurs (e.g., validation error, database error), handle it here
                // You can customize the error message based on the type of exception
                return response()->json(['error' => true, 'msg' => 'Failed to save data: ' . $e->getMessage()]);
            }
        }else{

            try {

                $record_up = $record->update($data);

                // If the creation was successful, redirect with success message
                return response()->json(['error' => false, 'msg' => localize('data_updated_successfully')]);
            } catch (\Exception $e) {
                // If an exception occurs (e.g., validation error, database error), handle it here
                // You can customize the error message based on the type of exception
                return response()->json(['error' => true, 'msg' => 'Failed to update data: ' . $e->getMessage()]);
            }
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

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function contactPageSetup()
    {
        $contact_setting = Setting::where('id',113)->first();
        $contact_setting_page = json_decode($contact_setting->details);

        return view('setting::web_setup.contact_page_setup', compact('contact_setting_page'));
    }

   /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function contactPageSetupStore(Request $request)
    {
        $contact_page = Setting::where('id',113)->first();

        $S_data ['id'] = 113;
        $S_data ['event'] = 'contact_page_setup';

        $post['editor'] = $request->input('editor');
        $post['content'] = $request->input('content');
        $post['address'] = $request->input('address');
        $post['phone'] = $request->input('phone');
        $post['phone_two'] = $request->input('phone_two');
        $post['email'] = $request->input('email');
        $post['website'] = $request->input('website');
        $post['latitude'] = $request->input('latitude');
        $post['longitude'] = $request->input('longitude');
        $post['map'] = $request->input('map');

        $S_data ['details'] = json_encode($post);

        try {

            $contact_page_up = $contact_page->update($S_data);

            // If the creation was successful, redirect with success message
            return response()->json(['error' => false, 'msg' => localize('data_updated_successfully')]);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            // You can customize the error message based on the type of exception
            return response()->json(['error' => true, 'msg' => 'Failed to update data: ' . $e->getMessage()]);
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function homePageSettings()
    {
        $home_page_settings = HomePagePosition::get();
        $categories         = Category::get();
        return view('setting::web_setup.home_page_setup', compact('home_page_settings', 'categories'));
    }

   /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function homePageSettingsSave(Request $request)
    {
        $request->validate([
            'position_no'       => 'required',
            'category_name'     => 'required',
        ]);

        $position_no            = $request->input('position_no') - 1;
        $data['category_id']    = $request->input('category_name');
        $data['max_news']       = $request->input('max_news');

        $homePagePosition       = HomePagePosition::get();
        $homePagePositionCount  = $homePagePosition->count();

        $cat_info = Category::where('category_id', $data['category_id'])->first();
        $insertData = [
            'slug'          => $cat_info->slug,
            'cat_name'      => $cat_info->category_name,
            'category_id'   => $data['category_id'],
            'max_news'      => null,
            'status'        => 0,
        ];

        try {
            if($position_no < $homePagePositionCount){
                $allInsertData      = [];
                $allInsertData[]    = $insertData;

                for($i=$position_no; $i < $homePagePositionCount; $i++){
                    $allInsertData[] = [
                        'cat_name'      => $homePagePosition[$i]->cat_name,
                        'slug'          => $homePagePosition[$i]->slug,
                        'max_news'      => $homePagePosition[$i]->max_news,
                        'category_id'   => $homePagePosition[$i]->category_id,
                        'status'        => $homePagePosition[$i]->status,
                    ];
                    HomePagePosition::where('id' , $homePagePosition[$i]->id)->delete();
                }
                HomePagePosition::insert($allInsertData);
            }
            else{
                HomePagePosition::create($insertData);
            }

            // If the creation was successful, redirect with success message
            return response()->json(['error' => false, 'msg' => localize('data_updated_successfully')]);

        } catch (\Exception $e) {
            // You can customize the error message based on the type of exception
            return response()->json(['error' => true, 'msg' => 'Failed to update data: ' . $e->getMessage()]);
        }
    }

   /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function homePageSettingsStore(Request $request)
    {
        $position_no    = $request->input('position_no');
        $category_id    = $request->input('category_id');
        $max_news       = $request->input('max_news');
        $status         = $request->input('status');

        foreach ($position_no as $key => $value) {

            $cat_info = Category::where('category_id', $category_id[$value])->first();

            if (!isset($status[$value])) {
                $new_status = 0;
            } else {
                $new_status = $status[$value];
            }
            $new_data[$value] = array(
                'cat_name'      => $cat_info->category_name,
                'slug'          => $cat_info->slug,
                'max_news'      => @$max_news,
                'category_id'   => $category_id[$value],
                'status'        => $new_status,
            );
        }

        try {
             HomePagePosition::truncate();
             HomePagePosition::insert($new_data);

            // If the creation was successful, redirect with success message
            return response()->json(['error' => false, 'msg' => localize('data_updated_successfully')]);

        } catch (\Exception $e) {
            // You can customize the error message based on the type of exception
            return response()->json(['error' => true, 'msg' => 'Failed to update data: ' . $e->getMessage()]);
        }
    }

}

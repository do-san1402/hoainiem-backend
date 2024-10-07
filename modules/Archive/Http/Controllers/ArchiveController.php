<?php

namespace Modules\Archive\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Illuminate\Support\Facades\DB;
use Modules\Archive\Entities\MaxArchiveSetting;
use Modules\Archive\Entities\NewsArchive;
use Modules\Archive\Entities\NewsRouting;
use Modules\Archive\DataTables\ArchiveDataTable;
use App\Models\NewsMst;

class ArchiveController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_archive_setting')->only('index');
        $this->middleware('permission:create_archive_setting')->only(['create','store', 'saveMaxArchiveSettings', 'archiveNewsesByCategory']);
        $this->middleware('permission:delete_archive_setting')->only('destroy');

        $this->middleware('demo')->only(['store', 'saveMaxArchiveSettings', 'destroy']);

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(ArchiveDataTable $dataTable)
    {
        return $dataTable->render('archive::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = Category::get();

        return view('archive::create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $post['category_id']  = $request->input("category_id");
        $post['max_archive']  = 0;

        $check_settings_exist = MaxArchiveSetting::where('category_id',$post['category_id'])->first();

        if ($check_settings_exist) {

            // You can customize the error message based on the type of exception
            return response()->json(['error' => true, 'msg' => 'Already exists']);

        } else{

            try {

                MaxArchiveSetting::create($post);

                // If the creation was successful, redirect with success message
                return response()->json(['error' => false, 'msg' => localize('data_saved_successfully')]);
            } catch (\Exception $e) {
                // If an exception occurs (e.g., validation error, database error), handle it here
                // You can customize the error message based on the type of exception
                return response()->json(['error' => true, 'msg' => 'Failed to save data: ' . $e->getMessage()]);
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
        return view('archive::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('archive::edit');
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
    public function destroy(MaxArchiveSetting $archive)
    {
        try {

            MaxArchiveSetting::where('uuid', $archive->uuid)->forceDelete();

            // If the creation was successful, redirect with success message
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            return response()->json(['fail' => 'fail']);
        }
    }

     /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function saveMaxArchiveSettings(Request $request)
    {
        $data = $request->all();
        $category_ids = $data['category_ids'];
        $max_archives = $data['max_archives'];

        try {

            foreach($category_ids as $key => $category_id){

                $post['category_id']  = $category_id;
                $post['max_archive']  = $max_archives[$key];

                $check_settings_exist = MaxArchiveSetting::where('category_id',$category_id)->first();
                if ($check_settings_exist) {
                    $check_settings_exist->update($post);
                }else{
                    MaxArchiveSetting::create($post);
                }
            }

            // If the creation was successful, redirect with success message
            return response()->json(['error' => false, 'msg' => localize('data_updated_successfully')]);

        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            // You can customize the error message based on the type of exception
            return response()->json(['error' => true, 'msg' => 'Failed to update data: ' . $e->getMessage()]);
        }
    }

     /**
     * Update the specified resource in storage.
     * @param int $cat_id_available
     * @return Renderable
     */
    public function archiveNewsesByCategory($cat_id_available)
    {
        list($category_id, $available_for_archive) = explode('~', $cat_id_available);

        $get_category_slug = Category::where('category_id', $category_id)->first();
        $category_name = $get_category_slug->slug;

        // confirmation for max archive settings
        $number_of_archive = $this->maximum_archive_settings_by_category($category_name, $category_id, $available_for_archive);

        // send to news archive
        $this->send_to_news_archive($category_name, $number_of_archive);

        // updating routing table
        $news_by_category = $this->getNewsByCategory($category_name, $number_of_archive);
        $tbl_name = 'news_archives';

        if ($news_by_category) {
            foreach ($news_by_category as $key => $value) {
                $this->news_routing($tbl_name, $value->news_id);
                $this->delete_news_by_id($value->news_id);
            }
        }

        // dd($number_of_archive);

    }

     #----------------------------------------
         # To DELETE news by ID
    #---------------------------------------
    public function delete_news_by_id($news_id) {

        NewsMst::where('news_id', $news_id)->delete();
    }

    #-----------------------------------------
         # To routing news in Routing Table
    #----------------------------------------
    public function news_routing($tbl_name, $news_id) {

        NewsRouting::where('news_id', $news_id)
        ->update(['table_name' => $tbl_name]);

    }

    #-----------------------------------------

    #-----------------------------------------
    public function getNewsByCategory($category_name, $limit)
    {
        $query = NewsMst::where('page', $category_name)
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();

        if ($query->isNotEmpty()) {
            return $query;
        } else {
            return false;
        }
    }

    #------------------------------------------
        # To send news in news archive
    #---------------------------------------------
    public function send_to_news_archive($category_name, $number_of_archive) {

        NewsArchive::insertUsing(
            ['uuid', 'news_id', 'encode_title', 'seo_title', 'stitle', 'title', 'news', 'image', 'image_base_url', 'videos', 'podcust_id', 'image_alt', 'reporter', 'page', 'reference', 'ref_date', 'post_by', 'update_by', 'time_stamp', 'post_date', 'publish_date', 'last_update', 'is_latest', 'reader_hit', 'status'],
            DB::table('news_msts')
                ->select(['uuid', 'news_id', 'encode_title', 'seo_title', 'stitle', 'title', 'news', 'image', 'image_base_url', 'videos', 'podcust_id', 'image_alt', 'reporter', 'page', 'reference', 'ref_date', 'post_by', 'update_by', 'time_stamp', 'post_date', 'publish_date', 'last_update', 'is_latest', 'reader_hit', 'status'])
                ->where('page', $category_name)
                ->orderBy('id', 'desc')
                ->limit($number_of_archive)
        );

    }

    #-----------------------------------------------
        # @param string $category_name
    #----------------------------------------------
    public function maximum_archive_settings_by_category($category_name, $category_id, $available_for_archive) {
        // max archive settings
        $arc_settings = MaxArchiveSetting::where('category_id',$category_id)->first();

        $max_archive_settings = $arc_settings->max_archive;

        $total_news = NewsMst::where('page',$category_name)->count();

        $now_available_news = $total_news - $max_archive_settings;

        if ($now_available_news < 10) {
            return $now_available_news;
        } else {
            return 10;
        }
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function get_all_category()
    {
        // Fetch categories and their max_archive settings
        $result = DB::table('categories')
        ->select('categories.category_id', 'categories.slug', 'categories.category_name', 'max_archive_settings.max_archive')
        ->join('max_archive_settings', 'max_archive_settings.category_id', '=', 'categories.category_id')
        ->get();

        // Iterate over the result to process each category
        foreach ($result as $key => $value) {
            // Remove single quotes from the slug
            $value->slug = str_replace("'", '', $value->slug);

            // Count the total news for the current slug
            $count_total_news = DB::table('news_msts')->where('page', $value->slug)->count();

            // Calculate available for archive
            $value->available_for_archive = $count_total_news - $value->max_archive;
        }

        // Return the result or false if empty
        return $result->isNotEmpty() ? $result : false;
    }
}

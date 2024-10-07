<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Entities\CategoryTopic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Modules\Category\DataTables\CategoryDataTable;
use App\Models\HomePagePosition;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:read_category')->only('index');
        $this->middleware('permission:create_category')->only(['create', 'store']);
        $this->middleware('permission:update_category')->only(['edit', 'update']);
        $this->middleware('permission:delete_category')->only('destroy');

        $this->middleware('demo')->only(['saveCategoryImgStatus','update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('category::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = Category::where('category_type', 2)->get();
        return view('category::create', compact('categories'));
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
            'category_name' => 'required',
            'category_type' => 'required',
            'slug' => 'required',
            'category_image' => 'file|mimes:gif,jpg,jpeg,png|max:1024', // 1024 KB
        ]);

        // check that category is  empty or not
        $slug = $request->slug;
        if ($request->slug == '' || empty($request->slug)) {
            $space_exist = preg_match('/\s/', $request->category_name);
            if ($space_exist > 0) {
                $slug = str_replace(' ', '-', $request->category_name);
            }
        } else {
            // Checking that slug is formatted or not
            $space_exist = preg_match('/\s/', $request->slug);
            if ($space_exist > 0) {
                $slug = str_replace(' ', '-', $request->slug);
            }
        }

        // making query to check category is exist or not
        if ($slug != '') {
            $check_data_exist = $this->check_category_existence($slug);
            // if it is exist already
            if ($check_data_exist) {
                // You can customize the error message based on the type of exception
                return response()->json(['error' => true, 'msg' => 'Category already exists !']);
            }
        }

        if ($request->hasFile('category_image')) {
            $request_file = $request->file('category_image');
            $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
            $path = $request_file->storeAs('category', $filename, 'public');
        }

        try {

            $category = Category::create([
                'category_name'    => $request->category_name,
                'category_type'    => $request->category_type,
                'slug'             => $slug,
                'description'      => $request->description,
                'category_imgae'   => $path
            ]);

            if($category){
                $topics = $request->category_topic;
                if(!empty($topics)){
                    // Delete existing records by cat_slug
                    CategoryTopic::where('cat_slug', $slug)->delete();

                    // Insert new records
                    foreach ($topics as $topic) {
                        CategoryTopic::create([
                            'cat_slug' => $slug,
                            'topic' => $topic
                        ]);
                    }
                }
            }

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
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Category $category)
    {
        $categories = Category::where('category_type', 2)->get();
        $category = Category::findOrFail($category->id);

        // Use query builder to join the tables and get the results
        $topics = DB::table('category_topics')
                ->join('categories', 'categories.slug', '=', 'category_topics.topic')
                ->select('category_topics.topic')
                ->where('category_topics.cat_slug', $category->slug)
                ->where('category_topics.deleted_at', Null)
                ->pluck('category_topics.topic')
                ->toArray();

        return view('category::edit', compact('categories','category', 'topics'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {

        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => 'required',
            'category_type' => 'required',
            'slug' => 'required',
            'category_image' => 'file|mimes:gif,jpg,jpeg,png|max:1024', // 1024 KB
        ]);

        // check that category is  empty or not
        $slug = $request->slug;
        if ($request->slug == '' || empty($request->slug)) {
            $space_exist = preg_match('/\s/', $request->category_name);
            if ($space_exist > 0) {
                $slug = str_replace(' ', '-', $request->category_name);
            }
        } else {
            // Checking that slug is formatted or not
            $space_exist = preg_match('/\s/', $request->slug);
            if ($space_exist > 0) {
                $slug = str_replace(' ', '-', $request->slug);
            }
        }

        // making query to check category is exist or not
        if ($slug != '' && $slug != $category->slug) {
            $check_data_exist = $this->check_category_existence($slug);
            // if it is exist already
            if ($check_data_exist) {
                // You can customize the error message based on the type of exception
                return response()->json(['error' => true, 'msg' => 'Category already exists !']);
            }
        }

        $path =  $category->category_imgae;

        if ($request->hasFile('category_image')) {
             // Delete previous signature if it exists
             Storage::delete('public/' . $category->category_imgae);

            $request_file = $request->file('category_image');
            $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
            $path = $request_file->storeAs('category', $filename, 'public');
        }

        try {

            $category_up = $category->update([
                'category_name'    => $request->category_name,
                'category_type'    => $request->category_type,
                'slug'             => $slug,
                'description'      => $request->description,
                'category_imgae'   => $path
            ]);

            if($category_up){
                $topics = $request->category_topic;
                if(!empty($topics)){
                    // Delete existing records by cat_slug
                    CategoryTopic::where('cat_slug', $slug)->delete();

                    // Insert new records
                    foreach ($topics as $topic) {
                        CategoryTopic::create([
                            'cat_slug' => $slug,
                            'topic' => $topic
                        ]);
                    }
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

    public function check_category_existence($slug){
        return Category::where('slug', $slug)->exists();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Category $category)
    {
        if ($category->category_imgae) {
            Storage::delete('public/' . $category->category_imgae);
        }

        HomePagePosition::where('category_id', $category->id)->delete();
        Category::where('id', $category->id)->delete();

        return response()->json(['success' => 'success']);
    }

    /**
     * Update the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function saveCategoryImgStatus(Category $category)
    {
        $status = ($category->img_status==1?'0':'1');

        try {

            $category_up = $category->update([
                'img_status'    => $status
            ]);

            // If the creation was successful, redirect with success message
            return response()->json(['success' => 'success']);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., validation error, database error), handle it here
            return response()->json(['fail' => 'fail']);
        }
    }

}

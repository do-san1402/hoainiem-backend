<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Api\CommonApis;
use App\Models\Api\NewsMst;
use App\Traits\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Setting\Entities\Application;

class ApiController extends Controller
{
    use Common;

    /*
    |---------------------------------------------------
    |        GET Web Setting
    |---------------------------------------------------
     */
    public function webSetting()
    {

        $settings = DB::table('app_settings')->first();

        $data['default_meta'] = CommonApis::settingData(5);
        $data['social_link']  = CommonApis::settingData(111);
        $data['contact']      = CommonApis::settingData(113);

        $data['website_title'] = $settings->website_title;
        $data['footer_text']   = $settings->footer_text;
        $data['copy_right']    = $settings->copy_right;
        $data['time_zone']     = $settings->time_zone;
        $data['ltl_rtl']       = $settings->ltl_rtl;
        $data['logo']          = app_setting()->logo;
        $data['footer_logo']   = app_setting()->footer_logo;
        $data['favicon']       = app_setting()->favicon;

        return sendSuccessResponse('Web Setting', $data, 200);

    }

    /*
    |---------------------------------------------------
    |        GET All Categories
    |---------------------------------------------------
     */
    public function categoryList()
    {

        $main_cat = [];

        $main = DB::table('menu_contents')
            ->select('menu_contents.menu_level', 'menu_contents.slug', 'menu_contents.id')
            ->join('menus', 'menus.id', '=', 'menu_contents.menu_id')
            ->leftJoin('categories', 'categories.slug', '=', 'menu_contents.slug')
            ->where('menus.position', 1)
            ->orderBy('menu_contents.menu_position', 'ASC')
            ->get();

        foreach ($main as $row) {

            $row->menu_lavel      = $row->menu_level;
            $row->menu_content_id = $row->id;

            $row       = (array) $row;
            $id        = $row["id"];
            $num_rows1 = DB::table('menu_contents')->select('menu_level', 'slug', 'id')
                ->where('parent_id', $id)
                ->orderBy('menu_contents.menu_position', 'ASC')
                ->get();
            $sub_cat1 = [];

            foreach ($num_rows1 as $key => $rows) {

                $rows->menu_lavel      = $rows->menu_level;
                $rows->menu_content_id = $rows->id;

                // Unset the properties
                unset($rows->id); // Eliminating this to form data as old API
                unset($rows->menu_level); // Eliminating this to form data as old API

                array_push($sub_cat1, $rows);
            }

            $row['categorieslevelone'] = $sub_cat1;

            unset($row['id']); // Eliminating this to form data as old API
            unset($row['menu_level']); // Eliminating this to form data as old API

            array_push($main_cat, $row);
        }

        return sendSuccessResponse('Category List', $main_cat, 200);
    }

    /*
    |---------------------------------------------------
    |        Sidebar All Categories
    |---------------------------------------------------
     */
    public function sidebarCategories()
    {

        $main_cat = [];

        $main = DB::table('menu_contents')
            ->select('menu_contents.menu_level', 'menu_contents.slug', 'menu_contents.id')
            ->join('menus', 'menus.id', '=', 'menu_contents.menu_id')
            ->leftJoin('categories', 'categories.slug', '=', 'menu_contents.slug')
            ->where('menus.position', 2)
            ->orderBy('menu_contents.menu_position', 'ASC')
            ->get();

        foreach ($main as $row) {

            $row->menu_lavel      = $row->menu_level;
            $row->menu_content_id = $row->id;

            $row       = (array) $row;
            $id        = $row["id"];
            $num_rows1 = DB::table('menu_contents')->select('menu_level', 'slug', 'id')
                ->where('parent_id', $id)
                ->orderBy('menu_contents.menu_position', 'ASC')
                ->get();
            $sub_cat1 = [];

            foreach ($num_rows1 as $rows) {

                $rows->menu_lavel      = $rows->menu_level;
                $rows->menu_content_id = $rows->id;

                // Unset the properties
                unset($rows->id); // Eliminating this to form data as old API
                unset($rows->menu_level); // Eliminating this to form data as old API

                array_push($sub_cat1, $rows);
            }

            $row['categorieslevelone'] = $sub_cat1;

            unset($row['id']); // Eliminating this to form data as old API
            unset($row['menu_level']); // Eliminating this to form data as old API

            array_push($main_cat, $row);
        }

        return sendSuccessResponse('Sidebar Category List', $main_cat, 200);

    }

    /*
    |---------------------------------------------------
    |        GET Home Page Data
    |---------------------------------------------------
     */
    public function homeData()
    {
        $data = NewsMst::home_data();
        return sendSuccessResponse('Home page data List', $data, 200);
    }

    /*
    |---------------------------------------------------
    |        Return latest post
    |---------------------------------------------------
     */
    public function latestPost()
    {
        $data = CommonApis::latestPost(20);
        return sendSuccessResponse('Latest post List', $data, 200);
    }

    /*
    |---------------------------------------------------
    |        Return popular post
    |---------------------------------------------------
     */
    public function popularPost()
    {
        $data = CommonApis::popularPost();
        return sendSuccessResponse('Popular Post List', $data, 200);
    }

    /*
    |---------------------------------------------------
    |    Return User post
    |---------------------------------------------------
     */
    public function userPost(Request $request)
    {

        $limit       = $request->limit ?? 12;
        $page_number = $request->page_number ?? 0;
        $offset      = $page_number * $limit;

        $request['limit']  = $request->limit ?? 12;
        $request['offset'] = $offset;
        $request['id']     = $request->id;

        $newses = NewsMst::userPost($request);

        if ($newses) {
            return sendSuccessResponse('user post', $newses, 200);
        } else {
            return sendErrorResponse('Not data found', [], 404);
        }

    }

    /*
    |---------------------------------------------------
    |    Get Social Link
    |---------------------------------------------------
     */
    public function socialLink()
    {

        $meta_setting = DB::table('settings')->where('id', 111)->first();
        $data         = json_decode($meta_setting->details);
        return sendSuccessResponse('Web Setting', $data, 200);

    }

    /*
    |---------------------------------------------------
    |    Get divisions
    |---------------------------------------------------
     */
    public function divisions()
    {
        $divisions = CommonApis::divisions();
        return sendSuccessResponse('Divission List', $divisions, 200);
    }

    /*
    |---------------------------------------------------
    |    Get districts
    |---------------------------------------------------
     */
    public function districts($id)
    {
        $districts = CommonApis::districts($id);
        return sendSuccessResponse('Districts', $districts, 200);
    }

    /*
    |---------------------------------------------------
    |    Get upazilas
    |---------------------------------------------------
     */
    public function upazilas($id)
    {
        $upazilas = CommonApis::upazilas($id);
        return sendSuccessResponse('Web Setting', $upazilas, 200);
    }

    /*
    |---------------------------------------------------
    |    Return search post
    |---------------------------------------------------
     */
    public function postSearch(Request $request)
    {

        $limit              = $request->limit ?? 12;
        $page_number        = $request->page_number ?? 0;
        $offset             = $page_number * $limit;
        $request['limit']   = $request->limit ?? 12;
        $request['offset']  = $offset;
        $request['keyword'] = $request->keyword;

        $newses = NewsMst::archivePost($request);

        return sendSuccessResponse('Search Post', $newses, 200);

    }

    /*
    |---------------------------------------------------
    |    Get photo posts
    |---------------------------------------------------
     */
    public function photoPosts(Request $request)
    {

        $limit       = $request->limit ?? 12;
        $page_number = $request->page_number ?? 0;
        $offset      = $page_number * $limit;

        $request['limit']    = $request->limit ?? 12;
        $request['offset']   = $offset;
        $request['category'] = $request->category;

        if ($request->post_id != '') {
            $newses                 = NewsMst::detailsPhotoPost($request);
            $request['category']    = $newses['category'] ?? null;
            $newses['related_post'] = NewsMst::photoPost($request);
            $newses['categories']   = NewsMst::photoCategory();
        } elseif ($request->category != '') {
            $newses               = NewsMst::photoCategoryPost($request);
            $newses['categories'] = NewsMst::photoCategory();

        } else {
            $newses = NewsMst::photoPost($request);
        }

        $newses['ads'] = NewsMst::ads(3);

        if ($newses) {
            return sendSuccessResponse('photo post', $newses, 200);
        } else {
            return sendErrorResponse('Not data found', [], 404);
        }

    }

    /*
    |---------------------------------------------------
    |    Get photo home posts
    |---------------------------------------------------
     */
    public function photoHomePosts(Request $request)
    {

        $limit       = $request->limit ?? 12;
        $page_number = $request->page_number ?? 0;
        $offset      = $page_number * $limit;

        $request['limit']    = $limit;
        $request['offset']   = $offset;
        $request['category'] = $request->category;

        $newses               = NewsMst::photoHomePosts($request);
        $newses['categories'] = NewsMst::photoCategory();
        $newses['mix_post']   = NewsMst::photoPost($request);
        $newses['ads']        = NewsMst::ads(3);

        if ($newses) {
            return sendSuccessResponse('photo post', $newses, 200);
        } else {
            return sendErrorResponse('Not data found', [], 404);
        }

    }

    /*
    |---------------------------------------------------
    |    Return  News info by news id
    |---------------------------------------------------
     */
    public function newsDetails(Request $request, $encode_title)
    {

        $post = NewsMst::newsDetails($encode_title);

        if ($post) {
            return sendSuccessResponse('Post details', $post, 200);
        } else {
            return sendErrorResponse('Not data found', [], 404);
        }

    }

    /*
    |---------------------------------------------------
    |        Return Category post
    |---------------------------------------------------
     */
    public function categoryPost(Request $request, $slug)
    {

        $limit       = $request->limit ?? 12;
        $page_number = $request->page_number ?? 0;
        $offset      = $page_number * $limit;

        $data                = [];
        $data['posts_count'] = NewsMst::categoryPostDataCount($slug);
        $data['posts']       = NewsMst::categoryPostData($slug, $limit, $offset);
        $data['topics']      = CommonApis::topicList($slug);
        $data['add']         = NewsMst::ads(2);

        return sendSuccessResponse('Category page data List', $data, 200);
    }

    /*
    |---------------------------------------------------
    |        Retrun  News info by news id
    |---------------------------------------------------
     */
    public function pageLink()
    {

        $page = DB::table('menu_contents')->select('menu_contents.menu_level as menu_lavel', 'menu_contents.slug', 'menu_contents.link_url')
            ->where('content_type', 'pages')
            ->where('status', 1)
            ->orderBy('menu_contents.menu_position', 'ASC')
            ->get();
        return sendSuccessResponse('Page Link', $page, 200);

    }

    public function pageData($slug)
    {

        $page_result = DB::table('pages')->where('page_slug', $slug)->first();

        $PAGE_DATA = '';

        if (@$page_result->title != null) {

            $pn['page_id']         = @$page_result->page_id;
            $pn['title']           = @$page_result->title;
            $pn['page_slug']       = @$page_result->page_slug;
            $pn['description']     = @$page_result->description;
            $pn['image_id']        = asset('storage/' . $page_result->image_id);
            $pn['seo_keyword']     = @$page_result->seo_keyword;
            $pn['seo_description'] = @$page_result->seo_description;
            $pn['video_url']       = @$page_result->video_url;
            $pn['publish_date']    = @$page_result->publish_date;
            $PAGE_DATA             = (object) $pn;
            return sendSuccessResponse('Page Link', $PAGE_DATA, 200);
        } else {
            return sendErrorResponse('No data found', '', 404);
        }

    }

    public function contactUs()
    {

        $page_result = CommonApis::settingData(113);

        if (@$page_result) {
            $data = $page_result;
            return sendSuccessResponse('Page Link', $data, 200);
        } else {
            return sendErrorResponse('No data found', '', 404);
        }

    }

    /*
    |---------------------------------------------------
    |        GET tag  Data
    |---------------------------------------------------
     */
    public function tagPost(Request $request, $tag)
    {
        $news_ids    = DB::table('post_tags')->where('tag', $tag)->groupBy('news_id')->pluck('news_id')->toArray();
        $limit       = $request->limit ?? 12;
        $page_number = $request->page_number ?? 0;
        $offset      = $page_number * $limit;
        $data        = NewsMst::tagPost($news_ids, $limit, $offset);
        return sendSuccessResponse('Tag page data List', $data, 200);
    }

    public function trendingPost()
    {
        $data = CommonApis::latestPost(6);
        return sendSuccessResponse('Trending Post List', $data, 200);
    }

    /*
    |---------------------------------------------------
    |        GET tag  Data
    |---------------------------------------------------
     */
    public function topicPost(Request $request, $topic)
    {

        $limit       = $request->limit ?? 12;
        $page_number = $request->page_number ?? 0;
        $offset      = $page_number * $limit;

        $data['profile'] = CommonApis::topicProfile($topic);
        $data['posts']   = NewsMst::categoryPostData($topic, $limit, $offset);

        return sendSuccessResponse('Topic post list', $data, 200);
    }

    public function archivePosts(Request $request)
    {

        $limit                    = $request->limit ?? 12;
        $page_number              = $request->page_number ?? 0;
        $offset                   = $page_number * $limit;
        $request['limit']         = $request->limit ?? 12;
        $request['offset']        = $offset;
        $request['category_slug'] = $request->category_slug;
        $request['from_date']     = $request->from_date;
        $request['to_date']       = $request->to_date;

        $newses = NewsMst::archivePost($request);

        if ($newses) {
            return sendSuccessResponse('archive post', $newses, 200);
        } else {
            return sendErrorResponse('Not data found', [], 404);
        }

    }

    public function ourTeam()
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $departments = DB::table('departments')->select('department_name', 'id')->get();

        if (@$departments) {
            $data = [];

            foreach ($departments as $key1 => $val1) {

                $teamps = DB::table('reporters')->select('user_id as id', 'name', 'mobile', 'email', 'photo', 'designation')->where('department_id', $val1->id)->get();

                $team = [];

                foreach ($teamps as $key => $val) {
                    $team[$key]['id']          = $val->id;
                    $team[$key]['name']        = $val->name;
                    $team[$key]['mobile']      = $val->mobile;
                    $team[$key]['email']       = $val->email;
                    $team[$key]['photo']       = $val->photo ? asset('storage/' . $val->photo) : asset($difimg->img);
                    $team[$key]['designation'] = @$val->designation;
                }

                $team1['member'] = $team;
                $data[]          = array_merge((array) $val1, $team1);
            }

            return sendSuccessResponse('Our Team', $data, 200);
        } else {
            return sendErrorResponse('No data found', '', 404);
        }

    }

    /*
    |---------------------------------------------------
    |    GET site map xml category
    |---------------------------------------------------
     */
    public static function sitemapXmlCategory()
    {
        @$categories = DB::table('categories')->select('category_name', 'slug')->get();

        if ($categories) {
            return sendSuccessResponse('photo post', $categories, 200);
        } else {
            return sendErrorResponse('Not data found', [], 404);
        }

    }

    /*
    |---------------------------------------------------
    |    GET site map xml
    |---------------------------------------------------
     */
    public static function sitemapXml(Request $request)
    {
        $page     = $request->page;
        $category = $request->category;
        @$news    = '';

        if ($category != '') {
            @$news = DB::table('news_msts')
                ->select('encode_title', 'page as slug', 'time_stamp', 'last_update')
                ->where('page', $request->category)
                ->orderBy('id', 'DESC')->limit(100)->get();
        }

        if ($page != '') {
            @$news = DB::table('news_msts')
                ->select('encode_title', 'page as slug', 'time_stamp', 'last_update')
                ->where('page', $request->category)
                ->orderBy('id', 'DESC')->limit(100)->get();
        }

        return sendSuccessResponse('photo post', $news, 200);

    }

    /*
    |---------------------------------------------------
    |    GET meta all data
    |---------------------------------------------------
     */
    public static function metaAllData(Request $request)
    {
        $application = Application::first();

        if (@$request->encode_title != '') {

            $newses = DB::table('news_msts')
                ->select('news_msts.*',
                    'users.id as user_id', 'users.full_name as name',
                    'r.full_name as reporter_name',
                    'categories.category_name',
                    'post_seo_onpages.meta_keyword', 'post_seo_onpages.meta_description'
                )
                ->leftJoin('users', 'users.id', '=', 'news_msts.post_by')
                ->leftJoin('users as r', 'r.id', '=', 'news_msts.reporter_id')
                ->leftJoin('categories', 'categories.slug', '=', 'news_msts.page')
                ->leftJoin('post_seo_onpages', 'post_seo_onpages.news_id', '=', 'news_msts.news_id')
                ->where('news_msts.encode_title', $request->encode_title)
                ->first();

            $json = (object) [];

            if ($newses) {
                $dis = Str::words($newses->news, '25');

                $json = (object) [
                    'title'            => $newses->title,
                    'meta_keyword'     => $newses->meta_keyword ? $newses->meta_keyword : '',
                    'meta_description' => $newses->meta_description ? $newses->meta_description : strip_tags($dis),
                    'encode_title'     => $newses->encode_title,
                    'image'            => $newses->image ? asset('storage/images/large/' . $newses->image) : null,
                    'favicon'          => $application->favicon ? asset('storage/' . $application->favicon) : '',
                    'news'             => $newses->news,
                    'video'            => $newses->videos,
                    'site_name'        => $application->title,
                    'width'            => '1200',
                    'height'           => '630',
                ];

            }

        } else {

            $defaultmeta = CommonApis::settingData(5);

            $json = (object) [
                'title'            => $defaultmeta->title ? $defaultmeta->title : '',
                'image'            => $defaultmeta->default_image ? asset('storage/' . $defaultmeta->default_image) : '',
                'favicon'          => $application->favicon ? asset('storage/' . $application->favicon) : '',
                'meta_keyword'     => $defaultmeta->meta_tag ? $defaultmeta->meta_tag : '',
                'meta_description' => $defaultmeta->meta_description ? $defaultmeta->meta_description : '',
                'google_analytics' => $defaultmeta->google_analytics ? $defaultmeta->google_analytics : '',
                'site_name'        => $application->title,
                'width'            => '1200',
                'height'           => '630',
            ];
        }

        return sendSuccessResponse('metadata', $json, 200);

    }

}

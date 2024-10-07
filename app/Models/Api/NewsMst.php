<?php

namespace App\Models\Api;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NewsMst extends Model
{
    use HasFactory;

#------------------------------------------------

# gatting home data
    #------------------------------------------------
    public static function home_data($page = 'home')
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $result = DB::table('news_positions as t2')->select('t1.news_id', 't1.encode_title', 't1.post_date', 't1.time_stamp',
            't1.page', 't1.stitle', 't1.title', 't1.image', 't1.news', 't1.reference', 't1.ref_date', 't1.publish_date', 't1.post_by', 't1.reporter', 't1.status', 't1.videos', 't1.podcust_id', 't1.image_alt', 't1.image_base_url', 't3.id', 't3.full_name as name', 't3.profile_image as photo', 't4.category_name')

            ->leftJoin('news_msts as t1', 't1.news_id', '=', 't2.news_id')
            ->leftJoin('users as t3', 't3.id', '=', 't1.post_by')
            ->Join('categories as t4', 't4.slug', '=', 't1.page')
            ->where('t1.publish_date', '<=', date("Y-m-d"))
            ->where('t2.page', $page)
            ->where('t1.status', 0)
            ->limit(12)
            ->orderBy('t2.position', 'ASC')
            ->orderBy('t2.news_id', 'DESC')
            ->get();

        $HN = [];
        $PP = [];

        foreach ($result as $key => $val) {

            $snews = \Str::words($val->news, '25');

            $imgurl = ($val->image_base_url ? $val->image_base_url : asset('storage') . '/');

            $HN['default_img']   = asset($difimg->img);
            $HN['category_name'] = $val->category_name;
            $HN['category']      = $val->page;
            $HN['image_title']   = null;
            $HN['image_alt']     = $val->image_alt;
            $HN['news_id']       = $val->news_id;
            $HN['post_by_image'] = ($val->photo != '' ? asset('storage/' . $val->photo) : asset($difimg->img));
            $HN['post_by_name']  = $val->name;
            $HN['post_by_id']    = $val->id;
            $HN['post_date']     = Carbon::parse($val->time_stamp)->diffForhumans();
            $HN['post_title']    = $val->title;
            $HN['encode_titl']   = $val->encode_title;
            $HN['stitle']        = strip_tags(html_entity_decode($snews));
            $HN['video']         = $val->videos;
            $HN['image_check']   = $val->image;
            $HN['image_thumb']   = $imgurl . 'images/thumb/' . $val->image;
            $HN['image_large']   = $imgurl . 'images/large/' . $val->image;
            $PP[$key]            = (object) $HN;
        }

        $home_page_position = self::home_category_position_data();
        $top_braking        = self::topBreakingPost();

        return [
            'top_braking'    => $top_braking,
            'topNews'        => $PP,
            'newsByCategory' => $home_page_position,
            'ads'            => self::ads(1),
        ];

    }

    public static function ads($page)
    {

        $ads = DB::table('ad_s')->select()->where('page', $page)->whereNull('deleted_at')->get();

        $adv = [];

        if ($ads) {

            foreach ($ads as $key => $value) {

                if ($value->page == 1) {
                    $page = 'home';
                } elseif ($value->page == 2) {
                    $page = 'category';
                } elseif ($value->page == 3) {
                    $page = 'news_view';
                }

                $adv[$page . '_' . $value->ad_position] = $value->embed_code;
            }

            return $adv;
        } else {
            return $adv;
        }

    }

    public static function topBreakingPost()
    {
        $data = DB::table('top_breakings')->where('status', 1)->first();
        $post = [];

        if ($data) {
            $post['title']            = $data->title;
            $post['background_color'] = $data->background_color;
            $post['post']             = self::categoryPostData($data->category_slug, 6, 0);
        } else {
            $post;
        }

        return $post;
    }

    public static function home_category_position_data()
    {
        $home_page_position = self::add_home_category_position_data();
        $data               = [];

        foreach ($home_page_position as $key => $val) {

            $catdata['post']           = self::categoryPostData($val->slug, 8, 0);
            $position['position']      = $key;
            $position['category_name'] = $val->cat_name;
            $position['slug']          = $val->slug;
            $position['category_id']   = $val->category_id;
            $position['status']        = $val->status;
            $data[]                    = array_merge($position, $catdata);
        }

        return $data;
    }

    public static function add_home_category_position_data()
    {
        $homePagePositions = DB::table('home_page_positions')->get();

        if ($homePagePositions != false) {
            return $homePagePositions;
        } else {
            return '';
        }

    }

    public static function categoryPostData($page, $limit, $offset)
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $result = DB::table('news_positions as t2')->select('t1.news_id', 't1.encode_title', 't1.time_stamp',
            't1.page', 't1.stitle', 't1.title', 't1.image', 't1.news', 't1.reference',
            't1.ref_date', 't1.publish_date', 't1.post_date', 't1.post_by', 't1.reporter',
            't1.videos', 't1.podcust_id', 't1.image_alt',
            't1.image_base_url', 't3.id', 'reporters.name', 'reporters.photo', 't4.category_name')
            ->leftJoin('news_msts as t1', 't1.news_id', '=', 't2.news_id')
            ->leftJoin('users as t3', 't3.id', '=', 't1.post_by')
            ->leftJoin('reporters', 'reporters.id', '=', 't1.reporter_id')
            ->leftJoin('categories as t4', 't4.slug', '=', 't1.page')
            ->where('t1.publish_date', '<=', date("Y-m-d"))
            ->where('t2.page', $page)
            ->where('t2.status', '1')
            ->orderBy('t2.position', 'ASC')
            ->orderBy('t2.news_id', 'DESC')
            ->offset($offset)->limit($limit)
            ->get();

        $PP = [];
        $PN = [];

        foreach ($result as $key => $data) {

            $imgurl = ($data->image_base_url ? $data->image_base_url : asset('storage') . '/');

            $snews = \Str::words($data->news, 25);

            $PN['default_img']   = asset($difimg->img);
            $PN['category_name'] = $data->category_name;
            $PN['category']      = $data->page;
            $PN['image_title']   = null;
            $PN['image_alt']     = $data->image_alt;
            $PN['news_id']       = $data->news_id;
            $PN['post_by_image'] = ($data->photo != '' ? asset('storage/' . $data->photo) : asset($difimg->img));
            $PN['post_by_name']  = $data->name;
            $PN['post_by_id']    = $data->id;
            $PN['post_date']     = Carbon::parse($data->time_stamp)->diffForhumans();
            $PN['time_stamp']    = $data->time_stamp;
            $PN['post_title']    = $data->title;
            $PN['encode_titl']   = $data->encode_title;
            $PN['stitle']        = strip_tags(html_entity_decode($snews));
            $PN['video']         = $data->videos;
            $PN['image_check']   = $data->image;
            $PN['image_thumb']   = $imgurl . 'images/thumb/' . $data->image;
            $PN['image_large']   = $imgurl . 'images/large/' . $data->image;

            $PP[$key] = (object) $PN;

        }

        return $PP;

    }

    public static function categoryPostDataCount($page)
    {
        return DB::table('news_positions as t2')
            ->leftJoin('news_msts as t1', 't1.news_id', '=', 't2.news_id')
            ->leftJoin('users as t3', 't3.id', '=', 't1.post_by')
            ->leftJoin('categories as t4', 't4.slug', '=', 't1.page')
            ->where('t1.publish_date', '<=', date("Y-m-d"))
            ->where('t2.page', $page)
            ->where('t2.status', '1')
            ->count();

    }

    public static function newsDetails($encode_title)
    {

        $encode_title = urldecode($encode_title);

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $newses = DB::table('news_msts')
            ->select('news_msts.*',
                'users.id as user_id', 'users.full_name as name', 'users.profile_image as photo',
                'r.name as reporter_name', 'r.photo as rporter_photo',
                'categories.category_name',
                'post_seo_onpages.meta_keyword', 'post_seo_onpages.meta_description'
            )
            ->leftJoin('users', 'users.id', '=', 'news_msts.post_by')
            ->leftJoin('reporters as r', 'r.id', '=', 'news_msts.reporter_id')
            ->leftJoin('categories', 'categories.slug', '=', 'news_msts.page')
            ->leftJoin('post_seo_onpages', 'post_seo_onpages.news_id', '=', 'news_msts.news_id')
            ->where('news_msts.encode_title', $encode_title)
            ->first();

        $data = [];

        if ($newses) {

            $read_hit = $newses->reader_hit + 1;
            DB::table('news_msts')->where('id', $newses->id)->update(['reader_hit' => $read_hit]);

            $imgurl = ($newses->image_base_url ? $newses->image_base_url : asset('storage') . '/');

            if ($newses->reporter_name != '') {
                $reporter_photo = ($newses->rporter_photo != '' ? asset('storage/' . $newses->rporter_photo) : asset($difimg->img));
            } else {
                $reporter_photo = ($newses->photo != '' ? asset('storage/' . $newses->photo) : asset($difimg->img));
            }

            $json = (object) [
                'id'             => $newses->news_id,
                'stitle'         => $newses->stitle,
                'title'          => $newses->title,
                'encode_title'   => $newses->encode_title,
                'image_thumb'    => $imgurl . 'images/thumb/' . $newses->image,
                'image_large'    => $imgurl . 'images/large/' . $newses->image,
                'category_name'  => $newses->category_name,
                'category'       => $newses->page,
                'news'           => $newses->news,
                'video'          => $newses->videos,
                'reporter'       => $newses->reporter_name ?? $newses->name,
                'reporter_image' => $reporter_photo,
                'post_date'      => $newses->post_date,
                'time_stamp'     => $newses->time_stamp,
            ];

            // related post data
            $relatedPost['relatedPost'] = self::relatedPost($newses->page, 6, 0, $newses->news_id);
            //post tag data
            $tags['tags'] = DB::table('post_tags')->select('tag')->where('news_id', $newses->news_id)->get();
            $ads['ads']   = self::ads(3);
            // array merge
            $data = array_merge((array) $json, $relatedPost, $tags, $ads);
            return $data;
        } else {
            return $data;
        }

    }

    public static function relatedPost($page, $limit, $offset, $news_id)
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $result = DB::table('news_positions as t2')
            ->select('t1.news_id', 't1.encode_title', 't1.time_stamp',
                't1.page', 't1.stitle', 't1.title', 't1.image', 't1.news', 't1.reference',
                't1.ref_date', 't1.publish_date', 't1.post_date', 't1.post_by', 't1.reporter',
                't1.videos', 't1.podcust_id', 't1.image_alt',
                't1.image_base_url', 't4.category_name')
            ->leftJoin('news_msts as t1', 't1.news_id', '=', 't2.news_id')
            ->leftJoin('categories as t4', 't4.slug', '=', 't1.page')
            ->where('t1.publish_date', '<=', date("Y-m-d"))
            ->where('t2.page', $page)
            ->where('t2.status', '1')
            ->where('t2.news_id', '!=', $news_id)
            ->orderBy('t2.position', 'ASC')
            ->orderBy('t2.news_id', 'DESC')
            ->offset($offset)->limit($limit)
            ->get();

        $PP = [];
        $PN = [];

        foreach ($result as $key => $data) {

            $imgurl = ($data->image_base_url ? $data->image_base_url : asset('storage') . '/');

            $PN['default_img']   = asset($difimg->img);
            $PN['category_name'] = $data->category_name;
            $PN['category']      = $data->page;
            $PN['image_title']   = null;
            $PN['image_alt']     = $data->image_alt;
            $PN['news_id']       = $data->news_id;
            $PN['post_date']     = Carbon::parse($data->time_stamp)->diffForhumans();
            $PN['time_stamp']    = $data->time_stamp;
            $PN['post_title']    = $data->title;
            $PN['encode_titl']   = $data->encode_title;
            $PN['stitle']        = $data->stitle;
            $PN['image_check']   = $data->image;
            $PN['image_thumb']   = $imgurl . 'images/thumb/' . $data->image;
            $PN['image_large']   = $imgurl . 'images/large/' . $data->image;

            $PP[$key] = (object) $PN;

        }

        return $PP;

    }

    public static function tagPost($news_ids, $limit, $offset)
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $result = DB::table('news_msts as t1')
            ->select('t1.news_id', 't1.encode_title', 't1.time_stamp',
                't1.page', 't1.stitle', 't1.title', 't1.image', 't1.news', 't1.reference',
                't1.ref_date', 't1.publish_date', 't1.post_date', 't1.post_by', 't1.reporter',
                't1.videos', 't1.podcust_id', 't1.image_alt',
                't1.image_base_url',
                't3.id', 't3.full_name as name', 't3.profile_image as photo',
                't4.category_name')
            ->leftJoin('users as t3', 't3.id', '=', 't1.post_by')
            ->leftJoin('categories as t4', 't4.slug', '=', 't1.page')
            ->whereIn('t1.news_id', $news_ids)
            ->where('t1.publish_date', '<=', date("Y-m-d"))
            ->offset($offset)
            ->limit($limit)
            ->get();

        $PP = [];
        $PN = [];

        foreach ($result as $key => $data) {

            $imgurl = ($data->image_base_url ? $data->image_base_url : asset('storage') . '/');

            $PN['default_img']   = asset('storage/' . $difimg->img);
            $PN['category_name'] = $data->category_name;
            $PN['category']      = $data->page;
            $PN['image_title']   = null;
            $PN['image_alt']     = $data->image_alt;
            $PN['news_id']       = $data->news_id;
            $PN['post_by_image'] = ($data->photo != '' ? asset('storage/' . $data->photo) : asset($difimg->img));
            $PN['post_by_name']  = $data->name;
            $PN['post_by_id']    = $data->id;
            $PN['post_date']     = Carbon::parse($data->time_stamp)->diffForhumans();
            $PN['post_title']    = $data->title;
            $PN['encode_titl']   = $data->encode_title;
            $PN['stitle']        = $data->stitle;
            $PN['video']         = $data->videos;
            $PN['time_stamp']    = $data->time_stamp;
            $PN['image_check']   = $data->image;
            $PN['image_thumb']   = $imgurl . 'images/thumb/' . $data->image;
            $PN['image_large']   = $imgurl . 'images/large/' . $data->image;

            $PP[$key] = (object) $PN;

        }

        return $PP;

    }

    public static function userPost($request)
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $info = DB::table('users')->select('id', 'full_name as name', 'email', 'profile_image', 'user_type_id')->where('id', $request->id)->first();

        $reporter_info = null;

        if ($info->user_type_id == 2) {
            $reporter_info = DB::table('reporters')->select('user_id as id', 'name', 'mobile', 'email', 'photo', 'designation')->where('user_id', $info->id)->first();
        }

        $data = [];

        if ($info) {

            $infoval['name']        = $info->name;
            $infoval['mobile']      = null;
            $infoval['email']       = $info->email;
            $infoval['photo']       = $info->profile_image ? asset('storage/' . $info->profile_image) : asset($difimg->img);
            $infoval['designation'] = null;

            if ($reporter_info != null) {

                $infoval['name']        = $reporter_info->name;
                $infoval['mobile']      = $reporter_info->mobile;
                $infoval['email']       = $reporter_info->email;
                $infoval['photo']       = $reporter_info->photo ? asset('storage/' . $reporter_info->photo) : asset($difimg->img);
                $infoval['designation'] = $reporter_info->designation;

            }

            $newses = DB::table('news_msts')
                ->select('news_msts.*', 'users.id as user_id', 'users.full_name as name', 'photo_libraries.disk', 'photo_libraries.thumb_image', 'photo_libraries.large_image')
                ->leftJoin('users', 'users.id', '=', 'news_msts.post_by')
                ->leftJoin('photo_libraries', 'photo_libraries.actual_image_name', '=', 'news_msts.image')
                ->where('news_msts.post_by', $request->id)
                ->offset($request->offset)->limit($request->limit)
                ->get();
            $PP = [];
            $PN = [];

            foreach ($newses as $key => $data) {

                $thumbImage = $data->thumb_image;
                $largeImage = $data->large_image;

                if ($data->disk == 'local') {
                    $thumbImage = storage_asset_image($data->thumb_image);
                    $largeImage = storage_asset_image($data->large_image);
                }

                $PN['image_title']   = $data->image_title;
                $PN['image_alt']     = $data->image_alt;
                $PN['news_id']       = $data->news_id;
                $PN['post_by_image'] = $infoval['photo'];
                $PN['post_by_name']  = $data->name;
                $PN['post_by_id']    = $data->id;
                $PN['post_date']     = Carbon::parse($data->time_stamp)->diffForhumans();
                $PN['time_stamp']    = $data->time_stamp;
                $PN['post_title']    = $data->title;
                $PN['encode_titl']   = $data->encode_title;
                $PN['stitle']        = $data->stitle;
                $PN['video']         = $data->videos;
                $PN['image_check']   = $data->image;
                $PN['image_thumb']   = $thumbImage;
                $PN['image_large']   = $largeImage;

                $PP[$key] = (object) $PN;

            }

            // related post data
            $relatedPost['posts'] = $PP;
            $data                 = array_merge((array) $infoval, $relatedPost);
            return $data;
        } else {
            return $data;
        }

    }

    public static function archivePost($request)
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $query = DB::table('news_msts');
        $query->select('news_msts.*');
        $query->where('publish_date', '<=', date("Y-m-d"));
        $query->where('status', '0');
        $query->orderBy('news_id', 'DESC');

        if ($request->from_date && $request->to_date) {
            $query->where('publish_date', '>=', $request->from_date);
            $query->where('publish_date', '<=', $request->to_date);
        } elseif ($request->from_date) {
            $query->where('publish_date', '=', $request->from_date);
        }

        if ($request->category_slug) {
            $query->where('page', $request->category_slug);
        }

        if ($request->keyword) {
            $query->where('title', 'LIKE', '%' . $request->keyword . '%');
        }

        $query->offset($request->offset)->limit($request->limit);
        $result = $query->get();

        $PP = [];
        $PN = [];

        foreach ($result as $key => $data) {

            $PN['default_img'] = asset($difimg->img);
            $PN['image_title'] = null;
            $imgurl            = ($data->image_base_url ? $data->image_base_url : asset('storage') . '/');

            $PN['default_img']  = asset($difimg->img);
            $PN['image_title']  = null;
            $PN['image_alt']    = $data->image_alt;
            $PN['news_id']      = $data->news_id;
            $PN['category']     = $data->page;
            $PN['post_date']    = Carbon::parse($data->time_stamp)->diffForhumans();
            $PN['publish_date'] = $data->publish_date;
            $PN['time_stamp']   = $data->time_stamp;
            $PN['post_title']   = $data->title;
            $PN['encode_titl']  = $data->encode_title;
            $PN['stitle']       = $data->stitle;
            $PN['video']        = $data->videos;
            $PN['image_check']  = $data->image;
            $PN['image_thumb']  = $imgurl . 'images/thumb/' . $data->image;
            $PN['image_large']  = $imgurl . 'images/large/' . $data->image;

            $PP[$key] = (object) $PN;

        }

        return $PP;

    }

#------------------------------------------------

# gatting home data
    #------------------------------------------------
    public static function photoPost()
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $query = DB::table('photo_posts');
        $query->select('photo_posts.*', 'users.full_name as name', 'categories.category_name');
        $query->leftJoin('users', 'users.id', '=', 'photo_posts.post_by');
        $query->leftJoin('categories', 'categories.slug', '=', 'photo_posts.category');

        $query->offset(0)->limit(6);
        $query->orderBy('photo_posts.id', 'DESC');
        $result = $query->get();

        $HN = [];
        $PP = [];

        foreach ($result as $key => $val) {

            $HN['category_name'] = $val->category_name;
            $HN['category']      = $val->category;
            $HN['id']            = $val->id;
            $HN['post_by_image'] = asset($difimg->img);
            $HN['post_by_name']  = $val->name;
            $HN['post_by_id']    = $val->post_by;
            $HN['title']         = $val->title;
            $HN['timestamp']     = @$val->timestamp;

            $photo_posts = DB::table('photo_post_details')
                ->select('photo_post_details.*', 'photo_libraries.disk', 'photo_libraries.thumb_image', 'photo_libraries.large_image')
                ->leftJoin('photo_libraries', 'photo_libraries.actual_image_name', '=', 'photo_post_details.image')
                ->where('photo_post_details.post_id', $val->id)
                ->orderBy('photo_post_details.id', 'DESC')
                ->get();

            $photos = [];

            foreach ($photo_posts as $p => $photo) {
                $thumbImage = $photo->thumb_image;
                $largeImage = $photo->large_image;

                if ($photo->disk == 'local') {
                    $thumbImage = storage_asset_image($photo->thumb_image);
                    $largeImage = storage_asset_image($photo->large_image);
                }

                $photos['photos'][$p]['thumb_photo']     = $thumbImage;
                $photos['photos'][$p]['large_photo']     = $largeImage;
                $photos['photos'][$p]['phot_title']      = $photo->title;
                $photos['photos'][$p]['photo_reference'] = @$photo->photo_reference;
            }

            // $photos['photos'] =$photos;
            $PP['posts'][$key] = array_merge($HN, $photos);
        }

        return $PP;

    }

    public static function photoHomePosts()
    {

        $categories = DB::table('photo_posts')
            ->select('photo_posts.id', 'categories.category_name', 'categories.slug')
            ->leftJoin('categories', 'categories.slug', '=', 'photo_posts.category')
            ->groupBy('photo_posts.category')
            ->orderBy('photo_posts.id', 'DESC')
            ->limit(5)->get();

        $data = [];

        foreach ($categories as $key => $val) {

            $request['category'] = $val->slug;
            $request['offset']   = 0;
            $request['limit']    = 8;

            $category['category_name'] = $val->category_name;
            $category['slug']          = $val->slug;

            $catdata            = self::photoCategoryPost((object) $request);
            $data['category'][] = array_merge($category, $catdata);

        }

        return $data;
    }

    public static function photoCategory()
    {

        $categories = DB::table('photo_posts')
            ->select('photo_posts.id', 'categories.category_name', 'categories.slug')
            ->leftJoin('categories', 'categories.slug', '=', 'photo_posts.category')
            ->groupBy('photo_posts.category')
            ->orderBy('photo_posts.id', 'DESC')
            ->limit(5)->get();

        $category = [];

        foreach ($categories as $key => $val) {
            $category[$key]['category_name'] = $val->category_name;
            $category[$key]['slug']          = $val->slug;
        }

        return $category;

    }

    public static function photoCategoryPost($request)
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $query = DB::table('photo_posts');
        $query->select('photo_posts.*', 'users.full_name as name', 'categories.category_name');
        $query->leftJoin('users', 'users.id', '=', 'photo_posts.post_by');

        $query->leftJoin('categories', 'categories.slug', '=', 'photo_posts.category');

        if ($request->category != '') {
            $query->where('photo_posts.category', $request->category);
        }

        $query->offset($request->offset)->limit($request->limit);

        $query->orderBy('photo_posts.id', 'DESC');
        $result = $query->get();

        $HN = [];
        $PP = [];

        foreach ($result as $key => $val) {

            $HN['category_name'] = $val->category_name;
            $HN['category']      = $val->category;
            $HN['id']            = $val->id;
            $HN['post_by_image'] = asset($difimg->img);
            $HN['post_by_name']  = $val->name;
            $HN['post_by_id']    = $val->post_by;
            $HN['title']         = $val->title;
            $HN['timestamp']     = @$val->timestamp;

            $photo_posts = DB::table('photo_post_details')
                ->select('photo_post_details.*', 'photo_libraries.disk', 'photo_libraries.thumb_image', 'photo_libraries.large_image')
                ->leftJoin('photo_libraries', 'photo_libraries.actual_image_name', '=', 'photo_post_details.image')
                ->where('photo_post_details.post_id', $val->id)
                ->orderBy('photo_post_details.id', 'DESC')
                ->get();

            $photos = [];

            foreach ($photo_posts as $p => $photo) {
                $thumbImage = $photo->thumb_image;
                $largeImage = $photo->large_image;

                if ($photo->disk == 'local') {
                    $thumbImage = storage_asset_image($photo->thumb_image);
                    $largeImage = storage_asset_image($photo->large_image);
                }

                $imgurl                                  = ($photo->image_base_url ? $photo->image_base_url : asset('') . '/');
                $photos['photos'][$p]['thumb_photo']     = $thumbImage;
                $photos['photos'][$p]['large_photo']     = $largeImage;
                $photos['photos'][$p]['phot_title']      = $photo->title;
                $photos['photos'][$p]['photo_reference'] = @$photo->photo_reference;
            }

            // $photos['photos'] =$photos;
            $PP['posts'][$key] = array_merge($HN, $photos);
        }

        return $PP;
    }

    public static function detailsPhotoPost($request)
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $query = DB::table('photo_posts');
        $query->select('photo_posts.*', 'users.full_name as name', 'categories.category_name');
        $query->leftJoin('users', 'users.id', '=', 'photo_posts.post_by');
        $query->leftJoin('categories', 'categories.slug', '=', 'photo_posts.category');

        if ($request->post_id != '') {
            $query->where('photo_posts.id', $request->post_id);
        }

        $query->offset($request->offset)->limit($request->limit);
        $query->orderBy('photo_posts.id', 'DESC');
        $result = $query->first();
        $HN     = [];
        $PP     = [];

        if ($result) {

            $HN['category_name'] = $result->category_name;
            $HN['category']      = $result->category;
            $HN['id']            = $result->id;
            $HN['post_by_image'] = asset($difimg->img);
            $HN['post_by_name']  = $result->name;
            $HN['post_by_id']    = $result->post_by;
            $HN['title']         = $result->title;
            $HN['timestamp']     = @$result->timestamp;

            $photo_posts = DB::table('photo_post_details')
                ->select('photo_post_details.*', 'photo_libraries.disk', 'photo_libraries.thumb_image', 'photo_libraries.large_image')
                ->leftJoin('photo_libraries', 'photo_libraries.actual_image_name', '=', 'photo_post_details.image')
                ->where('photo_post_details.post_id', $result->id)
                ->orderBy('photo_post_details.id', 'DESC')
                ->get();

            $photos = [];

            foreach ($photo_posts as $p => $photo) {
                $thumbImage = $photo->thumb_image;
                $largeImage = $photo->large_image;

                if ($photo->disk == 'local') {
                    $thumbImage = storage_asset_image($photo->thumb_image);
                    $largeImage = storage_asset_image($photo->large_image);
                }

                $photos['photos'][$p]['thumb_photo']     = $thumbImage;
                $photos['photos'][$p]['large_photo']     = $largeImage;
                $photos['photos'][$p]['phot_title']      = $photo->title;
                $photos['photos'][$p]['photo_reference'] = @$photo->photo_reference;
            }

            // $photos['photos'] =$photos;
            $PP = array_merge($HN, $photos);
        }

        return $PP;

    }

}

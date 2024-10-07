<?php

namespace App\Models\Api;

use App\Traits\Common;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CommonApis extends Model
{
    use HasFactory, Common;

    public static function settingData($id)
    {
        $page_result = DB::table('settings')->where('id', $id)->first();
        return json_decode(@$page_result->details);
    }

#------------------------------------

#     getting latest news
    #------------------------------------
    public static function latestPost($limit)
    {
        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $LN = [];
        $PP = [];

        $result = DB::table('news_msts')->select('news_msts.news_id', 'news_msts.encode_title', 'news_msts.title', 'news_msts.stitle', 'news_msts.image', 'news_msts.videos', 'news_msts.page', 'news_msts.time_stamp', 'news_msts.post_date', 'news_msts.news', 'news_msts.post_by', 'news_msts.image_alt', 'news_msts.image_base_url', 'news_msts.podcust_id', 'users.id', 'users.profile_image as photo', 'users.full_name as name', 'users.id as user_id', 'categories.category_name')
            ->Join('users', 'users.id', '=', 'news_msts.post_by')
            ->Join('categories', 'categories.slug', '=', 'news_msts.page')
            ->where('news_msts.publish_date', '<=', date("Y-m-d"))
            ->where('news_msts.is_latest', 1)
            ->where('news_msts.status', 0)
            ->orderBy('news_msts.id', 'DESC')
            ->limit($limit)
            ->get();

        foreach ($result as $key => $val) {

            $imgurl = $val->image_base_url ? $val->image_base_url : asset('storage/') . '/';

            $LN['default_img']   = asset($difimg->img);
            $LN['category_name'] = $val->category_name;
            $LN['category']      = $val->page;
            $LN['image_title']   = null;
            $LN['image_alt']     = $val->image_alt;
            $LN['news_id']       = $val->news_id;
            $LN['post_by_image'] = ($val->photo != '' ? asset('storage/' . $val->photo) : asset($difimg->img));
            $LN['post_by_name']  = $val->name;
            $LN['post_by_id']    = $val->id;
            $LN['post_date']     = Carbon::parse($val->time_stamp)->diffForhumans();
            $LN['time_stamp']    = $val->time_stamp;
            $LN['post_title']    = $val->title;
            $LN['encode_titl']   = $val->encode_title;
            $LN['stitle']        = $val->stitle;
            $LN['video']         = $val->videos;
            $LN['image_check']   = $val->image;
            $LN['image_thumb']   = $imgurl . 'images/thumb/' . $val->image;
            $LN['image_large']   = $imgurl . 'images/large/' . $val->image;

            $PP[$key] = (object) $LN;

        }

        return $PP;
    }

#------------------------------------

#     getting most read newspaper
    #------------------------------------
    public static function popularPost()
    {
        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $LN = [];
        $PP = [];

        $result = DB::table('news_msts as t1')
            ->select('t1.news_id', 't1.encode_title', 't1.stitle', 't1.title', 't1.page', 't1.image', 't1.videos', 't1.reader_hit', 't1.time_stamp', 't1.image_title', 't1.image_alt', 't1.post_date', 't1.news', 't1.image_base_url', 't1.podcust_id', 't2.id', 't2.full_name as name', 't2.profile_image as photo', 't4.category_name', 't6.disk', 't6.thumb_image', 't6.large_image')
            ->Join('users as t2', 't2.id', '=', 't1.post_by')
            ->Join('categories as t4', 't4.slug', '=', 't1.page')
            ->leftJoin('photo_libraries as t6', 't6.actual_image_name', '=', 't1.image')
            ->orderBy('t1.reader_hit', 'DESC')
            ->limit(20)
            ->get();

        foreach ($result as $key => $val) {

            $thumbImage = $val->thumb_image;
            $largeImage = $val->large_image;

            if ($val->disk == 'local') {
                $thumbImage = storage_asset_image($val->thumb_image);
                $largeImage = storage_asset_image($val->large_image);
            }

            $LN['default_img']   = asset('') . '/';
            $LN['category_name'] = $val->category_name;
            $LN['category']      = $val->page;
            $LN['image_title']   = $val->image_title;
            $LN['image_alt']     = $val->image_alt;
            $LN['news_id']       = $val->news_id;
            $LN['post_by_image'] = $val->photo ? asset('storage/' . $val->photo) : asset($difimg->img);
            $LN['post_by_name']  = $val->name;
            $LN['post_by_id']    = $val->id;
            $LN['post_date']     = Carbon::parse($val->time_stamp)->diffForhumans();
            $LN['time_stamp']    = $val->time_stamp;
            $LN['post_title']    = $val->title;
            $LN['encode_titl']   = $val->encode_title;
            $LN['stitle']        = $val->stitle;
            $LN['video']         = $val->videos;
            $LN['image_check']   = $val->image;
            $LN['image_thumb']   = $thumbImage;
            $LN['image_large']   = $largeImage;

            $PP[$key] = (object) $LN;

        }

        return $PP;
    }

    public static function topicList($topic)
    {
        $topics = DB::table('category_topics')->select('category_topics.*', 'categories.category_name')
            ->join('categories', 'categories.slug', '=', 'category_topics.topic')
            ->where('cat_slug', $topic)->get();
        $PP = [];

        foreach ($topics as $key => $val) {
            $LN['topic_name'] = $val->category_name;
            $LN['slug']       = $val->topic;
            $PP[$key]         = (object) $LN;
        }

        return $PP;
    }

    public static function topicProfile($topic)
    {

        $dif    = DB::table('settings')->where('id', 118)->first();
        $difimg = json_decode($dif->details);

        $topicProfile = DB::table('category_topics')
            ->select('category_topics.cat_slug', 'categories.category_name', 'categories.slug', 'categories.category_imgae', 'categories.description')
            ->join('categories', 'categories.slug', '=', 'category_topics.topic')
            ->where('slug', $topic)->first();

        $data = '';

        if ($topicProfile) {

            $topics['category_name']  = $topicProfile->category_name ?? '';
            $topics['slug']           = $topicProfile->slug ?? '';
            $topics['category_imgae'] = ($topicProfile->category_imgae ? baseUrl() . 'storage/' . $topicProfile->category_imgae : baseUrl() . $difimg->img);
            $topics['description']    = $topicProfile->description ?? '';

            $related['related_topic'] = DB::table('category_topics')
                ->select('category_topics.id', 'categories.category_name', 'categories.slug')
                ->join('categories', 'categories.slug', '=', 'category_topics.topic')
                ->where('cat_slug', $topicProfile->cat_slug)->get();

            $data = array_merge($topics, $related);
        }

        return $data;

    }

    public static function divisions()
    {
        return $result = DB::table('divisions')->get();
    }

    public static function districts($id)
    {
        return $result = DB::table('districts')->where('division_id', $id)->get();
    }

    public static function upazilas($id)
    {
        return $result = DB::table('upazilas')->where('district_id', $id)->get();
    }

}

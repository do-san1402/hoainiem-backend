<?php

namespace Modules\News\Services;

use App\Models\BreakingNews;
use App\Models\NewsMst;
use App\Models\NewsPosition;
use App\Models\PostSeoOnpage;
use App\Models\PostTag;
use App\Models\SchemaPost;
use App\Services\XmlService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;
use Modules\Reporter\Entities\Reporter;

class NewsService
{
    /**
     * Filter Data
     *
     * @return array
     */
    public function filterData(): array
    {
        $categories = Category::get();

        return compact('categories');
    }

    /**
     * Form Data
     *
     * @return array
     */
    public function formData(): array
    {
        $categories          = Category::get();
        $reporters           = Reporter::where('status', 1)->get();
        $categoryPositions   = generate_positions(1, 13);
        $homeSliderPositions = generate_positions(1, 21);
        $auth_user           = auth()->user();

        return compact('categories', 'reporters', 'categoryPositions', 'homeSliderPositions', 'auth_user');
    }

    /**
     * Create News
     *
     * @param  array  $attributes
     * @return NewsMst
     * @throws Exception
     */
    public function create(array $attributes): NewsMst
    {
        try {
            DB::beginTransaction();

            $post_ap_status = 0;
            $auth_user      = auth()->user();

            if ($auth_user->post_ap_status != 0) {
                $post_ap_status = 1;
            } else {
                $post_ap_status = $attributes['status_confirmed'] ?? 0;
            }

            if ($post_ap_status == 1) {
                $sta = 0;
            } else {
                $sta = 1;
            }

            if ($post_ap_status == 1) {
                $st = 1;
            } else {
                $st = 0;
            }

            $generate_id = NewsMst::max('id') + 1;
            $other_page  = $attributes['other_page'];
            $title       = $attributes['head_line'] ?? null;

            $encode_title = str_replace(' ', '-', $attributes['custom_url'] ?? $attributes['head_line'] ?? null);

            $page                   = $other_page ?? 'home';
            $post_by                = $auth_user->id;
            $publish_date           = $attributes['publish_date'] ?? $attributes['ref_date'] ?? null;
            $other_position         = $attributes['other_position'] ?? 1;
            $confirm_dynamic_static = $attributes['confirm_dynamic_static'] ?? null;
            $breaking_confirmed     = $attributes['breaking_confirmed'] ?? null;
            $home_page              = $attributes['home_page'] ?? null;
            $total_news             = 14;
            $time_stamp             = time();

            $newsMstData = [
                'news_id'          => $generate_id,
                'encode_title'     => $encode_title,
                'seo_title'        => $attributes['seo_title'] ?? null,
                'stitle'           => $attributes['short_head'] ?? null,
                'title'            => $title,

                'news'             => $attributes['details_news'] ?? null,
                'image'            => $attributes['lib_file_selected'] ?? null,
                'image_base_url'   => null,
                'image_alt'        => $attributes['image_alt'] ?? null,
                'image_title'      => $attributes['image_title'] ?? null,

                'videos'           => $attributes['videos'] ?? null,
                'podcust_id'       => null,
                'page'             => $page,
                'reference'        => $attributes['reference'] ?? null,
                'ref_date'         => $attributes['ref_date'],
                'reporter_id'      => $attributes['reporter_id'] ?? $auth_user->reporter->id ?? null,

                'reporter'         => null,
                'post_by'          => $post_by,
                'update_by'        => null,
                'time_stamp'       => $time_stamp,
                'post_date'        => Carbon::now(),
                'publish_date'     => $publish_date,
                'last_update'      => Carbon::now()->format('Y-m-d h:i:s'),
                'reader_hit'       => 0,
                'is_latest'        => $attributes['latest_confirmed'] ?? null,
                'status'           => $sta,
            ];

            $newsMst = NewsMst::create($newsMstData);

            /**
             * create breaking news
             */

            if ($breaking_confirmed && $breaking_confirmed == 1) {

                $br_data                   = [];
                $br_data['news_title']     = $title;
                $br_data['url']            = url('/') . $page . '/details/' . $generate_id . '/' . @trim(@implode('-', @preg_split("/[\s,-\:,()]+/", @$title)), '-');
                $JSON_format_breaking_news = json_encode($br_data);

                $breakingNewsData = [
                    'title'      => $JSON_format_breaking_news,
                    'time_stamp' => $time_stamp,
                    'status'     => 1,
                ];

                $breakingNews = BreakingNews::create($breakingNewsData);
            }

            /**
             * 0 for dynamic home
             */

            if ($home_page and ($confirm_dynamic_static == 0)) {
                $home_news_id_arr = [];

                for ($i = $home_page; $i <= $total_news + 7; $i++) {

                    $row = NewsPosition::select('news_id')
                        ->where('position', $i)
                        ->where('page', 'home')
                        ->orderBy('id', 'DESC')
                        ->first();

                    if (!empty($row->news_id)) {
                        $home_news_id_arr[$i + 1] = $row->news_id;
                    }

                }

                foreach ($home_news_id_arr as $position => $news_id) {
                    NewsPosition::where('news_id', $news_id)
                        ->where('page', 'home')
                        ->delete();

                    $pos = [
                        'news_id'  => $news_id,
                        'page'     => 'home',
                        'position' => $position,
                        'status'   => 1,
                    ];
                    NewsPosition::insert($pos);
                }

                NewsPosition::where('position', $home_page)
                    ->where('page', 'home')
                    ->delete();

                $pos1 = [
                    'news_id'  => $generate_id,
                    'page'     => 'home',
                    'position' => $home_page,
                    'status'   => $sta,
                ];

                NewsPosition::create($pos1);
            }

            /**
             * 0 for dynamic other pages
             */

            if ($other_position and $other_page and ($confirm_dynamic_static == 0)) {
                $news_id_arr = [];
                $statuss     = [];

                for ($i = $other_position; $i <= $total_news; $i++) {

                    $row = NewsPosition::select('news_id', 'status')
                        ->where('position', $i)
                        ->where('page', $other_page)
                        ->orderBy('id', 'DESC')
                        ->first();

                    if (!empty($row->news_id)) {
                        $news_id_arr[$i + 1]    = $row->news_id;
                        $statuss[$row->news_id] = $row->status;
                    }

                }

                foreach ($news_id_arr as $position => $news_id) {
                    NewsPosition::where('news_id', $news_id)
                        ->where('page', $other_page)
                        ->delete();

                    $news_pos1 = [
                        'news_id'  => $news_id,
                        'page'     => $other_page,
                        'position' => $position,
                        'status'   => $statuss[$news_id],
                    ];
                    NewsPosition::create($news_pos1);
                }

                NewsPosition::where('position', $other_position)
                    ->where('page', $other_page)
                    ->delete();

                $news_pos2 = [
                    'news_id'  => $generate_id,
                    'page'     => $other_page,
                    'position' => $other_position,
                    'status'   => $st,
                ];
                NewsPosition::create($news_pos2);

            }

            if ($home_page && ($confirm_dynamic_static == 1)) {
                $sd = NewsPosition::where('news_id', $generate_id)->count();

                if ($sd <= 0) {
                    NewsPosition::where('position', $other_position)
                        ->where('page', 'home')
                        ->delete();

                    $news_pos3 = [
                        'news_id'  => $generate_id,
                        'page'     => 'home',
                        'position' => $home_page,
                        'status'   => $sta,
                    ];
                    NewsPosition::create($news_pos3);
                }

            }

            /**
             * 1 for static other
             */

            if ($other_position && $other_page && ($confirm_dynamic_static == 1)) {
                $sd = NewsPosition::where('news_id', $generate_id)->count();

                if ($sd <= 0) {
                    NewsPosition::where('position', $other_position)
                        ->where('page', $other_page)
                        ->delete();

                    $news_pos4 = [
                        'news_id'  => $generate_id,
                        'page'     => $other_page,
                        'position' => $other_position,
                        'status'   => $st,
                    ];
                    NewsPosition::create($news_pos4);
                }

            }

            XmlService::rss_xml();
            XmlService::sitemap_xml();

            // delete cache file

            $post_keyword     = $attributes['meta_keyword'] ?? null;
            $post_description = $attributes['meta_description'] ?? null;

            if (!empty($post_keyword) && !empty($post_description)) {
                $post_meta                     = [];
                $post_meta['meta_keyword']     = $post_keyword;
                $post_meta['meta_description'] = $post_description;
                $post_meta['news_id']          = $newsMst['news_id'];
                PostSeoOnpage::create($post_meta);
            }

            $posttag = $attributes['post_tag'] ?? null;

            if (!empty($posttag)) {

                $post_tag = explode(',', $posttag);

                foreach ($post_tag as $key => $tags) {
                    $t   = $this->explodedTitle($tags);
                    $tag = [
                        'news_id' => $newsMst['news_id'],
                        'tag'     => $t,
                    ];
                    PostTag::create($tag);
                }

            }

            $active_status = $attributes['schemasetup'] ?? null;

            if (!empty($active_status)) {
                $description = $attributes['details_news'] ?? null;

                // for schema
                $schemapost                   = [];
                $schemapost['type']           = 'Article';
                $schemapost['url']            = null;
                $schemapost['headline']       = $attributes['head_line'] ?? null;
                $schemapost['image_url']      = null;
                $schemapost['description']    = implode(' ', array_slice(explode(' ', $description), 0, 60));
                $schemapost['author_type']    = 'person';
                $schemapost['author_name']    = null;
                $schemapost['publisher']      = null;
                $schemapost['publisher_logo'] = null;
                $schemapost['publishdate']    = $attributes['ref_date'];
                $schemapost['modifidate']     = $attributes['ref_date'];
                $schemapost['news_id']        = $newsMst['news_id'];

                SchemaPost::create($schemapost);
            }

            DB::commit();

            return $newsMst;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("news_create_error"),
                'title'   => localize("news"),
            ], 422));
        }

    }

    /**
     * Update News
     *
     * @param  array  $attributes
     * @return NewsMst
     * @throws Exception
     */
    public function update(array $attributes): NewsMst
    {
        $newsMstId = $attributes['news_mst_id'];
        $newsMst   = NewsMst::findOrFail($newsMstId);

        $generate_id = $newsMst->news_id;

        try {
            DB::beginTransaction();

            $post_ap_status = 0;
            $auth_user      = auth()->user();

            if ($auth_user->post_ap_status != 0) {
                $post_ap_status = 1;
            } else {
                $post_ap_status = $attributes['status_confirmed'] ?? 0;
            }

            if ($post_ap_status == 1) {
                $sta = 0;
            } else {
                $sta = 1;
            }

            if ($post_ap_status == 1) {
                $st = 1;
            } else {
                $st = 0;
            }

            $other_page = $attributes['other_page'];
            $title      = $attributes['head_line'] ?? null;

            $encode_title = str_replace(' ', '-', $attributes['custom_url'] ?? $attributes['head_line'] ?? null);

            $page                   = $other_page ?? 'home';
            $post_by                = $auth_user->id;
            $publish_date           = $attributes['publish_date'] ?? $attributes['ref_date'] ?? null;
            $other_position         = $attributes['other_position'] ?? 1;
            $confirm_dynamic_static = $attributes['confirm_dynamic_static'] ?? null;
            $breaking_confirmed     = $attributes['breaking_confirmed'] ?? null;
            $home_page              = $attributes['home_page'] ?? null;
            $total_news             = 14;

            $newsMstData = [
                'encode_title'     => $encode_title,
                'seo_title'        => $attributes['seo_title'] ?? null,
                'stitle'           => $attributes['short_head'] ?? null,
                'title'            => $title,

                'news'             => $attributes['details_news'] ?? null,
                'image'            => $attributes['lib_file_selected'] ?? null,
                'image_base_url'   => null,
                'image_alt'        => $attributes['image_alt'] ?? null,
                'image_title'      => $attributes['image_title'] ?? null,

                'videos'           => $attributes['videos'] ?? null,
                'podcust_id'       => null,
                'page'             => $page,
                'reference'        => $attributes['reference'] ?? null,
                'ref_date'         => $attributes['ref_date'],
                'reporter_id'      => $attributes['reporter_id'] ?? $auth_user->reporter->id ?? null,

                'reporter'         => null,
                'post_by'          => $post_by,
                'update_by'        => null,
                'time_stamp'       => time(),
                'post_date'        => Carbon::now(),
                'publish_date'     => $publish_date,
                'last_update'      => Carbon::now()->format('Y-m-d h:i:s'),
                'is_latest'        => $attributes['latest_confirmed'] ?? null,
                'status'           => $sta,
            ];

            $newsMst->update($newsMstData);

            /**
             * Delete previous related data
             */
            NewsPosition::where('news_id', $generate_id)->delete();
            PostSeoOnpage::where('news_id', $generate_id)->delete();
            PostTag::where('news_id', $generate_id)->delete();
            SchemaPost::where('news_id', $generate_id)->delete();

            /**
             * create breaking news
             */

            if ($breaking_confirmed && $breaking_confirmed == 1) {

                $br_data                   = [];
                $br_data['news_title']     = $title;
                $br_data['url']            = url('/') . $page . '/details/' . $generate_id . '/' . @trim(@implode('-', @preg_split("/[\s,-\:,()]+/", @$title)), '-');
                $JSON_format_breaking_news = json_encode($br_data);

                $breakingNewsData = [
                    'title'      => $JSON_format_breaking_news,
                    'time_stamp' => time(),
                    'status'     => 1,
                ];

                $breakingNews = BreakingNews::create($breakingNewsData);
            }

            /**
             * 0 for dynamic home
             */

            if ($home_page and ($confirm_dynamic_static == 0)) {
                $home_news_id_arr = [];

                for ($i = $home_page; $i <= $total_news + 7; $i++) {

                    $row = NewsPosition::select('news_id')
                        ->where('position', $i)
                        ->where('page', 'home')
                        ->orderBy('id', 'DESC')
                        ->first();

                    if (!empty($row->news_id)) {
                        $home_news_id_arr[$i + 1] = $row->news_id;
                    }

                }

                foreach ($home_news_id_arr as $position => $news_id) {
                    NewsPosition::where('news_id', $news_id)
                        ->where('page', 'home')
                        ->delete();

                    $pos = [
                        'news_id'  => $news_id,
                        'page'     => 'home',
                        'position' => $position,
                        'status'   => 1,
                    ];
                    NewsPosition::insert($pos);
                }

                NewsPosition::where('position', $home_page)
                    ->where('page', 'home')
                    ->delete();

                $pos1 = [
                    'news_id'  => $generate_id,
                    'page'     => 'home',
                    'position' => $home_page,
                    'status'   => $sta,
                ];

                NewsPosition::create($pos1);
            }

            /**
             * 0 for dynamic other pages
             */

            if ($other_position and $other_page and ($confirm_dynamic_static == 0)) {
                $news_id_arr = [];
                $statuss     = [];

                for ($i = $other_position; $i <= $total_news; $i++) {

                    $row = NewsPosition::select('news_id', 'status')
                        ->where('position', $i)
                        ->where('page', $other_page)
                        ->orderBy('id', 'DESC')
                        ->first();

                    if (!empty($row->news_id)) {
                        $news_id_arr[$i + 1]    = $row->news_id;
                        $statuss[$row->news_id] = $row->status;
                    }

                }

                foreach ($news_id_arr as $position => $news_id) {
                    NewsPosition::where('news_id', $news_id)
                        ->where('page', $other_page)
                        ->delete();

                    $news_pos1 = [
                        'news_id'  => $news_id,
                        'page'     => $other_page,
                        'position' => $position,
                        'status'   => $statuss[$news_id],
                    ];
                    NewsPosition::create($news_pos1);
                }

                NewsPosition::where('position', $other_position)
                    ->where('page', $other_page)
                    ->delete();

                $news_pos2 = [
                    'news_id'  => $generate_id,
                    'page'     => $other_page,
                    'position' => $other_position,
                    'status'   => $st,
                ];
                NewsPosition::create($news_pos2);

            }

            if ($home_page && ($confirm_dynamic_static == 1)) {
                $sd = NewsPosition::where('news_id', $generate_id)->count();

                if ($sd <= 0) {
                    NewsPosition::where('position', $other_position)
                        ->where('page', 'home')
                        ->delete();

                    $news_pos3 = [
                        'news_id'  => $generate_id,
                        'page'     => 'home',
                        'position' => $home_page,
                        'status'   => $sta,
                    ];
                    NewsPosition::create($news_pos3);
                }

            }

            /**
             * 1 for static other
             */

            if ($other_position && $other_page && ($confirm_dynamic_static == 1)) {
                $sd = NewsPosition::where('news_id', $generate_id)->count();

                if ($sd <= 0) {
                    NewsPosition::where('position', $other_position)
                        ->where('page', $other_page)
                        ->delete();

                    $news_pos4 = [
                        'news_id'  => $generate_id,
                        'page'     => $other_page,
                        'position' => $other_position,
                        'status'   => $st,
                    ];
                    NewsPosition::create($news_pos4);
                }

            }

            XmlService::rss_xml();
            XmlService::sitemap_xml();

            $post_keyword     = $attributes['meta_keyword'] ?? null;
            $post_description = $attributes['meta_description'] ?? null;

            if (!empty($post_keyword) && !empty($post_description)) {
                $post_meta                     = [];
                $post_meta['meta_keyword']     = $post_keyword;
                $post_meta['meta_description'] = $post_description;
                $post_meta['news_id']          = $newsMst['news_id'];
                PostSeoOnpage::create($post_meta);
            }

            $posttag = $attributes['post_tag'] ?? null;

            if (!empty($posttag)) {

                $post_tag = explode(',', $posttag);

                foreach ($post_tag as $key => $tags) {
                    $t   = $this->explodedTitle($tags);
                    $tag = [
                        'news_id' => $newsMst['news_id'],
                        'tag'     => $t,
                    ];
                    PostTag::create($tag);
                }

            }

            $active_status = $attributes['schemasetup'] ?? null;

            if (!empty($active_status)) {
                $description = $attributes['details_news'] ?? null;

                // for schema
                $schemapost                   = [];
                $schemapost['type']           = 'Article';
                $schemapost['url']            = null;
                $schemapost['headline']       = $attributes['head_line'] ?? null;
                $schemapost['image_url']      = null;
                $schemapost['description']    = implode(' ', array_slice(explode(' ', $description), 0, 60));
                $schemapost['author_type']    = 'person';
                $schemapost['author_name']    = null;
                $schemapost['publisher']      = null;
                $schemapost['publisher_logo'] = null;
                $schemapost['publishdate']    = $attributes['ref_date'];
                $schemapost['modifidate']     = $attributes['ref_date'];
                $schemapost['news_id']        = $newsMst['news_id'];

                SchemaPost::create($schemapost);
            }

            DB::commit();

            return $newsMst;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("news_update_error"),
                'title'   => localize("news"),
            ], 422));
        }

    }

    /**
     * Delete
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $newsMstId = $attributes['id'];

        try {
            DB::beginTransaction();

            $newsMst = NewsMst::find($newsMstId);

            if ($newsMst) {
                $news_id = $newsMst->news_id;

                // BreakingNews;
                NewsPosition::where('news_id', $news_id)->delete();
                PostSeoOnpage::where('news_id', $news_id)->delete();
                PostTag::where('news_id', $news_id)->delete();
                SchemaPost::where('news_id', $news_id)->delete();
                $newsMst->delete();

            }

            DB::commit();

            return true;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("photo_library_delete_error"),
                'title'   => localize("photo_library"),
            ], 422));
        }

    }

    /**
     * Update News Status
     *
     * @param  array  $attributes
     * @return string
     * @throws Exception
     */
    public function updateStatus(array $attributes): string
    {
        $newsMstId = $attributes['news_mst_id'];
        $newsMst   = NewsMst::findOrFail($newsMstId);

        try {
            DB::beginTransaction();

            $status = $attributes['status'] ?? 0;

            $newsMstData = [
                'status' => $status,
            ];

            $newsMst->update($newsMstData);
            $newsMst->refresh();

            DB::commit();

            $status_span = "";

            if ($newsMst->status == 1) {
                $status_span = '<span class="btn btn-labeled btn-success mb-2 mr-1 update-status-button" title="' . localize('publish') . '" data-action="' . route('news.update-status', ['news' => $newsMst->id]) . '" data-update_status="0" >' . localize('publish') . '</span>';

            } else {
                $status_span =  '<span class="btn btn-labeled btn-warning mb-2 mr-1 update-status-button" title="' . localize('unpublish') . '" data-action="' . route('news.update-status', ['news' => $newsMst->id]) . '" data-update_status="1" >' . localize('unpublish') . '</span>';

            }

            return $status_span;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("news_update_status_error"),
                'title'   => localize("news"),
            ], 422));
        }

    }

    /**
     * NewsMst data
     *
     * @param integer $id
     * @return NewsMst|null
     */
    public function newsMstData(int $id): ?NewsMst
    {
        $newsMst = NewsMst::with([
            'postByUser',
            'category',
            'photoLibrary',
            'otherNewsPosition',
            'homeNewsPosition',
            'schemaPost',
            'postTags',
            'postSeoOnpage',
        ])->findOrFail($id);

        return $newsMst;
    }

    /**
     * ExplodeTitle
     *
     * @param string $title
     * @return void
     */
    private function explodedTitle(string $title)
    {
        $extitle = @trim(@implode('-', @preg_split("/[\s,-\:,()]+/", @$title)), '');
        $string  = str_replace(' ', '-', trim($title));
        return $string;
    }

}

<?php

namespace Modules\News\Services;

use App\Models\BreakingNews;
use App\Models\NewsPosition;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;

class BreakingNewsService
{
    /**
     * Form Data
     *
     * @param  array  $attributes
     * @return array
     */
    public function formData(): array
    {
        $categories    = Category::get();
        $newsPositions = NewsPosition::with('newsMst')->get();

        return compact('categories', 'newsPositions');
    }

    /**
     * Create
     *
     * @param  array  $attributes
     * @return BreakingNews
     * @throws Exception
     */
    public function create(array $attributes): BreakingNews
    {
        $breaking_news = $attributes['breaking_news'];

        try {
            DB::beginTransaction();

            $data = [
                'title'      => json_encode(['news_title' => $breaking_news, 'url' => '']),
                'time_stamp' => time() + (6 * 60 * 60),
                'status'     => 1,
            ];

            $breakingNews = BreakingNews::create($data);

            DB::commit();

            return $breakingNews;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("breaking_news_create_error"),
                'title'   => localize("breaking_news"),
            ], 422));
        }

    }

    /**
     * Create
     *
     * @param  array  $attributes
     * @return BreakingNews
     * @throws Exception
     */
    public function edit(array $attributes): BreakingNews
    {
        $breakingNewsId = $attributes['id'];

        $breakingNews = BreakingNews::find($breakingNewsId);

        if (!$breakingNews) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("breaking_news_data_find_error"),
                'title'   => localize("breaking_news"),
            ], 422));
        }

        return $breakingNews;
    }

    /**
     * Update
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function update(array $attributes): bool
    {
        $breakingNewsId = $attributes['id'];
        $breaking_news  = $attributes['breaking_news'];

        try {
            DB::beginTransaction();
            $data = [
                'title' => json_encode(['news_title' => $breaking_news, 'url' => '']),
            ];

            BreakingNews::where('id', $breakingNewsId)->update($data);

            DB::commit();

            return true;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("breaking_news_update_error"),
                'title'   => localize("breaking_news"),
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
        $breakingNewsId = $attributes['id'];

        try {
            DB::beginTransaction();

            BreakingNews::where('id', $breakingNewsId)->delete();

            DB::commit();

            return true;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("breaking_news_delete_error"),
                'title'   => localize("breaking_news"),
            ], 422));
        }

    }

}

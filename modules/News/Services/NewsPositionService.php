<?php

namespace Modules\News\Services;

use App\Models\NewsPosition;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;

class NewsPositionService
{
    /**
     * Form Data
     *
     * @param  array  $attributes
     * @return array
     */
    public function formData(array $attributes): array
    {
        $categories = Category::get();
        $newsPositions = [];
        if (!empty($attributes['other_page'])) {
            $newsPositions = NewsPosition::with('newsMst')
                ->where(function ($query) use ($attributes) {
                    $query->where('page', $attributes['other_page']);
                })
                ->get();
        }

        return compact('categories', 'newsPositions');
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
        $positions = $attributes['position'];

        NewsPosition::orWhereDoesntHave('newsMst')->delete();

        try {
            DB::beginTransaction();

            foreach ($positions as $newsPositionId => $position) {
                NewsPosition::find($newsPositionId)->update(['position' => $position]);
            }

            DB::commit();

            return true;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("news_position_update_error"),
                'title'   => localize("news_position"),
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

            NewsPosition::where('id', $newsMstId)->delete();

            DB::commit();

            return true;

        } catch (Exception $exception) {
            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("news_position_delete_error"),
                'title'   => localize("news_position"),
            ], 422));
        }

    }

}

<?php

namespace Modules\News\Services;

use App\Enums\AssetsFolderEnum;
use App\Models\NewsMst;
use App\Models\PhotoLibrary;
use App\Models\PhotoPost;
use App\Models\PhotoPostDetail;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Modules\Category\Entities\Category;

class NewsPostService
{
    /**
     * Form Data
     *
     * @return array
     */
    public function formData(): array
    {
        $categories = Category::get();

        return compact('categories');
    }

    /**
     * Create News
     *
     * @param  array  $attributes
     * @return PhotoPost
     * @throws Exception
     */
    public function create(array $attributes): PhotoPost
    {
        try {
            DB::beginTransaction();

            $post_keyword     = $attributes['meta_keyword'] ?? null;
            $post_description = $attributes['meta_description'] ?? null;

            $photoPostData = [
                'category'         => $attributes['other_page'],
                'stitle'           => $attributes['short_head'] ?? null,
                'title'            => $attributes['head_line'],
                'details'          => $attributes['details'] ?? null,
                'post_by'          => auth()->id(),
                'meta_keyword'     => $post_keyword,
                'meta_description' => $post_description,
                'timestamp'        => time() + 6 * 60 * 60,
            ];

            $photoPost = PhotoPost::create($photoPostData);

            $gallery_photo   = $attributes['lib_file_selected'] ?? null;
            $photo_title     = $attributes['image_alt'] ?? null;
            $photo_reference = $attributes['image_title'] ?? null;

            if ($photoPost && !empty($gallery_photo)) {

                foreach ($gallery_photo as $key => $image) {
                    $photoLibrary = PhotoLibrary::where('actual_image_name', $image)->first();

                    $postGallery                    = [];
                    $postGallery['title']           = $photo_title[$key] ?? null;
                    $postGallery['post_id']         = $photoPost->id;
                    $postGallery['image']           = $image;
                    $postGallery['image_base_url']  = $photoLibrary->image_base_url ?? null;
                    $postGallery['photo_reference'] = $photo_reference[$key] ?? null;

                    PhotoPostDetail::create($postGallery);
                }

            }

            DB::commit();

            return $photoPost;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("photo_post_create_error"),
                'title'   => localize("photo_post"),
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
    public function update(array $attributes): bool
    {
        $photoPostId = $attributes['photo_post_id'];
        $photoPost   = PhotoPost::findOrFail($photoPostId);

        try {
            DB::beginTransaction();

            $post_keyword     = $attributes['meta_keyword'] ?? null;
            $post_description = $attributes['meta_description'] ?? null;

            $photoPostData = [
                'category'         => $attributes['other_page'],
                'stitle'           => $attributes['short_head'] ?? null,
                'title'            => $attributes['head_line'],
                'details'          => $attributes['details'] ?? null,
                'post_by'          => auth()->id(),
                'meta_keyword'     => $post_keyword,
                'meta_description' => $post_description,
                'timestamp'        => time() + 6 * 60 * 60,
            ];

            $updateCheck = $photoPost->update($photoPostData);

            $gallery_photo   = $attributes['lib_file_selected'] ?? null;
            $photo_title     = $attributes['image_alt'] ?? null;
            $photo_reference = $attributes['image_title'] ?? null;

            if ($updateCheck && !empty($gallery_photo)) {

                PhotoPostDetail::where('post_id', $photoPostId)->delete();

                foreach ($gallery_photo as $key => $image) {
                    $photoLibrary       = PhotoLibrary::where('actual_image_name', $image)->first();

                    $postGallery                    = [];
                    $postGallery['title']           = $photo_title[$key] ?? null;
                    $postGallery['post_id']         = $photoPost->id;
                    $postGallery['image']           = $image;
                    $postGallery['image_base_url']  = $photoLibrary->image_base_url ?? null;
                    $postGallery['photo_reference'] = $photo_reference[$key] ?? null;

                    PhotoPostDetail::create($postGallery);
                }

            }

            DB::commit();

            return true;
        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("photo_post_update_error"),
                'title'   => localize("photo_post"),
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
        $photoPostId = $attributes['id'];

        try {
            DB::beginTransaction();

            PhotoPost::where('id', $photoPostId)->delete();
            PhotoPostDetail::where('post_id', $photoPostId)->delete();

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
     * Photo Post data
     *
     * @param integer $id
     * @return PhotoPost|null
     */
    public function photoPostData(int $id): ?PhotoPost
    {
        $photoPost = PhotoPost::with(['photoPostDetails.photoLibrary'])->findOrFail($id);

        return $photoPost;
    }

}

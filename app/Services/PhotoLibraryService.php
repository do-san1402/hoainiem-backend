<?php

namespace App\Services;

use App\Enums\AssetsFolderEnum;
use App\Helpers\ImageHelper;
use App\Models\PhotoLibrary;
use App\Models\SpaceCredential;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class PhotoLibraryService
{
    /**
     * Form Data
     *
     * @return array
     */
    public function formData(array $attributes = []): array
    {
        $data                   = [];
        $data['imageLibraries'] = PhotoLibrary::where(function ($query) use ($attributes) {

            if (!empty($attributes['name'])) {
                $query = $query->where('title', 'LIKE', "%" . $attributes['name'] . "%");
            }

        })->get();

        if (!empty($attributes['div_id'])) {
            $data['div_id'] = $attributes['div_id'];
        }

        return $data;
    }

    /**
     * Create Image library
     *
     * @param  array  $attributes
     * @return PhotoLibrary
     * @throws Exception
     */
    public function create(array $attributes): ?PhotoLibrary
    {

        $spaceCredential = SpaceCredential::where('status', 1)->first();
        $uploadDisk      = current_file_system_disk();

        if ($spaceCredential) {
            $uploadDisk = 's3';
        }

        try {
            DB::beginTransaction();
            $thumbImgPath  = null;
            $largeImgPath  = null;
            $imageFilename = null;

            $imageBaseUrl     = null;
            $thumb_image_path = null;

            if (!empty($attributes['image'])) {
                $imageFilename = $attributes['image']->hashName();

                $thumbSize = [
                    'width'  => $attributes['thumb_width'] ?? 300,
                    'height' => $attributes['thumb_height'] ?? 300,
                ];

                $largeSize = [
                    'width'  => $attributes['large_width'] ?? 300,
                    'height' => $attributes['large_height'] ?? 300,
                ];

                $thumbImgUpload = ImageHelper::upload($attributes['image'] ?? null, 'images/thumb', $uploadDisk, $thumbSize);
                $thumbImgPath   = $thumbImgUpload['image_path'] ?? null;
                $imageUlr       = $thumbImgUpload['image_url'] ?? null;

                $largeImgUpload = ImageHelper::upload($attributes['image'] ?? null, 'images/large', $uploadDisk, $largeSize);
                $largeImgPath   = $largeImgUpload['image_path'] ?? null;

                if ($uploadDisk == 'local' && $thumbImgPath) {
                    $imageBaseUrl     = asset(AssetsFolderEnum::STORAGE_ASSETS->value . '/' . $thumbImgPath);
                    $thumb_image_path = storage_asset_image($thumbImgPath);

                } else {
                    $imageBaseUrl     = $imageUlr;
                    $thumb_image_path = $imageUlr;
                }

            }

            $insertData = [
                'disk'              => $uploadDisk,
                'image_base_url'    => $imageBaseUrl,
                'actual_image_name' => $imageFilename,
                'picture_name'      => $imageFilename,
                'thumb_image'       => $thumbImgPath,
                'large_image'       => $largeImgPath,
                'title'             => $attributes['caption'],
                'reference'         => $attributes['reference'],
                'time_stamp'        => time() + 6 * 60 * 60,
                'status'            => 1,
            ];
            $photoLibrary = PhotoLibrary::create($insertData);

            DB::commit();

            $photoLibrary->thumb_image_path = $thumb_image_path;

            return $photoLibrary;

        } catch (Exception $exception) {

            DB::rollBack();

            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => localize("photo_library_create_error"),
                'title'   => localize("photo_library"),
            ], 422));
        }

    }

    /**
     * Delete Image library
     *
     * @param  array  $attributes
     * @return bool
     * @throws Exception
     */
    public function destroy(array $attributes): bool
    {
        $photoLibraryId = $attributes['id'];

        try {
            DB::beginTransaction();

            $photoLibrary = PhotoLibrary::findOrFail($photoLibraryId);

            if ($photoLibrary) {

                if ($photoLibrary->thumb_image) {
                    ImageHelper::delete_file('public/' . $photoLibrary->thumb_image);
                }

                if ($photoLibrary->large_image) {
                    ImageHelper::delete_file('public/' . $photoLibrary->large_image);
                }

            }

            $photoLibrary->delete();

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

}

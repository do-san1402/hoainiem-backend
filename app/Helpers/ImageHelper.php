<?php

namespace App\Helpers;

use App\Models\SpaceCredential;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    /**
     * Image Upload
     * @param object $file
     * @param string $folderName
     * @param string $disk
     * @param array $size
     * @return null|array
     */
    public static function upload($file, $folderName = "images", $disk = 'local', $size = []): ?array
    {

        if (!$file) {
            return null;
        }

        $filename        = $file->hashName();
        $imagePath       = $folderName . '/' . $filename;
        $imageUploadPath = $imagePath;

        if (!empty($size) && !empty($size['width']) && !empty($size['height'])) {
            $image = Image::make($file->getRealPath())->resize($size['width'], $size['height']);
        } else {
            $image = Image::make($file->getRealPath());
        }

        if ($disk == 's3') {
            $spaceCredential = SpaceCredential::where('status', 1)->first();

            if ($spaceCredential) {
                Config::set('filesystems.disks.s3', [
                    'driver' => 's3',
                    'key'    => $spaceCredential->key,
                    'secret' => $spaceCredential->secret,
                    'region' => $spaceCredential->region,
                    'bucket' => $spaceCredential->bucket,
                    'url'    => $spaceCredential->url,
                ]);
            } else {
                $disk = 'local';
            }

        }

        if ($disk == 'local') {
            $imageUploadPath = "public/" . $imagePath;
        }

        Storage::disk($disk)->put($imageUploadPath, $image->stream()->__toString());
        $imageUrl = Storage::disk($disk)->url($imagePath);

        return [
            'image_path' => $imagePath,
            'image_url'  => $imageUrl,
            'disk'       => $disk,
        ];
    }

    /**
     * Delete file from storage
     *
     * @param string|null $file
     * @param string $disk
     * @return bool
     */
    public static function delete_file(string $file, $disk = 'local', ): bool
    {
        $uploadDisk = env('FILESYSTEM_DISK', 'local');

        if ($uploadDisk == 's3') {
            $spaceCredential = SpaceCredential::where('status', 1)->first();

            if ($spaceCredential) {
                Config::set('filesystems.disks.s3', [
                    'driver' => 's3',
                    'key'    => $spaceCredential->key,
                    'secret' => $spaceCredential->secret,
                    'region' => $spaceCredential->region,
                    'bucket' => $spaceCredential->bucket,
                    'url'    => $spaceCredential->url,
                ]);
            } else {
                $disk = 'local';
            }

        }

        if (!storage_exist($file)) {
            return false;
        }

        return Storage::disk($disk)->delete($file);

    }

}

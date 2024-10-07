<?php
namespace App\Traits;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use File;

trait PictureResizeTrait{


    private function resizeImage($file, $imageable_type , $imageable_id , $existing)
    {
        $pic = Picture::where('imageable_id' , $imageable_id)->first();
        if($pic){
            $pic->delete();
        }
        $filenameWithExt = $file->getClientOriginalName();

        // Get file path
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // Remove unwanted characters
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);

        // Get the original image extension
        $extension = $file->getClientOriginalExtension();

        // Create unique file name
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        $attributes = [
            'imageable_type' => $imageable_type,
            'imageable_id' => $imageable_id
        ];

        $sizes = [
            'febicon' => [32, 32],
        ];


        foreach ($sizes as $key => $size) {
            // Resize image
            $resize = Image::make($file)->fit($size[0], $size[1])->encode('jpg');
            // Create hash value
            $hash = md5($resize->__toString());
            // Prepare qualified image name
            $image = $hash . "jpg";
            // Put image to storage
            $save = Storage::put("public/country/{$fileNameToStore}", $resize->__toString());

        }

        $pic = new Picture();
        $pic->imageable_type = $imageable_type;
        $pic->imageable_id = $imageable_id;
        $pic->febicon = "country/{$fileNameToStore}";
        $pic->save();

    }

}

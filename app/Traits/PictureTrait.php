<?php
namespace App\Traits;
use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use File;

trait PictureTrait{

    private function upload($file , $imageable_type , $imageable_id , $existing){

        if($existing == 0){
            $pic = new Picture();
            $pic->imageable_type = $imageable_type;
            $pic->imageable_id =  $imageable_id;
            $pic->thumbnail =  Storage::put('user-profile', $file);
            $pic->save();
        }else {
            $pic = Picture::where('imageable_id' , $imageable_id)->first();
            $this->deleteFile($pic->thumbnail);
            $pic->imageable_type = $imageable_type;
            $pic->imageable_id =  $imageable_id;
            $pic->thumbnail =  Storage::put('user-profile', $file);
            $pic->save();

        }

    }

    private function deleteFile($path)
     {
         if(Storage::exists($path)) {
             Storage::delete($path);
         }
     }
}

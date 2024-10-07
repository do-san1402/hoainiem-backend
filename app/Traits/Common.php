<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait Common
{

    public function defaultImg()
    {
        $dif = DB::table('settings')->where('id', 118)->first();
        return $dif->img;
    }

    public function childCategory($slug)
    {

        $menu = DB::table('menu_contents')
        ->where('slug',$slug)
        ->first();

        $result = DB::table('menu_contents')
        ->where('parent_id',$menu->id)
        ->orderBy('menu_contents.menu_position','ASC')
        ->get();

        return $result;
    }

}

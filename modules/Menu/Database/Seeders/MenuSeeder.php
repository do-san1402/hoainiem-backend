<?php

namespace Modules\Menu\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Menu\Entities\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::truncate();
        Menu::create([
            'name'          => 'Main Menu',
            'position'      => 1,
            'status'        => 1,
            'mobile_status' => 1,
        ]);
        Menu::create([
            'name'          => 'Category',
            'position'      => 2,
            'status'        => 1,
            'mobile_status' => 1,
        ]);
        Menu::create([
            'name'          => 'Page',
            'position'      => 3,
            'status'        => 1,
            'mobile_status' => 1,
        ]);
    }
}

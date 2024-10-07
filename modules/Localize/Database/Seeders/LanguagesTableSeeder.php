<?php

namespace Modules\Localize\Database\Seeders;

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        \DB::table('languages')->delete();

        \DB::table('languages')->insert([
            0 => [
                'created_at' => '2022-12-08 06:29:24',
                'id' => 1,
                'langname' => 'English',
                'updated_at' => '2022-12-08 06:29:24',
                'value' => 'en',
            ],
            1 => [
                'created_at' => '2022-12-08 06:29:24',
                'id' => 2,
                'langname' => 'Arabic',
                'updated_at' => '2022-12-08 06:29:24',
                'value' => 'ar',
            ],
        ]);

    }
}

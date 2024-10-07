<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Entities\Application;

class ApplicationsSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Application::create([
            'language_id' => 1,
            'currency_id' => 1,
            'title' => 'HRM',
            'phone' => '880-258970255',
            'email' => 'info@bdtask.com',
            'website' => 'https://www.bdtask.com',
            'address' => 'B-25, Mannan Plaza, 4th Floor Khilkhet, Dhaka-1229, Bangladesh',
            'tax_no' => '43242424',
            'rtl_ltr' => 1,
            'prefix' => 'BT',
            'footer_text' => 'BDTASK © 2022. All Rights Reserved.',
            'logo' => null,
            'created_at' => '2022-10-13 04:46:42',
            'updated_at' => '2023-01-10 11:10:42',
            'deleted_at' => NULL,
        ]);
    }
}
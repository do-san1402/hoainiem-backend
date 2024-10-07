<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Setting\Entities\Application;
use Modules\Setting\Entities\Currency;

class CurrencySeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'country_id' => 14,
            'title' => 'Taka',
            'symbol' => '৳',
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Localize\Database\Seeders\LocalizeDatabaseSeeder;
use Modules\UserManagement\Database\Seeders\UserManagementDatabaseSeeder;
use Modules\Setting\Database\Seeders\SettingDatabaseSeeder;
use Modules\Setting\Database\Seeders\SeedCountriesTableSeeder;
use Database\Seeders\DistrictSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ApplicationsSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(UserManagementDatabaseSeeder::class);
        $this->call(LocalizeDatabaseSeeder::class);
        $this->call(SettingDatabaseSeeder::class);
        $this->call(SeedCountriesTableSeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(UpazilaSeeder::class);
    }
}

<?php

namespace Modules\UserManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\UserManagement\Database\Seeders\RoleTableSeeder;
use Modules\UserManagement\Database\Seeders\UserTableSeeder;
use Modules\Menu\Database\Seeders\MenuSeeder;

class UserManagementDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RoleTableSeeder::class);
        $this->call(UserTypeTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(MenuSeeder::class);
    }
}

<?php

namespace Modules\UserManagement\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\UserManagement\Entities\UserType;

class UserTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        UserType::create([
            'user_type_title' => 'Admin',
            'is_active' => true,
        ]);

        UserType::create([
            'user_type_title' => 'Employee',
            'is_active' => true,
        ]);
    }
}

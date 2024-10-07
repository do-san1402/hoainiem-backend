<?php

namespace Modules\UserManagement\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $user = User::create([
            'user_type_id' => 1,
            'full_name' => 'Admin',
            'user_name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // assign role 1 to user
        $user->assignRole(1);
    }
}

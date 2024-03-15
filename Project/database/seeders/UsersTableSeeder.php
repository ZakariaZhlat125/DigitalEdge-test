<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'admin',
            'email' => 'admin@nowui.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $admin->addRole('admin');

        $zakaria = User::create([
            'first_name' => 'zakaria',
            'last_name' => 'zhlat',
            'email' => 'zakaria@seeder.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $test = User::create([
            'first_name' => 'firsttest',
            'last_name' => 'lasttest',
            'email' => 'test@seeder.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123465'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Http\Libs\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use \App\Models\USer;
use Faker\Factory as Faker;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // DB::table('users')->insert([
        //     'name' => Str::random(10),
        //     'email' => 'admin@admin.com',
        //     'password' => Hash::make('password'),
        //     'role' => Roles::ADMIN
        // ]);
        User::create(
            [
                'name' => Faker::create()->name(),
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'role' => Roles::ADMIN,
            ]
        );
    }
}

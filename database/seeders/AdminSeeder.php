<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Admin Mugi",
            'email' => "admin@gmail.com",
            'email_verified_at' => now(),
            'password' => bcrypt('mugi2023'), // password
            'remember_token' => Str::random(10),
        ]);
    }
}

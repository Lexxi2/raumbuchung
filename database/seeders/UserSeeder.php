<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Creating test user 
        // User::create([
        //     'username'          => 'tu_godalfreinhard',
        //     'name'              => 'godalfreinhard tu',
        //     'email'             => 'tu_godalfreinhard@test.local',
        //     'email_verified_at' => now(),
        //     'remember_token'    => Str::random(10),
        //     'password'          => 'F,}k!U{WTEwsr9xvLZvH$F/@i-!b.R',
        // ]);
    }
}
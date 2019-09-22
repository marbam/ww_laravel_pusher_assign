<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => env('ADMIN_NAME'), 
            'email' => env('ADMIN_EMAIL'),
            'password' => Hash::make(env('SAMPLE_PASSWORD')),
            'created_at' => Date("Y-m-d H:i:s"),
            'approved' => 1,
            'can_approve' => 1
        ]);


        User::create([
            'name' => "Unapproved", 
            'email' => env('UNAPPROVED_EMAIL'),
            'password' => Hash::make(env('SAMPLE_PASSWORD')),
            'created_at' => Date("Y-m-d H:i:s")
        ]);


    }
}

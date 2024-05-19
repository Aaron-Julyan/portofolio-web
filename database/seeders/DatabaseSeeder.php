<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();

        // \App\Models\User::create([
        //     'username' => 'aaron',
        //     'password' => 'aaron',
        //     'name' => 'Vanilla',
        //     'email' => 'test@example.com',
        //     'status' => 'group',
        //     'file' => '/profile-images/user1.png',
        //     'category' => 'Informatika',
        //     'description' => 'HALO',
        // ]);
    }
}

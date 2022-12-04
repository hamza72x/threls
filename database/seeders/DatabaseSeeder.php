<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
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
        User::firstOrCreate([
            'account_type' => User::ACCOUNT_TYPE_ADMIN,
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('_pass$123_'),
            'email_verified_at' => now()
        ]);
    }
}

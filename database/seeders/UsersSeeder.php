<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'Test User',
            'username' => 'staff account',
            'email' => 'staff@email.com',
            'password' => bcrypt('test1234'),
            'usertype' => 'staff',
        ]);
    }
}

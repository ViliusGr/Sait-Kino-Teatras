<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'user',
            'email' => 'user@a.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@a.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        DB::table('users')->insert([
            'name' => 'admin2',
            'email' => 'admin2@a.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}

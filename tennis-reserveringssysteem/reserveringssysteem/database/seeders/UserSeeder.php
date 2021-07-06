<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'firstname' => 'Admin',
            'lastname' => 'Tennisvereniging',
            'email' => 'admin@tennisvereniging.nl',
            'password' => Hash::make('admin'),
            'roles_id' => 1,
            'clubs_id' => 1,
        ]);
        DB::table('users')->insert([
            'firstname' => 'Gedelegeerd',
            'lastname' => 'Lid',
            'email' => 'gedelegeerd@tennisvereniging.nl',
            'password' => Hash::make('admin'),
            'member' => '12345678',
            'roles_id' => 2,
            'clubs_id' => 1,
        ]);
        DB::table('users')->insert([
            'firstname' => 'lid',
            'lastname' => 'Tennisvereniging',
            'email' => 'lid@tennisvereniging.nl',
            'password' => Hash::make('admin'),
            'member' => '87654321',
            'roles_id' => 3,
            'clubs_id' => 1,
        ]);
        DB::table('users')->insert([
            'firstname' => 'test',
            'lastname' => 'lid',
            'email' => 'lid1@tennisvereniging.nl',
            'password' => Hash::make('admin'),
            'member' => '24354678',
            'roles_id' => 3,
            'clubs_id' => 1,
        ]);
        DB::table('users')->insert([
            'firstname' => 'test2',
            'lastname' => 'lid',
            'email' => 'lid2@tennisvereniging.nl',
            'password' => Hash::make('admin'),
            'member' => '26587462',
            'roles_id' => 3,
            'clubs_id' => 1,
        ]);
        DB::table('users')->insert([
            'firstname' => 'test3',
            'lastname' => 'lid',
            'email' => 'lid3@tennisvereniging.nl',
            'password' => Hash::make('admin'),
            'member' => '32643255',
            'roles_id' => 3,
            'clubs_id' => 1,
        ]);
    }
}

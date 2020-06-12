<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $roles = [
            [Role::KLANT],
            [Role::EERSTELIJNS_MEDEWERKER],
            [Role::TWEEDELIJNS_MEDEWERKER],
            [Role::ADMIN],
        ];

        foreach ($roles as $role) {
            DB::insert(
                "INSERT INTO roles (name, created_at, updated_at)
                    VALUES (:name, now(), now())",
                [
                    "name" => $role[0],
                ]
            );
        } 
    }
}

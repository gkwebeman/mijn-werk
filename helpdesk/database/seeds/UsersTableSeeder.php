<?php

use App\Role;
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
        //

        $users = [
            ["Admin", Role::ADMIN, "admin@gmail.com", bcrypt("admin")],
            ["Eerstelijns 1", Role::EERSTELIJNS_MEDEWERKER, "lijn1mw@gmail.com", bcrypt("lijn1mw")],
            ["Eerstelijns 2", Role::EERSTELIJNS_MEDEWERKER, "lijn1mw1@gmail.com", bcrypt("lijn1mw1")],
            ["Eerstelijns 3", Role::EERSTELIJNS_MEDEWERKER, "lijn1mw2@gmail.com", bcrypt("lijn1mw2")],
            ["Tweedelijns 1", Role::TWEEDELIJNS_MEDEWERKER, "lijn2mw@gmail.com", bcrypt("lijn2mw")],
            ["Tweedelijns 2", Role::TWEEDELIJNS_MEDEWERKER, "lijn2mw1@gmail.com", bcrypt("lijn2mw1")],
            ["Tweedelijns 3", Role::TWEEDELIJNS_MEDEWERKER, "lijn2mw2@gmail.com", bcrypt("lijn2mw2")],
            ["Klant 1", Role::KLANT, "klant1@gmail.com", bcrypt("klant1")],
            ["Klant 2", Role::KLANT, "klant2@gmail.com", bcrypt("klant2")],
        ];

        $role_ids = DB::table("roles")->pluck("id", "name");

        foreach ($users as $user) {
            DB::insert(
                "INSERT INTO users (name, role_id, email, password, created_at, updated_at)
                    VALUES (:name, :role_id, :email, :password, now(), now())"
                ,
                [
                    "name" => $user[0],
                    "role_id" => $role_ids[$user[1]],
                    "email" => $user[2],
                    "password" => $user[3],
                ]
            );
        }
    }
}

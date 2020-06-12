<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $statuses = [
            [Status::EERSTELIJNS_WACHT, "Ticket staat in de wacht op een eerstelijns medewerker."],
            [Status::EERSTELIJNS_TOEGEWEZEN, "Ticket is toegewezen aan een eerstelijns medewerker."],
            [Status::TWEEDELIJNS_WACHT, "Ticket staat in de wacht op een tweedelijns medewerker."],
            [Status::TWEEDELIJNS_TOEGEWEZEN, "Ticket is toegewezen aan een tweedelijns medewerker."],
            [Status::AFGEHANDELD, "Ticket is afgehandeld."]
        ];

        foreach ($statuses as $status) {
            DB::insert(
                "INSERT INTO statuses (name, description, created_at, updated_at)
                    VALUES (:name, :description, now(), now())"
                ,
                [
                    "name" => $status[0],
                    "description" => $status[1],
                ]
                );
        }
    }
}

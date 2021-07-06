<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationkindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('reservation_kind')->insert([
            'name' => 'Normaal',
        ]);
        DB::table('reservation_kind')->insert([
            'name' => 'Les',
        ]);
        DB::table('reservation_kind')->insert([
            'name' => 'Evenement',
        ]);
    }
}

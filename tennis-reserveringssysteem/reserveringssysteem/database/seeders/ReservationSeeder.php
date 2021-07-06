<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('reservations')->insert([
            'starttime' => Carbon::createFromFormat('H:i', '12:00'),
            'endtime' => Carbon::createFromFormat('H:i', '13:00'),
            'courts_id' => 2,
            'reservations_kinds_id' => 1,
        ]);
        DB::table('reservations')->insert([
            'starttime' => Carbon::createFromFormat('H:i', '13:00')->subDay(),
            'endtime' => Carbon::createFromFormat('H:i', '14:00')->subDay(),
            'courts_id' => 4,
            'reservations_kinds_id' => 1,
        ]);
        DB::table('reservations')->insert([
            'starttime' => Carbon::createFromFormat('H:i', '14:00')->addDay(),
            'endtime' => Carbon::createFromFormat('H:i', '15:00')->addDay(),
            'courts_id' => 3,
            'reservations_kinds_id' => 1,
        ]);
    }
}

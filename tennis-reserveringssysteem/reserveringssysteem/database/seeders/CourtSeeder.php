<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('courts')->insert([
            'number' => 1,
            'type' => 'Gravel',
            'clubs_id' => 1,
        ]);
        DB::table('courts')->insert([
            'number' => 2,
            'type' => 'Gravel',
            'clubs_id' => 1,
        ]);
        DB::table('courts')->insert([
            'number' => 3,
            'type' => 'Kunstgras',
            'clubs_id' => 1,
        ]);
        DB::table('courts')->insert([
            'number' => 4,
            'type' => 'Kunstgras',
            'clubs_id' => 1,
        ]);
    }
}

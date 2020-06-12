<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $products = [
            ["water", 0.0],
            ["radler", 2.0],
        ];

        foreach ($products as $product) {
            DB::insert(
                "INSERT INTO products (name, percentage, created_at, updated_at)
                    VALUES (:name, :percentage, now(), now())",
                [
                    "name" => $product[0],
                    "percentage" => $product[1],
                ]
            );
        } 
    }
}

<?php

use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert(
            [
                [
                    "id" => "1",
                    "name" => "Coca cola",
                    "since" => "2014-06-28",
                    "revenue" => "492.12"
                ],
                [
                    "id" => "2",
                    "name" => "Teamleader",
                    "since" => "2015-01-15",
                    "revenue" => "1505.95"
                ],
                [
                    "id" => "3",
                    "name" => "Jeroen de Wit",
                    "since" => "2016-02-11",
                    "revenue" => "0.00"
                ]

            ]
        );
    }
}

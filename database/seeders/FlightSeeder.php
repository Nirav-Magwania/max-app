<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\Flight;

class FlightSeeder extends Seeder
{     
    public function run()
    {
        \App\Models\Flight::factory(20)->create();
    } 
}

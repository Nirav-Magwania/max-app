<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            'name' => fake()->city(),
            'user_id'=>fake()->numberBetween(1,10),
            'international'=>fake()->boolean(chanceOfGettingTrue: 50)
 
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\States;
use App\Models\Districts;
use App\Models\Cities;

class BloodBankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->randomNumber(8),          
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'state' => $this->faker->randomElement(States::pluck('name')->toArray()),
            'district' => $this->faker->randomElement(Districts::pluck('name')->toArray()),
            'city' => $this->faker->randomElement(Cities::pluck('name')->toArray()),
            'license_no' => $this->faker->randomNumber(5),
            'blood_type_available' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']),
        ];
    }
}

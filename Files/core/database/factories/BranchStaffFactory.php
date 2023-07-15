<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class BranchStaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->name(),
            'mobile'      => $this->faker->phoneNumber,
            'address'     => $this->faker->address(),
            'email'       => $this->faker->unique()->safeEmail(),
            'password'    => Hash::make('123456'),
            'designation' => rand(0,1)
        ];
    }
}

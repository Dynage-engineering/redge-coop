<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $branch = $this->faker->country();
        return [
            'name'    => $branch . '- Branch',
            'code'    => rand(1000, 9999),
            'address' => $branch,
            'email'   => $this->faker->unique()->safeEmail(),
            'mobile'  => $this->faker->phoneNumber,
        ];

    }
}

<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Position>
 */
class PositionFactory extends Factory
{
    protected $model = Position::class;

    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'company_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomNumber(),
            'position' => $this->faker->jobTitle,
        ];
    }
}

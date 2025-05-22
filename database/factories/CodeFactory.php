<?php

namespace Database\Factories;

use App\Models\Code;
use App\Models\CodeCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Code>
 */
class CodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Code::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'code_category_id' => CodeCategory::factory(),
            'approved' => fake()->boolean(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
        ];
    }

    /**
     * Indicate that the code is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'approved' => true,
        ]);
    }
}

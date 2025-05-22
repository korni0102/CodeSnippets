<?php

namespace Database\Factories;

use App\Models\RowCategory;
use App\Models\Snippet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Snippet>
 */
class SnippetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Snippet::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => 'trans.snippet.description.' . fake()->unique()->numberBetween(1000, 9999),
            'row' => fake()->paragraph(),
            'crispdm' => fake()->numberBetween(1, 6),
            'category_id' => RowCategory::factory(),
        ];
    }
}

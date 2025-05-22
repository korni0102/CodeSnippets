<?php

namespace Database\Factories;

use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Translation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => fake()->unique()->word() . '.' . fake()->unique()->word() . '.' . fake()->numberBetween(1, 1000),
            'locale' => 'en',
            'value' => fake()->sentence(),
        ];
    }

    /**
     * Configure the factory to create a snippet translation.
     */
    public function snippetDescription(int $snippetId): static
    {
        return $this->state(fn (array $attributes) => [
            'key' => 'trans.snippet.description.' . $snippetId,
        ]);
    }
}

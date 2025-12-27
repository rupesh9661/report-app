<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Game>
 */
class GameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Game::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'provider_id' => Provider::factory(),
            'name' => fake()->words(2, true) . ' Game',
            'code' => 'GAME_' . fake()->unique()->numberBetween(1000, 9999),
            'category' => fake()->randomElement(['slot', 'casino', 'live-casino', 'sports']),
            'status' => 'active',
        ];
    }

    /**
     * Indicate that the game belongs to a specific provider.
     */
    public function forProvider($provider): static
    {
        return $this->state(fn (array $attributes) => [
            'provider_id' => $provider->id ?? $provider,
        ]);
    }
}

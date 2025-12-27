<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Provider;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'game_id' => Game::factory(),
            'provider_id' => Provider::factory(),
            'transaction_code' => 'TXN' . fake()->unique()->numberBetween(100000, 999999),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'status' => 'success',
            'type' => fake()->randomElement(['bet', 'win', 'refund']),
            'description' => null,
            'transaction_date' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    /**
     * Indicate that the transaction belongs to a specific user.
     */
    public function forUser($user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => is_object($user) ? $user->id : $user,
        ]);
    }

    /**
     * Indicate that the transaction belongs to a specific game.
     */
    public function forGame($game): static
    {
        return $this->state(fn (array $attributes) => [
            'game_id' => is_object($game) ? $game->id : $game,
        ]);
    }

    /**
     * Indicate that the transaction belongs to a specific provider.
     */
    public function forProvider($provider): static
    {
        return $this->state(fn (array $attributes) => [
            'provider_id' => is_object($provider) ? $provider->id : $provider,
        ]);
    }
}

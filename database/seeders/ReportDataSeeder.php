<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Game;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReportDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create providers
        $providers = Provider::factory()->count(5)->create();
        $this->command->info('Created 5 providers');

        // Create games for providers
        foreach ($providers as $provider) {
            Game::factory()
                ->count(10)
                ->forProvider($provider)
                ->create();
        }
        $this->command->info('Created 50 games');

        // Create users if needed
        if (User::count() == 0) {
            User::factory()->count(20)->create();
            $this->command->info('Created 20 users');
        }

        // Get all IDs
        $userIds = User::pluck('id')->toArray();
        $gameIds = Game::pluck('id')->toArray();
        $providerIds = Provider::pluck('id')->toArray();

        // Create transactions
        for ($i = 0; $i < 1000; $i++) {
            Transaction::factory()
                ->forUser($userIds[array_rand($userIds)])
                ->forGame($gameIds[array_rand($gameIds)])
                ->forProvider($providerIds[array_rand($providerIds)])
                ->create();
        }
        $this->command->info('Created 1000 transactions');

        $this->command->info('Report data seeded successfully!');
    }
}

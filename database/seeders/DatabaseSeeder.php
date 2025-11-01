<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => '에스티매이트 코리아',
            'email' => 'admin@estimatekorea.com',
        ]);
        User::factory()->withPersonalTeam()->create([
            'name' => '어드민',
            'email' => 'administrator@estimatekorea.com',
        ]);
        User::factory()->withPersonalTeam()->create([
            'name' => 'editor',
            'email' => 'editor@estimatekorea.com',
        ]);
        $this->call([
            StateSeeder::class,
            CitySeeder::class,
        ]);
    }
}

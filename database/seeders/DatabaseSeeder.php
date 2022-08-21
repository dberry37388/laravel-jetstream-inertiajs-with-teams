<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory()
             ->withPersonalTeam()
             ->create([
                 'name' => 'Test User',
                 'email' => 'test@example.com',
             ]);

         Team::factory()
             ->has(User::factory()
                 ->withPersonalTeam()
                 ->count(10))
             ->create([
                 'user_id' => $user->id
             ]);
    }
}

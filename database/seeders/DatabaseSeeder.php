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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Ziyad User',
            'email' => 'Ziyad2@example.com',
            'password' => 'Test#12345'
        ]);

        User::factory()->create([
            'name' => 'Meshai User',
            'email' => 'Meshari2@example.com',
            'password' => 'Test#12345'
        ]);

        User::factory()->create([
            'name' => 'Fahad User',
            'email' => 'Fahas2@example.com',
            'password' => 'Test#12345'
        ]);

        User::factory()->create([
            'name' => 'Abdullah User',
            'email' => 'Abdullah2@example.com',
            'password' => 'Test#12345'
        ]);

        User::factory()->create([
            'name' => 'Saud User',
            'email' => 'Saud2@example.com',
            'password' => 'Test#12345'
        ]);

        User::factory()->create([
            'name' => 'Faris User',
            'email' => 'Faris2@example.com',
            'password' => 'Test#12345'
        ]);

        $this->call(RecipeSeeder::class);
        $this->call(CategorySeeder::class);

    }
}

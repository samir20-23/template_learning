<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\article;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        article::create([
            'title' => 'article title   ',
            'content' => 'article content',
        ]);
    }
}

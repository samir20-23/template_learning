<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // L’ordre importe : 
        // 1) Création des catégories
        // 2) Création des utilisateurs
        // 3) Création des documents (qui ont besoin des users & categories)
        // 4) Création des validations (qui ont besoin des documents & formateurs)
        $this->call([
            CategoriesSeeder::class,
            UsersSeeder::class,
            DocumentsSeeder::class,
            ValidationSeeder::class,
        ]);
    }
}

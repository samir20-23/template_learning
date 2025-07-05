<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categorie;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Mathematics',
                'description' => 'Cours et exercices de mathématiques (algèbre, géométrie, etc.).',
            ],
            [
                'name'        => 'Physics',
                'description' => 'Ressources liées à la physique (mécanique, optique, etc.).',
            ],
            [
                'name'        => 'Chemistry',
                'description' => 'Documents sur la chimie (organique, inorganique, etc.).',
            ],
            [
                'name'        => 'Computer Science',
                'description' => 'Tutoriels et supports en informatique (programmation, réseaux, etc.).',
            ],
            [
                'name'        => 'Biology',
                'description' => 'Fiches et cours de biologie (cellulaire, anatomie, etc.).',
            ],
            [
                'name'        => 'History',
                'description' => 'Documents historiques et chronologies.',
            ],
            [
                'name'        => 'Languages',
                'description' => 'Cours de langues (anglais, français, espagnol, etc.).',
            ],
        ];

        foreach ($categories as $cat) {
            Categorie::create($cat);
        }
    }
}

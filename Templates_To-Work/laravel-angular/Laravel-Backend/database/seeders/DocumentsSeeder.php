<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\User;
use App\Models\Categorie;
use Faker\Factory as Faker;

class DocumentsSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        // Récupérer tous les IDs de catégories et d'utilisateurs pour la relation
        $allCategoryIds = Categorie::pluck('id')->toArray();
        $allUserIds     = User::pluck('id')->toArray();

        // Générer 25 documents variés
        for ($i = 1; $i <= 25; $i++) {
            $title       = ucfirst($faker->words(3, true));
            $ext         = $faker->fileExtension; // ex: pdf, docx
            $randomPath  = 'uploads/documents/' . $faker->uuid . '.' . $ext;
            $origName    = $title . '.' . $ext;
            $sizeInBytes = $faker->numberBetween(50_000, 5_000_000);
            $mime        = $faker->mimeType;

            Document::create([
                'title'          => $title,
                'type'           => $ext,
                'chemin_fichier' => $randomPath,
                'original_name'  => $origName,
                'file_size'      => $sizeInBytes,
                'mime_type'      => $mime,
                'description'    => $faker->paragraph(2),
                'status'         => $faker->randomElement(['draft', 'published', 'archived']),
                'is_public'      => $faker->boolean(70), // 70% public, 30% private
                'download_count' => $faker->numberBetween(0, 150),
                'categorie_id'   => $faker->randomElement($allCategoryIds),
                'user_id'        => $faker->randomElement($allUserIds),
                'created_at'     => $faker->dateTimeBetween('-3 months', 'now'),
                'updated_at'     => $faker->dateTimeBetween('-2 months', 'now'),
            ]);
        }
    }
}

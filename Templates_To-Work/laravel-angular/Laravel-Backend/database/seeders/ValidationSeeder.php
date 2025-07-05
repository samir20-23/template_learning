<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Validation;
use App\Models\Document;
use App\Models\User;
use Faker\Factory as Faker;

class ValidationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('fr_FR');

        // Récupérer tous les IDs de documents et d'utilisateurs (formateurs)
        $allDocIds      = Document::pluck('id')->toArray();
        $formateurIds   = User::where('role', 'Formateur')->pluck('id')->toArray();

        // Pour chaque document, créer une validation (ou plusieurs si vous voulez)
        foreach ($allDocIds as $docId) {
            Validation::create([
                'document_id'   => $docId,
                'validated_by'  => $faker->randomElement($formateurIds),
                'status'        => $faker->randomElement(['Pending', 'Approved', 'Rejected']),
                'commentaire'   => $faker->boolean(60)
                                    ? $faker->sentence(6)
                                    : null,
                'validated_at'  => $faker->dateTimeBetween('-1 month', 'now'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}

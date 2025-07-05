<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // --- Formateurs ---
        $formateurs = [
            [
                'name'     => 'admin',
                'email'    => 'admin@gmail.com',
                'role'     => 'admin',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'formateur',
                'email'    => 'formateur@gmail.com',
                'role'     => 'Formateur',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Apprenant',
                'email'    => 'Apprenant@gmail.com',
                'role'     => 'User',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($formateurs as $f) {
            User::create($f);
        }

        // --- Apprenants / Utilisateurs ---
        $apprenants = [
            [
                'name'     => 'Youssef Abdellaoui',
                'email'    => 'youssef.abdellaoui@example.com',
                'role'     => 'User',
                'password' => Hash::make('secret123'),
            ],
            [
                'name'     => 'Leila Mansour',
                'email'    => 'leila.mansour@example.com',
                'role'     => 'User',
                'password' => Hash::make('secret123'),
            ],
            [
                'name'     => 'Omar El Fassi',
                'email'    => 'omar.elfassi@example.com',
                'role'     => 'User',
                'password' => Hash::make('secret123'),
            ],
            [
                'name'     => 'Salma Nouri',
                'email'    => 'salma.nouri@example.com',
                'role'     => 'User',
                'password' => Hash::make('secret123'),
            ],
            [
                'name'     => 'Karima El Idrissi',
                'email'    => 'karima.elidrissi@example.com',
                'role'     => 'User',
                'password' => Hash::make('secret123'),
            ],
        ];

        foreach ($apprenants as $u) {
            User::create($u);
        }
    }
}

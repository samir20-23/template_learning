<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    public function run(): void
    {
        About::truncate();

        About::create([
            'title' => 'Who Am I?',
            'description' => 'I’m Samir Aoulad Amar, a passionate full‑stack developer specializing in Laravel & React. With 5+ years of experience, I build performant, scalable apps.',
        ]);
    }
}

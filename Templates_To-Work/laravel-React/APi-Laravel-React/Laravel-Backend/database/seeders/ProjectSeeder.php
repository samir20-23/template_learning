<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::truncate();

        $projects = [
            [
                'title' => 'Portfolio Website',
                'description' => 'A personal portfolio built with Laravel & React to showcase my work.',
                'url' => 'https://samir-portfolio.example.com',
            ],
            [
                'title' => 'E-Commerce Platform',
                'description' => 'Full-featured online store with shopping cart, payments, and admin panel.',
                'url' => 'https://shop.example.com',
            ],
            [
                'title' => 'Blog CMS',
                'description' => 'Headless CMS for blogging, with REST API and React front‑end.',
                'url' => 'https://blog-api.example.com',
            ],
            [
                'title' => 'Chat Application',
                'description' => 'Real‑time chat using WebSockets and Laravel Echo.',
                'url' => null,
            ],
        ];

        foreach ($projects as $p) {
            Project::create($p);
        }
    }
}

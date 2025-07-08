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
                'title'       => 'Personal Portfolio',
                'description' => 'A responsive personal website built to showcase my skills, blog posts, and contact info.',
                'url'         => 'https://samir-portfolio.example.com',
                'repo_url'    => 'https://github.com/samir/portfolio',
                'image_path'  => 'projects/portfolio.png',
                'tech_stack'  => 'Laravel,React,TailwindCSS,Vite',
            ],
            [
                'title'       => 'E‑Commerce Store',
                'description' => 'Full‑featured online store with product catalog, shopping cart, and Stripe payments integration.',
                'url'         => 'https://shop.example.com',
                'repo_url'    => 'https://github.com/samir/ecommerce-store',
                'image_path'  => 'projects/ecommerce.png',
                'tech_stack'  => 'Laravel,Inertia.js,Vue,MySQL,Stripe API',
            ],
            [
                'title'       => 'Chat App',
                'description' => 'Real‑time chat application using WebSockets, complete with user presence and private messaging.',
                'url'         => null,
                'repo_url'    => 'https://github.com/samir/chat-app',
                'image_path'  => 'projects/chat-app.png',
                'tech_stack'  => 'Laravel Echo,Socket.io,React,Redis',
            ],
            [
                'title'       => 'Headless Blog CMS',
                'description' => 'API‑driven blogging platform; headless CMS with React front‑end consuming a Laravel API.',
                'url'         => 'https://blog.example.com',
                'repo_url'    => 'https://github.com/samir/headless-blog',
                'image_path'  => 'projects/headless-blog.png',
                'tech_stack'  => 'Laravel Sanctum,React,Axios,Markdown',
            ],
        ];

        foreach ($projects as $data) {
            Project::create($data);
        }
    }
}

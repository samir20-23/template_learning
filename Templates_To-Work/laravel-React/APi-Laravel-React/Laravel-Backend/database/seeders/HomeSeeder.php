<?php

namespace Database\Seeders;

use App\Models\Home;
use Illuminate\Database\Seeder;

class HomeSeeder extends Seeder
{
    public function run(): void
    {
        Home::create([
            'headline' => "Hi, I'm Samir Aoulad Amar",
            'full_name' => 'Samir Aoulad Amar',
            'location' => 'Tanger, Morocco',
            'bio' => "I'm a passionate full-stack developer from Tanger, Morocco. I specialize in crafting scalable web applications.",
            'cv_url' => 'files/samir_cv.pdf', 
        ]);
    }
}

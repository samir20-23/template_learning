<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        Skill::truncate();

        $skills = [
            ['name' => 'Laravel',       'proficiency' => 90],
            ['name' => 'React',         'proficiency' => 85],
            ['name' => 'JavaScript',    'proficiency' => 95],
            ['name' => 'PHP',           'proficiency' => 88],
            ['name' => 'HTML & CSS',    'proficiency' => 92],
            ['name' => 'Tailwind CSS',  'proficiency' => 80],
            ['name' => 'Node.js',       'proficiency' => 75],
            ['name' => 'MySQL',         'proficiency' => 85],
            ['name' => 'Git & GitHub',  'proficiency' => 90],
            ['name' => 'REST APIs',     'proficiency' => 87],
        ];

        foreach ($skills as $s) {
            Skill::create($s);
        }
    }
}

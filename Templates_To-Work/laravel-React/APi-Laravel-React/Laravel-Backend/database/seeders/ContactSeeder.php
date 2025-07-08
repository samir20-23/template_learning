<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::truncate();

        $contacts = [
            ['type' => 'Email',     'value' => 'samir@example.com',         'icon' => 'mail'],
            ['type' => 'Phone',     'value' => '+212600123456',            'icon' => 'phone'],
            ['type' => 'LinkedIn',  'value' => 'linkedin.com/in/samir',    'icon' => 'linkedin'],
            ['type' => 'GitHub',    'value' => 'github.com/samir',         'icon' => 'github'],
            ['type' => 'Twitter',   'value' => 'twitter.com/samir_dev',    'icon' => 'twitter'],
        ];

        foreach ($contacts as $c) {
            Contact::create($c);
        }
    }
}

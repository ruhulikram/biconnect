<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'UI/UX Design',
            'Graphic Design',
            'Web Development',
            'Android Development',
            'Data Analysis',
            'Copywriting',
            'Video Editing',
            'Social Media Management',
            'Riset & Analisis',
            'Presentasi',
            'Fotografi',
            'Ilustrasi',
            'Konten Kreatif',
            'Akuntansi',
            'Event Organizer',
            'Backend Development',
            'Machine Learning',
            'Mobile Development'
        ];

        foreach ($skills as $skill) {
            Skill::firstOrCreate(['name' => $skill]);
        }
    }
}

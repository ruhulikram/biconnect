<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator BSI',
                'email' => 'admin@biconnect.bsi.ac.id',
                'password' => Hash::make('password123'),
                'nim' => null,
                'program' => 'Staff IT',
                'semester' => null,
                'campus_area' => 'Kramat 98',
                'bio' => 'Akun Administrator Sistem BiConnect.',
                'dark_mode' => false,
                'is_admin' => true,
                'is_verified' => true,
                'onboarding_completed' => true,
            ],
            [
                'name' => 'Ikram Maulana',
                'email' => 'ikram.maulana@bsi.ac.id',
                'password' => Hash::make('password123'),
                'nim' => '12210001',
                'program' => 'Sistem Informasi',
                'semester' => 6,
                'campus_area' => 'Kramat 98',
                'bio' => 'Fullstack Developer. Suka Laravel & Tailwind CSS.',
                'dark_mode' => false,
                'is_admin' => false,
                'is_verified' => true,
                'onboarding_completed' => true,
            ],
            [
                'name' => 'Aditya Wijaya',
                'email' => 'aditya.wijaya@bsi.ac.id',
                'password' => Hash::make('password123'),
                'nim' => '12210002',
                'program' => 'Teknologi Informasi',
                'semester' => 4,
                'campus_area' => 'Margonda',
                'bio' => 'UI/UX Designer enthusiast & Figma lover.',
                'dark_mode' => false,
                'is_admin' => false,
                'is_verified' => true,
                'onboarding_completed' => true,
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@bsi.ac.id',
                'password' => Hash::make('password123'),
                'nim' => '12210003',
                'program' => 'Rekayasa Perangkat Lunak',
                'semester' => 6,
                'campus_area' => 'Cengkareng',
                'bio' => 'Mobile Developer learning Flutter & React Native.',
                'dark_mode' => false,
                'is_admin' => false,
                'is_verified' => false,
                'onboarding_completed' => true,
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@bsi.ac.id',
                'password' => Hash::make('password123'),
                'nim' => '12210004',
                'program' => 'Sistem Informasi',
                'semester' => 2,
                'campus_area' => 'Jatiwaringin',
                'bio' => 'Junior Web Developer. Sedang belajar PHP dasar.',
                'dark_mode' => false,
                'is_admin' => false,
                'is_verified' => true,
                'onboarding_completed' => true,
            ]
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}

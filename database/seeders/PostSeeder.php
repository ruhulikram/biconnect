<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Skills
        $skillsData = [
            'Laravel', 'Vue.js', 'React', 'Tailwind CSS', 'Figma', 
            'Flutter', 'Python', 'MySQL', 'PHP', 'Alpine.js', 'Git'
        ];
        
        $skills = [];
        foreach ($skillsData as $name) {
            $skills[] = Skill::firstOrCreate(['name' => $name]);
        }

        // 2. Create Users (Students of BSI)
        $usersInfo = [
            [
                'name' => 'Ikram Maulana',
                'email' => 'ikram.maulana@bsi.ac.id',
                'password' => Hash::make('password123'),
                'nim' => '12210001',
                'program' => 'Sistem Informasi',
                'semester' => 6,
                'campus_area' => 'Kramat 98',
                'bio' => 'Fullstack Developer. Suka Laravel & Tailwind CSS.',
                'is_verified' => true,
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
                'is_verified' => true,
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
                'is_verified' => false,
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
                'is_verified' => true,
            ]
        ];

        $seededUsers = [];
        foreach ($usersInfo as $userInfo) {
            $seededUsers[] = User::firstOrCreate(['email' => $userInfo['email']], $userInfo);
        }

        // 3. Create Posts (Discussions & Projects)
        
        // Discussion 1
        $disc1 = Post::create([
            'user_id' => $seededUsers[0]->id,
            'type' => 'discussion',
            'title' => 'Bagaimana cara setup Vite dengan Tailwind CSS v3 di Laravel 11?',
            'body' => "Halo teman-teman BSI! Saya sedang mencoba mengintegrasikan Vite dengan Tailwind CSS v3 di project Laravel baru saya. Tapi ketika saya jalankan npm run dev, stylenya tidak masuk/tidak ter-load. \n\nApakah ada konfigurasi khusus di tailwind.config.js atau vite.config.js yang terlewat? Terima kasih sebelumnya!",
            'campus_area' => 'Kramat 98',
            'is_active' => true,
        ]);
        // attach skills
        $disc1->skills()->attach([$skills[0]->id, $skills[3]->id]);
        
        // Discussion 2
        $disc2 = Post::create([
            'user_id' => $seededUsers[2]->id,
            'type' => 'discussion',
            'title' => 'Rekomendasi topik Skripsi RPL BSI yang berfokus ke Mobile App',
            'body' => "Permisi kak, saya semester 6 prodi RPL Kampus Cengkareng. Sedang mempersiapkan judul skripsi untuk semester depan. Rencananya mau buat aplikasi mobile. \n\nKira-kira topik apa ya yang sedang tren dan berpeluang besar diterima oleh dosen pembimbing? Apakah aplikasi e-learning, marketplace, atau smart city?",
            'campus_area' => 'Cengkareng',
            'is_active' => true,
        ]);
        $disc2->skills()->attach([$skills[5]->id]);

        // Project 1
        $proj1 = Post::create([
            'user_id' => $seededUsers[0]->id,
            'type' => 'project',
            'title' => 'Dicari Partner UI/UX Designer untuk Project BiConnect',
            'body' => "Kami sedang membangun platform BiConnect menggunakan Laravel dan Alpine.js. Saat ini kami membutuhkan partner Designer untuk merancang mockup antarmuka pengguna agar lebih premium, modern, dan responsive.\n\nProject ini bersifat portfolio untuk skripsi, tapi jika hasil kerja memuaskan kita bisa kembangkan ke ranah komersial. Ditunggu kolaborasinya!",
            'deadline' => now()->addDays(14),
            'campus_area' => 'Kramat 98',
            'project_type' => 'portfolio',
            'is_active' => true,
        ]);
        $proj1->skills()->attach([$skills[4]->id, $skills[9]->id]);

        // Project 2
        $proj2 = Post::create([
            'user_id' => $seededUsers[1]->id,
            'type' => 'project',
            'title' => 'Project Aplikasi Kasir (POS) UMKM Kuliner Margonda',
            'body' => "Dibutuhkan developer backend Laravel untuk membantu menyelesaikan modul inventory dan integrasi payment gateway pada aplikasi kasir UMKM. Desain UI/UX sudah selesai di Figma. \n\nProject ini berbayar (Paid) dengan sistem bagi hasil atau borongan. Diutamakan mahasiswa domisili Depok agar mudah koordinasi offline.",
            'deadline' => now()->addDays(7),
            'campus_area' => 'Margonda',
            'project_type' => 'paid',
            'is_active' => true,
        ]);
        $proj2->skills()->attach([$skills[0]->id, $skills[7]->id]);
        
        // Project 3
        $proj3 = Post::create([
            'user_id' => $seededUsers[3]->id,
            'type' => 'project',
            'title' => 'Belajar Kelompok Membuat Mobile Flutter App Sukarela',
            'body' => "Halo! Saya ingin membuat project iseng-iseng untuk belajar Flutter bareng. Targetnya adalah membuat clone aplikasi to-do list sederhana dengan integrasi Firebase.\n\nSifatnya unpaid (sukarela) untuk sama-sama belajar dari dasar. Siapa saja boleh gabung!",
            'deadline' => now()->addDays(20),
            'campus_area' => 'Jatiwaringin',
            'project_type' => 'unpaid',
            'is_active' => true,
        ]);
        $proj3->skills()->attach([$skills[5]->id]);

        // 4. Create Comments
        $comment1 = \App\Models\Comment::create([
            'post_id' => $disc1->id,
            'user_id' => $seededUsers[1]->id,
            'body'    => 'Coba pastikan di tailwind.config.js content-nya pointing ke resources/**/*.blade.php, saya juga pernah stuck di masalah ini!',
        ]);

        \App\Models\Comment::create([
            'post_id'   => $disc1->id,
            'user_id'   => $seededUsers[0]->id,
            'parent_id' => $comment1->id,
            'body'      => 'Terima kasih kak Aditya! Ternyata emang path content-nya yang salah. Sudah fixed sekarang 🎉',
        ]);

        \App\Models\Comment::create([
            'post_id' => $disc1->id,
            'user_id' => $seededUsers[3]->id,
            'body'    => 'Mantap, saya juga baru mulai pakai Tailwind. Bookmark dulu buat referensi.',
        ]);

        \App\Models\Comment::create([
            'post_id' => $proj1->id,
            'user_id' => $seededUsers[1]->id,
            'body'    => 'Saya tertarik nih kak! Saya biasa pakai Figma dan sudah beberapa kali handle desain app mobile. Boleh diskusi lebih lanjut?',
        ]);

        $comment5 = \App\Models\Comment::create([
            'post_id' => $proj1->id,
            'user_id' => $seededUsers[2]->id,
            'body'    => 'Apakah masih open? Saya punya pengalaman di UI/UX research juga.',
        ]);

        \App\Models\Comment::create([
            'post_id'   => $proj1->id,
            'user_id'   => $seededUsers[0]->id,
            'parent_id' => $comment5->id,
            'body'      => 'Masih open kak, silakan! Nanti kita bisa bikin grup WA untuk koordinasi.',
        ]);

        \App\Models\Comment::create([
            'post_id' => $proj2->id,
            'user_id' => $seededUsers[0]->id,
            'body'    => 'Budget range-nya berapa ya kak? Dan estimasi waktu pengerjaannya berapa lama?',
        ]);

        // 5. Create Post Interests
        \App\Models\PostInterest::create(['post_id' => $proj1->id, 'user_id' => $seededUsers[1]->id]);
        \App\Models\PostInterest::create(['post_id' => $proj1->id, 'user_id' => $seededUsers[2]->id]);
        \App\Models\PostInterest::create(['post_id' => $proj1->id, 'user_id' => $seededUsers[3]->id]);
        \App\Models\PostInterest::create(['post_id' => $proj2->id, 'user_id' => $seededUsers[0]->id]);
        \App\Models\PostInterest::create(['post_id' => $proj3->id, 'user_id' => $seededUsers[0]->id]);
        \App\Models\PostInterest::create(['post_id' => $proj3->id, 'user_id' => $seededUsers[2]->id]);
    }
}

# PRD.md – BiConnect Product Requirements Document (Implementasi & Status)

> Based on GEMINI.md v1.0 + client feedback  
> Target Stack: Laravel Blade, Vite, Tailwind CSS v3, Alpine.js  
> Document Version: 3.0 – 2026-06-25 (Status: 100% Selesai Diimplementasikan)

---

## 1. Executive Summary

BiConnect adalah platform kolaborasi mahasiswa BSI. Dokumen ini mendokumentasikan status implementasi fitur dan perbaikan UI/UX setelah seluruh persyaratan berhasil diselesaikan. Seluruh fungsionalitas utama yang direncanakan telah diuji dan berjalan dengan baik pada lingkungan pengembangan:

- **Perbaikan Elemen UI/UX Global**: Tata letak Forgot Password, logo footer terpadu, dan konsistensi logo pada halaman auth.
- **Redesign Landing Page**: Carousel vertikal interaktif (swipe & scroll), section features natural dengan ikon custom statis.
- **Feed 3 Kolom (Desktop)**: Tata letak kolom responsif dengan panel filter permanen di sisi kiri dan Information Hub di sisi kanan.
- **Pencarian Realtime**: Pencarian asinkron berbasis modal dengan autocomplete (membatasi min. 2 karakter, debounce 300ms).
- **Aksi Cepat di Feed**: Tombol pembuatan proyek diletakkan langsung di atas feed utama untuk kemudahan akses.
- **Penyempurnaan Profil**: Posisi foto profil non-overlapping di atas banner dan dukungan integrasi tautan media sosial.

---

## 2. Scope & Hasil Implementasi

### 2.1 Tujuan Tercapai
- Mengoptimalkan interaksi pengguna (UX) pada fitur inti (Feed, Pencarian, Profil).
- Menyediakan modul administrasi khusus untuk mempublikasikan poster informasi kampus dengan rasio 3:4.
- Membuka akses interaksi eksternal melalui penyematan media sosial terverifikasi pada profil mahasiswa.

### 2.2 Batasan Sistem (Out of Scope)
- Sinkronisasi otomatis dengan basis data SIAKAD BSI (pendaftaran tetap menggunakan email kampus resmi `@bsi.ac.id` via OTP).

---

## 3. Persyaratan Fungsional & Status Detail

### 3.1 Auth & Layout Global

| ID | Kebutuhan | Kriteria Penerimaan | Status | File / Elemen Implementasi |
|----|-------------|----------------------|--------|----------------------------|
| A-1 | Posisi "Forgot Password" di login harus tepat di bawah tombol login. | Link lupa password tampil setelah tombol login, rata tengah, dan tidak bertabrakan dengan elemen input. | **Selesai** | [login.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/auth/login.blade.php) |
| A-2 | Logo footer menggunakan file `biconnect-logo.png`. | Footer menggunakan asset `images/biconnect-logo.png` dengan efek filter brightness-0 invert agar menyatu dengan latar belakang gelap. | **Selesai** | [footer.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/components/footer.blade.php) |
| A-3 | Logo pada halaman aktivasi dan login menggunakan logo terpadu. | Seluruh halaman auth menggunakan logo resmi dari path `public/images/biconnect-logo.png`. | **Selesai** | [activate.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/auth/activate.blade.php), [login.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/auth/login.blade.php) |

---

### 3.2 Landing Page Redesign

| ID | Kebutuhan | Kriteria Penerimaan | Status | File / Elemen Implementasi |
|----|-------------|----------------------|--------|----------------------------|
| L-1 | Hero section berisi carousel vertikal (3 slide) dengan fungsi swipe dan scroll. | Carousel berjalan otomatis (interval 5 detik) dan merespons gesture swipe up/down (mobile) serta event wheel (desktop). | **Selesai** | [landing.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/landing.blade.php) (Alpine.js `heroCarousel()`) |
| L-2 | Penggunaan gambar asli fitur pada folder `public/storage/icon`. | Mengganti icon generik AI dengan gambar aset tetap: `idea.png`, `group.png`, dan `deal.png`. | **Selesai** | [landing.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/landing.blade.php) |
| L-3 | Estetika natural dan konsisten dengan panduan brand. | Mengurangi gradasi warna berlebihan, menyelaraskan tipografi Plus Jakarta Sans, dan menjaga keselarasan tombol. | **Selesai** | [landing.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/landing.blade.php) |

---

### 3.3 Feed (Setelah Login) – Tata Ulang Layout Desktop

Untuk layar desktop (viewport $\ge 1024\text{px}$), feed menggunakan susunan **3 kolom** untuk efisiensi ruang:

*   **Kolom Kiri (Lebar 280px)**: **Filter Panel Permanen** ([feed-filters.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/components/feed-filters.blade.php)) — Memungkinkan penyaringan berdasarkan Tipe Post, Area Kampus, Kategori Project, Keahlian (Skills), dan Urutan (Terbaru/Populer).
*   **Kolom Tengah (Fleksibel)**: **Feed Content** — Berisi tab kategori utama, tombol buat postingan, dan daftar kartu post/diskusi.
*   **Kolom Kanan (Lebar 280px)**: **Information Hub** ([info-hub.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/components/info-hub.blade.php)) — Menampilkan poster informasi kampus (rasio 3:4) yang diunggah oleh administrator.

*Catatan UX: Penempatan panel filter di sebelah kiri dilakukan untuk mengikuti pola membaca pengguna (F-shaped pattern) sehingga pencarian parameter menjadi lebih intuitif.*

| ID | Kebutuhan | Kriteria Penerimaan | Status | File / Elemen Implementasi |
|----|-------------|----------------------|--------|----------------------------|
| F-1 | Tombol pencarian (Search) di navbar berfungsi. | Menampilkan modal pencarian asinkron yang melayang (backdrop blur). Melakukan kueri dinamis untuk post dan user. | **Selesai** | [search.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/components/modals/search.blade.php), [SearchController.php](file:///c:/Umar/Skripsi/biconnect/app/Http/Controllers/SearchController.php) |
| F-2 | Filter samping permanen pada layar desktop. | Tombol pemicu bottom sheet disembunyikan di desktop. Parameter filter terpasang langsung di sidebar kiri. | **Selesai** | [feed/index.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/feed/index.blade.php), [feed-filters.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/components/feed-filters.blade.php) |
| F-3 | Manajemen poster admin (Information Hub). | Admin memiliki kendali CRUD penuh atas poster hub di dashboard admin, termasuk opsi menonaktifkan poster secara temporer. | **Selesai** | [InfoHubController.php](file:///c:/Umar/Skripsi/biconnect/app/Http/Controllers/InfoHubController.php), [AdminController.php](file:///c:/Umar/Skripsi/biconnect/app/Http/Controllers/AdminController.php) |
| F-4 | Tombol buat postingan di atas feed utama. | Tombol "+ Buat Project / Diskusi" terintegrasi di atas daftar feed pada seluruh ukuran layar. | **Selesai** | [feed/index.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/feed/index.blade.php) |
| F-5 | Filter panel realtime tanpa reload paksa. | Perubahan parameter filter pada desktop langsung diarahkan kembali dengan parameter URL query yang bersih. | **Selesai** | [feed-filters.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/components/feed-filters.blade.php), [FeedController.php](file:///c:/Umar/Skripsi/biconnect/app/Http/Controllers/FeedController.php) |

---

### 3.4 Profile – Banner & Social Media

| ID | Kebutuhan | Kriteria Penerimaan | Status | File / Elemen Implementasi |
|----|-------------|----------------------|--------|----------------------------|
| P-1 | Tata letak foto profil tidak tertutup banner. | Foto profil diletakkan dengan teknik overlapping terkendali menggunakan negative margin (`-mt-[40px]`) dan `z-index` yang tepat. | **Selesai** | [profile/show.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/profile/show.blade.php) |
| P-2 | Fitur Tautan Media Sosial Pengguna. | Mendukung LinkedIn, GitHub, Instagram, Twitter/X, dan Personal Website. Dapat diupdate melalui formulir edit profil. | **Selesai** | [profile/edit.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/profile/edit.blade.php), [SocialLink.php](file:///c:/Umar/Skripsi/biconnect/app/Models/SocialLink.php) |
| P-3 | Penyajian ikon sosial media berkualitas tinggi. | Ikon dirender menggunakan jalur SVG inline kustom dengan efek transisi warna hover yang spesifik untuk tiap platform. | **Selesai** | [social-links.blade.php](file:///c:/Umar/Skripsi/biconnect/resources/views/components/social-links.blade.php) |

---

## 4. Arsitektur Teknis & Struktur Data Aktual

### 4.1 Registrasi Rute (Routing)
Rute-rute baru yang didaftarkan pada berkas [web.php](file:///c:/Umar/Skripsi/biconnect/routes/web.php) meliputi:
- **Pencarian**: `Route::get('/search', [SearchController::class, 'search'])`
- **Tautan Sosial**: Ditangani di dalam pembaruan profil terpadu `Route::put('/profile', [ProfileController::class, 'update'])`
- **Poster Admin**:
  - `Route::post('/info-hub', [InfoHubController::class, 'store'])`
  - `Route::put('/info-hub/{infoHub}', [InfoHubController::class, 'update'])`
  - `Route::delete('/info-hub/{infoHub}', [InfoHubController::class, 'destroy'])`
  - `Route::post('/info-hub/{infoHub}/toggle', [InfoHubController::class, 'toggleActive'])`

### 4.2 Skema Migrasi Database Aktual
Berikut adalah skema tabel basis data fisik yang terbentuk:

#### 1. Tabel Poster Informasi (`info_hub`)
Tabel ini digunakan oleh administrator untuk menyimpan data poster promosi/kegiatan internal kampus.
Berkas migrasi: [2026_06_11_000001_create_info_hub_table.php](file:///c:/Umar/Skripsi/biconnect/database/migrations/2026_06_11_000001_create_info_hub_table.php)
```php
Schema::create('info_hub', function (Blueprint $table) {
    $table->id();
    $table->string('title')->nullable();
    $table->string('poster_image')->nullable();
    $table->string('poster_link')->nullable();
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

#### 2. Tabel Tautan Media Sosial (`social_links`)
Tabel relasional untuk menyimpan tautan akun media sosial mahasiswa.
Berkas migrasi: [2026_06_11_000002_create_social_links_table.php](file:///c:/Umar/Skripsi/biconnect/database/migrations/2026_06_11_000002_create_social_links_table.php)
```php
Schema::create('social_links', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('platform'); // linkedin, github, instagram, twitter, website
    $table->string('url');
    $table->timestamps();

    $table->unique(['user_id', 'platform']);
});
```
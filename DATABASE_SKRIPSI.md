# 2.1.6 Basis Data (Database)

Basis data atau database adalah kumpulan data yang tersimpan secara sistematis dan terorganisir di dalam komputer sehingga dapat diakses, dikelola, dan diperbarui dengan mudah menggunakan perangkat lunak khusus. Menurut Aulia et al. (2023), jaringan komputer dan basis data memiliki peran yang krusial di era digital, di mana basis data menjadi fondasi utama bagi hampir semua sistem informasi modern. Tanpa adanya basis data yang dirancang secara baik, sebuah sistem informasi tidak akan mampu menyimpan, memproses, dan menyajikan data secara cepat, akurat, dan efektif.

Dalam penelitian ini, *Database Management System* (DBMS) yang digunakan untuk mengimplementasikan sistem BiConnect adalah **MySQL** (dengan menggunakan engine penyimpanan **InnoDB**). MySQL dipilih karena merupakan DBMS relasional (*Relational Database Management System* / RDBMS) berkinerja tinggi, bersifat *open-source*, memiliki tingkat keandalan yang tinggi, serta memiliki kompatibilitas yang sangat baik dengan kerangka kerja Laravel melalui *Eloquent Object-Relational Mapping* (ORM). Penggunaan engine InnoDB menjamin integritas data melalui dukungan penuh terhadap transaksi database (*ACID compliance*) serta penegakan kunci asing (*foreign key constraints*) untuk menjaga konsistensi hubungan antar-entitas.

---

## 1. Struktur Tabel dan Skema Basis Data

Sistem BiConnect menggunakan 14 tabel utama dalam database untuk mengelola data pengguna, postingan, keahlian, ketertarikan proyek, hingga sistem verifikasi OTP. Berikut adalah rincian struktur tabel beserta tipe data dan penjelasannya:

### 1. Tabel `users`
Tabel ini digunakan untuk menyimpan data profil pengguna, baik mahasiswa Universitas Bina Sarana Informatika maupun akun administrator.
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kolom**:
  * `name` (VarChar 255): Nama lengkap pengguna.
  * `email` (VarChar 255, Unique): Alamat email kampus BSI (`@bsi.ac.id` atau `@student.bsi.ac.id`).
  * `password` (VarChar 255): Hash kata sandi pengguna (didekripsi dengan algoritma bcrypt).
  * `nim` (VarChar 20, Unique, Nullable): Nomor Induk Mahasiswa.
  * `program` (VarChar 100, Nullable): Program studi mahasiswa.
  * `semester` (TinyInt, Unsigned, Nullable): Semester aktif mahasiswa saat ini.
  * `campus_area` (VarChar 100, Nullable): Lokasi cabang kampus BSI mahasiswa.
  * `bio` (Text, Nullable): Deskripsi singkat mengenai keahlian atau pengenalan diri.
  * `whatsapp` (VarChar 20, Nullable): Nomor kontak WhatsApp aktif.
  * `avatar` (VarChar 255, Nullable): Path berkas foto profil pengguna.
  * `cover` (VarChar 255, Nullable): Path berkas foto sampul profil pengguna.
  * `dark_mode` (Boolean, Default: false): Pengaturan tema antarmuka (terang/gelap).
  * `is_admin` (Boolean, Default: false): Flag penanda apakah pengguna memiliki hak akses administrator.
  * `is_active` (Boolean, Default: true): Status keaktifan akun pengguna.
  * `is_verified` (Boolean, Default: false): Flag penanda akun mahasiswa yang telah memverifikasi email kampusnya.
  * `onboarding_completed` (Boolean, Default: false): Flag penanda apakah pengguna sudah menyelesaikan pengisian data keahlian awal.
  * `created_at` & `updated_at` (Timestamp): Waktu pembuatan dan pembaruan baris data.

### 2. Tabel `posts`
Tabel ini menyimpan data postingan yang dibuat oleh pengguna, yang terbagi menjadi dua kategori utama: diskusi umum (`discussion`) dan proyek kolaborasi (`project`).
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kunci Asing (Foreign Key)**: `user_id` relasi ke tabel `users(id)`
* **Kolom**:
  * `user_id` (BigInt, Indexed): ID pembuat postingan.
  * `type` (Enum: 'discussion', 'project'): Kategori postingan.
  * `title` (VarChar 255): Judul diskusi atau proyek.
  * `body` (Text): Isi atau detail dari postingan.
  * `image` (VarChar 255, Nullable): Path berkas gambar poster proyek atau lampiran diskusi.
  * `deadline` (Date, Nullable): Batas akhir pendaftaran proyek (hanya berlaku jika tipe adalah 'project').
  * `campus_area` (VarChar 100, Nullable): Lokasi kampus fokus proyek.
  * `project_type` (VarChar 100, Nullable): Kategori tipe pengerjaan proyek (misal: Tugas Akhir, Skripsi, Lomba).
  * `is_active` (Boolean, Default: true): Status tayang postingan di halaman feed.
  * `status` (Enum: 'pending', 'approved', 'rejected', 'closed', Default: 'pending'): Status persetujuan/siklus proyek.
  * `created_at` & `updated_at` (Timestamp).

### 3. Tabel `skills`
Tabel master untuk menyimpan daftar keahlian/kompetensi teknologi informasi (misal: Laravel, UI/UX Design, Flutter, Python).
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kolom**:
  * `name` (VarChar 100, Unique): Nama keahlian.
  * `created_at` & `updated_at` (Timestamp).

### 4. Tabel `user_skills` (Tabel Pivot Relasi Many-to-Many)
Menghubungkan entitas `users` dengan `skills` untuk merepresentasikan daftar keahlian yang dikuasai oleh seorang mahasiswa.
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kunci Asing (Foreign Key)**: 
  * `user_id` relasi ke tabel `users(id)` dengan aksi `ON DELETE CASCADE`
  * `skill_id` relasi ke tabel `skills(id)` dengan aksi `ON DELETE CASCADE`

### 5. Tabel `post_skills` (Tabel Pivot Relasi Many-to-Many)
Menghubungkan entitas `posts` bertipe 'project' dengan `skills` untuk mendefinisikan persyaratan keahlian yang dibutuhkan untuk bergabung ke proyek tersebut.
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kunci Asing (Foreign Key)**: 
  * `post_id` relasi ke tabel `posts(id)` dengan aksi `ON DELETE CASCADE`
  * `skill_id` relasi ke tabel `skills(id)` dengan aksi `ON DELETE CASCADE`

### 6. Tabel `post_interests`
Menyimpan data ketertarikan (*apply*) dari mahasiswa pelamar yang ingin bergabung ke proyek kolaborasi tertentu.
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kunci Asing (Foreign Key)**:
  * `post_id` relasi ke tabel `posts(id)` dengan aksi `ON DELETE CASCADE`
  * `user_id` relasi ke tabel `users(id)` dengan aksi `ON DELETE CASCADE`
* **Kolom**:
  * `status` (Enum: 'pending', 'selected', Default: 'pending'): Status pelamar dalam proyek (menunggu atau terpilih/diterima).

### 7. Tabel `comments`
Tabel ini digunakan untuk mengelola fitur komentar pada diskusi maupun proyek kolaborasi. Tabel ini juga mendukung struktur komentar bersarang (*nested comments*) melalui relasi mandiri (*self-referencing*).
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kunci Asing (Foreign Key)**:
  * `post_id` relasi ke tabel `posts(id)` dengan aksi `ON DELETE CASCADE`
  * `user_id` relasi ke tabel `users(id)` dengan aksi `ON DELETE CASCADE`
  * `parent_id` (Nullable) relasi ke tabel `comments(id)` dengan aksi `ON DELETE CASCADE`
* **Kolom**:
  * `body` (Text): Konten pesan komentar.

### 8. Tabel `post_likes`
Menyimpan data kesukaan (*like*) dari pengguna terhadap postingan diskusi maupun proyek.
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kunci Asing (Foreign Key)**:
  * `post_id` relasi ke tabel `posts(id)` dengan aksi `ON DELETE CASCADE`
  * `user_id` relasi ke tabel `users(id)` dengan aksi `ON DELETE CASCADE`

### 9. Tabel `follows`
Tabel relasi sosial yang mencatat hubungan pengikut (*followers*) dan yang diikuti (*following*) antar-pengguna dalam sistem.
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kunci Asing (Foreign Key)**:
  * `follower_id` relasi ke tabel `users(id)` dengan aksi `ON DELETE CASCADE`
  * `following_id` relasi ke tabel `users(id)` dengan aksi `ON DELETE CASCADE`

### 10. Tabel `campuses`
Tabel master yang menampung daftar cabang kampus Universitas Bina Sarana Informatika beserta pembagian wilayah regionalnya.
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kolom**:
  * `code` (VarChar 50, Unique): Kode unik singkatan kampus (misal: K98, MRD).
  * `name` (VarChar 150): Nama lengkap cabang kampus BSI.
  * `region` (VarChar 100): Wilayah regional kampus (misal: Jakarta Pusat, Depok).

### 11. Tabel `social_links`
Tabel pendukung profil untuk menyimpan link akun media sosial (LinkedIn, GitHub, Instagram, dll.) milik mahasiswa.
* **Kunci Utama (Primary Key)**: `id` (BigInt, Auto Increment)
* **Kunci Asing (Foreign Key)**: `user_id` relasi ke tabel `users(id)` dengan aksi `ON DELETE CASCADE`
* **Kolom**:
  * `platform` (VarChar 50): Nama platform sosial (LinkedIn, GitHub, dll).
  * `url` (VarChar 255): Tautan profil media sosial pengguna.

### 12. Tabel `otp_verifications` & `email_verification_tokens`
Tabel log keamanan untuk mencatat pengiriman kode OTP verifikasi email mahasiswa.
* **Kolom**:
  * `email` (VarChar 255)
  * `code` / `token` (VarChar 255)
  * `expires_at` (Timestamp): Batas kedaluwarsa kode verifikasi.
  * `used_at` (Timestamp, Nullable): Waktu kode tersebut digunakan.

### 13. Tabel `notifications`
Tabel terintegrasi untuk menyimpan data notifikasi sistem (seperti approval proyek, ketertarikan kandidat, dll.) dengan arsitektur polymorphic bawaan Laravel.
* **Kolom**:
  * `id` (UUID, Primary Key)
  * `type` (VarChar 255): Nama kelas notifikasi terkait.
  * `notifiable_type` & `notifiable_id` (Polymorphic): Model penerima notifikasi (biasanya mengarah ke `users`).
  * `data` (Text/JSON): Informasi pesan notifikasi dalam format JSON.
  * `read_at` (Timestamp, Nullable): Waktu notifikasi dibaca.

---

## 2. Hubungan Antar-Entitas (Entity Relationship / Relational Mapping)

Perancangan basis data BiConnect didasarkan pada hubungan (*relationship*) antar tabel yang saling terintegrasi erat:

1. **Relasi Satu-ke-Banyak (One-to-Many)**:
   * **`users` ➔ `posts`**: Satu pengguna dapat membuat banyak postingan diskusi maupun proyek, tetapi satu postingan hanya dimiliki oleh satu pembuat.
   * **`users` ➔ `comments`**: Satu pengguna dapat menulis banyak komentar.
   * **`posts` ➔ `comments`**: Satu postingan dapat memiliki banyak komentar dari pengguna yang berbeda.
   * **`users` ➔ `social_links`**: Satu pengguna dapat menghubungkan beberapa akun media sosial ke profil mereka.

2. **Relasi Banyak-ke-Banyak (Many-to-Many)**:
   * **`users` ➔ `skills` (melalui pivot `user_skills`)**: Seorang pengguna dapat memiliki banyak keahlian, dan satu keahlian dapat dikuasai oleh banyak pengguna.
   * **`posts` ➔ `skills` (melalui pivot `post_skills`)**: Sebuah proyek dapat membutuhkan banyak keahlian prasyarat, dan satu keahlian dapat disyaratkan oleh banyak proyek.
   * **`users` ➔ `users` (melalui pivot `follows` - self-referencing Many-to-Many)**: Seorang pengguna dapat diikuti oleh banyak pengguna lain (*followers*), dan dapat mengikuti banyak pengguna lain (*following*).
   * **`users` ➔ `posts` (melalui pivot `post_likes`)**: Banyak pengguna dapat menyukai banyak postingan.
   * **`users` ➔ `posts` (melalui pivot `post_interests`)**: Banyak pengguna dapat mendaftar/tertarik pada banyak proyek kolaborasi.

3. **Relasi Bersarang (Self-Referencing / Hierarchical Relationship)**:
   * **`comments` ➔ `comments`**: Kolom `parent_id` pada tabel `comments` merujuk kembali ke kolom `id` pada tabel `comments` itu sendiri. Ini memungkinkan implementasi balasan komentar (*nested reply*) di dalam sistem.

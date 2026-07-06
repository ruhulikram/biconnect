BAB IV
IMPLEMENTASI DAN PENGUJIAN SOFTWARE

Pada bab ini penulis akan membahas tahap implementasi dari rancangan yang telah disusun pada bab sebelumnya. Setelah analisis kebutuhan dan perancangan algoritma selesai dilakukan, langkah berikutnya yaitu menerjemahkan rancangan tersebut menjadi sebuah perangkat lunak yang nyata dan dapat dijalankan. Sesuai dengan metode Waterfall yang dipakai, tahap implementasi ini berada setelah tahap desain dan sebelum tahap pengujian. Adapun pembahasan pada bab ini mencakup desain sistem (basis data, arsitektur, dan antarmuka), pembangkitan kode (code generation), pengujian, serta spesifikasi pendukung yang dibutuhkan supaya sistem BiConnect dapat beroperasi dengan baik.

4.1 Design

Tahap desain menjadi jembatan antara hasil analisis kebutuhan dengan kode program yang sesungguhnya. Di sini penulis menuangkan rancangan basis data, gambaran arsitektur perangkat lunak, serta tampilan antarmuka yang nantinya akan digunakan oleh mahasiswa pengguna sistem BiConnect. Ketiga aspek tersebut saling berkaitan satu sama lain, dimana struktur basis data menjadi fondasi penyimpanan data, arsitektur menjelaskan bagaimana komponen sistem saling bekerja, dan antarmuka menjadi titik temu antara pengguna dengan sistem.

4.1.1 Basis Data

Basis data pada sistem BiConnect dirancang menggunakan MySQL dengan pendekatan relasional. Pemilihan basis data relasional didasari pertimbangan bahwa data pada sistem ini memiliki keterhubungan yang jelas antar entitas, misalnya antara pengguna dengan postingan, postingan dengan komentar, dan pengguna dengan keahlian (skill). Hal ini membuat model relasional jadi pilihan yang tepat untuk menjaga integritas data. Untuk menggambarkan keterhubungan antar entitas tersebut, penulis menggunakan Entity Relationship Diagram (ERD) dan Logical Record Structure (LRS).

A. Entity Relationship Diagram (ERD)

ERD digunakan untuk menggambarkan hubungan antar entitas beserta atribut yang dimiliki masing-masing entitas di dalam sistem. Secara garis besar, entitas inti pada sistem BiConnect terdiri dari pengguna (users), postingan (posts), komentar (comments), dan keahlian (skills). Entitas-entitas tersebut kemudian dihubungkan oleh sejumlah tabel relasi seperti user_skills, post_skills, post_likes, dan post_interests untuk merepresentasikan hubungan banyak-ke-banyak (many to many). Adapun relasi utama yang terbentuk dapat dijelaskan sebagai berikut:

1. Satu pengguna (users) dapat membuat banyak postingan (posts), sehingga relasinya bersifat one to many.
2. Satu postingan (posts) dapat memiliki banyak komentar (comments), dan satu komentar dapat memiliki banyak balasan melalui atribut parent_id (relasi rekursif satu tingkat).
3. Satu pengguna dapat memiliki banyak keahlian, dan satu keahlian dapat dimiliki oleh banyak pengguna, yang mana hal tersebut direpresentasikan melalui tabel relasi user_skills (many to many).
4. Satu postingan proyek dapat membutuhkan banyak keahlian melalui tabel post_skills, dan satu pengguna dapat menyatakan ketertarikan pada banyak postingan melalui tabel post_interests.
5. Pengguna juga dapat saling mengikuti (follow) pengguna lain yang direkam pada tabel follows.

[Gambar IV.1 Entity Relationship Diagram (ERD) Sistem BiConnect]

(Catatan: gambar ERD dapat di-export langsung dari dbdiagram.io menggunakan berkas database.dbml yang telah disusun.)

B. Logical Record Structure (LRS)

Logical Record Structure (LRS) merupakan hasil transformasi dari ERD ke dalam bentuk struktur tabel beserta kunci primer (primary key) dan kunci tamu (foreign key) yang menghubungkan antar tabel. Melalui LRS, dapat terlihat dengan jelas bagaimana setiap tabel saling terhubung melalui field penghubung. Sebagai contoh, tabel posts memiliki field user_id sebagai foreign key yang merujuk ke field id pada tabel users. Begitu pula tabel comments yang memiliki dua foreign key, yaitu post_id yang merujuk ke posts dan user_id yang merujuk ke users, serta parent_id yang merujuk ke tabel comments itu sendiri untuk fitur balasan komentar.

[Gambar IV.2 Logical Record Structure (LRS) Sistem BiConnect]


4.1.2 Arsitektur Software

Sistem BiConnect dibangun di atas framework Laravel yang menerapkan pola arsitektur Model-View-Controller (MVC). Pola ini memisahkan logika aplikasi menjadi tiga lapisan utama supaya kode lebih terstruktur dan mudah dirawat. Adapun pembagian peran dari masing-masing lapisan dapat dijelaskan sebagai berikut.

Bagian Model bertugas mengelola data dan berinteraksi langsung dengan basis data melalui Eloquent ORM. Setiap tabel pada basis data umumnya direpresentasikan oleh satu model, misalnya model User, Post, Comment, dan Skill. Bagian View bertanggung jawab menampilkan antarmuka kepada pengguna, dimana pada sistem ini View dibangun menggunakan Blade sebagai template engine yang dipadukan dengan Tailwind CSS untuk styling serta Alpine.js untuk interaktivitas ringan di sisi klien. Sementara itu, bagian Controller berperan sebagai penghubung yang menerima permintaan (request) dari pengguna, memproses logika bisnis, memanggil Model yang dibutuhkan, lalu mengembalikan View sebagai respon.

Alur kerja sistem secara umum dimulai ketika pengguna mengakses sebuah halaman melalui browser. Permintaan tersebut diterima oleh routing Laravel pada berkas routes/web.php yang kemudian meneruskannya ke Controller yang sesuai. Controller lalu memproses permintaan, mengambil atau menyimpan data melalui Model, dan akhirnya menampilkan hasilnya kembali kepada pengguna dalam bentuk halaman Blade. Pada beberapa proses tertentu seperti pengiriman email OTP dan notifikasi, sistem memanfaatkan mekanisme antrian (queue) supaya proses berjalan di latar belakang tanpa membuat pengguna menunggu lama.

Dari sisi penyebaran (deployment), sistem dijalankan pada arsitektur berbasis web. Pengguna mengakses aplikasi melalui browser pada perangkat masing-masing (klien), permintaan diteruskan melalui internet menuju web server (Apache/Nginx) yang menjalankan aplikasi Laravel, dan seluruh data disimpan pada database server MySQL. Layanan email digunakan untuk mengirim OTP, tautan aktivasi, serta tautan reset password. Gambaran arsitektur tersebut dapat dilihat pada diagram berikut.

[Gambar IV.3 Arsitektur Software Sistem BiConnect]

4.1.3 Antarmuka Pengguna

Antarmuka pengguna (user interface) dirancang dengan tampilan yang sederhana dan mudah dipahami, mengikuti kebutuhan non-fungsional dari aspek usability yang telah dibahas pada bab sebelumnya. Berikut diuraikan tampilan dari halaman-halaman utama pada sistem BiConnect beserta penjelasan fungsinya.

A. Halaman Landing Page

Halaman landing page menjadi halaman pertama yang dilihat pengunjung sebelum masuk ke sistem. Pada bagian hero, teks utama dan tombol ajakan (call to action) diletakkan di sisi kiri dengan tata letak rata kiri, sementara di sisi kanan terdapat banner slider yang berjalan otomatis. Halaman ini juga menampilkan statistik real-time seperti jumlah pengguna, jumlah proyek, dan jumlah diskusi yang datanya diambil langsung dari basis data.

[Gambar IV.4 Tampilan Halaman Landing Page]

B. Halaman Login dan Aktivasi

Halaman login menyediakan form untuk masuk ke sistem menggunakan email dan kata sandi. Di bawah tombol login terdapat tautan "Lupa Password" untuk pengguna yang ingin mereset kata sandinya. Logo BiConnect pada halaman login maupun aktivasi dapat diklik dan akan mengarahkan pengguna kembali ke halaman utama.

[Gambar IV.5 Tampilan Halaman Login]

[Gambar IV.6 Tampilan Halaman Aktivasi/Verifikasi OTP]

C. Halaman Feed (Beranda Setelah Login)

Setelah berhasil masuk, pengguna diarahkan ke halaman feed yang menampilkan daftar postingan, baik berupa proyek maupun diskusi. Setiap postingan ditampilkan dalam bentuk kartu (card) yang dapat diklik di mana saja untuk menuju halaman detail. Pada halaman ini tersedia pula fitur pencarian, filter berdasarkan tipe dan kategori, serta tombol interaksi seperti suka (like), komentar, dan bagikan (share).

[Gambar IV.7 Tampilan Halaman Feed]

D. Halaman Detail Proyek

Halaman detail proyek menampilkan informasi lengkap dari sebuah proyek, mencakup judul, deskripsi, keahlian yang dibutuhkan, area kampus, serta tenggat waktu. Pada halaman ini terdapat tombol "Tertarik" yang dapat diklik oleh mahasiswa lain yang berminat bergabung. Apabila tombol tersebut ditekan, pemilik proyek akan menerima notifikasi dan dapat melihat daftar mahasiswa yang tertarik. Pemilik proyek juga dapat menyetujui/memilih kandidat tersebut, yang akan membuka modal pop-up berisi informasi kontak kandidat terpilih (email dan nomor WhatsApp) untuk memfasilitasi komunikasi langsung.

[Gambar IV.8 Tampilan Halaman Detail Proyek]

E. Halaman Buat Postingan

Halaman buat postingan menyediakan form untuk membuat proyek atau diskusi baru. Pada bagian unggah gambar, sistem mendukung mekanisme seret dan lepas (drag and drop) selain klik untuk memilih berkas. Khusus untuk proyek, postingan yang baru dibuat akan berstatus pending dan baru tampil di feed publik setelah disetujui admin.

[Gambar IV.9 Tampilan Halaman Buat Postingan]

F. Halaman Profil

Halaman profil menampilkan data diri pengguna seperti nama, NIM, program studi, biodata, daftar keahlian, serta tautan media sosial. Foto profil ditampilkan dengan teknik overlapping terhadap banner profil. Pengguna juga dapat mengubah datanya melalui halaman edit profil.

[Gambar IV.10 Tampilan Halaman Profil]

G. Halaman Admin (Approval Proyek)

Halaman admin hanya dapat diakses oleh pengguna dengan hak akses administrator. Pada halaman ini admin dapat melihat daftar proyek yang berstatus pending, lalu memilih untuk menyetujui (approve) atau menolak (reject) proyek tersebut. Saat menolak proyek, admin dapat memasukkan alasan penolakan melalui modal dialog, yang kemudian akan dikirimkan kepada pengunggah proyek sebagai notifikasi in-app. Hanya proyek yang sudah disetujui yang akan tampil di feed publik.

[Gambar IV.11 Tampilan Halaman Admin Approval Proyek]

4.2 Code Generation

Sistem BiConnect dikembangkan dengan menggunakan framework Laravel yang menerapkan pola arsitektur MVC (Model-View-Controller) berbasis Object-Oriented Programming (OOP). Pada arsitektur ini, Model merepresentasikan struktur tabel database dan relasinya, Controller menangani logika bisnis, dan View bertugas merender antarmuka pengguna. Berikut diuraikan class-class utama (Model dan Controller) yang menyusun sistem BiConnect, beserta potongan kode (source code) implementasi dari fungsi-fungsi utamanya.

### 4.2.1 Class Diagram dan Deskripsi Model Utama

Model dalam framework Laravel memanfaatkan Eloquent ORM untuk merepresentasikan entitas basis data dalam bentuk class. Berikut adalah deskripsi class model utama yang digunakan pada sistem BiConnect:

#### A. Class User (Model)
Class `User` mewakili entitas pengguna (mahasiswa dan administrator). Class ini mewarisi class `Authenticatable` untuk menangani fitur otentikasi.
* **Atribut**: `id`, `name`, `email`, `password`, `nim`, `program`, `semester`, `campus_area`, `bio`, `whatsapp`, `avatar`, `cover`, `dark_mode`, `is_admin`, `is_active`, `is_verified`, `onboarding_completed`.
* **Relasi**:
  - `posts()`: `hasMany(Post::class)` (Satu pengguna dapat membuat banyak postingan).
  - `comments()`: `hasMany(Comment::class)` (Satu pengguna dapat membuat banyak komentar).
  - `skills()`: `belongsToMany(Skill::class)` (Menghubungkan pengguna dengan keahlian yang dikuasai).
  - `socialLinks()`: `hasMany(SocialLink::class)` (Satu pengguna dapat menyambungkan banyak tautan media sosial).
  - `interests()`: `hasMany(PostInterest::class)` (Pengguna dapat tertarik pada banyak proyek).
  - `followers()` & `following()`: `belongsToMany(User::class)` (Relasi many-to-many rekursif untuk sistem pengikut).

#### B. Class Post (Model)
Class `Post` mewakili entitas postingan diskusi maupun proyek yang diunggah oleh pengguna.
* **Atribut**: `id`, `user_id`, `type` (discussion/project), `title`, `body`, `image`, `deadline`, `campus_area`, `project_type` (paid/unpaid/portfolio), `status` (pending/approved/rejected/closed), `is_active`.
* **Relasi**:
  - `user()`: `belongsTo(User::class)` (Setiap postingan dimiliki oleh satu pengguna).
  - `comments()`: `hasMany(Comment::class)` (Postingan dapat memiliki banyak komentar).
  - `skills()`: `belongsToMany(Skill::class)` (Proyek dapat membutuhkan banyak keahlian).
  - `interests()`: `hasMany(PostInterest::class)` (Proyek dapat diminati oleh banyak mahasiswa).
  - `likes()`: `belongsToMany(User::class)` (Postingan dapat disukai oleh banyak pengguna).

#### C. Class Comment (Model)
Class `Comment` mewakili entitas komentar dan balasan komentar yang dikirim oleh pengguna pada suatu postingan.
* **Atribut**: `id`, `post_id`, `user_id`, `parent_id` (opsional, untuk nested reply), `body`.
* **Relasi**:
  - `post()`: `belongsTo(Post::class)` (Komentar ditujukan pada satu postingan).
  - `user()`: `belongsTo(User::class)` (Komentar dibuat oleh satu pengguna).
  - `parent()`: `belongsTo(Comment::class)` (Merujuk ke komentar induk jika berupa balasan).
  - `replies()`: `hasMany(Comment::class)` (Komentar induk dapat memiliki banyak balasan).

#### D. Class PostInterest (Model)
Class `PostInterest` mewakili entitas ketertarikan mahasiswa terhadap suatu proyek kolaborasi.
* **Atribut**: `id`, `post_id`, `user_id`, `status` (pending/selected), `created_at`.
* **Relasi**:
  - `post()`: `belongsTo(Post::class)` (Ketertarikan ditujukan pada satu proyek).
  - `user()`: `belongsTo(User::class)` (Ketertarikan diajukan oleh satu pengguna pelamar).

---

### 4.2.2 Implementasi Controller dan Listing Program Utama

Controller bertugas sebagai pengatur alur aplikasi dengan menerima request dari pengguna, berinteraksi dengan Model, dan mengembalikan data ke View. Berikut adalah listing program dari fungsi-fungsi krusial pada sistem BiConnect beserta penjelasan logikanya:

#### A. Kode Verifikasi OTP Pendaftaran (AuthController)
Metode `verifyOtp()` pada `AuthController` berfungsi memvalidasi kode OTP 6-digit yang dikirimkan ke email mahasiswa saat proses registrasi. Kode dicocokkan dengan data tabel `otp_verifications` dan diverifikasi masa berlakunya. Jika valid, akun akan diinisialisasi secara temporer di basis data.

```php
public function verifyOtp(VerifyOtpRequest $request): RedirectResponse
{
    $validated = $request->validated();

    $otp = OtpVerification::where('email', $validated['email'])
        ->where('code', $validated['code'])
        ->valid()
        ->latest('created_at')
        ->first();

    if (! $otp) {
        return back()->withErrors([
            'code' => 'Kode OTP tidak valid atau sudah kedaluwarsa.',
        ]);
    }

    // Tandai OTP telah digunakan
    $otp->update(['used_at' => now()]);

    // Daftarkan pengguna baru dengan email terverifikasi (kata sandi diisi di langkah berikutnya)
    $user = User::firstOrCreate(
        ['email' => $validated['email']],
        [
            'name'        => explode('@', $validated['email'])[0],
            'password'    => bcrypt(str()->random(32)),
            'is_verified' => false,
        ]
    );

    // Simpan ID pengguna sementara ke dalam session untuk pembuatan password
    session(['verified_user_id' => $user->id]);

    return redirect()->route('auth.create-password');
}
```
*(Listing program di atas merupakan implementasi logika pendaftaran aman berbasis OTP yang dibahas pada bab perancangan.)*

#### B. Kode Pemfilteran dan Pengurutan Halaman Feed (FeedController)
Metode `index()` pada `FeedController` bertugas mengambil data postingan dengan status `approved` dan `active` untuk ditampilkan di halaman beranda. Metode ini menerapkan parameter penyaringan berlapis (tipe postingan, lokasi kampus, jenis proyek, keahlian khusus) serta mendukung pengurutan postingan terpopuler berdasarkan interaksi pengguna.

```php
public function index(Request $request): View
{
    $query = Post::query()
        ->with(['user', 'skills'])
        ->withCount(['comments', 'likes', 'interests'])
        ->where('status', 'approved')
        ->active();

    // 1. Filter tipe postingan (diskusi atau proyek)
    if ($request->filled('type') && in_array($request->type, ['discussion', 'project'])) {
        $query->where('type', $request->type);
    }

    // 2. Filter area kampus
    if ($request->filled('campus_area')) {
        $query->where('campus_area', $request->campus_area);
    }

    // 3. Filter kategori/jenis proyek
    if ($request->filled('project_type')) {
        $query->where('project_type', $request->project_type);
    }

    // 4. Filter berdasarkan keahlian (skills)
    if ($request->filled('skills')) {
        $skillIds = is_array($request->skills) ? $request->skills : explode(',', $request->skills);
        $query->whereHas('skills', function ($q) use ($skillIds) {
            $q->whereIn('skills.id', $skillIds);
        });
    }

    // 5. Pengurutan data (Terbaru atau Terpopuler)
    $sort = $request->get('sort', 'latest');
    if ($sort === 'popular') {
        $query->orderByDesc('likes_count')->orderByDesc('comments_count')->orderByDesc('id');
    } else {
        $query->latest();
    }

    $posts = $query->paginate(10)->withQueryString();
    $allSkills = Skill::orderBy('name')->get();
    $campusAreas = Campus::pluck('name', 'code')->toArray();

    return view('feed.index', compact('posts', 'allSkills', 'campusAreas'));
}
```
*(Listing program di atas menerapkan fungsi filter kustom dengan mempertahankan query string pada pagination agar perpindahan halaman tidak menghilangkan filter.)*

#### C. Kode Validasi Pernyataan Ketertarikan Proyek (PostController)
Metode `storeInterest()` pada `PostController` menangani permintaan pengguna yang berminat untuk berkolaborasi dalam suatu proyek. Sistem memastikan postingan bertipe proyek, mencegah pemilik proyek mendaftar ke proyeknya sendiri, serta menolak pendaftaran ganda dari pengguna yang sama demi menjaga validitas data ketertarikan.

```php
public function storeInterest(Post $post): RedirectResponse
{
    if ($post->type !== 'project') {
        return back()->with('error', 'Hanya post project yang bisa diminati.');
    }

    // Cegah pemilik menyatakan ketertarikan pada postingan sendiri
    if ($post->user_id === auth()->id()) {
        return back()->with('error', 'Anda tidak bisa tertarik pada post sendiri.');
    }

    // Cegah duplikasi data ketertarikan
    $exists = PostInterest::where('post_id', $post->id)
        ->where('user_id', auth()->id())
        ->exists();

    if ($exists) {
        return back()->with('error', 'Anda sudah menyatakan ketertarikan pada project ini.');
    }

    PostInterest::create([
        'post_id' => $post->id,
        'user_id' => auth()->id(),
    ]);

    // Kirim notifikasi in-app ke pemilik proyek
    $post->user->notify(new \App\Notifications\NewInterest($post, auth()->user()));

    return back()->with('success', 'Ketertarikan berhasil dikirim! Pemilik project akan menghubungi Anda. 🤝');
}
```
*(Listing program di atas mengimplementasikan skema notifikasi real-time antar pengguna ketika ada pelamar proyek baru.)*

#### D. Kode Pemilihan Kandidat Kolaborasi oleh Pemilik Proyek (PostController)
Metode `selectInterest()` diakses oleh pemilik proyek untuk menyeleksi kandidat pelamar. Metode ini mengubah status pendaftaran kandidat menjadi `selected`, mengirimkan notifikasi terpilih, dan mengembalikan informasi kontak lengkap (Email dan WhatsApp) kandidat dalam format JSON untuk dirender di modal pop-up sisi klien.

```php
public function selectInterest(Post $post, PostInterest $interest): JsonResponse
{
    // Hanya pemilik proyek yang berhak memilih
    if ($post->user_id !== auth()->id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    if ($post->type !== 'project') {
        return response()->json(['error' => 'Invalid post type'], 422);
    }

    // Ubah status menjadi terpilih
    $interest->update(['status' => 'selected']);

    // Kirim notifikasi sukses ke kandidat terpilih
    $interest->user->notify(new \App\Notifications\InterestSelected($post));

    // Dapatkan data kontak kandidat dan format tautan WhatsApp
    $user = $interest->user;
    $whatsappUrl = null;
    if ($user->whatsapp) {
        $wa = preg_replace('/[^0-9]/', '', $user->whatsapp);
        if (str_starts_with($wa, '0')) {
            $wa = '62' . substr($wa, 1);
        }
        $whatsappUrl = 'https://wa.me/' . $wa;
    }

    return response()->json([
        'success'       => true,
        'user'          => [
            'name'        => $user->name,
            'avatar_url'  => $user->avatar_url,
            'email'       => $user->email,
            'whatsapp'    => $user->whatsapp,
            'whatsapp_url'=> $whatsappUrl,
            'social_links'=> $user->socialLinks->map(fn($l) => [
                'platform' => $l->platform,
                'url'      => $l->url,
            ])->toArray(),
            'profile_url' => route('profile.show.user', $user),
        ],
    ]);
}
```
*(Listing program di atas memanfaatkan format data JSON yang aman untuk menghindari reload halaman penuh saat proses pemilihan kandidat.)*

#### E. Kode Komentar Bersarang Satu Tingkat (PostController)
Metode `storeComment()` pada `PostController` menangani penulisan komentar utama dan balasan komentar. Keberadaan atribut `parent_id` membedakan apakah komentar tersebut merupakan ulasan mandiri atau balasan terhadap komentar mahasiswa lain.

```php
public function storeComment(Request $request, Post $post): RedirectResponse
{
    $request->validate([
        'body'      => ['required', 'string', 'min:2', 'max:1000'],
        'parent_id' => ['nullable', 'exists:comments,id'],
    ], [
        'body.required' => 'Komentar tidak boleh kosong.',
        'body.min'      => 'Komentar minimal 2 karakter.',
        'body.max'      => 'Komentar maksimal 1000 karakter.',
    ]);

    Comment::create([
        'post_id'   => $post->id,
        'user_id'   => auth()->id(),
        'parent_id' => $request->parent_id,
        'body'      => $request->body,
    ]);

    return back()->with('success', 'Komentar berhasil ditambahkan.');
}
```
*(Listing program di atas memanfaatkan rekursi basis data untuk mendefinisikan relasi komentar bertingkat.)*

#### F. Kode Persetujuan dan Penolakan Proyek oleh Admin (AdminController)
Dua metode berikut berada di `AdminController` untuk menangani moderasi proyek oleh administrator sebelum ditampilkan di feed publik. Metode penolakan menerima data input `reason` opsional yang dikirim sebagai penjelas kepada pemilik proyek.

```php
// 1. Persetujuan Proyek
public function approveProject(Post $post): RedirectResponse
{
    abort_if($post->type !== 'project', 404);

    $post->update(['status' => 'approved', 'is_active' => true]);

    if ($post->user) {
        $post->user->notify(new \App\Notifications\ProjectApproved($post));
    }

    return back()->with('success', 'Project "' . $post->title . '" berhasil disetujui.');
}

// 2. Penolakan Proyek dengan Alasan
public function rejectProject(Request $request, Post $post): RedirectResponse
{
    abort_if($post->type !== 'project', 404);

    $reason = $request->input('reason');

    $post->update(['status' => 'rejected', 'is_active' => false]);

    if ($post->user) {
        $post->user->notify(new \App\Notifications\ProjectRejected($post, $reason ?: null));
    }

    return back()->with('success', 'Project "' . $post->title . '" ditolak.');
}
```
*(Listing program di atas menerapkan integrasi sistem approval admin dengan notifikasi in-app untuk mengedukasi mahasiswa mengenai kelayakan konten.)*

4.3 Testing

Pengujian dilakukan dengan tujuan memastikan bahwa setiap fungsi pada sistem BiConnect berjalan sesuai dengan yang diharapkan. Metode pengujian yang digunakan yaitu black box testing, dimana pengujian dilakukan dengan cara memberikan masukan tertentu pada sistem lalu mengamati keluaran yang dihasilkan tanpa perlu mengetahui struktur kode di dalamnya. Pendekatan ini dipilih karena lebih berfokus pada perilaku sistem dari sudut pandang pengguna. Adapun hasil pengujian terhadap beberapa fungsi utama disajikan pada tabel-tabel berikut.

A. Pengujian Form Login

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|--------------------|-----------|-----------------------|-----------------|------------|
| 1 | Email dan password kosong | Klik tombol login tanpa mengisi field | Sistem menolak dan menampilkan pesan validasi | Sesuai harapan | Valid |
| 2 | Email benar, password salah | Memasukkan password yang tidak sesuai | Sistem menampilkan pesan kredensial tidak cocok | Sesuai harapan | Valid |
| 3 | Akun belum terverifikasi | Login dengan akun yang belum aktivasi | Sistem menolak login | Sesuai harapan | Valid |
| 4 | Email dan password benar | Memasukkan kredensial yang valid | Sistem mengarahkan ke halaman feed | Sesuai harapan | Valid |

B. Pengujian Pendaftaran dan Verifikasi OTP

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|--------------------|-----------|-----------------------|-----------------|------------|
| 1 | Email bukan domain @bsi.ac.id | Memasukkan email gmail.com | Sistem menolak pendaftaran | Sesuai harapan | Valid |
| 2 | Email valid @bsi.ac.id | Memasukkan email kampus | Sistem mengirim kode OTP ke email | Sesuai harapan | Valid |
| 3 | Kode OTP salah | Memasukkan kode yang tidak sesuai | Sistem menampilkan pesan kesalahan | Sesuai harapan | Valid |
| 4 | Kode OTP kedaluwarsa | Memasukkan OTP setelah 5 menit | Sistem menolak kode | Sesuai harapan | Valid |
| 5 | Kode OTP benar dan masih berlaku | Memasukkan OTP valid | Sistem melanjutkan ke pembuatan password | Sesuai harapan | Valid |

C. Pengujian Buat Proyek dan Approval Admin

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|--------------------|-----------|-----------------------|-----------------|------------|
| 1 | Buat proyek dengan data lengkap | Mengisi form lalu submit | Proyek tersimpan dengan status pending | Sesuai harapan | Valid |
| 2 | Proyek pending di feed publik | Membuka feed sebagai pengguna lain | Proyek pending tidak tampil | Sesuai harapan | Valid |
| 3 | Admin menyetujui proyek | Klik tombol approve | Status berubah approved dan tampil di feed | Sesuai harapan | Valid |
| 4 | Admin menolak proyek dengan alasan | Klik tombol tolak, isi form alasan penolakan, lalu submit | Status proyek menjadi rejected, tidak tampil di feed, dan pengunggah menerima notifikasi alasan | Sesuai harapan | Valid |

D. Pengujian Fitur Ketertarikan (Interest)

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|--------------------|-----------|-----------------------|-----------------|------------|
| 1 | Tertarik pada proyek sendiri | Pemilik klik tombol Tertarik | Sistem menolak | Sesuai harapan | Valid |
| 2 | Tertarik pada proyek orang lain | Pengguna lain klik Tertarik | Ketertarikan tersimpan, pemilik dapat notifikasi | Sesuai harapan | Valid |
| 3 | Tertarik dua kali pada proyek sama | Klik tombol Tertarik berulang | Sistem menolak duplikasi | Sesuai harapan | Valid |
| 4 | Pemilik proyek memilih kandidat | Klik tombol "Pilih" pada daftar pelamar | Status berubah menjadi selected, muncul modal berisi info kontak (email/WhatsApp), dan kandidat menerima notifikasi | Sesuai harapan | Valid |

E. Pengujian Interaksi (Like dan Komentar)

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|--------------------|-----------|-----------------------|-----------------|------------|
| 1 | Menyukai postingan | Klik tombol like | Jumlah like bertambah | Sesuai harapan | Valid |
| 2 | Membatalkan like | Klik tombol like sekali lagi | Jumlah like berkurang | Sesuai harapan | Valid |
| 3 | Komentar utama | Mengisi komentar lalu submit | Komentar tampil di postingan | Sesuai harapan | Valid |
| 4 | Membalas komentar | Membalas komentar yang ada | Balasan tampil di bawah komentar utama | Sesuai harapan | Valid |

F. Pengujian Lupa Password

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|--------------------|-----------|-----------------------|-----------------|------------|
| 1 | Input email terdaftar | Memasukkan email valid | Sistem mengirim tautan reset password | Sesuai harapan | Valid |
| 2 | Buka tautan reset | Klik tautan dari email | Sistem menampilkan form password baru | Sesuai harapan | Valid |
| 3 | Submit password baru | Mengisi password baru lalu submit | Password berhasil diperbarui | Sesuai harapan | Valid |

G. Pengujian Kelengkapan Profil dan WhatsApp

| No | Skenario Pengujian | Test Case | Hasil yang Diharapkan | Hasil Pengujian | Kesimpulan |
|----|--------------------|-----------|-----------------------|-----------------|------------|
| 1 | Menyimpan nomor WhatsApp pada profil | Mengisi nomor WhatsApp di form edit profil lalu simpan | Nomor WhatsApp berhasil disimpan ke basis data | Sesuai harapan | Valid |
| 2 | Notifikasi kelengkapan profil saat login | Login dengan akun yang memiliki bio/skill kosong | Pengguna menerima notifikasi in-app untuk melengkapi profil | Sesuai harapan | Valid |

Berdasarkan hasil pengujian black box di atas, dapat disimpulkan bahwa seluruh fungsi utama sistem BiConnect telah berjalan sesuai dengan yang diharapkan. Setiap skenario, baik untuk masukan yang valid maupun masukan yang tidak valid, memberikan keluaran yang sesuai dengan rancangan. Dengan demikian, sistem dinilai layak untuk digunakan.

4.4 Pendukung

Pada bagian ini diuraikan spesifikasi perangkat keras (hardware) dan perangkat lunak (software) yang dibutuhkan dalam rangka untuk menjalankan sistem BiConnect, baik dari sisi server maupun sisi pengguna. Spesifikasi ini menjadi acuan minimum supaya sistem dapat beroperasi dengan optimal.

A. Spesifikasi Perangkat Keras

| No | Perangkat Keras | Sisi Server | Sisi Client |
|----|-----------------|-------------|-------------|
| 1 | Processor | Intel Xeon atau setara | Intel Core i3 atau setara |
| 2 | RAM | Minimal 8 GB | Minimal 4 GB |
| 3 | Penyimpanan | SSD minimal 256 GB | Minimal 128 GB |
| 4 | Koneksi Internet | Stabil dan memadai | Stabil dan memadai |

B. Spesifikasi Perangkat Lunak

| No | Perangkat Lunak | Sisi Server | Sisi Client |
|----|-----------------|-------------|-------------|
| 1 | Sistem Operasi | Linux (Ubuntu Server 22.04 LTS) | Windows, macOS, Linux, Android, iOS |
| 2 | Web Server | Apache / Nginx | - |
| 3 | Bahasa Pemrograman | PHP 8.0 atau lebih baru | - |
| 4 | Framework | Laravel | - |
| 5 | Basis Data | MySQL 8.0 / MariaDB | - |
| 6 | Browser | - | Google Chrome, Firefox, Edge, Safari |

Dengan terpenuhinya spesifikasi perangkat keras dan perangkat lunak di atas, sistem BiConnect dapat dijalankan sebagaimana mestinya. Penggunaan pendekatan berbasis web menjadikan sistem ini ringan dari sisi pengguna, sebab mahasiswa cukup mengakses sistem melalui browser tanpa perlu melakukan instalasi aplikasi tambahan pada perangkatnya.

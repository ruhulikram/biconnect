# ANALISIS PROGRAM TERSTRUKTUR BICONNECT

Dokumen ini berisi analisis fungsionalitas utama sistem **BiConnect** yang dikembangkan menggunakan arsitektur MVC (Model-View-Controller) dengan framework Laravel. Setiap modul dilengkapi penjelasan metode logika bisnis yang digunakan, disertai listing program (*source code*) asli dari aplikasi untuk kebutuhan penulisan skripsi akademik.

---

## 2. Contoh Program Terstruktur

### 1. Autentikasi Pengguna & Aktivasi Akun (OTP Verification)
Fungsionalitas ini digunakan untuk mengontrol akses pengguna ke dalam sistem. Alur masuk dimulai dengan registrasi/aktivasi menggunakan email kampus resmi BSI (`@bsi.ac.id`). Kode OTP 6-digit acak akan dikirimkan ke email untuk verifikasi keamanan sebelum pengguna diizinkan membuat kata sandi baru.

```
[Gambar 4.1: Tampilan Halaman Aktivasi Email Kampus]
[Gambar 4.2: Tampilan Halaman Input Kode OTP]
[Gambar 4.3: Tampilan Halaman Pembuatan Kata Sandi Baru]
[Gambar 4.4: Tampilan Halaman Login BiConnect]
```

Berikut adalah implementasi kode program untuk kontrol autentikasi dan aktivasi akun pada berkas `app/Http/Controllers/AuthController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Menampilkan halaman awal aktivasi email kampus
    public function showActivate(): View
    {
        return view('auth.activate');
    }

    // Mengirimkan kode OTP ke email kampus pengguna
    public function sendOtp(SendOtpRequest $request): RedirectResponse
    {
        $email = $request->validated()['email'];

        // Mencegah eksploitasi: blokir email yang sudah aktif/terverifikasi sebelumnya
        $existingUser = User::where('email', $email)->first();
        if ($existingUser && $existingUser->is_verified) {
            return back()->withErrors([
                'email' => 'Email sudah terdaftar dan aktif. Silakan masuk atau gunakan fitur lupa password.',
            ])->onlyInput('email');
        }

        // Nonaktifkan kode OTP lama yang belum terpakai untuk email ini
        OtpVerification::where('email', $email)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        // Membuat kode OTP 6 digit acak
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpVerification::create([
            'email'      => $email,
            'code'       => $code,
            'expires_at' => now()->addMinutes(5),
        ]);

        // Mengirimkan email berisi OTP ke pengguna (menggunakan Mail driver)
        Mail::raw("Kode OTP BiConnect kamu: {$code}\n\nKode ini berlaku selama 5 menit.", function ($message) use ($email) {
            $message->to($email)
                    ->subject('Kode OTP BiConnect');
        });

        // Menyimpan email di session untuk divalidasi pada halaman input OTP
        session(['otp_email' => $email]);

        return redirect()
            ->route('auth.otp')
            ->with('success', 'Kode OTP telah dikirim ke ' . $email);
    }

    // Menampilkan halaman pengisian kode OTP
    public function showOtp(): View|RedirectResponse
    {
        if (! session('otp_email')) {
            return redirect()->route('auth.activate');
        }

        return view('auth.otp', [
            'email' => session('otp_email'),
        ]);
    }

    // Memverifikasi kecocokan kode OTP yang dimasukkan pengguna
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

        // Menandai OTP telah sukses digunakan
        $otp->update(['used_at' => now()]);

        // Membuat record user sementara jika belum ada
        $user = User::firstOrCreate(
            ['email' => $validated['email']],
            [
                'name'        => explode('@', $validated['email'])[0],
                'password'    => bcrypt(str()->random(32)), // Password sementara acak
                'is_verified' => false,
            ]
        );

        // Menyimpan user ID ke session untuk pembuatan password baru
        session(['verified_user_id' => $user->id]);

        return redirect()->route('auth.create-password');
    }

    // Menampilkan halaman pembuatan password baru
    public function showCreatePassword(): View|RedirectResponse
    {
        if (! session('verified_user_id')) {
            return redirect()->route('auth.activate');
        }

        return view('auth.create-password');
    }

    // Memproses password baru yang dibuat pengguna dan mengaktifkan akun
    public function createPassword(CreatePasswordRequest $request): RedirectResponse
    {
        $userId = session('verified_user_id');

        if (! $userId) {
            return redirect()->route('auth.activate');
        }

        $user = User::findOrFail($userId);
        $user->update([
            'password' => bcrypt($request->validated()['password']),
            'is_verified' => true,
            'email_verified_at' => now(),
        ]);

        // Bersihkan session aktivasi
        session()->forget(['otp_email', 'verified_user_id']);

        // Melakukan login otomatis setelah aktivasi berhasil
        Auth::login($user);

        return redirect()->route('feed.index')
            ->with('success', 'Akun berhasil diaktifkan! Selamat datang di BiConnect.');
    }

    // Menampilkan halaman login utama
    public function showLogin(): View
    {
        return view('auth.login');
    }

    // Memproses data kredensial login pengguna
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }

        // Cek apakah akun sudah terverifikasi email
        if (! Auth::user()->is_verified) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            session(['pending_verification_email' => $credentials['email']]);

            return redirect()->route('verification.notice')
                ->with('warning', 'Akun kamu belum diverifikasi. Silakan cek email untuk tautan verifikasi.');
        }

        // Cek status keaktifan akun (apakah diblokir admin)
        if (! Auth::user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors([
                'email' => 'Akun kamu telah dinonaktifkan oleh Administrator.',
            ])->onlyInput('email');
        }

        // Meregenerasi session ID untuk mencegah session fixation attacks
        $request->session()->regenerate();

        $user = Auth::user();
        if (!$user->onboarding_completed) {
            return redirect()->route('onboarding.profile');
        }

        // Menampilkan pengingat kelengkapan profil jika biodata/skills masih kosong
        $user->sendProfileCompletionReminder();

        return redirect()->intended(route('feed.index'))
            ->with('success', 'Selamat datang kembali!');
    }

    // Memproses logout pengguna
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Kamu telah logout.');
    }
}
```

---

### 2. Verifikasi & Aktivasi Email (Email Verification Link)
Alur ini digunakan untuk memastikan kepemilikan email kampus yang didaftarkan. Setelah proses login pertama kali atau pendaftaran, token verifikasi unik dikirimkan ke email kampus pengguna. Akun tidak akan dapat mengakses fitur utama sebelum tautan verifikasi diklik.

```
[Gambar 4.5: Halaman Pemberitahuan Pengiriman Link Verifikasi Email]
```

Berikut adalah implementasi kode program untuk modul verifikasi email pada berkas `app/Http/Controllers/EmailVerificationController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\EmailVerificationToken;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    // Menampilkan halaman pemberitahuan untuk memeriksa kotak masuk email
    public function notice(): View|RedirectResponse
    {
        if (! session('pending_verification_email')) {
            return redirect()->route('auth.activate');
        }

        $email = session('pending_verification_email');

        return view('auth.verify-email', compact('email'));
    }

    // Memproses tautan verifikasi email yang diklik oleh pengguna
    public function verify(string $token): RedirectResponse
    {
        $verificationToken = EmailVerificationToken::where('token', $token)
            ->valid()
            ->first();

        if (! $verificationToken) {
            return redirect()->route('login')
                ->with('error', 'Tautan verifikasi tidak valid atau sudah kedaluwarsa. Silakan daftar ulang.');
        }

        // Menandai token verifikasi telah digunakan
        $verificationToken->update(['used_at' => now()]);

        // Mengaktifkan status verifikasi pengguna di database
        $user = User::where('email', $verificationToken->email)->first();

        if ($user) {
            $user->update([
                'is_verified'       => true,
                'email_verified_at' => now(),
            ]);
        }

        // Hapus session email verifikasi tertunda
        session()->forget('pending_verification_email');

        return redirect()->route('login')
            ->with('success', 'Email berhasil diverifikasi! Silakan masuk dengan akun kamu.');
    }

    // Mengirimkan ulang email tautan verifikasi
    public function resend(Request $request): RedirectResponse
    {
        $email = session('pending_verification_email');

        if (! $email) {
            return redirect()->route('auth.activate');
        }

        // Nonaktifkan token lama yang belum terpakai untuk email ini
        EmailVerificationToken::where('email', $email)
            ->whereNull('used_at')
            ->update(['used_at' => now()]);

        // Generate token keamanan acak baru sepanjang 64 karakter
        $token = Str::random(64);

        EmailVerificationToken::create([
            'email'      => $email,
            'token'      => $token,
            'expires_at' => now()->addHours(24), // Berlaku selama 24 jam
        ]);

        // Mengirimkan template email verifikasi baru
        \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\EmailVerificationMail($token));

        return back()->with('success', 'Email verifikasi baru telah dikirim ke ' . $email);
    }
}
```

---

### 3. Manajemen Pembuatan Postingan (Proyek & Diskusi)
Metode ini membedakan alur antara postingan bertipe proyek (`project`) dan postingan bertipe diskusi (`discussion`). Jika bertipe diskusi, postingan langsung dipublikasikan. Jika bertipe proyek, status diset `pending` dan menunggu persetujuan (moderasi) dari Administrator agar dapat ditampilkan di feed utama. Relasi kategori skill mahasiswa juga di-sync pada tahap ini.

```
[Gambar 4.6: Halaman Form Pembuatan Postingan Baru]
```

Berikut adalah kode program untuk memproses pengiriman data postingan pada berkas `app/Http/Controllers/PostController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Campus;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostInterest;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PostController extends Controller
{
    // Menampilkan halaman formulir pembuatan postingan baru
    public function create(): View
    {
        $skills = Skill::orderBy('name')->get();
        $campusAreas = Campus::pluck('name', 'code')->toArray();

        return view('post.create', compact('skills', 'campusAreas'));
    }

    // Menyimpan postingan baru ke database
    public function store(StorePostRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Mengunggah gambar jika dilampirkan oleh pengguna
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // Tentukan aturan persetujuan: Diskusi langsung tayang, Proyek memerlukan moderasi admin
        $isProject = ($validated['type'] ?? 'discussion') === 'project';

        // Menyimpan data postingan ke database
        $post = Post::create([
            'user_id'      => auth()->id(),
            'type'         => $validated['type'],
            'title'        => $validated['title'] ?? null,
            'body'         => $validated['body'],
            'image'        => $imagePath,
            'deadline'     => $validated['deadline'] ?? null,
            'campus_area'  => $validated['campus_area'] ?? null,
            'project_type' => $validated['project_type'] ?? null,
            'is_active'    => ! $isProject,
            'status'       => $isProject ? 'pending' : 'approved',
        ]);

        // Menyinkronkan daftar keahlian (skills) yang dipilih ke tabel pivot
        if (!empty($validated['skills'])) {
            $post->skills()->sync($validated['skills']);
        }

        $message = $isProject
            ? 'Project berhasil diunggah! Menunggu persetujuan admin sebelum ditampilkan. 🎉'
            : 'Diskusi berhasil dipublikasikan! 🎉';

        return redirect()
            ->route('feed.index')
            ->with('success', $message);
    }
    
    // ... (metode pendukung lain didefinisikan di bawah)
}
```

---

### 4. Sistem Approval & Moderasi Proyek oleh Administrator
Fungsi ini khusus dijalankan oleh akun dengan hak akses administrator untuk memvalidasi dan menyetujui postingan bertipe proyek. Admin dapat menyetujui (`approve`) proyek agar tayang secara publik di feed, atau menolak (`reject`) dengan melampirkan alasan penolakan yang dikirimkan via notifikasi sistem ke pembuat proyek.

```
[Gambar 4.7: Halaman Dashboard Panel Admin]
[Gambar 4.8: Halaman Daftar Moderasi Proyek Pending]
```

Berikut adalah implementasi kode program untuk mengelola proses approval proyek pada berkas `app/Http/Controllers/AdminController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\InfoHub;
use App\Models\Post;
use App\Models\PostInterest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    // Menampilkan daftar proyek berstatus 'pending' yang membutuhkan persetujuan
    public function pendingProjects(Request $request): View
    {
        $projects = Post::with(['user', 'skills'])
            ->where('type', 'project')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.projects', compact('projects'));
    }

    // Menyetujui postingan proyek agar tayang di feed utama
    public function approveProject(Post $post): RedirectResponse
    {
        abort_if($post->type !== 'project', 404);

        $post->update(['status' => 'approved', 'is_active' => true]);

        // Mengirimkan notifikasi keberhasilan ke pemilik proyek
        if ($post->user) {
            $post->user->notify(new \App\Notifications\ProjectApproved($post));
        }

        return back()->with('success', 'Project "' . $post->title . '" berhasil disetujui dan dipublikasikan.');
    }

    // Menolak postingan proyek dengan alasan tertentu
    public function rejectProject(Request $request, Post $post): RedirectResponse
    {
        abort_if($post->type !== 'project', 404);

        $reason = $request->input('reason');

        $post->update(['status' => 'rejected', 'is_active' => false]);

        // Mengirimkan notifikasi penolakan beserta alasannya ke pemilik proyek
        if ($post->user) {
            $post->user->notify(new \App\Notifications\ProjectRejected($post, $reason ?: null));
        }

        return back()->with('success', 'Project "' . $post->title . '" ditolak.');
    }
}
```

---

### 5. Siklus Hidup Proyek (Ketertarikan & Penutupan Proyek)
Modul ini mendefinisikan siklus hidup interaksi proyek:
1. **Ketertarikan (Interest)**: Pengguna lain dapat menyatakan ketertarikan bergabung ke suatu proyek dengan memicu notifikasi kepada pembuat proyek. Pemilik proyek kemudian dapat memilih kandidat terpilih (`selectInterest`) dan sistem akan memberikan kontak Whatsapp & tautan profil kandidat tersebut.
2. **Penutupan Proyek (Close Project)**: Pemilik proyek dapat menutup proyek secara manual bila kuota tim dirasa sudah terpenuhi, mengubah status menjadi `closed` dan menyembunyikannya dari feed publik.

```
[Gambar 4.9: Halaman Detail Proyek (Pilihan Tertarik)]
[Gambar 4.10: Modal Kontak Kandidat Terpilih]
```

Berikut implementasi kode program untuk siklus hidup proyek pada berkas `app/Http/Controllers/PostController.php`:

```php
<?php

namespace App\Http\Controllers;

// ... (namespace & imports yang didefinisikan sebelumnya)

class PostController extends Controller
{
    // Menyimpan ketertarikan pengguna pada proyek orang lain
    public function storeInterest(Post $post): RedirectResponse
    {
        if ($post->type !== 'project') {
            return back()->with('error', 'Hanya post project yang bisa diminati.');
        }

        // Validasi: melarang mendaftar di proyek buatan sendiri
        if ($post->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa tertarik pada post sendiri.');
        }

        // Validasi: melarang menyatakan ketertarikan ganda
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

        // Kirim notifikasi sistem ke pemilik proyek
        $post->user->notify(new \App\Notifications\NewInterest($post, auth()->user()));

        return back()->with('success', 'Ketertarikan berhasil dikirim! Pemilik project akan menghubungi Anda. 🤝');
    }

    // Memilih/menerima kandidat pelamar proyek dan menampilkan informasi kontak mereka
    public function selectInterest(Post $post, PostInterest $interest): JsonResponse
    {
        // Hanya pembuat proyek asli yang memiliki otorisasi memilih kandidat
        if ($post->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($post->type !== 'project') {
            return response()->json(['error' => 'Invalid post type'], 422);
        }

        // Tandai status pelamar menjadi terpilih ('selected')
        $interest->update(['status' => 'selected']);

        // Mengirimkan notifikasi kelulusan seleksi ke pelamar proyek
        $interest->user->notify(new \App\Notifications\InterestSelected($post));

        // Format nomor WhatsApp pelamar untuk integrasi API chat langsung
        $user = $interest->user;
        $whatsappUrl = null;
        if ($user->whatsapp) {
            $wa = preg_replace('/[^0-9]/', '', $user->whatsapp);
            if (str_starts_with($wa, '0')) {
                $wa = '62' . substr($wa, 1); // Ubah awalan 0 menjadi kode negara 62
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

    // Membatalkan pilihan kandidat pelamar proyek
    public function deselectInterest(Post $post, PostInterest $interest): JsonResponse
    {
        // Hanya pembuat proyek asli yang memiliki otorisasi membatalkan kandidat
        if ($post->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if ($post->type !== 'project') {
            return response()->json(['error' => 'Invalid post type'], 422);
        }

        // Kembalikan status pelamar menjadi pending
        $interest->update(['status' => 'pending']);

        // Mengirimkan notifikasi pembatalan ke pelamar proyek
        $interest->user->notify(new \App\Notifications\InterestDeselected($post));

        return response()->json([
            'success' => true,
            'message' => 'Pilihan kandidat berhasil dibatalkan.'
        ]);
    }

    // Menutup proyek secara manual oleh pembuatnya
    public function close(Post $post): RedirectResponse
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        if ($post->type !== 'project') {
            abort(404);
        }

        // Ubah status proyek menjadi tertutup dan sembunyikan dari feed utama
        $post->update(['status' => 'closed', 'is_active' => false]);

        return redirect()->route('profile.show')
            ->with('success', 'Project berhasil ditutup.');
    }
}
```

---

### 6. Pengaturan Akun & Dark Mode
Fungsi ini digunakan untuk menyesuaikan tampilan dashboard pengguna secara dinamis. Pilihan preferensi disimpan di database pada record profil user dan langsung diaplikasikan reaktif menggunakan class dark mode pada elemen HTML.

```
[Gambar 4.11: Halaman Pengaturan & Personalisasi Akun]
```

Berikut kode program untuk mengubah preferensi tampilan pada berkas `app/Http/Controllers/SettingsController.php`:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    // Menampilkan halaman pengaturan akun
    public function index(): View
    {
        return view('settings.index');
    }

    // Menyimpan preferensi tampilan tema (Dark Mode) pengguna ke database
    public function updateDarkMode(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'dark_mode' => 'required|boolean',
        ]);

        auth()->user()->update([
            'dark_mode' => $request->boolean('dark_mode'),
        ]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Pengaturan tampilan diperbarui.');
    }
}
```

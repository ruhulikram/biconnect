# Use Case Diagram — BiConnect

Berikut adalah kode **Mermaid.js** yang telah diperbarui untuk merender Use Case Diagram sistem BiConnect. Diagram ini sekarang mencakup fungsi **Login**, **Logout**, **Lupa & Reset Password**, serta menggunakan relasi **`<<include>>`** dan **`<<extend>>`** sesuai dengan standar UML untuk menggambarkan ketergantungan antar use case di program Anda.

## Kode Mermaid

```mermaid
graph LR
    %% Pengaturan Style Aktor dan Use Case
    classDef actor fill:#eff6ff,stroke:#1e40af,stroke-width:2px,color:#1e40af,font-weight:bold;
    classDef usecase fill:#fff,stroke:#475569,stroke-width:1.5px,color:#0f172a;
    classDef system fill:#f8fafc,stroke:#cbd5e1,stroke-width:2px,stroke-dasharray: 5 5;

    %% Aktor Utama
    Mahasiswa((Mahasiswa)):::actor
    Admin((Administrator)):::actor

    subgraph BiConnect ["Sistem BiConnect (System Boundary)"]
        %% 1. Autentikasi & Akun
        UC_Login(Login):::usecase
        UC_Logout(Logout):::usecase
        UC_Registrasi(Aktivasi Akun & OTP):::usecase
        UC_Reset(Lupa & Reset Password):::usecase

        %% 2. Fitur Mahasiswa
        UC_Profil(Lengkapi Profil & WhatsApp):::usecase
        UC_Post(Membuat Postingan Proyek/Diskusi):::usecase
        UC_Komentar(Mengirim Komentar Bersarang):::usecase
        UC_Tertarik(Menyatakan Ketertarikan Proyek):::usecase
        UC_Pilih(Memilih Kandidat Kolaborasi):::usecase
        UC_Notif(Menerima Notifikasi In-App):::usecase

        %% 3. Fitur Admin
        UC_Dash(Dashboard & Statistik):::usecase
        UC_Moderasi(Moderasi Proyek & Alasan Penolakan):::usecase
        UC_Info(Mengelola Info Kampus / Info Hub):::usecase

        %% ── Relasi <<include>> (Use Case memerlukan Login terlebih dahulu) ──
        UC_Logout -. "<<include>>" .-> UC_Login
        UC_Profil -. "<<include>>" .-> UC_Login
        UC_Post -. "<<include>>" .-> UC_Login
        UC_Komentar -. "<<include>>" .-> UC_Login
        UC_Tertarik -. "<<include>>" .-> UC_Login
        UC_Pilih -. "<<include>>" .-> UC_Login
        UC_Notif -. "<<include>>" .-> UC_Login
        
        UC_Dash -. "<<include>>" .-> UC_Login
        UC_Moderasi -. "<<include>>" .-> UC_Login
        UC_Info -. "<<include>>" .-> UC_Login

        %% ── Relasi <<extend>> (Kasus alternatif/opsional dari Login) ──
        UC_Reset -. "<<extend>>" .-> UC_Login
    end

    %% Relasi Aktor Mahasiswa
    Mahasiswa --> UC_Login
    Mahasiswa --> UC_Registrasi
    Mahasiswa --> UC_Profil
    Mahasiswa --> UC_Post
    Mahasiswa --> UC_Komentar
    Mahasiswa --> UC_Tertarik
    Mahasiswa --> UC_Pilih
    Mahasiswa --> UC_Notif
    Mahasiswa --> UC_Logout

    %% Relasi Aktor Admin
    Admin --> UC_Login
    Admin --> UC_Dash
    Admin --> UC_Moderasi
    Admin --> UC_Info
    Admin --> UC_Notif
    Admin --> UC_Logout
```

---

## Penjelasan Relasi UML:

1. **`<<include>>` (Penyertaan)**:
   Digambarkan dengan garis putus-putus berpanah (`-.->`) dari use case asal ke use case `Login`. Artinya, pengguna **harus masuk (Login) terlebih dahulu** agar dapat menjalankan aksi-aksi tersebut (misal: membuat postingan, mengubah profil, atau melihat dashboard admin).
   
2. **`<<extend>>` (Perluasan)**:
   Digambarkan dengan garis putus-putus berpanah dari `Lupa & Reset Password` ke `Login`. Artinya, fitur lupa password bersifat **opsional/alternatif** yang dipicu hanya jika pengguna mengalami kendala saat melakukan proses `Login`.

3. **Login & Logout**:
   Kedua aktor (Mahasiswa & Admin) terhubung langsung ke use case `Login` dan `Logout` sebagai syarat utama masuk dan keluar dari hak akses sistem masing-masing.

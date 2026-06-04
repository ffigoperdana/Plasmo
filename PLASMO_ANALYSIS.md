# Analisa dan Dokumentasi Project Plasmo

Dokumen ini berisi penjelasan lengkap mengenai alur kerja, struktur database, dan aspek teknis dari aplikasi **Plasmo**.

---

## 1. Ringkasan Aplikasi
**Plasmo** adalah platform berbasis web yang dirancang untuk memfasilitasi donor plasma konvalesen. Aplikasi ini menghubungkan pasien yang membutuhkan donor (Pencari Donor) dengan individu yang bersedia mendonorkan plasma mereka (Pendonor), serta menyediakan informasi stok plasma di berbagai rumah sakit.

### Teknologi yang Digunakan:
- **Framework:** Laravel 8.5
- **Frontend:** Livewire 2.0, Tailwind CSS
- **Authentication:** Laravel Jetstream (Fortify & Sanctum)
- **Database:** MySQL
- **Asset Bundling:** Laravel Mix (Webpack)

---

## 2. Alur Kerja Aplikasi (Application Flow)

### A. Akses Publik (Guest)
Pengguna yang belum login dapat mengakses:
1. **Landing Page:** Informasi umum mengenai platform.
2. **Tentang Kami & Kontak:** Informasi profil platform dan bantuan.
3. **Stok Plasma:** Melihat ketersediaan stok plasma di berbagai rumah sakit secara real-time.
4. **Registrasi/Masuk:** Mendaftarkan diri sebagai salah satu peran (Pencari Donor atau Pendonor).

### B. Peran Pencari Donor (Pasien)
Setelah login, pengguna ini dapat:
1. **Dashboard:** Melihat ringkasan aktivitas.
2. **Buat Permohonan:** Mengisi formulir detail pasien yang membutuhkan plasma (termasuk golongan darah, rhesus, rumah sakit, dan dokumen pendukung/TPK).
3. **Cari Stok:** Melihat daftar rumah sakit dan stok plasma yang tersedia.
4. **Profil:** Mengelola data diri, ganti password, dan email.

### C. Peran Pendonor
Setelah login, pengguna ini dapat:
1. **Dashboard:** Melihat ringkasan aktivitas donor.
2. **Registrasi Donor:** Mengisi formulir kualifikasi sebagai pendonor (NIK, riwayat PCR, alamat, dll).
3. **Daftar Pasien:** Melihat daftar pasien yang saat ini sangat membutuhkan donor plasma.
4. **Berita & FAQ:** Membaca informasi terbaru seputar donor plasma.

### D. Peran Admin
Admin memiliki kontrol penuh untuk mengelola data:
1. **Manajemen User:** Mengelola semua akun pengguna dan peran mereka.
2. **Manajemen Rumah Sakit:** Menambah/mengedit data rumah sakit serta memperbarui jumlah stok plasma per golongan darah (A, B, AB, O).
3. **Manajemen Berita:** Membuat dan memperbarui artikel atau berita di platform.
4. **Manajemen FAQ:** Mengelola pertanyaan yang sering diajukan untuk membantu pengguna.

---

## 3. Struktur Database

Aplikasi ini memiliki beberapa tabel utama untuk menyimpan data fungsional:

| Tabel | Kegunaan |
|-------|----------|
| `users` | Menyimpan data autentikasi pengguna (email, password, role_id). |
| `roles` | Menyimpan definisi peran (Admin, Pencari Donor, Pendonor). |
| `pasien` | Menyimpan data permohonan plasma (Nama pasien, golongan darah, rhesus, RS, jumlah plasma). |
| `pendonor` | Menyimpan data registrasi pendonor (NIK, alamat, riwayat PCR, kualifikasi fisik). |
| `hospital` | Menyimpan data rumah sakit dan jumlah stok plasma (A+, A-, B+, B-, dll). |
| `berita` | Menyimpan konten artikel/berita yang dipublikasikan. |
| `faq` | Menyimpan daftar pertanyaan dan jawaban. |

---

## 4. Analisis Kode (Technical Insight)

### Routing (`routes/web.php`)
- Menggunakan middleware `auth` dan `role` untuk membatasi akses antar dashboard.
- Integrasi Sanctum dan Jetstream untuk keamanan sesi.

### Controller & Logic
- **PasienController:** Menangani proses `store` data permohonan pasien.
- **PendonorController:** Menangani pendaftaran donor.
- **HospitalController:** Menangani pengelolaan stok plasma oleh admin.
- **Livewire Components:** Digunakan di beberapa bagian seperti `CreateTable` atau form pembuatan user untuk memberikan pengalaman interaktif tanpa reload halaman.

### DevOps & Environment
- **Environment:** Menggunakan file `.env` untuk konfigurasi database dan app key.
- **Assets:** Dicompile menggunakan `npm run dev` atau `npm run production` yang menghasilkan file di `public/css` dan `public/js`.
- **Migrations:** Skema database sepenuhnya dikelola melalui migration Laravel, memudahkan setup ulang environment baru.

---

## 5. Kesimpulan Fitur Utama
Aplikasi ini adalah **Dashboard CRUD** yang terbagi menjadi 3 sisi kepentingan:
1. **Sisi Kebutuhan (Demand):** Pasien menginput data kebutuhan mereka.
2. **Sisi Ketersediaan (Supply):** Pendonor mendaftar dan Rumah Sakit mengupdate stok.
3. **Sisi Informasi (Information):** Berita, FAQ, dan landing page sebagai jembatan informasi.

---
*Dibuat secara otomatis melalui analisa codebase Plasmo pada April 2026.*

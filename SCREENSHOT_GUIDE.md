# Screenshot Capture Guide

Panduan ini adalah manifest tunggal untuk screenshot portfolio Employee Management System. Seluruh slot telah diaudit terhadap route, controller, permission, navigasi, halaman Vue, dan demo seeder yang tersedia. Jangan mengambil gambar dari proyek lain dan jangan mengganti placeholder dengan mockup UI.

## Persiapan umum

- Jalankan aplikasi pada environment lokal dan isi ulang data fiktif dengan `php artisan migrate:fresh --seed`.
- Gunakan browser zoom 100% dan viewport desktop konsisten `1440 × 900` (rasio 8:5).
- Gunakan branding **Employee Management System**, DevTools tertutup, serta crop yang tetap memperlihatkan konteks halaman.
- Tampilkan hanya data dari demo seeder. Email yang terlihat harus memakai domain `example.com`.
- Jangan tampilkan tab browser, desktop, path lokal, email pribadi, koordinat pribadi, notifikasi sistem, file lokal, token, atau credential sensitif.
- Tutup toast/modal yang menutupi konten. Hindari tooltip, dropdown akun, dan menu browser yang sedang terbuka.
- Simpan hasil sebagai WebP berkualitas tinggi. PNG boleh dipakai sementara jika konversi WebP belum tersedia.
- Jangan melakukan crop yang menghilangkan judul halaman, navigasi aplikasi, atau konteks workflow utama.
- Semua screenshot adalah desktop. Uji UI mobile tetap dilakukan terpisah, tetapi mobile screenshot tidak diperlukan untuk manifest ini.

## Manifest screenshot

### 01 — Login

- **File final:** `docs/assets/images/screenshots/login.webp`
- **Halaman/route:** Login, `/login`
- **Akun/role:** Belum login
- **Data demo:** Form dalam keadaan kosong; tidak perlu mengetik credential
- **Harus terlihat:** Branding, judul Login, input identitas dan password, tombol masuk, serta tautan lupa password
- **Tidak boleh terlihat:** Password, password manager popup, autofill pribadi, error validasi, atau URL/path lokal
- **Viewport:** `1440 × 900`, desktop
- **README:** Core Workflows — Access
- **Static showcase:** Access and history
- **Nilai portfolio:** Menunjukkan entry point dan pola visual guest layout yang konsisten.

### 02 — Employee directory

- **File final:** `docs/assets/images/screenshots/employee-directory.webp`
- **Halaman/route:** User Management, `/data-user/users`
- **Akun/role:** `admin@example.com` — `Super Admin`
- **Data demo:** Daftar akun dari seeder; pertahankan beberapa role serta status aktif/tidak aktif
- **Harus terlihat:** Judul halaman, pencarian/filter bila tersedia, tabel atau card daftar user, role/status badge, dan aksi yang relevan
- **Tidak boleh terlihat:** Detail gaji, alamat lengkap, nomor telepon pribadi, menu akun terbuka, dialog hapus, atau toast
- **Viewport:** `1440 × 900`, desktop
- **README:** Core Workflows — People
- **Static showcase:** People and attendance
- **Nilai portfolio:** Menunjukkan direktori karyawan, status akun, role, dan administrative CRUD entry points.

### 03 — Employee attendance

- **File final:** `docs/assets/images/screenshots/attendance.webp`
- **Halaman/route:** Presensi, `/presensi`
- **Akun/role:** `employee@example.com` — `Karyawan`
- **Data demo:** Status hari berjalan dari akun demo; izin lokasi browser boleh ditolak jika koordinat tidak perlu ditampilkan
- **Harus terlihat:** Judul Presensi, status check-in/check-out, informasi waktu, kontrol aksi, dan ringkasan/konteks halaman
- **Tidak boleh terlihat:** Prompt izin lokasi browser, koordinat, peta dengan lokasi pribadi, error geolocation, atau notifikasi OS
- **Viewport:** `1440 × 900`, desktop
- **README:** Core Workflows — Attendance
- **Static showcase:** People and attendance
- **Nilai portfolio:** Menunjukkan workflow GPS-assisted attendance dan state-aware controls.

### 04 — Attendance history

- **File final:** `docs/assets/images/screenshots/attendance-history.webp`
- **Halaman/route:** Riwayat Presensi, `/presensi/riwayat`
- **Akun/role:** `employee@example.com` — `Karyawan`
- **Data demo:** Bulan saat demo seeder dijalankan; pilih tanggal yang memiliki presensi lengkap atau lembur
- **Harus terlihat:** Ringkasan bulanan, kalender, legenda status, dan panel detail tanggal bila muat
- **Tidak boleh terlihat:** Koordinat mentah, URL peta pribadi, data di luar demo seeder, atau kalender kosong
- **Viewport:** `1440 × 900`, desktop
- **README:** Core Workflows — Attendance
- **Static showcase:** Access and history (pengganti slot dashboard yang kurang representatif)
- **Nilai portfolio:** Menunjukkan visualisasi kalender, status system, dan detail operasional per hari.

### 05 — Leave management

- **File final:** `docs/assets/images/screenshots/leave.webp`
- **Halaman/route:** Izin, `/izin`
- **Akun/role:** `employee@example.com` — `Karyawan`
- **Data demo:** Riwayat izin fiktif dari seeder dan tanggal yang eligible jika form ikut ditampilkan
- **Harus terlihat:** Status eligibility, form pengajuan, riwayat/kalender izin, dan status yang tersedia
- **Tidak boleh terlihat:** Alasan pribadi nyata, tanggal sensitif, modal validasi, atau klaim approval workflow
- **Viewport:** `1440 × 900`, desktop
- **README:** Core Workflows — Leave
- **Static showcase:** Leave and overtime
- **Nilai portfolio:** Menunjukkan eligibility validation, pengajuan, dan riwayat izin tanpa mengklaim approval yang tidak ada.

### 06 — Overtime management

- **File final:** `docs/assets/images/screenshots/overtime.webp`
- **Halaman/route:** Lembur, `/lembur`
- **Akun/role:** `employee@example.com` — `Karyawan`
- **Data demo:** State lembur hari berjalan; gunakan data seeder tanpa mengubahnya menjadi data nyata
- **Harus terlihat:** Status aktivitas hari ini, kartu mulai/selesai lembur, waktu, dan state tombol
- **Tidak boleh terlihat:** Prompt geolocation, koordinat, lokasi pribadi, toast, atau klaim persetujuan lembur
- **Viewport:** `1440 × 900`, desktop
- **README:** Core Workflows — Overtime
- **Static showcase:** Leave and overtime
- **Nilai portfolio:** Menunjukkan workflow lembur dua tahap dan business-rule safeguards.

### 07 — Daily attendance report

- **File final:** `docs/assets/images/screenshots/reports-daily.webp`
- **Halaman/route:** Rekap Harian Presensi, `/admin/presensi/by-date`
- **Akun/role:** `admin@example.com` — `Super Admin`
- **Data demo:** Pilih salah satu tanggal kerja bulan berjalan yang memiliki beberapa record hasil seeder
- **Harus terlihat:** Pemilih tanggal, empat summary card, tombol PDF/Excel, header tabel, dan beberapa row operasional
- **Tidak boleh terlihat:** Tanggal kosong, link peta/koordinat pribadi, hasil export terbuka, menu akun, atau toast
- **Viewport:** `1440 × 900`, desktop
- **README:** Hero preview dan Core Workflows — Reporting
- **Static showcase:** Hero serta Reporting and payroll
- **Nilai portfolio:** Menjadi hero karena merangkum authorization, filtering, operational recap, sorting, dan export.

### 08 — Daily payroll detail

- **File final:** `docs/assets/images/screenshots/payroll-daily.webp`
- **Halaman/route:** Hitung Gaji Karyawan Harian, `/payroll/daily`
- **Akun/role:** `admin@example.com` — `Super Admin`
- **Data demo:** Pilih `employee@example.com`, gunakan periode berisi presensi seeded, lalu jalankan preview calculation
- **Harus terlihat:** Identitas karyawan fiktif, periode, ringkasan hadir/jam, tabel presensi, serta panel perhitungan gaji
- **Tidak boleh terlihat:** Print dialog, angka dari data nyata, field tanpa hasil, error request, atau credential
- **Viewport:** `1440 × 900`, desktop
- **README:** Core Workflows — Payroll
- **Static showcase:** Reporting and payroll
- **Nilai portfolio:** Menunjukkan service-backed calculation dari attendance, leave, overtime, dan printable detail.

## Urutan pengambilan yang disarankan

1. Ambil `login.webp` sebelum login.
2. Login sebagai `admin@example.com`, lalu ambil `employee-directory.webp`.
3. Pilih tanggal seeded dan ambil `reports-daily.webp`.
4. Hitung preview payroll akun harian dan ambil `payroll-daily.webp`.
5. Logout, login sebagai `employee@example.com`, lalu ambil `attendance.webp`.
6. Buka riwayat dan ambil `attendance-history.webp` pada bulan seeded.
7. Ambil `leave.webp`.
8. Ambil `overtime.webp`.

Setelah semua file tersedia, simpan tepat di `docs/assets/images/screenshots/` dan minta tahap integrasi berikutnya. Jangan menghapus placeholder sampai seluruh reference README dan static showcase sudah dipindahkan serta diverifikasi.

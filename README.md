# Romyverse (Artoverse)

Platform berbagi dan eksplorasi karya seni digital berbasis web. Romyverse adalah tempat seniman dapat memamerkan karya mereka dan penggemar seni dapat menemukan dan berinteraksi dengan lukisan-lukisan menarik.

## Fitur

- **Galeri Lukisan Pinterest-Style**: Tampilan galeri yang menarik dengan layout pinterest
- **Autentikasi User & Admin**: Sistem login dan registrasi yang aman
- **Upload Karya**: Kemudahan dalam mengunggah dan mengedit karya
- **Interaksi Sosial**: Fitur like dan komentar untuk berinteraksi dengan karya
- **Profil Publik**: Halaman profil untuk melihat semua karya seniman
- **Sistem Notifikasi**: Dapatkan notifikasi saat karya Anda mendapat interaksi
- **Pencarian**: Cari lukisan berdasarkan judul, seniman, atau tahun
- **Koleksi Favorit**: Simpan lukisan favorit dalam koleksi pribadi
- **Panel Admin**: Manajemen pengguna dan konten bagi administrator

## Teknologi

- **Backend**: Laravel 12
- **Frontend**: HTML, CSS, JavaScript, Bootstrap 5
- **Database**: MySQL
- **Libraries**: Swiper, FontAwesome, AOS Animation

## Instalasi

1. Clone repository:
   ```
   git clone https://github.com/USERNAME/romyverse.git
   cd romyverse
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Setup environment:
   ```
   cp .env.example .env
   php artisan key:generate
   ```

4. Konfigurasi database di file .env

5. Jalankan migrasi:
   ```
   php artisan migrate
   ```

6. Opsional, seed database:
   ```
   php artisan db:seed
   ```

7. Buat symlink untuk storage:
   ```
   php artisan storage:link
   ```

8. Jalankan aplikasi:
   ```
   php artisan serve
   ```

## Lisensi

Romyverse dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

## Kontributor

- Creator: Romyverse Team

## Screenshots

[Screenshots akan ditambahkan di sini]

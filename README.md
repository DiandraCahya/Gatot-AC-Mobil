# Tugas Akhir

> 🏆 **Achievement Unlock:** Melalui project Tugas Akhir ini, saya berhasil mendapatkan predikat **"Sangat Kompeten"**! Sebuah pencapaian yang sangat saya syukuri karena hanya 2 orang dari 1 kelas yang berhasil mendapatkan nilai tersebut.

Project ini adalah aplikasi web berbasis **Laravel 11**. Berikut adalah panduan langkah demi langkah untuk menginstal dan menjalankan project ini di lokal komputer Anda jika baru saja melakukan *clone*.

## Fitur Utama

- **Sistem Role (Admin & User)**: Pemisahan hak akses antara pengguna biasa dan administrator.
- **Manajemen Booking (Pemesanan)**: Pengguna dapat memesan layanan, sementara admin dapat menyetujui (approve) atau menolak (reject) pesanan.
- **Integrasi Payment Gateway (Midtrans)**: Pembayaran yang aman dan otomatis menggunakan Midtrans.
- **Pembuatan Struk/Invoice**: Generate struk atau invoice (PDF) untuk pesanan pengguna.
- **Live Chat (Real-time)**: Fitur obrolan langsung (chatting) menggunakan Livewire & Pusher.
- **Sistem Ulasan (Rating)**: Pengguna dapat memberikan ulasan dan rating untuk layanan yang telah selesai.
- **Manajemen Layanan/Jasa**: Admin dapat melakukan operasi CRUD untuk daftar layanan yang ditawarkan.


## Persyaratan Sistem

Sebelum memulai, pastikan sistem Anda sudah terinstal:
- **PHP** (sesuaikan dengan versi Laravel yang digunakan, disarankan >= 8.1)
- **Composer** (untuk mengelola package PHP)
- **Node.js & NPM** (untuk mengelola package frontend/Tailwind/Vite)
- **Database Server** (MySQL, PostgreSQL, atau SQLite)

## Cara Instalasi & Menjalankan Project

1. **Clone Repository**
   ```bash
   git clone https://github.com/DiandraCahya/Gatot-AC-Mobil.git
   cd Gatot-AC-Mobil
   ```

2. **Install Dependensi Backend (PHP)**
   Jalankan perintah ini untuk mengunduh folder `vendor/`:
   ```bash
   composer install
   ```

3. **Install Dependensi Frontend (Node.js)**
   Jalankan perintah ini untuk mengunduh folder `node_modules/`:
   ```bash
   npm install
   ```

4. **Konfigurasi Environment (.env)**
   Copy file contoh `.env` bawaan agar aplikasi bisa berjalan:
   ```bash
   cp .env.example .env
   ```
   *(Untuk pengguna Windows CMD, gunakan perintah: `copy .env.example .env`)*

   Buka file `.env` tersebut dan sesuaikan bagian koneksi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_kamu
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migrasi Database**
   Untuk membuat tabel-tabel ke dalam database yang sudah disiapkan:
   ```bash
   php artisan migrate
   ```

7. **Compile Aset Frontend (Vite)**
   ```bash
   npm run build
   ```
   *(Catatan: Gunakan `npm run dev` jika kamu sedang mendevelop/mengubah tampilan secara langsung)*

8. **Jalankan Server Lokal**
   ```bash
   php artisan serve
   ```

Aplikasi sekarang sudah berjalan dan dapat diakses di browser melalui: **[http://localhost:8000](http://localhost:8000)**

---
*Dibuat untuk keperluan Tugas Akhir (RPL - SMKN 2 SURABAYA).*

# Materi Presentasi: Deployment Aplikasi "Rex's Rents"

Dokumen ini disusun sebagai panduan dan materi presentasi untuk mata kuliah Cloud Computing. Dokumen ini dibagi menjadi dua bagian: Pengenalan Teknologi dan Panduan Setup Langkah-demi-Langkah.

---

## BAGIAN 1: PENGENALAN TEKNOLOGI & INFRASTRUKTUR

### 1. Sistem Operasi: Ubuntu Server
**Ubuntu Server** dipilih sebagai fondasi infrastruktur aplikasi ini karena:
*   **Ringan & Efisien**: Tidak menggunakan antarmuka grafis (GUI) sehingga seluruh resource (RAM/CPU) difokuskan murni untuk menjalankan layanan web dan database.
*   **Stabilitas (Enterprise-grade)**: Menjadi standar industri untuk deployment aplikasi Cloud karena minim *downtime* dan keamanannya yang kuat.
*   **Open Source**: Sepenuhnya gratis dengan dukungan komunitas terbesar di dunia.

### 2. Web Server: Apache (Apache2)
**Apache** berperan sebagai pelayan web (web server) yang memproses permintaan dari browser pengguna (client). Alasan penggunaannya:
*   **Keandalan Tinggi**: Apache adalah salah satu web server paling stabil dan banyak digunakan di seluruh dunia.
*   **Integrasi Mudah**: Sangat mudah diintegrasikan dengan PHP (melalui `libapache2-mod-php`) sehingga script PHP dapat langsung dieksekusi dan hasilnya dikirim kembali ke browser pengguna.

### 3. Database: MySQL
**MySQL** digunakan sebagai Sistem Manajemen Basis Data Relasional (RDBMS) dengan pertimbangan:
*   **Relasional & Terstruktur**: Sangat cocok untuk aplikasi sewa mobil yang membutuhkan relasi data ketat (misalnya relasi antara tabel `tb_pelanggan`, `tb_mobil`, dan `tb_transaksi`).
*   **Performa Tinggi**: Sangat cepat untuk operasi *Read* (membaca data mobil di katalog) maupun *Write* (mencatat transaksi penyewaan).

### 4. Bahasa Pemrograman & Framework (Tech Stack)
*   **Backend (PHP Native)**: Aplikasi ini dibangun menggunakan PHP murni tanpa framework besar (seperti Laravel/CodeIgniter). Tujuannya agar aplikasi sangat ringan, memori yang digunakan kecil, dan kecepatan pemrosesan data maksimal. PHP menangani logika bisnis, autentikasi (dengan *Bcrypt hashing* untuk keamanan password), dan interaksi ke MySQL (*Prepared Statements* untuk mencegah SQL Injection).
*   **Frontend (Tailwind CSS)**: Untuk tampilan antarmuka (UI), aplikasi ini menggunakan Tailwind CSS. Ini adalah *utility-first framework* yang memungkinkan pembuatan desain bertema **Brutalism** (desain modern dengan warna tegas, border tebal, dan animasi *hardware-accelerated* yang berjalan mulus di 60fps) secara cepat dan sangat responsif di berbagai ukuran layar.

---

## BAGIAN 2: PANDUAN SETUP (STEP-BY-STEP DEPLOYMENT)

Berikut adalah langkah-langkah riil yang dilakukan untuk mendeploy aplikasi ini ke dalam Ubuntu Server di lingkungan VirtualBox:

### Langkah 1: Persiapan Jaringan VirtualBox (Port Forwarding)
Karena Ubuntu Server dijalankan di VirtualBox menggunakan mode jaringan **NAT**, server tidak memiliki IP publik yang bisa diakses langsung dari Windows. Solusinya adalah *Port Forwarding*:
1. Buka pengaturan VirtualBox -> **Network** -> **Advanced** -> **Port Forwarding**.
2. Buat aturan baru untuk mengarahkan lalu lintas dari Windows ke Ubuntu:
   * **Host Port**: `8080`
   * **Guest Port**: `80` (Port default web server HTTP).

### Langkah 2: Instalasi LAMP Stack
LAMP (Linux, Apache, MySQL, PHP) adalah kumpulan perangkat lunak untuk menjalankan website dinamis. Perintah yang dijalankan di terminal Ubuntu:
```bash
sudo apt update
sudo apt install apache2 mysql-server php php-mysqli libapache2-mod-php php-gd -y
```

### Langkah 3: Mengunduh Source Code Aplikasi
Kode sumber aplikasi diunduh secara otomatis dari repository GitHub langsung ke folder publik web server (`/var/www/html`):
```bash
# Menghapus file default bawaan Apache
sudo rm -rf /var/www/html/*

# Mengunduh branch "main" dari GitHub
sudo git clone -b main https://github.com/ahmdraihn/rexrent-web-app.git .

# Memberikan hak akses folder agar admin bisa upload foto mobil
sudo chown -R www-data:www-data /var/www/html/web-app/assets/images/mobil/
sudo chmod -R 775 /var/www/html/web-app/assets/images/mobil/
```

### Langkah 4: Konfigurasi Database
Membuat pengguna khusus (`rexuser`) untuk keamanan, daripada menggunakan akun `root` bawaan:
```bash
sudo mysql
```
*(Di dalam konsol MySQL):*
```sql
CREATE DATABASE db_rexrents;
CREATE USER 'rexuser'@'localhost' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON db_rexrents.* TO 'rexuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

Setelah database siap, struktur tabel dan data awal (*dummy data*) diimpor:
```bash
sudo mysql db_rexrents < web-app/database.sql
```

### Langkah 5: Menghubungkan Aplikasi ke Database
Langkah terakhir adalah memberi tahu aplikasi PHP (melalui file konfigurasi) cara untuk masuk ke database MySQL:
```bash
sudo nano web-app/config.php
```
Mengubah konfigurasi menjadi:
*   `define('DB_USER', 'rexuser');`
*   `define('DB_PASS', '123');`

Setelah disimpan, website sudah sepenuhnya berhasil dideploy dan dapat diakses dari Windows (Host) melalui browser pada alamat:
👉 **http://localhost:8080/web-app/**

---

## BAGIAN 3: KENDALA & SOLUSI SELAMA DEPLOYMENT
Untuk melengkapi presentasi (biasanya dosen akan menanyakan ini), berikut adalah beberapa kendala *real* yang dihadapi selama proses pemindahan aplikasi dari XAMPP Windows ke lingkungan Linux (Ubuntu Server) beserta solusinya:

### 1. Masalah Jaringan VirtualBox (Terjebak Captive Portal Wi-Fi Kampus)
*   **Kendala**: Saat menggunakan mode *Bridged Adapter*, Ubuntu gagal mengunduh paket (`apt update`) karena koneksi internet dialihkan ke halaman login Wi-Fi kampus, sedangkan server tidak memiliki GUI/Browser untuk login.
*   **Solusi**: Mengubah mode jaringan VirtualBox menjadi **NAT** agar Ubuntu Server menumpang koneksi internet dari Windows (yang sudah login Wi-Fi).

### 2. Akses Aplikasi dari Host (Limitasi NAT)
*   **Kendala**: Mode NAT membuat IP Ubuntu tersembunyi (biasanya `10.0.x.x`), sehingga browser di Windows tidak bisa langsung membuka website melalui IP tersebut.
*   **Solusi**: Melakukan konfigurasi **Port Forwarding** di VirtualBox dengan mengarahkan Port Host `8080` ke Port Guest `80` (Apache).

### 3. Masalah Kredensial Database (Access Denied)
*   **Kendala**: Terdapat pesan *HTTP Error 500* karena file `config.php` masih menggunakan username bawaan XAMPP (`root` tanpa password), sedangkan di Ubuntu kita membuat *user* MySQL yang jauh lebih aman (`rexuser`).
*   **Solusi**: Mengedit file `/var/www/html/web-app/config.php` melalui terminal Ubuntu dan menyesuaikan `DB_USER` dan `DB_PASS` dengan kredensial Ubuntu Server.

### 4. Gagal Upload Foto (Masalah Hak Akses/Permissions)
*   **Kendala**: Data mobil berhasil disimpan ke database, tetapi foto gagal diupload (*broken image*). Hal ini karena direktori `/assets/images/mobil/` terkunci oleh `root` (karena proses *git clone* menggunakan `sudo`).
*   **Solusi**: Mengubah kepemilikan folder (*ownership*) ke *user* Apache dengan perintah `sudo chown -R www-data:www-data` dan mengubah *permission* menjadi `775`.

### 5. Limitasi Ukuran File Bawaan Server
*   **Kendala**: Gambar dengan resolusi tinggi atau berukuran besar ditolak diam-diam oleh server saat diunggah.
*   **Solusi**: Mengedit konfigurasi inti PHP (`/etc/php/8.3/apache2/php.ini`) untuk menaikkan `upload_max_filesize` dan `post_max_size` dari bawaan 2MB menjadi 10MB, lalu me-*restart* Apache.

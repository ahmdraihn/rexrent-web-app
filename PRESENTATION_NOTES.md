# Catatan Presentasi & Penjelasan Teknis - Rex's Rents

Dokumen ini berisi informasi detail mengenai arsitektur dan fitur aplikasi untuk membantu dalam presentasi tugas Cloud Computing.

---

## 1. Teknologi (Tech Stack)
*   **Bahasa Pemrograman**: PHP 8.2 (Backend) & JavaScript (Frontend).
*   **Database**: MySQL 8.0 atau MariaDB 10.5.
*   **Desain UI**: Tailwind CSS dengan tema **Brutalism** (Vibrant colors, thick borders, modern typography).
*   **Server**: Apache 2.4 pada lingkungan Ubuntu Server.

## 2. Keamanan (Security Features)
Sebagai aplikasi yang dirancang untuk lingkungan Cloud, keamanan adalah prioritas utama:
*   **Password Hashing (Bcrypt)**: Menggunakan fungsi `password_hash()` dan `password_verify()` dari PHP. Password tidak disimpan dalam bentuk teks biasa, sehingga aman dari pencurian data.
*   **Prepared Statements**: Melindungi aplikasi dari serangan **SQL Injection**. Semua input pengguna diproses secara aman sebelum berinteraksi dengan database.
*   **Session Management**: Sistem autentikasi yang aman untuk memisahkan hak akses antara **Admin** dan **Employee (Pegawai)**.

## 3. Optimasi Performa (Performance Optimization)
*   **GPU Acceleration**: Menggunakan properti CSS `will-change` dan `translateZ(0)` pada elemen animasi (seperti marquee dan hero section). Hal ini memindahkan beban rendering ke kartu grafis (GPU), menghasilkan pergerakan yang mulus (60 FPS).
*   **Specific Transitions**: Optimasi CSS dengan mengganti `transition: all` menjadi properti spesifik untuk mengurangi beban kerja browser saat rendering.
*   **Database Indexing**: Menambahkan indeks pada kolom-kolom penting seperti `status` mobil dan `tanggal` transaksi untuk mempercepat query pada dashboard.

## 4. Fitur Utama Aplikasi
*   **Dashboard Statistik**: Ringkasan data mobil, pelanggan, dan transaksi secara real-time.
*   **Manajemen Mobil (CRUD)**: Admin dapat menambah, mengedit, dan menghapus data mobil beserta **upload foto** secara langsung.
*   **Manajemen Pelanggan**: Pegawai memiliki akses khusus untuk mendaftarkan pelanggan baru agar proses sewa lebih cepat.
*   **Sistem Pengembalian & Denda**: Perhitungan denda otomatis jika mobil dikembalikan melewati batas waktu yang ditentukan.
*   **Database Seeder**: Skrip `seed.php` untuk mempermudah reset dan pengisian data awal (dummy data) secara otomatis.

---

## 5. Kesimpulan untuk Cloud Computing
Aplikasi ini memenuhi kriteria Cloud-Ready karena:
1.  **Portable**: Mudah dideploy ke server Linux (Ubuntu) menggunakan instruksi standar.
2.  **Secure**: Mengikuti standar keamanan web modern.
3.  **Performant**: Dioptimalkan untuk pengalaman pengguna yang responsif.

# Rex's Rents - Web Application
## Aplikasi Sewa Mobil (Ubuntu Server - Apache - MySQL)

Aplikasi web untuk manajemen sewa mobil, dikonversi dari Java Desktop Application ke Web Application untuk tugas Cloud Computing.

---

## 🚀 Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP 8.x
- **Database:** MySQL 8.x
- **Web Server:** Apache 2.x
- **OS:** Ubuntu Server 20.04+ LTS

---

## 📁 Struktur Folder

```
web-app/
├── index.php              # Landing page
├── login.php              # Login page
├── logout.php             # Logout handler
├── config.php             # Database configuration
├── database.sql           # Database schema & sample data
├── DEPLOYMENT.md          # Deployment guide
├── README.md              # This file
├── assets/
│   └── css/
│       └── style.css      # Main stylesheet
├── admin/                 # Admin panel
│   ├── dashboard.php      # Admin dashboard
│   ├── cars.php           # Car management (CRUD)
│   ├── customers.php      # Customer management (CRUD)
│   ├── transactions.php   # Transaction history
│   └── includes/
│       ├── sidebar.php    # Admin sidebar navigation
│       └── header.php     # Admin header
└── employee/              # Employee panel
    ├── dashboard.php      # Employee dashboard
    ├── rental.php         # Add new rental
    ├── return.php         # Return car processing
    └── includes/
        ├── sidebar.php    # Employee sidebar navigation
        └── header.php     # Employee header
```

---

## ✨ Fitur

### Landing Page (Public)
- Hero section dengan CTA
- Daftar armada yang tersedia
- Fitur dan keunggulan
- Informasi kontak
- Responsive design

### Admin Panel
- **Dashboard:**
  - Statistik (total mobil, pelanggan, transaksi)
  - Pendapatan kotor & bersih
  - Biaya maintenance
  - Top 5 pelanggan
  - Transaksi terbaru

- **Data Mobil (CRUD):**
  - Tambah mobil baru
  - Edit data mobil
  - Hapus mobil
  - Set status available/unavailable
  - Auto-generate ID mobil

- **Data Pelanggan (CRUD):**
  - Tambah pelanggan baru
  - Edit data pelanggan
  - Hapus pelanggan
  - Auto-generate ID pelanggan

- **Data Transaksi:**
  - Lihat semua transaksi
  - Filter status (disewa/dikembalikan)
  - Hapus transaksi

### Employee Panel
- **Dashboard:**
  - Statistik transaksi
  - Mobil tersedia vs disewa
  - Transaksi aktif
  - Quick actions

- **Tambah Sewa:**
  - Pilih pelanggan
  - Pilih mobil tersedia
  - Set durasi sewa (1-30 hari)
  - Kalkulasi total harga otomatis

- **Kembalikan Mobil:**
  - Daftar mobil sedang disewa
  - Input keterlambatan
  - Kalkulasi denda otomatis (10% dari harga sewa/hari)
  - Update status mobil ke available

---

## 🔐 Default Login

### Admin
- **Username:** `admin`
- **Password:** `admin123`

### Pegawai
- **Username:** `pegawai`
- **Password:** `pegawai123`

**⚠️ PENTING:** Ganti password default sebelum production!

---

## 📦 Instalasi Lokal (Development)

### Prasyarat
- XAMPP / WAMP / LAMP
- PHP 8.x
- MySQL 8.x

### Langkah Instalasi

1. **Copy ke htdocs/www**
   ```bash
   # XAMPP (Windows)
   Copy folder ke: C:\xampp\htdocs\rexsrents
   
   # Linux LAMP
   Copy ke: /var/www/html/rexsrents
   ```

2. **Import Database**
   - Buka phpMyAdmin (`http://localhost/phpmyadmin`)
   - Buat database baru: `db_rexrents`
   - Import file `database.sql`

3. **Konfigurasi Database**
   Edit `config.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Sesuaikan
   define('DB_NAME', 'db_rexrents');
   ```

4. **Akses Aplikasi**
   ```
   http://localhost/rexsrents/
   ```

---

## 🌐 Deployment ke Ubuntu Server

Lihat panduan lengkap di **DEPLOYMENT.md**

### Quick Start

```bash
# Install LAMP stack
sudo apt update
sudo apt install apache2 mysql-server php libapache2-mod-php php-mysql -y

# Import database
sudo mysql -u root -p db_rexrents < database.sql

# Copy files
sudo cp -r * /var/www/html/

# Set permissions
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/

# Restart Apache
sudo systemctl restart apache2
```

---

## 🗄️ Database Schema

### tb_akun
- id_akun (PK)
- username
- password
- role (Admin/Employee)
- created_at

### tb_mobil
- id_mobil (PK)
- model
- merk
- hargasewa
- status (available/unavailable)
- foto
- biaya_maintenance
- created_at

### tb_pelanggan
- id_pelanggan (PK)
- nama
- noHP
- noKTP
- alamat
- gender (L/P)
- created_at

### tb_transaksi
- id_transaksi (PK)
- tanggal
- id_pelanggan (FK)
- id_mobil (FK)
- durasi
- denda
- total_harga
- tanggal_kembali
- status_kembali
- created_at

---

## 🎨 UI/UX Features

- Responsive design (mobile-friendly)
- Modern gradient color scheme
- Smooth animations & transitions
- Sidebar navigation dengan collapse
- Modal dialogs untuk konfirmasi
- Alert messages untuk feedback
- Real-time kalkulasi harga
- Table dengan sorting & pagination (basic)

---

## 🔧 Customization

### Ganti Warna Theme
Edit `assets/css/style.css`:

```css
:root {
    --primary-color: #ff5733;    /* Warna utama */
    --secondary-color: #3385ff;  /* Warna sekunder */
    --success-color: #28a745;    /* Success/hijau */
    --danger-color: #dc3545;     /* Danger/merah */
}
```

### Tambah Logo
Ganti emoji di `sidebar.php` dan `index.php` dengan tag `<img>`:

```php
<!-- Ganti ini: -->
<h1>🚗 Rex's Rents</h1>

<!-- Dengan: -->
<img src="assets/images/logo.png" alt="Rex's Rents" class="logo">
```

---

## 🐛 Troubleshooting

### Error: Connection refused
- Cek MySQL berjalan: `sudo systemctl status mysql`
- Cek kredensial di `config.php`

### Error: Permission denied
```bash
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
```

### Halaman blank
- Enable error display di `config.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### CSS tidak load
- Cek path file CSS
- Clear browser cache (Ctrl+F5)

---

## 📝 Catatan

- Aplikasi ini dikembangkan untuk tujuan edukasi (tugas Cloud Computing)
- Password disimpan plain text (untuk development saja)
- Untuk production, gunakan password hashing (bcrypt)
- Tambahkan validasi input lebih ketat untuk production
- Implementasikan CSRF protection untuk keamanan

---

## 📚 Learning Outcomes

Dari proyek ini, Anda belajar:
- Migrasi dari Java Desktop ke Web Application
- LAMP Stack deployment
- CRUD operations dengan PHP & MySQL
- Session management untuk authentication
- Responsive web design
- Database relational design
- Ubuntu Server administration

---

## 👨‍💻 Developer

Dikembangkan untuk tugas Cloud Computing - Aplikasi Sewa Mobil

---

## 📄 License

Educational purposes only.

---

## 🙏 Acknowledgments

- Java Swing original version
- Bootstrap-inspired design patterns
- PHP best practices community

---

**© 2024 Rex's Rents - Car Rental Management System**

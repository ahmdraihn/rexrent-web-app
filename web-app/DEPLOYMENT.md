# Rex's Rents - Deployment Guide
## Ubuntu Server - Apache - MySQL

Panduan lengkap untuk mendeploy Aplikasi Sewa Mobil Rex's Rents ke Ubuntu Server.

---

## Prasyarat

- Ubuntu Server 20.04 LTS atau lebih baru
- Akses root atau sudo
- Koneksi internet

---

## Langkah 1: Update Sistem

```bash
sudo apt update && sudo apt upgrade -y
```

---

## Langkah 2: Install Apache Web Server

```bash
sudo apt install apache2 -y
sudo systemctl start apache2
sudo systemctl enable apache2
```

Verifikasi Apache berjalan:
```bash
sudo systemctl status apache2
```

---

## Langkah 3: Install MySQL Server

```bash
sudo apt install mysql-server -y
sudo systemctl start mysql
sudo systemctl enable mysql
```

Amankan instalasi MySQL:
```bash
sudo mysql_secure_installation
```

Jawab pertanyaan:
- Validate password plugin: `No` (atau `Y` jika ingin validasi)
- Change root password: `No` (gunakan password kosong untuk development)
- Remove anonymous users: `Y`
- Disallow root login remotely: `Y`
- Remove test database: `Y`
- Reload privilege tables: `Y`

---

## Langkah 4: Install PHP dan Extension

```bash
sudo apt install php libapache2-mod-php php-mysql php-cli php-curl php-gd php-mbstring php-xml php-zip -y
```

Verifikasi instalasi PHP:
```bash
php -v
```

Restart Apache:
```bash
sudo systemctl restart apache2
```

---

## Langkah 5: Setup Database

### 5.1 Buat Database dan User

```bash
sudo mysql -u root -p
```

Jalankan perintah SQL berikut:

```sql
-- Buat database
CREATE DATABASE db_rexrents;

-- Buat user untuk aplikasi
CREATE USER 'rexrents_user'@'localhost' IDENTIFIED BY 'rexrents_password123';

-- Berikan privilege
GRANT ALL PRIVILEGES ON db_rexrents.* TO 'rexrents_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 5.2 Import Schema Database

Copy file `database.sql` ke server:
```bash
scp database.sql user@your-server-ip:/tmp/
```

Import database:
```bash
sudo mysql -u root -p db_rexrents < /tmp/database.sql
```

Atau login ke MySQL dan source file:
```bash
sudo mysql -u root -p
USE db_rexrents;
SOURCE /tmp/database.sql;
EXIT;
```

---

## Langkah 6: Deploy Aplikasi

### 6.1 Copy File Aplikasi

Copy semua file web-app ke directory Apache:

```bash
sudo cp -r web-app/* /var/www/html/
```

Atau gunakan SCP dari lokal:
```bash
scp -r web-app/* user@your-server-ip:/var/www/html/
```

### 6.2 Set Permission

```bash
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
```

---

## Langkah 7: Konfigurasi Database

Edit file `config.php`:

```bash
sudo nano /var/www/html/config.php
```

Update konfigurasi database:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'rexrents_user');
define('DB_PASS', 'rexrents_password123');
define('DB_NAME', 'db_rexrents');
```

Simpan dengan `Ctrl+X`, lalu `Y`, lalu `Enter`.

---

## Langkah 8: Konfigurasi Apache (Opsional)

### Buat Virtual Host (Opsional)

```bash
sudo nano /etc/apache2/sites-available/rexsrents.conf
```

Isi dengan:

```apache
<VirtualHost *:80>
    ServerName your-domain.com
    ServerAlias www.your-domain.com
    DocumentRoot /var/www/html
    
    <Directory /var/www/html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

Aktifkan site:
```bash
sudo a2ensite rexsrents.conf
sudo a2dissite 000-default.conf
sudo systemctl reload apache2
```

---

## Langkah 9: Konfigurasi Firewall

Jika firewall aktif, izinkan HTTP dan HTTPS:

```bash
sudo ufw allow 'Apache Full'
sudo ufw status
```

---

## Langkah 10: Verifikasi Instalasi

### Test Apache
Buka browser dan akses:
```
http://your-server-ip/
```

### Test PHP
Buat file test:
```bash
sudo nano /var/www/html/info.php
```

Isi dengan:
```php
<?php
phpinfo();
?>
```

Akses: `http://your-server-ip/info.php`

**PENTING**: Hapus file test setelah selesai!
```bash
sudo rm /var/www/html/info.php
```

---

## Langkah 11: Akses Aplikasi

### Landing Page
```
http://your-server-ip/
```

### Login Admin
```
http://your-server-ip/login.php
```

**Default Login:**
- **Admin:**
  - Username: `admin`
  - Password: `admin123`

- **Pegawai:**
  - Username: `pegawai`
  - Password: `pegawai123`

---

## Troubleshooting

### Apache tidak berjalan
```bash
sudo systemctl start apache2
sudo systemctl status apache2
```

### MySQL tidak berjalan
```bash
sudo systemctl start mysql
sudo systemctl status mysql
```

### Error koneksi database
1. Cek konfigurasi di `config.php`
2. Pastikan user MySQL memiliki privilege yang benar
3. Cek MySQL log: `sudo tail -f /var/log/mysql/error.log`

### Error permission
```bash
sudo chown -R www-data:www-data /var/www/html/
sudo chmod -R 755 /var/www/html/
```

### Enable error logging (untuk debugging)
Edit `/etc/php/8.x/apache2/php.ini`:
```ini
display_errors = On
error_reporting = E_ALL
```

Restart Apache:
```bash
sudo systemctl restart apache2
```

---

## Keamanan (Production)

### 1. Ganti Password Default
```sql
UPDATE tb_akun SET password = 'password_baru_anda' WHERE username = 'admin';
```

### 2. Gunakan HTTPS (SSL)
```bash
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache -d your-domain.com
```

### 3. Backup Database Rutin
```bash
#!/bin/bash
# backup.sh
DATE=$(date +%Y%m%d_%H%M%S)
mysqldump -u rexrents_user -p'rexrents_password123' db_rexrents > /backups/db_rexrents_$DATE.sql
```

Jadwalkan dengan cron:
```bash
sudo crontab -e
# Tambahkan: 0 2 * * * /path/to/backup.sh
```

---

## Struktur File

```
/var/www/html/
├── index.php           # Landing page
├── login.php           # Login page
├── logout.php          # Logout handler
├── config.php          # Database configuration
├── database.sql        # Database schema
├── assets/
│   └── css/
│       └── style.css   # Stylesheet
├── admin/
│   ├── dashboard.php   # Admin dashboard
│   ├── cars.php        # Car management
│   ├── customers.php   # Customer management
│   ├── transactions.php# Transaction management
│   └── includes/
│       ├── sidebar.php # Admin sidebar
│       └── header.php  # Admin header
└── employee/
    ├── dashboard.php   # Employee dashboard
    ├── rental.php      # Add rental
    ├── return.php      # Return car
    └── includes/
        ├── sidebar.php # Employee sidebar
        └── header.php  # Employee header
```

---

## Fitur Aplikasi

### Admin
- Dashboard dengan statistik
- Manajemen Data Mobil (CRUD)
- Manajemen Data Pelanggan (CRUD)
- Lihat semua transaksi
- Statistik keuangan (Bruto, Netto, Maintenance)

### Pegawai
- Dashboard dengan statistik
- Tambah transaksi sewa baru
- Proses pengembalian mobil
- Hitung denda keterlambatan otomatis

---

## Kontak & Support

Untuk pertanyaan atau masalah, hubungi administrator sistem.

---

**© 2024 Rex's Rents - Aplikasi Sewa Mobil**

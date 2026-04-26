# Rex's Rents - Cloud Computing Assignment
## Aplikasi Sewa Mobil

Proyek migrasi aplikasi Java Desktop ke Web Application untuk tugas Cloud Computing.

---

## 📁 Struktur Folder

```
rexrent/
├── Rexs-Rents/              # Original Java Desktop App (kept for reference)
│   ├── .git/                # Git repository
│   ├── .vscode/             # VS Code settings
│   └── README.md            # Original Java app documentation
│
└── web-app/                 # NEW: PHP Web Application (for deployment)
    ├── index.php            # Landing page
    ├── login.php            # Login page
    ├── logout.php           # Logout handler
    ├── config.php           # Database configuration
    ├── database.sql         # Database schema
    ├── README.md            # Web app documentation
    ├── DEPLOYMENT.md        # Ubuntu server deployment guide
    ├── admin/               # Admin panel
    ├── employee/            # Employee panel
    └── assets/
        ├── css/             # Stylesheets
        └── images/          # Images & car photos
```

---

## 🚀 Quick Start

### Development (Local)
1. Install XAMPP/WAMP
2. Copy `web-app/` ke `htdocs/`
3. Import `database.sql` ke MySQL
4. Akses `http://localhost/web-app/`

### Production (Ubuntu Server)
Lihat `web-app/DEPLOYMENT.md` untuk panduan lengkap.

---

## 🔐 Default Login

| Role   | Username | Password    |
|--------|----------|-------------|
| Admin  | admin    | admin123    |
| Pegawai| pegawai  | pegawai123  |

---

## 📋 Fitur

### Admin
- Dashboard dengan statistik
- CRUD Mobil
- CRUD Pelanggan
- Manajemen Transaksi
- Laporan Keuangan

### Pegawai
- Dashboard
- Tambah Sewa
- Kembalikan Mobil (dengan denda)

---

## 🛠️ Tech Stack

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP 8.x
- **Database:** MySQL 8.x
- **Web Server:** Apache 2.x
- **OS:** Ubuntu Server 20.04+

---

## 📝 Catatan

- Folder `Rexs-Rents/` berisi aplikasi Java asli (untuk referensi)
- Folder `web-app/` adalah aplikasi web baru untuk deployment
- Semua file Java source (`.java`) dan libraries (`.jar`) sudah dihapus
- Assets gambar sudah dipindahkan ke `web-app/assets/images/`

---

**© 2024 Rex's Rents - Cloud Computing Assignment**

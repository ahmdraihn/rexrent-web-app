-- Rex's Rents Database - Indonesia Realistic Pricing
-- All prices in Indonesian Rupiah (IDR)
-- Based on Indonesian car rental market research 2024

CREATE DATABASE IF NOT EXISTS db_rexrents CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_rexrents;
SET FOREIGN_KEY_CHECKS = 0;

-- Accounts table
DROP TABLE IF EXISTS tb_akun;
CREATE TABLE tb_akun (
    id_akun INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Employee') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Cars table with realistic Indonesian rental prices
DROP TABLE IF EXISTS tb_mobil;
CREATE TABLE tb_mobil (
    id_mobil VARCHAR(10) PRIMARY KEY,
    model VARCHAR(100) NOT NULL,
    merk VARCHAR(100) NOT NULL,
    hargasewa DECIMAL(15,2) NOT NULL,
    status BOOLEAN DEFAULT TRUE,
    foto VARCHAR(255) DEFAULT '',
    biaya_maintenance DECIMAL(15,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Customers table
DROP TABLE IF EXISTS tb_pelanggan;
CREATE TABLE tb_pelanggan (
    id_pelanggan VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    noHP VARCHAR(20) NOT NULL,
    noKTP VARCHAR(20) NOT NULL,
    alamat TEXT NOT NULL,
    gender ENUM('L', 'P') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Transactions table
DROP TABLE IF EXISTS tb_transaksi;
CREATE TABLE tb_transaksi (
    id_transaksi VARCHAR(10) PRIMARY KEY,
    tanggal DATE NOT NULL,
    id_pelanggan VARCHAR(10) NOT NULL,
    id_mobil VARCHAR(10) NOT NULL,
    durasi INT NOT NULL,
    denda DECIMAL(15,2) DEFAULT 0,
    total_harga DECIMAL(15,2) NOT NULL,
    tanggal_kembali DATE DEFAULT NULL,
    status_kembali BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pelanggan) REFERENCES tb_pelanggan(id_pelanggan) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_mobil) REFERENCES tb_mobil(id_mobil) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Default accounts (admin123 / pegawai123)
INSERT INTO tb_akun (username, password, role) VALUES 
('admin', '$2y$10$.RTkFDqInpb/PzoIT.ZKpOePyhLBrR6LhIVmb/P4YQueSR2yATVBe', 'Admin'),
('pegawai', '$2y$10$s6wP1mUGqPMgwrHqySamuesnHTaT4YvGOaSctypsn7niWNCwVqscu', 'Employee');

-- All 27 cars with REALISTIC INDONESIAN RENTAL PRICES (per day)
-- Prices based on Jakarta car rental market research 2024
-- Includes basic insurance and admin fees

INSERT INTO tb_mobil (id_mobil, model, merk, hargasewa, status, foto, biaya_maintenance) VALUES 
-- LCGC / Economy City Cars (Popular for city driving)
('M01', 'Agya', 'Toyota', 250000, TRUE, '13_agya.png', 25000),
('M02', 'Brio', 'Honda', 275000, TRUE, '4_brio.png', 27500),
('M03', 'Calya', 'Toyota', 250000, TRUE, '14_calya.png', 25000),
('M04', 'Ayla', 'Daihatsu', 240000, TRUE, '13_agya.png', 24000),

-- MPV 7-Seaters (Most popular category in Indonesia)
('M05', 'Avanza', 'Toyota', 350000, TRUE, '16_avanza.png', 35000),
('M06', 'Xenia', 'Toyota', 350000, TRUE, '3_xenia.png', 35000),
('M07', 'Xpander', 'Mitsubishi', 400000, TRUE, '10_xpander.png', 40000),
('M08', 'Stargazer', 'Mitsubishi', 400000, TRUE, '11_stargazer.png', 40000),
('M09', 'Mobilio', 'Honda', 375000, TRUE, '5_mobilio.png', 37500),
('M10', 'Ertiga', 'Suzuki', 350000, TRUE, '25_ertiga.png', 35000),
('M11', 'Livina', 'Nissan', 350000, TRUE, '10_xpander.png', 35000),

-- SUV Category (Growing popularity)
('M12', 'HRV', 'Honda', 500000, TRUE, '8_hrv.png', 50000),
('M13', 'Fortuner', 'Toyota', 750000, TRUE, '15_fortuner.png', 75000),
('M14', 'Pajero Sport', 'Mitsubishi', 700000, TRUE, '15_fortuner.png', 70000),
('M15', 'Rush', 'Toyota', 400000, TRUE, '17_rush.png', 40000),
('M16', 'Terios', 'Daihatsu', 375000, TRUE, '17_rush.png', 37500),

-- Sedans (Business/Executive)
('M17', 'Civic', 'Honda', 550000, TRUE, '6_civic.png', 55000),
('M18', 'City', 'Honda', 350000, TRUE, '9_city.png', 35000),
('M19', 'Yaris', 'Toyota', 400000, TRUE, '18_yaris.png', 40000),
('M20', 'Corolla', 'Toyota', 500000, TRUE, '18_yaris.png', 50000),

-- Premium MPV / SUV
('M21', 'Innova Reborn', 'Toyota', 550000, TRUE, '20_innova.png', 55000),
('M22', 'Innova Zenix', 'Toyota', 600000, TRUE, '19_zenix.png', 60000),
('M23', 'Hiace', 'Toyota', 900000, TRUE, '22_hiace.png', 90000),

-- Luxury Sedans
('M24', 'Camry', 'Toyota', 800000, TRUE, '21_camry.png', 80000),
('M25', 'Alphard', 'Toyota', 1500000, TRUE, '23_alphard.png', 150000),

-- Supercars (Special occasion / Events / Photo shoots)
('M26', 'Aventador', 'Lamborghini', 18000000, TRUE, '26_aventador.png', 1800000),
('M27', 'Chiron', 'Bugatti', 100000000, TRUE, '27_chiron.png', 10000000);

-- Sample customers
INSERT INTO tb_pelanggan (id_pelanggan, nama, noHP, noKTP, alamat, gender) VALUES 
('P001', 'Ahmad Rizki', '081234567890', '3171234567890123', 'Jl. Sudirman No. 123, Jakarta Pusat', 'L'),
('P002', 'Siti Nurhaliza', '081234567891', '3271234567890124', 'Jl. Asia Afrika No. 45, Bandung', 'P'),
('P003', 'Budi Santoso', '081234567892', '3371234567890125', 'Jl. Tunjungan No. 78, Surabaya', 'L'),
('P004', 'Dewi Lestari', '081234567893', '3471234567890126', 'Jl. Malioboro No. 12, Yogyakarta', 'P'),
('P005', 'Eko Prasetyo', '081234567894', '3571234567890127', 'Jl. Pandanaran No. 56, Semarang', 'L');

-- Sample transactions (completed)
INSERT INTO tb_transaksi (id_transaksi, tanggal, id_pelanggan, id_mobil, durasi, denda, total_harga, status_kembali, tanggal_kembali) VALUES 
('TRX0001', '2024-01-10', 'P001', 'M05', 3, 0, 1050000, TRUE, '2024-01-13'),
('TRX0002', '2024-01-15', 'P002', 'M07', 5, 0, 2000000, TRUE, '2024-01-20'),
('TRX0003', '2024-02-01', 'P003', 'M12', 2, 0, 1000000, TRUE, '2024-02-03'),
('TRX0004', '2024-02-10', 'P004', 'M06', 4, 50000, 1450000, TRUE, '2024-02-14'),
('TRX0005', '2024-02-20', 'P005', 'M21', 3, 0, 1650000, TRUE, '2024-02-23');

-- Create indexes for better performance
CREATE INDEX idx_mobil_status ON tb_mobil(status);
CREATE INDEX idx_transaksi_tanggal ON tb_transaksi(tanggal);
CREATE INDEX idx_transaksi_status ON tb_transaksi(status_kembali);
SET FOREIGN_KEY_CHECKS = 1;

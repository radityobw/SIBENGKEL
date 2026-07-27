# Dokumentasi & Panduan Query Database Direct — SIBENGKEL
## Panduan Eksekusi SQL, Eloquent ORM & Artisan Tinker

> **Sistem Basis Data:** MySQL 8.0+ / MariaDB 10.4+  
> **Database Name:** `sibengkel`  
> **Framework ORM:** Eloquent ORM (Laravel 12)  
> **Tujuan Dokumen:** Panduan lengkap eksekusi query langsung (Raw SQL, Query Builder, Eloquent, dan Tinker) untuk keperluan operasional, pengujian, analitik, dan demonstrasi sidang basis data.

---

## 📌 Peta Navigasi Dokumen

| No | Bagian | Deskripsi Ringkas |
|:--:|:---|:---|
| 1 | [Metode Akses Database](#1-metode-akses-database) | Cara terhubung via CLI, Artisan Tinker, & DB GUI |
| 2 | [Kamus & Struktur Skema Tabel (DDL)](#2-kamus--struktur-skema-tabel-ddl) | Definisi tabel, Foreign Keys, Index & Constraints |
| 3 | [Data Manipulation Language (DML)](#3-data-manipulation-language-dml) | Query INSERT, UPDATE, DELETE (SQL vs Eloquent) |
| 4 | [Data Query Language (DQL) & Analitik](#4-data-query-language-dql--analitik) | Query SELECT, JOIN 5 Tabel, Agregasi, & Filter |
| 5 | [Interaktif Testing via Artisan Tinker](#5-interaktif-testing-via-artisan-tinker) | Snippet PHP Tinker untuk verifikasi data instan |
| 6 | [Database Administration & Backup](#6-database-administration--backup) | Backup `mysqldump`, Restore, & Fresh Seeding |

---

## 1. Metode Akses Database

### A. Melalui Terminal / Command Line Interface (CLI)

```bash
# 1. Masuk ke prompt MySQL
mysql -u root -p

# 2. Pilih database SIBENGKEL
USE sibengkel;

# 3. Tampilkan seluruh tabel
SHOW TABLES;

# 4. Tampilkan struktur tabel tertentu
DESCRIBE service_transactions;
```

---

### B. Melalui Laravel Artisan Tinker (Interactive PHP REPL)

```bash
# Buka REPL Artisan Tinker
php artisan tinker
```

---

### C. Melalui Laravel DB Facade dalam Kode Application

```php
use Illuminate\Support\Facades\DB;

// Menjalankan Raw SELECT
$results = DB::select("SELECT * FROM service_transactions WHERE status = ?", ['proses']);

// Menjalankan Query Builder
$customers = DB::table('customers')->where('name', 'like', '%Budi%')->get();
```

---

## 2. Kamus & Struktur Skema Tabel (DDL)

### 2.1. Skema Pembuatan Tabel Utama (DDL Reference)

Berikut adalah query DDL pembuatan tabel-tabel inti SIBENGKEL:

```sql
-- 1. Tabel users (Akun Kredensial Staff Internal)
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL UNIQUE,
  `email` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','mekanik') NOT NULL DEFAULT 'admin',
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabel customers (Data Pelanggan Portal & Bengkel)
CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL UNIQUE,
  `password` varchar(255) DEFAULT NULL,
  `profile_photo_url` varchar(2048) DEFAULT NULL,
  `cart_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`cart_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel vehicles (Data Kendaraan Terdaftar)
CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `plate_number` varchar(20) NOT NULL UNIQUE,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `vehicles_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel mechanics (Profil Data Master Mekanik)
CREATE TABLE `mechanics` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `expertise` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `mechanics_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabel service_transactions (Fakta Utama Transaksi Servis)
CREATE TABLE `service_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mechanic_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('servis','penjualan') NOT NULL DEFAULT 'servis',
  `complaint` text NOT NULL,
  `cost` decimal(12,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','proses','selesai') NOT NULL DEFAULT 'pending',
  `transaction_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `service_transactions_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `service_transactions_mechanic_id_foreign` FOREIGN KEY (`mechanic_id`) REFERENCES `mechanics` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabel bookings (Reservasi Servis Daring Pelanggan)
CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `service_transaction_id` bigint(20) UNSIGNED DEFAULT NULL,
  `preferred_date` date NOT NULL,
  `preferred_time` time NOT NULL,
  `complaint` text NOT NULL,
  `status` enum('menunggu','disetujui','ditolak') NOT NULL DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_service_transaction_id_foreign` FOREIGN KEY (`service_transaction_id`) REFERENCES `service_transactions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabel spare_parts (Katalog Stok & Harga Eceran Sparepart)
CREATE TABLE `spare_parts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 3. Data Manipulation Language (DML)

### 3.1. INSERT Data (SQL vs Eloquent)

#### A. Tambah Pelanggan Baru

**Raw SQL:**
```sql
INSERT INTO `customers` (`name`, `phone`, `address`, `email`, `created_at`, `updated_at`) 
VALUES ('Budi Santoso', '081234567890', 'Jl. Merdeka No. 45, Jakarta', 'budi@example.com', NOW(), NOW());
```

**Eloquent ORM:**
```php
use App\Models\Customer;

$customer = Customer::create([
    'name'    => 'Budi Santoso',
    'phone'   => '081234567890',
    'address' => 'Jl. Merdeka No. 45, Jakarta',
    'email'   => 'budi@example.com',
]);
```

---

#### B. Tambah Kendaraan Baru (Terhubung ke Pelanggan ID = 1)

**Raw SQL:**
```sql
INSERT INTO `vehicles` (`customer_id`, `plate_number`, `brand`, `model`, `year`, `created_at`, `updated_at`) 
VALUES (1, 'B 1234 ABC', 'Honda', 'Vario 150', 2022, NOW(), NOW());
```

**Eloquent ORM:**
```php
use App\Models\Vehicle;

$vehicle = Vehicle::create([
    'customer_id'  => 1,
    'plate_number' => 'B 1234 ABC',
    'brand'        => 'Honda',
    'model'        => 'Vario 150',
    'year'         => 2022,
]);
```

---

#### C. Catat Transaksi Servis Baru

**Raw SQL:**
```sql
INSERT INTO `service_transactions` 
  (`vehicle_id`, `user_id`, `mechanic_id`, `type`, `complaint`, `cost`, `status`, `transaction_date`, `created_at`, `updated_at`) 
VALUES 
  (1, 1, 1, 'servis', 'Ganti oli mesin dan tune up rutin CVT', 150000.00, 'pending', CURDATE(), NOW(), NOW());
```

**Eloquent ORM:**
```php
use App\Models\ServiceTransaction;

$transaction = ServiceTransaction::create([
    'vehicle_id'       => 1,
    'user_id'          => 1,
    'mechanic_id'      => 1,
    'type'             => 'servis',
    'complaint'        => 'Ganti oli mesin dan tune up rutin CVT',
    'cost'             => 150000.00,
    'status'           => 'pending',
    'transaction_date' => now()->toDateString(),
]);
```

---

### 3.2. UPDATE Data (SQL vs Eloquent)

#### A. Pembaruan Status Transaksi Servis (`pending` ➔ `proses` ➔ `selesai`)

**Raw SQL:**
```sql
UPDATE `service_transactions` 
SET `status` = 'proses', `updated_at` = NOW() 
WHERE `id` = 10;
```

**Eloquent ORM:**
```php
$transaction = ServiceTransaction::findOrFail(10);
$transaction->update(['status' => 'proses']);
```

---

#### B. Kurangi Stok Sparepart Saat Terjual

**Raw SQL:**
```sql
UPDATE `spare_parts` 
SET `stock` = `stock` - 2, `updated_at` = NOW() 
WHERE `id` = 5 AND `stock` >= 2;
```

**Eloquent ORM:**
```php
use App\Models\SparePart;

SparePart::where('id', 5)->decrement('stock', 2);
```

---

### 3.3. DELETE Data (SQL vs Eloquent)

#### A. Hapus Transaksi Servis (Sekaligus Cascade Booking Terkait)

**Raw SQL:**
```sql
-- 1. Hapus FK booking terikat jika ada
DELETE FROM `bookings` WHERE `service_transaction_id` = 10;

-- 2. Hapus transaksi servis
DELETE FROM `service_transactions` WHERE `id` = 10;
```

**Eloquent ORM (Controller Logic):**
```php
use App\Models\Booking;
use App\Models\ServiceTransaction;

// Manual cascade deletion untuk integritas data
Booking::where('service_transaction_id', $id)->delete();
ServiceTransaction::destroy($id);
```

---

## 4. Data Query Language (DQL) & Analitik

### 4.1. Query JOIN 5 Tabel (Laporan Lengkap Transaksi Servis)

Menggabungkan `service_transactions`, `vehicles`, `customers`, `mechanics`, dan `users` untuk menampilkan laporan perbaikan kendaraan secara komprehensif.

**Raw SQL:**
```sql
SELECT 
    t.id AS id_transaksi,
    t.transaction_date AS tanggal_servis,
    c.name AS nama_pelanggan,
    c.phone AS telepon_pelanggan,
    v.plate_number AS nomor_polisi,
    CONCAT(v.brand, ' ', v.model, ' (', v.year, ')') AS spesifikasi_kendaraan,
    m.name AS nama_mekanik,
    m.expertise AS keahlian_mekanik,
    u.name AS petugas_pencatat,
    t.complaint AS rincian_keluhan,
    t.cost AS total_biaya,
    t.status AS status_pengerjaan
FROM service_transactions t
INNER JOIN vehicles v ON t.vehicle_id = v.id
INNER JOIN customers c ON v.customer_id = c.id
LEFT JOIN mechanics m ON t.mechanic_id = m.id
INNER JOIN users u ON t.user_id = u.id
ORDER BY t.created_at DESC;
```

**Eloquent ORM Equivalent:**
```php
$transactions = ServiceTransaction::with(['vehicle.customer', 'mechanic', 'user'])
    ->orderBy('created_at', 'desc')
    ->get();
```

---

### 4.2. Query Pencarian Cek Status Servis (Case-Insensitive & Toleran Spasi)

Digunakan pada fitur publik `/cek-status` untuk mencocokkan nomor polisi tanpa memedulikan spasi atau huruf kapital.

**Raw SQL:**
```sql
SELECT t.id, t.status, t.cost, t.complaint, v.plate_number, v.brand, v.model, c.name AS customer_name
FROM service_transactions t
JOIN vehicles v ON t.vehicle_id = v.id
JOIN customers c ON v.customer_id = c.id
WHERE REPLACE(UPPER(v.plate_number), ' ', '') = REPLACE(UPPER('b 1234 abc'), ' ', '')
ORDER BY t.created_at DESC
LIMIT 1;
```

**Eloquent ORM Equivalent:**
```php
$nopolClean = str_replace(' ', '', strtoupper($searchQuery));

$transaction = ServiceTransaction::whereHas('vehicle', function($q) use ($nopolClean) {
    $q->whereRaw("REPLACE(UPPER(plate_number), ' ', '') = ?", [$nopolClean]);
})->with(['vehicle.customer', 'mechanic'])->latest()->first();
```

---

### 4.3. Query Agregasi & Analitik Dashboard

#### A. Total Pendapatan Harian & Bulanan

**Raw SQL:**
```sql
-- Pendapatan Hari Ini
SELECT COALESCE(SUM(cost), 0) AS total_hari_ini
FROM service_transactions
WHERE status = 'selesai' AND transaction_date = CURDATE();

-- Pendapatan Bulan Ini (Gabungan Servis & Penjualan Sparepart)
SELECT 
    (SELECT COALESCE(SUM(cost), 0) FROM service_transactions WHERE status = 'selesai' AND MONTH(transaction_date) = MONTH(CURRENT_DATE()) AND YEAR(transaction_date) = YEAR(CURRENT_DATE())) +
    (SELECT COALESCE(SUM(total_price), 0) FROM orders WHERE status = 'selesai' AND MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())) 
    AS total_pendapatan_bulan_ini;
```

**Eloquent ORM Equivalent:**
```php
$servisIncome = ServiceTransaction::where('status', 'selesai')
    ->whereMonth('transaction_date', now()->month)
    ->whereYear('transaction_date', now()->year)
    ->sum('cost');

$orderIncome = Order::where('status', 'selesai')
    ->whereMonth('created_at', now()->month)
    ->whereYear('created_at', now()->year)
    ->sum('total_price');

$totalMonthlyRevenue = $servisIncome + $orderIncome;
```

---

#### B. Rekapitulasi Jumlah Kendaraan Per Pelanggan (GROUP BY & HAVING)

**Raw SQL:**
```sql
SELECT 
    c.id AS customer_id,
    c.name AS nama_pelanggan,
    c.phone AS nomor_telepon,
    COUNT(v.id) AS total_kendaraan
FROM customers c
LEFT JOIN vehicles v ON c.id = v.customer_id
GROUP BY c.id, c.name, c.phone
HAVING total_kendaraan >= 1
ORDER BY total_kendaraan DESC;
```

**Eloquent ORM Equivalent:**
```php
$customers = Customer::withCount('vehicles')
    ->having('vehicles_count', '>=', 1)
    ->orderBy('vehicles_count', 'desc')
    ->get();
```

---

#### C. Top 5 Sparepart Terlaris Berdasarkan Kuantitas Penjualan

**Raw SQL:**
```sql
SELECT 
    sp.id,
    sp.name AS nama_sparepart,
    sp.price AS harga_satuan,
    SUM(oi.quantity) AS total_terjual,
    SUM(oi.quantity * oi.price) AS total_omzet
FROM order_items oi
JOIN spare_parts sp ON oi.spare_part_id = sp.id
JOIN orders o ON oi.order_id = o.id
WHERE o.status = 'selesai'
GROUP BY sp.id, sp.name, sp.price
ORDER BY total_terjual DESC
LIMIT 5;
```

---

## 5. Interaktif Testing via Artisan Tinker

Gunakan perintah-perintah berikut di terminal `php artisan tinker` untuk verifikasi data instan saat demo atau pengujian:

### 5.1. Verifikasi Jumlah Record Semua Tabel

```php
// Jalankan di Tinker:
App\Models\User::count();
App\Models\Customer::count();
App\Models\Vehicle::count();
App\Models\Mechanic::count();
App\Models\ServiceTransaction::count();
App\Models\Booking::count();
App\Models\SparePart::count();
App\Models\Order::count();
```

### 5.2. Test Relasi Eager Loading Vehicle ➔ Customer ➔ Transactions

```php
// Ambil kendaraan pertama beserta pemilik dan transaksi servisnya
$vehicle = App\Models\Vehicle::with(['customer', 'serviceTransactions.mechanic'])->first();

// Tampilkan nama pemilik
echo $vehicle->customer->name;

// Tampilkan plat nomor
echo $vehicle->plate_number;

// Tampilkan jumlah transaksi kendaraan ini
echo $vehicle->serviceTransactions->count();
```

### 5.3. Simulasi Konversi Booking Menjadi Transaksi Servis

```php
// 1. Ambil booking yang statusnya 'menunggu'
$booking = App\Models\Booking::where('status', 'menunggu')->first();

// 2. Buat transaksi servis otomatis
$transaction = App\Models\ServiceTransaction::create([
    'vehicle_id'       => $booking->vehicle_id,
    'user_id'          => 1, // Admin ID
    'mechanic_id'      => 1, // Mekanik ID
    'type'             => 'servis',
    'complaint'        => $booking->complaint,
    'cost'             => 175000,
    'status'           => 'pending',
    'transaction_date' => $booking->preferred_date,
]);

// 3. Update status booking & hubungkan ke transaksi
$booking->update([
    'status'                 => 'disetujui',
    'service_transaction_id' => $transaction->id,
]);
```

---

## 6. Database Administration & Backup

### 6.1. Export / Backup Database (`mysqldump`)

```bash
# Backup struktur + data ke file .sql
mysqldump -u root -p sibengkel > sibengkel_backup_$(date +%Y%m%d).sql

# Backup hanya struktur (schema only)
mysqldump -u root -p --no-data sibengkel > sibengkel_schema.sql
```

---

### 6.2. Import / Restore Database

```bash
# Restore dari file .sql
mysql -u root -p sibengkel < sibengkel_backup_20260727.sql
```

---

### 6.3. Reset & Fresh Seeding (Laravel Artisan)

```bash
# 1. Wipe semua tabel, jalankan ulang semua migrasi & seeder
php artisan migrate:fresh --seed

# 2. Re-index & clear application cache
php artisan optimize:clear
```

---

*Dokumen Query Database SIBENGKEL | Versi 1.0 | Juli 2026*

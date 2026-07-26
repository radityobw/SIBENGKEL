# Penjelasan Teknis Komprehensif Codebase SIBENGKEL
## Sistem Informasi Bengkel Terpadu — Panduan Presentasi Dosen Penguji

> **Tenggat Presentasi:** Senin, 27 Juli 2026
> **Mata Kuliah:** Pemrograman Web + Sistem Basis Data
> **Tim Pengembang:** 3 Orang
> **Stack Utama:** Laravel 12 · MySQL · Blade · Tailwind CSS · Laravel Sanctum

---

## PETA DOKUMEN

| No | Bagian | Bobot Rubrik |
|:--:|:---|:--:|
| 1 | [Fungsionalitas Sistem](#1-fungsionalitas-sistem) | 40% |
| 2 | [Kualitas Kode](#2-kualitas-kode) | 20% |
| 3 | [Tampilan & UX](#3-tampilan--ux) | 15% |
| 4 | [API & Keamanan](#4-api--keamanan) | 10% |
| 5 | [Hosting & Dokumentasi](#5-hosting--dokumentasi) | 10% |
| 6 | [Tips Presentasi](#6-tips-presentasi) | 5% |

---

## 1. Fungsionalitas Sistem
> **Bobot: 40%** — CRUD berjalan, autentikasi, relasi antar tabel, data tersimpan

### 1.1. Gambaran Umum Sistem

SIBENGKEL adalah platform web terintegrasi yang mendigitalisasi operasional bengkel otomotif. Sistem terdiri dari dua lapisan:

| No | Lapisan | Deskripsi |
|:--:|:---|:---|
| 1 | **Internal Staff Panel** | Dashboard admin & mekanik untuk mengelola operasional bengkel |
| 2 | **Customer Portal** | Portal publik untuk pelanggan: booking, cek status, belanja sparepart |

---

### 1.2. Modul CRUD Lengkap (7 Modul Utama)

#### Module 1 — Manajemen Admin (Pengguna Internal)
- **Controller:** `app/Http/Controllers/AdminController.php`
- **Rute:** `GET/POST /admins`, `GET/PUT/DELETE /admins/{id}`
- **Fitur Keamanan:** Akun diri sendiri tidak bisa dihapus (`$admin->id !== Auth::id()`)
- **CRUD:** Create, Read, Update, Delete akun administrator

#### Module 2 — Manajemen Mekanik
- **Controller:** `app/Http/Controllers/MechanicController.php`
- **Relasi:** `mechanics.user_id` → FK ke `users.id` (1:1), `mechanics.id` → FK di `service_transactions`
- **CRUD:** Full CRUD data mekanik, keahlian teknis, foto profil

#### Module 3 — Manajemen Pelanggan
- **Controller:** `app/Http/Controllers/CustomerController.php`
- **Fitur:** Pencarian real-time, tampilan kartu mobile, badge jumlah kendaraan
- **CRUD:** Full CRUD dengan soft guard relasi kendaraan

#### Module 4 — Manajemen Kendaraan
- **Controller:** `app/Http/Controllers/VehicleController.php`
- **Validasi Kritis:** `plate_number UNIQUE` — menolak duplikasi nomor polisi di level database
- **CRUD:** Full CRUD, filter berdasarkan merek

#### Module 5 — Transaksi Servis *(Modul Inti)*
- **Controller:** `app/Http/Controllers/TransactionController.php`
- **Status Lifecycle:** `pending` → `proses` → `selesai`
- **Relasi:** Menghubungkan `vehicles`, `users` (pencatat), `mechanics` (penanggung jawab)
- **Integritas Cascade:** Hapus transaksi → otomatis hapus booking terkait (cascade manual)
- **Fitur Extra:** Cetak Invoice/Nota servis (halaman print-view)

#### Module 6 — Manajemen Sparepart & Pesanan Online
- **Controller:** `AdminSparePartController.php`, `AdminOrderController.php`
- **Relasi:** `orders` → `order_items` → `spare_parts` (many-to-many via pivot)
- **Fitur:** Kelola katalog, pantau pesanan, kelola stok

#### Module 7 — Booking Servis
- **Controller:** `AdminBookingController.php`
- **Otomatisasi:** Saat disetujui, sistem otomatis membuat `ServiceTransaction` baru
- **Notifikasi:** Pelanggan menerima in-app notification dengan tautan langsung ke cek status

---

### 1.3. Autentikasi Sistem (Dual-Guard Authentication)

| No | Guard | Tabel | Target | Mekanisme |
|:--:|:---|:---|:---|:---|
| 1 | `web` (default) | `users` | Admin & Mekanik | Laravel Session |
| 2 | `customer` | `customers` | Pelanggan Portal | Custom Guard + Session |

Proteksi Middleware yang Diimplementasikan:
- `middleware('auth')` → Wajib login sebagai staff
- `middleware('auth:customer')` → Wajib login sebagai pelanggan  
- `middleware('role:admin')` → Hanya Admin (custom middleware `CheckRole`)

---

### 1.4. Relasi Antar Tabel

```
users ──1:1──► mechanics ──1:N──► service_transactions ◄──N:1── vehicles ◄──N:1── customers
                                         ▲                                              │
                                         │ (via booking)                               │
                                    bookings ◄────────────────────────────────────────┤
                                                                                       │
                                    orders ◄───────────────────────────────────────── ┤
                                       │                                               │
                                  order_items ──N:1──► spare_parts                    │
                                                                                       │
                                  testimonials ◄───────────────────────────────────── ┘
```

**Total Tabel Database: 15 tabel**
`users, customers, vehicles, mechanics, service_transactions, bookings, spare_parts, orders, order_items, testimonials, pages, settings, notifications, contact_messages, personal_access_tokens`

---

## 2. Kualitas Kode
> **Bobot: 20%** — Struktur MVC, validasi input, Eloquent (bukan raw SQL), keamanan

### 2.1. Arsitektur MVC Laravel

```
app/
├── Http/
│   ├── Controllers/        ← CONTROLLER: Logic & Routing Handler (34 file)
│   │   ├── Api/            ←   API Controllers (JSON Response)
│   │   ├── Auth/           ←   Auth Controllers (Session Management)
│   │   └── Admin/          ←   Admin-specific Controllers
│   └── Middleware/         ← Custom Middleware (Role Check)
├── Models/                 ← MODEL: Eloquent ORM + Relasi (13 model)
└── Notifications/          ← Notification Classes (In-App Push)

database/
├── migrations/             ← Struktur Tabel (26 file migrasi, ordered)
└── seeders/                ← Data Awal (Admin, Sparepart, Pages)

resources/views/            ← VIEW: Blade Templates
├── layouts/                ←   Master Layouts (app, public, customer, guest)
├── admin/, customers/,     ←   Feature-specific Views
│   transactions/, public/  ←
└── components/             ←   Reusable Blade Components (fab, toast, badge)
```

### 2.2. Eloquent ORM — Zero Raw SQL

Seluruh query database menggunakan Eloquent ORM (PDO prepared statements otomatis).

**Eager Loading — mencegah N+1 Problem:**
```php
// AdminBookingController.php
$bookings = Booking::with(['customer', 'vehicle', 'transaction'])
    ->orderBy('created_at', 'desc')->paginate(15);
```

**Conditional Query (Scope):**
```php
// TransactionController.php
$transactions = ServiceTransaction::with(['vehicle.customer', 'mechanic', 'user'])
    ->when($status, fn($q, $status) => $q->where('status', $status))
    ->latest()->paginate(10);
```

**Raw-like tapi tetap Aman (whereRaw dengan binding):**
```php
// PublicStatusController.php — pencarian nomor polisi
$q->whereRaw("REPLACE(UPPER(plate_number), ' ', '') = ?", [$nopolClean]);
```

### 2.3. Relasi Model Eloquent

| No | Model | Tipe Relasi | Target Model |
|:--:|:---|:---|:---|
| 1 | `User` | `hasOne` | `Mechanic` |
| 2 | `Customer` | `hasMany` | `Vehicle`, `Booking`, `Order`, `Testimonial` |
| 3 | `Vehicle` | `belongsTo` | `Customer` |
| 4 | `Vehicle` | `hasMany` | `ServiceTransaction` |
| 5 | `ServiceTransaction` | `belongsTo` | `Vehicle`, `User`, `Mechanic` |
| 6 | `Booking` | `belongsTo` | `Customer`, `Vehicle`, `ServiceTransaction` |
| 7 | `Order` | `hasMany` | `OrderItem` |
| 8 | `OrderItem` | `belongsTo` | `Order`, `SparePart` |

### 2.4. Validasi Input Komprehensif

```php
// TransactionController::store() — Contoh validasi lengkap
$validated = $request->validate([
    'vehicle_id'       => 'required|exists:vehicles,id',
    'mechanic_id'      => 'nullable|exists:mechanics,id',
    'type'             => 'required|in:servis,penjualan',
    'complaint'        => 'required|string',
    'cost'             => 'required|numeric|min:0',
    'status'           => 'required|in:pending,proses,selesai',
    'transaction_date' => 'required|date',
]);
```

Rule yang digunakan: `required`, `exists:table,col`, `unique:table,col`, `in:val1,val2`, `numeric|min:0`, `image|max:2048`, `nullable`, `date`, `string`, `email`

### 2.5. Keamanan Codebase

| No | Mekanisme | Implementasi |
|:--:|:---|:---|
| 1 | CSRF Protection | `@csrf` di setiap form Blade |
| 2 | SQL Injection | Eloquent ORM + PDO prepared statements |
| 3 | XSS Protection | Blade `{{ }}` auto-escape semua output |
| 4 | Password Hashing | `Hash::make()` bcrypt — tidak pernah plain text |
| 5 | Role Middleware | Custom `CheckRole` middleware di routes |
| 6 | API Token Auth | Laravel Sanctum Bearer Token |
| 7 | Mass Assignment Guard | `$fillable` eksplisit di semua Model |
| 8 | Guest Redirect | `middleware('guest')` di auth routes |

---

## 3. Tampilan & UX
> **Bobot: 15%** — Responsive, konsisten, informatif, navigasi jelas

### 3.1. Design System & Brand Identity

Didefinisikan di `docs/DESIGN.md`, diimplementasikan via Tailwind CSS custom tokens:

| No | Token | Nilai | Fungsi |
|:--:|:---|:---|:---|
| 1 | `primary` | `#000000` | Elemen primer, tombol utama |
| 2 | `secondary` | `#FF6B00` | Workshop Orange — CTA, badge aktif |
| 3 | `background` | `#f8f9fb` | Latar light mode |
| 4 | Font Heading | Sora (Google Fonts) | Judul & heading |
| 5 | Font Body | Inter (Google Fonts) | Teks konten |

### 3.2. Responsive Design (Mobile-First)

| No | Breakpoint | Resolusi | Adaptasi UI |
|:--:|:---|:---|:---|
| 1 | Mobile | < 768px | Card view, FAB, bottom dock 4-tab |
| 2 | Tablet | 768–1023px | Grid 2 kolom, sidebar collapsed |
| 3 | Desktop | ≥ 1024px | Full sidebar, tabel data, multi-column |

**Komponen Mobile-Specific:**
- **Bottom Navigation Dock** — 4 tab: Home, Booking, Transaksi, Menu
- **Floating Action Button (FAB)** — Tombol tambah mengambang, 7 halaman
- **Card View** — Tabel berubah jadi kartu di layar kecil
- **Slide-up Drawer** — Bottom sheet untuk menu tambahan

### 3.3. Dark Mode Premium

Toggle dark mode menggunakan CSS View Transition API dengan efek circle-reveal:

```javascript
document.documentElement.animate({
    clipPath: [
        `circle(0px at ${x}px ${y}px)`,
        `circle(${endRadius}px at ${x}px ${y}px)`
    ]
}, { duration: 500, pseudoElement: '::view-transition-new(root)' });
```

Preferensi disimpan di `localStorage` — mencegah flash of white saat reload.

### 3.4. Komponen UI Premium

| No | Komponen | Teknologi | Deskripsi |
|:--:|:---|:---|:---|
| 1 | Magic Card Spotlight | Vanilla JS | Gradient mengikuti kursor |
| 2 | Marquee Testimonial | requestAnimationFrame | Auto-scroll infinite + edge fade |
| 3 | Toast Notification | Alpine.js | Auto-dismiss success/error |
| 4 | Animated Counter | Intersection Observer | Count-up saat masuk viewport |
| 5 | Page Transition | View Transition API | Fade + scale antar halaman |
| 6 | Real-time Status Polling | setInterval + API | Update tanpa reload halaman |

---

## 4. API & Keamanan
> **Bobot: 10%** — Endpoint JSON berfungsi, Sanctum token, response format

### 4.1. Tabel Endpoint REST API Lengkap

| No | Method | Endpoint | Auth | Deskripsi |
|:--:|:---|:---|:---|:---|
| 1 | `POST` | `/api/login` | Public | Login & terbitkan Bearer Token |
| 2 | `POST` | `/api/logout` | Bearer | Revoke token aktif |
| 3 | `GET` | `/api/customers` | Bearer | Daftar semua pelanggan |
| 4 | `POST` | `/api/customers` | Bearer | Tambah pelanggan |
| 5 | `GET` | `/api/customers/{id}` | Bearer | Detail pelanggan |
| 6 | `PUT` | `/api/customers/{id}` | Bearer | Update pelanggan |
| 7 | `DELETE` | `/api/customers/{id}` | Bearer | Hapus pelanggan |
| 8 | `GET` | `/api/vehicles` | Bearer | Daftar kendaraan |
| 9 | `POST` | `/api/vehicles` | Bearer | Tambah kendaraan |
| 10 | `GET` | `/api/vehicles/{id}` | Bearer | Detail kendaraan |
| 11 | `PUT` | `/api/vehicles/{id}` | Bearer | Update kendaraan |
| 12 | `DELETE` | `/api/vehicles/{id}` | Bearer | Hapus kendaraan |
| 13 | `GET` | `/api/services` | Bearer | Daftar transaksi servis |
| 14 | `POST` | `/api/services` | Bearer | Tambah transaksi |
| 15 | `GET` | `/api/services/{id}` | Bearer | Detail transaksi |
| 16 | `PUT` | `/api/services/{id}` | Bearer | Update transaksi |
| 17 | `PATCH` | `/api/services/{id}/status` | Bearer | Update status saja |
| 18 | `DELETE` | `/api/services/{id}` | Bearer | Hapus transaksi |
| 19 | `GET` | `/api/transactions/{id}/status` | Public | Polling status real-time |

### 4.2. Format Response JSON Standar

**Response Sukses:**
```json
{
  "success": true,
  "message": "Berhasil mengambil data pelanggan",
  "data": [{ "id": 1, "name": "Budi Santoso", ... }]
}
```

**Response Login dengan Token:**
```json
{
  "success": true,
  "message": "Login API Berhasil",
  "access_token": "1|sanctum_token_xyz...",
  "token_type": "Bearer",
  "user": { "id": 1, "name": "Admin Bengkel", "role": "admin" }
}
```

**Response Error (HTTP 422):**
```json
{
  "success": false,
  "message": "Login gagal.",
  "errors": { "login": ["Username atau password salah."] }
}
```

### 4.3. Penggunaan Token (Contoh Postman/curl)

```bash
# Step 1: Dapatkan token
POST /api/login
Content-Type: application/json
Body: { "login": "adminbengkel", "password": "password123" }

# Step 2: Gunakan token
GET /api/customers
Authorization: Bearer 1|sanctumtoken...
Accept: application/json
```

### 4.4. Endpoint Polling Real-Time (Bonus)

```
GET /api/transactions/{id}/status  ← Public, tanpa token
```
```json
{ "status": "proses", "status_label": "Proses", "updated_at": "5 menit yang lalu" }
```
Digunakan di halaman Cek Status via `setInterval` JavaScript untuk update otomatis tanpa reload.

---

## 5. Hosting & Dokumentasi
> **Bobot: 10%** — Aplikasi live, GitHub tersedia, laporan lengkap, ERD

### 5.1. Stack Infrastruktur

| No | Komponen | Detail |
|:--:|:---|:---|
| 1 | OS + Web Server | Linux + Nginx |
| 2 | PHP Runtime | PHP 8.2+ |
| 3 | Database | MySQL/MariaDB |
| 4 | Framework | Laravel 12.x |
| 5 | Asset Build | Vite + Tailwind CSS |
| 6 | CI/CD | GitHub Actions |

### 5.2. CI/CD Pipeline (GitHub Actions)

File: `.github/workflows/devsecops-cicd.yml`

```
[Push ke GitHub]
      ↓
[1] Composer Install + Cache
      ↓
[2] PHP Lint & Static Analysis
      ↓
[3] Run Automated Tests (php artisan test)
      ↓
[4] Security Dependency Audit
      ↓
[5] Deploy ke Production via SSH
```

### 5.3. ERD (Entity Relationship Diagram)

```
┌──────────────────────────────┐       ┌──────────────────────────────────┐
│             users            │  1:1  │            mechanics             │
│──────────────────────────────│──────►│──────────────────────────────────│
│ id               BIGINT (PK) │       │ id               BIGINT (PK)     │
│ name             VARCHAR     │       │ user_id          BIGINT (FK)     │
│ username         VARCHAR UK  │       │ name             VARCHAR         │
│ email            VARCHAR UK  │       │ phone            VARCHAR         │
│ password         VARCHAR     │       │ expertise        VARCHAR         │
│ role             ENUM        │       │ created_at       TIMESTAMP       │
│ profile_photo    VARCHAR     │       │ updated_at       TIMESTAMP       │
│ created_at       TIMESTAMP   │       └──────────────────────────────────┘
│ updated_at       TIMESTAMP   │                       │ 1:N
└──────────────────────────────┘                       │
                                                       ▼
┌──────────────────────────────┐       ┌──────────────────────────────────────┐
│           customers          │  1:N  │          service_transactions         │
│──────────────────────────────│       │──────────────────────────────────────│
│ id               BIGINT (PK) │       │ id               BIGINT (PK)         │
│ name             VARCHAR     │       │ vehicle_id       BIGINT (FK)         │
│ phone            VARCHAR     │       │ user_id          BIGINT (FK)         │
│ address          TEXT        │       │ mechanic_id      BIGINT (FK)         │
│ email            VARCHAR UK  │       │ type             ENUM (servis/jual)  │
│ password         VARCHAR     │       │ complaint        TEXT                │
│ profile_photo    VARCHAR     │       │ cost             DECIMAL(12,2)       │
│ cart_data        JSON        │       │ status           ENUM (pend/pros/sel)│
│ created_at       TIMESTAMP   │       │ transaction_date DATE                │
│ updated_at       TIMESTAMP   │       │ created_at       TIMESTAMP           │
└──────────────────────────────┘       │ updated_at       TIMESTAMP           │
              │ 1:N                    └──────────────────────────────────────┘
              ▼                                      ▲
┌──────────────────────────────┐  1:N               │ vehicle_id FK
│           vehicles           │────────────────────┘
│──────────────────────────────│
│ id               BIGINT (PK) │
│ customer_id      BIGINT (FK) │
│ plate_number     VARCHAR UK  │
│ brand            VARCHAR     │
│ model            VARCHAR     │
│ year             INTEGER     │
│ created_at       TIMESTAMP   │
│ updated_at       TIMESTAMP   │
└──────────────────────────────┘
              │ (via customers 1:N)
              ▼
┌──────────────────────────────────────────────────────┐
│                      bookings                        │
│──────────────────────────────────────────────────────│
│ id                    BIGINT (PK)                    │
│ customer_id           BIGINT (FK → customers)        │
│ vehicle_id            BIGINT (FK → vehicles)         │
│ service_transaction_id BIGINT (FK → s_transactions)  │
│ preferred_date        DATE                           │
│ preferred_time        TIME                           │
│ complaint             TEXT                           │
│ status                ENUM (menunggu/disetujui/tolak)│
│ created_at            TIMESTAMP                      │
│ updated_at            TIMESTAMP                      │
└──────────────────────────────────────────────────────┘

┌──────────────────────────────┐       ┌──────────────────────────────┐
│            orders            │  1:N  │          order_items          │
│──────────────────────────────│──────►│──────────────────────────────│
│ id               BIGINT (PK) │       │ id           BIGINT (PK)     │
│ customer_id      BIGINT (FK) │       │ order_id     BIGINT (FK)     │
│ total_price      DECIMAL     │       │ spare_part_id BIGINT (FK)    │
│ status           ENUM        │       │ quantity     INTEGER         │
│ created_at       TIMESTAMP   │       │ price        DECIMAL(12,2)   │
│ updated_at       TIMESTAMP   │       │ created_at   TIMESTAMP       │
└──────────────────────────────┘       └──────────────────────────────┘
                                                    │ N:1
                                                    ▼
                               ┌──────────────────────────────────┐
                               │           spare_parts            │
                               │──────────────────────────────────│
                               │ id           BIGINT (PK)         │
                               │ name         VARCHAR             │
                               │ description  TEXT                │
                               │ price        DECIMAL(12,2)       │
                               │ stock        INTEGER             │
                               │ image        VARCHAR             │
                               │ created_at   TIMESTAMP           │
                               │ updated_at   TIMESTAMP           │
                               └──────────────────────────────────┘

┌──────────────────────────────────────────────────┐
│                   testimonials                   │
│──────────────────────────────────────────────────│
│ id               BIGINT (PK)                     │
│ customer_id      BIGINT (FK → customers)         │
│ customer_name    VARCHAR                         │
│ rating           TINYINT (1–5)                   │
│ content          TEXT                            │
│ vehicle          VARCHAR                         │
│ created_at       TIMESTAMP                       │
│ updated_at       TIMESTAMP                       │
└──────────────────────────────────────────────────┘
```

### 5.4. Kronologi Migrasi Database

| No | File Migrasi | Tabel |
|:--:|:---|:---|
| 1 | `000000_create_users_table` | `users`, `password_reset_tokens`, `sessions` |
| 2 | `create_customers_table` | `customers` |
| 3 | `create_vehicles_table` | `vehicles` |
| 4 | `create_mechanics_table` | `mechanics` |
| 5 | `create_service_transactions_table` | `service_transactions` |
| 6 | `create_personal_access_tokens_table` | `personal_access_tokens` (Sanctum) |
| 7 | `create_bookings_table` | `bookings` |
| 8 | `create_spare_parts_table` | `spare_parts` |
| 9 | `create_orders_table` | `orders` |
| 10 | `create_order_items_table` | `order_items` |
| 11 | `create_testimonials_table` | `testimonials` |
| 12 | `create_notifications_table` | `notifications` (Laravel built-in) |
| 13 | `create_contact_messages_table` | `contact_messages` |

---

## 6. Tips Presentasi
> **Bobot: 5%** — Demo lancar, bisa jawab pertanyaan, pembagian tugas jelas

### 6.1. Skenario Demo yang Direkomendasikan (10 Menit)

```
[Menit 1-2] Buka Landing Page
   → Hero section, statistik counter animasi, testimoni auto-scroll infinite
   → Toggle Dark Mode (tunjukkan efek circle-reveal premium)

[Menit 2-3] Login Staff & Dashboard
   → POST /login sebagai Admin → redirect ke dashboard
   → Tunjukkan widget KPI: total pelanggan, kendaraan, transaksi, pendapatan

[Menit 3-6] Demo CRUD Core
   → Tambah pelanggan baru → Tambah kendaraan (relasi otomatis ke pelanggan)
   → Buat transaksi servis (pilih kendaraan, mekanik, isi keluhan, biaya)
   → Update status: pending → proses → selesai
   → Cetak Invoice servis

[Menit 6-8] Demo Customer Portal + Booking Flow
   → Buka tab baru: /portal/login (login sebagai pelanggan)
   → Submit booking servis online
   → Kembali ke admin → setujui booking
   → Tunjukkan ServiceTransaction otomatis terbuat
   → Notifikasi masuk ke pelanggan → klik → diarahkan ke cek status

[Menit 8-9] Demo Cek Status Real-Time
   → /cek-status → input nomor polisi → hasil status langsung muncul
   → Tunjukkan polling otomatis (tanpa reload)

[Menit 9-10] Demo API via Postman
   → POST /api/login → salin Bearer Token
   → GET /api/customers (dengan Authorization header) → JSON response
   → GET /api/services → data transaksi dalam format JSON
```

### 6.2. Q&A Siap Jawab

**Q: Kenapa pakai Laravel Sanctum bukan Passport?**
> Sanctum lebih ringan dan tepat untuk SPA/mobile API sederhana. Passport mengimplementasikan OAuth2 penuh yang overkill untuk scope proyek ini. Sanctum sudah bundled di Laravel 12 tanpa instalasi tambahan.

**Q: Bagaimana mencegah SQL Injection?**
> Seluruh query menggunakan Eloquent ORM yang secara otomatis menggunakan PDO prepared statements. Parameter user tidak pernah di-interpolasi langsung ke string query. Satu-satunya penggunaan `whereRaw` di codebase menggunakan binding `[?]` yang aman.

**Q: Apa perbedaan guard `auth` vs `auth:customer`?**
> `auth` (alias `auth:web`) memeriksa guard default yang membaca dari tabel `users` (admin/mekanik). `auth:customer` adalah custom guard yang membaca dari tabel `customers`. Keduanya dikonfigurasi di `config/auth.php` dengan provider berbeda.

**Q: Bagaimana relasi Booking ke ServiceTransaction?**
> `bookings.service_transaction_id` adalah Foreign Key nullable. Nilai null berarti booking belum diproses. Saat admin menyetujui, controller membuat `ServiceTransaction` baru lalu mengisi FK ini. Jika transaksi dihapus, controller juga menghapus booking terkait secara manual (cascade di level aplikasi).

**Q: Apakah ada constraint di level database selain Laravel validation?**
> Ya. Migrasi mendefinisikan: `UNIQUE` pada `plate_number` dan `email`, `NOT NULL` pada field wajib, `DECIMAL(12,2)` untuk cost, `ENUM` untuk status dan type, serta `FOREIGN KEY` dengan `onDelete('cascade')` atau `onDelete('set null')` sesuai kebutuhan bisnis.

**Q: Bagaimana notifikasi bekerja?**
> Menggunakan Laravel Notification system (`Notifiable` trait). Notifikasi disimpan ke tabel `notifications` sebagai JSON. Dropdown notifikasi di topbar melakukan query `Auth::user()->notifications()->take(5)->get()`. Admin dan pelanggan memiliki notifiable model berbeda.

**Q: Apakah dashboard real-time?**
> Data dashboard di-query dari database setiap page load. Chart tren pendapatan menggabungkan `service_transactions` dan `orders` dalam satu query. Halaman Cek Status menggunakan `setInterval` + `/api/transactions/{id}/status` untuk polling tanpa reload.

### 6.3. Pembagian Tugas Tim

| No | Anggota | Role & Area Tanggung Jawab |
|:--:|:---|:---|
| 1 | **Radityo B. W.** | **Lead Developer & Software Architect**: Fullstack MVC Architecture, Multi-Guard Auth, REST API Sanctum, DevSecOps CI/CD & Deployment |
| 2 | **Zayyan F. R.** | **Frontend UI/UX Engineer**: Blade Templating, Mobile-First Layout, Adaptive Dark Mode, Component Styling & Animations |
| 3 | **Raditya A. P.** | **Backend & Database Engineer**: Eloquent Data Layer, Database Migrations, Input Validation, Business Logic & Workflow Testing |

### 6.4. Nilai Tambah Melampaui Rubrik Minimum

| No | Fitur Extra | Nilai Tambah |
|:--:|:---|:---|
| 1 | Customer Portal (guard terpisah) | Dual authentication system profesional |
| 2 | Booking Servis Online | Otomatisasi workflow end-to-end |
| 3 | Toko Sparepart (cart + checkout) | Mini e-commerce terintegrasi |
| 4 | Real-time Status Polling | UX tanpa reload — modern web experience |
| 5 | CI/CD Pipeline GitHub Actions | Standar industri DevSecOps |
| 6 | SEO Technical (sitemap, robots.txt) | Siap deploy produksi |
| 7 | Dark Mode + View Transition API | UI premium, web modern 2026 |
| 8 | FAB Navigation Mobile | UX optimal untuk pengguna HP |
| 9 | Invoice Cetak PDF | Dokumen resmi operasional bengkel |

---

## RINGKASAN EKSEKUTIF

**SIBENGKEL** adalah sistem informasi bengkel berbasis web yang dibangun menggunakan **Laravel 12** dengan:

- **7 Modul CRUD** — relasi antar tabel presisi dengan FK dan Cascade Rule
- **Dual-Guard Authentication** — Staff Internal + Pelanggan Portal terpisah
- **RBAC 3 Level** — Admin, Mekanik, Pelanggan dengan middleware proteksi
- **15 Tabel Database** — normalisasi 3NF, relasi terstruktur, 26 file migrasi
- **19 REST API Endpoint** — diamankan Laravel Sanctum Bearer Token
- **Zero Raw SQL** — 100% Eloquent ORM dengan Eager Loading
- **Mobile-First Responsive** — Dark Mode, FAB, Bottom Dock, Card View
- **CI/CD Pipeline** — GitHub Actions untuk deployment otomatis
- **Fitur Extra** — Customer Portal, E-commerce Sparepart, Real-time Polling, Invoice Cetak

> *"Sistem ini tidak hanya memenuhi seluruh rubrik penilaian, tetapi mengimplementasikan standar industri pengembangan perangkat lunak modern yang siap digunakan dalam lingkungan produksi nyata."*

---

*Versi: 1.0 | Juli 2026 | SIBENGKEL Team*

<div align="center">

  <img src="https://raw.githubusercontent.com/radityobw/SIBENGKEL/main/public/logobengkel.png" alt="SIBENGKEL Logo" width="120" />

  # SIBENGKEL
  ### Sistem Informasi Bengkel Terpadu

  **Platform Web Operasional Terpadu, *Booking* Daring, *E-Commerce Sparepart* & Portal Pelanggan**

  [![Laravel 13](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
  [![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
  [![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
  [![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
  [![Sanctum API](https://img.shields.io/badge/Sanctum_API-Bearer_Token-000000?style=for-the-badge&logo=json-web-tokens&logoColor=white)](https://laravel.com/docs/sanctum)
  [![GitHub Release](https://img.shields.io/github/v/release/radityobw/SIBENGKEL?label=Release&color=FF6B00&style=for-the-badge&cacheSeconds=3600)](https://github.com/radityobw/SIBENGKEL/releases/latest)
  [![CI Status](https://img.shields.io/github/actions/workflow/status/radityobw/SIBENGKEL/devsecops-cicd.yml?label=DevSecOps_CI&color=22c55e&style=for-the-badge)](https://github.com/radityobw/SIBENGKEL/actions/workflows/devsecops-cicd.yml)
  [![Docs](https://img.shields.io/badge/Docs-GitHub_Pages-FF6B00?style=for-the-badge)](https://radityobw.github.io/SIBENGKEL/)
  [![License MIT](https://img.shields.io/badge/License-MIT-a855f7?style=for-the-badge)](https://github.com/radityobw/SIBENGKEL/blob/main/LICENSE)

  [**Bahasa Indonesia**](#-bahasa-indonesia) • [**English**](#-english) • [**Quick Start**](#-quick-start-pengaturan-lokal) • [**API Contract**](#-endpoints-restful-api) • [**GitHub Pages**](https://radityobw.github.io/SIBENGKEL/)

</div>

---

# 🇮🇩 Bahasa Indonesia

## 📌 Tentang SIBENGKEL

**Sistem Informasi Bengkel (SIBENGKEL)** adalah *platform* web terpadu yang dirancang untuk mendigitalisasi seluruh alur operasional bengkel otomotif serta meningkatkan pengalaman servis pelanggan. Dibangun menggunakan **Laravel 13**, **PHP 8.3+**, **Eloquent ORM**, dan antarmuka responsif berbasis **Tailwind CSS 3**, SIBENGKEL menghubungkan tim internal bengkel (Admin & Mekanik) dengan pemilik kendaraan secara terpusat.

### 🌟 Keunggulan & Nilai Utama
- **Digitalisasi Operasional Bengkel**: Pelacakan status pengerjaan servis secara *real-time* (`pending`, `proses`, `selesai`) lengkap dengan penugasan mekanik, tren pendapatan 7 hari, serta cetak nota servis PDF.
- **Manajemen Pelanggan & Kendaraan**: Pencatatan terpusat yang menghubungkan pemilik dengan kendaraan terdaftar, dilengkapi validasi unik nomor polisi.
- ***Booking* Servis Daring**: Pelanggan dapat mengajukan jadwal servis secara *online*, yang dapat disetujui admin dan dikonversi langsung menjadi transaksi servis aktif.
- ***E-Commerce Sparepart***: Toko *online* terintegrasi dengan keranjang belanja persisten (`cart_data`), manajemen stok produk, dan *checkout* pesanan daring.
- **Cek Status Servis Publik (`/cek-status`)**: Pelanggan dapat memantau progres perbaikan kendaraan secara *real-time* menggunakan nomor polisi atau nomor telepon tanpa perlu *login*.
- ***Dual-Guard Authentication* & RBAC**: Autentikasi terpisah (`web` untuk staf internal di `/login`, `customer` untuk pelanggan di `/masuk`) serta kontrol akses berbasis peran (RBAC).
- ***Pipeline* DevSecOps Otomatis**: *Workflow* GitHub Actions mencakup Gitleaks, Trivy, **SIDIK** SAST/SCA, validasi dan audit `Composer`, pengujian PHPUnit lintas PHP 8.3 & 8.4, serta pengemasan rilis & *container* `ghcr.io`.

---

## 🛠️ Tumpukan Teknologi (*Technology Stack*)

| Lapisan | Teknologi | Deskripsi |
|:---|:---|:---|
| **Framework** | **Laravel 13.x** | *Framework* web PHP dengan arsitektur MVC |
| **Bahasa** | **PHP 8.3+** / **JavaScript (ES6+)** | Logika *backend* & interaktivitas *frontend* |
| **Basis Data** | **MySQL 8.0 / MariaDB / SQLite** | Basis data relasional (25 file migrasi, 13 Eloquent *model*) |
| **ORM** | **Eloquent ORM** | *Prepared statements* terstruktur tanpa kueri SQL mentah berisiko |
| **Frontend Styling** | **Tailwind CSS 3.x** | Sistem desain *Monochrome Industrial* & *Workshop Orange* (`#FF6B00`) |
| **Interaktivitas** | **Alpine.js** & **Vanilla JS** | Komponen dinamis, notifikasi, mode gelap via *View Transition API* |
| **Autentikasi** | **Laravel Breeze** & **Sanctum** | Autentikasi sesi *web* dan *Bearer Token* API |
| **API** | **RESTful API** | Respons standar JSON untuk integrasi sistem eksternal |
| **DevSecOps** | **GitHub Actions + SIDIK** | Gitleaks, Trivy, SIDIK SAST/SCA, `composer audit`, PHPUnit, & `ghcr.io` |

---

## ✨ Fitur Unggulan

### 👨‍💼 Panel Staf Internal (Admin & Mekanik)
- **Dasbor Analitik**: Ringkasan KPI pelanggan, kendaraan, mekanik, serta grafik tren pendapatan 7 hari dari servis dan pesanan *sparepart*.
- **Manajemen Transaksi Servis**: Pencatatan perbaikan kendaraan, penugasan mekanik, estimasi biaya, pembaruan status, dan cetak nota PDF.
- **Basis Data Pelanggan & Kendaraan**: CRUD lengkap dengan pencarian cepat dan unggah foto profil.
- **Manajemen Mekanik**: Pengelolaan profil mekanik, kontak, dan keahlian teknis.
- ***Workflow Booking* Servis**: Persetujuan *booking* masuk yang membuat `ServiceTransaction` dan mengirim notifikasi ke pelanggan.
- **Inventaris *Sparepart* & Pesanan**: Pengelolaan katalog, stok barang, harga, dan status pesanan daring.

### 👤 Portal Pelanggan & Halaman Publik
- **Halaman Utama & Informasi Publik**: Statistik bengkel dinamis, katalog *sparepart* aktif, testimoni pelanggan, dan formulir kontak (`/contact-us`).
- **Cek Status Servis Publik (`/cek-status`)**: Pelacakan progres pengerjaan berdasarkan nomor polisi atau nomor telepon dengan *polling* JSON `/api/transactions/{id}/status`.
- **Portal Pelanggan (`/masuk`, `/daftar`, `/portal`)**: Pengajuan *booking*, riwayat pesanan, kelola profil, serta pemulihan kata sandi berbasis OTP email.
- **Toko *Sparepart* Daring (`/sparepart`, `/cart`, `/checkout`)**: Keranjang belanja persisten lintas sesi/*cookie*/*database* dengan validasi stok.

---

## ⚡ *Quick Start* (Pengaturan Lokal)

### Prasyarat Sistem
- **PHP** >= 8.3 (ekstensi: `pdo`, `pdo_sqlite` / `pdo_mysql`, `mbstring`, `openssl`, `gd`, `intl`, `bcmath`)
- **Composer** >= 2.x
- **Node.js** >= 22.x & **npm**
- **MySQL** >= 8.0 / MariaDB >= 10.4 (atau SQLite untuk pengembangan cepat)

### Langkah Instalasi

```bash
# 1. Kloning repositori
git clone https://github.com/radityobw/SIBENGKEL.git
cd SIBENGKEL

# 2. Pasang dependensi PHP dan Node.js
composer install
npm ci

# 3. Salin berkas environment dan buat kunci aplikasi
cp .env.example .env
php artisan key:generate

# 4. (Opsional) Sesuaikan konfigurasi MySQL di .env apabila tidak memakai SQLite

# 5. Jalankan migrasi basis data dan seeder awal
php artisan migrate --seed

# 6. Buat tautan simbolik penyimpanan media
php artisan storage:link

# 7. Bangun aset frontend
npm run build

# 8. Jalankan server pengembangan lokal
php artisan serve
```

Akses aplikasi melalui peramban di `http://127.0.0.1:8000`.

### Menjalankan via *Container* (`ghcr.io`)

```bash
docker run --rm -p 8080:80 ghcr.io/radityobw/sibengkel:latest
```

Akses aplikasi melalui peramban di `http://127.0.0.1:8080` (menggunakan SQLite otomatis secara bawaan, atau kirim variabel lingkungan `DB_*` untuk MySQL/MariaDB).

---

## 🔑 Kredensial Akun Pengujian (*Seeder Default*)

Setelah menjalankan `php artisan migrate --seed`, akun bawaan berikut tersedia untuk pengujian lokal (`DatabaseSeeder.php`):

| Peran (*Role*) | URL Masuk | Username / Email | Password | Hak Akses |
|:---|:---|:---|:---|:---|
| **Admin** | `/login` | `adminbengkel` atau `admin@sibengkel.web.id` | `password123` | Akses penuh & seluruh modul CRUD |
| **Mekanik** | `/login` | `mekanikbudi` atau `budi.mekanik@sibengkel.web.id` | `password123` | Transaksi servis & pembaruan status |
| **Pelanggan** | `/masuk` | `andi@example.com` *(atau HP `081234567801`)* | `password123` | Portal pelanggan, *booking*, & belanja |

---

## 🌐 *Endpoints* RESTful API

SIBENGKEL menyediakan REST API terautentikasi menggunakan **Laravel Sanctum** (*Bearer Token*):

| No | Metode | *Endpoint* | Autentikasi | Deskripsi |
|:--:|:---:|:---|:---:|:---|
| 1 | `POST` | `/api/login` | Publik | Autentikasi staf (`login`, `password`) & terbitkan token Sanctum |
| 2 | `POST` | `/api/logout` | Bearer | Mencabut token Sanctum aktif |
| 3 | `GET` | `/api/customers` | Bearer | Mengambil daftar pelanggan |
| 4 | `POST` | `/api/customers` | Bearer | Menambahkan pelanggan baru |
| 5 | `GET` | `/api/vehicles` | Bearer | Mengambil daftar kendaraan |
| 6 | `POST` | `/api/vehicles` | Bearer | Menambahkan kendaraan baru |
| 7 | `GET` | `/api/services` | Bearer | Mengambil daftar transaksi servis |
| 8 | `POST` | `/api/services` | Bearer | Mencatat transaksi servis baru |
| 9 | `PATCH` | `/api/services/{service}/status` | Bearer | Memperbarui status servis (`pending` / `proses` / `selesai`) |
| 10 | `GET` | `/api/transactions/{id}/status` | Publik | *Polling* status *real-time* transaksi servis |

---

## 🧪 Pengujian Otomatis & QA *Blackbox*

```bash
# Jalankan seluruh unit & feature tests
php artisan test

# Validasi integritas Composer & audit kerentanan
composer validate --strict
composer audit --locked
```

- **Suite PHPUnit**: Mencakup pengujian metadata proyek, rute publik & sitemap, otorisasi peran (RBAC), REST API Sanctum, dan portal pelanggan.
- **Laporan QA *Blackbox***: [`docs/blackbox.md`](https://github.com/radityobw/SIBENGKEL/blob/main/docs/blackbox.md) (18 modul fungsional, 137 skenario uji terverifikasi).
- **Template Uji *Blackbox***: [`docs/blackbox-template.md`](https://github.com/radityobw/SIBENGKEL/blob/main/docs/blackbox-template.md).

---

## 📖 Indeks Dokumentasi (*Single Source of Truth*)

| No | Dokumen | Deskripsi |
|:--:|:---|:---|
| 1 | [PRD Utama (SSOT)](https://github.com/radityobw/SIBENGKEL/blob/main/docs/PRD_Sistem_Informasi_Bengkel.md) | Spesifikasi produk, ERD, matriks RBAC, dan kontrak API |
| 2 | [PRD Suplementer](https://github.com/radityobw/SIBENGKEL/blob/main/docs/PRD_Suplementer_Customer_Portal_SIBENGKEL.md) | Spesifikasi portal pelanggan, *booking* daring, & toko *sparepart* |
| 3 | [Design System](https://github.com/radityobw/SIBENGKEL/blob/main/docs/DESIGN.md) | Token warna, tipografi Sora/Inter, & aturan komponen UI |
| 4 | [Panduan Presentasi](https://github.com/radityobw/SIBENGKEL/blob/main/docs/penjelasan.md) | Penjelasan arsitektur dan alur sistem |
| 5 | [Blackbox Test Suite](https://github.com/radityobw/SIBENGKEL/blob/main/docs/blackbox.md) | Hasil pengujian *blackbox* 18 modul |
| 6 | [Execution Playbook](https://github.com/radityobw/SIBENGKEL/blob/main/docs/guidebook.md) | Panduan implementasi langkah demi langkah |
| 7 | [Direct Database Queries](https://github.com/radityobw/SIBENGKEL/blob/main/docs/query.md) | Referensi kueri SQL (DDL, DML, DQL) & Tinker |
| 8 | [Changelog](https://github.com/radityobw/SIBENGKEL/blob/main/CHANGELOG.md) | Riwayat rilis versi SIBENGKEL |
| 9 | [Contributing](https://github.com/radityobw/SIBENGKEL/blob/main/CONTRIBUTING.md) | Pedoman kontribusi, *pre-flight gate*, & alur rilis |
| 10 | [Security Policy](https://github.com/radityobw/SIBENGKEL/blob/main/SECURITY.md) | Kebijakan pelaporan kerentanan & gerbang keamanan |

---

## 📁 Struktur Direktori Proyek

```text
SIBENGKEL/
├── .github/                   # Workflow DevSecOps CI/CD, Release, Pages, & Dependabot
├── app/
│   ├── Http/Controllers/      # 35 Controller Web, Admin, Portal, & Sanctum API
│   ├── Http/Middleware/       # Middleware CheckRole untuk kontrol RBAC
│   ├── Mail/                  # OtpMail untuk reset kata sandi pelanggan
│   ├── Models/                # 13 Eloquent Model & relasi basis data
│   └── Notifications/         # Engine notifikasi in-app
├── config/                    # Konfigurasi aplikasi (termasuk APP version dari VERSION)
├── database/
│   ├── migrations/            # 25 file migrasi terstruktur
│   └── seeders/               # Seeder data awal (DatabaseSeeder, Page, SparePart, Testimonial)
├── docs/
│   ├── pages/                 # Situs statis GitHub Pages tersinkron otomatis
│   └── ...                    # PRD, DESIGN, Blackbox QA, Guidebook, Query, & Stitch mockups
├── public/                    # Aset publik & logo resmi (logobengkel.png)
├── resources/views/           # 78 templat Blade (Admin, Portal Pelanggan, Publik)
├── routes/                    # Definisi rute web.php, api.php, auth.php, & console.php
├── tests/                     # Suite pengujian otomatis PHPUnit (Unit & Feature)
├── CHANGELOG.md               # Riwayat perubahan versi
├── CITATION.cff               # Metadata sitasi akademik
├── CONTRIBUTING.md            # Panduan kontribusi & gerbang rilis
├── LICENSE                    # Lisensi MIT
├── SECURITY.md                # Kebijakan keamanan repositori
└── VERSION                    # Single Source of Truth (SSOT) versi rilis
```

---

## 👥 Tim Pengembang

Disusun untuk Mata Kuliah **Pemrograman Web & Sistem Basis Data**:

- **Radityo Budi Waskito** - *Lead Developer & Software Architect* ([@radityobw](https://github.com/radityobw))
  *Fullstack Architecture, Multi-Guard Auth, Sanctum REST API, DevSecOps & Deployment*
- **Zayyan Fadhlur Rahman** - *Frontend & UI/UX Engineer*
  *Blade Templating, Mobile-First Design, Dark Mode System, Component Styling & Animations*
- **Raditya Ahmad Pratama** - *Backend & Database Engineer*
  *Eloquent Data Layer, Database Migrations, Input Validation & System Testing*

---

# 🇬🇧 English

## 📌 Project Overview

**SIBENGKEL** (*Sistem Informasi Bengkel*) is an integrated automotive workshop web platform built with **Laravel 13**, **PHP 8.3+**, **Eloquent ORM**, and **Tailwind CSS 3**. It unifies internal garage operations (Admin & Mechanic workflows), customer self-service booking, an integrated sparepart store, public real-time service tracking, and a Sanctum-protected RESTful API.

## ✨ Core Capabilities

- **Workshop Service Operations**: Track repair statuses (`pending`, `proses`, `selesai`), assign mechanics, compute 7-day revenue trends, and print service invoices.
- **Dual-Guard Authentication & RBAC**: Separate guards for internal staff (`web` at `/login`) and customers (`customer` at `/masuk`), with role middleware (`admin`, `mekanik`).
- **Customer Portal & Online Booking**: Schedule repairs online, receive in-app approval notifications, convert bookings to service transactions, and reset passwords via email OTP.
- **Sparepart E-Commerce & Public Status Lookup**: Browse `/sparepart`, manage persistent carts (`cart_data`), check out with stock validation, and poll repair progress at `/cek-status`.
- **Sanctum RESTful API & DevSecOps**: Token-authenticated API endpoints paired with automated CI/CD checks (Gitleaks, Trivy, SIDIK SAST/SCA, `composer audit --locked`, and PHPUnit across PHP 8.3 and 8.4).

## 🚀 Quick Start

```bash
git clone https://github.com/radityobw/SIBENGKEL.git
cd SIBENGKEL
composer install
npm ci
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan test
php artisan serve

# Or run directly via GitHub Container Registry (ghcr.io)
docker run --rm -p 8080:80 ghcr.io/radityobw/sibengkel:latest
```

## 📄 License

Distributed under the **MIT License**. See [LICENSE](https://github.com/radityobw/SIBENGKEL/blob/main/LICENSE).

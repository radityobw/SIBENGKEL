# Product Requirements Document (PRD)
# Sistem Informasi Bengkel

| Atribut | Keterangan |
|---|---|
| Nama Proyek | Sistem Informasi Bengkel (SIB) |
| Mata Kuliah | Pemrograman Web + Sistem Basis Data |
| Jenis Dokumen | Product Requirements Document |
| Versi | 1.0 |
| Deadline Presentasi | Senin, 27 Juli 2026 |
| Jumlah Anggota Kelompok | 3 orang |
| Status | Draft — siap dikembangkan |

---

## 1. Ringkasan Eksekutif

Sistem Informasi Bengkel (SIB) adalah aplikasi web berbasis Laravel yang dirancang untuk mendigitalisasi proses operasional bengkel kendaraan, mulai dari pendataan pelanggan dan kendaraan, pencatatan transaksi servis/penjualan, hingga penyediaan API publik yang aman menggunakan Laravel Sanctum. Sistem ini dibangun dengan pendekatan **mobile-first**, arsitektur **MVC**, dan basis data relasional, untuk memastikan proses bengkel yang selama ini manual (dicatat di buku/kertas) menjadi lebih cepat, akurat, dan mudah dilacak.

Dokumen ini menjadi acuan tunggal bagi tim (3 anggota) dalam merancang, membangun, menguji, dan mendokumentasikan aplikasi sesuai dengan ketentuan tugas akhir dan rubrik penilaian yang berlaku.

---

## 2. Latar Belakang

Bengkel kendaraan pada umumnya masih mengelola data pelanggan, kendaraan, dan riwayat servis secara manual atau menggunakan spreadsheet terpisah. Hal ini menimbulkan beberapa masalah:

- Riwayat servis kendaraan sulit ditelusuri kembali.
- Data pelanggan dan kendaraan rawan duplikasi atau hilang.
- Tidak ada kontrol akses antara admin/mekanik dan proses transaksi.
- Tidak tersedia akses data secara terprogram (API) untuk kebutuhan integrasi di masa depan (misalnya aplikasi mobile atau dashboard pihak ketiga).

SIB hadir sebagai solusi berbasis web yang terpusat, memiliki autentikasi, mendukung operasi CRUD penuh, serta menyediakan REST API teramankan token (Sanctum).

---

## 3. Tujuan

1. Menyediakan platform terpusat untuk mengelola data mekanik/admin, pelanggan, kendaraan, dan transaksi servis/penjualan.
2. Menerapkan sistem autentikasi (login/register) dan otorisasi berbasis peran (role-based access).
3. Menyediakan REST API yang aman menggunakan Laravel Sanctum untuk konsumsi data eksternal.
4. Menghadirkan antarmuka yang responsif (mobile-first) agar dapat diakses dari perangkat apa pun.
5. Mendemonstrasikan penerapan prinsip MVC, Eloquent ORM, relasi antar tabel, dan validasi input yang baik.
6. Menghasilkan aplikasi yang di-deploy secara publik (repo Git + hosting + domain) sebagai bukti implementasi nyata.

---

## 4. Ruang Lingkup (Scope)

### 4.1 Termasuk dalam Ruang Lingkup
- Modul autentikasi (login, logout, register, proteksi rute).
- Modul manajemen data master: Mekanik/Admin, Pelanggan, Kendaraan.
- Modul transaksi: pencatatan servis dan/atau penjualan.
- REST API dengan otentikasi token (Sanctum) minimal 2 endpoint publik terautentikasi.
- Tampilan responsif (mobile-first) untuk seluruh halaman.
- Dokumentasi laporan tugas akhir lengkap (BAB I–V + Lampiran).
- Proses deployment ke hosting publik dengan domain aktif.

### 4.2 Di Luar Ruang Lingkup (Out of Scope)
- Sistem pembayaran online (payment gateway) — kecuali jika tim ingin menambahkan sebagai fitur nilai tambah (nice-to-have).
- Aplikasi mobile native (Android/iOS).
- Notifikasi real-time (email/SMS) — opsional sebagai pengembangan lanjutan.
- Multi-cabang bengkel (multi-tenant) — opsional pengembangan lanjutan.

---

## 5. Target Pengguna & Peran (Roles)

| Peran | Deskripsi | Hak Akses Utama |
|---|---|---|
| **Admin** | Pemilik/pengelola bengkel | Akses penuh ke semua modul, kelola user, laporan |
| **Mekanik** | Petugas teknis bengkel | Kelola data servis, update status pengerjaan, lihat data kendaraan & pelanggan |
| **Pelanggan** *(opsional login)* | Pemilik kendaraan | Lihat riwayat servis miliknya (jika fitur portal pelanggan diaktifkan) |

> Catatan: Minimal sistem harus membedakan hak akses **Admin/Mekanik** sebagai pengguna internal yang login, sedangkan **Pelanggan** dapat diperlakukan sebagai entitas data (bukan wajib punya akun login), sesuai kebutuhan tim.

---

## 6. Entitas Data Utama & Relasi

Sesuai ketentuan tugas, sistem minimal memiliki 4 entitas inti berikut:

| Entitas | Deskripsi Singkat |
|---|---|
| **Mekanik/Admin (users)** | Data pengguna internal sistem beserta peran (role) dan kredensial login |
| **Pelanggan (customers)** | Data pemilik kendaraan: nama, kontak, alamat |
| **Kendaraan (vehicles)** | Data kendaraan milik pelanggan: plat nomor, merk, tipe, tahun |
| **Transaksi (services/transactions)** | Catatan servis/penjualan: jenis layanan, biaya, status, tanggal, mekanik penanggung jawab |

### 6.1 Gambaran Relasi (ERD Ringkas)

```
users (mekanik/admin)  1 ────< transactions
customers               1 ────< vehicles
vehicles                1 ────< transactions
customers               1 ────< transactions   (opsional, relasi langsung)
```

**Penjelasan relasi:**
- Satu **pelanggan** dapat memiliki banyak **kendaraan** (1 → N).
- Satu **kendaraan** dapat memiliki banyak **transaksi** servis (1 → N).
- Satu **mekanik/admin** dapat menangani banyak **transaksi** (1 → N).
- Tabel `transactions` menjadi tabel penghubung utama (fact table) yang mencatat histori servis/penjualan.

> ERD detail (format visual: Chen/Crow's Foot) wajib dibuat pada BAB III Laporan menggunakan tools seperti draw.io, dbdiagram.io, atau Lucidchart.

### 6.2 Rancangan Struktur Tabel (Kamus Data Ringkas)

**users**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| name | varchar | |
| email | varchar, unique | |
| password | varchar, hashed | |
| role | enum('admin','mekanik') | |
| timestamps | datetime | created_at, updated_at |

**customers**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| name | varchar | |
| phone | varchar | |
| address | text | |
| timestamps | datetime | |

**vehicles**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| customer_id | bigint, FK → customers.id | |
| plate_number | varchar, unique | |
| brand | varchar | |
| model | varchar | |
| year | int | |
| timestamps | datetime | |

**transactions**
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint, PK | |
| vehicle_id | bigint, FK → vehicles.id | |
| user_id | bigint, FK → users.id (mekanik) | |
| type | enum('servis','penjualan') | |
| description | text | |
| cost | decimal(12,2) | |
| status | enum('pending','proses','selesai') | |
| transaction_date | date | |
| timestamps | datetime | |

---

## 7. Fitur Fungsional & User Stories

### 7.1 Autentikasi (Auth)
| ID | User Story | Prioritas |
|---|---|---|
| F-01 | Sebagai admin/mekanik, saya dapat login menggunakan email & password | Wajib |
| F-02 | Sebagai admin/mekanik, saya dapat logout dari sistem | Wajib |
| F-03 | Sebagai admin, saya dapat mendaftarkan akun mekanik baru | Wajib |
| F-04 | Sistem membatasi akses halaman sesuai role (middleware) | Wajib |

### 7.2 Manajemen Pelanggan (CRUD)
| ID | User Story | Prioritas |
|---|---|---|
| F-05 | Admin/mekanik dapat menambah data pelanggan baru | Wajib |
| F-06 | Admin/mekanik dapat melihat daftar & detail pelanggan | Wajib |
| F-07 | Admin/mekanik dapat mengubah data pelanggan | Wajib |
| F-08 | Admin/mekanik dapat menghapus data pelanggan | Wajib |

### 7.3 Manajemen Kendaraan (CRUD)
| ID | User Story | Prioritas |
|---|---|---|
| F-09 | Admin/mekanik dapat menambah kendaraan yang terkait ke pelanggan | Wajib |
| F-10 | Admin/mekanik dapat melihat daftar kendaraan per pelanggan | Wajib |
| F-11 | Admin/mekanik dapat mengubah/menghapus data kendaraan | Wajib |

### 7.4 Manajemen Transaksi Servis/Penjualan (CRUD)
| ID | User Story | Prioritas |
|---|---|---|
| F-12 | Mekanik dapat mencatat transaksi servis baru untuk suatu kendaraan | Wajib |
| F-13 | Mekanik dapat memperbarui status transaksi (pending/proses/selesai) | Wajib |
| F-14 | Admin dapat melihat seluruh riwayat transaksi dengan filter tanggal/status | Wajib |
| F-15 | Admin/mekanik dapat menghapus/mengedit transaksi yang keliru | Wajib |

### 7.5 Dashboard & Laporan (Nilai Tambah)
| ID | User Story | Prioritas |
|---|---|---|
| F-16 | Admin melihat ringkasan jumlah transaksi & pendapatan harian/bulanan | Opsional |
| F-17 | Admin dapat mengekspor data transaksi ke PDF/Excel | Opsional |

---

## 8. Kebutuhan API (REST API + Sanctum)

Autentikasi API menggunakan **Laravel Sanctum** (token-based authentication).

### 8.1 Endpoint Wajib

| Method | Endpoint | Deskripsi | Auth |
|---|---|---|---|
| POST | `/api/login` | Login & menerbitkan token Sanctum | Tidak |
| GET | `/api/services` | Daftar transaksi servis dalam format JSON | Ya (Bearer Token) |
| GET | `/api/customers` | Daftar pelanggan dalam format JSON | Ya (Bearer Token) |

### 8.2 Contoh Kontrak Response

**GET /api/customers**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Budi Santoso",
      "phone": "0812xxxxxxx",
      "address": "Jl. Merdeka No. 10",
      "vehicles_count": 2
    }
  ]
}
```

**GET /api/services**
```json
{
  "success": true,
  "data": [
    {
      "id": 10,
      "vehicle": "B 1234 XYZ",
      "customer": "Budi Santoso",
      "type": "servis",
      "status": "proses",
      "cost": 350000,
      "transaction_date": "2026-07-20"
    }
  ]
}
```

### 8.3 Endpoint Tambahan (Rekomendasi Pengembangan)
- `POST /api/services` — tambah transaksi via API
- `GET /api/vehicles` — daftar kendaraan
- `POST /api/logout` — hapus token aktif

---

## 9. Kebutuhan Non-Fungsional

| Kategori | Kebutuhan |
|---|---|
| **Responsivitas** | Tampilan wajib mobile-first, diuji minimal pada breakpoint 375px, 768px, 1024px |
| **Keamanan** | Password di-hash (bcrypt), validasi input server-side, proteksi CSRF, token Sanctum untuk API |
| **Kinerja** | Waktu muat halaman < 3 detik pada koneksi standar |
| **Konsistensi UI** | Menggunakan satu sistem desain (misal Bootstrap/Tailwind) secara konsisten di semua halaman |
| **Maintainability** | Kode mengikuti struktur MVC Laravel, menggunakan Eloquent ORM (bukan raw SQL) |
| **Ketersediaan** | Aplikasi harus live/dapat diakses publik saat presentasi |

---

## 10. Tumpukan Teknologi (Tech Stack)

| Layer | Teknologi |
|---|---|
| Backend Framework | Laravel (PHP) |
| Autentikasi Web | Laravel Breeze/Jetstream (opsional) |
| Autentikasi API | Laravel Sanctum |
| Database | MySQL / MariaDB |
| ORM | Eloquent |
| Frontend | Blade + Bootstrap / Tailwind CSS (mobile-first) |
| Version Control | Git & GitHub |
| Hosting | Shared hosting/VPS mendukung PHP & MySQL (misal Niagahoster, Hostinger, Railway, atau sejenis) + domain aktif |
| Tools Pendukung | Postman (testing API), draw.io/dbdiagram.io (ERD) |

---

## 11. Struktur Direktori (Rancangan)

```
sistem-informasi-bengkel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── CustomerController.php
│   │   │   ├── VehicleController.php
│   │   │   ├── TransactionController.php
│   │   │   └── Api/
│   │   │       ├── ServiceApiController.php
│   │   │       └── CustomerApiController.php
│   │   └── Middleware/
│   └── Models/
│       ├── User.php
│       ├── Customer.php
│       ├── Vehicle.php
│       └── Transaction.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       ├── customers/
│       ├── vehicles/
│       └── transactions/
├── routes/
│   ├── web.php
│   └── api.php
└── README.md
```

---

## 12. Alur Kerja Utama (Workflow Bisnis)

1. Pelanggan datang membawa kendaraan → Admin/mekanik mendata pelanggan baru (jika belum ada) dan kendaraannya.
2. Mekanik membuat transaksi servis baru, memilih kendaraan terkait, mengisi deskripsi & estimasi biaya.
3. Status transaksi diperbarui secara berkala: `pending` → `proses` → `selesai`.
4. Admin memantau seluruh transaksi melalui dashboard/daftar transaksi.
5. Data dapat diakses melalui API (misalnya untuk keperluan integrasi atau laporan eksternal) menggunakan token Sanctum.

---

## 13. Rencana Pengujian (Test Plan)

| No | Skenario Uji | Hasil yang Diharapkan | Terkait Rubrik |
|---|---|---|---|
| 1 | Login dengan kredensial valid | Berhasil masuk & diarahkan ke dashboard | Fungsionalitas |
| 2 | Login dengan kredensial salah | Muncul pesan error, akses ditolak | Fungsionalitas & Keamanan |
| 3 | Tambah/Edit/Hapus data pelanggan | Data tersimpan/berubah/terhapus di database | Fungsionalitas |
| 4 | Tambah kendaraan tanpa memilih pelanggan | Validasi input menolak & menampilkan pesan error | Kualitas Kode |
| 5 | Buat transaksi servis baru | Data transaksi tersimpan dan relasi ke kendaraan benar | Fungsionalitas |
| 6 | Akses `/api/customers` tanpa token | Response 401 Unauthorized | API & Keamanan |
| 7 | Akses `/api/customers` dengan token valid | Response 200 dengan data JSON pelanggan | API & Keamanan |
| 8 | Buka aplikasi di layar mobile (375px) | Tampilan tetap rapi, navigasi mudah diakses | Tampilan & UX |
| 9 | Uji CRUD di berbagai role (admin vs mekanik) | Hak akses sesuai peran masing-masing | Fungsionalitas |
| 10 | Deploy aplikasi & akses via domain publik | Aplikasi dapat diakses tanpa error | Hosting & Dokumentasi |

---

## 14. Rencana Deployment

1. **Repository**: Buat repo GitHub privat/publik, gunakan branching sederhana (`main` + `dev`).
2. **Environment**: Siapkan `.env.example` untuk konfigurasi database & Sanctum.
3. **Hosting**: Pilih penyedia hosting yang mendukung PHP 8+ dan MySQL (atau platform seperti Railway/Render untuk kemudahan deploy Laravel).
4. **Domain**: Gunakan subdomain gratis dari penyedia hosting atau domain custom bila tersedia.
5. **Checklist sebelum presentasi**:
   - [ ] Migrasi & seeder berjalan di server produksi
   - [ ] `.env` produksi terkonfigurasi (APP_DEBUG=false)
   - [ ] Endpoint API teruji via Postman di server produksi
   - [ ] SSL aktif (opsional tapi disarankan)

---

## 15. Pembagian Tugas Tim (Rekomendasi, 3 Anggota)

| Anggota | Tanggung Jawab Utama |
|---|---|
| **Anggota 1 — Backend Lead** | Struktur database, migration, model, relasi Eloquent, autentikasi (Auth + Sanctum) |
| **Anggota 2 — Frontend/UI Lead** | Desain tampilan responsif, layout Blade, integrasi Bootstrap/Tailwind, UX halaman CRUD |
| **Anggota 3 — QA & Dokumentasi Lead** | Pengujian fungsionalitas, penyusunan laporan (BAB I–V), ERD, deployment, dokumentasi API (Postman) |

> Pembagian tugas bersifat kolaboratif — setiap anggota tetap harus memahami keseluruhan sistem untuk menjawab pertanyaan saat sesi presentasi (bobot 5% pada rubrik).

---

## 16. Timeline Pengerjaan (s.d. 27 Juli 2026)

| Tahap | Aktivitas | Target Selesai |
|---|---|---|
| 1 | Perancangan ERD, skema database, wireframe | H-6 |
| 2 | Setup project Laravel, migration, auth | H-5 |
| 3 | Implementasi CRUD (customers, vehicles, transactions) | H-4 |
| 4 | Implementasi API + Sanctum | H-3 |
| 5 | Styling responsif & QA fungsional | H-2 |
| 6 | Deployment & pengujian di server produksi | H-1 |
| 7 | Finalisasi laporan PDF & gladi presentasi | H |

---

## 17. Pemetaan ke Rubrik Penilaian

| Aspek Rubrik | Bobot | Fitur/Bagian PRD Terkait |
|---|---|---|
| Fungsionalitas | 40% | Bagian 7 (Fitur & User Stories), Bagian 13 (Test Plan) |
| Kualitas Kode | 20% | Bagian 9 (Non-fungsional), Bagian 11 (Struktur direktori MVC) |
| Tampilan & UX | 15% | Bagian 9 (Responsivitas), Bagian 13 no. 8 |
| API & Keamanan | 10% | Bagian 8 (Kebutuhan API + Sanctum) |
| Hosting & Dokumentasi | 10% | Bagian 14 (Deployment), dokumen ini sebagai basis laporan BAB III |
| Presentasi | 5% | Bagian 15 (Pembagian tugas), pemahaman menyeluruh tim |

---

## 18. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|---|---|---|
| Keterbatasan waktu (deadline ketat) | Fitur tidak selesai tepat waktu | Prioritaskan fitur "Wajib" di Bagian 7 sebelum fitur opsional |
| Relasi database salah rancang di awal | Refactor besar di tengah jalan | Finalisasi ERD & skema sebelum mulai coding (Bagian 6) |
| Hosting bermasalah saat presentasi | Demo gagal | Siapkan juga versi lokal (localhost) sebagai cadangan demo |
| Endpoint API tidak konsisten formatnya | Nilai aspek API & Keamanan turun | Gunakan format response JSON terstandar sejak awal (Bagian 8.2) |

---

## 19. Lampiran Rujukan untuk Laporan

Dokumen PRD ini dapat langsung digunakan sebagai dasar penyusunan:
- **BAB I** → Bagian 2, 3, 4 (Latar Belakang, Tujuan, Ruang Lingkup)
- **BAB II** → Bagian 10 (Tech Stack) sebagai basis Landasan Teori
- **BAB III** → Bagian 6, 8, 11 (ERD, Skema Relasi, Rancangan API, Struktur Sistem)
- **BAB IV** → Bagian 13, 14 (Pengujian & Deployment) — lengkapi dengan screenshot aktual
- **BAB V** → Disusun setelah implementasi selesai, merujuk pencapaian pada Bagian 17

---

*Dokumen ini bersifat living document dan dapat diperbarui seiring perkembangan implementasi oleh tim.*

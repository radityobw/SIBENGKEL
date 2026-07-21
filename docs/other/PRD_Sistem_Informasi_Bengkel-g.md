# Product Requirements Document (PRD)
# Sistem Informasi Bengkel (SIBENGKEL)

## 1. Ringkasan Produk

### Nama Produk
SIBENGKEL — Sistem Informasi Bengkel Berbasis Web

### Visi Produk
Membangun sistem informasi bengkel modern yang mampu mengelola pelanggan, kendaraan, mekanik, transaksi servis, dan penjualan secara terintegrasi, responsif, aman, dan mudah digunakan.

### Tujuan Utama
- Digitalisasi operasional bengkel.
- Mempermudah pencatatan servis dan transaksi.
- Mengurangi kesalahan administrasi.
- Menyediakan data pelanggan dan kendaraan secara terstruktur.
- Menyediakan API untuk integrasi eksternal.

---

# 2. Latar Belakang

Banyak bengkel masih menggunakan pencatatan manual sehingga proses administrasi menjadi lambat, rawan kesalahan, dan sulit menghasilkan laporan yang akurat.

Sistem Informasi Bengkel dikembangkan untuk mengatasi permasalahan tersebut melalui platform web yang terpusat, sehingga seluruh data dapat dikelola secara efisien dan terdokumentasi dengan baik.

---

# 3. Ruang Lingkup Produk

## In Scope

### Autentikasi
- Login
- Logout
- Session Management
- API Authentication menggunakan Laravel Sanctum

### Manajemen Pelanggan
- Tambah pelanggan
- Ubah pelanggan
- Hapus pelanggan
- Lihat daftar pelanggan

### Manajemen Kendaraan
- Tambah kendaraan
- Edit kendaraan
- Hapus kendaraan
- Relasi kendaraan dengan pelanggan

### Manajemen Mekanik/Admin
- Tambah data mekanik
- Edit data mekanik
- Hapus data mekanik
- Monitoring aktivitas

### Manajemen Transaksi
- Servis kendaraan
- Penjualan sparepart
- Riwayat transaksi
- Detail transaksi

### API
- GET /api/services
- GET /api/customers

### Deployment
- Git Repository
- Hosting
- Domain aktif

---

# 4. Stakeholder

## Internal
- Admin
- Mekanik
- Tim Pengembang
- Dosen Pembimbing

## Eksternal
- Pelanggan Bengkel

---

# 5. User Persona

## Admin

### Tujuan
Mengelola seluruh operasional bengkel.

### Kebutuhan
- Mengelola data master
- Mengelola transaksi
- Melihat laporan

### Pain Point
- Data tersebar
- Sulit mencari riwayat servis

---

## Mekanik

### Tujuan
Mencatat pekerjaan servis kendaraan.

### Kebutuhan
- Melihat kendaraan masuk
- Menginput hasil servis

---

## Pelanggan

### Tujuan
Mendapatkan layanan servis yang terdokumentasi.

### Kebutuhan
- Data kendaraan tersimpan
- Riwayat servis terdokumentasi

---

# 6. Functional Requirements

## FR-01 Authentication

### Deskripsi
Sistem harus menyediakan autentikasi pengguna.

### Acceptance Criteria
- Login berhasil dengan kredensial valid.
- Login gagal dengan kredensial tidak valid.
- Logout menghapus sesi aktif.

---

## FR-02 CRUD Pelanggan

### Data
- Nama
- Nomor Telepon
- Alamat

### Acceptance Criteria
- Data dapat ditambah.
- Data dapat diperbarui.
- Data dapat dihapus.
- Data dapat dicari.

---

## FR-03 CRUD Kendaraan

### Data
- Nomor Polisi
- Merek
- Model
- Tahun
- Pemilik

### Acceptance Criteria
- Kendaraan terhubung dengan pelanggan.
- Data tersimpan dengan benar.

---

## FR-04 CRUD Mekanik

### Data
- Nama
- Nomor Telepon
- Keahlian

---

## FR-05 CRUD Transaksi Servis

### Data
- Nomor Transaksi
- Tanggal
- Pelanggan
- Kendaraan
- Mekanik
- Keluhan
- Biaya

### Acceptance Criteria
- Transaksi tersimpan.
- Relasi antar data berjalan.

---

## FR-06 Riwayat Servis

### Acceptance Criteria
- Riwayat dapat ditampilkan.
- Riwayat dapat difilter.

---

## FR-07 REST API

### Endpoint 1
GET /api/services

### Response
JSON

### Endpoint 2
GET /api/customers

### Response
JSON

---

# 7. Non Functional Requirements

## Performance
- Response < 3 detik.
- Pagination untuk data besar.

## Security
- Laravel Sanctum.
- Password Hashing.
- CSRF Protection.
- Validation Input.

## Reliability
- Data konsisten.
- Tidak terjadi duplikasi data.

## Scalability
- Struktur database mendukung penambahan fitur.

## Maintainability
- Menggunakan MVC Laravel.
- Menggunakan Eloquent ORM.

## Usability
- Mobile First.
- Responsive.
- Navigasi sederhana.

---

# 8. System Architecture

## Frontend
- HTML
- CSS
- JavaScript
- Bootstrap / Tailwind CSS

## Backend
- Laravel

## Database
- MySQL / MariaDB

## API
- Laravel Sanctum

## Hosting
- Shared Hosting / VPS

---

# 9. Entity Relationship

## Customer
Menyimpan data pelanggan.

## Vehicle
Menyimpan data kendaraan.

## Mechanic
Menyimpan data mekanik.

## ServiceTransaction
Menyimpan transaksi servis.

---

## Relasi

Customer
1 : N
Vehicle

Vehicle
1 : N
ServiceTransaction

Mechanic
1 : N
ServiceTransaction

---

# 10. Database Design

## customers
- id
- name
- phone
- address
- created_at
- updated_at

## vehicles
- id
- customer_id
- plate_number
- brand
- model
- year
- created_at
- updated_at

## mechanics
- id
- name
- phone
- expertise
- created_at
- updated_at

## service_transactions
- id
- vehicle_id
- mechanic_id
- complaint
- service_date
- cost
- created_at
- updated_at

---

# 11. User Flow

Login
→ Dashboard
→ Kelola Pelanggan
→ Kelola Kendaraan
→ Kelola Mekanik
→ Kelola Transaksi
→ API
→ Logout

---

# 12. Wireframe Recommendation

## Dashboard
- Statistik pelanggan
- Statistik kendaraan
- Statistik transaksi

## Customer Page
- Search
- Table
- CRUD Action

## Vehicle Page
- Search
- Table
- CRUD Action

## Mechanic Page
- Search
- Table
- CRUD Action

## Transaction Page
- Filter
- Search
- Detail

---

# 13. API Specification

## GET /api/customers

Response:

```json
{
  "success": true,
  "data": []
}
```

## GET /api/services

```json
{
  "success": true,
  "data": []
}
```

---

# 14. Testing Plan

## Authentication Test
- Login valid
- Login invalid
- Logout

## Customer Test
- Create
- Read
- Update
- Delete

## Vehicle Test
- Create
- Read
- Update
- Delete

## Mechanic Test
- Create
- Read
- Update
- Delete

## Transaction Test
- Create
- Read
- Update
- Delete

## API Test
- Endpoint berjalan
- Response JSON valid
- Token Sanctum valid

---

# 15. Deployment Plan

## Source Control
GitHub Repository

## Hosting
Deploy aplikasi ke hosting publik.

## Domain
Gunakan domain aktif yang dapat diakses dosen penguji.

---

# 16. Success Metrics

### Functional
- Semua CRUD berjalan.
- Semua relasi berjalan.
- API berjalan.

### Technical
- Tidak ada error kritis.
- Data tersimpan dengan benar.

### Academic
- Memenuhi seluruh rubrik penilaian.
- Laporan lengkap.
- Presentasi berhasil.

---

# 17. Future Enhancement

- Notifikasi servis berkala.
- Dashboard analitik.
- Manajemen sparepart.
- Cetak invoice PDF.
- WhatsApp Reminder.
- Booking servis online.
- Multi Role Access Control.
- Laporan keuangan otomatis.

---

# 18. Kesimpulan

SIBENGKEL dirancang sebagai sistem informasi bengkel modern yang memenuhi seluruh kebutuhan tugas akhir pemrograman web dan sistem basis data. Sistem mengimplementasikan autentikasi, CRUD, relasi database, REST API, keamanan Laravel Sanctum, desain responsif, serta deployment publik sehingga memenuhi kebutuhan akademik sekaligus relevan untuk implementasi dunia nyata.

# Product Requirements Document (PRD)
## Sistem Informasi Bengkel Terpadu

**Status:** Disetujui  
**Tanggal:** Juli 2026  
**Tim Proyek:** 3 Orang per Kelompok [cite: 1]  
**Tenggat Waktu Utama:** Senin, 27 Juli 2026 (Presentasi) [cite: 1]  

---

## 1. Ringkasan Eksekutif (Executive Summary)
Sistem Informasi Bengkel adalah sebuah platform berbasis web yang dirancang secara komprehensif, intuitif, dan modern untuk mengelola operasional bengkel secara digital [cite: 1]. Sistem ini memfasilitasi pencatatan data pelanggan, manajemen kendaraan, penjadwalan mekanik, serta pelacakan transaksi servis dan penjualan secara terstruktur dan terpusat. PRD ini disusun untuk memenuhi kebutuhan Tugas Akhir Pemrograman Web dan Sistem Basis Data, dengan mengedepankan kualitas kode (MVC, REST API, Relational DB) dan pengalaman pengguna (UI/UX) [cite: 1].

## 2. Latar Belakang & Tujuan Proyek
*   **Latar Belakang:** Kebutuhan akan sistem digital yang kooperatif dan berkelanjutan untuk menggantikan pencatatan manual di bengkel otomotif, meminimalisir kesalahan data, dan mempercepat proses layanan.
*   **Tujuan:** 
    *   Membangun sistem informasi berbasis web yang fungsional dan responsif [cite: 1].
    *   Menerapkan arsitektur Model-View-Controller (MVC) yang rapi dan aman [cite: 1].
    *   Menyediakan REST API untuk integrasi data yang menyeluruh [cite: 1].
    *   Memenuhi syarat kelulusan Tugas Akhir dengan standar industri modern [cite: 1].

## 3. Ruang Lingkup Sistem (Scope)
Sistem ini dibatasi pada minimum entitas dan fungsionalitas berikut untuk memastikan pengembangan yang terarah dan terperinci:

### 3.1. Entitas Minimum Sistem
1.  **Mekanik / Admin:** Pengguna yang memiliki hak akses sistem untuk mengelola data dan operasional [cite: 1].
2.  **Pelanggan:** Pemilik kendaraan yang menggunakan jasa bengkel [cite: 1].
3.  **Kendaraan:** Unit yang diregistrasikan dan menerima layanan servis [cite: 1].
4.  **Transaksi:** Pencatatan riwayat servis maupun penjualan sparepart [cite: 1].

### 3.2. Fitur Utama (Fungsionalitas)
*   **Autentikasi (Auth):** Sistem login dan manajemen sesi yang aman (termasuk proteksi rute) [cite: 1].
*   **CRUD Operations:** Fitur Create, Read, Update, Delete untuk semua entitas (Mekanik, Pelanggan, Kendaraan, Transaksi) [cite: 1].
*   **RESTful API:** Integrasi pihak ketiga menggunakan token otentikasi (Laravel Sanctum) [cite: 1].

## 4. Kebutuhan Antarmuka & API (Interfaces & API)
### 4.1. Desain Antarmuka Pengguna (UI/UX)
*   **Mobile-First Design:** Tampilan harus responsif dan intuitif, memprioritaskan akses dari perangkat mobile sebelum di-scale up ke tampilan desktop [cite: 1].
*   **Modern & Konsisten:** Navigasi yang jelas, informatif, dan mudah dipahami oleh pengguna awam [cite: 1].

### 4.2. Spesifikasi API Minimum
Sistem wajib menyediakan Application Programming Interface (API) berformat JSON yang dilindungi oleh otentikasi Sanctum [cite: 1]:
*   `GET /api/services` : Menampilkan daftar seluruh transaksi servis bengkel [cite: 1].
*   `GET /api/customers` : Menampilkan daftar seluruh data pelanggan bengkel [cite: 1].

## 5. Persyaratan Teknis & Arsitektur
*   **Framework:** Laravel (menggunakan pola arsitektur MVC yang tegas) [cite: 1].
*   **Basis Data:** Relational Database dengan konfigurasi relasi antar tabel (Foreign Keys, Cascade, dll) [cite: 1].
*   **Kualitas Kode:** Penggunaan Eloquent ORM (dilarang keras menggunakan Raw SQL), disertai dengan validasi input yang ketat dan lapisan keamanan (security) standar [cite: 1].
*   **Infrastruktur (Deployment):** Aplikasi harus berstatus live dan dapat diakses publik melalui Domain dan Hosting terpadu, serta dikelola menggunakan Version Control System (GitHub Repository) [cite: 1].

---

## 6. Struktur Pelaporan Tugas Akhir
Dokumentasi proyek (laporan tertulis) harus disusun secara komprehensif dan sistematis sesuai format berikut [cite: 1]:

| Bab | Isi Laporan |
| :--- | :--- |
| **BAB I** | Pendahuluan (Latar belakang, tujuan, ruang lingkup) [cite: 1] |
| **BAB II** | Landasan Teori (Laravel, MVC, REST API, Relational DB) [cite: 1] |
| **BAB III** | Analisis & Perancangan Sistem (ERD, Skema Relasi / Kamus Data, Rancangan Tampilan/Wireframe) [cite: 1] |
| **BAB IV** | Implementasi & Pengujian (Screenshot aplikasi jadi, Link akses aplikasi, Pengujian fungsionalitas / tabel uji) [cite: 1] |
| **BAB V** | Penutup (Kesimpulan dan Saran) [cite: 1] |
| **Lampiran** | Struktur direktori project, Contoh response API (Screenshot Postman), Link GitHub repository [cite: 1] |

---

## 7. Metrik Keberhasilan (Rubrik Penilaian)
Evaluasi sistem dan proyek secara keseluruhan akan berpedoman pada metrik terperinci berikut:

1.  **Fungsionalitas (Bobot 40%):** Seluruh fitur CRUD berjalan sempurna, autentikasi aman, relasi tabel akurat, dan data tersimpan dengan benar di database [cite: 1].
2.  **Kualitas Kode (Bobot 20%):** Struktur MVC diterapkan konsisten, ada validasi input, implementasi Eloquent ORM, serta standar keamanan terpenuhi [cite: 1].
3.  **Tampilan & UX (Bobot 15%):** Desain mobile-first responsive, konsisten, informatif, dan alur navigasi jelas [cite: 1].
4.  **API & Keamanan (Bobot 10%):** Endpoint JSON berfungsi dengan baik, dilindungi token Sanctum, format respons terstruktur [cite: 1].
5.  **Hosting & Dokumentasi (Bobot 10%):** Aplikasi live (bisa diakses), repository GitHub tersedia, laporan lengkap sesuai struktur, dan terdapat ERD [cite: 1].
6.  **Presentasi (Bobot 5%):** Demonstrasi lancar, penguasaan materi (mampu menjawab pertanyaan), dan pembagian tugas per anggota jelas [cite: 1].

## 8. Jadwal & Pengiriman (Deliverables)
*   **Batas Waktu Presentasi:** Senin, 27 Juli 2026 [cite: 1].
*   **Format Pengumpulan:** Laporan dikumpulkan dalam format PDF [cite: 1].
*   **Portal Pengumpulan:** Setiap mahasiswa **WAJIB** mengunggah dokumen secara individual melalui tautan: `https://bit.ly/4gKHyJY` [cite: 1].

---
*Dokumen ini disusun untuk memberikan panduan menyeluruh, terarah, dan persuasif agar tim pengembang dapat berkolaborasi secara optimal, inovatif, dan mencapai hasil Tugas Akhir yang maksimal.*
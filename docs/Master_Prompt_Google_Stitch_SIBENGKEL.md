# Master Prompt — Google Stitch untuk SIBENGKEL

Disusun dari `PRD_Sistem_Informasi_Bengkel.md`. Karena Stitch menghasilkan output terbaik saat dipandu bertahap (bukan satu prompt raksasa untuk semua layar sekaligus), dokumen ini dibagi jadi dua lapis:

1. **Prompt Fondasi (DESIGN.md style)** — tempel ini duluan untuk mengunci gaya visual, palet warna, tipografi, dan komponen bersama. Ini yang membuat semua layar berikutnya konsisten (nav bar, badge, tombol nggak "reinvent" tiap layar baru).
2. **Prompt Per-Layar** — tempel satu per satu setelah fondasi ter-generate, secara berurutan sesuai alur user flow di PRD.

Mode yang disarankan: mulai di **Ideate/3 Flash** untuk fondasi + dashboard (paling butuh eksplorasi), pindah ke **Thinking mode** untuk layar-layar final yang detailnya presisi (form, invoice). Pilih **Web**, bukan mobile-only, tapi tetap tulis "mobile-first" di setiap prompt karena PRD menuntut breakpoint 375px/768px/1024px.

---

## 1. PROMPT FONDASI (tempel pertama)

```
Rancang design system dan halaman pertama untuk "SIBENGKEL" — Sistem Informasi Bengkel Terpadu, sebuah web app manajemen bengkel otomotif (Laravel + MySQL di backend, tapi ini murni untuk desain UI web).

KONTEKS PRODUK
Platform ini menggantikan pencatatan manual/kertas di bengkel motor & mobil. Penggunanya dua peran: Admin Bengkel (pemilik/pengelola, akses penuh) dan Mekanik (teknisi lapangan, akses terbatas, sering pakai HP di area kerja yang kotor/berminyak sambil berdiri). Tidak ada portal pelanggan.

PERSONALITY & MOOD
Modern, teknikal, terpercaya — bukan playful. Pikirkan campuran antara dashboard SaaS modern (bersih, whitespace cukup, data-dense tapi tidak sesak) dengan sentuhan industrial/otomotif (aksen warna oli/logam, ikon kunci pas/gear, tipografi tegas). Hindari kesan "toko online" yang lembut dan pastel — ini alat kerja, bukan e-commerce.

DESIGN TOKENS (kunci ini untuk semua layar berikutnya)
- Warna dasar: latar netral abu-abu sangat terang (#F7F8FA) untuk light mode, dengan opsi dark mode abu-gelap kebiruan (#12151C) — mekanik sering kerja di ruang dengan pencahayaan buruk.
- Warna primer/brand: biru-dongker industrial (semacam #1E3A5F sampai #274C77) untuk header, sidebar, tombol utama — kesan bengkel resmi & profesional.
- Warna aksen sekunder: oranye bengkel/oli (#F2994A atau sejenis) untuk call-to-action penting (tombol "Tambah", floating action button).
- Warna status transaksi (WAJIB konsisten di semua tempat): 
  - pending = badge kuning/amber
  - proses = badge biru
  - selesai = badge hijau
- Tipografi: sans-serif modern yang tegas untuk heading (contoh gaya Inter/Sora), body text tetap sans-serif standar yang sangat mudah dibaca di layar kecil dengan jari berminyak — ukuran tap target besar (minimum 44px tinggi tombol).
- Card & tabel: sudut membulat sedang (8-12px radius), shadow tipis, garis pembatas jelas antar baris data.
- Ikon: gunakan gaya outline/line-icon konsisten (kunci pas, mobil/motor, kalender, user, dokumen invoice).

LAYOUT STRUKTUR UMUM (desktop ≥1024px)
- Sidebar kiri collapsible berisi navigasi: Dashboard, Pelanggan, Kendaraan, Mekanik, Transaksi Servis, Logout. Sidebar untuk Mekanik hanya menampilkan Dashboard & Transaksi Servis (role-based, item lain disembunyikan).
- Topbar berisi judul halaman, search bar global, avatar user + role badge (Admin/Mekanik).
- Area konten utama: statistik ringkas di atas (card KPI), lalu tabel/daftar data di bawah.

LAYOUT MOBILE (<768px, WAJIB tanpa horizontal scroll)
- Sidebar berubah jadi hamburger menu slide-in dari kiri.
- Semua tabel data berubah jadi tampilan card per-baris (bukan tabel horizontal).
- Tombol aksi utama ("Tambah Data", "Buat Transaksi") jadi Floating Action Button (FAB) bulat oranye di kanan bawah.
- Bottom padding cukup agar FAB tidak menutupi konten terakhir.

Untuk prompt ini, generate dulu: (1) halaman Login, dan (2) satu contoh KPI card component + satu contoh status badge (pending/proses/selesai) sebagai referensi visual komponen, dalam mode desktop dan mobile berdampingan.
```

---

## 2. PROMPT PER-LAYAR (tempel satu-satu, berurutan)

### 2.1. Halaman Login
```
Lanjutkan design system yang sama. Buat halaman Login SIBENGKEL: form email + password dengan validasi inline error, checkbox "Remember Me", tombol Login warna primer full-width. Tambahkan panel kiri (desktop) berisi ilustrasi/branding bengkel modern dan tagline singkat tentang digitalisasi bengkel. Di mobile, panel ilustrasi disembunyikan, form login full-screen dengan logo di atas.
```

### 2.2. Dashboard Admin
```
Buat halaman Dashboard untuk role Admin. Bagian atas: 4 KPI card dalam grid (Total Pelanggan, Total Kendaraan Terdaftar, Servis Aktif Hari Ini, Total Pendapatan Bulan Ini) masing-masing dengan angka besar, label, dan ikon kecil. Di bawahnya: grafik ringkas tren pendapatan (line/bar chart sederhana) berdampingan dengan tabel "Transaksi Servis Terkini" — kolom: No. Polisi, Pelanggan, Mekanik, Status (pakai badge warna pending/proses/selesai), Biaya. Tabel dibatasi 5-6 baris terbaru dengan link "Lihat Semua". Versi mobile: KPI card jadi carousel/scroll horizontal 2 kolom, grafik disederhanakan, tabel jadi list card.
```

### 2.3. Dashboard Mekanik
```
Buat versi Dashboard yang lebih ringkas untuk role Mekanik (mobile-first, karena mekanik akses dari HP di area kerja). Fokus ke: daftar "Tugas Servis Hari Ini" dalam bentuk card besar dan mudah disentuh — tiap card menampilkan foto/ikon kendaraan, plat nomor, nama pelanggan, keluhan singkat, status saat ini (badge), dan tombol besar untuk update status cepat (pending → proses → selesai) langsung dari card tanpa masuk halaman lain. Tidak ada sidebar penuh, cukup bottom navigation bar sederhana (Dashboard, Transaksi, Profil).
```

### 2.4. Manajemen Pelanggan (List + Form)
```
Buat halaman daftar Pelanggan (role Admin): tabel dengan kolom Nama, No. Telepon, Alamat, Jumlah Kendaraan, dan tombol aksi Edit/Hapus per baris. Ada search bar dan pagination di bawah tabel. Tombol "Tambah Pelanggan" di kanan atas (desktop) / FAB oranye (mobile). Lalu buat juga modal/halaman form Tambah/Edit Pelanggan: input Nama, No. Telepon, Alamat, dengan validasi inline error merah di bawah field yang salah. Versi mobile: tabel jadi card list, tiap card menampilkan nama besar + telepon + jumlah kendaraan, tap untuk expand aksi.
```

### 2.5. Manajemen Kendaraan (List + Form)
```
Buat halaman daftar Kendaraan: tabel dengan kolom Plat Nomor, Merk & Model, Tahun, Nama Pemilik (pelanggan terkait), tombol Edit/Hapus. Tambahkan filter dropdown untuk Merk dan search box untuk plat nomor. Buat form Tambah/Edit Kendaraan dengan dropdown pencarian dinamis (searchable select) untuk memilih Pelanggan pemilik, input Plat Nomor, Merk, Model, Tahun. Mobile: card list dengan plat nomor sebagai judul card yang menonjol.
```

### 2.6. Manajemen Mekanik (List + Form)
```
Buat halaman daftar Mekanik: card grid (bukan tabel) menampilkan foto/avatar mekanik, nama, spesialisasi/keahlian teknis, status aktif/nonaktif (badge hijau/abu-abu). Tombol Tambah Mekanik di atas. Form Tambah/Edit Mekanik: input Nama, No. Telepon, Spesialisasi (bisa multi-select tags seperti "Mesin", "Kelistrikan", "Body Repair"), status aktif toggle.
```

### 2.7. Transaksi Servis — Daftar & Filter
```
Buat halaman daftar Transaksi Servis: tabel dengan kolom Tanggal, Plat Nomor, Pelanggan, Mekanik, Jenis (servis/penjualan), Biaya, Status (badge pending/proses/selesai berwarna kuning/biru/hijau sesuai design token). Sediakan filter bar di atas tabel: date range picker, dropdown status, search plat nomor. Tombol "Buat Transaksi Baru" mengambang di kanan atas / FAB di mobile. Setiap baris ada quick-action dropdown untuk update status cepat tanpa buka halaman baru.
```

### 2.8. Form Transaksi Servis Baru
```
Buat form Input Transaksi Servis Baru: dropdown pencarian dinamis untuk pilih Kendaraan (tampilkan plat nomor + nama pemilik saat dicari), dropdown pilih Mekanik penanggung jawab, textarea untuk Keluhan/Deskripsi Perbaikan, input angka untuk Estimasi Biaya (format Rupiah), date picker Tanggal Transaksi, dan radio button untuk Jenis (Servis/Penjualan). Validasi inline jelas di tiap field.
```

### 2.9. Halaman Invoice / Cetak Nota
```
Buat halaman Invoice/Nota Servis dalam tampilan print-friendly: header logo bengkel + info bengkel (nama, alamat, telepon), info pelanggan & kendaraan, tabel rincian item servis/sparepart dengan kolom Deskripsi dan Biaya, total biaya di bawah dengan penekanan visual (bold, ukuran lebih besar), area tanda tangan mekanik & pelanggan. Desain harus tetap rapi jika dicetak di kertas A4/thermal printer — hindari warna latar gelap yang boros tinta, gunakan garis tegas sebagai pengganti shadow.
```

---

## 3. Pemetaan Routes → Layar Desain

Ini daftar seluruh Web Route (`routes/web.php`) dari PRD bagian 8.3, dikelompokkan per modul dan dipetakan ke layar mana di atas yang menanganinya. Gunakan ini sebagai checklist supaya tidak ada satu route pun yang lolos tanpa desain.

| Route | Method | Halaman/Komponen UI | Ditangani di Prompt |
| :--- | :--- | :--- | :--- |
| `/login` | GET/POST | Form Login | 2.1 Halaman Login |
| `/logout` | POST | Aksi logout (tanpa halaman baru) | — (aksi dari topbar/avatar menu) |
| `/dashboard` | GET | Dashboard (beda tampilan per role) | 2.2 Dashboard Admin & 2.3 Dashboard Mekanik |
| `/customers` | GET | Tabel/daftar Pelanggan | 2.4 Manajemen Pelanggan |
| `/customers/create` | GET | Form Tambah Pelanggan | 2.4 Manajemen Pelanggan |
| `/customers/{id}/edit` | GET | Form Edit Pelanggan (sama dengan form create) | 2.4 Manajemen Pelanggan |
| `/customers` (POST), `/customers/{id}` (PUT/DELETE) | — | Aksi backend, tidak perlu layar desain terpisah | — |
| `/vehicles` | GET | Tabel/daftar Kendaraan | 2.5 Manajemen Kendaraan |
| `/vehicles/create` | GET | Form Tambah Kendaraan | 2.5 Manajemen Kendaraan |
| `/vehicles/{id}/edit` | GET | Form Edit Kendaraan | 2.5 Manajemen Kendaraan |
| `/vehicles` (POST), `/vehicles/{id}` (PUT/DELETE) | — | Aksi backend | — |
| `/mechanics` | GET | Daftar/grid Mekanik | 2.6 Manajemen Mekanik |
| `/mechanics/create` | GET | Form Tambah Mekanik | 2.6 Manajemen Mekanik |
| `/mechanics/{id}/edit` | GET | Form Edit Mekanik | 2.6 Manajemen Mekanik |
| `/mechanics` (POST), `/mechanics/{id}` (PUT/DELETE) | — | Aksi backend | — |
| `/transactions` | GET | Tabel/daftar Transaksi Servis + filter | 2.7 Transaksi Servis — Daftar & Filter |
| `/transactions/create` | GET | Form Input Transaksi Baru | 2.8 Form Transaksi Servis Baru |
| `/transactions/{id}/edit` | GET | Form Edit Transaksi (sama dengan form create) | 2.8 Form Transaksi Servis Baru |
| `/transactions/{id}/status` | PATCH | Quick-action update status (dropdown/tombol inline, bukan halaman terpisah) | Ditambahkan sebagai komponen inline di 2.7 |
| `/transactions/{id}/invoice` | GET | Halaman Cetak Nota/Invoice (print view) | 2.9 Halaman Invoice / Cetak Nota |
| `/transactions` (POST), `/transactions/{id}` (PUT/DELETE) | — | Aksi backend | — |

**Total halaman/layar unik yang perlu benar-benar didesain di Stitch: 10** — Login, Dashboard Admin, Dashboard Mekanik, Daftar Pelanggan, Form Pelanggan, Daftar Kendaraan, Form Kendaraan, Daftar/Grid Mekanik, Form Mekanik, Daftar Transaksi, Form Transaksi, Invoice. (Form create & edit tiap modul memakai layout yang sama persis, cukup satu desain untuk keduanya — hanya beda judul "Tambah" vs "Edit" dan field yang sudah terisi.)

**Route yang TIDAK butuh layar baru** (murni method POST/PUT/DELETE/PATCH untuk submit atau redirect, tidak dirender sebagai halaman): `/customers` (POST), `/customers/{id}` (PUT/DELETE), `/vehicles` (POST), `/vehicles/{id}` (PUT/DELETE), `/mechanics` (POST), `/mechanics/{id}` (PUT/DELETE), `/transactions` (POST), `/transactions/{id}` (PUT/DELETE), `/logout` (POST), `/transactions/{id}/status` (PATCH — cukup jadi state perubahan badge di halaman yang sudah ada).

---

## 4. Tips Eksekusi di Stitch

- **Urutan penting**: jalankan Prompt Fondasi dulu → biarkan Stitch generate Login + komponen referensi → baru lanjut ke prompt per-layar satu-satu. Ini bikin sidebar, badge status, dan tombol konsisten di semua layar (masalah klasik kalau langsung minta banyak layar sekaligus).
- **Kalau ada layar yang komponennya melenceng** (misalnya warna badge beda), gunakan **Direct Edit** di layar itu saja — jangan regenerate ulang seluruh set, supaya konsistensi yang sudah didapat nggak hilang.
- **Simpan sebagai DESIGN.md**: setelah fondasi ter-generate dan kamu puas, minta Stitch (atau catat manual) ringkasan token warna/tipografi final sebagai referensi buat prompt-prompt susulan atau anggota tim lain yang juga pakai Stitch.
- **Role-based UI**: karena Admin dan Mekanik punya akses beda (lihat matriks RBAC di PRD bagian 5), selalu sebutkan role di setiap prompt layar supaya Stitch nggak menampilkan menu yang seharusnya disembunyikan untuk Mekanik.
- Setelah desain final, **export HTML/Tailwind CSS** dari Stitch — ini langsung align dengan tech stack di PRD (Blade + Tailwind CSS mobile-first), tinggal alih bahasa dari HTML statis ke Blade template oleh Anggota 2 (Frontend Lead).

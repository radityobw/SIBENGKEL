# PRD Suplementer — Customer Portal & Landing Page
# SIBENGKEL Fase 2 (Bonus / Nilai Tambah)

| Atribut Dokumen | Keterangan |
| :--- | :--- |
| **Status** | **✅ SELESAI DIIMPLEMENTASIKAN** |
| **Versi** | v2.0 — diperbarui 23 Juli 2026 |
| **Posisi terhadap PRD Utama** | Suplemen — seluruh Tier 1-4 telah selesai dibangun dan berjalan |
| **Relasi ke Dokumen Tugas Resmi** | Bagian 19 PRD utama menandai "Portal Booking Servis Online" sebagai *Future Enhancement* — seluruhnya telah diwujudkan sebagai nilai tambah |
| **Dampak ke Rubrik Penilaian** | Memperkuat **"Tampilan & UX" (15%)** dan **"Presentasi" (5%)** — dapat didemokan secara penuh dan mulus |

> [!NOTE]
> Dokumen ini telah diperbarui dari spesifikasi rencana (v1.0) menjadi dokumentasi **kondisi aktual implementasi** (v2.0). Semua fitur yang tercantum di sini sudah berjalan di lingkungan development dan telah diverifikasi melalui automated test.

---

## 1. Status Implementasi Per Tier

| Tier | Fitur | Status |
| :--- | :--- | :---: |
| **1** | Landing Page publik | ✅ Selesai |
| **2** | Cek Status Servis (tanpa login, lookup by plat nomor/no HP) | ✅ Selesai |
| **3** | Booking Servis Online + Auth Pelanggan | ✅ Selesai |
| **4** | Katalog & Beli Sparepart | ✅ Selesai |

---

## 2. Prinsip Desain: Non-Invasif ke Skema Inti

Seluruh fitur bonus bersifat **tambahan murni (additive)** — tidak mengubah struktur kolom yang sudah ada di PRD utama. Sistem inti (Users, Customers, Vehicles, Transactions) tetap valid dan berjalan independen dari modul portal.

---

## 3. Skema Database — Implementasi Aktual

### 3.1. Perubahan pada Tabel `customers` (Sudah Dimigrasikan)

Semua kolom baru bersifat `nullable` agar tidak merusak data existing:

| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `password` | varchar nullable | Diisi hanya jika pelanggan mendaftar sendiri lewat portal |
| `email` | varchar unique nullable | Opsional — identifier login alternatif selain nomor HP |
| `profile_photo` | varchar nullable | Path foto profil pelanggan |
| `cart_data` | json nullable | Keranjang belanja persisten (disimpan di DB) |

### 3.2. Tabel `bookings` (Tier 3) — ✅ Aktif

| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint PK | — |
| `customer_id` | bigint FK → `customers.id` | Pemesan |
| `vehicle_id` | bigint FK → `vehicles.id` | Kendaraan yang mau diservis |
| `preferred_date` | date | Tanggal yang diinginkan pelanggan |
| `preferred_time` | time | Jam yang diinginkan |
| `complaint` | text | Keluhan awal dari pelanggan |
| `status` | enum(`menunggu_konfirmasi`,`disetujui`,`ditolak`,`dikonversi`) | Status booking |
| `transaction_id` | bigint FK nullable → `transactions.id` | Diisi saat admin approve & konversi |
| `created_at`, `updated_at` | timestamp | — |

> **Alur penting**: Booking BUKAN transaksi. Saat admin approve, sistem membuat row baru di `transactions` dan mengisi `bookings.transaction_id`. Tabel `transactions` inti tetap murni berisi data yang divalidasi admin.

### 3.3. Tabel `spare_parts` (Tier 4) — ✅ Aktif

| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint PK | — |
| `name` | varchar | Nama sparepart |
| `category` | varchar | Kategori (Mesin, Kelistrikan, Ban, dll) |
| `price` | decimal(12,2) | Harga jual |
| `stock` | int | Stok tersedia |
| `description` | text nullable | Deskripsi produk |
| `image_path` | varchar nullable | Path gambar produk |
| `created_at`, `updated_at` | timestamp | — |

### 3.4. Tabel `orders` & `order_items` (Tier 4) — ✅ Aktif

| `orders` | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint PK | — |
| `customer_id` | bigint FK → `customers.id` | Pembeli |
| `status` | enum(`menunggu_pembayaran`,`diproses`,`selesai`,`dibatalkan`) | Status pesanan (konfirmasi manual admin) |
| `total` | decimal(12,2) | Total harga |
| `created_at`, `updated_at` | timestamp | — |

| `order_items` | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint PK | — |
| `order_id` | bigint FK → `orders.id` | — |
| `spare_part_id` | bigint FK → `spare_parts.id` | — |
| `qty` | int | Jumlah dibeli |
| `price_at_purchase` | decimal(12,2) | Harga snapshot saat pembelian |

### 3.5. Tabel `testimonials` — ✅ Aktif (Tambahan dari Spec Awal)

| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint PK | — |
| `customer_id` | bigint FK nullable → `customers.id` | Jika dari pelanggan terdaftar |
| `customer_name` | varchar | Nama tampil (fallback jika bukan pelanggan terdaftar) |
| `content` | text | Isi testimoni |
| `rating` | tinyint | Nilai 1–5 bintang |
| `vehicle` | varchar nullable | Jenis kendaraan |
| `is_active` | boolean | Kontrol tampil/sembunyikan di Landing Page |
| `created_at`, `updated_at` | timestamp | — |

---

## 4. RBAC Aktual

| Modul / Fitur | Admin | Mekanik | Pelanggan (guard `customer`) | Guest |
| :--- | :---: | :---: | :---: | :---: |
| Landing Page | ✅ | ✅ | ✅ | ✅ |
| Cek Status Servis | ✅ | ✅ | ✅ | ✅ (tanpa login) |
| Katalog Sparepart (browse) | ✅ | ✅ | ✅ | ✅ |
| Registrasi/Login Pelanggan | — | — | ✅ | ✅ |
| Dashboard Portal Pelanggan | — | — | ✅ (data sendiri) | ❌ |
| Booking Servis | Lihat & approve semua | ❌ | ✅ (buat & lihat sendiri) | ❌ |
| Beli Sparepart / Checkout | Kelola semua order | ❌ | ✅ (beli & lihat sendiri) | ❌ (redirect login) |
| Edit Profil & Foto | — | — | ✅ (profil sendiri) | ❌ |
| Kelola Sparepart (CRUD) | ✅ | ❌ | ❌ | ❌ |
| Kelola Booking (approve/reject) | ✅ | ❌ | ❌ | ❌ |
| Kelola Testimoni (CRUD) | ✅ | ❌ | ❌ | ❌ |

> **Arsitektur Auth**: Multi-guard Laravel — guard `web` untuk `users` (Admin/Mekanik), guard `customer` untuk tabel `customers`. Login pelanggan mendukung **dua identifier**: nomor HP atau email, dideteksi otomatis oleh controller menggunakan `filter_var(..., FILTER_VALIDATE_EMAIL)`.

---

## 5. Routes Aktual (Sesuai `routes/web.php`)

### 5.1. Tier 1 — Landing Page (Publik)

| Method | URI | Route Name | Keterangan |
| :--- | :--- | :--- | :--- |
| GET | `/` | `public.landing` | Landing Page dinamis: hero, layanan, features, katalog sparepart, testimoni, CTA |

### 5.2. Tier 2 — Cek Status Servis (Publik, Tanpa Login)

| Method | URI | Route Name | Keterangan |
| :--- | :--- | :--- | :--- |
| GET | `/cek-status` | `public.status.index` | Form input (No. Polisi atau No. HP) |
| GET | `/cek-status/cari` | `public.status.search` | Proses lookup via query param |
| GET | `/cek-status/hasil/{id}` | `public.status.result` | Tampilkan detail status transaksi |

> **Implementasi**: Pencarian menggunakan GET agar URL hasil bisa dibagikan/di-bookmark dari HP pelanggan.

### 5.3. Tier 3 — Auth Pelanggan

| Method | URI | Route Name | Keterangan |
| :--- | :--- | :--- | :--- |
| GET | `/masuk` | `public.login` | Form login pelanggan |
| POST | `/masuk` | `public.login.submit` | Proses login (HP atau email, auto-detect) |
| GET | `/daftar` | `public.register` | Form registrasi akun baru |
| POST | `/daftar` | `public.register.submit` | Proses registrasi |
| POST | `/keluar` | `public.logout` | Logout pelanggan |
| GET | `/lupa-password` | `public.forgot_password` | Form lupa password |
| POST | `/lupa-password/send-otp` | `public.forgot_password.send_otp` | Kirim OTP reset password |
| GET | `/lupa-password/verifikasi` | `public.forgot_password.verify` | Form verifikasi OTP |
| POST | `/lupa-password/reset` | `public.forgot_password.reset` | Reset password dengan OTP |

### 5.4. Tier 3 — Portal Pelanggan (Auth Required: guard `customer`)

| Method | URI | Route Name | Keterangan |
| :--- | :--- | :--- | :--- |
| GET | `/portal` | `public.dashboard` | Dashboard: ringkasan kendaraan, booking aktif, riwayat servis |
| GET | `/profil` | `public.profile` | Form edit profil & foto |
| PUT | `/profil` | `public.profile.update` | Simpan perubahan profil |
| GET | `/booking` | `public.booking.form` | Form booking servis baru |
| POST | `/booking` | `public.booking.submit` | Submit booking |

### 5.5. Tier 4 — Katalog & Sparepart

| Method | URI | Route Name | Keterangan |
| :--- | :--- | :--- | :--- |
| GET | `/sparepart` | `public.sparepart.index` | Katalog produk (publik, tanpa login) |
| GET | `/cart` | `public.cart` | Lihat keranjang (butuh login) |
| POST | `/cart/add` | `public.cart.add` | Tambah item ke keranjang |
| DELETE | `/cart/{id}` | `public.cart.remove` | Hapus item dari keranjang |
| GET | `/checkout` | `public.checkout` | Halaman konfirmasi checkout |
| POST | `/checkout` | `public.checkout.process` | Buat order |
| GET | `/pesanan` | `public.orders.index` | Riwayat pembelian pelanggan |
| GET | `/pesanan/{order}` | `public.orders.show` | Detail satu order |

### 5.6. Halaman Statis (Publik)

| Method | URI | Route Name | Keterangan |
| :--- | :--- | :--- | :--- |
| GET | `/p/{slug}` | `public.page` | Halaman dinamis (Privacy Policy, Terms, Contact, Support) |

---

## 6. Fitur Tambahan (Melampaui Spec Awal v1.0)

| Fitur | Keterangan |
| :--- | :--- |
| **Login Hybrid (HP/Email)** | Controller mendeteksi otomatis apakah input adalah email atau nomor HP |
| **Reset Password via OTP** | Alur lupa password menggunakan OTP berbasis waktu |
| **Upload Foto Profil Pelanggan** | Pelanggan bisa upload foto profil, disimpan di `storage/app/public` |
| **Testimoni Dinamis di Landing Page** | Data testimoni dari DB (`testimonials`), bukan hard-coded. Dikelola Admin. |
| **Keranjang Persisten di DB** | `cart_data` disimpan di kolom JSON `customers`, tidak hilang saat session expired |
| **Landing Page Fully Dinamis** | Statistik, sparepart, testimoni diambil live dari DB via `LandingController` |
| **Multi-auth Guard** | Guard `customer` sepenuhnya terpisah dari guard `web` staff |
| **Admin: Kelola Testimoni** | Halaman admin untuk CRUD data testimoni pelanggan |
| **Admin: Kelola Booking** | Halaman admin untuk approve/reject/konversi booking ke transaksi resmi |
| **ScrollSpy Navbar** | Navbar publik otomatis menyorot menu aktif sesuai section yang sedang di-scroll |

---

## 7. Desain & Branding

- **Warna Primer**: Industrial Navy `#022448` — sidebar, navbar, elemen utama
- **Warna Sekunder**: Workshop Orange `#FF6B00` — tombol CTA, badge state aktif, gradient teks header
- **Hover Orange Terang**: `#FF8F42` — efek hover pada tombol sekunder
- **Tipografi**: Sora (heading / display), Inter (body / label)
- **Logo**: `public/logobengkel.png` digunakan di semua halaman (navbar, footer, auth screen) — teks "SIBENGKEL" selalu disertakan karena logo hanya berupa visual mark
- **UI Pattern**: Glassmorphism ringan, gradasi teks oranye pada semua section header landing page, animasi `split-char` karakter pada hero heading

---

## 8. Prompt Google Stitch — Referensi Desain Landing Page & Portal Pelanggan

Melanjutkan design system dari master prompt (warna biru-dongker industrial `#022448` + aksen oranye `#FF6B00`, badge status pending/proses/selesai). Prompt di bawah disusun per tier sebagai referensi jika perlu regenerasi atau iterasi ulang desain via Google Stitch.

### 8.1. Landing Page (Tier 1)
```
Lanjutkan design system yang sama (biru-dongker industrial + aksen oranye). Buat Landing Page publik SIBENGKEL: hero section dengan headline besar tentang digitalisasi servis bengkel, sub-headline singkat, dan dua tombol CTA berdampingan — "Cek Status Servis" (sekunder, outline) dan "Masuk sebagai Staff" (primer, solid) yang mengarah ke halaman login staff terpisah. Di bawah hero: section "Layanan Kami" dengan 3-4 card ikon (Servis Rutin, Ganti Sparepart, Booking Online, Riwayat Terlacak). Section berikutnya: showcase singkat "Kenapa SIBENGKEL" dengan poin transparansi biaya & tracking real-time. Footer sederhana dengan info kontak bengkel. Mobile: hero dan CTA stack vertikal, section layanan jadi scroll horizontal card.
```

### 8.2. Cek Status Servis Publik (Tier 2)
```
Lanjutkan design system yang sama. Buat halaman "Cek Status Servis" yang bisa diakses tanpa login: form sederhana satu kolom input (toggle antara No. Polisi atau No. Telepon) dengan tombol besar "Cek Status". Setelah submit, tampilkan halaman hasil: card besar berisi info kendaraan (plat nomor, merk/model), status terkini dengan badge besar dan jelas (pending/proses/selesai sesuai warna token yang sudah ditentukan), nama mekanik penanggung jawab, dan estimasi biaya jika ada. Jika data tidak ditemukan, tampilkan empty state yang ramah dengan saran menghubungi bengkel langsung. Mobile-first, karena pelanggan kemungkinan besar akses dari HP saat menunggu.
```

### 8.3. Portal Pelanggan — Login/Register (Tier 3)
```
Lanjutkan design system yang sama. Buat halaman Login & Register khusus Pelanggan (terpisah dari login staff, gunakan aksen warna yang sedikit lebih ramah/approachable dibanding sisi admin — tetap dalam keluarga warna yang sama tapi lebih terang). Form Register: Nama, No. Telepon, Email (opsional), Password, Konfirmasi Password. Form Login: Email/No.Telepon + Password (field tunggal "login" yang auto-detect). Sertakan link silang "Sudah punya akun? Masuk di sini" dan sebaliknya.
```

### 8.4. Dashboard & Booking Pelanggan (Tier 3)
```
Lanjutkan design system yang sama. Buat Dashboard Portal Pelanggan: sapaan personal di atas, lalu grid card kendaraan terdaftar milik pelanggan, section "Booking Aktif" menampilkan status booking dengan timeline visual sederhana (Menunggu Konfirmasi → Disetujui → Sedang Dikerjakan → Selesai), dan tombol besar "Booking Servis Baru". Buat juga form Booking Servis Baru: pilih kendaraan (dropdown dari kendaraan miliknya), date picker tanggal diinginkan, time picker jam diinginkan, textarea keluhan. Setelah submit, tampilkan konfirmasi bahwa booking menunggu persetujuan admin. Mobile-first dengan bottom navigation (Dashboard, Booking, Sparepart, Profil).
```

### 8.5. Katalog & Checkout Sparepart (Tier 4)
```
Lanjutkan design system yang sama. Buat halaman Katalog Sparepart: grid produk dengan gambar, nama, kategori, harga, dan tombol "Tambah ke Keranjang". Ada search bar dan filter kategori (chip/tag di atas grid). Buat juga halaman Keranjang: list item dengan quantity stepper, subtotal per item, total keseluruhan di bawah, tombol "Checkout". Halaman Checkout: ringkasan pesanan, pilihan metode konfirmasi pembayaran (Transfer Manual / COD di Bengkel — tanpa payment gateway asli), tombol "Buat Pesanan". Mobile: grid produk 2 kolom, keranjang dan checkout full-screen dengan sticky total di bawah.
```

---

## 9. Yang Masih Out-of-Scope

| Fitur | Alasan |
| :--- | :--- |
| Payment Gateway (Midtrans/Xendit) | Konfirmasi manual/COD sesuai scope awal |
| Notifikasi WhatsApp/SMS otomatis | Future Enhancement |
| Real-time status update (WebSocket) | Tidak diperlukan untuk demo |
| Rating & ulasan servis dari portal pelanggan | Testimoni dikelola admin, bukan self-service dari pelanggan |

---

## 9. Cara Menyampaikan ke Dosen Penguji

> *"Di luar requirement wajib, kami menambahkan modul customer portal lengkap sebagai nilai tambah — mulai dari landing page publik yang dinamis, cek status tanpa login, hingga portal pelanggan penuh dengan booking servis online, katalog sparepart, dan sistem autentikasi hybrid yang mendukung login via nomor HP maupun email. Ini mendemonstrasikan pemahaman kami tentang desain sistem yang scalable dari sistem internal murni menjadi platform customer-facing yang siap production."*

# PRD Suplementer — Customer Portal & Landing Page
# SIBENGKEL Fase 2 (Bonus / Nilai Tambah)

| Atribut Dokumen | Keterangan |
| :--- | :--- |
| **Status** | **OPSIONAL — bukan bagian dari spesifikasi wajib tugas akhir** |
| **Posisi terhadap PRD Utama** | Suplemen, dikerjakan **hanya setelah** seluruh fitur `[Wajib]` di PRD utama (Bagian 4 & 7) selesai, teruji, dan ter-deploy |
| **Relasi ke Dokumen Tugas Resmi** | Bagian 19 PRD utama sudah menandai "Portal Booking Servis Online" sebagai *Future Enhancement* — dokumen ini adalah breakdown teknisnya jika tim memutuskan mengejarnya sebagai nilai tambah |
| **Dampak ke Rubrik Penilaian** | **Tidak menambah bobot "Fungsionalitas" 40%** (karena penguji menilai berdasarkan requirement asli), tapi berpotensi memperkuat kesan di **"Tampilan & UX" (15%)** dan **"Presentasi" (5%)** kalau didemokan dengan mulus. Jangan dikerjakan dengan mengorbankan fitur wajib. |

> [!CAUTION]
> Deadline presentasi 27 Juli 2026, dan ini disusun 21 Juli — sisa **6 hari**. Dokumen ini sengaja dipecah jadi **4 tingkat (tier)** berurutan supaya tim bisa berhenti di tingkat manapun sesuai waktu yang tersisa, tanpa meninggalkan fitur setengah jadi yang malah bikin bingung saat demo. Kalau sampai H-2 fitur wajib belum 100% solid, **lewati dokumen ini sepenuhnya.**

---

## 1. Prinsip Desain: Non-Invasif ke Skema Inti

Supaya fitur bonus ini tidak mengganggu 4 entitas inti yang sudah dinilai (Users, Customers, Vehicles, Transactions), seluruh tabel baru di dokumen ini bersifat **tambahan murni (additive)** — tidak mengubah struktur kolom yang sudah ada di PRD utama, kecuali satu penambahan kolom nullable di `customers` (dijelaskan di Bagian 3).

Kalau tim kehabisan waktu di tengah jalan, sistem inti tetap berjalan normal karena tidak ada dependency terbalik dari tabel inti ke tabel bonus.

---

## 2. Empat Tingkat Prioritas (Kerjakan Berurutan, Berhenti Kapan Saja)

| Tier | Fitur | Effort | Butuh Auth Pelanggan? | Ketergantungan |
| :--- | :--- | :--- | :--- | :--- |
| **1** | Landing Page publik | Rendah (murni statis + link ke `/login`) | Tidak | Tidak ada |
| **2** | Cek Status Servis (tanpa login, lookup by plat nomor/no HP) | Rendah–Menengah | **Tidak** (sengaja dihindari untuk hemat waktu) | Tabel `transactions` yang sudah ada |
| **3** | Booking Servis Online | Menengah–Tinggi | Ya (guard `customer`) | Tabel baru `bookings` |
| **4** | Katalog & Beli Sparepart | Tinggi | Ya (guard `customer`) | Tabel baru `spare_parts`, `orders`, `order_items` |

**Rekomendasi kuat**: kalau cuma sanggup 1 tier, ambil **Tier 1 + Tier 2**. Kombinasi ini paling murah dieksekusi tapi paling terlihat impactful saat demo — dosen bisa lihat halaman depan yang profesional lalu langsung dicek "coba masukin plat nomor ini, lihat statusnya real-time" tanpa tim perlu membangun sistem auth pelanggan yang penuh risiko bug di menit-menit akhir.

Tier 3 dan 4 baru dikejar kalau Tier 1–2 sudah solid dan masih ada sisa waktu signifikan (idealnya H-3 atau lebih awal).

---

## 3. Perubahan & Tabel Baru pada Skema Database

### 3.1. Perubahan Minor pada Tabel Existing
```
ALTER TABLE customers ADD COLUMN password VARCHAR(255) NULL;
```
Kolom ini **nullable** — pelanggan yang datanya diinput manual oleh admin (alur inti PRD utama) tetap valid tanpa password. Kolom hanya terisi kalau pelanggan mendaftar sendiri lewat portal (Tier 3+). Ini menghindari migration yang merusak data existing.

### 3.2. Tabel Baru: `bookings` (Tier 3)
| Kolom | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint PK | — |
| `customer_id` | bigint FK → `customers.id` | Pemesan |
| `vehicle_id` | bigint FK → `vehicles.id` | Kendaraan yang mau diservis |
| `preferred_date` | date | Tanggal yang diinginkan pelanggan |
| `preferred_time` | time | Jam yang diinginkan |
| `complaint` | text | Keluhan awal dari pelanggan |
| `status` | enum(`menunggu_konfirmasi`,`disetujui`,`ditolak`,`dikonversi`) | Status booking, **terpisah** dari status transaksi inti |
| `transaction_id` | bigint FK nullable → `transactions.id` | Diisi otomatis saat admin approve & konversi jadi transaksi resmi |
| `created_at`, `updated_at` | timestamp | — |

**Alur penting**: booking BUKAN transaksi. Begitu admin approve, sistem membuat row baru di tabel `transactions` (skema inti, tidak diubah) dan mengisi `bookings.transaction_id`. Dengan begini, tabel `transactions` inti kamu tetap murni berisi data yang sudah divalidasi admin — tidak ada risiko data booking asal-asalan pelanggan mencemari tabel yang dinilai dosen.

### 3.3. Tabel Baru: `spare_parts` (Tier 4)
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

### 3.4. Tabel Baru: `orders` & `order_items` (Tier 4)
| `orders` | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint PK | — |
| `customer_id` | bigint FK → `customers.id` | Pembeli |
| `status` | enum(`menunggu_pembayaran`,`diproses`,`selesai`,`dibatalkan`) | Status pesanan (tanpa payment gateway — cukup konfirmasi manual admin, sesuai catatan Out-of-Scope PRD utama) |
| `total` | decimal(12,2) | Total harga |
| `created_at`, `updated_at` | timestamp | — |

| `order_items` | Tipe | Keterangan |
| :--- | :--- | :--- |
| `id` | bigint PK | — |
| `order_id` | bigint FK → `orders.id` | — |
| `spare_part_id` | bigint FK → `spare_parts.id` | — |
| `qty` | int | Jumlah dibeli |
| `price_at_purchase` | decimal(12,2) | Harga saat dibeli (snapshot, bukan referensi harga live) |

---

## 4. RBAC Tambahan

| Modul / Fitur | Admin | Mekanik | **Pelanggan (baru)** | Guest (belum login) |
| :--- | :---: | :---: | :---: | :---: |
| Landing Page | Ya | Ya | Ya | **Ya** |
| Cek Status Servis (Tier 2) | Ya | Ya | Ya | **Ya (tanpa login)** |
| Registrasi/Login Pelanggan | — | — | Ya (buat akun sendiri) | **Ya** |
| Booking Servis (Tier 3) | Lihat & approve semua | ❌ | **Buat & lihat booking sendiri** | ❌ |
| Kelola Sparepart (Tier 4) | Full CRUD | ❌ | ❌ | ❌ |
| Katalog & Beli Sparepart (Tier 4) | Lihat semua order | ❌ | **Browse & beli, lihat order sendiri** | Browse katalog saja (checkout wajib login) |

> Catatan arsitektur: karena `customers` sekarang bisa login (Tier 3+), gunakan **multi-guard authentication** Laravel — guard `web` tetap untuk `users` (Admin/Mekanik, tidak berubah), guard baru `customer` untuk tabel `customers`. Ini pola standar Laravel, tidak perlu ubah struktur auth inti yang sudah ada.

---

## 5. Routes Lengkap

### 5.1. Tier 1 — Landing Page (Publik)
| Route | Method | Halaman |
| :--- | :--- | :--- |
| `/` | GET | Landing Page — hero section, value proposition, showcase layanan, testimoni (dummy/opsional), CTA ke `/login` (staff) & `/cek-status` |

### 5.2. Tier 2 — Cek Status Servis (Publik, Tanpa Login)
| Route | Method | Halaman |
| :--- | :--- | :--- |
| `/cek-status` | GET | Form input No. Polisi / No. Telepon pelanggan |
| `/cek-status` | POST | Proses lookup, redirect ke hasil |
| `/cek-status/hasil` | GET | Tampilkan status transaksi terkini kendaraan tsb (read-only, tanpa data sensitif pelanggan lain) |

### 5.3. Tier 3 — Portal Pelanggan: Auth & Booking
| Route | Method | Halaman |
| :--- | :--- | :--- |
| `/portal/register` | GET/POST | Form daftar akun pelanggan baru |
| `/portal/login` | GET/POST | Form login pelanggan (guard `customer`) |
| `/portal/logout` | POST | Logout pelanggan |
| `/portal/dashboard` | GET | Ringkasan: kendaraan terdaftar, booking aktif, riwayat servis singkat |
| `/portal/vehicles` | GET | Daftar kendaraan milik pelanggan yang login |
| `/portal/vehicles/create` | GET/POST | Tambah kendaraan sendiri (opsional, atau tetap lewat admin) |
| `/portal/booking/create` | GET/POST | Form booking servis baru: pilih kendaraan, keluhan, tanggal/jam diinginkan |
| `/portal/bookings` | GET | Riwayat & status seluruh booking milik pelanggan |
| `/portal/bookings/{id}` | GET | Detail satu booking + status transaksi jika sudah dikonversi |

### 5.4. Tier 3 — Sisi Admin untuk Kelola Booking
| Route | Method | Halaman |
| :--- | :--- | :--- |
| `/admin/bookings` | GET | Daftar booking masuk dari semua pelanggan, filter status |
| `/admin/bookings/{id}/approve` | PATCH | Approve booking → auto-generate row `transactions` + assign mekanik |
| `/admin/bookings/{id}/reject` | PATCH | Tolak booking dengan alasan |

### 5.5. Tier 4 — Katalog & Order Sparepart (Pelanggan)
| Route | Method | Halaman |
| :--- | :--- | :--- |
| `/portal/sparepart` | GET | Katalog produk — grid, search, filter kategori |
| `/portal/sparepart/{id}` | GET | Detail produk |
| `/portal/cart` | GET | Lihat keranjang |
| `/portal/cart/add` | POST | Tambah item ke keranjang |
| `/portal/cart/{id}` | DELETE | Hapus item dari keranjang |
| `/portal/checkout` | GET/POST | Konfirmasi & buat order (tanpa payment gateway — status awal `menunggu_pembayaran`, konfirmasi manual oleh admin, misal transfer manual/COD di lokasi) |
| `/portal/orders` | GET | Riwayat pembelian pelanggan |
| `/portal/orders/{id}` | GET | Detail satu order |

### 5.6. Tier 4 — Sisi Admin untuk Kelola Sparepart & Order
| Route | Method | Halaman |
| :--- | :--- | :--- |
| `/admin/spareparts` | GET | Daftar sparepart + stok |
| `/admin/spareparts/create` | GET/POST | Tambah produk baru |
| `/admin/spareparts/{id}/edit` | GET/PUT | Edit produk & stok |
| `/admin/orders` | GET | Kelola pesanan masuk, update status (`diproses`/`selesai`/`dibatalkan`) |

---

## 6. Prompt Google Stitch — Tambahan untuk Landing Page & Portal Pelanggan

Melanjutkan design system dari master prompt sebelumnya (warna biru-dongker industrial + aksen oranye, badge status pending/proses/selesai). Tempel prompt berikut **setelah** fondasi & layar-layar inti selesai, urut sesuai tier yang dikejar.

### 6.1. Landing Page (Tier 1)
```
Lanjutkan design system yang sama (biru-dongker industrial + aksen oranye). Buat Landing Page publik SIBENGKEL: hero section dengan headline besar tentang digitalisasi servis bengkel, sub-headline singkat, dan dua tombol CTA berdampingan — "Cek Status Servis" (sekunder, outline) dan "Masuk sebagai Staff" (primer, solid) yang mengarah ke halaman login staff terpisah. Di bawah hero: section "Layanan Kami" dengan 3-4 card ikon (Servis Rutin, Ganti Sparepart, Booking Online, Riwayat Terlacak). Section berikutnya: showcase singkat "Kenapa SIBENGKEL" dengan poin transparansi biaya & tracking real-time. Footer sederhana dengan info kontak bengkel. Mobile: hero dan CTA stack vertikal, section layanan jadi scroll horizontal card.
```

### 6.2. Cek Status Servis Publik (Tier 2)
```
Lanjutkan design system yang sama. Buat halaman "Cek Status Servis" yang bisa diakses tanpa login: form sederhana satu kolom input (toggle antara No. Polisi atau No. Telepon) dengan tombol besar "Cek Status". Setelah submit, tampilkan halaman hasil: card besar berisi info kendaraan (plat nomor, merk/model), status terkini dengan badge besar dan jelas (pending/proses/selesai sesuai warna token yang sudah ditentukan), nama mekanik penanggung jawab, dan estimasi biaya jika ada. Jika data tidak ditemukan, tampilkan empty state yang ramah dengan saran menghubungi bengkel langsung. Mobile-first, karena pelanggan kemungkinan besar akses dari HP saat menunggu.
```

### 6.3. Portal Pelanggan — Login/Register (Tier 3)
```
Lanjutkan design system yang sama. Buat halaman Login & Register khusus Pelanggan (terpisah dari login staff, gunakan aksen warna yang sedikit lebih ramah/approachable dibanding sisi admin — tetap dalam keluarga warna yang sama tapi lebih terang). Form Register: Nama, No. Telepon, Email, Password, Konfirmasi Password. Form Login: Email/No.Telepon + Password. Sertakan link silang "Sudah punya akun? Masuk di sini" dan sebaliknya.
```

### 6.4. Dashboard & Booking Pelanggan (Tier 3)
```
Lanjutkan design system yang sama. Buat Dashboard Portal Pelanggan: sapaan personal di atas, lalu grid card kendaraan terdaftar milik pelanggan, section "Booking Aktif" menampilkan status booking dengan timeline visual sederhana (Menunggu Konfirmasi → Disetujui → Sedang Dikerjakan → Selesai), dan tombol besar "Booking Servis Baru". Buat juga form Booking Servis Baru: pilih kendaraan (dropdown dari kendaraan miliknya), date picker tanggal diinginkan, time picker jam diinginkan, textarea keluhan. Setelah submit, tampilkan konfirmasi bahwa booking menunggu persetujuan admin. Mobile-first dengan bottom navigation (Dashboard, Booking, Sparepart, Profil).
```

### 6.5. Katalog & Checkout Sparepart (Tier 4)
```
Lanjutkan design system yang sama. Buat halaman Katalog Sparepart: grid produk dengan gambar, nama, kategori, harga, dan tombol "Tambah ke Keranjang". Ada search bar dan filter kategori (chip/tag di atas grid). Buat juga halaman Keranjang: list item dengan quantity stepper, subtotal per item, total keseluruhan di bawah, tombol "Checkout". Halaman Checkout: ringkasan pesanan, pilihan metode konfirmasi pembayaran (Transfer Manual / COD di Bengkel — tanpa payment gateway asli), tombol "Buat Pesanan". Mobile: grid produk 2 kolom, keranjang dan checkout full-screen dengan sticky total di bawah.
```

---

## 7. Yang Sengaja Dihindari (Tetap Out-of-Scope)

Untuk menjaga dokumen ini tetap realistis sebagai *bonus*, hal-hal berikut **tetap di luar cakupan** meski sudah masuk area customer-facing:
- **Payment Gateway otomatis** (Midtrans/Xendit) — tetap manual/COD sesuai Out-of-Scope PRD utama.
- **Notifikasi WhatsApp/SMS otomatis** — tetap Future Enhancement, jangan dikejar sekarang.
- **Real-time update status** (WebSocket/polling) — cukup refresh manual, jangan tambah kompleksitas infrastruktur di detik-detik akhir.
- **Rating & ulasan servis dari pelanggan** — nice-to-have tapi tidak ada di scope manapun, skip total.

---

## 8. Cara Menyampaikan Ini ke Dosen Penguji

Kalau sempat mengerjakan sebagian tier ini, framing yang tepat saat presentasi:
> *"Di luar requirement wajib, kami menambahkan modul customer portal sebagai nilai tambah — mendemonstrasikan pemahaman kami soal desain sistem yang scalable dari sistem internal murni menjadi platform yang customer-facing."*

Ini penting supaya dosen menilai fitur wajib PRD utama sebagai fokus utama, dan modul ini murni sebagai *bonus point* tanpa menciptakan ekspektasi bahwa seluruh Tier 1-4 harus sempurna.

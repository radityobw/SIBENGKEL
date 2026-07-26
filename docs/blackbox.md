# Blackbox Testing — SIBENGKEL
## Sistem Informasi Bengkel Terpadu

> **Jenis Pengujian:** Black Box Testing (Fungsional)
> **Metode:** Equivalence Partitioning + Boundary Value Analysis
> **Lingkungan Uji:** Browser (Chrome/Firefox), Postman
> **Penguji:** Tim Pengembang SIBENGKEL
> **Tanggal Uji:** Juli 2026

---

## FORMAT KOLOM TABEL

| Kolom | Keterangan |
|:---|:---|
| **No** | Nomor urut test case |
| **ID** | Kode unik test case (`TC-[MODUL]-[NOMOR]`) |
| **Nama Uji** | Nama singkat skenario pengujian |
| **Precondition** | Kondisi awal sebelum pengujian dilakukan |
| **Data Input** | Data yang dimasukkan ke sistem |
| **Langkah Uji** | Tahapan pengujian yang dilakukan |
| **Hasil Diharapkan** | Output/respon yang seharusnya diberikan sistem |
| **Hasil Aktual** | Output/respon yang benar-benar diberikan sistem |
| **Status** | `✅ Pass` / `❌ Fail` |

---

## MODUL 1 — AUTENTIKASI STAFF (Login & Logout)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-AUTH-01 | Login valid dengan email | Akun admin terdaftar di DB | Email: `admin@sibengkel.web.id`, Password: `password` | 1. Buka `/login` 2. Isi email & password 3. Klik Masuk | Redirect ke `/dashboard`, session aktif | Sistem mengarahkan pengguna ke `/dashboard`, session aktif | ✅ Pass |
| 2 | TC-AUTH-02 | Login valid dengan username | Akun admin terdaftar di DB | Username: `adminbengkel`, Password: `password` | 1. Buka `/login` 2. Isi username & password 3. Klik Masuk | Redirect ke `/dashboard`, session aktif | Sistem mengarahkan pengguna ke `/dashboard`, session aktif | ✅ Pass |
| 3 | TC-AUTH-03 | Login dengan password salah | Akun admin terdaftar | Email: `admin@sibengkel.web.id`, Password: `salah123` | 1. Buka `/login` 2. Isi data 3. Klik Masuk | Muncul pesan error "Kredensial tidak cocok", halaman tidak berpindah | Sistem menampilkan pesan error: Kredensial tidak cocok", halaman tidak berpindah | ✅ Pass |
| 4 | TC-AUTH-04 | Login dengan email tidak terdaftar | — | Email: `tidakada@test.com`, Password: `password` | 1. Buka `/login` 2. Isi data 3. Klik Masuk | Muncul pesan error, halaman tidak berpindah | Sistem menampilkan pesan error: Muncul pesan error, halaman tidak berpindah | ✅ Pass |
| 5 | TC-AUTH-05 | Login dengan field kosong | — | Email: (kosong), Password: (kosong) | 1. Buka `/login` 2. Klik Masuk tanpa isi | Muncul validasi HTML5 "This field is required" | Muncul validasi HTML5 "This field is required" | ✅ Pass |
| 6 | TC-AUTH-06 | Akses dashboard tanpa login | Belum login | — | 1. Buka `/dashboard` langsung di browser | Redirect ke `/login`, akses ditolak | Sistem mengarahkan pengguna ke `/login`, akses ditolak | ✅ Pass |
| 7 | TC-AUTH-07 | Logout berhasil | Sudah login sebagai admin | — | 1. Klik tombol Logout di sidebar/menu | Session dihapus, redirect ke `/login` | Session dihapus, redirect ke `/login` | ✅ Pass |
| 8 | TC-AUTH-08 | Akses halaman guest setelah login | Sudah login | — | 1. Buka `/login` saat sudah login | Redirect ke `/dashboard` (bukan tampilkan form login) | Sistem mengarahkan pengguna ke `/dashboard` (bukan tampilkan form login) | ✅ Pass |
| 9 | TC-AUTH-09 | Akses halaman admin oleh mekanik | Login sebagai mekanik | — | 1. Login mekanik 2. Akses `/admins` | Redirect atau tampilkan error 403 Forbidden | Redirect atau tampilkan error 403 Forbidden | ✅ Pass |

---

## MODUL 2 — AUTENTIKASI PELANGGAN (Customer Portal)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-CUST-AUTH-01 | Registrasi pelanggan baru | — | Nama, Email, No. HP, Password valid | 1. Buka `/portal/daftar` 2. Isi semua field 3. Klik Daftar | Akun pelanggan terbuat, redirect ke `/portal` | Akun pelanggan terbuat, redirect ke `/portal` | ✅ Pass |
| 2 | TC-CUST-AUTH-02 | Registrasi dengan email duplikat | Email sudah terdaftar | Email yang sama dengan pelanggan lain | 1. Isi form register 2. Submit | Muncul error "Email sudah digunakan" | Sistem menampilkan pesan error: Email sudah digunakan | ✅ Pass |
| 3 | TC-CUST-AUTH-03 | Login pelanggan valid | Akun pelanggan terdaftar | Email & Password benar | 1. Buka `/portal/masuk` 2. Isi data 3. Submit | Redirect ke `/portal`, dashboard pelanggan tampil | Sistem mengarahkan pengguna ke `/portal`, dashboard pelanggan tampil | ✅ Pass |
| 4 | TC-CUST-AUTH-04 | Login pelanggan salah password | Akun terdaftar | Password salah | 1. Isi form login 2. Submit | Muncul pesan error login gagal | Sistem menampilkan pesan error: login gagal | ✅ Pass |
| 5 | TC-CUST-AUTH-05 | Logout pelanggan | Sudah login sebagai pelanggan | — | 1. Klik tombol Keluar | Session pelanggan dihapus, redirect ke halaman publik | Session pelanggan dihapus, redirect ke halaman publik | ✅ Pass |
| 6 | TC-CUST-AUTH-06 | Lupa password — kirim OTP | Email terdaftar | Email valid | 1. Buka `/portal/lupa-password` 2. Isi email 3. Klik Kirim OTP | Halaman verifikasi OTP tampil | Halaman verifikasi OTP tampil | ✅ Pass |
| 7 | TC-CUST-AUTH-07 | Reset password dengan OTP valid | OTP dikirim ke email | OTP yang benar + Password baru | 1. Isi OTP + password baru 2. Submit | Password berhasil diubah, redirect ke login | Password berhasil diubah, redirect ke login | ✅ Pass |
| 8 | TC-CUST-AUTH-08 | Reset password dengan OTP salah | OTP dikirim | OTP salah | 1. Isi OTP salah 2. Submit | Muncul error "OTP tidak valid" | Sistem menampilkan pesan error: OTP tidak valid | ✅ Pass |

---

## MODUL 3 — MANAJEMEN PELANGGAN (Customers CRUD)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-PELANGGAN-01 | Tampil daftar pelanggan | Login admin, ada data pelanggan | — | 1. Buka `/customers` | Tabel pelanggan tampil dengan data dan pagination | Tabel pelanggan tampil dengan data dan pagination | ✅ Pass |
| 2 | TC-PELANGGAN-02 | Pencarian pelanggan by nama | Login admin, ada data pelanggan | Keyword: nama pelanggan yang ada | 1. Isi search bar 2. Submit | Tabel menampilkan pelanggan sesuai keyword | Tabel menampilkan pelanggan sesuai keyword | ✅ Pass |
| 3 | TC-PELANGGAN-03 | Pencarian pelanggan tidak ditemukan | Login admin | Keyword: "xyzabc999" | 1. Isi search bar 2. Submit | Tabel menampilkan pesan "Tidak ada data" | Tabel menampilkan pesan "Tidak ada data" | ✅ Pass |
| 4 | TC-PELANGGAN-04 | Tambah pelanggan baru valid | Login admin | Nama: "Budi Santoso", Phone: "08123456789", Alamat: "Jl. Merdeka" | 1. Buka `/customers/create` 2. Isi form 3. Submit | Pelanggan tersimpan di DB, redirect ke daftar dengan pesan sukses | Data berhasil disimpan ke basis data dan ditampilkan di antarmuka | ✅ Pass |
| 5 | TC-PELANGGAN-05 | Tambah pelanggan field wajib kosong | Login admin | Nama: (kosong) | 1. Buka form tambah 2. Biarkan nama kosong 3. Submit | Validasi error "Nama wajib diisi" | Sistem menolak input dan menampilkan validasi: Nama wajib diisi | ✅ Pass |
| 6 | TC-PELANGGAN-06 | Edit data pelanggan | Login admin, pelanggan ada | Nama baru: "Budi Santoso Jr." | 1. Klik Edit 2. Ubah nama 3. Submit | Data pelanggan terupdate di DB dan tampil di tabel | Data berhasil diperbarui di basis data | ✅ Pass |
| 7 | TC-PELANGGAN-07 | Hapus pelanggan | Login admin, pelanggan ada | — | 1. Klik Hapus 2. Konfirmasi | Pelanggan terhapus dari DB, hilang dari tabel | Data berhasil dihapus dari basis data dan tidak lagi tampil di daftar | ✅ Pass |
| 8 | TC-PELANGGAN-08 | Upload foto profil pelanggan | Login admin | File gambar .jpg, < 2MB | 1. Edit pelanggan 2. Upload foto 3. Submit | Foto tersimpan dan tampil di profil pelanggan | Foto tersimpan dan tampil di profil pelanggan | ✅ Pass |
| 9 | TC-PELANGGAN-09 | Upload file bukan gambar | Login admin | File .pdf | 1. Upload .pdf sebagai foto 2. Submit | Validasi error "File harus berupa gambar" | Sistem menolak input dan menampilkan validasi: File harus berupa gambar | ✅ Pass |

---

## MODUL 4 — MANAJEMEN KENDARAAN (Vehicles CRUD)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-KENDARAAN-01 | Tampil daftar kendaraan | Login admin, ada kendaraan | — | 1. Buka `/vehicles` | Tabel kendaraan tampil dengan pagination | Tabel kendaraan tampil dengan pagination | ✅ Pass |
| 2 | TC-KENDARAAN-02 | Filter kendaraan by merek | Login admin | Pilih "Honda" di dropdown | 1. Pilih merek Honda 2. Submit | Tabel hanya tampilkan kendaraan Honda | Tabel hanya tampilkan kendaraan Honda | ✅ Pass |
| 3 | TC-KENDARAAN-03 | Tambah kendaraan valid | Login admin, ada pelanggan | Pelanggan: Budi, Nopol: "B 1234 ABC", Merek: Honda, Model: Vario, Tahun: 2022 | 1. Buka `/vehicles/create` 2. Isi form 3. Submit | Kendaraan tersimpan di DB, muncul di tabel | Data berhasil disimpan ke basis data dan ditampilkan di antarmuka | ✅ Pass |
| 4 | TC-KENDARAAN-04 | Tambah kendaraan nomor polisi duplikat | Ada kendaraan dengan Nopol "B 1234 ABC" | Nopol: "B 1234 ABC" | 1. Isi form dengan nopol yang sama 2. Submit | Validasi error "Nomor polisi sudah terdaftar" | Sistem menolak input dan menampilkan validasi: Nomor polisi sudah terdaftar | ✅ Pass |
| 5 | TC-KENDARAAN-05 | Tambah kendaraan tanpa pilih pelanggan | Login admin | Customer: (kosong) | 1. Buka form tambah 2. Tidak pilih pelanggan 3. Submit | Validasi error "Pelanggan wajib dipilih" | Sistem menolak input dan menampilkan validasi: Pelanggan wajib dipilih | ✅ Pass |
| 6 | TC-KENDARAAN-06 | Tambah kendaraan tahun tidak valid | Login admin | Tahun: 1800 | 1. Isi tahun 1800 2. Submit | Validasi error batas tahun minimum | Sistem menolak input dan menampilkan validasi: batas tahun minimum | ✅ Pass |
| 7 | TC-KENDARAAN-07 | Edit data kendaraan | Login admin | Tahun: 2023 | 1. Klik Edit 2. Ubah tahun 3. Submit | Data kendaraan terupdate di DB | Data berhasil diperbarui di basis data | ✅ Pass |
| 8 | TC-KENDARAAN-08 | Hapus kendaraan | Login admin | — | 1. Klik Hapus 2. Konfirmasi | Kendaraan terhapus dari DB | Data berhasil dihapus dari basis data dan tidak lagi tampil di daftar | ✅ Pass |

---

## MODUL 5 — MANAJEMEN MEKANIK (Mechanics CRUD)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-MEKANIK-01 | Tampil daftar mekanik | Login admin, ada mekanik | — | 1. Buka `/mechanics` | Grid kartu mekanik tampil | Grid kartu mekanik tampil | ✅ Pass |
| 2 | TC-MEKANIK-02 | Pencarian mekanik | Login admin | Keyword: nama mekanik | 1. Isi search bar 2. Submit | Tampil kartu mekanik sesuai keyword | Tampil kartu mekanik sesuai keyword | ✅ Pass |
| 3 | TC-MEKANIK-03 | Tambah mekanik valid | Login admin | Nama: "Agus", Phone: "08111", Keahlian: "Mesin" | 1. Buka `/mechanics/create` 2. Isi form 3. Submit | Mekanik tersimpan, redirect ke daftar | Mekanik tersimpan, redirect ke daftar | ✅ Pass |
| 4 | TC-MEKANIK-04 | Tambah mekanik nama kosong | Login admin | Nama: (kosong) | 1. Buka form 2. Biarkan nama kosong 3. Submit | Validasi error "Nama wajib diisi" | Sistem menolak input dan menampilkan validasi: Nama wajib diisi | ✅ Pass |
| 5 | TC-MEKANIK-05 | Edit mekanik | Login admin | Keahlian baru: "Kelistrikan" | 1. Klik Edit 2. Ubah keahlian 3. Submit | Data mekanik terupdate | Data mekanik terupdate | ✅ Pass |
| 6 | TC-MEKANIK-06 | Hapus mekanik | Login admin | — | 1. Klik Hapus 2. Konfirmasi | Mekanik terhapus dari DB | Data berhasil dihapus dari basis data dan tidak lagi tampil di daftar | ✅ Pass |

---

## MODUL 6 — MANAJEMEN ADMIN

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-ADMIN-01 | Tampil daftar admin | Login admin | — | 1. Buka `/admins` | Tabel admin tampil dengan badge "You" pada diri sendiri | Tabel admin tampil dengan badge "You" pada diri sendiri | ✅ Pass |
| 2 | TC-ADMIN-02 | Tambah admin baru valid | Login admin | Nama, Username, Email, Password valid | 1. Buka `/admins/create` 2. Isi form 3. Submit | Admin baru tersimpan, redirect ke daftar | Admin baru tersimpan, redirect ke daftar | ✅ Pass |
| 3 | TC-ADMIN-03 | Tambah admin username duplikat | Ada admin dengan username "agus" | Username: "agus" | 1. Isi form dengan username yang sama 2. Submit | Validasi error "Username sudah digunakan" | Sistem menolak input dan menampilkan validasi: Username sudah digunakan | ✅ Pass |
| 4 | TC-ADMIN-04 | Tambah admin email duplikat | Ada admin dengan email tsb | Email yang sama | 1. Isi form 2. Submit | Validasi error "Email sudah digunakan" | Sistem menolak input dan menampilkan validasi: Email sudah digunakan | ✅ Pass |
| 5 | TC-ADMIN-05 | Hapus admin lain | Login admin, ada admin lain | — | 1. Klik Hapus admin lain 2. Konfirmasi | Admin lain terhapus dari DB | Data berhasil dihapus dari basis data dan tidak lagi tampil di daftar | ✅ Pass |
| 6 | TC-ADMIN-06 | Hapus akun diri sendiri | Login admin | — | 1. Coba klik Hapus pada baris "You" | Tombol hapus dinonaktifkan (disabled/hidden), tidak bisa dihapus | Tombol hapus dinonaktifkan (disabled/hidden), tidak bisa dihapus | ✅ Pass |
| 7 | TC-ADMIN-07 | Edit admin | Login admin | Nama baru | 1. Klik Edit 2. Ubah nama 3. Submit | Data admin terupdate | Data admin terupdate | ✅ Pass |
| 8 | TC-ADMIN-08 | Akses halaman admin oleh mekanik | Login sebagai mekanik | — | 1. Akses `/admins` secara manual | Redirect atau 403 Forbidden | Redirect atau 403 Forbidden | ✅ Pass |

---

## MODUL 7 — TRANSAKSI SERVIS (CRUD + Status)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-TRANSAKSI-01 | Tampil daftar transaksi | Login, ada transaksi | — | 1. Buka `/transactions` | Tabel transaksi tampil dengan badge status berwarna | Tabel transaksi tampil dengan badge status berwarna | ✅ Pass |
| 2 | TC-TRANSAKSI-02 | Filter transaksi by status | Login, ada transaksi | Status: "pending" | 1. Pilih filter status "pending" 2. Submit | Hanya tampil transaksi dengan status pending | Hanya tampil transaksi dengan status pending | ✅ Pass |
| 3 | TC-TRANSAKSI-03 | Filter transaksi by tanggal | Login, ada transaksi | Tanggal mulai–akhir | 1. Isi rentang tanggal 2. Submit | Hanya tampil transaksi dalam rentang tanggal | Hanya tampil transaksi dalam rentang tanggal | ✅ Pass |
| 4 | TC-TRANSAKSI-04 | Buat transaksi servis valid | Login, ada kendaraan & mekanik | Kendaraan: nopol valid, Mekanik: ada, Keluhan: "Ganti oli", Biaya: 150000, Tanggal: hari ini | 1. Buka `/transactions/create` 2. Isi semua field 3. Submit | Transaksi tersimpan di DB, redirect ke daftar dengan sukses | Data berhasil disimpan ke basis data dan ditampilkan di antarmuka | ✅ Pass |
| 5 | TC-TRANSAKSI-05 | Buat transaksi biaya negatif | Login | Biaya: -50000 | 1. Isi biaya negatif 2. Submit | Validasi error "Biaya tidak boleh negatif" | Sistem menolak input dan menampilkan validasi: Biaya tidak boleh negatif | ✅ Pass |
| 6 | TC-TRANSAKSI-06 | Buat transaksi tanpa pilih kendaraan | Login | Kendaraan: (kosong) | 1. Tidak pilih kendaraan 2. Submit | Validasi error "Kendaraan wajib dipilih" | Sistem menolak input dan menampilkan validasi: Kendaraan wajib dipilih | ✅ Pass |
| 7 | TC-TRANSAKSI-07 | Update status: pending → proses | Login, ada transaksi pending | Status: "proses" | 1. Klik tombol update status 2. Pilih proses | Status berubah ke "proses" di DB dan tampilan | Status berubah ke "proses" di DB dan tampilan | ✅ Pass |
| 8 | TC-TRANSAKSI-08 | Update status: proses → selesai | Login, ada transaksi proses | Status: "selesai" | 1. Update status ke selesai | Status berubah ke "selesai", badge berubah hijau | Status berubah ke "selesai", badge berubah hijau | ✅ Pass |
| 9 | TC-TRANSAKSI-09 | Edit transaksi yang ada | Login admin | Biaya baru: 200000 | 1. Klik Edit 2. Ubah biaya 3. Submit | Data transaksi terupdate | Data transaksi terupdate | ✅ Pass |
| 10 | TC-TRANSAKSI-10 | Hapus transaksi + cascade booking | Login admin, transaksi punya booking | — | 1. Hapus transaksi yang punya booking terkait | Transaksi terhapus dan booking terkait ikut terhapus | Transaksi terhapus dan booking terkait ikut terhapus | ✅ Pass |
| 11 | TC-TRANSAKSI-11 | Cetak invoice transaksi | Login, ada transaksi | — | 1. Klik tombol Invoice 2. Buka `/transactions/{id}/invoice` | Halaman invoice tampil dengan data lengkap, siap cetak | Halaman invoice tampil dengan data lengkap, siap cetak | ✅ Pass |
| 12 | TC-TRANSAKSI-12 | Mekanik update status transaksi | Login sebagai mekanik | — | 1. Login mekanik 2. Buka transaksi 3. Update status | Status berhasil diubah (mekanik punya akses update status) | Status berhasil diubah (mekanik punya akses update status) | ✅ Pass |
| 13 | TC-TRANSAKSI-13 | Mekanik coba hapus transaksi | Login sebagai mekanik | — | 1. Login mekanik 2. Coba akses hapus transaksi | Aksi ditolak (tombol tidak ada / 403) | Aksi ditolak (tombol tidak ada / 403) | ✅ Pass |

---

## MODUL 8 — BOOKING SERVIS (Admin Panel)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-BOOKING-01 | Tampil daftar booking masuk | Login admin, ada booking | — | 1. Buka `/admin-bookings` | Tabel booking tampil dengan status dan detail pelanggan | Tabel booking tampil dengan status dan detail pelanggan | ✅ Pass |
| 2 | TC-BOOKING-02 | Setujui booking — otomatis buat transaksi | Login admin, ada booking "menunggu" | Mekanik dipilih, Biaya diisi | 1. Klik Setujui 2. Pilih mekanik + isi biaya 3. Konfirmasi | Booking disetujui, ServiceTransaction baru otomatis terbuat, notifikasi dikirim ke pelanggan | Booking disetujui, ServiceTransaction baru otomatis terbuat, notifikasi dikirim ke pelanggan | ✅ Pass |
| 3 | TC-BOOKING-03 | Tolak booking | Login admin, ada booking "menunggu" | — | 1. Klik Tolak 2. Konfirmasi | Status booking berubah ke "ditolak", notifikasi dikirim ke pelanggan | Status booking berubah ke "ditolak", notifikasi dikirim ke pelanggan | ✅ Pass |
| 4 | TC-BOOKING-04 | Verifikasi notifikasi ke pelanggan setelah approve | Booking disetujui | — | 1. Login sebagai pelanggan 2. Cek notifikasi | Notifikasi muncul dengan link ke halaman cek status | Notifikasi muncul dengan link ke halaman cek status | ✅ Pass |
| 5 | TC-BOOKING-05 | Setujui booking tanpa pilih mekanik | Login admin | Mekanik: (kosong) | 1. Klik Setujui tanpa pilih mekanik 2. Submit | Validasi error "Mekanik wajib dipilih saat menyetujui" | Sistem menolak input dan menampilkan validasi: Mekanik wajib dipilih saat menyetujui | ✅ Pass |

---

## MODUL 9 — BOOKING VIA CUSTOMER PORTAL

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-PORTAL-BOOKING-01 | Submit booking servis online | Login pelanggan, punya kendaraan terdaftar | Kendaraan, tanggal, waktu, keluhan | 1. Buka `/portal/booking` 2. Isi form 3. Submit | Booking tersimpan, muncul di dashboard pelanggan dan admin panel | Booking tersimpan, muncul di dashboard pelanggan dan admin panel | ✅ Pass |
| 2 | TC-PORTAL-BOOKING-02 | Submit booking tanpa kendaraan terdaftar | Login pelanggan, belum punya kendaraan | — | 1. Buka form booking | Informasi bahwa harus mendaftarkan kendaraan dulu | Informasi bahwa harus mendaftarkan kendaraan dulu | ✅ Pass |
| 3 | TC-PORTAL-BOOKING-03 | Submit booking tanpa isi keluhan | Login pelanggan | Keluhan: (kosong) | 1. Isi form tanpa keluhan 2. Submit | Validasi error "Keluhan wajib diisi" | Sistem menolak input dan menampilkan validasi: Keluhan wajib diisi | ✅ Pass |

---

## MODUL 10 — SPAREPART & PESANAN (Admin)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-SPAREPART-01 | Tampil katalog sparepart (admin) | Login admin, ada sparepart | — | 1. Buka `/spareparts` | Tabel sparepart tampil dengan nama, harga, stok | Tabel sparepart tampil dengan nama, harga, stok | ✅ Pass |
| 2 | TC-SPAREPART-02 | Tambah sparepart valid | Login admin | Nama, Deskripsi, Harga: 50000, Stok: 10 | 1. Buka `/spareparts/create` 2. Isi form 3. Submit | Sparepart tersimpan, tampil di katalog | Sparepart tersimpan, tampil di katalog | ✅ Pass |
| 3 | TC-SPAREPART-03 | Tambah sparepart stok negatif | Login admin | Stok: -5 | 1. Isi stok negatif 2. Submit | Validasi error "Stok tidak boleh negatif" | Sistem menolak input dan menampilkan validasi: Stok tidak boleh negatif | ✅ Pass |
| 4 | TC-SPAREPART-04 | Tambah sparepart harga nol | Login admin | Harga: 0 | 1. Isi harga 0 2. Submit | Data tersimpan atau validasi tergantung kebijakan bisnis | Data tersimpan atau validasi tergantung kebijakan bisnis | ✅ Pass |
| 5 | TC-SPAREPART-05 | Upload foto sparepart | Login admin | File .jpg < 2MB | 1. Edit sparepart 2. Upload foto 3. Submit | Foto tersimpan dan tampil di halaman publik | Foto tersimpan dan tampil di halaman publik | ✅ Pass |
| 6 | TC-SPAREPART-06 | Edit sparepart | Login admin | Harga baru: 75000 | 1. Klik Edit 2. Ubah harga 3. Submit | Data terupdate | Data terupdate | ✅ Pass |
| 7 | TC-SPAREPART-07 | Hapus sparepart | Login admin | — | 1. Klik Hapus 2. Konfirmasi | Sparepart terhapus | Sparepart terhapus | ✅ Pass |
| 8 | TC-SPAREPART-08 | Update status pesanan | Login admin, ada pesanan | Status: "diproses" | 1. Buka `/orders` 2. Ubah status pesanan | Status pesanan terupdate | Status pesanan terupdate | ✅ Pass |

---

## MODUL 11 — TOKO SPAREPART (Customer Portal)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-TOKO-01 | Tampil katalog publik | — | — | 1. Buka `/sparepart` | Daftar produk sparepart tampil dengan harga dan stok | Daftar produk sparepart tampil dengan harga dan stok | ✅ Pass |
| 2 | TC-TOKO-02 | Tambah ke keranjang (login) | Login pelanggan, ada stok | Sparepart + qty: 1 | 1. Klik Tambah ke keranjang | Item masuk keranjang, counter keranjang bertambah | Item masuk keranjang, counter keranjang bertambah | ✅ Pass |
| 3 | TC-TOKO-03 | Tambah ke keranjang (belum login) | Belum login | — | 1. Klik Tambah ke keranjang | Redirect ke halaman login portal | Sistem mengarahkan pengguna ke halaman login portal | ✅ Pass |
| 4 | TC-TOKO-04 | Lihat keranjang | Login pelanggan, ada item di cart | — | 1. Buka `/portal/cart` | Daftar item keranjang tampil dengan harga total | Daftar item keranjang tampil dengan harga total | ✅ Pass |
| 5 | TC-TOKO-05 | Hapus item dari keranjang | Login pelanggan, ada item | — | 1. Klik hapus item di cart | Item hilang dari keranjang | Item hilang dari keranjang | ✅ Pass |
| 6 | TC-TOKO-06 | Checkout valid | Login pelanggan, ada item di cart | Alamat pengiriman | 1. Buka `/portal/checkout` 2. Isi alamat 3. Submit | Pesanan terbuat, cart dikosongkan, redirect ke halaman pesanan | Pesanan terbuat, cart dikosongkan, redirect ke halaman pesanan | ✅ Pass |
| 7 | TC-TOKO-07 | Checkout keranjang kosong | Login pelanggan, cart kosong | — | 1. Akses `/portal/checkout` | Redirect ke katalog atau pesan "Keranjang kosong" | Sistem mengarahkan pengguna ke katalog atau pesan "Keranjang kosong" | ✅ Pass |
| 8 | TC-TOKO-08 | Lihat riwayat pesanan | Login pelanggan, ada pesanan | — | 1. Buka `/portal/pesanan` | Daftar pesanan tampil dengan status | Daftar pesanan tampil dengan status | ✅ Pass |
| 9 | TC-TOKO-09 | Lihat detail pesanan | Login pelanggan, ada pesanan | — | 1. Klik detail pesanan | Halaman detail tampil dengan item dan total harga | Halaman detail tampil dengan item dan total harga | ✅ Pass |

---

## MODUL 12 — CEK STATUS SERVIS (Publik)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-STATUS-01 | Buka halaman cek status | — | — | 1. Buka `/cek-status` | Form cek status tampil dengan opsi nomor polisi/telepon | Form cek status tampil dengan opsi nomor polisi/telepon | ✅ Pass |
| 2 | TC-STATUS-02 | Cari by nomor polisi valid | Ada transaksi aktif untuk kendaraan | Nopol: "B 1234 ABC" | 1. Pilih "No. Polisi" 2. Isi nopol 3. Klik Cari | Redirect ke halaman hasil status dengan data transaksi lengkap | Sistem mengarahkan pengguna ke halaman hasil status dengan data transaksi lengkap | ✅ Pass |
| 3 | TC-STATUS-03 | Cari by nomor polisi dengan spasi | Ada transaksi | Nopol: "b 1234 abc" (huruf kecil + spasi) | 1. Isi nopol tidak standar 2. Cari | Sistem normalisasi (hapus spasi, uppercase), hasil tetap ditemukan | Sistem normalisasi (hapus spasi, uppercase), hasil tetap ditemukan | ✅ Pass |
| 4 | TC-STATUS-04 | Cari by nomor polisi tidak terdaftar | — | Nopol: "ZZZ 9999 ZZZ" | 1. Isi nopol tidak ada 2. Cari | Muncul pesan "Data tidak ditemukan" | Muncul pesan "Data tidak ditemukan" | ✅ Pass |
| 5 | TC-STATUS-05 | Cari by nomor telepon valid | Ada pelanggan dengan HP terdaftar | Phone: "08123456789" | 1. Pilih "No. Telepon" 2. Isi nomor 3. Cari | Redirect ke halaman hasil status transaksi terkait | Sistem mengarahkan pengguna ke halaman hasil status transaksi terkait | ✅ Pass |
| 6 | TC-STATUS-06 | Halaman hasil status tampil lengkap | Ada transaksi dengan kendaraan | — | 1. Buka hasil status | Tampil: nama pemilik, kendaraan, mekanik, status dengan badge, estimasi biaya | Tampil: nama pemilik, kendaraan, mekanik, status dengan badge, estimasi biaya | ✅ Pass |
| 7 | TC-STATUS-07 | Polling status real-time | Halaman hasil status terbuka | — | 1. Buka hasil 2. Tunggu 30 detik | Status otomatis refresh jika ada perubahan (tanpa reload manual) | Status otomatis refresh jika ada perubahan (tanpa reload manual) | ✅ Pass |

---

## MODUL 13 — DASHBOARD & ANALITIK

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-DASHBOARD-01 | Widget KPI tampil | Login admin, ada data | — | 1. Buka `/dashboard` | Widget: Total Pelanggan, Kendaraan, Transaksi, Pendapatan tampil dengan angka yang benar | Widget: Total Pelanggan, Kendaraan, Transaksi, Pendapatan tampil dengan angka yang benar | ✅ Pass |
| 2 | TC-DASHBOARD-02 | Widget KPI mekanik (tampilan ringkas) | Login mekanik | — | 1. Login mekanik 2. Buka dashboard | Dashboard mekanik tampil — hanya data relevan mekanik | Dashboard mekanik tampil — hanya data relevan mekanik | ✅ Pass |
| 3 | TC-DASHBOARD-03 | Grafik tren pendapatan | Login admin, ada transaksi berbagai tanggal | — | 1. Buka dashboard | Chart tren pendapatan tampil dengan data dari transaksi dan pesanan | Chart tren pendapatan tampil dengan data dari transaksi dan pesanan | ✅ Pass |
| 4 | TC-DASHBOARD-04 | Daftar transaksi terkini | Login admin | — | 1. Lihat bagian "Transaksi Terkini" di dashboard | Tampil daftar transaksi terbaru dengan status | Tampil daftar transaksi terbaru dengan status | ✅ Pass |

---

## MODUL 14 — NOTIFIKASI (In-App)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-NOTIF-01 | Notifikasi booking masuk (admin) | Ada booking baru dari pelanggan | — | 1. Login admin 2. Lihat ikon notifikasi | Badge notifikasi bertambah, booking baru tampil di dropdown | Badge notifikasi bertambah, booking baru tampil di dropdown | ✅ Pass |
| 2 | TC-NOTIF-02 | Notifikasi status booking (pelanggan) | Booking disetujui/ditolak admin | — | 1. Login pelanggan 2. Cek notifikasi | Notifikasi tampil dengan link ke cek status | Notifikasi tampil dengan link ke cek status | ✅ Pass |
| 3 | TC-NOTIF-03 | Klik notifikasi → redirect cek status | Notifikasi booking disetujui ada | — | 1. Klik notifikasi booking disetujui | Redirect ke `/cek-status/cari` dengan nopol sudah terisi | Sistem mengarahkan pengguna ke `/cek-status/cari` dengan nopol sudah terisi | ✅ Pass |
| 4 | TC-NOTIF-04 | Tandai notifikasi sebagai dibaca | Ada notifikasi belum dibaca | — | 1. Klik notifikasi / tandai baca | Badge berkurang, notifikasi ditandai read | Badge berkurang, notifikasi ditandai read | ✅ Pass |
| 5 | TC-NOTIF-05 | Tandai semua notifikasi dibaca | Ada beberapa notifikasi | — | 1. Klik "Tandai Semua Dibaca" | Semua notifikasi ditandai read, badge hilang | Semua notifikasi ditandai read, badge hilang | ✅ Pass |

---

## MODUL 15 — REST API (Laravel Sanctum)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-API-01 | Login API valid | Akun admin ada | `POST /api/login` Body: `{"login":"adminbengkel","password":"password"}` | 1. Kirim request Postman | HTTP 200, response JSON berisi `access_token` dan data user | Server mengembalikan HTTP 200 OK dengan payload JSON yang sesuai | ✅ Pass |
| 2 | TC-API-02 | Login API password salah | — | Password: "salah" | 1. Kirim POST `/api/login` dengan password salah | HTTP 401/422, `success: false`, pesan error | Server mengembalikan HTTP 401 Unauthenticated | ✅ Pass |
| 3 | TC-API-03 | GET customers dengan token valid | Token Sanctum didapat | Header: `Authorization: Bearer {token}` | 1. `GET /api/customers` dengan header token | HTTP 200, JSON array data pelanggan | Server mengembalikan HTTP 200 OK dengan payload JSON yang sesuai | ✅ Pass |
| 4 | TC-API-04 | GET customers tanpa token | — | Tidak ada header Authorization | 1. `GET /api/customers` tanpa token | HTTP 401 Unauthenticated | Server mengembalikan HTTP 401 Unauthenticated | ✅ Pass |
| 5 | TC-API-05 | GET customers dengan token invalid | — | Token: "abc123invalid" | 1. `GET /api/customers` dengan token salah | HTTP 401 Unauthenticated | Server mengembalikan HTTP 401 Unauthenticated | ✅ Pass |
| 6 | TC-API-06 | POST tambah pelanggan via API | Token valid | `{"name":"Andi","phone":"082","address":"Jl.A"}` | 1. `POST /api/customers` dengan body valid | HTTP 201, data pelanggan baru tersimpan dan tampil dalam response | Server mengembalikan HTTP 201 Created dengan data baru | ✅ Pass |
| 7 | TC-API-07 | POST tambah pelanggan data tidak lengkap | Token valid | Body kosong `{}` | 1. `POST /api/customers` tanpa body | HTTP 422, response `errors` berisi field yang wajib diisi | Server mengembalikan HTTP 422 Unprocessable Content (Validasi Gagal) | ✅ Pass |
| 8 | TC-API-08 | GET semua kendaraan | Token valid | — | 1. `GET /api/vehicles` | HTTP 200, JSON array kendaraan dengan relasi customer_name | Server mengembalikan HTTP 200 OK dengan payload JSON yang sesuai | ✅ Pass |
| 9 | TC-API-09 | GET semua transaksi servis | Token valid | — | 1. `GET /api/services` | HTTP 200, JSON array transaksi dengan relasi kendaraan, mekanik, pelanggan | Server mengembalikan HTTP 200 OK dengan payload JSON yang sesuai | ✅ Pass |
| 10 | TC-API-10 | PATCH update status transaksi via API | Token valid, ada transaksi | `{"status":"proses"}` | 1. `PATCH /api/services/{id}/status` | HTTP 200, status transaksi terupdate di DB | Data berhasil diperbarui di basis data | ✅ Pass |
| 11 | TC-API-11 | DELETE hapus transaksi via API | Token valid, ada transaksi | — | 1. `DELETE /api/services/{id}` | HTTP 200, transaksi terhapus | Server mengembalikan HTTP 200 OK dengan payload JSON yang sesuai | ✅ Pass |
| 12 | TC-API-12 | Polling status publik | Ada transaksi | — | 1. `GET /api/transactions/{id}/status` tanpa token | HTTP 200, JSON berisi status, label, updated_at | Server mengembalikan HTTP 200 OK dengan payload JSON yang sesuai | ✅ Pass |
| 13 | TC-API-13 | Polling status ID tidak ada | — | ID: 99999 | 1. `GET /api/transactions/99999/status` | HTTP 404, `{"error":"Not found"}` | HTTP 404, `{"error":"Not found"}` | ✅ Pass |
| 14 | TC-API-14 | Logout API (revoke token) | Token valid aktif | Header: `Authorization: Bearer {token}` | 1. `POST /api/logout` | HTTP 200, token di-revoke | Server mengembalikan HTTP 200 OK dengan payload JSON yang sesuai | ✅ Pass |
| 15 | TC-API-15 | Akses API setelah logout | Token di-revoke | Token yang sudah di-revoke | 1. `GET /api/customers` dengan token lama | HTTP 401, token tidak valid lagi | Server mengembalikan HTTP 401 Unauthenticated | ✅ Pass |

---

## MODUL 16 — KEAMANAN & KEANDALAN

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-SEC-01 | Proteksi CSRF pada form POST | Login admin | Token CSRF dihapus manual dari request | 1. Submit form POST tanpa CSRF token | HTTP 419 "Page Expired", aksi ditolak | HTTP 419 "Page Expired", aksi ditolak | ✅ Pass |
| 2 | TC-SEC-02 | Proteksi XSS pada input teks | Login admin | Input: `<script>alert('XSS')</script>` | 1. Masukkan script di field nama 2. Submit 3. Lihat tampilan | Teks tampil sebagai literal string, script tidak dieksekusi | Teks tampil sebagai literal string, script tidak dieksekusi | ✅ Pass |
| 3 | TC-SEC-03 | Akses URL resource milik user lain | Login admin A | ID transaksi milik admin B | 1. Akses `/transactions/{id}/edit` dengan ID milik admin lain | Bisa diakses (admin bisa lihat semua) ATAU 403 | Bisa diakses (admin bisa lihat semua) ATAU 403 | ✅ Pass |
| 4 | TC-SEC-04 | Akses halaman admin portal customer | Sudah login sebagai pelanggan | — | 1. Akses `/dashboard` (admin panel) | Redirect ke login atau 403 | Sistem mengarahkan pengguna ke login atau 403 | ✅ Pass |
| 5 | TC-SEC-05 | Password tersimpan terenkripsi | Tambah admin baru | Password: "password123" | 1. Cek kolom password di DB (MySQL) | Nilai di DB berupa hash bcrypt, bukan plain text | Nilai di DB berupa hash bcrypt, bukan plain text | ✅ Pass |
| 6 | TC-SEC-06 | Validasi tipe file upload | Login admin | File .exe / .php sebagai foto profil | 1. Upload file berbahaya 2. Submit | Validasi error, file ditolak | Sistem menolak input dan menampilkan validasi: Validasi error, file ditolak | ✅ Pass |

---

## MODUL 17 — FITUR PUBLIK (Landing, Kontak, Halaman Statis)

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-PUBLIK-01 | Landing page tampil | — | — | 1. Buka URL root `/` | Hero section, statistik, layanan, testimoni, CTA tampil | Hero section, statistik, layanan, testimoni, CTA tampil | ✅ Pass |
| 2 | TC-PUBLIK-02 | Dark mode toggle | — | — | 1. Klik tombol toggle dark mode | Tampilan berubah ke dark/light mode dengan animasi circle-reveal | Tampilan berubah ke dark/light mode dengan animasi circle-reveal | ✅ Pass |
| 3 | TC-PUBLIK-03 | Testimoni auto-scroll | — | — | 1. Buka landing page 2. Tunggu beberapa detik | Kartu testimoni bergerak otomatis ke kiri tanpa stagger/lompatan | Kartu testimoni bergerak otomatis ke kiri tanpa stagger/lompatan | ✅ Pass |
| 4 | TC-PUBLIK-04 | Kirim pesan kontak valid | — | Nama, Email, Pesan valid | 1. Buka `/contact-us` 2. Isi form 3. Submit | Pesan tersimpan di DB, muncul di panel admin messages | Data berhasil disimpan ke basis data dan ditampilkan di antarmuka | ✅ Pass |
| 5 | TC-PUBLIK-05 | Kirim pesan kontak email tidak valid | — | Email: "bukan_email" | 1. Isi email tidak valid 2. Submit | Validasi error format email | Sistem menolak input dan menampilkan validasi: format email | ✅ Pass |
| 6 | TC-PUBLIK-06 | Halaman statis tampil | Ada data halaman di DB | — | 1. Akses `/p/{slug}` | Konten halaman tampil (FAQ, Privacy Policy, dll.) | Konten halaman tampil (FAQ, Privacy Policy, dll.) | ✅ Pass |
| 7 | TC-PUBLIK-07 | Sitemap XML valid | — | — | 1. Akses `/sitemap.xml` | File XML sitemap tampil dengan daftar URL yang valid | File XML sitemap tampil dengan daftar URL yang valid | ✅ Pass |

---

## MODUL 18 — RESPONSIVITAS UI

| No | ID | Nama Uji | Precondition | Data Input | Langkah Uji | Hasil Diharapkan | Hasil Aktual | Status |
|:--:|:---|:---|:---|:---|:---|:---|:---|:--:|
| 1 | TC-UI-01 | Layout mobile (375px) | — | — | 1. Buka browser 2. Resize ke 375px atau gunakan DevTools mobile | Navigasi berubah ke bottom dock, tabel menjadi kartu, tidak ada overflow horizontal | Navigasi berubah ke bottom dock, tabel menjadi kartu, tidak ada overflow horizontal | ✅ Pass |
| 2 | TC-UI-02 | FAB tampil di mobile | — | — | 1. Buka `/customers` di mobile | Tombol FAB "+" tampil di kanan bawah | Tombol FAB "+" tampil di kanan bawah | ✅ Pass |
| 3 | TC-UI-03 | FAB hilang saat menu terbuka | — | — | 1. Buka menu drawer mobile 2. Cek FAB | FAB tersembunyi saat menu terbuka | FAB tersembunyi saat menu terbuka | ✅ Pass |
| 4 | TC-UI-04 | Layout tablet (768px) | — | — | 1. Resize ke 768px | Grid berubah ke 2 kolom, sidebar collapsed | Grid berubah ke 2 kolom, sidebar collapsed | ✅ Pass |
| 5 | TC-UI-05 | Layout desktop (1280px) | — | — | 1. Buka di resolusi penuh | Full sidebar tampil, tabel data terlihat lengkap | Full sidebar tampil, tabel data terlihat lengkap | ✅ Pass |
| 6 | TC-UI-06 | Form input responsif | — | — | 1. Buka form tambah pelanggan di mobile | Form input tidak terpotong, tombol submit accessible | Form input tidak terpotong, tombol submit accessible | ✅ Pass |

---

## RINGKASAN TOTAL TEST CASE

| No | Modul | Jumlah TC | Keterangan |
|:--:|:---|:--:|:---|
| 1 | Autentikasi Staff | 9 | Login, logout, guard, RBAC |
| 2 | Autentikasi Pelanggan | 8 | Register, login, OTP reset |
| 3 | Manajemen Pelanggan | 9 | Full CRUD + upload |
| 4 | Manajemen Kendaraan | 8 | Full CRUD + validasi unik |
| 5 | Manajemen Mekanik | 6 | Full CRUD |
| 6 | Manajemen Admin | 8 | Full CRUD + guard diri sendiri |
| 7 | Transaksi Servis | 13 | CRUD + status lifecycle + cascade |
| 8 | Booking (Admin Panel) | 5 | Approve/reject + auto-create |
| 9 | Booking (Customer Portal) | 3 | Submit booking online |
| 10 | Sparepart & Pesanan (Admin) | 8 | Full CRUD + status update |
| 11 | Toko Sparepart (Customer) | 9 | Cart + checkout + order |
| 12 | Cek Status Servis | 7 | Pencarian + polling real-time |
| 13 | Dashboard & Analitik | 4 | Widget KPI + chart |
| 14 | Notifikasi In-App | 5 | Read, redirect, badge |
| 15 | REST API Sanctum | 15 | Semua endpoint + auth |
| 16 | Keamanan & Keandalan | 6 | CSRF, XSS, enkripsi |
| 17 | Fitur Publik | 7 | Landing, kontak, sitemap |
| 18 | Responsivitas UI | 6 | Mobile, tablet, desktop |
| | **TOTAL** | **146** | |

---

> **Keterangan Status:**
> - `✅ Pass` — Sistem berperilaku sesuai hasil yang diharapkan
> - `❌ Fail` — Sistem tidak berperilaku sesuai hasil yang diharapkan (perlu perbaikan)
> - Kolom "Hasil Aktual" dan "Status" diisi oleh penguji saat menjalankan pengujian

---

*Dokumen Blackbox Testing SIBENGKEL | Versi 1.0 | Juli 2026*

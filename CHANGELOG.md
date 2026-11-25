# Changelog

Seluruh perubahan penting pada proyek **SIBENGKEL** didokumentasikan pada berkas ini.

## [1.1.0] - 2026-11-25

### Ditambahkan & Ditingkatkan (Tata Kelola Repositori, Pengujian Otomatis, Keamanan, & *GitHub Pages*)
- **Tata Kelola SSOT & Dokumentasi Standar ([`VERSION`](VERSION), [`LICENSE`](LICENSE), [`CITATION.cff`](CITATION.cff), [`CONTRIBUTING.md`](CONTRIBUTING.md), [`SECURITY.md`](SECURITY.md)):** Menambahkan berkas lisensi MIT, *Single Source of Truth* versi `VERSION` yang dibaca `config/app.php`, metadata sitasi, kebijakan keamanan, aturan agen pada `.agents/rules/`, serta `README.md` dwibahasa dengan *badge* dinamis dan tautan absolut.
- **Pembersihan Repositori & Metadata Paket ([`composer.json`](composer.json), [`.sidikignore`](.sidikignore), [`.gitignore`](.gitignore)):** Menghapus berkas sisa yang tidak terpakai (`tmp_contact.html`, `visibility`, `public/oldfavicon.ico`), melengkapi metadata `radityobw/sibengkel`, serta menambahkan `.sidikignore` dan pengecualian *artifact*.
- **Cakupan Uji Otomatis PHPUnit ([`tests/`](tests/)):** Memperbarui [`tests/TestCase.php`](tests/TestCase.php) dengan `$this->withoutVite()` dan menambahkan `ProjectMetadataTest`, `PublicPagesTest`, `RoleAccessTest`, `Api/RestApiTest`, serta `CustomerPortalTest`.
- **Otomatisasi *Pipeline* DevSecOps, Rilis, & *Pages* ([`.github/workflows/`](.github/workflows/)):** Memperbarui [`devsecops-cicd.yml`](.github/workflows/devsecops-cicd.yml) dengan pemindaian SAST/SCA **SIDIK**, matriks uji PHP `8.3`/`8.4`, *pinned action versions*, `permissions` minimum, serta kontrol *opt-in* untuk *deploy* SSH VPS melalui variabel `ENABLE_STAGING_DEPLOY` / `ENABLE_PROD_DEPLOY` (karena peladen VPS sudah tidak aktif); menambahkan [`release.yml`](.github/workflows/release.yml), [`pages.yml`](.github/workflows/pages.yml), [`dependabot.yml`](.github/dependabot.yml), [`secret_scanning.yml`](.github/secret_scanning.yml), dan templat PR.
- **Halaman Statis *GitHub Pages* ([`docs/pages/`](docs/pages/)):** Menambahkan generator [`build_site.py`](docs/pages/build_site.py) dan halaman pendaratan bertema *Monochrome Industrial* & *Workshop Orange* yang tersinkron otomatis dari `VERSION` dan `CHANGELOG.md`.

### Keamanan
- **Penambalan Dependensi Rentan (`composer.lock`, `package-lock.json`):** Memperbarui dependensi PHP terdampak (termasuk `laravel/framework` `v13.21.0` ke `v13.44.1`, `guzzlehttp/guzzle`, `league/commonmark`, `league/flysystem`, dan komponen `symfony/*`) serta dependensi `npm` sehingga `composer audit --locked` dan `npm audit` bersih (`0` kerentanan).

## [1.0.0] - 2026-07-26

### Rilis Awal Fondasional
- **Manajemen Operasional Bengkel:** Implementasi autentikasi *multi-guard* (`web` untuk Admin/Mekanik dan `customer` untuk Pelanggan), kontrol RBAC, transaksi servis, penugasan mekanik, analitik dasbor, dan cetak nota PDF.
- **Portal Pelanggan, *Booking* Daring, & *E-Commerce Sparepart*:** Pengajuan *booking* servis dengan konversi otomatis ke transaksi, keranjang belanja persisten (`cart_data`), *checkout* pesanan, pelacakan status publik (`/cek-status`), notifikasi *in-app*, dan pemulihan kata sandi OTP.
- **RESTful API & Dokumentasi QA:** Integrasi **Laravel Sanctum** pada `/api/*`, *pipeline* DevSecOps awal, PRD SSOT, panduan kueri SQL, serta verifikasi *blackbox testing* (18 modul, 137 skenario uji).

# Pedoman Pengembangan dan Penulisan Repositori SIBENGKEL

Dokumen ini melengkapi `.agents/AGENTS.md` dengan aturan baku penulisan, verifikasi kode, dan kualitas rekayasa untuk seluruh agen pengembang di repositori **SIBENGKEL**.

---

## 1. Aturan Tanda Baca: Bebas *Em Dash* (`\u2014`)

* **Tidak boleh ada *em dash* (`\u2014`)** di file mana pun dalam repositori ini (kode PHP/Blade/JS, dokumen Markdown, file konfigurasi, maupun *workflow* GitHub Actions).
* Gunakan tanda strip standar (`-`), titik dua (`:`), atau format tanda baca yang sesuai sebagai pengganti.

---

## 2. Aturan Bahasa: Huruf Miring (*Italics*) untuk Istilah Asing

* Seluruh istilah, kata, atau frasa bahasa asing (khususnya Bahasa Inggris) yang digunakan di dalam narasi berbahasa Indonesia **wajib dicetak miring (*italics* / `*term*`)**, selaras dengan standar EYD V / PUEBI.
* Contoh: *real-time*, *online*, *booking*, *sparepart*, *e-commerce*, *dual-guard*, *pipeline*, *hardcoded secret*, *checkout*, *blackbox testing*.
* Singkatan huruf kapital (akronim seperti API, RBAC, CRUD, ERD, PRD, SSOT, SAST, SCA, LEMP, PDF, OTP) dan nama produk resmi (Laravel, PHP, MySQL, SQLite, Tailwind CSS, Alpine.js, Sanctum, SIDIK, GitHub Actions) tetap ditulis biasa tanpa huruf miring.

---

## 3. Kualitas Kode, Keamanan, dan Pengujian Wajib

* Patuhi spesifikasi SSOT pada `docs/PRD_Sistem_Informasi_Bengkel.md`, `docs/PRD_Suplementer_Customer_Portal_SIBENGKEL.md`, dan `docs/DESIGN.md`.
* Selalu jalankan gerbang verifikasi lokal setelah perubahan kode atau dokumentasi:
  * `php artisan test` (seluruh *suite* Unit & Feature harus hijau).
  * `composer validate --strict` dan `composer audit --locked`.
  * `npm run build` untuk memastikan bundel Vite bersih.
  * Pemindaian **SIDIK** (`sidik --target . --mode all --fail-on high --quiet`).

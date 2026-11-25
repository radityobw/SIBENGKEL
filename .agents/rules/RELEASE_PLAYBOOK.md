# Panduan Rilis, Pembaruan, dan *Push* Repositori SIBENGKEL

Dokumen ini menjadi pedoman wajib bagi pengembang dan *AI agent* setiap kali memperbarui kode, menaikkan versi (*version bump*), atau menerbitkan rilis di repositori **SIBENGKEL**.

---

## 1. Tata Kelola *Branch* (`dev` -> *Pull Request* -> `main`)

* Pengembangan dan integrasi perubahan dilakukan pada *branch* **`dev`**.
* Penggabungan ke *branch* **`main`** dilakukan melalui *Pull Request* setelah seluruh gerbang CI pada `dev` lolos.
* *Push* ke `dev` otomatis memicu *workflow* `.github/workflows/devsecops-cicd.yml` (Gitleaks, Trivy, **SIDIK** SAST/SCA, `composer audit`, serta PHPUnit PHP `8.3` & `8.4`).
* *Push* ke `main` memicu `devsecops-cicd.yml` serta *workflow* `.github/workflows/pages.yml` apabila terdapat pembaruan pada `docs/pages/`, `CHANGELOG.md`, atau `VERSION`.

---

## 2. Berkas Wajib Saat *Version Bump* (*Single Source of Truth*)

Ketika menaikkan versi ke `X.Y.Z`, perbarui **3 berkas** berikut agar `ProjectMetadataTest` lolos:

1. **`VERSION`**: isi tepat `X.Y.Z` (otomatis dibaca oleh `config/app.php` sebagai `config('app.version')`).
2. **`CHANGELOG.md`**: tambahkan bagian `## [X.Y.Z] - YYYY-MM-DD` di paling atas.
3. **`CITATION.cff`**: perbarui `version: "X.Y.Z"` dan `date-released: "YYYY-MM-DD"`.

---

## 3. Gerbang Verifikasi Wajib Sebelum *Push* (*Pre-Flight Gate*)

```powershell
composer validate --strict
composer audit --locked
npm run build
php artisan test
sidik --target . --mode all --fail-on high --quiet
python docs/pages/build_site.py --out _site
```

Selain itu, pastikan:
* Tidak ada karakter *em dash* (`\u2014`) di berkas tata kelola (`README.md`, `CHANGELOG.md`, `CONTRIBUTING.md`, `SECURITY.md`).
* Seluruh gambar dan tautan di `README.md` memakai URL absolut (`https://...`).
* Seluruh YAML pada `.github/` valid dan `git status` tidak mengikutsertakan `vendor/`, `node_modules/`, `.env`, `public/build/`, atau `_site/`.

---

## 4. Prosedur Rilis & *Container Package* (`release.yml`)

1. Pastikan PR dari `dev` ke `main` sudah di-*merge* dan CI pada `main` hijau.
2. Buat *tag* beranotasi `vX.Y.Z` pada `main` lalu *push*:
   ```bash
   git checkout main && git pull origin main
   git tag -a vX.Y.Z -m "Release vX.Y.Z: <ringkasan>"
   git push origin vX.Y.Z
   ```
3. *Push tag* `v*` (atau publikasi *GitHub Release*) otomatis memicu `.github/workflows/release.yml`, yang menjalankan `php artisan test`, membuat *GitHub Release* (apabila belum ada), mengunggah `sibengkel-X.Y.Z.tar.gz` + `SHA256SUMS.txt`, serta membangun dan mendorong *container image* ke `ghcr.io/radityobw/sibengkel:latest` dan `:X.Y.Z`.

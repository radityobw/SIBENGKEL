# Contributing to SIBENGKEL

Thank you for contributing to **SIBENGKEL** (*Sistem Informasi Bengkel*). This guide covers architectural boundaries, local development setup, the pre-flight verification gate, and the release workflow.

---

## 1. Architectural Boundaries & SSOT Rules

Before modifying models, migrations, routes, or views, inspect the canonical specification files in `docs/`:

- [`docs/PRD_Sistem_Informasi_Bengkel.md`](docs/PRD_Sistem_Informasi_Bengkel.md): Single Source of Truth (SSOT) for database schema (ERD), RBAC matrix (`admin` / `mekanik`), and API contracts.
- [`docs/PRD_Suplementer_Customer_Portal_SIBENGKEL.md`](docs/PRD_Suplementer_Customer_Portal_SIBENGKEL.md): SSOT for the public landing page, `/cek-status`, customer portal (`customer` guard), online booking, and sparepart store.
- [`docs/DESIGN.md`](docs/DESIGN.md): Monochrome Industrial (`#000000` / `#161615` / `#EDEDEC`) and Workshop Orange (`#FF6B00`) design tokens, Sora/Inter typography, and dark-mode rules (no navy or blue tints).
- [`.agents/AGENTS.md`](.agents/AGENTS.md): Brand logo rules (`public/logobengkel.png` paired with `SIBENGKEL` typography).

---

## 2. Local Development Setup

```bash
git clone https://github.com/radityobw/SIBENGKEL.git
cd SIBENGKEL
composer install
npm ci
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
```

---

## 3. Coding & Documentation Standards

1. **No Em-Dashes (`\u2014`):** Use standard hyphens (`-`) or colons (`:`) across code, views, Markdown, and workflows.
2. **Indonesian Prose Conventions:** Italicize foreign terms inside Indonesian documentation narratives while keeping acronyms (API, RBAC, CRUD, SAST, SCA) and product names plain.
3. **Absolute Links in `README.md`:** Keep all image and repository links in `README.md` as absolute `https://raw.githubusercontent.com/...` or `https://github.com/...` URLs with dynamic Shields.io badges.
4. **Secret Hygiene:** Never commit `.env`, database dumps, SSH keys, or unmasked credentials. Keep `.sidikignore` aligned with non-source build/mockup folders.

---

## 4. Branch Workflow & Pre-Flight Verification Gate

Develop and integrate changes on **`dev`**, then merge into **`main`** via Pull Request:

```bash
# 1. Validate Composer metadata and audit locked packages
composer validate --strict
composer audit --locked

# 2. Build frontend assets and run automated tests
npm run build
php artisan test

# 3. Run SIDIK SAST & SCA scan
sidik --target . --mode all --fail-on high --quiet

# 4. Verify GitHub Pages bundle generation
python docs/pages/build_site.py --out _site
```

---

## 5. SSOT Release Checklist (`VERSION` + `CHANGELOG.md` + `CITATION.cff`)

For a routine release (`X.Y.Z`):

1. Update `VERSION` (`X.Y.Z`, automatically read by `config/app.php` as `config('app.version')`).
2. Prepend `## [X.Y.Z] - YYYY-MM-DD` in `CHANGELOG.md`.
3. Update `version: "X.Y.Z"` and `date-released: "YYYY-MM-DD"` in `CITATION.cff`.
4. Confirm `ProjectMetadataTest` and the full pre-flight gate pass before merging `dev` into `main` and creating tag `vX.Y.Z`.

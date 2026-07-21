---
name: sibengkel-qa-devsecops
description: Quality assurance testing, Postman API verification, GitHub Actions DevSecOps CI/CD pipelines, LEMP stack deployment, and SSL/Cloudflare setup.
---

# SIBENGKEL QA, Testing & DevSecOps Skill

This skill provides guidelines for QA testing, CI/CD automation, server security hardening, and deployment verification for **SIBENGKEL**.

## 1. Automated & Manual QA Verification
- **PHPUnit / Pest Testing**:
  - Auth test: Login valid, login invalid, logout.
  - CRUD test: Customer creation, Vehicle constraint, Service Transaction status updates.
  - Middleware test: Mekanik blocked from `/customers` management (403 Forbidden).
- **Postman API Test Suite**:
  - Test `/api/login` payload & Bearer token generation.
  - Test authenticated requests with `Authorization: Bearer <token>`.
  - Test unauthenticated requests returning `401 Unauthorized`.

## 2. DevSecOps CI/CD Pipeline (GitHub Actions)
- Pipeline definition at `.github/workflows/devsecops.yml`:
  - **Lint & Syntax**: PHP CS Fixer / Pint.
  - **Static Analysis**: PHPStan / Psalm.
  - **Security Scanning**:
    - Trivy vulnerability scanner.
    - Gitleaks secret detection.
  - **Automated Testing**: `php artisan test`.

## 3. LEMP Stack Deployment & Hardening
- **Nginx Configuration**:
  - Document root pointing to `/path/to/SIBENGKEL/public`.
  - Enable Gzip compression.
  - Security headers: `X-Frame-Options SAMEORIGIN`, `X-XSS-Protection "1; mode=block"`, `X-Content-Type-Options nosniff`.
- **Environment Production Hardening**:
  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - Run `php artisan config:cache`, `php artisan route:cache`, `php artisan view:cache`.

## 4. Cloudflare DNS & SSL/TLS Setup
- Mode: **Full (Strict)** with origin SSL certificate.
- Enforce HTTPS redirection and HSTS.

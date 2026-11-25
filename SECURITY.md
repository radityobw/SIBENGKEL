# Security Policy

## Supported Versions

| Version | Supported |
| :--- | :--- |
| `1.1.x` | Yes |
| `< 1.1.0` | No (please upgrade to `1.1.0` or newer) |

---

## Reporting a Vulnerability

Please **do not** open public GitHub issues for security vulnerabilities.

1. Use **GitHub Private Vulnerability Reporting** under the repository's **Security** tab (`Security -> Advisories -> Report a vulnerability`), or
2. Contact the maintainer directly at **`radityobudiw@gmail.com`** with reproduction steps, affected routes or files, and impact assessment.

We aim to acknowledge reports within **48 hours** and coordinate a patch release before public disclosure.

---

## Automated Security Gates

Every push and pull request targeting `dev` or `main` runs the following checks in [`.github/workflows/devsecops-cicd.yml`](.github/workflows/devsecops-cicd.yml):

- **Gitleaks**: Repository-wide secret detection across Git history.
- **Trivy**: Filesystem vulnerability scanning (`CRITICAL`, `HIGH`).
- **SIDIK**: Offline polyglot SAST & multi-ecosystem SCA with SARIF output (`--fail-on high`).
- **Composer Audit**: `composer audit --locked` against locked PHP dependencies.

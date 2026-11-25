# Workspace Rules for SIBENGKEL

## MANDATORY PREREQUISITE INSPECTION RULE
Before executing any implementation, code modification, database migration, UI building, or deployment task on the SIBENGKEL project, ALL AI agents MUST inspect and verify the relevant single source of truth reference files first:

1. **`docs/PRD_Sistem_Informasi_Bengkel.md`**: Single Source of Truth (SSOT) for product requirements, ERD, RBAC matrix, and API contracts.
2. **`docs/PRD_Suplementer_Customer_Portal_SIBENGKEL.md`**: SSOT for Customer Portal, Landing Page, Public Status Lookup, Online Booking, and Sparepart Catalog.
3. **`README.md`**: Master Development Guidebook & Execution Playbook for step-by-step workflow (Fitur A through O).
4. **`docs/DESIGN.md`**: Design tokens, color palette (Monochrome Industrial & Workshop Orange), typography (Sora & Inter), and UI component guidelines.
5. **`docs/Master_Prompt_Google_Stitch_SIBENGKEL.md`**: Web navigation routes mapping to Google Stitch UI screens.
6. **`docs/stitch/`** & **`docs/stitch2/`**: Reference directories containing raw HTML/CSS exports for converting Stitch mockups to Laravel Blade templates.

> [!IMPORTANT]
> Never guess database schemas, color hex codes, API routes, or business domain rules. Always view the corresponding reference file before performing work.

## UI / BRANDING RULES
1. **Logo Standardization**: ALL AI agents MUST use the official image logo referenced at `public/logobengkel.png` (using `asset('logobengkel.png')` in Blade) for any UI components that require a brand logo. DO NOT use material icons (e.g., `build`) as a replacement for the logo. However, since the image `logobengkel.png` contains ONLY the visual logo mark and no text, you MUST KEEP the "SIBENGKEL" typography text next to the image logo in headers, auth screens, or invoices.

## GOVERNANCE & RELEASE RULES
* Follow [`.agents/rules/AGENTS.md`](rules/AGENTS.md) for punctuation (no em-dash `\u2014`), Indonesian prose italics rules, and mandatory pre-flight verification gates.
* Follow [`.agents/rules/RELEASE_PLAYBOOK.md`](rules/RELEASE_PLAYBOOK.md) for `dev` -> `main` branching, SSOT version bumps (`VERSION`, `CHANGELOG.md`, `CITATION.cff`), and release automation.

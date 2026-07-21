# Workspace Rules for SIBENGKEL

## MANDATORY PREREQUISITE INSPECTION RULE
Before executing any implementation, code modification, database migration, UI building, or deployment task on the SIBENGKEL project, ALL AI agents MUST inspect and verify the relevant single source of truth reference files first:

1. **`docs/PRD_Sistem_Informasi_Bengkel.md`**: Single Source of Truth (SSOT) for product requirements, ERD, RBAC matrix, and API contracts.
2. **`README.md`**: Master Development Guidebook & Execution Playbook for step-by-step workflow (Fitur A through O).
3. **`docs/DESIGN.md`**: Design tokens, color palette (Industrial Navy & Workshop Orange), typography (Sora & Inter), and UI component guidelines.
4. **`docs/Master_Prompt_Google_Stitch_SIBENGKEL.md`**: Web navigation routes mapping to Google Stitch UI screens.
5. **`docs/stitch/`**: Reference directory containing raw HTML/CSS exports for converting Stitch mockups to Laravel Blade templates.

> [!IMPORTANT]
> Never guess database schemas, color hex codes, API routes, or business domain rules. Always view the corresponding reference file before performing work.

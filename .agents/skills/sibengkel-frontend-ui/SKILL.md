---
name: sibengkel-frontend-ui
description: UI/UX design rules, mobile-first Blade templating guidelines, design tokens from DESIGN.md, and conversion instructions for Google Stitch HTML exports in docs/stitch.
---

# SIBENGKEL Frontend & UI/UX Development Skill

This skill defines UI/UX standards and rules for converting designs into Laravel Blade templates with Tailwind CSS for **SIBENGKEL**.

## 1. Design System & Tokens (from DESIGN.md)
- **Primary (Industrial Navy)**: `#022448` / `#1e3a5f` (Headers, sidebar, primary actions)
- **Secondary (Workshop Orange)**: `#904d00` / `#ffa454` (FABs, primary CTAs, high priority buttons)
- **Background**: Light `#f8f9fb`, Dark `#12151C`
- **Typography**: 
  - Headings: `Sora` (sans-serif, bold/technical)
  - Body & Data: `Inter` (sans-serif, high legibility)
- **Status Badges (CRITICAL CONSISTENCY)**:
  - `pending`: Amber/Yellow badge (`bg-amber-100 text-amber-800 border-amber-300`)
  - `proses`: Blue badge (`bg-blue-100 text-blue-800 border-blue-300`)
  - `selesai`: Green badge (`bg-emerald-100 text-emerald-800 border-emerald-300`)

## 2. Mobile-First & Responsive Layout Guidelines
- **Breakpoints**: 375px (Mobile), 768px (Tablet), 1024px+ (Desktop)
- **Touch Ergonomics**: All interactive elements (buttons, inputs, cards) must have a minimum height of **44px** for gloved hands in workshop environments.
- **Desktop Grid**: Fixed sidebar (280px), main content topbar with search, breadcrumb, and user avatar.
- **Mobile Grid**: Collapsible hamburger sidebar menu, floating action buttons (FAB) in bottom-right for primary actions, list-cards instead of overflow tables.

## 3. Stitch HTML to Blade Conversion Reference
When implementing screens, refer to exports in `docs/stitch/`:
- **Login**: `docs/stitch/login_sibengkel_desktop` & `login_sibengkel_mobile`
- **Dashboard Admin**: `docs/stitch/dashboard_admin_sibengkel_desktop` & `dashboard_admin_sibengkel_mobile`
- **Dashboard Mekanik**: `docs/stitch/dashboard_mekanik_sibengkel_mobile`
- **Customers**: `docs/stitch/daftar_pelanggan_sibengkel_desktop` & `tambah_edit_pelanggan_sibengkel_desktop`
- **Vehicles**: `docs/stitch/daftar_kendaraan_sibengkel_desktop` & `tambah_edit_kendaraan_sibengkel_desktop`
- **Mechanics**: `docs/stitch/daftar_mekanik_sibengkel_desktop` & `tambah_edit_mekanik_sibengkel_desktop`
- **Transactions**: `docs/stitch/daftar_transaksi_servis_sibengkel_desktop` & `input_transaksi_baru_sibengkel_desktop`
- **Invoice**: `docs/stitch/nota_servis_sibengkel_desktop_print`

## 4. Blade Components Guidelines
- Create reusable components in `resources/views/components/`:
  - `<x-status-badge :status="$status" />`
  - `<x-kpi-card title="..." value="..." icon="..." />`
  - `<x-table>` / `<x-card-list>`
  - `<x-input-field>` with inline validation error handling (`@error(...)`).

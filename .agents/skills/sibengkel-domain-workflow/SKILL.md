---
name: sibengkel-domain-workflow
description: Business logic, service transaction lifecycle, user personas, domain rules, and academic evaluation rubric mapping for SIBENGKEL.
---

# SIBENGKEL Business Domain & Academic Requirements Skill

This skill defines the business domain workflow, operational lifecycle, user personas, and academic submission alignment for **SIBENGKEL**.

## 1. Core Business Workflow
1. **Customer Arrival**: Customer brings vehicle to workshop. Staff checks existing record or registers a new Customer and Vehicle.
2. **Service Transaction Logging**: Admin/Mekanik creates a new `ServiceTransaction` record:
   - Selects `Vehicle` (linked to `Customer`).
   - Assigns a `Mechanic`.
   - Records complaint / service request.
   - Sets initial status to `pending` and estimates cost.
3. **Pengerjaan & Status Lifecycle**:
   - `pending` (Antrean masuk)
   - `proses` (Mekanik actively repairing/servicing)
   - `selesai` (Work completed, ready for billing)
4. **Checkout & Invoice Printing**: Admin finalizes payment and prints invoice (`/transactions/{id}/invoice`).

## 2. User Personas & Permissions
- **Admin**: Workshop owner/manager. Needs high-level KPI dashboard, full access to user management, customer/vehicle records, mechanics, transaction reports.
- **Mekanik**: Technical field worker. Primary access via mobile device in workshop environment. Needs quick view of "Tugas Servis Hari Ini" and one-tap status updates (`pending` -> `proses` -> `selesai`).
- **Pelanggan**: End-user / Vehicle owner. Entitas data only (no login portal).

## 3. Academic Evaluation Rubric Alignment (Deadline: 27 July 2026)
- **Fungsionalitas (40%)**: Complete CRUD across 4 core entities (Users, Customers, Vehicles, ServiceTransactions/Mechanics).
- **Kualitas Kode (20%)**: Standard MVC architecture, Eloquent ORM, strict validation, clean codebase.
- **Tampilan & UX (15%)**: Mobile-first responsive design, modern UI aesthetics.
- **API & Keamanan (10%)**: Sanctum token auth, JSON standard response, role-based protection.
- **Hosting & Dokumentasi (10%)**: Live domain URL, GitHub repository cleanliness, PDF Report (BAB I-V).
- **Presentasi (5%)**: Seamless demo and team role clarity.

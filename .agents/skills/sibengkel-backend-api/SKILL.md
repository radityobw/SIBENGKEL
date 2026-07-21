---
name: sibengkel-backend-api
description: Architectural standards, database migrations, Eloquent models, RESTful API contracts (Sanctum), and RBAC security rules for the SIBENGKEL system.
---

# SIBENGKEL Backend & API Development Skill

> [!IMPORTANT]
> **MANDATORY PREREQUISITE**: Before executing any backend task (migrations, models, controllers, API endpoints, or middleware), you MUST inspect these authoritative documents:
> 1. [PRD_Sistem_Informasi_Bengkel.md](file:///Users/ryo/PemrogramanWeb/SIBENGKEL/SIBENGKEL/docs/PRD_Sistem_Informasi_Bengkel.md) (Section 6: ERD & Data Dictionary, Section 9: REST API Sanctum)
> 2. [README.md](file:///Users/ryo/PemrogramanWeb/SIBENGKEL/SIBENGKEL/README.md) (Fitur B: Database, Fitur C: Auth & RBAC, Fitur I: REST API)

## 1. Database Architecture & Migrations
- **Naming Conventions**: Plural table names (`customers`, `vehicles`, `mechanics`, `service_transactions`).
- **Foreign Keys**: Always define explicit constraints with cascading or restrict rules:
  - `vehicles.customer_id` -> `ON DELETE CASCADE`
  - `service_transactions.vehicle_id` -> `ON DELETE CASCADE`
  - `service_transactions.user_id` & `mechanic_id` -> `ON DELETE SET NULL`
- **Data Types**:
  - `cost`: `decimal(12, 2)` default `0.00`
  - `status`: `enum('pending', 'proses', 'selesai')` default `'pending'`
  - `type`: `enum('servis', 'penjualan')` default `'servis'`
  - `role`: `enum('admin', 'mekanik')` default `'mekanik'`

## 2. Eloquent Models & Relationships
- **Customer**: `hasMany(Vehicle::class)`
- **Vehicle**: `belongsTo(Customer::class)`, `hasMany(ServiceTransaction::class)`
- **Mechanic**: `hasMany(ServiceTransaction::class)`
- **ServiceTransaction**: `belongsTo(Vehicle::class)`, `belongsTo(User::class)`, `belongsTo(Mechanic::class)`

## 3. Role-Based Access Control (RBAC)
- Enforce `CheckRole` middleware on Web and API routes:
  - **Admin (`admin`)**: Full CRUD on `users`, `customers`, `vehicles`, `mechanics`, `transactions`.
  - **Mekanik (`mekanik`)**: Read/Create `customers`, full `vehicles`, `transactions` (Create & Update Status `pending` -> `proses` -> `selesai`). Restricted from user management and financial analytics.

## 4. RESTful API Standard (Laravel Sanctum)
- All API responses MUST return strict JSON with standard envelope structure:
```json
{
  "success": true,
  "message": "Human readable response message",
  "data": { ... }
}
```
- Standard HTTP status codes:
  - `200 OK`: Successful fetch / update
  - `201 Created`: Resource created
  - `401 Unauthorized`: Missing or invalid Sanctum token
  - `403 Forbidden`: Role permission denied
  - `422 Unprocessable Entity`: Validation failure

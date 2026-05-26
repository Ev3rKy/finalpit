# Wellmeadows Hospital Management System

## Project Description

A hospital management system for Wellmeadows Hospital with five integrated modules: Patient Management, Staff & Department Management, Ward & Bed Management, Appointments & Treatment, and Billing & Reporting. Staff log in using their hospital-issued badge ID and role selection.

---

## Team Members

| Name | Module |
|---|---|
| Chris | Module 1 – Patient Management |
| Erin | Module 2 – Staff & Department Management |
| Bello | Module 3 – Ward & Bed Management |
| Kyrvee | Module 4 – Appointments & Treatment |
| Kris | Module 5 – Billing & Reporting |

---

## Tech Stack

- **Laravel 12** – PHP framework
- **PHP 8.4** – Backend runtime
- **Blade + Tailwind CSS 4** – Frontend templating and styling
- **Vite** – Asset bundling
- **PostgreSQL** – Production database (Railway)
- **SQLite** – Local development database
- **Railway** – Cloud hosting and deployment

---

## Repository Link

https://github.com/Ev3rKy/finalpit

---

## Setup Instructions

```bash
git clone https://github.com/Ev3rKy/finalpit.git
cd finalpit

composer install
npm install

cp .env.example .env
php artisan key:generate
```

---

## Environment Variables

Update `.env` for local development:

```env
APP_NAME="Wellmeadows Hospital"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
```

For Railway / production (PostgreSQL):

```env
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}
DB_SSLMODE=require
```

---

## Run Migration & Seed

```bash
php artisan migrate
php artisan db:seed --force
```

---

## Start Development Server

In separate terminals:

```bash
# Terminal 1 – Laravel server
php artisan serve

# Terminal 2 – Vite (for frontend hot reload)
npm run dev
```

---

## Default Login

Login using staff badge ID + role selection (no password required — accounts are seeded):

| Role | Badge ID |
|---|---|
| Administrator | `ADMIN001` |
| Doctor | `DOC001` |
| Nurse | `NUR001` |
| Billing / Cashier | `BIL001` |

---

## Database Information

### Database Platform

Railway PostgreSQL (production) / SQLite (local development)

### Main Tables

| Table | Purpose | Module |
|---|---|---|
| `hospital_users` | Staff login accounts | Auth |
| `patients` | Patient demographics and records | 1 – Patient Management |
| `patient_medical_records` | Ward/bed assignments and stay records | 1 – Patient Management |
| `medications` | Prescribed medications linked to patients | 1 – Patient Management |
| `admissions` | Patient admission and discharge tracking | 1 – Patient Management |
| `staff` | Hospital staff roster | 2 – Staff & Department |
| `staff_qualifications` | Staff qualifications | 2 – Staff & Department |
| `staff_work_experience` | Staff work history | 2 – Staff & Department |
| `ward_staff_allocation` | Staff shift scheduling by ward | 2 – Staff & Department |
| `ward` | Ward definitions (shared source of truth) | 3 – Ward & Bed |
| `hospital_beds` | Individual bed records with status | 3 – Ward & Bed |
| `ward_roster` | Ward display roster | 3 – Ward & Bed |
| `appointments` | Scheduled patient appointments | 4 – Appointments |
| `treatment_records` | Clinical treatment records and vitals | 4 – Appointments |
| `staff_tasks` | Staff task assignments | 4 – Appointments |
| `portal_staff` | Separate portal accounts | 4 – Appointments |
| `bills` | Patient billing records | 5 – Billing |
| `billing_wards` | Ward mirror for billing (synced) | 5 – Billing |

---

## Module Assignment

| Module | Assigned Developer |
|---|---|
| Module 1 – Patient Management | Chris |
| Module 2 – Staff & Department Management | Erin |
| Module 3 – Ward & Bed Management | Bello |
| Module 4 – Appointments & Treatment | Kyrvee |
| Module 5 – Billing & Reporting | Kris |

---

## Deployment Information

### Live URL

```
https://finalpit-production.up.railway.app
```

### Hosting Platform

```
Railway
```

---

## Screenshots

(Add screenshots below)

### Login Page

![Login Page](screenshots/login.png)

### Dashboard

![Dashboard](screenshots/dashboard.png)

### CRUD Module

![CRUD Module](screenshots/crud.png)

### PostgreSQL Database Table

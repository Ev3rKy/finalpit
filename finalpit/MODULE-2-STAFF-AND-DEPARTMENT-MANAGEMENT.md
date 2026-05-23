# Module 2: Staff & Department Management

## Requirements
- PHP 8.2+
- Composer
- PostgreSQL (database: `wellmeadows`)

## Install
```bash
cd finalpit
composer install
cp .env.example .env
# Configure DB_CONNECTION=pgsql and database credentials in .env
php artisan key:generate
php artisan migrate
php artisan db:seed --class=WardSeeder
php artisan serve
```

## Features
- Staff records (CRUD)
- Staff registration
- Staff profile with qualifications and work experience
- Ward allocation (shift scheduling)

## URLs
- Staff Directory: http://localhost:8000/staff
- Add Staff: http://localhost:8000/staff/create
- Ward Allocation: http://localhost:8000/ward-allocation

## If migrations show "Ran" but a table is missing
```bash
php artisan db:table staff_work_experience
php artisan migrate:status
```
Re-run the specific migration file if needed, or contact the team before using `migrate:fresh` (deletes data).

# Baldur's Gate 3 Guide — Web Application

A centralised Laravel web platform for creating, organising, and accessing game guides for Baldur's Gate 3. Players can browse quests, character builds, strategies, and gameplay tips, while authorised editors and admins can manage all content.

---

## Requirements

- **PHP** 8.2+ (XAMPP recommended)
- **MySQL** 5.7+ or 8.0 (via XAMPP)
- **Composer** 2.x

---

## Setup Instructions

### 1. Clone the repository
`bash
git clone https://github.com/Marius55XD/Baldurs3_Guide.git
cd Baldurs3_Guide
`

### 2. Install PHP dependencies
`bash
composer install
`

### 3. Configure environment
`bash
copy .env.example .env
php artisan key:generate
`

Edit `.env` and confirm your XAMPP database credentials:
`
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bg3_guide
DB_USERNAME=root
DB_PASSWORD=
`

### 4. Create the database in phpMyAdmin or run:
`bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS bg3_guide CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
`

### 5. Run migrations and seed sample data
`bash
php artisan migrate --seed
`

Seeds: 4 categories, 4 sample guides, admin user (admin@bg3guide.com / password).

### 6. Start the server
`bash
php artisan serve
`
Visit http://localhost:8000

---

## User Roles
admin: full access | editor: create/edit guides & categories | user: browse only

Admin account: admin@bg3guide.com / password

Promote via Tinker:
`bash
php artisan tinker
# App\Models\User::where('email','you@example.com')->update(['role'=>'editor']);
`

---

## Technologies
- Laravel 11 | MySQL (XAMPP) | Bootstrap 5 CDN | Bootstrap Icons | Eloquent ORM | Blade

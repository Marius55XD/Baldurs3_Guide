# Baldur's Gate 3 Guide — Web Application

A centralised Laravel web platform for creating, organising, and accessing game guides for Baldur's Gate 3. Players can browse quests, character builds, strategies, and gameplay tips, while authorised editors and admins can manage all content.


https://github.com/user-attachments/assets/39c49e94-c3d2-403c-ae99-8ecc462097c9

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

For real email delivery, set `MAIL_MAILER=smtp` and use either Gmail (Google App Password) or Brevo SMTP.

#### Gmail option:
- Sender email must be a real Gmail mailbox you control.
- `MAIL_PASSWORD` must be the Google App Password generated after enabling 2-Step Verification.
- Typical values: `MAIL_SCHEME=smtps`, `MAIL_HOST=smtp.gmail.com`, `MAIL_PORT=465`.

#### Brevo option (used in this project):
- Typical values: `MAIL_SCHEME=tls`, `MAIL_HOST=smtp-relay.brevo.com`, `MAIL_PORT=587`.
- Use your Brevo SMTP login and key for `MAIL_USERNAME` and `MAIL_PASSWORD`.
- `MAIL_FROM_ADDRESS` should be a sender address verified in Brevo.

Mail setup note: copy the values from `.env.example`, then replace SMTP host, username, password, sender address, and `MAIL_CONTACT_TO` with your own working values. For local testing without real delivery, set `MAIL_MAILER=log`.

### 4. Create the database in phpMyAdmin or run:
`bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS bg3_guide CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
`

### 5. Run migrations and seed sample data
`bash
php artisan migrate --seed
`

Seeds: 4 categories, 32 sample guides, admin user (admin@bg3guide.com / password).

### 6. Start the server
`bash
php artisan serve
`
 Visit http://127.0.0.1:8000

---

## User Roles
admin: full access (users, roles, settings, all content) | editor: create/edit/delete guides & categories (no user/role management) | user: browse guides, purchase guides, and view own purchases

Admin account: admin@bg3guide.com / password

---

## Technologies
- Laravel 11 | MySQL (XAMPP) | Bootstrap 5 CDN | Bootstrap Icons | Eloquent ORM | Blade


## About Us
### Marius Stuopelis
### Bio:
2nd Year student studying a Bachelor (Hons) in Computing in Software Development at Dundalk Institute of Technology. I’ve built a solid foundation in programming and problem-solving through my coursework and projects. I also have experience in fast-paced, customer-facing roles, where I’ve developed strong communication and teamwork skills. In my free time, I enjoy working out and hanging out with friends. I’m aiming to become a software engineer in the future.

<a href="https://www.linkedin.com/in/marius-stuopelis-74477317a/">LinkedIn</a>

### Gvidonas Buikys 
### BIO 
Second-year Software Development (Level 8 Honours Bachelors) student. I have developed a solid foundation in programming, problem-solving, and software development through academic coursework and projects using technologies such as e.g. Java, JavaScript, SQL, React, HTML, Swift. I am a motivated and detail oriented individual with a strong sense of teamwork and communication skills demonstrated through group projects.  

<a href="https://www.linkedin.com/in/gvidonas-buikys-1bb7283b3/">LinkedIn</a>

# Dtrans Rental

**North Sumatra's Premier Car Rental & Tourism Platform**  
Built with Native PHP · MVC Architecture · MySQL

---

## Quick Start

### Requirements
- PHP 8.1+
- MySQL 8.0+
- Apache (XAMPP recommended for local dev)
- Composer

### 1. Clone & Install Dependencies

```bash
cd htdocs
git clone <repo-url> dtrans-rental
cd dtrans-rental
composer install
```

### 2. Configure Environment

```bash
cp .env .env
```

Edit `.env` with your local credentials:
- DB credentials
- Gmail SMTP app password ([guide](https://support.google.com/accounts/answer/185833))
- Google OAuth credentials ([console](https://console.cloud.google.com))
- Midtrans keys ([dashboard](https://dashboard.midtrans.com))

### 3. Create Database

Open phpMyAdmin or run:

```bash
mysql -u root -p < database/migrations/001_create_all_tables.sql
```

### 4. Apache Virtual Host (optional)

```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/dtrans-rental/public"
    ServerName dtrans.local
    <Directory "C:/xampp/htdocs/dtrans-rental/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Or access directly at: `http://localhost/dtrans-rental/public`

### 5. Default Admin Login

| Field    | Value                     |
|----------|---------------------------|
| Email    | admin@dtransrental.com    |
| Password | Admin@123                 |

> ⚠️ **Change this password immediately after first login.**

---

## Project Structure

```
dtrans-rental/
├── app/
│   ├── controllers/        # All controllers (one per feature area)
│   ├── models/             # Database models extending Model base
│   ├── views/              # PHP view templates
│   │   ├── layouts/        # main.php (customer), admin.php, auth.php
│   │   ├── auth/           # login, register, forgot, reset views
│   │   ├── cars/           # Car listing and detail views
│   │   ├── bookings/       # Booking flow views
│   │   ├── drivers/        # Driver listing view
│   │   ├── tourism/        # Tourism destination views
│   │   ├── admin/          # Admin panel views
│   │   └── errors/         # 403, 404, 500 error pages
│   ├── middleware/         # Auth, Admin, Driver middleware
│   ├── helpers/            # Mailer, etc.
│   └── core/               # App, Router, Controller, Model, Session, Env
│
├── config/                 # app.php, database.php
├── database/
│   └── migrations/         # SQL schema files
├── public/                 # Web root — index.php + .htaccess
│   ├── assets/css/         # app.css, admin.css
│   ├── assets/js/          # app.js, admin.js
│   └── uploads/            # cars/, drivers/, identities/, tourism/
├── routes/
│   └── web.php             # All routes defined here
├── storage/
│   ├── logs/               # Application logs
│   └── invoices/           # Generated PDF invoices (optional cache)
├── vendor/                 # Composer packages
├── composer.json
└── .env                    # Environment config (never commit)
```

---

## Development Phases

| Phase | Status | Description |
|-------|--------|-------------|
| Phase 1 | 🚧 In Progress | Core: Auth, Cars, Bookings, Drivers, Payments, Admin Dashboard |
| Phase 2 | ⏳ Planned | Tourism module, Maps, Reviews, PDF Invoice, Multilingual |
| Phase 3 | ⏳ Planned | AJAX realtime, Live chat, AI recommendations |

---

## Security Features

- ✅ Password hashing (bcrypt)
- ✅ CSRF protection on all POST forms
- ✅ XSS filtering via `htmlspecialchars()`
- ✅ SQL injection prevention via PDO prepared statements
- ✅ Secure session management
- ✅ Role-based middleware (Admin / Driver / Customer)
- ✅ Identity file upload validation (mime type + extension)
- ✅ `.htaccess` blocks `.env` and `composer.json` from public access

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Native PHP 8.1, MVC |
| Database | MySQL 8.0 |
| Frontend | Bootstrap 5, jQuery, AJAX |
| Auth | Manual + Google OAuth 2.0 |
| Email | Gmail SMTP via PHPMailer |
| Payment | Midtrans Payment Gateway |
| PDF | DomPDF |
| Maps | Google Maps Embed API |

---

## License

Proprietary — Dtrans Rental &copy; 2025

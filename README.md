# 🩹 Lumina Healthcare - Advanced Consultation Hub

**Lumina Healthcare** (formerly Medicare) is a premium, full-stack medical platform designed for seamless patient-doctor interactions and subscription-based healthcare management. Featuring a state-of-the-art "Bento-style" dashboard and secure financial integrations, Lumina represents the next generation of digital health.

---

## 🌟 Elite Features (A-Z)

- **Appointment Lifecycle**: Fully managed consultation queue with real-time status updates (Pending, Confirmed, Cancelled).
- **Bento Dashboard**: A modern, responsive user interface utilizing "bento-box" design principles for intuitive navigation.
- **CSRF Protection**: Military-grade security with global anti-forgery tokens on every form and action link.
- **Doctor Directory**: A curated list of **9 specialized medical professionals** with personal bios and high-resolution portraits.
- **Elite Neural Hub**: An exclusive biometric analytics dashboard for Elite members, featuring interactive system integrity monitoring.
- **Flexible Database**: Native support for **SQLite** (local development) and **MySQL/PostgreSQL** (production deployment).
- **GPay UPI Integration**: Direct "Scan to Pay" functionality featuring a custom Google Pay QR gateway.
- **Hardened Auth**: Secure session management with password hashing and auto-redirection based on user roles (Patient/Doctor).
- **Instant Chat**: Role-based communication channel (available for Professional and Elite tiers).
- **Payment Gateway**: Integrated **Stripe Checkout** for secure, encrypted Credit/Debit card transactions with automatic currency handling.
- **Subscription Tiers**: Three-tier system (Basic, Professional, Elite) with dynamic feature entitlement unlocking.

---

## 🏗️ Technical Stack

- **Backend**: PHP 8.x (Procedural/MVC Hybrid)
- **Frontend**: Vanilla CSS 3 (Custom Design System), HTML5 Semantic Tags, JavaScript (ES6+)
- **Database**: SQLite (built-in) / MySQL (production ready)
- **Security**: SHA-256 CSRF verification, Environment variable encapsulation
- **Payments**: Stripe API 2024, UPI Gateway

---

## 📂 Project Organization

```text
medicare-app/
├── backend/
│   ├── config/          # DB, Stripe, CSRF, and Env loaders
│   ├── controllers/     # Business logic (Auth, Appointments, Doctors)
│   ├── models/          # Data schemas (Entitlements, Users, Doctors)
├── database/            # SQL migration scripts (schema.sql)
├── public/              # Document Root (accessible files)
│   ├── assets/          # CSS, Images (QR, Portraits, Logos)
│   ├── components/      # Reusable UI fragments (Header, Footer)
│   └── *.php            # Feature pages (Dashboard, Checkout, Chat)
├── .env                 # Secret key management (Stripe, DB)
└── seed.php             # Automated data restoration script
```

---

## ⚙️ Quick Start (Local Development)

### 1. Requirements
- A local PHP environment (Included in `bin/php` for this project).

### 2. Configuration
Create/Edit your `.env` file in `medicare-app/`:
```env
STRIPE_PUBLISHABLE_KEY=pk_test_...
STRIPE_SECRET_KEY=sk_test_...
DB_DRIVER=sqlite
```

### 3. Database Setup
Run the seeder to restore all doctors, patients, and initial state:
```bash
php seed.php
```

### 4. Launch the Server
```bash
cd medicare-app
..\bin\php\php.exe -S localhost:8000 -t public
```
Visit: [http://localhost:8000](http://localhost:8000)

---

## 🔒 Security & Deployment

### Production Ready
Lumina is pre-configured for **Render** and **Vercel** via the included `vercel.json`.

### Deployment Checklist
- [x] Toggle Stripe to "Live Mode" and update `.env` keys.
- [x] Point `DB_DRIVER` to a production MySQL instance.
- [x] Ensure your hosting provider supports PHP 8.x.
- [x] Configure your SMTP provider in `EmailHelper.php` for real notifications.

---

## 📜 Disclaimer
*Lumina Healthcare is an advanced portfolio demonstration project. It is not intended for real-world medical diagnosis or handling sensitive patient health information (PHI).*

**Built with precision and security for the modern web.**

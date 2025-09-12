# Sumati Balwan / RHPM Sanstha Website

A simple website for Radhabai Hardikar Pranjjat Mangal Sanstha (Sumati Balwan) featuring static pages, a donation system, and basic admin/user management with PHP and SQLite.

## Features

- Informational pages: About, Contact, Gallery, Awards, Trustees, and more
- Donation flow with online form and screenshot upload
- Admin-only donation listing (password protected)
- User management API (CRUD) with SQLite backend
- Responsive design using Bootstrap and Tailwind (CDN)
- Image galleries and awards showcase

## Tech Stack

- **Frontend:** HTML, CSS, JavaScript (vanilla)
- **Styling:** Custom CSS (`lib/css/`), Bootstrap, Tailwind (CDN)
- **Backend:** PHP 8+ (PDO SQLite)
- **Database:** SQLite (`donation/database.sqlite`, `api/users.sqlite`)

## Project Structure

```
/
├── index.html, aboutP.html, aboutS.html, contact.html, gallery.html, awards.html, trustees.html, working.html, new.html
├── css/                # Additional styles
├── js/                 # JavaScript files
├── images/, assets/    # Images and icons
├── donation/
│   ├── donate.html, donateNow.html
│   ├── process-donation.php, list-donations.php
│   ├── database.sqlite
│   ├── get_exchange_rate.php, process_donation-old.php
├── api/
│   ├── api.php, index.php, config.php, users.sqlite
├── stories/            # Personal stories (HTML)
├── admin.html          # LocalStorage-based admin dashboard
├── README.md
```

## Getting Started

### Prerequisites

- PHP 8.0+ with SQLite PDO extension enabled

### Running Locally

```bash
php -S localhost:8000 -t .
# Visit http://localhost:8000/
```

- Ensure PHP can read/write the `.sqlite` files in `donation/` and `api/`.

### Donation Flow

- **Donate:** `donation/donate.html` → `donation/donateNow.html`
- **Processing:** `donation/process-donation.php` (handles form, uploads screenshot as BLOB)
- **Admin List:** `donation/list-donations.php` (password protected)
- **Thank You/Error:** `donation/donation-thank-you.html`, `donation/donation-error.html`

### User API

- **List users:** `GET /api/api.php`
- **Create user:** `POST /api/api.php` (JSON: `{ "name": "...", "email": "..." }`)
- **Update user:** `PUT /api/api.php` (JSON: `{ "id": ..., "name": "...", "email": "..." }`)
- **Delete user:** `DELETE /api/api.php` (JSON: `{ "id": ... }`)
- **UI:** `/api/index.php`

### Admin Dashboard

- `admin.html` displays donation form data from browser `localStorage` (not server DB).

## Security & Deployment

- Password-protected donation list (`donation/list-donations.php`)
- Validate and sanitize all inputs server-side
- Ensure `.sqlite` files are not publicly accessible
- For production, consider adding CSRF protection and disabling directory listings

## Contributing

1. Fork or create a feature branch
2. Make changes and test locally
3. Commit and push a PR

---

© Radhabai Hardikar Pranjjat Mangal Sanstha (Sumati Balwan)
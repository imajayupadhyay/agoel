# Anmol Pushjai Goel Website

Laravel 12 conversion of the supplied three-page static website.

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

Open `http://127.0.0.1:8000`.

## Public routes

- `/` — Home
- `/industries` — Industries
- `/philanthropy` — Philanthropy and governance
- `/sanchalak` — Admin login
- `/sanchalak/dashboard` — Protected admin dashboard
- `/sitemap.xml` — XML sitemap
- `/robots.txt` — Dynamic robots file

## Production

Set these values in `.env` before deployment:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com
```

Then run:

```bash
composer install --no-dev --optimize-autoloader
php artisan optimize
```

The site does not require a database for normal page requests.

## Static source import

The original HTML was imported with:

```bash
php scripts/import-static.php
```

Running the importer again regenerates the three Blade views and their page-specific CSS/JavaScript from the source files in `../html`.

# MyHoliday Itinerary Generator

A PHP web app for building a holiday itinerary. Search destinations and activities, add them to a planner, remove what you don't need, and print the final plan.

## Tech stack

- PHP 8.2 (PDO)
- PostgreSQL (hosted on [Neon](https://neon.tech))
- HTML, CSS, Bootstrap 5
- jQuery
- Docker and Apache for local development
- Vercel for deployment (via the `vercel-php` community runtime)

## Screenshots

### Search results
![Search results](https://raw.githubusercontent.com/haingo-raz/MyHoliday-Itinerary-Generator/master/public/assets/search_results.png)

### Planner
![Planner](https://raw.githubusercontent.com/haingo-raz/MyHoliday-Itinerary-Generator/master/public/assets/sample_planner.png)

## Project layout

```
.
├── api/                PHP entry points (serverless functions on Vercel)
│   ├── index.php
│   ├── planner.php
│   ├── addDestination.php
│   └── deleteDestination.php
├── public/             Static assets served at the web root
│   ├── css/
│   ├── js/
│   └── assets/
├── src/
│   └── db.php          PDO factory, reads DATABASE_URL
├── sql/
│   ├── schema.sql
│   └── seed_destination.sql
├── .env.example
├── .htaccess           Local Apache routing (mirrors vercel.json)
├── Dockerfile
├── docker-compose.yml
└── vercel.json
```

## Prerequisites

- A Neon PostgreSQL project (free tier works)
- Docker Desktop (recommended for local dev) or PHP 8.2+ with the `pdo_pgsql` extension and Apache
- For deployment: a Vercel account and the Vercel CLI (optional)

## Database setup (Neon)

1. Create a project at [neon.tech](https://neon.tech).
2. Open the **Connection Details** panel and copy the connection string. It looks like:
   `postgresql://neondb_owner:PASSWORD@ep-xxxx.region.aws.neon.tech/neondb?sslmode=require`
3. In the Neon SQL editor, run the contents of [sql/schema.sql](sql/schema.sql), then [sql/seed_destination.sql](sql/seed_destination.sql).

## Local development

### Option A: Docker (recommended)

1. Copy the env file and paste your Neon connection string:
   ```bash
   cp .env.example .env
   ```
   Edit `.env` so `DATABASE_URL` equals your Neon URL.
2. Start the container:
   ```bash
   docker compose up --build
   ```
3. Open http://localhost:8080.

### Option B: Apache + PHP (XAMPP or similar)

1. Enable the `pdo_pgsql` extension in `php.ini`.
2. Point your virtual host's `DocumentRoot` at the project root and make sure `AllowOverride All` is set so `.htaccess` is read.
3. Make sure `mod_rewrite` is enabled.
4. Copy `.env.example` to `.env` and set `DATABASE_URL`.
5. Open the configured URL in your browser.

## Deployment (Vercel)

1. Push the project to GitHub.
2. In Vercel, click **Add New Project** and import the repository.
3. Framework preset: **Other**. Leave build and output settings at their defaults.
4. Under **Environment Variables**, add `DATABASE_URL` with your Neon connection string.
5. Click **Deploy**.

Alternatively, with the Vercel CLI:
```bash
vercel link
vercel env add DATABASE_URL
vercel deploy --prod
```

### URL routing

| Route | Handler |
|---|---|
| `/` | `api/index.php` |
| `/planner` or `/planner.php` | `api/planner.php` |
| `/api/addDestination.php` | `api/addDestination.php` |
| `/api/deleteDestination.php` | `api/deleteDestination.php` |
| `/css/*`, `/js/*`, `/assets/*` | `public/*` |


# SWMS - Smart Waste Management System

Server-rendered PHP application for the Kawempe (KCCA) division: IoT bin
monitoring, citizen incident reporting, and an admin dashboard.

## Project structure

```
public/            Web root - PHP pages, CSS, JS, images
  includes/         Shared header/footer partials
  assets/           css/, js/, images/
config/
  database.php      DB connection, reads credentials from environment variables
database/
  schema.sql        Table definitions (run once on a fresh database)
docker/             Apache vhost, php.ini overrides, container entrypoint
Dockerfile
.env.example        Template for local environment variables
```

## Why one service, not two

The app is server-rendered PHP: every page queries the database and outputs
HTML directly (no JSON API). There's no separate "frontend build" to deploy -
the PHP files *are* the frontend. So this ships as a single Render **Web
Service** running the Dockerfile below, with `public/` as the web root and
`config/` holding the database bootstrap. Splitting this into a separate
static frontend + API backend would require rewriting every page as a fetch()
call against JSON endpoints - a much larger change than "prepare for
production."

## Local development

1. Copy `.env.example` to `.env` and fill in your local MySQL credentials.
2. Import `database/schema.sql` into a fresh database.
3. Run the built-in PHP server from the project root:
   ```
   php -S localhost:8000 -t public
   ```
4. Visit `http://localhost:8000`. Register the first admin account at
   `/register.php` using one of the authorized IDs in `public/register.php`
   (`KCCA01`-`KCCA05`).

## Deploying to Render

Render has no managed MySQL - only Postgres, Redis, and disks - so you need
an external MySQL host. Options: keep using your existing InfinityFree
database, or move to a managed MySQL provider (PlanetScale, Aiven, Railway,
AWS RDS, etc.). Whichever you pick, you just need a host/port/user/password/
database name reachable from Render.

1. **Push this repo to GitHub** (if not already there).
2. **Create the database** by running `database/schema.sql` against your
   MySQL host.
3. In Render, click **New > Web Service**, connect the repo, and choose
   **Docker** as the runtime (Render will detect the `Dockerfile`
   automatically).
4. Add environment variables in the service's **Environment** tab:
   - `DB_HOST`
   - `DB_USER`
   - `DB_PASSWORD`
   - `DB_NAME`
   - `DB_PORT` (usually `3306`)
   - `IOT_API_KEY` - a secret string your bin sensors must send as
     `?key=...` when calling `update_bin.php`. Required in production;
     leaving it unset disables the check.
5. Deploy. Render sets `PORT` automatically; `docker/entrypoint.sh` points
   Apache at it on container start, so no manual port configuration is
   needed.
6. Once live, visit `/register.php` to create the first admin account (no
   credentials are seeded by `schema.sql`).

## Security notes carried over from the original build

- Passwords are hashed with `password_hash()`/`password_verify()` (bcrypt).
- All queries now use prepared statements.
- `dashboard.php` now requires an authenticated admin session (previously
  publicly viewable).
- `update_bin.php` now supports a shared-secret `IOT_API_KEY` check
  (previously an open, unauthenticated write endpoint).
- Database errors are logged server-side (`error_log`) instead of being
  shown to visitors.

# Breezy — Team D (Merged Front + Auth + Favorites)

## Quick Start (XAMPP)

1. Copy this folder into `C:\xampp\htdocs\Breezy`.
2. In `config.php` and set DB + `OPENWEATHER_API_KEY`. or leave it
3. Create database and tables:
   - Create DB `weatherloop` in phpMyAdmin
   - Import `sql/schema.sql`
4. Start Apache + MySQL in XAMPP.
5. Visit `http://localhost/Breezy/index.php`

## Files

- `index.php` — original UI preserved + added:
  - Login/Sign up/Logout + **“Don’t have an account? Sign up”** inside the login modal
  - About modal (Team D)
  - Favorites panel (show/hide)
  - Weather proxy usage
- `php/connection.php` — PDO connection
- `php/register.php` — POST JSON `{full_name,email,password}`
- `php/login.php` — POST JSON `{email,password}`
- `php/logout.php` — destroys session
- `php/me.php` — returns current user `{user_id,full_name,email}` or `null`
- `php/favorites.php` — GET `?action=list` or POST JSON `{action:add/remove,...}`
- `php/weather.php` — proxies to OpenWeather (keeps key private)
- `sql/schema.sql` — MySQL tables
- `config.php` set credentials

## Swapping in the team’s assets

- Keep `weatherloop-logo.png` and `weatherloop-favicon.png` in the web root.
- If their JS updates hourly/daily cards, **leave it**; our code updates only the “current” area and small metrics to avoid conflicts.
- If they had `index.html`, just replace it with this `index.php` (or add this file alongside and use it).

## API Notes

- All auth/favorites endpoints speak JSON and use PHP sessions.
- Weather uses OpenWeather Current Weather API. You can later extend to One Call for hourly/daily and fill the “Today/Next days” rows from server results.

## Security Notes

- Passwords hashed with `password_hash` (bcrypt).
- Prepared statements everywhere.
- CORS not needed (same origin).

## Next Steps (optional polish)

- Add CSRF tokens to POSTs.
- Rate‑limit favorites add/remove.
- Migrate weather provider to Open‑Meteo if desired (free/no key) and adapt `php/weather.php`.

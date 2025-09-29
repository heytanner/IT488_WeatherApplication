# IT488 Weather Application (Breezy)
Team D – Purdue Global (IT488-01, 2504B).

**Highlights**: City search, GPS fetch, Open-Meteo, radar embed, login modal, favorites (localStorage).

# Breezy — IT488 Weather Application

A sprint-driven, front-end weather app for Purdue Global IT488 (Team D). Breezy provides current conditions, a radar view, and progressive enhancements (login, favorites, compass) using the Open-Meteo API and an embedded Windy radar.

---

## Current Status — Sprint 2 · Week 2
**Goal:** deliver radar integration, login form + logic, compass placeholder, and begin QA testing.

**In progress this week**
- Compass placeholder under the current conditions.
- Login modal + JavaScript logic (front-end only).
- QA pass for search, GPS, theme, units; log issues in GitHub.

---

## Features (as of Sprint 2)
- City search and GPS lookup (Open-Meteo geocoding + browser geolocation)
- Current conditions panel with key metrics
- Radar map via Windy embed
- Theme and unit toggle (°F/°C with persistence)
- Login modal and client-side auth scaffold (local/session storage)
- **Favorites ♥** (ahead of backlog): save/remove cities per signed-in user in `localStorage` (`breezy:favs:<email>`)

---

## Burndown — Sprint 2
The burndown tracks remaining story points across the 10 working days of the sprint.

![Sprint 2 Burndown](docs/burndown-sprint2.png)

> **Tip:** If you update numbers during the sprint, replace the PNG with a new export and commit.

---

## QA Checklist — Sprint 2
See the full test list and acceptance checks:

- [`docs/qa-checklist-sprint2.md`](docs/qa-checklist-sprint2.md)

---

## Tech Stack
- **Frontend:** HTML5, Tailwind (CDN), vanilla JavaScript  
- **APIs:** Open-Meteo (forecast + geocoding)  
- **Maps:** Windy embedded radar  
- **Storage:** `localStorage` / `sessionStorage` (auth + favorites)

---

## Run Locally
1. Clone the repo.
2. Open `index.html` in a modern browser (or serve with any static server).
3. Allow location permission to test GPS (“Use my location”).

_No build step or API keys required._

---

## Architecture Notes
- **Data flow:** UI input → geocoding → forecast fetch → UI render.  
- **Auth:** front-end only; users at `breezyUsers`, session at `breezySession` (remember-me → `localStorage`, else `sessionStorage`).  
- **Favorites:** per-user array `breezy:favs:<email>` with `{ name, lat, lon }`.

---

## Roadmap
- **Sprint 2 (now):** radar, login form + logic, compass placeholder, QA start.  
- **Sprint 3:** favorites UX, daily forecast polish, compass needle bound to wind, cross-browser checks.  
- **Sprint 4:** branding and splash; alerts; final QA and packaging.

---

## Contributors
Team D (Alisa Roberts, Rylie Evans, Tanner Smith, Sedjro Tovihouande) — Breezy Project


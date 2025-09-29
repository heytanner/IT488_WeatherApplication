# QA Checklist — Sprint 2 (Week 2)

**Scope**: Radar embed, Login modal + JS, Unit toggle, Theme toggle, GPS lookup, Search, Favorites (localStorage), Compass placeholder.

## Test Matrix

### Search & Geocoding
- [ ] City name returns a valid location via Open‑Meteo geocoding.
- [ ] Enter key triggers search.
- [ ] Unknown city shows a helpful error.

### GPS / Location
- [ ] Permission prompt appears; denial shows graceful error.
- [ ] On allow, weather renders for current coordinates.
- [ ] Radar centers near GPS location.

### Current Conditions Panel
- [ ] Date/time updates on fetch.
- [ ] Temperature, feels like, hi/lo display in selected unit.
- [ ] Wind, humidity, pressure, visibility show non‑placeholder values.

### Hourly / Daily (In‑progress UI)
- [ ] Hourly row renders at least one tile.
- [ ] “Next days” block shows today row without layout breakage.

### Theme & Units
- [ ] Theme toggle flips the glass/dark classes consistently.
- [ ] Unit toggle °F/°C persists in localStorage and re‑applies after refresh.

### Login Modal
- [ ] Opens from header button; close (×) works.
- [ ] Validation blocks empty email/password.
- [ ] Create account path stores user in localStorage (`breezyUsers`).
- [ ] Remember me stores session in localStorage; otherwise sessionStorage.
- [ ] After login, header button shows “Logout”.

### Favorites ♥ (Ahead of backlog)
- [ ] Heart shows `♡` when not saved; `♥` when saved.
- [ ] Click saves/removes `{name, lat, lon}` in `breezy:favs:<email>`.
- [ ] Requires sign‑in; if not signed in, opens login modal.

### Radar (Windy Embed)
- [ ] Iframe loads with no mixed‑content warnings.
- [ ] Location updates when a new city/GPS is selected.
- [ ] Page remains responsive while iframe loads.

### Performance & Resilience
- [ ] No unhandled promise rejections in DevTools console.
- [ ] Network offline → friendly error; app does not crash.
- [ ] Basic Lighthouse pass (Performance/Accessibility > 80).

## Known Issues / Notes
- [ ] Compass is a placeholder (needle not bound to wind yet).
- [ ] Hourly/daily views minimal; polish planned for Sprint 3.

## Test Artifacts
- Screenshots or recordings of each feature.
- Browser/OS matrix used for testing.
- Issue links (if any) in GitHub Issues with repro steps.

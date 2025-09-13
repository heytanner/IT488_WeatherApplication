<?php /* index.php — Weather Loop (merged) */
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Breezy - Weather App</title>
  <link rel="icon" type="image/png" href="weatherloop-favicon.png" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .glass{background:rgba(255,255,255,.14);}
    .glass-dark{background:rgba(0,0,0,.22);}
    .text-shadow{ text-shadow: 0 2px 12px rgba(0,0,0,.45) }
    .hide-scroll::-webkit-scrollbar{ display:none }
    .hide-scroll{ -ms-overflow-style:none; scrollbar-width:none }
  </style>
</head>
<body class="min-h-screen text-white font-sans selection:bg-white/20">
  <!-- background -->
  <div class="fixed inset-0 -z-10 bg-gradient-to-br from-sky-500 via-blue-600 to-indigo-700"></div>

  <div class="mx-auto max-w-5xl px-4 py-6">
    <!-- header -->
    <header class="flex flex-col items-center gap-4">
      <img src="weatherloop-logo.png" alt="Weather Loop logo"
           class="h-24 w-auto select-none"
           onerror="this.style.display='none'"/>

      <div class="flex items-center gap-2">
        <button id="unitBtn" class="glass hover:bg-white/25 active:scale-95 transition rounded-2xl px-3 py-2 text-sm">°F</button>
        <button id="themeBtn" class="glass hover:bg-white/25 active:scale-95 transition rounded-2xl px-3 py-2 text-sm">Theme</button>
        <a href="#about" id="aboutBtn" class="glass hover:bg-white/25 rounded-2xl px-3 py-2 text-sm">About</a>

        <!-- Added auth controls (minimal intrusion) -->
        <button id="registerBtn" class="glass rounded-2xl px-3 py-2 text-sm">Sign up</button>
        <button id="loginBtn" class="glass rounded-2xl px-3 py-2 text-sm">Login</button>
        <button id="logoutBtn" class="hidden glass rounded-2xl px-3 py-2 text-sm">Logout</button>
        <span id="helloUser" class="ml-2 text-sm opacity-90"></span>
        <button id="favoritesBtn" class="hidden glass rounded-2xl px-3 py-2 text-sm">My Favorites</button>
      </div>
    </header>

    <!-- search -->
    <section class="mt-4">
      <div class="glass rounded-3xl p-2">
        <div class="flex items-center gap-2">
          <input id="city" class="w-full bg-transparent outline-none placeholder-white/70 py-2" placeholder="Search city" />
          <button id="useGps" class="glass rounded-2xl px-3 py-2">GPS</button>
          <button id="go" class="bg-white text-gray-900 rounded-2xl px-4 py-2 font-medium">Search</button>
        </div>
      </div>
      <p class="mt-2 text-white/80 text-sm">Try: Indianapolis, Chicago, New York</p>
    </section>

    <!-- current -->
    <section class="mt-6 grid gap-4 md:grid-cols-3">
      <div class="md:col-span-2 rounded-3xl glass p-6">
        <div class="flex items-end justify-between">
          <div>
            <div id="place" class="text-xl sm:text-2xl font-medium">City</div>
            <div id="dateNow" class="mt-1 text-white/80">Today</div>
            <div class="mt-6 flex items-center gap-4">
              <div id="temp" class="text-7xl sm:text-8xl leading-none">--°</div>
              <div class="space-y-1">
                <div id="summary" class="text-lg">Ready</div>
                <div id="feels" class="text-white/80 text-sm">Feels like --°</div>
                <div id="hiLo" class="text-white/80 text-sm">H --°  L --°</div>
              </div>
            </div>
          </div>
          <div id="bigIcon" class="text-7xl sm:text-8xl">☀️</div>
        </div>
      </div>
      <div class="rounded-3xl glass p-6">
        <dl class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
          <div><dt class="opacity-80">Wind</dt><dd id="windVal" class="text-lg">-- mph</dd></div>
          <div><dt class="opacity-80">Humidity</dt><dd id="humVal" class="text-lg">--%</dd></div>
          <div><dt class="opacity-80">Pressure</dt><dd id="pressVal" class="text-lg">-- hPa</dd></div>
          <div><dt class="opacity-80">Visibility</dt><dd id="visVal" class="text-lg">-- km</dd></div>
        </dl>
      </div>
    </section>

    <!-- hourly -->
    <section class="mt-6">
      <h2 class="mb-3 text-lg font-medium">Today</h2>
      <div class="hide-scroll overflow-x-auto whitespace-nowrap rounded-3xl glass p-3">
        <div id="hourRow" class="flex gap-3">
          <div class="w-20 shrink-0 rounded-2xl bg-white/10 text-center py-3">
            <div class="text-sm opacity-90">--</div>
            <div class="text-2xl">☁️</div>
            <div class="mt-1 text-lg">--°</div>
          </div>
        </div>
      </div>
    </section>

    <!-- daily -->
    <section class="mt-6">
      <h2 class="mb-3 text-lg font-medium">Next days</h2>
      <div id="daily" class="rounded-3xl glass">
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/10">
          <div class="w-32">Today</div>
          <div class="text-2xl">⛅</div>
          <div class="w-24 text-right">--°</div>
          <div class="w-24 text-right opacity-80">--°</div>
        </div>
      </div>
    </section>

    <!-- favorites (collapsed by default) -->
    <section id="favoritesPanel" class="hidden mt-8 glass rounded-2xl p-5">
      <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold">My Favorites</h2>
        <button id="refreshFavBtn" class="text-sm underline">Refresh</button>
      </div>
      <div id="favoritesList" class="mt-4 space-y-3"></div>
    </section>

    <!-- footer -->
    <footer class="mt-10 pb-10 text-white/80 text-sm text-center">
      Data by Open Meteo and Nominatim. <br />
      IT488-01 | 2504B August 2025 Term - Purdue University Global - Team D - Weather App Project.
    </footer>
  </div>

  <!-- ===== About Modal ===== -->
  <div id="aboutModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center">
    <div class="bg-white text-black rounded-2xl max-w-lg w-full p-6">
      <div class="flex items-center justify-between">
        <h3 class="font-semibold text-xl">About • Breezy (Team D)</h3>
        <button id="aboutClose" class="px-2 py-1 rounded hover:bg-black/10">✕</button>
      </div>
      <p class="mt-2 text-sm opacity-80">
        Breezy lets anyone view forecasts. Signed-in users can save favorite locations.
      </p>
      <div id="teamList" class="mt-4 space-y-3"></div>
    </div>
  </div>

  <!-- ===== Auth overlay ===== -->
  <div id="authShade" class="hidden fixed inset-0 bg-black/50 z-40"></div>

  <!-- ===== Register Modal ===== -->
  <div id="registerModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-white text-black rounded-2xl shadow-xl w-full max-w-md p-6">
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-xl font-semibold">Create account</h3>
        <button type="button" class="px-2 py-1 rounded hover:bg-black/10" onclick="closeModal('registerModal')">✕</button>
      </div>
      <form id="registerForm" class="space-y-3">
        <div>
          <label class="text-sm">Full name</label>
          <input name="full_name" class="w-full mt-1 rounded-2xl px-3 py-2 border border-black/10" placeholder="John Doe" required />
        </div>
        <div>
          <label class="text-sm">Email</label>
          <input type="email" name="email" class="w-full mt-1 rounded-2xl px-3 py-2 border border-black/10" placeholder="you@example.com" required />
        </div>
        <div>
          <label class="text-sm">Password</label>
          <input type="password" name="password" class="w-full mt-1 rounded-2xl px-3 py-2 border border-black/10" minlength="6" required />
        </div>
        <div>
          <label class="text-sm">Confirm password</label>
          <input type="password" name="confirm" class="w-full mt-1 rounded-2xl px-3 py-2 border border-black/10" minlength="6" required />
        </div>
        <div class="pt-2 flex items-center justify-between gap-2">
          <span class="text-sm text-black/70">Already have an account? <a href="#" id="toLogin" class="underline">Sign in</a></span>
          <div>
            <button type="button" class="px-3 py-2 rounded-2xl" onclick="closeModal('registerModal')">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded-2xl bg-blue-600 text-white">Register</button>
          </div>
        </div>
        <p id="registerError" class="text-sm text-red-600"></p>
      </form>
    </div>
  </div>

  <!-- ===== Login Modal ===== -->
  <div id="loginModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="bg-white text-black rounded-2xl shadow-xl w-full max-w-md p-6">
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-xl font-semibold">Sign in</h3>
        <button type="button" class="px-2 py-1 rounded hover:bg-black/10" onclick="closeModal('loginModal')">✕</button>
      </div>
      <form id="loginForm" class="space-y-3">
        <div>
          <label class="text-sm">Email</label>
          <input type="email" name="email" class="w-full mt-1 rounded-2xl px-3 py-2 border border-black/10" placeholder="you@example.com" required />
        </div>
        <div>
          <label class="text-sm">Password</label>
          <input type="password" name="password" class="w-full mt-1 rounded-2xl px-3 py-2 border border-black/10" required />
        </div>
        <div class="pt-2 flex items-center justify-between gap-2">
          <span class="text-sm text-black/70">Don’t have an account? <a href="#" id="toRegister" class="underline">Sign up</a></span>
          <div>
            <button type="button" class="px-3 py-2 rounded-2xl" onclick="closeModal('loginModal')">Cancel</button>
            <button type="submit" class="px-4 py-2 rounded-2xl bg-blue-600 text-white">Login</button>
          </div>
        </div>
        <p id="loginError" class="text-sm text-red-600"></p>
      </form>
    </div>
  </div>

  <script>
    /* ---------- Helpers ---------- */
    const $ = s => document.querySelector(s);
    const $$ = s => Array.from(document.querySelectorAll(s));

    function wmEmoji(code){
      // Open-Meteo WMO weather codes -> emoji
      if (code==0) return '☀️';
      if ([1,2,3].includes(code)) return '⛅';
      if ([45,48].includes(code)) return '🌫️';
      if ([51,53,55,56,57].includes(code)) return '🌦️';
      if ([61,63,65,80,81,82].includes(code)) return '🌧️';
      if ([71,73,75,77,85,86].includes(code)) return '🌨️';
      if ([95,96,99].includes(code)) return '⛈️';
      return '☁️';
    }

    function fmtHourLabel(ts){ // '2025-04-20T15:00' -> '3 PM'
      const d = new Date(ts);
      let h = d.getHours();
      const ampm = h>=12 ? 'PM' : 'AM';
      h = h % 12 || 12;
      return `${h} ${ampm}`;
    }

    function fmtDayLabel(iso){ // '2025-04-20' -> 'Sun' or 'Today'
      const d = new Date(iso + 'T00:00:00');
      const today = new Date();
      const sameDay = d.toDateString() === today.toDateString();
      return sameDay ? 'Today' : d.toLocaleDateString(undefined, { weekday:'short' });
    }

    function renderHourly(hours){
      const row = document.getElementById('hourRow');
      if (!row) return;
      const today = new Date().toISOString().slice(0,10); // YYYY-MM-DD
      const fromNow = Date.now();
      const todays = hours.filter(h => h.time.startsWith(today) && new Date(h.time).getTime() >= fromNow).slice(0,12);

      if (!todays.length){
        row.innerHTML = `<div class="w-20 shrink-0 rounded-2xl bg-white/10 text-center py-3 opacity-70">
          <div class="text-sm">--</div><div class="text-2xl">☁️</div><div class="mt-1 text-lg">--°</div></div>`;
        return;
      }

      row.innerHTML = todays.map(h => `
        <div class="w-20 shrink-0 rounded-2xl bg-white/10 text-center py-3">
          <div class="text-sm opacity-90">${fmtHourLabel(h.time)}</div>
          <div class="text-2xl">${wmEmoji(h.code)}</div>
          <div class="mt-1 text-lg">${Math.round(h.temp)}°</div>
        </div>`).join('');
    }

    function renderDaily(days){
      const box = document.getElementById('daily');
      if (!box || !days.length) return;
      box.innerHTML = days.slice(0,7).map(d => `
        <div class="flex items-center justify-between px-5 py-4 border-b border-white/10 last:border-b-0">
          <div class="w-32">${fmtDayLabel(d.date)}</div>
          <div class="text-2xl">${wmEmoji(d.code)}</div>
          <div class="w-24 text-right">${Math.round(d.tmax)}°</div>
          <div class="w-24 text-right opacity-80">${Math.round(d.tmin)}°</div>
        </div>`).join('');
    }


    /* ---------- Existing buttons ---------- */
    const unitBtn = document.getElementById('unitBtn');
    const themeBtn = document.getElementById('themeBtn');
    let tempUnit = localStorage.getItem('unit') || 'fahrenheit';
    unitBtn.textContent = tempUnit === 'fahrenheit' ? '°F' : '°C';

    unitBtn.addEventListener('click', () => {
      tempUnit = tempUnit === 'fahrenheit' ? 'celsius' : 'fahrenheit';
      unitBtn.textContent = tempUnit === 'fahrenheit' ? '°F' : '°C';
      localStorage.setItem('unit', tempUnit);
      instantToggleUI();
    });

    themeBtn.addEventListener('click', () => {
      document.body.classList.toggle('dark-theme');
      document.querySelectorAll('.glass').forEach(c => c.classList.toggle('glass-dark'));
    });

    /* ---------- Added: About ---------- */
    const TEAM_D = [
      { name: 'Evans, Rylie', role: 'Scrum Master, Developer' },
      { name: 'Robests, Alisa', role: 'Full Stack Developer' },
      { name: 'Smith, Tanner', role: 'Product Owner, Frontend Developer' },
      { name: 'Tovihouande, Sedjro', role: 'Backend Developer' },
    ];
    function renderTeam(){
      const box = document.getElementById('teamList'); if (!box) return; box.innerHTML='';
      TEAM_D.forEach(m => {
        const row = document.createElement('div');
        row.className = 'flex items-start gap-3';
        row.innerHTML = `<div class="mt-1">🌤</div>
          <div><div class="font-medium">${m.name}</div><div class="text-sm opacity-80">${m.role}</div></div>`;
        box.appendChild(row);
      });
    }
    const aboutBtn = document.getElementById('aboutBtn');
    if (aboutBtn) aboutBtn.addEventListener('click', (e)=>{
      if (aboutBtn.getAttribute('href')==='#about') e.preventDefault();
      renderTeam();
      const m = document.getElementById('aboutModal'); m.classList.remove('hidden'); m.classList.add('flex');
    });
    document.getElementById('aboutClose').onclick = () => {
      const m = document.getElementById('aboutModal'); m.classList.add('hidden'); m.classList.remove('flex');
    };

    /* ---------- New Auth / Favorites state ---------- */
    const helloUser = $('#helloUser');
    const logoutBtn = $('#logoutBtn');
    const favoritesBtn = $('#favoritesBtn');
    const favoritesPanel = $('#favoritesPanel');
    const favoritesList = $('#favoritesList');

    const WL = {
      user: null,
      units: (localStorage.getItem('wl_units') || (tempUnit==='fahrenheit'?'imperial':'metric')),
      last: null,
      cache: new Map()
    };

    function applyUnitLabel(){ unitBtn.textContent = (WL.units==='imperial') ? '°F' : '°C'; }
    function instantToggleUI(){
      // Update small metric spots if present
      const wind = $('#windVal'); const vis = $('#visVal');
      if (wind) {
        const mph = wind.dataset.mph, ms = wind.dataset.ms;
        wind.textContent = (WL.units==='imperial' && mph) ? `${mph} mph` : (ms ? `${ms} m/s` : wind.textContent);
      }
      if (vis) {
        const km = vis.dataset.km, mi = vis.dataset.mi;
        vis.textContent = (WL.units==='imperial' && mi) ? `${mi} mi` : (km ? `${km} km` : vis.textContent);
      }
    }
    applyUnitLabel();

    unitBtn.addEventListener('click', () => {
      WL.units = WL.units==='imperial' ? 'metric' : 'imperial';
      localStorage.setItem('wl_units', WL.units);
    });

    /* ---------- Auth Modals ---------- */
    function openModal(id){ $('#authShade').classList.remove('hidden'); $('#'+id).classList.remove('hidden'); }
    function closeModal(id){ $('#authShade').classList.add('hidden'); $('#'+id).classList.add('hidden'); }

    $('#registerBtn').onclick = () => openModal('registerModal');
    $('#loginBtn').onclick = () => openModal('loginModal');
    $('#toRegister').onclick = (e)=>{ e.preventDefault(); closeModal('loginModal'); openModal('registerModal'); };
    $('#toLogin').onclick = (e)=>{ e.preventDefault(); closeModal('registerModal'); openModal('loginModal'); };

    logoutBtn.onclick = async () => { await fetch('php/logout.php', {credentials:'same-origin'}); fetchMe(); };
    favoritesBtn.onclick = () => favoritesPanel.classList.toggle('hidden');
    $('#refreshFavBtn').onclick = () => loadFavorites();

    async function fetchMe(){
      try {
        const r = await fetch('php/me.php', {credentials:'same-origin'});
        const j = await r.json();
        WL.user = j.user || null;
        if (WL.user){
          helloUser.textContent = `Hello, ${WL.user.full_name}`;
          $('#loginBtn').classList.add('hidden'); $('#registerBtn').classList.add('hidden');
          logoutBtn.classList.remove('hidden'); favoritesBtn.classList.remove('hidden');
          favoritesPanel.classList.remove('hidden'); loadFavorites();
        } else {
          helloUser.textContent = '';
          $('#loginBtn').classList.remove('hidden'); $('#registerBtn').classList.remove('hidden');
          logoutBtn.classList.add('hidden'); favoritesBtn.classList.add('hidden');
          favoritesPanel.classList.add('hidden');
        }
      } catch(e){}
    }

    document.getElementById('registerForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const f = e.target;
      const full_name = f.full_name.value.trim();
      const email = f.email.value.trim();
      const password = f.password.value;
      const confirm = f.confirm.value;
      const errEl = document.getElementById('registerError');
      errEl.textContent = '';
      if (!full_name || !email || !password) { errEl.textContent = 'All fields are required.'; return; }
      if (password !== confirm) { errEl.textContent = 'Passwords do not match.'; return; }

      const r = await fetch('php/register.php', {
        method:'POST', credentials:'same-origin',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({ full_name, email, password })
      });
      const j = await r.json();
      if (!j.ok) { errEl.textContent = j.error || 'Registration failed.'; return; }
      closeModal('registerModal'); fetchMe();
    });

    document.getElementById('loginForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const f = e.target;
      const email = f.email.value.trim();
      const password = f.password.value;
      const errEl = document.getElementById('loginError');
      errEl.textContent = '';
      const r = await fetch('php/login.php', {
        method:'POST', credentials:'same-origin',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify({ email, password })
      });
      const j = await r.json();
      if (!j.ok) { errEl.textContent = j.error || 'Login failed.'; return; }
      closeModal('loginModal'); fetchMe();
    });

    /* ---------- Weather (server-proxied) ---------- */
    async function fetchWeatherByCoords(lat, lon) {
      const key = `${lat},${lon},${WL.units}`;
      if (WL.cache.has(key)) return WL.cache.get(key);
      const url = `php/weather.php?lat=${lat}&lon=${lon}&units=${WL.units}&include=current,hourly,daily`;
      const r = await fetch(url, {credentials:'same-origin'});
      const j = await r.json();
      if (!j.ok) throw new Error(j.error || 'weather failed');
      WL.cache.set(key, j.data);
      return j.data;
    }


    function showCurrent(j){
      const c = j.current;
      const name = c?.name || 'City';
      const temp = c?.main?.temp ?? null;
      const feels = c?.main?.feels_like ?? null;
      const hum = c?.main?.humidity ?? null;
      const press = c?.main?.pressure ?? null;
      const visM = c?.visibility ?? null;
      const wind = c?.wind?.speed ?? null;
      const icon = c?.weather?.[0]?.icon;

      document.getElementById('place').textContent = name;
      document.getElementById('temp').textContent = (temp!=null?Math.round(temp):'--') + '°';
      document.getElementById('feels').textContent = 'Feels like ' + (feels!=null?Math.round(feels):'--') + '°';
      document.getElementById('summary').textContent = (c?.weather?.[0]?.description || '—')
        .replace(/\b\w/g, m=>m.toUpperCase());
      document.getElementById('hiLo').textContent = 'H --°  L --°'; // placeholder; daily call can set

      const big = document.getElementById('bigIcon');
      big.innerHTML = icon ? `<img src="https://openweathermap.org/img/wn/${icon}@4x.png" class="w-20 h-20 drop-shadow-xl" />` : '⛅';

      const mph = (WL.units==='imperial' && wind!=null) ? wind.toFixed(1) : (wind!=null ? (wind*2.236936).toFixed(1) : null);
      const ms = (WL.units==='metric' && wind!=null) ? wind.toFixed(1) : (wind!=null ? (wind/2.236936).toFixed(1) : null);

      const km = visM!=null ? (visM/1000).toFixed(1) : null;
      const mi = visM!=null ? (visM/1609.344).toFixed(1) : null;

      const windEl = document.getElementById('windVal');
      windEl.dataset.mph = mph || '';
      windEl.dataset.ms = ms || '';
      windEl.textContent = (WL.units==='imperial' ? (mph?`${mph} mph`:'—') : (ms?`${ms} m/s`:'—'));

      document.getElementById('humVal').textContent = hum!=null? `${hum}%` : '—';
      document.getElementById('pressVal').textContent = press!=null? `${press} hPa` : '—';

      const visEl = document.getElementById('visVal');
      visEl.dataset.km = km || '';
      visEl.dataset.mi = mi || '';
      visEl.textContent = (WL.units==='imperial' ? (mi?`${mi} mi`:'—') : (km?`${km} km`:'—'));

      // remember coords for favorites
      const apiLat = c?.coord?.lat, apiLon = c?.coord?.lon;
      WL.last = { lat: apiLat, lon: apiLon, name };
    }

    async function runSearchByQuery(q){
      let lat, lon;
      const m = q.match(/^\s*(-?\d+(?:\.\d+)?)[,\s]+(-?\d+(?:\.\d+)?)\s*$/);
      if (m){ lat = parseFloat(m[1]); lon = parseFloat(m[2]); }
      else {
        const gn = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}`).then(r=>r.json());
        if (!gn[0]) return alert('Location not found.');
        lat = parseFloat(gn[0].lat); lon = parseFloat(gn[0].lon);
      }
      const data = await fetchWeatherByCoords(lat, lon);
      showCurrent(data);
      renderHourly(data.hourly || []);
      renderDaily(data.daily || []);
      // optional: set today's hi/lo if available
      if ((data.daily || []).length) {
        const d0 = data.daily[0];
        document.getElementById('hiLo').textContent =
          `H ${Math.round(d0.tmax)}°  L ${Math.round(d0.tmin)}°`;
      }

    }

    document.getElementById('go').onclick = ()=>{
      const q = document.getElementById('city').value.trim();
      if (!q) return;
      runSearchByQuery(q);
    };
    document.getElementById('useGps').onclick = ()=>{
      navigator.geolocation.getCurrentPosition(async pos => {
        const { latitude:lat, longitude:lon } = pos.coords;
        const data = await fetchWeatherByCoords(lat, lon);
      showCurrent(data);
      renderHourly(data.hourly || []);
      renderDaily(data.daily || []);
      // optional: set today's hi/lo if available
      if ((data.daily || []).length) {
        const d0 = data.daily[0];
        document.getElementById('hiLo').textContent =
          `H ${Math.round(d0.tmax)}°  L ${Math.round(d0.tmin)}°`;
      }
      }, () => alert('GPS error'));
    };

    /* ---------- Favorites ---------- */
    async function loadFavorites(){
      const r = await fetch('php/favorites.php?action=list', {credentials:'same-origin'});
      const j = await r.json();
      favoritesList.innerHTML = '';
      if (!j.ok) { favoritesList.innerHTML = '<p class="text-red-300">Could not load favorites.</p>'; return; }
      if (j.items.length===0){ favoritesList.innerHTML = '<p class="opacity-80">No favorites yet.</p>'; return; }
      j.items.forEach(it => {
        const row = document.createElement('div');
        row.className = 'flex items-center justify-between glass rounded-xl px-3 py-2';
        row.innerHTML = `<div><div class="font-medium">${it.location_name}</div>
                         <div class="text-xs opacity-80">${it.lat}, ${it.lon}</div></div>
                         <div class="flex gap-2">
                           <button class="underline text-sm" data-lat="${it.lat}" data-lon="${it.lon}">View</button>
                           <button class="underline text-sm text-red-200" data-remove="${it.location_id}">Remove</button>
                         </div>`;
        favoritesList.appendChild(row);
        row.querySelector('[data-lat]').onclick = async (e) => {
          const lat = e.target.getAttribute('data-lat');
          const lon = e.target.getAttribute('data-lon');
          const data = await fetchWeatherByCoords(lat, lon);
          showCurrent(data);
          renderHourly(data.hourly || []);
          renderDaily(data.daily || []);
          // optional: set today's hi/lo if available
          if ((data.daily || []).length) {
            const d0 = data.daily[0];
            document.getElementById('hiLo').textContent =
              `H ${Math.round(d0.tmax)}°  L ${Math.round(d0.tmin)}°`;
          }
        };
        row.querySelector('[data-remove]').onclick = async (e) => {
          const id = +e.target.getAttribute('data-remove');
          const rr = await fetch('php/favorites.php', {
            method:'POST', credentials:'same-origin',
            headers:{'Content-Type':'application/json'},
            body: JSON.stringify({ action:'remove', location_id:id })
          });
          await rr.json(); loadFavorites();
        };
      });
    }

    async function addCurrentToFavorites(){
      if (!WL.user) { alert('Please log in to save favorites.'); return; }
      const { lat, lon, name } = WL.last || {};
      if (lat==null || lon==null) return alert('No location selected yet.');
      try {
        const res = await fetch('php/favorites.php?action=add', {
          method:'POST', credentials:'same-origin',
          headers: {'Content-Type':'application/json'},
          body: JSON.stringify({ action:'add', location_name: name || 'Unknown', lat, lon })
        });
        const j = await res.json();
        if (!j.ok) alert('Add failed: ' + (j.error || 'unknown'));
        else { alert('Added to favorites ✅'); loadFavorites(); }
      } catch(e){ alert('Network error: ' + e.message); }
    }

    // Add to favorites when clicking the big current card
    document.querySelector('.md\\:col-span-2.rounded-3xl.glass.p-6').insertAdjacentHTML('beforeend',
      `<div class="mt-4"><button id="addFavBtn" class="glass rounded-2xl px-4 py-2 border border-white/40">Add to Favorites</button></div>`
    );
    document.getElementById('addFavBtn').onclick = addCurrentToFavorites;

    /* ---------- Boot ---------- */
    fetchMe();
  </script>
</body>
</html>

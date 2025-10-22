const VERSION = "breezy-v1";

const CORE = [
  "./",
  "index.html",
  "icons/site.webmanifest",
  "icons/favicon.ico",
  "icons/favicon-16x16.png",
  "icons/favicon-32x32.png",
  "icons/android-chrome-192x192.png",
  "icons/android-chrome-512x512.png",
  "icons/apple-touch-icon.png",
  "breezy-favicon.png",
  "breezy-logo.png",
  "breezy-splash.png",
  "https://cdn.tailwindcss.com"
];

self.addEventListener("install", e => {
  e.waitUntil(
    caches.open(VERSION).then(cache =>
      Promise.all(CORE.map(u => cache.add(new Request(u, { mode: "no-cors" }))))
    )
  );
  self.skipWaiting();
});

self.addEventListener("activate", e => {
  e.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.map(k => (k === VERSION ? null : caches.delete(k))))
    )
  );
  self.clients.claim();
});

self.addEventListener("fetch", e => {
  const req = e.request;

  if (req.mode === "navigate") {
    e.respondWith(fetch(req).catch(() => caches.match("index.html")));
    return;
  }

  const url = new URL(req.url);

  if (url.origin === location.origin) {
    e.respondWith(caches.match(req).then(c => c || fetch(req)));
    return;
  }

  e.respondWith(fetch(req).catch(() => caches.match(req)));
});

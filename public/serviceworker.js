const CACHE_NAME = 'lite-cache-v3';
const FILES_TO_CACHE = [
    '/css/app.css',
    '/js/app.js',
    '/offline.html',
    '/images/icons/icon-192x192.png',
    '/images/icons/icon-512x512.png'
];

// Install - cache only static assets
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => cache.addAll(FILES_TO_CACHE))
    );
    self.skipWaiting();
});

// Activate - clean old caches
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(keys =>
            Promise.all(keys.map(key => key !== CACHE_NAME && caches.delete(key)))
        )
    );
    self.clients.claim();
});

// Fetch - serve static assets from cache, dynamic pages always from network
self.addEventListener('fetch', event => {
    const url = new URL(event.request.url);

    if (FILES_TO_CACHE.includes(url.pathname)) {
        event.respondWith(
            caches.match(event.request).then(resp => resp || fetch(event.request))
        );
    } else {
        // Always fetch dynamic content from server
        event.respondWith(fetch(event.request).catch(() => caches.match('/offline.html')));
    }
});

// Message listener - skip waiting
self.addEventListener('message', event => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});

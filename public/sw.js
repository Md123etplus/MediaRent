const CACHE_NAME = 'mediarent-v2';
const OFFLINE_PAGE = '/offline';
const ASSETS_TO_CACHE = [
    '/',
    '/css/app.css',
    '/js/app.js',
    '/manifest.json',
    OFFLINE_PAGE,
    // Add other critical assets like:
    // '/images/logo.png',
    // '/fonts/your-font.woff2'
];

// Install Service Worker and cache essential assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => {
                console.log('[ServiceWorker] Caching app shell');
                return cache.addAll(ASSETS_TO_CACHE);
            })
            .then(() => self.skipWaiting())
    );
});

// Activate Service Worker and clean old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((cache) => {
                    if (cache !== CACHE_NAME) {
                        console.log('[ServiceWorker] Removing old cache:', cache);
                        return caches.delete(cache);
                    }
                })
            );
        })
    );
    return self.clients.claim();
});

// Fetch strategy: Cache First, falling back to Network
self.addEventListener('fetch', (event) => {
    // Skip non-GET requests and chrome-extension requests
    if (event.request.method !== 'GET' || event.request.url.startsWith('chrome-extension://')) {
        return;
    }

    // Handle API requests differently
    if (event.request.url.includes('/api/')) {
        event.respondWith(
            fetch(event.request)
                .then((response) => {
                    // Cache API responses if successful
                    const responseClone = response.clone();
                    caches.open(CACHE_NAME).then((cache) => {
                        cache.put(event.request, responseClone);
                    });
                    return response;
                })
                .catch(() => {
                    // Return cached API response if available
                    return caches.match(event.request);
                })
        );
    } else {
        // For all other requests (static assets)
        event.respondWith(
            caches.match(event.request)
                .then((cachedResponse) => {
                    // Return cached version if exists
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    // Otherwise fetch from network
                    return fetch(event.request)
                        .then((response) => {
                            // Cache the new response if valid
                            if (!response || response.status !== 200) {
                                return response;
                            }
                            const responseToCache = response.clone();
                            caches.open(CACHE_NAME)
                                .then((cache) => {
                                    cache.put(event.request, responseToCache);
                                });
                            return response;
                        })
                        .catch(() => {
                            // If both fail, show offline page
                            if (event.request.headers.get('accept').includes('text/html')) {
                                return caches.match(OFFLINE_PAGE);
                            }
                        });
                })
        );
    }
});
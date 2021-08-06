var cacheName = 'travelshop-static';
var urlsToCache = [
    '/wp-content/themes/travelshop/offline.php',
];

self.addEventListener('install', function(event) {
    // Perform install steps
    event.waitUntil(
        caches.open(cacheName)
            .then(function(cache) {
                return cache.addAll(urlsToCache);
            })
    );
});


// Simple offline fallback, for advanced offline caching use workbox instead reenginering caching strategies
self.addEventListener('fetch', function(event) {
    event.respondWith(fetch(event.request).catch(function() {
                return caches.match('/wp-content/themes/travelshop/offline.php');
        })
    );
});
var cache = 'travelshop-cache-v3';
var urlsToCache = [
    '/',
];

self.addEventListener('install', function(event) {
    // Perform install steps
    event.waitUntil(
        caches.open(cache)
            .then(function(cache) {
                console.log('Opened cache');
                return cache.addAll(urlsToCache);
            })
    );
});

self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                    // Cache hit - return response
                    if (response) {
                        return response;
                    }
                    return fetch(event.request);
                }
            )
    );
});
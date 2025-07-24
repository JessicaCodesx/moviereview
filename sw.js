var CACHE_NAME = 'moviereview-v1';

// Simple install event
self.addEventListener('install', function(event) {
  console.log('SW: Installing');
  // Skip waiting to activate immediately
  self.skipWaiting();
});

// Simple activate event
self.addEventListener('activate', function(event) {
  console.log('SW: Activating');
  // Claim all clients immediately
  event.waitUntil(
    self.clients.claim().then(function() {
      console.log('SW: Active');
    })
  );
});

// Minimal fetch handler - just pass through to network
self.addEventListener('fetch', function(event) {
  // Let all requests go to network normally
  // This SW just establishes the registration without interfering
  return;
});
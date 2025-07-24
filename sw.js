// Ultra-minimal Service Worker - No-op implementation
// This file does absolutely nothing except register successfully

console.log('Minimal SW loaded');

// Just install and activate without doing anything
self.addEventListener('install', function() {
  self.skipWaiting();
});

self.addEventListener('activate', function() {
  self.clients.claim();
});

// No fetch handler - let everything pass through normally

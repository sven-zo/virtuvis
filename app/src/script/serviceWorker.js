/**
/ Creëert een service worker als deze nog niet bestaat.
*/
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function () {
    navigator.serviceWorker.register('/serviceWorker.js').then(function (registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope)
    }).catch(function (err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err)
    })
  })
}
/**
/ Deze code definieert wat er gecached moet worden door de service worker
*/
var CACHE_NAME = 'virtuvis_v1.0.0'
var urlsToCache = [
  '../assets',
  '../components',
  '../router',
  '../script',
  '../style',
  '../App.vue',
  '../main.js',
  '../../manifest.webmanifest'
]
/**
/ Deze code wordt uitgevoerd wanneer de service worker wordt geïnstalleerd
*/
self.addEventListener('install', function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
    .then(function (cache) {
      console.log('Cache is geöpend')
      return cache.addAll(urlsToCache)
    })
  )
})
/**
/ Deze code wordt uitgevoerd als de gebruiker naar een nieuwe pagina navigeert
/ (Dit gebeurt één keer bij ons, als de gebruiker de app opent)
*/
self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request)
      .then(function (response) {
        // Cache hit - return response
        if (response) {
          return response
        }
        return fetch(event.request)
      }
    )
  )
})
/**
/ TODO: Toevoegen van een 'activate' event voor als de service worker wordt geüpdatet
*/

self.addEventListener('install', (event) => {
  console.log('Employee Management service worker installed');
});

self.addEventListener('activate', (event) => {
  console.log('Employee Management service worker activated');
});

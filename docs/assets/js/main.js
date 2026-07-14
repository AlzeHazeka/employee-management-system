const header = document.querySelector('[data-header]');
const nav = document.querySelector('[data-nav]');
const navToggle = document.querySelector('[data-nav-toggle]');
const repositoryLink = document.querySelector('[data-repository-link]');

const repositoryUrl = '#'; // Replace with the reviewed public repository URL before publishing.

function closeNavigation() {
  if (!nav || !navToggle) return;
  nav.classList.remove('is-open');
  navToggle.setAttribute('aria-expanded', 'false');
}

navToggle?.addEventListener('click', () => {
  const open = nav?.classList.toggle('is-open') ?? false;
  navToggle.setAttribute('aria-expanded', String(open));
});

nav?.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeNavigation));

window.addEventListener('scroll', () => {
  header?.classList.toggle('is-scrolled', window.scrollY > 12);
}, { passive: true });

if (repositoryLink) {
  repositoryLink.setAttribute('href', repositoryUrl);
  if (repositoryUrl === '#') {
    repositoryLink.addEventListener('click', (event) => event.preventDefault());
    repositoryLink.setAttribute('title', 'Replace the repository URL in docs/assets/js/main.js before publishing.');
  }
}

document.querySelectorAll('[data-current-year]').forEach((element) => {
  element.textContent = String(new Date().getFullYear());
});

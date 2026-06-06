(function () {
  const STORAGE_KEY = 'amjads_dark_mode';

  // Apply on load
  if (localStorage.getItem(STORAGE_KEY) === '1') {
    document.body.classList.add('dark-mode');
  }

  document.addEventListener('DOMContentLoaded', function () {
    // Also check html attribute set in <head>
    if (document.documentElement.getAttribute('data-dark') === '1') {
      document.body.classList.add('dark-mode');
    }

    const btn = document.querySelector('.dark-mode-btn');
    if (!btn) return;

    btn.addEventListener('click', function () {
      const isDark = document.body.classList.toggle('dark-mode');
      localStorage.setItem(STORAGE_KEY, isDark ? '1' : '0');
    });
  });
})();
// ── Main JS ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

  // ── Navbar Scroll Shrink ──────────────────────────────
  const navbar = document.querySelector('.navbar');
  if (navbar) {
    window.addEventListener('scroll', function () {
      navbar.classList.toggle('scrolled', window.scrollY > 40);
    });
  }

  // ── Hamburger / Category Overlay ─────────────────────
  const menuBtn   = document.getElementById('grid-menu-btn');
  const overlay   = document.getElementById('cat-overlay');
  const closeBtn  = document.getElementById('cat-overlay-close');
  const tiles     = document.querySelectorAll('.cat-tile');

  function openOverlay() {
    if (!overlay) return;
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    tiles.forEach(function (tile, i) {
      setTimeout(function () {
        tile.classList.add('animate-in');
      }, i * 50);
    });
  }

  function closeOverlay() {
    overlay.classList.remove('open');
    document.body.style.overflow = '';
    tiles.forEach(function (tile) { tile.classList.remove('animate-in'); });
  }

  if (menuBtn)  menuBtn.addEventListener('click', openOverlay);
  if (closeBtn) closeBtn.addEventListener('click', closeOverlay);
  if (overlay) {
    overlay.addEventListener('click', function (e) {
      if (e.target === overlay) closeOverlay();
    });
  }
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && overlay?.classList.contains('open')) closeOverlay();
  });

  // ── Horizontal Scroll Arrows ──────────────────────────
  document.querySelectorAll('.h-scroll-wrapper').forEach(function (wrapper) {
    const container = wrapper.querySelector('.h-scroll-container');
    const leftBtn   = wrapper.querySelector('.scroll-arrow.left');
    const rightBtn  = wrapper.querySelector('.scroll-arrow.right');
    if (!container) return;

    function updateArrows() {
      if (!leftBtn || !rightBtn) return;
      leftBtn.classList.toggle('hidden',  container.scrollLeft <= 0);
      rightBtn.classList.toggle('hidden', container.scrollLeft + container.clientWidth >= container.scrollWidth - 2);
    }

    if (leftBtn)  leftBtn.addEventListener('click',  function () { container.scrollBy({ left: -300, behavior: 'smooth' }); });
    if (rightBtn) rightBtn.addEventListener('click', function () { container.scrollBy({ left:  300, behavior: 'smooth' }); });
    container.addEventListener('scroll', updateArrows);
    updateArrows();
    window.addEventListener('resize', updateArrows);
  });

  // ── Flash Deal Countdown ──────────────────────────────
  const countdownEl = document.getElementById('flash-countdown');
  if (countdownEl) {
    function updateCountdown() {
      const now   = new Date();
      const end   = new Date();
      end.setHours(23, 59, 59, 0);
      const diff  = end - now;
      const h = Math.floor(diff / 3600000);
      const m = Math.floor((diff % 3600000) / 60000);
      const s = Math.floor((diff % 60000) / 1000);

      document.getElementById('cd-hours')   && (document.getElementById('cd-hours').textContent   = String(h).padStart(2,'0'));
      document.getElementById('cd-minutes') && (document.getElementById('cd-minutes').textContent = String(m).padStart(2,'0'));
      document.getElementById('cd-seconds') && (document.getElementById('cd-seconds').textContent = String(s).padStart(2,'0'));
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
  }

  // ── Active nav link highlight ─────────────────────────
  const currentPath = window.location.pathname;
  document.querySelectorAll('.admin-nav-link').forEach(function (link) {
    if (link.getAttribute('href') && currentPath.startsWith(link.getAttribute('href'))) {
      link.classList.add('active');
    }
  });

});
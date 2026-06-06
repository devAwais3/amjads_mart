// ── Animations ────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

  document.documentElement.classList.add('js-animations-loaded');

  // ── Fallback: if IntersectionObserver not supported ───
  if (!('IntersectionObserver' in window)) {
    document.querySelectorAll('.scroll-reveal').forEach(function (el) {
      el.classList.add('revealed');
    });
    return;
  }
  
  // ── Intersection Observer ─────────────────────────────
  const revealObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('revealed');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.05, rootMargin: '0px 0px -10px 0px' });

  document.querySelectorAll('.scroll-reveal').forEach(function (el, i) {
    // If inside a stagger-grid, delay is handled by CSS nth-child
    // For h-scroll rows, add inline delay by index
    const row = el.closest('.h-scroll-container');
    if (row) {
      const idx = Array.from(row.children).indexOf(el);
      el.style.transitionDelay = (idx * 80) + 'ms';
    }
    revealObserver.observe(el);
  });

  // ── Count-Up Animation ────────────────────────────────
  const countObserver = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (!entry.isIntersecting) return;
      const el = entry.target;
      const end = parseFloat(el.dataset.count || el.textContent.replace(/[^0-9.]/g, ''));
      const dec = (el.dataset.count || '').includes('.') ? 2 : 0;
      const dur = 1800;
      const step = dur / 60;
      let current = 0;
      const inc = end / (dur / step);
      const prefix = el.dataset.prefix || '';
      const suffix = el.dataset.suffix || '';

      const timer = setInterval(function () {
        current += inc;
        if (current >= end) {
          current = end;
          clearInterval(timer);
        }
        el.textContent = prefix + current.toFixed(dec) + suffix;
      }, step);

      countObserver.unobserve(el);
    });
  }, { threshold: 0.3 });

  document.querySelectorAll('.count-up').forEach(function (el) {
    countObserver.observe(el);
  });

  // ── Ripple Effect ─────────────────────────────────────
  document.querySelectorAll('.btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      const ripple = document.createElement('span');
      ripple.className = 'ripple-effect';
      const rect = btn.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      ripple.style.width = ripple.style.height = size + 'px';
      ripple.style.left = (e.clientX - rect.left - size / 2) + 'px';
      ripple.style.top = (e.clientY - rect.top - size / 2) + 'px';
      btn.appendChild(ripple);
      setTimeout(function () { ripple.remove(); }, 700);
    });
  });

  // ── Skeleton → real content ───────────────────────────
  document.querySelectorAll('.skeleton-card').forEach(function (card) {
    setTimeout(function () {
      card.style.opacity = '0';
      setTimeout(function () { card.remove(); }, 300);
    }, 800);
  });

});
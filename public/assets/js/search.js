// ── Live Search ────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {
  const input    = document.getElementById('search-input');
  const dropdown = document.getElementById('search-dropdown');
  if (!input || !dropdown) return;

  let timer;

  input.addEventListener('input', function () {
    clearTimeout(timer);
    const q = input.value.trim();

    if (q.length < 2) {
      dropdown.classList.remove('show');
      dropdown.innerHTML = '';
      return;
    }

    timer = setTimeout(function () {
      fetch(BASE_URL + 'search?q=' + encodeURIComponent(q))
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (!data.products || data.products.length === 0) {
            dropdown.innerHTML = '<div class="search-item" style="color:#64748b;justify-content:center">No products found</div>';
            dropdown.classList.add('show');
            return;
          }

          dropdown.innerHTML = data.products.map(function (p) {
            return '<div class="search-item" onclick="window.location=\'' + BASE_URL + 'product/' + p.slug + '\'">' +
              '<img src="/' + p.image_url + '" onerror="this.src=\'/assets/images/placeholder.jpg\'">' +
              '<div>' +
                '<div class="search-item-name">' + escHtml(p.name) + '</div>' +
                '<div class="search-item-price">Rs. ' + p.price + '</div>' +
              '</div>' +
            '</div>';
          }).join('');

          dropdown.classList.add('show');
        })
        .catch(function () {
          dropdown.classList.remove('show');
        });
    }, 300);
  });

  // Close on outside click
  document.addEventListener('click', function (e) {
    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.classList.remove('show');
    }
  });

  // Keyboard nav
  input.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
      dropdown.classList.remove('show');
      input.blur();
    }
  });

  function escHtml(str) {
    const d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
  }
});
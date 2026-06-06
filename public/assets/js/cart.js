// ── Cart JS ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

  // ── Add to Cart ───────────────────────────────────────
  document.querySelectorAll('.btn-add-cart').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      const productId = btn.dataset.productId;
      const qty = parseInt(document.getElementById('qty-input')?.value || '1');

      btn.disabled = true;
      btn.innerHTML = '<i class="ri-loader-4-line spin"></i> Adding...';

      fetch(BASE_URL + 'cart/add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
        body: 'product_id=' + productId + '&quantity=' + qty
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          btn.disabled = false;
          btn.innerHTML = '<i class="ri-shopping-cart-line"></i> Add to Cart';
          if (data.success) {
            updateCartBadge(data.cart_count);
            showToast(data.message, 'success');
            bounceCartIcon();
          } else if (data.redirect) {
            window.location = data.redirect;
          } else {
            showToast(data.message || 'Error adding to cart.', 'error');
          }
        })
        .catch(function () {
          btn.disabled = false;
          btn.innerHTML = '<i class="ri-shopping-cart-line"></i> Add to Cart';
          showToast('Network error. Try again.', 'error');
        });
    });
  });

  // ── Cart Page: update qty ─────────────────────────────
  document.querySelectorAll('.qty-dec, .qty-inc').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const wrap = btn.closest('[data-product-id]');
      const productId = wrap.dataset.productId;
      const valEl = wrap.querySelector('.qty-val');
      let qty = parseInt(valEl.textContent);
      if (btn.classList.contains('qty-dec')) qty = Math.max(1, qty - 1);
      else qty += 1;
      valEl.textContent = qty;
      cartAjaxUpdate(productId, qty, wrap);
    });
  });

  function cartAjaxUpdate(productId, qty, wrap) {
    fetch(BASE_URL + 'cart/update', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
      body: 'product_id=' + productId + '&quantity=' + qty
    })
      .then(function (r) { return r.json(); })
      .then(function (data) {
        if (data.success) {
          updateSummary(data);
          updateCartBadge(data.cart_count);
          const price = parseFloat(wrap.dataset.price || 0);
          const totalEl = wrap.querySelector('.row-total');
          if (totalEl) totalEl.textContent = 'Rs. ' + (price * qty).toFixed(0);
        } else {
          showToast(data.message, 'error');
        }
      });
  }

  // ── Remove item ───────────────────────────────────────
  document.querySelectorAll('.cart-remove-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const row = btn.closest('tr') || btn.closest('[data-product-id]');
      const productId = btn.dataset.productId;
      fetch(BASE_URL + 'cart/remove', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
        body: 'product_id=' + productId
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.success) {
            row.style.opacity = '0';
            row.style.transform = 'translateX(-20px)';
            row.style.transition = 'all .3s ease';
            setTimeout(function () { row.remove(); checkEmptyCart(); }, 300);
            updateSummary(data);
            updateCartBadge(data.cart_count);
            showToast('Item removed.', 'info');
          }
        });
    });
  });

  // ── Coupon ─────────────────────────────────────────────
  const couponBtn = document.getElementById('apply-coupon-btn');
  if (couponBtn) {
    couponBtn.addEventListener('click', function () {
      const code = document.getElementById('coupon-input').value.trim();
      const amount = parseFloat(document.getElementById('summary-subtotal')?.dataset.val || 0);
      fetch(BASE_URL + 'cart/apply-coupon', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
        body: 'coupon=' + encodeURIComponent(code) + '&amount=' + amount
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.valid) {
            showToast(data.message, 'success');
            const discRow = document.getElementById('discount-row');
            if (discRow) {
              discRow.style.display = 'flex';
              document.getElementById('discount-amount').textContent = 'Rs. ' + data.discount_amount;
            }
            sessionStorage.setItem('coupon_code', code);
            sessionStorage.setItem('coupon_discount', data.discount_amount);
          } else {
            showToast(data.message, 'error');
            const inp = document.getElementById('coupon-input');
            inp.classList.add('shake');
            setTimeout(function () { inp.classList.remove('shake'); }, 500);
          }
        });
    });
  }

  function updateSummary(data) {
    const sub = document.getElementById('summary-subtotal');
    const fee = document.getElementById('summary-delivery');
    const tot = document.getElementById('summary-total');
    if (sub) {
      sub.textContent = 'Rs. ' + data.subtotal;
      sub.dataset.val = parseFloat(String(data.subtotal).replace(/,/g, ''));
    }
    if (fee) fee.textContent = (parseFloat(data.delivery_fee) === 0) ? 'FREE' : 'Rs. ' + data.delivery_fee;
    if (tot) tot.textContent = 'Rs. ' + data.total;
  }

  function checkEmptyCart() {
    const rows = document.querySelectorAll('.cart-table tbody tr');
    if (!rows || rows.length === 0) {
      const empty = document.getElementById('empty-cart');
      const cartWrap = document.getElementById('cart-content');
      if (empty) empty.style.display = 'block';
      if (cartWrap) cartWrap.style.display = 'none';
    }
  }

  function updateCartBadge(count) {
    document.querySelectorAll('.cart-badge').forEach(function (el) {
      el.textContent = count;
      el.style.display = count > 0 ? 'flex' : 'none';
    });
  }

  function bounceCartIcon() {
    const icon = document.querySelector('.cart-icon-wrap');
    if (!icon) return;
    icon.classList.add('cart-icon-bounce');
    setTimeout(function () { icon.classList.remove('cart-icon-bounce'); }, 600);
  }
});

// ── Toast (global) ─────────────────────────────────────────
function showToast(message, type) {
  type = type || 'success';
  let container = document.getElementById('toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    document.body.appendChild(container);
  }
  const icons = { success: 'ri-checkbox-circle-line', error: 'ri-error-warning-line', info: 'ri-information-line' };
  const toast = document.createElement('div');
  toast.className = 'toast toast-' + type;
  toast.innerHTML = '<i class="' + (icons[type] || icons.success) + '"></i> ' + message;
  container.appendChild(toast);
  requestAnimationFrame(function () { toast.classList.add('show'); });
  setTimeout(function () {
    toast.classList.remove('show');
    setTimeout(function () { toast.remove(); }, 400);
  }, 3000);
}
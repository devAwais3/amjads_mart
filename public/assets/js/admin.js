// ── Admin JS ───────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function () {

  // ── Chart.js Orders Bar Chart ─────────────────────────
  const chartCanvas = document.getElementById('orders-chart');
  if (chartCanvas && typeof Chart !== 'undefined') {
    fetch(BASE_URL + 'admin/chart-data')
      .then(function (r) { return r.json(); })
      .then(function (data) {
        new Chart(chartCanvas, {
          type: 'bar',
          data: {
            labels: data.labels,
            datasets: [
              {
                label: 'Orders',
                data: data.counts,
                backgroundColor: 'rgba(22,163,74,.75)',
                borderColor: '#16a34a',
                borderWidth: 2,
                borderRadius: 8,
              },
              {
                label: 'Revenue (Rs.)',
                data: data.revenues,
                backgroundColor: 'rgba(251,191,36,.6)',
                borderColor: '#fbbf24',
                borderWidth: 2,
                borderRadius: 8,
                yAxisID: 'y2',
              }
            ]
          },
          options: {
            responsive: true,
            plugins: {
              legend: { position: 'top' },
              tooltip: {
                callbacks: {
                  label: function (ctx) {
                    if (ctx.dataset.label === 'Revenue (Rs.)') {
                      return 'Rs. ' + ctx.parsed.y.toLocaleString();
                    }
                    return ctx.dataset.label + ': ' + ctx.parsed.y;
                  }
                }
              }
            },
            scales: {
              y: { beginAtZero: true, ticks: { stepSize: 1 } },
              y2: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
            }
          }
        });
      });
  }

  // ── Count-Up on stat cards ────────────────────────────
  document.querySelectorAll('.count-up').forEach(function (el) {
    const target = parseFloat(el.dataset.count || el.textContent.replace(/[^0-9.]/g, '') || 0);
    const dec = el.dataset.dec ? parseInt(el.dataset.dec) : 0;
    const prefix = el.dataset.prefix || '';
    const suffix = el.dataset.suffix || '';
    const dur = 1500;
    const steps = 60;
    const inc = target / steps;
    let cur = 0;
    const timer = setInterval(function () {
      cur += inc;
      if (cur >= target) { cur = target; clearInterval(timer); }
      el.textContent = prefix + cur.toFixed(dec) + suffix;
    }, dur / steps);
  });

  // ── Product Add/Edit Modal ────────────────────────────
  const productForm = document.getElementById('product-form');
  if (productForm) {
    productForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(productForm);
      const isEdit = productForm.dataset.mode === 'edit';
      const id = productForm.dataset.id || '';
      const url = isEdit ? BASE_URL + 'admin/products/update/' + id : BASE_URL + 'admin/products/store';
      // const url = isEdit
      //   ? window.BASE_URL + 'admin/products/update/' + id
      //   : window.BASE_URL + 'admin/products/store';

      fetch(url, { method: 'POST', body: formData })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.success) {
            showToast(data.message, 'success');
            setTimeout(function () { location.reload(); }, 800);
          } else {
            showToast(data.message || 'Error.', 'error');
          }
        });
    });
  }

  // Populate edit modal
  document.querySelectorAll('.btn-edit-product').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const id = btn.dataset.id;
      fetch(BASE_URL + 'admin/products/get/' + id)
        .then(function (r) { return r.json(); })
        .then(function (p) {
          const form = document.getElementById('product-form');
          if (!form) return;
          form.dataset.mode = 'edit';
          form.dataset.id = p.id;
          form.querySelector('[name=name]').value = p.name || '';
          form.querySelector('[name=category_id]').value = p.category_id || '';
          form.querySelector('[name=price]').value = p.price || '';
          form.querySelector('[name=original_price]').value = p.original_price || '';
          form.querySelector('[name=stock]').value = p.stock || '';
          form.querySelector('[name=unit]').value = p.unit || '';
          form.querySelector('[name=description]').value = p.description || '';
          form.querySelector('[name=discount_percent]').value = p.discount_percent || 0;
          if (form.querySelector('[name=is_featured]'))
            form.querySelector('[name=is_featured]').checked = p.is_featured == 1;
          if (form.querySelector('[name=is_on_sale]'))
            form.querySelector('[name=is_on_sale]').checked = p.is_on_sale == 1;
          document.getElementById('product-modal-title').textContent = 'Edit Product';
          const modal = new bootstrap.Modal(document.getElementById('productModal'));
          modal.show();
        });
    });
  });

  // Reset modal on add
  const addProductBtn = document.getElementById('add-product-btn');
  if (addProductBtn) {
    addProductBtn.addEventListener('click', function () {
      const form = document.getElementById('product-form');
      if (form) { form.reset(); form.dataset.mode = 'add'; form.dataset.id = ''; }
      document.getElementById('product-modal-title').textContent = 'Add Product';
    });
  }

  // ── Delete Product ─────────────────────────────────────
  document.querySelectorAll('.btn-delete-product').forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (!confirm('Delete this product?')) return;
      fetch(BASE_URL + 'admin/products/delete/' + btn.dataset.id, { method: 'POST' })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.success) {
            btn.closest('tr').remove();
            showToast(data.message, 'success');
          }
        });
    });
  });

  // ── Order Status Update ───────────────────────────────
  document.querySelectorAll('.order-status-select').forEach(function (sel) {
    sel.addEventListener('change', function () {
      const orderId = sel.dataset.orderId;
      fetch(BASE_URL + 'admin/orders/update-status', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'order_id=' + orderId + '&status=' + sel.value
      })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          showToast(data.message || 'Updated', data.success ? 'success' : 'error');
          const badge = sel.closest('tr')?.querySelector('.order-status-badge');
          if (badge) {
            badge.className = 'order-status-badge status-' + sel.value;
            badge.textContent = sel.value.charAt(0).toUpperCase() + sel.value.slice(1);
          }
        });
    });
  });

  // ── View Order Detail Modal ───────────────────────────
  document.querySelectorAll('.btn-view-order').forEach(function (btn) {
    btn.addEventListener('click', function () {
      const orderId = btn.dataset.orderId;
      fetch(BASE_URL + 'admin/orders/get/' + orderId)
        .then(function (r) { return r.json(); })
        .then(function (order) {
          const body = document.getElementById('order-modal-body');
          if (!body) return;

          const statusClass = 'status-' + order.status;
          let itemsHtml = order.items.map(function (item) {
            return '<tr><td><img src="/' + item.image_url + '" style="width:40px;height:40px;object-fit:cover;border-radius:6px"></td>' +
              '<td>' + item.product_name + '</td>' +
              '<td>' + item.quantity + '</td>' +
              '<td>Rs. ' + parseFloat(item.unit_price).toLocaleString() + '</td>' +
              '<td>Rs. ' + parseFloat(item.subtotal).toLocaleString() + '</td></tr>';
          }).join('');

          body.innerHTML = '<div class="row g-3">' +
            '<div class="col-6"><strong>Order #</strong> ' + String(order.id).padStart(5, '0') + '</div>' +
            '<div class="col-6"><strong>Status:</strong> <span class="order-status-badge ' + statusClass + '">' + order.status + '</span></div>' +
            '<div class="col-6"><strong>Customer:</strong> ' + (order.full_name || '—') + '</div>' +
            '<div class="col-6"><strong>Phone:</strong> ' + order.delivery_phone + '</div>' +
            '<div class="col-12"><strong>Address:</strong> ' + order.delivery_address + ', ' + order.delivery_city + '</div>' +
            '<div class="col-6"><strong>Payment:</strong> ' + order.payment_method.toUpperCase() + '</div>' +
            (order.transaction_id ? '<div class="col-6"><strong>Txn ID:</strong> ' + order.transaction_id + '</div>' : '') +
            '</div>' +
            '<table class="admin-table mt-3"><thead><tr><th></th><th>Product</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead><tbody>' + itemsHtml + '</tbody></table>' +
            '<div class="mt-3 text-end"><strong>Total: Rs. ' + parseFloat(order.total).toLocaleString() + '</strong></div>';

          new bootstrap.Modal(document.getElementById('orderModal')).show();
        });
    });
  });

  // ── User Block/Unblock ────────────────────────────────
  document.querySelectorAll('.btn-toggle-user').forEach(function (btn) {
    btn.addEventListener('click', function () {
      fetch(BASE_URL + 'admin/users/toggle/' + btn.dataset.userId, { method: 'POST' })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.success) {
            btn.textContent = data.is_active ? 'Block' : 'Unblock';
            btn.className = data.is_active
              ? 'btn btn-sm btn-outline btn-toggle-user'
              : 'btn btn-sm btn-red btn-toggle-user';
            const badge = btn.closest('tr')?.querySelector('.user-status-badge');
            if (badge) {
              badge.textContent = data.is_active ? 'Active' : 'Blocked';
              badge.className = 'order-status-badge ' + (data.is_active ? 'status-delivered' : 'status-cancelled');
            }
            showToast(data.message, 'success');
          }
        });
    });
  });

  // ── Delete Coupon ──────────────────────────────────────
  document.querySelectorAll('.btn-delete-coupon').forEach(function (btn) {
    btn.addEventListener('click', function () {
      if (!confirm('Delete coupon?')) return;
      fetch(BASE_URL + 'admin/coupons/delete/' + btn.dataset.id, { method: 'POST' })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.success) { btn.closest('tr').remove(); showToast(data.message, 'success'); }
        });
    });
  });

  // ── Toggle Message Read ───────────────────────────────
  document.querySelectorAll('.btn-toggle-read').forEach(function (btn) {
    btn.addEventListener('click', function () {
      fetch(BASE_URL + 'admin/messages/toggle-read/' + btn.dataset.id, { method: 'POST' })
        .then(function (r) { return r.json(); })
        .then(function (data) {
          if (data.success) {
            const row = btn.closest('tr');
            row.style.background = data.is_read ? '' : '#f0fdf4';
            btn.textContent = data.is_read ? 'Mark Unread' : 'Mark Read';
          }
        });
    });
  });

  // ── Add Coupon Form ───────────────────────────────────
  const couponForm = document.getElementById('add-coupon-form');
  if (couponForm) {
    couponForm.addEventListener('submit', function (e) {
      e.preventDefault();
      const data = new FormData(couponForm);
      fetch(BASE_URL + 'admin/coupons/store', { method: 'POST', body: data })
        .then(function (r) { return r.json(); })
        .then(function (res) {
          if (res.success) { showToast(res.message, 'success'); setTimeout(function () { location.reload(); }, 600); }
          else showToast(res.message || 'Error', 'error');
        });
    });
  }

});
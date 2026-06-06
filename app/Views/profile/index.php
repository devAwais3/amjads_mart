<div class="profile-page">
  <div class="container" style="padding-bottom:3rem">
    <div class="row g-4">

      <!-- Sidebar -->
      <div class="col-lg-3">
        <div class="profile-sidebar scroll-reveal">

          <div class="text-center">
            <div class="avatar-circle">
              <?= strtoupper(substr($user['full_name'] ?? 'U', 0, 1)) ?>
            </div>

            <h4 style="margin-bottom:.25rem">
              <?= esc($user['full_name']) ?>
            </h4>

            <p style="font-size:.82rem">
              <?= esc($user['email']) ?>
            </p>
          </div>

          <ul class="profile-tabs-list">

            <li class="profile-tab-item">
              <button class="profile-tab-btn active" onclick="showTab('orders')">
                <i class="ri-file-list-3-line"></i> My Orders
                <span class="ms-auto nav-badge" style="position:static;background:var(--green);border:none">
                  <?= count($orders) ?>
                </span>
              </button>
            </li>

            <li class="profile-tab-item">
              <button class="profile-tab-btn" onclick="showTab('wishlist')">
                <i class="ri-heart-line"></i> Wishlist
                <span class="ms-auto nav-badge" style="position:static;background:var(--red);border:none">
                  <?= count($wishlist) ?>
                </span>
              </button>
            </li>

            <li class="profile-tab-item">
              <button class="profile-tab-btn" onclick="showTab('settings')">
                <i class="ri-settings-3-line"></i> Settings
              </button>
            </li>

            <li class="profile-tab-item" style="margin-top:.5rem;border-top:1px solid var(--gray-l);padding-top:.5rem">
              <a href="<?= base_url('auth/logout') ?>" class="profile-tab-btn" style="color:var(--red)">
                <i class="ri-logout-box-line"></i> Logout
              </a>
            </li>

          </ul>

        </div>
      </div>

      <!-- Content -->
      <div class="col-lg-9">
        <div class="profile-content scroll-reveal">

          <!-- ORDERS TAB -->
          <div class="profile-panel active" id="tab-orders">
            <h3 class="mb-3">📦 My Orders</h3>

            <?php if (empty($orders)): ?>
              <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h3>No orders yet</h3>
                <a href="<?= base_url() ?>" class="btn btn-primary">Start Shopping</a>
              </div>
            <?php else: ?>
              <div style="overflow-x:auto">
                <table class="admin-table">
                  <thead>
                    <tr>
                      <th>Order #</th>
                      <th>Date</th>
                      <th>Total</th>
                      <th>Status</th>
                      <th>Payment</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach ($orders as $order): ?>
                      <tr>
                        <td>
                          <strong>
                            #<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?>
                          </strong>
                        </td>

                        <td>
                          <?= date('d M Y', strtotime($order['created_at'])) ?>
                        </td>

                        <td>
                          <strong style="color:var(--green)">
                            Rs. <?= number_format($order['total'], 0) ?>
                          </strong>
                        </td>

                        <td>
                          <span class="order-status-badge status-<?= $order['status'] ?>">
                            <?= ucfirst($order['status']) ?>
                          </span>
                        </td>

                        <td>
                          <?= strtoupper($order['payment_method']) ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>

          <!-- WISHLIST TAB -->
          <div class="profile-panel" id="tab-wishlist">
            <h3 class="mb-3">❤️ My Wishlist</h3>

            <?php if (empty($wishlist)): ?>
              <div class="empty-state">
                <div class="empty-state-icon">💔</div>
                <h3>Wishlist is empty</h3>
                <a href="<?= base_url() ?>" class="btn btn-primary">Browse Products</a>
              </div>
            <?php else: ?>
              <div class="products-grid stagger-grid">

                <?php foreach ($wishlist as $item): ?>
                  <div class="product-card scroll-reveal">

                    <div class="product-img-wrap">

                      <img src="<?= base_url($item['image_url']) ?>" alt="<?= esc($item['name']) ?>"
                        onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">

                      <button class="product-wishlist-btn active"
                        onclick="removeWishlist(<?= $item['product_id'] ?>, this)">
                        <i class="ri-heart-fill"></i>
                      </button>
                    </div>

                    <div class="product-info">
                      <a href="<?= base_url('product/' . esc($item['slug'])) ?>" class="product-name">
                        <?= esc($item['name']) ?>
                      </a>

                      <div class="product-price">
                        <span class="price-current">
                          Rs. <?= number_format($item['price'], 0) ?>
                        </span>
                      </div>
                    </div>

                    <button class="product-add-btn btn-add-cart" data-product-id="<?= $item['product_id'] ?>">
                      <i class="ri-shopping-cart-line"></i> Add to Cart
                    </button>

                  </div>
                <?php endforeach; ?>

              </div>
            <?php endif; ?>
          </div>

          <!-- SETTINGS TAB -->
          <div class="profile-panel" id="tab-settings">
            <h3 class="mb-3">⚙️ Account Settings</h3>

            <div class="row g-4">

              <!-- Edit Profile -->
              <div class="col-12">
                <h5 style="font-weight:700;margin-bottom:1rem">Edit Profile</h5>

                <div class="row g-3">

                  <div class="col-sm-6">
                    <label class="fw-600 d-block mb-1" style="font-size:.88rem">Full Name</label>
                    <input type="text" class="form-control" id="edit-name" value="<?= esc($user['full_name']) ?>">
                  </div>

                  <div class="col-sm-6">
                    <label class="fw-600 d-block mb-1" style="font-size:.88rem">Email</label>
                    <input type="email" class="form-control" id="edit-email" value="<?= esc($user['email']) ?>">
                  </div>

                  <div class="col-sm-6">
                    <label class="fw-600 d-block mb-1" style="font-size:.88rem">Phone</label>
                    <input type="tel" class="form-control" id="edit-phone" value="<?= esc($user['phone'] ?? '') ?>">
                  </div>

                  <div class="col-sm-6">
                    <label class="fw-600 d-block mb-1" style="font-size:.88rem">City</label>
                    <input type="text" class="form-control" id="edit-city" value="<?= esc($user['city'] ?? '') ?>">
                  </div>

                  <div class="col-12">
                    <label class="fw-600 d-block mb-1" style="font-size:.88rem">Address</label>
                    <input type="text" class="form-control" id="edit-address"
                      value="<?= esc($user['address'] ?? '') ?>">
                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary" onclick="saveProfile()">
                      <i class="ri-save-line"></i> Save Changes
                    </button>
                  </div>

                </div>
              </div>

              <!-- Change Password -->
              <div class="col-12" style="border-top:1px solid var(--gray-l);padding-top:1.5rem">

                <h5 style="font-weight:700;margin-bottom:1rem">
                  Change Password
                </h5>

                <div class="row g-3">

                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="cp-current" placeholder="Current password">
                  </div>

                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="cp-new" placeholder="New password">
                  </div>

                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="cp-confirm" placeholder="Confirm password">
                  </div>

                  <div class="col-12">
                    <button class="btn btn-outline" onclick="changePassword()">
                      <i class="ri-lock-password-line"></i> Update Password
                    </button>
                  </div>

                </div>
              </div>

            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<script>
  function showTab(tab) {
    document.querySelectorAll('.profile-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.profile-tab-btn').forEach(b => b.classList.remove('active'));

    document.getElementById('tab-' + tab).classList.add('active');
    event.currentTarget.classList.add('active');
  }

  function removeWishlist(productId, btn) {
    fetch(BASE_URL + 'wishlist/toggle', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: 'product_id=' + productId
    })
      .then(r => r.json())
      .then(data => {
        if (!data.in_wishlist) {
          const card = btn.closest('.product-card');
          card.style.opacity = '0';
          card.style.transform = 'scale(.9)';
          card.style.transition = 'all .3s';
          setTimeout(() => card.remove(), 300);
          showToast(data.message, 'success');
        }
      });
  }

  function saveProfile() {
    const body = new URLSearchParams({
      full_name: document.getElementById('edit-name').value,
      email: document.getElementById('edit-email').value,
      phone: document.getElementById('edit-phone').value,
      address: document.getElementById('edit-address').value,
      city: document.getElementById('edit-city').value,
    });

    fetch(BASE_URL + 'profile/update', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: body.toString()
    })
      .then(r => r.json())
      .then(data => showToast(data.message, data.success ? 'success' : 'error'));
  }

  function changePassword() {
    const body = new URLSearchParams({
      current_password: document.getElementById('cp-current').value,
      new_password: document.getElementById('cp-new').value,
      confirm_password: document.getElementById('cp-confirm').value,
    });

    fetch(BASE_URL + 'profile/change-password', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: body.toString()
    })
      .then(r => r.json())
      .then(data => {
        showToast(data.message, data.success ? 'success' : 'error');

        if (data.success) {
          document.getElementById('cp-current').value = '';
          document.getElementById('cp-new').value = '';
          document.getElementById('cp-confirm').value = '';
        }
      });
  }
</script>
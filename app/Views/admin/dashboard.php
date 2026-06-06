<?php $activePage = 'dashboard'; ?>
<?php include __DIR__ . '/partials/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
  <div class="admin-header">
    <h1>📊 Dashboard</h1>
    <div style="color:var(--gray);font-size:.88rem">
      <i class="ri-calendar-line"></i> <?= date('l, d F Y') ?>
    </div>
  </div>

  <!-- Stats -->
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card scroll-reveal">
        <div class="stat-icon green"><i class="ri-shopping-bag-3-line"></i></div>
        <div>
          <div class="stat-val count-up" data-count="<?= $totalOrders ?>">0</div>
          <div class="stat-label">Total Orders</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card scroll-reveal">
        <div class="stat-icon yellow"><i class="ri-money-rupee-circle-line"></i></div>
        <div>
          <div class="stat-val count-up" data-count="<?= number_format($totalRevenue, 0) ?>" data-prefix="Rs. ">Rs. 0
          </div>
          <div class="stat-label">Total Revenue</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card scroll-reveal">
        <div class="stat-icon blue"><i class="ri-store-2-line"></i></div>
        <div>
          <div class="stat-val count-up" data-count="<?= $totalProducts ?>">0</div>
          <div class="stat-label">Active Products</div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="stat-card scroll-reveal">
        <div class="stat-icon red"><i class="ri-group-line"></i></div>
        <div>
          <div class="stat-val count-up" data-count="<?= $totalUsers ?>">0</div>
          <div class="stat-label">Customers</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Chart + Low Stock -->
  <div class="row g-4 mb-4">
    <div class="col-lg-8">
      <div class="admin-card scroll-reveal">
        <div class="admin-card-header">
          <h3>📈 Orders Last 7 Days</h3>
        </div>
        <canvas id="orders-chart" height="100"></canvas>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="admin-card scroll-reveal">
        <div class="admin-card-header">
          <h3>⚠️ Low Stock</h3>
          <a href="<?= base_url('admin/products') ?>" style="font-size:.8rem;color:var(--green)">View all</a>
        </div>
        <?php if (empty($lowStock)): ?>
          <p style="color:var(--gray);font-size:.88rem">All products well stocked! ✅</p>
        <?php else: ?>
          <?php foreach ($lowStock as $p): ?>
            <div
              style="display:flex;align-items:center;justify-content:space-between;padding:.5rem 0;border-bottom:1px solid var(--gray-l)">
              <span style="font-size:.88rem;font-weight:500"><?= esc(substr($p['name'], 0, 28)) ?>...</span>
              <span
                style="background:#fee2e2;color:var(--red);padding:.2rem .6rem;border-radius:50px;font-size:.75rem;font-weight:700">
                <?= $p['stock'] ?> left
              </span>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Recent Orders -->
  <div class="admin-card scroll-reveal">
    <div class="admin-card-header">
      <h3>🧾 Recent Orders</h3>
      <a href="<?= base_url('admin/orders') ?>" class="btn btn-outline btn-sm">View All</a>
    </div>
    <div style="overflow-x:auto">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Order #</th>
            <th>Customer</th>
            <th>Date</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($recentOrders as $order): ?>
            <tr>
              <td><strong>#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
              <td><?= esc($order['full_name'] ?? 'Guest') ?></td>
              <td><?= date('d M, g:i a', strtotime($order['created_at'])) ?></td>
              <td><strong style="color:var(--green)">Rs. <?= number_format($order['total'], 0) ?></strong></td>
              <td><span style="text-transform:uppercase;font-size:.78rem"><?= $order['payment_method'] ?></span></td>
              <td>
                <select class="order-status-select" data-order-id="<?= $order['id'] ?>"
                  style="padding:.3rem .6rem;border-radius:50px;border:1px solid var(--gray-l);font-size:.78rem;background:var(--bg);cursor:pointer">
                  <?php foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s): ?>
                    <option value="<?= $s ?>" <?= $order['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
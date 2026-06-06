<?php $activePage = 'coupons'; ?>

<?php include __DIR__ . '/partials/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <div class="admin-header">
        <h1>🎟️ Coupons</h1>
    </div>

    <div class="row g-4">
        <!-- Add Coupon Form -->
        <div class="col-lg-4">
            <div class="admin-card">
                <h3 style="margin-bottom:1.25rem">Add New Coupon</h3>
                <form id="add-coupon-form">
                    <div class="form-group">
                        <label style="font-size:.85rem;font-weight:600">Coupon Code *</label>
                        <input type="text" name="code" class="form-control mt-1" placeholder="e.g. SAVE10"
                            style="text-transform:uppercase" required>
                    </div>
                    <div class="form-group">
                        <label style="font-size:.85rem;font-weight:600">Discount % *</label>
                        <input type="number" name="discount_percent" class="form-control mt-1" min="1" max="100"
                            required>
                    </div>
                    <div class="form-group">
                        <label style="font-size:.85rem;font-weight:600">Min Order (Rs.)</label>
                        <input type="number" name="min_order_amount" class="form-control mt-1" min="0" value="500">
                    </div>
                    <div class="form-group">
                        <label style="font-size:.85rem;font-weight:600">Expires At</label>
                        <input type="datetime-local" name="expires_at" class="form-control mt-1">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ri-add-line"></i> Create Coupon
                    </button>
                </form>
            </div>
        </div>

        <!-- Coupons Table -->
        <div class="col-lg-8">
            <div class="admin-card">
                <h3 style="margin-bottom:1.25rem">Active Coupons</h3>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Discount</th>
                            <th>Min Order</th>
                            <th>Expires</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coupons as $c): ?>
                            <tr>
                                <td><strong style="letter-spacing:.05em">
                                        <?= esc($c['code']) ?>
                                    </strong></td>
                                <td><span style="color:var(--green);font-weight:700">
                                        <?= $c['discount_percent'] ?>% OFF
                                    </span></td>
                                <td>Rs.
                                    <?= number_format($c['min_order_amount'], 0) ?>+
                                </td>
                                <td>
                                    <?= $c['expires_at'] ? date('d M Y', strtotime($c['expires_at'])) : '—' ?>
                                </td>
                                <td>
                                    <span
                                        class="order-status-badge <?= $c['is_active'] ? 'status-delivered' : 'status-cancelled' ?>">
                                        <?= $c['is_active'] ? 'Active' : 'Inactive' ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-red btn-delete-coupon" data-id="<?= $c['id'] ?>">
                                        <i class="ri-delete-bin-6-line"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php /*
<link rel="stylesheet" href="/assets/css/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/admin.js"></script>
*/ ?>
</div>
</div>
<?php include __DIR__ . '/partials/footer_main.php'; ?>
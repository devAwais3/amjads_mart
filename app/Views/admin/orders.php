<?php $activePage = 'orders'; ?>
<?php include __DIR__ . '/partials/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <div class="admin-header">
        <h1>📦 Orders</h1>
        <a href="<?= base_url('admin/orders/export-csv') ?>" class="btn btn-outline">
            <i class="ri-download-2-line"></i> Export CSV
        </a>
    </div>

    <!-- Filters -->
    <div class="admin-card mb-4">
        <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end">
            <div>
                <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:.3rem">Status</label>
                <select name="status" class="form-control">
                    <option value="">All</option>
                    <?php foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s): ?>
                        <option value="<?= $s ?>" <?= ($status ?? '') === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label style="font-size:.82rem;font-weight:600;display:block;margin-bottom:.3rem">Search Order
                    ID</label>
                <input type="text" name="search" class="form-control" placeholder="#00001"
                    value="<?= esc($search ?? '') ?>">
            </div>
            <button type="submit" class="btn btn-outline"><i class="ri-search-line"></i> Filter</button>
        </form>
    </div>

    <div class="admin-card">
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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong>#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></strong></td>
                            <td>
                                <div style="font-weight:600;font-size:.9rem"><?= esc($order['full_name'] ?? 'Guest') ?>
                                </div>
                                <div style="font-size:.75rem;color:var(--gray)"><?= esc($order['email'] ?? '') ?></div>
                            </td>
                            <td><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                            <td><strong style="color:var(--green)">Rs. <?= number_format($order['total'], 0) ?></strong>
                            </td>
                            <td style="text-transform:uppercase;font-size:.8rem"><?= esc($order['payment_method']) ?></td>
                            <td>
                                <select class="order-status-select" data-order-id="<?= $order['id'] ?>"
                                    style="padding:.3rem .6rem;border-radius:50px;border:1px solid var(--gray-l);font-size:.78rem;background:var(--bg);cursor:pointer">
                                    <?php foreach (['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $s): ?>
                                        <option value="<?= $s ?>" <?= esc($order['status']) === $s ? 'selected' : '' ?>>
                                            <?= ucfirst($s) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline btn-view-order" data-order-id="<?= $order['id'] ?>"
                                    data-bs-toggle="modal" data-bs-target="#orderModal">
                                    <i class="ri-eye-line"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Order Detail Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:none">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" id="order-modal-body">
                <div style="text-align:center;padding:2rem;color:var(--gray)">Loading...</div>
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
<?php $activePage = 'users'; ?>

<?php include __DIR__ . '/partials/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <div class="admin-header">
        <h1>👥 Users</h1>
        <span style="color:var(--gray);font-size:.88rem">
            <?= count($users) ?> customers registered
        </span>
    </div>

    <div class="admin-card">
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Orders</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:.6rem">
                                    <div
                                        style="width:36px;height:36px;border-radius:50%;background:var(--green);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.9rem;flex-shrink:0">
                                        <?= strtoupper(substr($u['full_name'], 0, 1)) ?>
                                    </div>
                                    <strong>
                                        <?= esc($u['full_name']) ?>
                                    </strong>
                                </div>
                            </td>
                            <td>
                                <?= esc($u['email']) ?>
                            </td>
                            <td>
                                <?= esc($u['phone'] ?? '—') ?>
                            </td>
                            <td><strong>
                                    <?= esc($u['order_count']) ?>
                                </strong></td>
                            <td>
                                <?= date('d M Y', strtotime($u['created_at'])) ?>
                            </td>
                            <td>
                                <span
                                    class="order-status-badge user-status-badge <?= $u['is_active'] ? 'status-delivered' : 'status-cancelled' ?>">
                                    <?= $u['is_active'] ? 'Active' : 'Blocked' ?>
                                </span>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm <?= $u['is_active'] ? 'btn-outline' : 'btn-red' ?> btn-toggle-user"
                                    data-user-id="<?= esc($u['id']) ?>">
                                    <?= $u['is_active'] ? 'Block' : 'Unblock' ?>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
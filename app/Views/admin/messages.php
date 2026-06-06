<?php $activePage = 'messages'; ?>

<?php include __DIR__ . '/partials/header.php'; ?>
<?php include __DIR__ . '/partials/sidebar.php'; ?>

<div class="admin-main">
    <div class="admin-header">
        <h1>📬 Contact Messages</h1>
        <span style="color:var(--gray);font-size:.88rem">
            <?= count(array_filter($messages, fn($m) => !$m['is_read'])) ?> unread
        </span>
    </div>

    <div class="admin-card">
        <div style="overflow-x:auto">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $msg): ?>
                        <tr style="<?= !$msg['is_read'] ? 'background:rgba(22,163,74,.04)' : '' ?>">
                            <td>
                                <strong>
                                    <?= esc($msg['name']) ?>
                                </strong>
                            </td>
                            <td>
                                <?= esc($msg['email']) ?>
                            </td>
                            <td>
                                <?= esc($msg['subject']) ?>
                            </td>
                            <td style="max-width:250px">
                                <span style="font-size:.82rem;color:var(--gray)">
                                    <?= esc(substr(strip_tags($msg['message']), 0, 80)) ?>...
                                </span>
                            </td>
                            <td>
                                <?= date('d M Y', strtotime($msg['created_at'])) ?>
                            </td>
                            <td>
                                <span
                                    class="order-status-badge <?= $msg['is_read'] ? 'status-delivered' : 'status-processing' ?>">
                                    <?= $msg['is_read'] ? 'Read' : 'Unread' ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline btn-toggle-read" data-id="<?= $msg['id'] ?>">
                                    <?= $msg['is_read'] ? 'Mark Unread' : 'Mark Read' ?>
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
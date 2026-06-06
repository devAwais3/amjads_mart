<div class="admin-layout">
    <div class="admin-sidebar">
        <div class="admin-logo">
            <h2>🛒 Amjad's Mart</h2>
            <p>Administrator Panel</p>
        </div>
        <nav class="admin-nav">
            <a href="<?= base_url('admin/dashboard') ?>"
                class="admin-nav-link <?= ($activePage ?? '') === 'dashboard' ? 'active' : '' ?>">
                <i class="ri-dashboard-line"></i> Dashboard
            </a>
            <a href="<?= base_url('admin/products') ?>" class="admin-nav-link <?= ($activePage ?? '') === 'products' ? 'active' : '' ?>">
                <i class="ri-store-2-line"></i> Products
            </a>
            <a href="<?= base_url('admin/orders') ?>" class="admin-nav-link <?= ($activePage ?? '') === 'orders' ? 'active' : '' ?>">
                <i class="ri-shopping-bag-3-line"></i> Orders
            </a>
            <a href="<?= base_url('admin/users') ?>" class="admin-nav-link <?= ($activePage ?? '') === 'users' ? 'active' : '' ?>">
                <i class="ri-group-line"></i> Users
            </a>
            <?php
            /*
            <a href="/admin/categories" class="admin-nav-link <?= ($activePage ?? '') === 'categories' ? 'active' : '' ?>">
                <i class="ri-grid-line"></i> Categories
            </a>
            */
            ?>
            <a href="<?= base_url('admin/coupons') ?>" class="admin-nav-link <?= ($activePage ?? '') === 'coupons' ? 'active' : '' ?>">
                <i class="ri-coupon-3-line"></i> Coupons
            </a>
            <a href="<?= base_url('admin/messages') ?>" class="admin-nav-link <?= ($activePage ?? '') === 'messages' ? 'active' : '' ?>">
                <i class="ri-message-3-line"></i> Messages
            </a>
            <a href="<?= base_url() ?>" class="admin-nav-link" style="margin-top:.5rem">
                <i class="ri-store-line"></i> View Store
            </a>
            <a href="<?= base_url('auth/logout') ?>" class="admin-nav-link" style="color:#ef4444;margin-top:auto">
                <i class="ri-logout-box-line"></i> Logout
            </a>
        </nav>
        <div style="padding:1rem 1.5rem;border-top:1px solid #1e293b;font-size:.78rem;color:#475569">
            Logged in as: <strong style="color:#94a3b8"><?= esc(session()->get('user_name') ?? 'Admin') ?></strong>
        </div>
    </div>
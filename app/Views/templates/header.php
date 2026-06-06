<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? "Amjad's Mart") ?></title>
  <meta name="description" content="Amjad's Mart — Fresh. Fast. Local. Online grocery store in Mardan, KPK Pakistan.">

  <meta name="csrf-token" content="<?= csrf_hash() ?>">
  <meta name="csrf-header" content="<?= csrf_header() ?>">

  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <!-- Remix Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css">
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/animations.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/dark-mode.css') ?>">
  <script>window.BASE_URL = '<?= base_url() ?>';</script>

  <!-- Base URL + CSRF for AJAX -->
  <script>
    window.BASE_URL = '<?= base_url() ?>';
    window.CSRF_TOKEN_NAME = '<?= csrf_token() ?>';
    window.CSRF_HASH = '<?= csrf_hash() ?>';
  </script>
  <!-- Dark mode: apply before paint to avoid flash -->
  <script>
    if (localStorage.getItem('amjads_dark_mode') === '1') document.documentElement.setAttribute('data-dark', '1');
  </script>
  <!-- <script>
    if (localStorage.getItem('amjads_dark_mode') === '1') document.documentElement.classList.add('dark-mode-pre');
  </script> -->
</head>

<body class="page-enter">

  <!-- Toast Container -->
  <div id="toast-container"></div>

  <!-- ── NAVBAR ──────────────────────────────────────────── -->
  <nav class="navbar">
    <div class="container navbar-inner">

      <!-- Grid Menu Button -->
      <!-- <button class="grid-menu-btn" id="grid-menu-btn" title="Browse Categories">
        <i class="ri-grid-fill"></i>
      </button> -->



      <div class="dropdown category-dropdown">
        <button class="btn btn-success dropdown-toggle category-btn" type="button" data-bs-toggle="dropdown">
          Shop By Category
        </button>

        <ul class="dropdown-menu">
          <?php foreach ($categories as $cat): ?>
            <li>
              <a class="dropdown-item" href="<?= base_url('category/' . $cat['slug']) ?>">
                <?= esc($cat['name']) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <!-- Logo -->
      <a href="<?= base_url() ?>" class="nav-logo">
        🛒 Amjad's<span>Mart</span>
      </a>

      <!-- Search -->
      <div class="nav-search">
        <i class="ri-search-line search-icon"></i>
        <input type="text" id="search-input" placeholder="Search groceries, brands...">
        <div id="search-dropdown" class="search-dropdown"></div>
      </div>

      <!-- Actions -->
      <div class="nav-actions">
        <!-- Dark Mode -->
        <button class="nav-icon-btn dark-mode-btn" title="Toggle dark mode">
          <i class="ri-sun-line icon-sun"></i>
          <i class="ri-moon-line icon-moon"></i>
        </button>

        <!-- Wishlist -->
        <!-- <a href="<?= base_url('profile') ?>#wishlist" class="nav-icon-btn" title="Wishlist">
          <i class="ri-heart-line"></i>
          <?php if (session()->get('user_id')): ?>
            <span class="nav-badge wishlist-badge">0</span>
          <?php endif; ?>
        </a> -->

        <!-- Wishlist -->
        <a href="<?= base_url('profile') ?>#wishlist" class="nav-icon-btn" title="Wishlist">
          <i class="ri-heart-line"></i>

          <?php if (session()->get('user_id')): ?>
            <span class="nav-badge wishlist-badge" style="<?= ($wishlistCount ?? 0) > 0 ? '' : 'display:none' ?>">
              <?= $wishlistCount ?? 0 ?>
            </span>
          <?php endif; ?>
        </a>

        <!-- Cart -->
        <a href="<?= base_url('cart') ?>" class="nav-icon-btn cart-icon-wrap" title="Cart">
          <i class="ri-shopping-cart-line"></i>
          <span class="nav-badge cart-badge" style="<?= ($cartCount ?? 0) > 0 ? '' : 'display:none' ?>">
            <?= $cartCount ?? 0 ?>
          </span>
        </a>

        <!-- Login / Avatar -->
        <?php if (session()->get('user_id')): ?>
          <div class="dropdown">
            <button class="nav-icon-btn" data-bs-toggle="dropdown">
              <i class="ri-user-fill"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:14px;min-width:180px">
              <li><span class="dropdown-item-text fw-600"
                  style="font-weight:600"><?= esc(session()->get('user_name')) ?></span></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item" href="<?= base_url('profile') ?>"><i class="ri-user-line me-2"></i>My
                  Profile</a></li>
              <li><a class="dropdown-item" href="<?= base_url('cart') ?>"><i class="ri-shopping-cart-line me-2"></i>Cart</a></li>
              <?php if (session()->get('user_role') === 'admin'): ?>
                <li><a class="dropdown-item text-success" href="<?= base_url('admin/dashboard') ?>"><i
                      class="ri-dashboard-line me-2"></i>Admin</a></li>
              <?php endif; ?>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>"><i
                    class="ri-logout-box-line me-2"></i>Logout</a></li>
            </ul>
          </div>
        <?php else: ?>
          <a href="<?= base_url('login') ?>" class="btn btn-primary btn-sm">
            <i class="ri-user-line"></i> Login
          </a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <!-- ── CATEGORY OVERLAY ─────────────────────────────────── -->
  <div id="cat-overlay" class="cat-overlay">
    <div class="cat-overlay-inner">
      <div class="cat-overlay-title">
        <span>🛒 Browse Categories</span>
        <button class="cat-overlay-close" id="cat-overlay-close">
          <i class="ri-close-line"></i>
        </button>
      </div>
      <div class="cat-grid">
        <?php
        $cats = $categories ?? [];
        $catColors = ['#fef9c3', '#dbeafe', '#fce7f3', '#d1fae5', '#ede9fe', '#fee2e2', '#e0f2fe', '#f0fdf4'];
        foreach ($cats as $i => $cat):
          ?>
          <a href="<?= base_url('category/' . esc($cat['slug'])) ?>" class="cat-tile scroll-reveal">
            <div class="cat-tile-icon"><?= $cat['icon'] ?></div>
            <div class="cat-tile-name"><?= esc($cat['name']) ?></div>
            <div class="cat-tile-count"><?= $cat['product_count'] ?> items</div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
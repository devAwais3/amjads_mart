<!-- ── HERO CAROUSEL ────────────────────────────────────── -->
<section class="hero-section">
  <div id="heroCarousel" class="carousel slide hero-carousel carousel-fade" data-bs-ride="carousel"
    data-bs-interval="4000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
      <!-- Slide 1 -->
      <div class="carousel-item active hero-slide">
        <img src="<?= base_url('assets/images/hero/hero1.png') ?>" alt="Fresh Groceries"
          onerror="this.style.background='linear-gradient(135deg,#16a34a,#15803d)';this.style.height='480px'">
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <span class="hero-badge">Welcome to Mardan's Finest</span>
          <h1>Fresh Groceries<br>Delivered Fast</h1>
          <p>Shop from 200+ products from trusted Pakistani brands. Free delivery above Rs. 1000.</p>
          <a href="<?= base_url('category/groceries') ?>" class="btn btn-primary btn-lg">
            <i class="ri-shopping-basket-line"></i> Shop Now
          </a>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item hero-slide">
        <img src="<?= base_url('assets/images/hero/hero2.png') ?>" alt="Fresh Dairy"
          onerror="this.style.background='linear-gradient(135deg,#0369a1,#0284c7)';this.style.height='480px'">
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <span class="hero-badge">Farm Fresh</span>
          <h1>Fresh Dairy &<br>Organic Produce</h1>
          <p>Eggs, milk, yogurt, butter — sourced fresh daily from local farms in KPK.</p>
          <a href="<?= base_url('category/fresh-dairy') ?>" class="btn btn-primary btn-lg">
            <i class="ri-leaf-line"></i> Explore Dairy
          </a>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="carousel-item hero-slide">
        <img src="<?= base_url('assets/images/hero/hero3.png') ?>" alt="Special Offers"
          onerror="this.style.background='linear-gradient(135deg,#b45309,#d97706)';this.style.height='480px'">
        <div class="hero-overlay"></div>
        <div class="hero-content">
          <span class="hero-badge">Limited Time</span>
          <h1>Big Savings on<br>Combo Deals</h1>
          <p>Bundle packs at up to 23% off! Stock up and save big on your weekly grocery run.</p>
          <a href="<?= base_url('category/special-offers') ?>" class="btn btn-primary btn-lg"
            style="background:#fbbf24;color:#0f172a">
            <i class="ri-coupon-3-line"></i> View Deals
          </a>
        </div>
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
      <i class="ri-arrow-left-s-line" style="font-size:1.5rem;color:#fff"></i>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
      <i class="ri-arrow-right-s-line" style="font-size:1.5rem;color:#fff"></i>
    </button>
  </div>
</section>

<!-- ── FLASH DEALS ───────────────────────────────────────── -->
<div class="container">
  <section class="section">
    <div class="flash-deals-section">
      <div class="flash-header">
        <h2 class="flash-title scroll-reveal">⚡ Flash Deals</h2>

        <div class="countdown" id="flash-countdown">
          <span>Ends in</span>
          <span class="countdown-unit" id="cd-hours">00</span>
          <span class="countdown-sep">:</span>
          <span class="countdown-unit" id="cd-minutes">00</span>
          <span class="countdown-sep">:</span>
          <span class="countdown-unit" id="cd-seconds">00</span>
        </div>

        <a href="<?= base_url('category/special-offers') ?>" class="view-all">View All <i
            class="ri-arrow-right-s-line"></i></a>
      </div>

      <div class="h-scroll-wrapper">
        <button class="scroll-arrow left" aria-label="Scroll left"><i class="ri-arrow-left-s-line"></i></button>

        <div class="h-scroll-container">

          <?php if (empty($onSale)): ?>
            <div style="padding:2rem;width:100%;text-align:center;color:var(--gray)">
              No deals available right now.
            </div>
          <?php else: ?>
            <?php foreach ($onSale as $p): ?>
              <div class="product-card scroll-reveal">
                <div class="product-img-wrap">
                  <img src="<?= base_url(esc($p['image_url'])) ?>" alt="<?= esc($p['name']) ?>"
                    onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">

                  <?php if ($p['discount_percent'] > 0): ?>
                    <span class="product-badge">-<?= $p['discount_percent'] ?>%</span>
                  <?php endif; ?>

                  <button class="product-wishlist-btn" onclick="toggleWishlist(<?= $p['id'] ?>, this)" title="Wishlist">
                    <i class="ri-heart-line"></i>
                  </button>
                </div>

                <div class="product-info">
                  <div class="product-category"><?= esc($p['unit']) ?></div>
                  <a href="<?= base_url('product/' . esc($p['slug'])) ?>" class="product-name"><?= esc($p['name']) ?></a>

                  <div class="product-rating">
                    <span class="stars">★★★★★</span>
                    <span class="rating-count">(<?= $p['review_count'] ?>)</span>
                  </div>

                  <div class="product-price">
                    <span class="price-current">Rs. <?= number_format($p['price'], 0) ?></span>
                    <?php if ($p['original_price']): ?>
                      <span class="price-original">Rs. <?= number_format($p['original_price'], 0) ?></span>
                    <?php endif; ?>
                  </div>
                </div>

                <button class="product-add-btn btn-add-cart" data-product-id="<?= $p['id'] ?>">
                  <i class="ri-shopping-cart-line"></i> Add to Cart
                </button>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

        </div>

        <button class="scroll-arrow right" aria-label="Scroll right"><i class="ri-arrow-right-s-line"></i></button>
      </div>
    </div>
  </section>

  <!-- ── SHOP BY CATEGORY ──────────────────────────────────── -->
  <section class="section">
    <div class="section-header">
      <h2 class="section-title scroll-reveal">Shop by Category</h2>
    </div>

    <div class="categories-grid stagger-grid">
      <?php
      $catGradients = [
        'linear-gradient(135deg,#fef9c3,#fde68a)',
        'linear-gradient(135deg,#dbeafe,#bfdbfe)',
        'linear-gradient(135deg,#fce7f3,#fbcfe8)',
        'linear-gradient(135deg,#d1fae5,#a7f3d0)',
        'linear-gradient(135deg,#ede9fe,#ddd6fe)',
        'linear-gradient(135deg,#fee2e2,#fecaca)',
        'linear-gradient(135deg,#e0f2fe,#bae6fd)',
        'linear-gradient(135deg,#f0fdf4,#bbf7d0)',
      ];

      foreach ($categories as $i => $cat):
        ?>
        <a href="<?= base_url('category/' . esc($cat['slug'])) ?>" class="category-card scroll-reveal"
          style="background:<?= $catGradients[$i % 8] ?>">
          <div class="cat-icon"><?= $cat['icon'] ?></div>
          <div class="cat-name"><?= esc($cat['name']) ?></div>
          <div class="cat-count"><?= $cat['product_count'] ?> items</div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- ── FEATURED PRODUCTS ─────────────────────────────────── -->
  <section class="section">
    <div class="section-header">
      <h2 class="section-title scroll-reveal">Featured Products ⭐</h2>
      <a href="<?= base_url('category/groceries') ?>" class="view-all">View All <i
          class="ri-arrow-right-s-line"></i></a>
    </div>

    <div class="h-scroll-wrapper">
      <button class="scroll-arrow left"><i class="ri-arrow-left-s-line"></i></button>

      <div class="h-scroll-container">

        <?php if (empty($featured)): ?>
          <div style="padding:2rem;width:100%;text-align:center;color:var(--gray)">
            No featured products available.
          </div>
        <?php else: ?>
          <?php foreach ($featured as $p): ?>
            <div class="product-card scroll-reveal">
              <div class="product-img-wrap">

                <img src="<?= base_url(esc($p['image_url'])) ?>" alt="<?= esc($p['name']) ?>"
                  onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">

                <span class="product-badge badge-featured">Featured</span>

                <button class="product-wishlist-btn" onclick="toggleWishlist(<?= $p['id'] ?>, this)" title="Wishlist">
                  <i class="ri-heart-line"></i>
                </button>
              </div>

              <div class="product-info">
                <div class="product-category"><?= esc($p['unit']) ?></div>
                <a href="<?= base_url('product/' . esc($p['slug'])) ?>" class="product-name"><?= esc($p['name']) ?></a>

                <div class="product-rating">
                  <span class="stars">★★★★★</span>
                  <span class="rating-count">(<?= $p['review_count'] ?>)</span>
                </div>

                <div class="product-price">
                  <span class="price-current">Rs. <?= number_format($p['price'], 0) ?></span>
                  <?php if ($p['original_price']): ?>
                    <span class="price-original">Rs. <?= number_format($p['original_price'], 0) ?></span>
                  <?php endif; ?>
                </div>
              </div>

              <button class="product-add-btn btn-add-cart" data-product-id="<?= $p['id'] ?>">
                <i class="ri-shopping-cart-line"></i> Add to Cart
              </button>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>

      </div>

      <button class="scroll-arrow right"><i class="ri-arrow-right-s-line"></i></button>
    </div>
  </section>

  <script>
    function submitNewsletter(e) {
      e.preventDefault();
      const email = document.getElementById('newsletter-email').value;
      const btn = e.target.querySelector('button');
      btn.disabled = true;
      btn.innerHTML = '<i class="ri-loader-4-line spin"></i> Subscribing...';

      fetch(BASE_URL + 'newsletter/subscribe', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
        body: 'email=' + encodeURIComponent(email)
      })
        .then(r => r.json())
        .then(data => {
          btn.disabled = false;
          btn.innerHTML = '<i class="ri-send-plane-line"></i> Subscribe';
          showToast(data.message, data.success ? 'success' : 'error');
          if (data.success) document.getElementById('newsletter-email').value = '';
        });
    }

    function toggleWishlist(productId, btn) {
      if (!<?= session()->get('user_id') ? 'true' : 'false' ?>) {
        showToast('Please login to save to wishlist.', 'info');
        return;
      }
      fetch(BASE_URL + 'wishlist/toggle', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
        body: 'product_id=' + productId
      })
        .then(r => r.json())
        .then(data => {
          btn.classList.toggle('active', data.in_wishlist);
          btn.querySelector('i').className = data.in_wishlist ? 'ri-heart-fill' : 'ri-heart-line';
          showToast(data.message, 'success');
        });
    }
  </script>
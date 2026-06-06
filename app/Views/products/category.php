<!-- 
<div class="breadcrumb-section">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li class="sep"><i class="ri-arrow-right-s-line"></i></li>
      <li><?= esc($category['name']) ?></li>
    </ol>
  </div>
</div>

<div class="container" style="padding-top:1.5rem;padding-bottom:3rem">
  <div class="scroll-reveal" style="background:linear-gradient(135deg,#16a34a,#15803d);border-radius:20px;padding:2.5rem;color:#fff;margin-bottom:2rem;display:flex;align-items:center;gap:1.5rem">
    <div style="font-size:4rem"><?= $category['icon'] ?></div>
    <div>
      <h1 style="color:#fff;margin-bottom:.25rem"><?= esc($category['name']) ?></h1>
      <p style="color:rgba(255,255,255,.85);margin:0"><?= $category['product_count'] ?> products available</p>
    </div>
  </div>

  <div class="filter-bar">
    <label><i class="ri-sort-desc"></i> Sort by:</label>
    <select class="filter-select" id="sort-select" onchange="applyFilters()">
      <option value="default" <?= $sort==='default'?'selected':'' ?>>Default</option>
      <option value="price_asc" <?= $sort==='price_asc'?'selected':'' ?>>Price: Low to High</option>
      <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Price: High to Low</option>
      <option value="rating" <?= $sort==='rating'?'selected':'' ?>>Top Rated</option>
    </select>
    <button class="btn btn-outline btn-sm" onclick="applyFilters()"><i class="ri-filter-line"></i> Apply</button>
  </div>

  <?php if(empty($products)): ?>
  <div class="empty-state scroll-reveal">
    <div class="empty-state-icon">🔍</div>
    <h3>No Products Found</h3>
    <a href="/" class="btn btn-primary">Back to Home</a>
  </div>
  <?php else: ?>
  <div class="products-grid stagger-grid">
    <?php foreach($products as $p): ?>
    <div class="product-card scroll-reveal">
      <div class="product-img-wrap">
        <img src="/<?= esc($p['image_url']) ?>" alt="<?= esc($p['name']) ?>"
             onerror="this.src='/assets/images/placeholder.jpg'" loading="lazy">
        <?php if($p['is_on_sale'] && $p['discount_percent'] > 0): ?>
        <span class="product-badge">-<?= $p['discount_percent'] ?>%</span>
        <?php elseif($p['is_featured']): ?>
        <span class="product-badge badge-featured">⭐</span>
        <?php endif; ?>
      </div>
      <div class="product-info">
        <div class="product-category"><?= esc($p['unit']) ?></div>
        <a href="/product/<?= esc($p['slug']) ?>" class="product-name"><?= esc($p['name']) ?></a>
        <div class="product-price">
          <span class="price-current">Rs. <?= number_format($p['price'],0) ?></span>
          <?php if($p['original_price']): ?>
          <span class="price-original">Rs. <?= number_format($p['original_price'],0) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <button class="product-add-btn btn-add-cart" data-product-id="<?= $p['id'] ?>"
              <?= $p['stock']<1?'disabled':'' ?>>
        <?= $p['stock']<1?'<i class="ri-close-circle-line"></i> Out of Stock':'<i class="ri-shopping-cart-line"></i> Add to Cart' ?>
      </button>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<script>
function applyFilters() {
  const sort = document.getElementById('sort-select').value;
  window.location = '/category/<?= esc($category['slug']) ?>?sort=' + sort;
}
</script>
          -->
<!-- breadcrumb -->
<div class="breadcrumb-section">
  <div class="container">
    <ol class="breadcrumb">
      <li><a href="<?= base_url() ?>">Home</a></li>
      <li class="sep"><i class="ri-arrow-right-s-line"></i></li>
      <li><?= esc($category['name']) ?></li>
    </ol>
  </div>
</div>

<div class="container" style="padding-top:1.5rem;padding-bottom:3rem">

  <!-- Category Banner -->
  <div class="scroll-reveal" style="background:linear-gradient(135deg,#16a34a,#15803d);border-radius:20px;padding:2.5rem;color:#fff;margin-bottom:2rem;display:flex;align-items:center;gap:1.5rem">
    <div style="font-size:4rem"><?= $category['icon'] ?></div>
    <div>
      <h1 style="color:#fff;margin-bottom:.25rem"><?= esc($category['name']) ?></h1>
      <p style="color:rgba(255,255,255,.85);margin:0"><?= $category['product_count'] ?> products available</p>
    </div>
  </div>

  <!-- Filter Bar -->
  <div class="filter-bar">
    <label><i class="ri-sort-desc"></i> Sort by:</label>
    <select class="filter-select" id="sort-select" onchange="applyFilters()">
      <option value="default" <?= $sort==='default'?'selected':'' ?>>Default</option>
      <option value="price_asc"  <?= $sort==='price_asc'?'selected':'' ?>>Price: Low to High</option>
      <option value="price_desc" <?= $sort==='price_desc'?'selected':'' ?>>Price: High to Low</option>
      <option value="rating"     <?= $sort==='rating'?'selected':'' ?>>Top Rated</option>
    </select>
    <button class="btn btn-outline btn-sm" onclick="applyFilters()">
      <i class="ri-filter-line"></i> Apply
    </button>
  </div>

  <!-- Products -->
  <?php if(empty($products)): ?>
  <div class="empty-state scroll-reveal">
    <div class="empty-state-icon">🔍</div>
    <h3>No Products Found</h3>
    <p>No products in this category yet.</p>
    <a href="<?= base_url() ?>" class="btn btn-primary">Back to Home</a>
  </div>
  <?php else: ?>
  <div class="products-grid stagger-grid">
    <?php foreach($products as $p): ?>
    <div class="product-card scroll-reveal">
      <div class="product-img-wrap">
        <img src="<?= base_url(esc($p['image_url'])) ?>" alt="<?= esc($p['name']) ?>"
             onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'" loading="lazy">
        <?php if($p['is_on_sale'] && $p['discount_percent'] > 0): ?>
        <span class="product-badge">-<?= $p['discount_percent'] ?>%</span>
        <?php elseif($p['is_featured']): ?>
        <span class="product-badge badge-featured">⭐</span>
        <?php endif; ?>
        <button class="product-wishlist-btn" onclick="toggleWishlistCat(<?= $p['id'] ?>, this)">
          <i class="ri-heart-line"></i>
        </button>
      </div>
      <div class="product-info">
        <div class="product-category"><?= esc($p['unit']) ?></div>
        <a href="<?= base_url('product/' . esc($p['slug'])) ?>" class="product-name"><?= esc($p['name']) ?></a>
        <div class="product-rating">
          <span class="stars">★★★★<?= $p['rating'] >= 4.5 ? '★' : '☆' ?></span>
          <span class="rating-count">(<?= $p['review_count'] ?>)</span>
        </div>
        <div class="product-price">
          <span class="price-current">Rs. <?= number_format($p['price'],0) ?></span>
          <?php if($p['original_price']): ?>
          <span class="price-original">Rs. <?= number_format($p['original_price'],0) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <button class="product-add-btn btn-add-cart" data-product-id="<?= $p['id'] ?>"
              <?= $p['stock']<1?'disabled':'' ?>>
        <?= $p['stock']<1 ? '<i class="ri-close-circle-line"></i> Out of Stock' : '<i class="ri-shopping-cart-line"></i> Add to Cart' ?>
      </button>
    </div>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>
</div>

<script>
function applyFilters() {
  const sort = document.getElementById('sort-select').value;
  window.location = BASE_URL + 'category/<?= esc($category['slug']) ?>?sort=' + sort;
}
function toggleWishlistCat(productId, btn) {
  if(!<?= session()->get('user_id') ? 'true' : 'false' ?>) {
    showToast('Please login to use wishlist.', 'info'); return;
  }
  fetch(BASE_URL + 'wishlist/toggle', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded','X-Requested-With':'XMLHttpRequest'},
    body:'product_id='+productId
  }).then(r=>r.json()).then(data=>{
    btn.classList.toggle('active', data.in_wishlist);
    btn.querySelector('i').className = data.in_wishlist ? 'ri-heart-fill' : 'ri-heart-line';
    showToast(data.message, 'success');
  });
}
</script>
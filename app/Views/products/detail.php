<div class="product-detail-page">
  <!-- Breadcrumb -->
  <div class="breadcrumb-section">
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>">Home</a></li>
        <li class="sep"><i class="ri-arrow-right-s-line"></i></li>
        <li><a href="<?= base_url('category/' . esc($category['slug'] ?? '')) ?>"><?= esc($category['name'] ?? 'Products') ?></a></li>
        <li class="sep"><i class="ri-arrow-right-s-line"></i></li>
        <li><?= esc($product['name']) ?></li>
      </ol>
    </div>
  </div>

  <div class="container" style="padding-top:2rem">
    <div class="row g-4">
      <!-- Image Gallery -->
      <div class="col-lg-5">
        <div class="product-gallery scroll-reveal">
          <img src="<?= base_url(esc($product['image_url'])) ?>" alt="<?= esc($product['name']) ?>"
               class="main-img" id="main-img"
               onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">
          <div class="thumb-row">
            <img src="<?= base_url(esc($product['image_url'])) ?>" class="thumb active" id="thumb-0"
                 onclick="switchImg(this.src, 0)" onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">
            <img src="<?= base_url(esc($product['image_url'])) ?>" class="thumb" id="thumb-1"
                 onclick="switchImg(this.src, 1)" onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">
            <img src="<?= base_url(esc($product['image_url'])) ?>" class="thumb" id="thumb-2"
                 onclick="switchImg(this.src, 2)" onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">
          </div>
        </div>
      </div>

      <!-- Product Info -->
      <div class="col-lg-7">
        <div class="scroll-reveal">
          <?php if($product['is_on_sale']): ?>
          <span class="product-badge" style="position:static;display:inline-block;margin-bottom:.75rem">
            🔥 <?= $product['discount_percent'] ?>% OFF
          </span>
          <?php endif; ?>
          <?php if($product['is_featured']): ?>
          <span class="product-badge badge-featured" style="position:static;display:inline-block;margin-bottom:.75rem;margin-left:.25rem">
            ⭐ Featured
          </span>
          <?php endif; ?>

          <h1 class="product-detail-name"><?= esc($product['name']) ?></h1>

          <div class="product-rating mb-3">
            <span class="stars" style="font-size:1.1rem">★★★★<?= $product['rating'] >= 4.5 ? '★' : '☆' ?></span>
            <span class="rating-count"><?= $product['rating'] ?> (<?= $product['review_count'] ?> reviews)</span>
          </div>

          <div class="mb-3" style="display:flex;align-items:baseline;gap:.75rem">
            <span class="product-detail-price">Rs. <?= number_format($product['price'], 0) ?></span>
            <?php if($product['original_price']): ?>
            <span class="product-detail-original">Rs. <?= number_format($product['original_price'], 0) ?></span>
            <?php endif; ?>
            <span class="product-unit"><?= esc($product['unit']) ?></span>
          </div>

          <?php if($product['stock'] > 0): ?>
          <span class="stock-badge in-stock mb-3 d-inline-flex">
            <i class="ri-checkbox-circle-line"></i> In Stock (<?= $product['stock'] ?> left)
          </span>
          <?php else: ?>
          <span class="stock-badge out-stock mb-3 d-inline-flex">
            <i class="ri-close-circle-line"></i> Out of Stock
          </span>
          <?php endif; ?>

          <!-- Quantity + Add to Cart -->
          <?php if($product['stock'] > 0): ?>
          <div class="d-flex align-items-center gap-3 mb-4 mt-3">
            <div class="qty-stepper" data-product-id="<?= $product['id'] ?>">
              <button class="qty-btn" onclick="changeQty(-1)">−</button>
              <span class="qty-val" id="qty-input">1</span>
              <button class="qty-btn" onclick="changeQty(1)">+</button>
            </div>
            <button class="btn btn-primary btn-lg flex-grow-1 btn-add-cart" data-product-id="<?= $product['id'] ?>">
              <i class="ri-shopping-cart-line"></i> Add to Cart
            </button>
            <button class="btn btn-outline" onclick="toggleWishlistDetail(<?= $product['id'] ?>, this)"
                    id="wishlist-btn" style="padding:.85rem 1.25rem">
              <i class="<?= $inWishlist ? 'ri-heart-fill' : 'ri-heart-line' ?>"></i>
            </button>
          </div>
          <?php else: ?>
          <button class="btn btn-outline btn-lg mt-3 mb-4" disabled>
            <i class="ri-notification-line"></i> Notify When Available
          </button>
          <?php endif; ?>

          <!-- Delivery Info -->
          <div style="background:var(--bg);border-radius:var(--radius);padding:1rem;margin-bottom:1.25rem">
            <div style="display:flex;gap:1.5rem;flex-wrap:wrap">
              <span style="font-size:.85rem"><i class="ri-truck-line" style="color:var(--green)"></i> Free delivery above Rs. 1000</span>
              <span style="font-size:.85rem"><i class="ri-shield-check-line" style="color:var(--green)"></i> Genuine products</span>
              <span style="font-size:.85rem"><i class="ri-refresh-line" style="color:var(--green)"></i> Easy returns</span>
            </div>
          </div>

          <!-- Accordion Description -->
          <div class="accordion" id="productAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#desc-collapse">
                  📋 Product Description
                </button>
              </h2>
              <div id="desc-collapse" class="accordion-collapse collapse show" data-bs-parent="#productAccordion">
                <div class="accordion-body" style="color:var(--gray)">
                  <?= nl2br(esc($product['description'])) ?>
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#delivery-collapse">
                  🚚 Delivery Information
                </button>
              </h2>
              <div id="delivery-collapse" class="accordion-collapse collapse" data-bs-parent="#productAccordion">
                <div class="accordion-body" style="color:var(--gray)">
                  <ul style="padding-left:1.25rem">
                    <li>Same-day delivery in Mardan for orders before 6 PM</li>
                    <li>Delivery fee: Rs. 150 for orders under Rs. 1,000</li>
                    <li>FREE delivery on orders above Rs. 1,000</li>
                    <li>Cash on Delivery (COD), JazzCash & EasyPaisa accepted</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Related Products -->
    <?php if(!empty($related)): ?>
    <div class="section" style="margin-top:3rem">
      <div class="section-header">
        <h2 class="section-title scroll-reveal">You May Also Like</h2>
      </div>
      <div class="h-scroll-wrapper">
        <button class="scroll-arrow left"><i class="ri-arrow-left-s-line"></i></button>
        <div class="h-scroll-container">
          <?php foreach($related as $rp): ?>
          <div class="product-card scroll-reveal">
            <div class="product-img-wrap">
              <img src="<?= base_url(esc($rp['image_url'])) ?>" alt="<?= esc($rp['name']) ?>"
                   onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'" loading="lazy">
              <?php if($rp['is_on_sale'] && $rp['discount_percent'] > 0): ?>
              <span class="product-badge">-<?= $rp['discount_percent'] ?>%</span>
              <?php endif; ?>
            </div>
            <div class="product-info">
              <div class="product-category"><?= esc($rp['unit']) ?></div>
              <a href="<?= base_url('product/' . esc($rp['slug'])) ?>" class="product-name"><?= esc($rp['name']) ?></a>
              <div class="product-price">
                <span class="price-current">Rs. <?= number_format($rp['price'], 0) ?></span>
              </div>
            </div>
            <button class="product-add-btn btn-add-cart" data-product-id="<?= $rp['id'] ?>">
              <i class="ri-shopping-cart-line"></i> Add to Cart
            </button>
          </div>
          <?php endforeach; ?>
        </div>
        <button class="scroll-arrow right"><i class="ri-arrow-right-s-line"></i></button>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
function changeQty(delta) {
  const el  = document.getElementById('qty-input');
  const max = <?= (int)$product['stock'] ?>;
  let val = parseInt(el.textContent) + delta;
  val = Math.max(1, Math.min(max, val));
  el.textContent = val;
}
function switchImg(src, idx) {
  document.getElementById('main-img').src = src;
  document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
  document.getElementById('thumb-' + idx)?.classList.add('active');
}
function toggleWishlistDetail(productId, btn) {
  if(!<?= session()->get('user_id') ? 'true' : 'false' ?>) {
    showToast('Please login to use wishlist.', 'info'); return;
  }
  fetch(BASE_URL + 'wishlist/toggle', {
    method: 'POST',
    headers: {'Content-Type':'application/x-www-form-urlencoded','X-Requested-With':'XMLHttpRequest'},
    body: 'product_id=' + productId
  }).then(r=>r.json()).then(data=>{
    const i = btn.querySelector('i');
    i.className = data.in_wishlist ? 'ri-heart-fill' : 'ri-heart-line';
    showToast(data.message, 'success');
  });
}
</script>
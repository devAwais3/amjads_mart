<div class="cart-page">
  <div class="container" style="padding-top:1.5rem;padding-bottom:3rem">
    <h1 class="mb-3 scroll-reveal">🛒 Shopping Cart</h1>

    <?php if (empty($items)): ?>
      <div class="empty-state scroll-reveal" id="empty-cart">
        <div class="empty-state-icon">🛒</div>
        <h3>Your cart is empty</h3>
        <p>Looks like you haven't added anything yet. Start shopping!</p>
        <a href="<?= base_url() ?>" class="btn btn-primary btn-lg">
          <i class="ri-store-2-line"></i> Start Shopping
        </a>
      </div>
    <?php else: ?>
      <div id="cart-content">
        <div class="row g-4">
          <!-- Cart Items -->
          <div class="col-lg-8">
            <table class="cart-table">
              <thead>
                <tr>
                  <th style="width:80px"></th>
                  <th>Product</th>
                  <th>Price</th>
                  <th>Quantity</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($items as $item): ?>
                  <tr data-product-id="<?= $item['product_id'] ?>" data-price="<?= $item['price'] ?>">
                    <td>
                      <a href="<?= base_url('product/' . esc($item['slug'] ?? '')) ?>"
                        <img src="/<?= esc($item['image_url']) ?>" class="cart-product-img"
                          onerror="this.src='/assets/images/placeholder.jpg'" alt="">
                      </a>
                    </td>
                    <td>
                      <div class="cart-product-name"><?= esc($item['name']) ?></div>
                      <div style="font-size:.78rem;color:var(--gray)"><?= esc($item['unit']) ?></div>
                    </td>
                    <td><strong>Rs. <?= number_format($item['price'], 0) ?></strong></td>
                    <td>
                      <div class="qty-stepper" data-product-id="<?= $item['product_id'] ?>">
                        <button class="qty-btn qty-dec">−</button>
                        <span class="qty-val"><?= $item['quantity'] ?></span>
                        <button class="qty-btn qty-inc">+</button>
                      </div>
                    </td>
                    <td>
                      <strong class="row-total">Rs. <?= number_format($item['price'] * $item['quantity'], 0) ?></strong>
                    </td>
                    <td>
                      <button class="cart-remove-btn" data-product-id="<?= $item['product_id'] ?>" title="Remove">
                        <i class="ri-delete-bin-6-line"></i>
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>

            <div class="mt-3 d-flex justify-content-between">
              <a href="<?= base_url() ?>" class="btn btn-outline">
                <i class="ri-arrow-left-line"></i> Continue Shopping
              </a>
            </div>
          </div>

          <!-- Order Summary -->
          <div class="col-lg-4">
            <div class="order-summary scroll-reveal">
              <h3>Order Summary</h3>

              <!-- Coupon -->
              <div class="coupon-row">
                <input type="text" id="coupon-input" placeholder="Coupon code" style="text-transform:uppercase">
                <button class="btn btn-outline btn-sm" id="apply-coupon-btn">Apply</button>
              </div>
              <div id="discount-row" style="display:none" class="summary-row" style="color:var(--green)">
                <span>Discount</span>
                <span style="color:var(--green)">- Rs. <span id="discount-amount">0</span></span>
              </div>

              <div class="summary-row">
                <span>Subtotal</span>
                <span id="summary-subtotal" data-val="<?= $subtotal ?>">Rs. <?= number_format($subtotal, 0) ?></span>
              </div>
              <div class="summary-row">
                <span>Delivery Fee</span>
                <span id="summary-delivery" class="<?= $deliveryFee == 0 ? 'free-delivery' : '' ?>">
                  <?= $deliveryFee == 0 ? '🎉 FREE' : 'Rs. ' . number_format($deliveryFee, 0) ?>
                </span>
              </div>
              <?php if ($deliveryFee > 0): ?>
                <p style="font-size:.78rem;color:var(--green);margin-bottom:.75rem">
                  Add Rs. <?= number_format(1000 - $subtotal, 0) ?> more for FREE delivery!
                </p>
              <?php endif; ?>
              <div class="summary-row total">
                <span>Total</span>
                <span id="summary-total">Rs. <?= number_format($total, 0) ?></span>
              </div>

              <a href="<?= base_url('checkout') ?>" class="btn btn-primary w-100 mt-3 btn-lg">
                <i class="ri-secure-payment-line"></i> Proceed to Checkout
              </a>
              <p style="font-size:.75rem;text-align:center;margin-top:.75rem;color:var(--gray)">
                <i class="ri-shield-check-line"></i> Secure checkout. Your data is safe.
              </p>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
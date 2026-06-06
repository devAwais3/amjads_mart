<div class="checkout-page">
  <div class="container" style="padding-top:1.5rem;padding-bottom:3rem;max-width:960px">
    <h1 class="mb-4 scroll-reveal">✅ Checkout</h1>

    <!-- Step Indicator -->
    <div class="checkout-steps scroll-reveal">
      <div class="step-item active" id="step-ind-1">
        <div class="step-circle">1</div>
        <div class="step-label">Delivery</div>
      </div>
      <div class="step-item" id="step-ind-2">
        <div class="step-circle">2</div>
        <div class="step-label">Payment</div>
      </div>
      <div class="step-item" id="step-ind-3">
        <div class="step-circle">3</div>
        <div class="step-label">Review</div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-lg-7">

        <!-- STEP 1: Delivery Info -->
        <div class="checkout-panel active" id="panel-1">
          <div style="background:var(--card-bg);border-radius:var(--radius-l);padding:1.75rem;box-shadow:var(--shadow)">
            <h3 class="mb-4">📍 Delivery Information</h3>
            <div class="row g-3">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Full Name *</label>
                  <input type="text" class="form-control" id="d-name" placeholder="Ali Khan"
                    value="<?= esc(session()->get('user_name') ?? '') ?>" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Phone Number *</label>
                  <input type="tel" class="form-control" id="d-phone" placeholder="0300-1234567" required>
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Delivery Address *</label>
                  <input type="text" class="form-control" id="d-address" placeholder="House/Street/Colony" required>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>City *</label>
                  <select class="form-control" id="d-city">
                    <option value="Mardan" selected>Mardan</option>
                    <option value="Takht Bhai">Takht Bhai</option>
                    <option value="Rustam">Rustam</option>
                    <option value="Katlang">Katlang</option>
                    <option value="Shergarh">Shergarh</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Area / Locality</label>
                  <input type="text" class="form-control" id="d-area" placeholder="e.g. Hoti, Shahbaz Garhi">
                </div>
              </div>
              <div class="col-12">
                <div class="form-group">
                  <label>Order Notes (optional)</label>
                  <textarea class="form-control" id="d-notes" rows="2" placeholder="Special instructions..."></textarea>
                </div>
              </div>
            </div>
            <button class="btn btn-primary btn-lg w-100 mt-2" onclick="goToStep(2)">
              Continue to Payment <i class="ri-arrow-right-line"></i>
            </button>
          </div>
        </div>

        <!-- STEP 2: Payment -->
        <div class="checkout-panel" id="panel-2">
          <div style="background:var(--card-bg);border-radius:var(--radius-l);padding:1.75rem;box-shadow:var(--shadow)">
            <h3 class="mb-4">💳 Payment Method</h3>

            <div class="payment-option selected" id="pay-cod" onclick="selectPayment('cod')">
              <span class="payment-icon">💵</span>
              <div>
                <strong>Cash on Delivery (COD)</strong>
                <div style="font-size:.82rem;color:var(--gray)">Pay cash when your order arrives</div>
              </div>
              <i class="ri-checkbox-circle-fill ms-auto" style="color:var(--green);font-size:1.3rem" id="check-cod"></i>
            </div>

            <div class="payment-option" id="pay-jazzcash" onclick="selectPayment('jazzcash')">
              <span class="payment-icon">🟣</span>
              <div>
                <strong>JazzCash</strong>
                <div style="font-size:.82rem;color:var(--gray)">Send to 0300-1234567 (Amjad Khan)</div>
              </div>
              <i class="ri-circle-line ms-auto" style="color:var(--gray-l);font-size:1.3rem" id="check-jazzcash"></i>
            </div>
            <div id="jazzcash-fields"
              style="display:none;margin-top:.5rem;padding:1rem;background:var(--bg);border-radius:var(--radius)">
              <label class="fw-600" style="font-size:.85rem">Transaction ID / Reference Number</label>
              <input type="text" class="form-control mt-1" id="jazzcash-txn" placeholder="e.g. TXN-12345678">
            </div>

            <div class="payment-option" id="pay-easypaisa" onclick="selectPayment('easypaisa')">
              <span class="payment-icon">🟢</span>
              <div>
                <strong>EasyPaisa</strong>
                <div style="font-size:.82rem;color:var(--gray)">Send to 0345-1234567 (Amjad Khan)</div>
              </div>
              <i class="ri-circle-line ms-auto" style="color:var(--gray-l);font-size:1.3rem" id="check-easypaisa"></i>
            </div>
            <div id="easypaisa-fields"
              style="display:none;margin-top:.5rem;padding:1rem;background:var(--bg);border-radius:var(--radius)">
              <label class="fw-600" style="font-size:.85rem">Transaction ID / Reference Number</label>
              <input type="text" class="form-control mt-1" id="easypaisa-txn" placeholder="e.g. EP-87654321">
            </div>

            <div class="d-flex gap-2 mt-3">
              <button class="btn btn-outline" onclick="goToStep(1)"><i class="ri-arrow-left-line"></i> Back</button>
              <button class="btn btn-primary flex-grow-1 btn-lg" onclick="goToStep(3)">Review Order <i
                  class="ri-arrow-right-line"></i></button>
            </div>
          </div>
        </div>

        <!-- STEP 3: Review -->
        <div class="checkout-panel" id="panel-3">
          <div style="background:var(--card-bg);border-radius:var(--radius-l);padding:1.75rem;box-shadow:var(--shadow)">
            <h3 class="mb-3">📋 Review Your Order</h3>
            <div id="review-delivery"
              style="background:var(--bg);border-radius:var(--radius);padding:1rem;margin-bottom:1.25rem"></div>
            <div id="review-payment"
              style="background:var(--bg);border-radius:var(--radius);padding:1rem;margin-bottom:1.5rem"></div>

            <div class="d-flex gap-2">
              <button class="btn btn-outline" onclick="goToStep(2)"><i class="ri-arrow-left-line"></i> Back</button>
              <button class="btn btn-primary flex-grow-1 btn-lg" id="place-order-btn" onclick="placeOrder()">
                <i class="ri-check-double-line"></i> Place Order
              </button>
            </div>
          </div>
        </div>

      </div>

      <!-- Order Summary Sidebar -->
      <div class="col-lg-5">
        <div class="order-summary scroll-reveal" style="position:sticky;top:90px">
          <h3>Order Summary</h3>
          <div style="max-height:280px;overflow-y:auto;margin-bottom:1rem">
            <?php foreach ($items as $item): ?>
              <div
                style="display:flex;align-items:center;gap:.75rem;margin-bottom:.75rem;padding-bottom:.75rem;border-bottom:1px solid var(--gray-l)">
                
                <img src="<?= base_url($item['image_url']) ?>" class="checkout-product-image"
                  onerror="this.src='<?= base_url('assets/images/placeholder.jpg') ?>'">

                <div style="flex:1">
                  <div style="font-size:.85rem;font-weight:600"><?= esc($item['name']) ?></div>
                  <div style="font-size:.78rem;color:var(--gray)">x<?= $item['quantity'] ?></div>
                </div>
                <strong>Rs. <?= number_format($item['price'] * $item['quantity'], 0) ?></strong>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="summary-row"><span>Subtotal</span><span>Rs. <?= number_format($subtotal, 0) ?></span></div>
          <div class="summary-row">
            <span>Delivery</span>
            <span
              class="<?= $deliveryFee == 0 ? 'free-delivery' : '' ?>"><?= $deliveryFee == 0 ? '🎉 FREE' : 'Rs. ' . number_format($deliveryFee, 0) ?></span>
          </div>
          <div id="co-discount-row" class="summary-row" style="display:none;color:var(--green)">
            <span>Discount</span>
            <span>- Rs. <span id="co-discount-amount">0</span></span>
          </div>
          <div class="summary-row total">
            <span>Total</span>
            <span id="co-total">Rs. <?= number_format($total, 0) ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  let selectedPayment = 'cod';

  const deliveryFee = <?= (int) $deliveryFee ?>;
  const subtotal = <?= (float) $subtotal ?>;

  function selectPayment(method) {
    selectedPayment = method;

    ['cod', 'jazzcash', 'easypaisa'].forEach(m => {

      document
        .getElementById('pay-' + m)
        .classList.toggle('selected', m === method);

      const check = document.getElementById('check-' + m);

      if (check) {
        check.className = (m === method)
          ? 'ri-checkbox-circle-fill ms-auto'
          : 'ri-circle-line ms-auto';

        check.style.color = (m === method)
          ? 'var(--green)'
          : 'var(--gray-l)';
      }

      const fields = document.getElementById(m + '-fields');

      if (fields) {
        fields.style.display =
          (m === method && m !== 'cod')
            ? 'block'
            : 'none';
      }
    });
  }

  function goToStep(step) {
    if (step === 2) {
      const name = document.getElementById('d-name').value.trim();
      const phone = document.getElementById('d-phone').value.trim();
      const addr = document.getElementById('d-address').value.trim();

      if (!name || !phone || !addr) {
        showToast(
          'Please fill all required delivery fields.',
          'error'
        );
        return;
      }
    }

    // Update panels
    document
      .querySelectorAll('.checkout-panel')
      .forEach(panel => panel.classList.remove('active'));

    document
      .getElementById('panel-' + step)
      .classList.add('active');

    // Update step indicators
    document
      .querySelectorAll('.step-item')
      .forEach((item, index) => {

        item.classList.remove('active', 'done');

        if (index + 1 < step) {
          item.classList.add('done');
        }

        if (index + 1 === step) {
          item.classList.add('active');
        }
      });

    if (step === 3) {
      buildReview();
    }

    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  }

  function buildReview() {
    const name = document.getElementById('d-name').value;
    const phone = document.getElementById('d-phone').value;
    const address = document.getElementById('d-address').value;
    const city = document.getElementById('d-city').value;
    const area = document.getElementById('d-area').value;

    document.getElementById('review-delivery').innerHTML = `
            <strong>📍 Delivery To:</strong><br>
            ${name} · ${phone}<br>
            ${address}${area ? ', ' + area : ''}, ${city}
        `;

    const payNames = {
      cod: 'Cash on Delivery',
      jazzcash: 'JazzCash',
      easypaisa: 'EasyPaisa'
    };

    document.getElementById('review-payment').innerHTML = `
            <strong>💳 Payment:</strong>
            ${payNames[selectedPayment] || selectedPayment}
        `;
  }

  function placeOrder() {
    const btn = document.getElementById('place-order-btn');

    const txnId =
      selectedPayment === 'jazzcash'
        ? document.getElementById('jazzcash-txn').value
        : selectedPayment === 'easypaisa'
          ? document.getElementById('easypaisa-txn').value
          : '';

    // ✅ REQUIRED + 14 DIGITS VALIDATION
    if (selectedPayment === 'jazzcash' || selectedPayment === 'easypaisa') {

        const cleanTxn = (txnId || '').trim();

        if (!cleanTxn) {
            showToast('Transaction ID is required', 'error');
            return;
        }

        // must be exactly 14 digits (numbers only)
        const isValid = /^\d{14}$/.test(cleanTxn);

        if (!isValid) {
            showToast('Transaction ID must be exactly 14 digits', 'error');
            return;
        }
    }

    btn.disabled = true;
    btn.innerHTML =
      '<i class="ri-loader-4-line spin"></i> Placing Order...';

    const couponCode =
      sessionStorage.getItem('coupon_code') || '';

    const body = new URLSearchParams({
      delivery_name: document.getElementById('d-name').value,
      delivery_phone: document.getElementById('d-phone').value,
      delivery_address: document.getElementById('d-address').value,
      delivery_city: document.getElementById('d-city').value,
      delivery_area: document.getElementById('d-area').value || '',
      order_notes: document.getElementById('d-notes').value || '',
      payment_method: selectedPayment,
      transaction_id: txnId,
      coupon_code: couponCode
    });

    fetch(BASE_URL + 'checkout/place-order', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: body.toString()
    })
      .then(response => response.json())
      .then(data => {

        if (data.success) {

          sessionStorage.removeItem('coupon_code');
          sessionStorage.removeItem('coupon_discount');

          window.location = data.redirect;

        } else {

          showToast(
            data.message || 'Error placing order.',
            'error'
          );

          btn.disabled = false;
          btn.innerHTML =
            '<i class="ri-check-double-line"></i> Place Order';
        }
      });
}
</script>
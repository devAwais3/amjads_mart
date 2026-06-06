<div class="success-page">
    <div class="success-card scroll-reveal">

        <div class="success-icon">✅</div>

        <h1 style="font-size:1.75rem; margin-bottom:.5rem;">
            Order Placed Successfully!
        </h1>

        <p style="margin-bottom:1.5rem;">
            Your order
            <strong>
                #<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?>
            </strong>
            has been received.
            <br>
            A confirmation email has been sent to your inbox.
        </p>

        <!-- Order Summary -->
        <div style="background:var(--bg); border-radius:var(--radius); padding:1.25rem; text-align:left; margin-bottom:1.5rem;">

            <div style="display:flex; justify-content:space-between; margin-bottom:.5rem;">
                <span style="color:var(--gray)">Order Status</span>
                <span class="order-status-badge status-pending">
                    Pending
                </span>
            </div>

            <div style="display:flex; justify-content:space-between; margin-bottom:.5rem;">
                <span style="color:var(--gray)">Payment Method</span>
                <strong><?= strtoupper($order['payment_method']) ?></strong>
            </div>

            <div style="display:flex; justify-content:space-between; margin-bottom:.5rem;">
                <span style="color:var(--gray)">Delivery To</span>
                <strong><?= esc($order['delivery_city']) ?></strong>
            </div>

            <div style="display:flex; justify-content:space-between;">
                <span style="color:var(--gray)">Total Paid</span>
                <strong style="color:var(--green); font-size:1.1rem;">
                    Rs. <?= number_format($order['total'], 0) ?>
                </strong>
            </div>

        </div>

        <!-- Delivery Information -->
        <div style="background:#fff7ed; border-radius:var(--radius); padding:1rem; margin-bottom:1.5rem; border-left:4px solid var(--yellow);">

            <strong>📍 Delivering to:</strong>
            <br>

            <?= esc($order['delivery_name']) ?>
            <br>

            <?= esc($order['delivery_address']) ?>,
            <?= esc($order['delivery_city']) ?>
            <br>

            <a
                href="https://wa.me/923001234567?text=Hi+I+have+an+order+%23<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?>"
                target="_blank"
                style="color:var(--green); font-weight:600; display:inline-flex; align-items:center; gap:.3rem; margin-top:.5rem;"
            >
                <i class="ri-whatsapp-line"></i>
                Track via WhatsApp
            </a>

        </div>

        <!-- Buttons -->
        <div style="display:flex; gap:.75rem; justify-content:center; flex-wrap:wrap;">

            <a href="<?= base_url() ?>" class="btn btn-primary btn-lg">
                <i class="ri-store-2-line"></i>
                Continue Shopping
            </a>

            <a href="<?= base_url('profile') ?>#orders" class="btn btn-outline btn-lg">
                <i class="ri-file-list-3-line"></i>
                My Orders
            </a>

        </div>

    </div>
</div>
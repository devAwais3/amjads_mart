<!-- ── FOOTER ──────────────────────────────────────────── -->
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <!-- Brand -->
      <div class="footer-brand">
        <h3>🛒 Amjad's Mart</h3>
        <p>Your trusted neighborhood online grocery store in Mardan, KPK. Fresh produce, daily essentials, and more — delivered fast to your doorstep.</p>
        <div class="social-row">
          <a href="https://wa.me/923001234567" class="social-btn" target="_blank" title="WhatsApp"><i class="ri-whatsapp-line"></i></a>
          <a href="#" class="social-btn" title="Facebook"><i class="ri-facebook-fill"></i></a>
          <a href="#" class="social-btn" title="Instagram"><i class="ri-instagram-line"></i></a>
          <a href="#" class="social-btn" title="TikTok"><i class="ri-tiktok-line"></i></a>
        </div>
      </div>

      <!-- Quick Links -->
      <div>
        <h4>Quick Links</h4>
        <ul class="footer-links">
          <li><a href="<?= base_url() ?>"><i class="ri-arrow-right-s-line"></i> Home</a></li>
          <li><a href="<?= base_url('category/groceries') ?>"><i class="ri-arrow-right-s-line"></i> Groceries</a></li>
          <li><a href="<?= base_url('category/fresh-dairy') ?>"><i class="ri-arrow-right-s-line"></i> Fresh & Dairy</a></li>
          <li><a href="<?= base_url('category/beverages') ?>"><i class="ri-arrow-right-s-line"></i> Beverages</a></li>
          <li><a href="<?= base_url('category/special-offers') ?>"><i class="ri-arrow-right-s-line"></i> Special Offers</a></li>
          <li><a href="<?= base_url('contact') ?>"><i class="ri-arrow-right-s-line"></i> Contact Us</a></li>
        </ul>
      </div>

      <!-- Customer -->
      <div>
        <h4>Customer</h4>
        <ul class="footer-links">
          <li><a href="<?= base_url('profile') ?>"><i class="ri-arrow-right-s-line"></i> My Account</a></li>
          <li><a href="<?= base_url('cart') ?>"><i class="ri-arrow-right-s-line"></i> Cart</a></li>
          <li><a href="<?= base_url('profile') ?>#orders"><i class="ri-arrow-right-s-line"></i> My Orders</a></li>
          <li><a href="<?= base_url('profile') ?>#wishlist"><i class="ri-arrow-right-s-line"></i> Wishlist</a></li>
          <li><a href="<?= base_url('contact') ?>"><i class="ri-arrow-right-s-line"></i> Help & Support</a></li>
        </ul>
      </div>

      <!-- Contact Info -->
      <div>
        <h4>Contact</h4>
        <ul class="footer-links">
          <li style="color:#94a3b8;font-size:.88rem;margin-bottom:.5rem">
            <i class="ri-map-pin-line" style="color:#16a34a"></i> Main Bazaar, Mardan, KPK
          </li>
          <li style="color:#94a3b8;font-size:.88rem;margin-bottom:.5rem">
            <i class="ri-phone-line" style="color:#16a34a"></i> 0300-1234567
          </li>
          <li style="color:#94a3b8;font-size:.88rem;margin-bottom:.5rem">
            <i class="ri-mail-line" style="color:#16a34a"></i> hello@amjadsmart.pk
          </li>
          <li style="color:#94a3b8;font-size:.88rem">
            <i class="ri-time-line" style="color:#16a34a"></i> Mon–Sat: 8am – 10pm
          </li>
        </ul>
      </div>
    </div>

    <div class="footer-bottom">
      <p style="color:#475569">© <?= date('Y') ?> Amjad's Mart. All rights reserved. Made with ❤️ in Mardan, KPK Pakistan.</p>
    </div>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js (loaded on admin pages but harmless globally) -->
<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script> -->
<!-- Custom JS -->

<script src="<?= base_url('assets/js/dark-mode.js') ?>"></script>
<script src="<?= base_url('assets/js/animations.js') ?>"></script>
<script src="<?= base_url('assets/js/search.js') ?>"></script>
<script src="<?= base_url('assets/js/cart.js') ?>"></script>
<script src="<?= base_url('assets/js/main.js') ?>"></script>
<script src="<?= base_url('assets/js/admin.js') ?>"></script>
<!-- <script src="/assets/js/dark-mode.js"></script>
<script src="/assets/js/animations.js"></script>
<script src="/assets/js/search.js"></script>
<script src="/assets/js/cart.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/js/admin.js"></script> -->
</body>
</html>
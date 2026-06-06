<div class="contact-page">
  <!-- Breadcrumb -->
  <div class="breadcrumb-section">
    <div class="container">
      <ol class="breadcrumb">
        <li><a href="<?= base_url() ?>">Home</a></li>
        <li class="sep"><i class="ri-arrow-right-s-line"></i></li>
        <li>Contact Us</li>
      </ol>
    </div>
  </div>

  <div class="container" style="padding-top:2rem">
    <h1 class="scroll-reveal mb-1">📬 Contact Us</h1>
    <p class="scroll-reveal" style="margin-bottom:2rem">Have a question or complaint? We'd love to hear from you!</p>

    <div class="row g-4">
      <!-- Contact Form -->
      <div class="col-lg-7">
        <div class="contact-card scroll-reveal">
          <h3 class="mb-4">Send us a Message</h3>
          <div class="row g-3">
            <div class="col-sm-6">
              <label class="fw-600 d-block mb-1" style="font-size:.88rem">Full Name *</label>
              <input type="text" class="form-control" id="c-name" placeholder="Your name">
            </div>
            <div class="col-sm-6">
              <label class="fw-600 d-block mb-1" style="font-size:.88rem">Email Address *</label>
              <input type="email" class="form-control" id="c-email" placeholder="your@email.com">
            </div>
            <div class="col-12">
              <label class="fw-600 d-block mb-1" style="font-size:.88rem">Subject *</label>
              <input type="text" class="form-control" id="c-subject" placeholder="e.g. Order issue, Product inquiry">
            </div>
            <div class="col-12">
              <label class="fw-600 d-block mb-1" style="font-size:.88rem">Message *</label>
              <textarea class="form-control" id="c-message" rows="5" placeholder="Describe your issue or question in detail... Minimum 100 words"></textarea>
            </div>
            <div class="col-12">
              <button class="btn btn-primary btn-lg" onclick="sendMessage()">
                <i class="ri-send-plane-line"></i> Send Message
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Info -->
      <div class="col-lg-5">
        <div class="contact-card scroll-reveal">
          <h3 class="mb-4">Get in Touch</h3>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="ri-map-pin-line"></i></div>
            <div>
              <strong>Store Location</strong><br>
              <span style="color:var(--gray);font-size:.9rem">Main Bazaar, Mardan, KPK, Pakistan</span>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="ri-whatsapp-line"></i></div>
            <div>
              <strong>WhatsApp</strong><br>
              <a href="https://wa.me/923001234567" target="_blank" style="color:var(--green);font-size:.9rem">
                0300-1234567
              </a>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="ri-mail-line"></i></div>
            <div>
              <strong>Email</strong><br>
              <span style="color:var(--gray);font-size:.9rem">hello@amjadsmart.pk</span>
            </div>
          </div>

          <div class="contact-info-item">
            <div class="contact-info-icon"><i class="ri-time-line"></i></div>
            <div>
              <strong>Business Hours</strong><br>
              <span style="color:var(--gray);font-size:.9rem">Mon – Sat: 8:00 AM – 10:00 PM</span><br>
              <span style="color:var(--gray);font-size:.9rem">Sunday: 9:00 AM – 8:00 PM</span>
            </div>
          </div>

          <!-- Google Maps Embed -->
          <div style="border-radius:var(--radius);overflow:hidden;margin-top:.5rem">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26594.03093097753!2d72.01!3d34.19!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38d90a7d9a1e5c4b%3A0x1234!2sMardan%2C%20KPK%2C%20Pakistan!5e0!3m2!1sen!2s!4v1700000000000"
              width="100%" height="200" style="border:0" allowfullscreen="" loading="lazy">
            </iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function sendMessage() {
  const name    = document.getElementById('c-name').value.trim();
  const email   = document.getElementById('c-email').value.trim();
  const subject = document.getElementById('c-subject').value.trim();
  const message = document.getElementById('c-message').value.trim();

  if(!name||!email||!subject||!message) { showToast('Please fill all fields.','error'); return; }

  fetch(BASE_URL + 'contact/send', {
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded','X-Requested-With':'XMLHttpRequest'},
    body: 'name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email) +
          '&subject=' + encodeURIComponent(subject) + '&message=' + encodeURIComponent(message)
  })
  .then(r=>r.json())
  .then(data=>{
    showToast(data.message, data.success?'success':'error');
    if(data.success) {
      document.getElementById('c-name').value='';
      document.getElementById('c-email').value='';
      document.getElementById('c-subject').value='';
      document.getElementById('c-message').value='';
    }
  });
}
</script>
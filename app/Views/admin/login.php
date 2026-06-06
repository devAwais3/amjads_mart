<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Login — Amjad's Mart</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
    rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: linear-gradient(135deg, #0f172a, #1e293b);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center
    }

    .card {
      background: rgba(255, 255, 255, .05);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, .1);
      border-radius: 20px;
      padding: 2.5rem;
      width: 100%;
      max-width: 400px;
      color: #fff
    }

    h1 {
      font-size: 1.6rem;
      margin-bottom: .25rem;
      color: #16a34a
    }

    p {
      color: #94a3b8;
      font-size: .85rem;
      margin-bottom: 2rem
    }

    label {
      display: block;
      font-size: .82rem;
      font-weight: 600;
      margin-bottom: .4rem;
      color: #cbd5e1
    }

    input {
      width: 100%;
      padding: .7rem 1rem;
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, .15);
      background: rgba(255, 255, 255, .08);
      color: #fff;
      font-size: .92rem;
      outline: none;
      margin-bottom: 1.25rem;
      font-family: inherit
    }

    input:focus {
      border-color: #16a34a;
      background: rgba(255, 255, 255, .12)
    }

    input::placeholder {
      color: #64748b
    }

    button {
      width: 100%;
      padding: .8rem;
      background: #16a34a;
      color: #fff;
      border: none;
      border-radius: 50px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      font-family: inherit;
      transition: background .2s
    }

    button:hover {
      background: #15803d
    }

    .error {
      background: rgba(239, 68, 68, .15);
      color: #fca5a5;
      padding: .75rem;
      border-radius: 10px;
      margin-bottom: 1rem;
      font-size: .85rem
    }
  </style>
</head>

<body>
  <div class="card">
    <h1>🔐 Admin Panel</h1>
    <p>Amjad's Mart · Administrator Access</p>
    <?php if (session()->getFlashdata('error')): ?>
      <div class="error"><i class="ri-error-warning-line"></i> <?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <form method="POST" action="<?= base_url('admin/login') ?>">
      <?= csrf_field() ?>
      <label>Email Address</label>
      <input type="email" name="email" placeholder="admin@amjadsmart.pk" required>
      <!-- <label>Password</label>
      <input type="password" name="password" placeholder="••••••••" required> -->
      <label>Password</label>

      <div style="position:relative;">
        <input type="password" id="password" name="password" placeholder="••••••••" required minlength="8"
          pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
          title="Password must be at least 8 characters and contain uppercase, lowercase, number and special character.">

        <button type="button" onclick="togglePassword()" style="
      position:absolute;
      right:12px;
      top:30%;
      transform:translateY(-50%);
      background:none;
      border:none;
      color:#94a3b8;
      cursor:pointer;
      width:auto;
      padding:0;">
          <i id="password-eye" class="ri-eye-line"></i>
        </button>
      </div>
      <button type="submit"><i class="ri-login-box-line"></i> Login to Admin</button>
    </form>
    <p style="text-align:center;margin-top:1rem;font-size:.78rem">
      <a href="<?= base_url() ?>" style="color:#16a34a">← Back to Store</a>
    </p>
  </div>

  <script>
function togglePassword() {
    const password = document.getElementById('password');
    const eye = document.getElementById('password-eye');

    if (password.type === 'password') {
        password.type = 'text';
        eye.className = 'ri-eye-off-line';
    } else {
        password.type = 'password';
        eye.className = 'ri-eye-line';
    }
}
</script>
</body>

</html>
<div class="auth-page">
    <div class="container">
        <div class="auth-card scroll-reveal">

            <div class="auth-logo">
                <h2>🛒 Amjad's Mart</h2>
                <p style="color:var(--gray);font-size:.9rem">
                    Fresh. Fast. Local.
                </p>
            </div>

            <!-- Tabs -->
            <div class="auth-tabs">
                <button class="auth-tab active" onclick="switchTab('login')">
                    Login
                </button>

                <button class="auth-tab" onclick="switchTab('register')">
                    Register
                </button>
            </div>

            <!-- LOGIN FORM -->
            <div class="auth-form active" id="form-login">

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" id="login-email" placeholder="you@example.com">
                </div>

                <div class="form-group">
                    <label>Password</label>

                    <div class="password-wrap">
                        <input type="password" class="form-control" id="login-password" placeholder="••••••••">

                        <button type="button" class="toggle-pw" onclick="togglePw('login-password', this)">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </div>

                <div style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        margin-bottom:1.25rem
                    ">
                    <label style="
                            display:flex;
                            align-items:center;
                            gap:.4rem;
                            cursor:pointer;
                            font-size:.88rem
                        ">
                        <input type="checkbox" id="login-remember">
                        Remember me
                    </label>

                    <a href="#" style="color:var(--green);font-size:.85rem">
                        Forgot password?
                    </a>
                </div>

                <button class="btn btn-primary w-100 btn-lg" onclick="doLogin()">
                    <i class="ri-login-box-line"></i>
                    Login
                </button>

                <p style="
                        text-align:center;
                        margin-top:1rem;
                        font-size:.88rem;
                        color:var(--gray)
                    ">
                    No account?

                    <a href="#" onclick="switchTab('register')" style="color:var(--green);font-weight:600">
                        Register here
                    </a>
                </p>

            </div>

            <!-- REGISTER FORM -->
            <div class="auth-form" id="form-register">

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" class="form-control" id="reg-name" placeholder="Enter your full name">
                </div>

                <div class="form-group">
                    <label>Email Address</label>

                    <div class="position-relative">
                        <input type="email" class="form-control" id="reg-email" placeholder="example@gmail.com"
                            oninput="checkEmailAsync()">

                        <span id="email-check" style="
                                position:absolute;
                                right:.75rem;
                                top:50%;
                                transform:translateY(-50%);
                                font-size:.8rem
                            "></span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" id="reg-phone" placeholder="03XX-XXXXXXX">
                </div>

                <div class="form-group">
                    <label>Password</label>

                    <div class="password-wrap">
                        <input type="password" class="form-control" id="reg-password" placeholder="Min. 8 characters">

                        <button type="button" class="toggle-pw" onclick="togglePw('reg-password', this)">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>

                    <div class="password-wrap">
                        <input type="password" class="form-control" id="reg-confirm" placeholder="Repeat password">

                        <button type="button" class="toggle-pw" onclick="togglePw('reg-confirm', this)">

                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:1.25rem">
                    <label style="
                            display:flex;
                            align-items:flex-start;
                            gap:.5rem;
                            cursor:pointer;
                            font-size:.85rem;
                            color:var(--gray)
                        ">
                        <input type="checkbox" id="reg-terms" style="margin-top:.15rem">

                        I agree to the
                        <a href="#" style="color:var(--green)">
                            Terms & Conditions
                        </a>
                    </label>
                </div>

                <button class="btn btn-primary w-100 btn-lg" onclick="doRegister()">
                    <i class="ri-user-add-line"></i>
                    Create Account
                </button>

                <p style="
                        text-align:center;
                        margin-top:1rem;
                        font-size:.88rem;
                        color:var(--gray)
                    ">
                    Have an account?

                    <a href="#" onclick="switchTab('login')" style="color:var(--green);font-weight:600">
                        Login here
                    </a>
                </p>

            </div>

        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        document.querySelectorAll('.auth-tab').forEach((t, i) => {
            t.classList.toggle(
                'active',
                (i === 0 && tab === 'login') ||
                (i === 1 && tab === 'register')
            );
        });

        document
            .getElementById('form-login')
            .classList.toggle('active', tab === 'login');

        document
            .getElementById('form-register')
            .classList.toggle('active', tab === 'register');
    }

    function togglePw(id, btn) {
        const input = document.getElementById(id);

        input.type =
            input.type === 'password'
                ? 'text'
                : 'password';

        btn.querySelector('i').className =
            input.type === 'password'
                ? 'ri-eye-line'
                : 'ri-eye-off-line';
    }

    let emailCheckTimer;

    function checkEmailAsync() {
        clearTimeout(emailCheckTimer);

        const email = document.getElementById('reg-email').value.trim();
        const el = document.getElementById('email-check');

        if (!email) {
            el.textContent = '';
            return;
        }

        emailCheckTimer = setTimeout(function () {
            fetch(BASE_URL + 'auth/check-email?email=' + encodeURIComponent(email))
                .then(r => r.json())
                .then(data => {
                    el.textContent =
                        data.exists
                            ? '❌ Email taken'
                            : '✅ Available';

                    el.style.color =
                        data.exists
                            ? 'var(--red)'
                            : 'var(--green)';
                });
        }, 400);
    }

    function doLogin() {
        const email =
            document.getElementById('login-email').value.trim();

        const password =
            document.getElementById('login-password').value;

        const remember =
            document.getElementById('login-remember').checked
                ? 1
                : 0;

        if (!email || !password) {
            showToast(
                'Please enter email and password.',
                'error'
            );
            return;
        }

        fetch(BASE_URL + 'auth/login', {
            method: 'POST',
            headers: {
                'Content-Type':
                    'application/x-www-form-urlencoded',
                'X-Requested-With':
                    'XMLHttpRequest'
            },
            body:
                'email=' +
                encodeURIComponent(email) +
                '&password=' +
                encodeURIComponent(password) +
                '&remember=' +
                remember
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(
                        'Welcome back!',
                        'success'
                    );

                    setTimeout(() => {
                        window.location = data.redirect;
                    }, 800);
                } else {
                    showToast(data.message, 'error');
                }
            });
    }

    function doRegister() {
        const name =
            document.getElementById('reg-name').value.trim();

        const email =
            document.getElementById('reg-email').value.trim();

        const phone =
            document.getElementById('reg-phone').value.trim();

        const password =
            document.getElementById('reg-password').value;

        const confirm =
            document.getElementById('reg-confirm').value;

        const terms =
            document.getElementById('reg-terms').checked;

        if (!name || !email || !password || !confirm) {
            showToast(
                'Please fill all required fields.',
                'error'
            );
            return;
        }

        if (password !== confirm) {
            showToast(
                'Passwords do not match.',
                'error'
            );
            return;
        }

        if (!terms) {
            showToast(
                'Please agree to the terms.',
                'error'
            );
            return;
        }

        fetch(BASE_URL + 'auth/register', {
            method: 'POST',
            headers: {
                'Content-Type':
                    'application/x-www-form-urlencoded',
                'X-Requested-With':
                    'XMLHttpRequest'
            },
            body:
                'full_name=' +
                encodeURIComponent(name) +
                '&email=' +
                encodeURIComponent(email) +
                '&phone=' +
                encodeURIComponent(phone) +
                '&password=' +
                encodeURIComponent(password) +
                '&confirm_password=' +
                encodeURIComponent(confirm)
        })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    showToast(
                        'Account created!',
                        'success'
                    );

                    setTimeout(() => {
                        window.location = data.redirect;
                    }, 800);
                } else {
                    const msg =
                        data.message ||
                        Object.values(data.errors || {})[0] ||
                        'Registration failed.';

                    showToast(msg, 'error');
                }
            });
    }
</script>
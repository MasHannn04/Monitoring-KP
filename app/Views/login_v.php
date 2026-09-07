<style>
    body {
        background-color: var(--bg-color);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
        font-family: 'Inter', sans-serif;
    }
    .login-container {
        background-color: var(--card-bg);
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.05);
        padding: 40px;
        width: 100%;
        max-width: 400px;
        text-align: center;
        margin: 0 auto;
    }
    .login-logo {
        color: var(--primary-blue);
        font-size: 45px;
        margin-bottom: 15px;
    }
    .login-title {
        font-size: 24px;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 5px;
        margin-top: 0;
    }
    .login-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        margin-bottom: 30px;
    }
    .form-group {
        text-align: left;
        margin-bottom: 20px;
    }
    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 8px;
    }
    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
        transition: all 0.3s;
    }
    .form-control:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(10, 88, 202, 0.1);
    }
    .btn-login {
        background-color: var(--primary-blue);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 14px;
        width: 100%;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }
    .btn-login:hover {
        background-color: #084298;
    }
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 13px;
        border: 1px solid #f5c6cb;
    }
    /* Hide top nav and sidebar for login page specifically if they are inadvertently loaded */
    .sidebar, .top-nav {
        display: none !important;
    }
    .main-content {
        margin-left: 0 !important;
        padding: 0 !important;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        background-color: var(--bg-color);
    }
</style>

<div class="login-container">
    <div class="login-logo">
        <i class="fa-solid fa-graduation-cap"></i>
    </div>
    <h1 class="login-title">SIM KP ITATS</h1>
    <p class="login-subtitle">Sistem Informasi Monitoring Kerja Praktek</p>

    <?php if(!empty($error)): ?>
    <div class="alert-error">
        <i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?= base_url('login') ?>">
        <div class="form-group">
            <label class="form-label">NPM / NIP</label>
            <input type="text" name="npm_nip" class="form-control" placeholder="Masukkan NPM atau NIP" required autofocus>
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
        </div>
        <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
            <input type="checkbox" name="remember" id="remember" style="width: 16px; height: 16px; cursor: pointer;">
            <label for="remember" style="font-size: 13px; color: var(--text-dark); cursor: pointer;">Ingat Saya</label>
        </div>
        <button type="submit" class="btn-login">Login Masuk <i class="fa-solid fa-arrow-right-to-bracket" style="margin-left: 5px;"></i></button>
    </form>
    
    <div style="margin-top: 30px; font-size: 12px; color: var(--text-muted);">
        &copy; 2026 Institut Teknologi Adhi Tama Surabaya
    </div>
</div>

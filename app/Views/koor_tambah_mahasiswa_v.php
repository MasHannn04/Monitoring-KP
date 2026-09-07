<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Pendaftaran Mahasiswa</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / Manajemen User / <span style="color: var(--primary-blue);">Daftar Mahasiswa Baru</span>
        </div>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Form Registrasi Mahasiswa KP</h2>
        
        <?php if(!empty($error)): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($success)): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <i class="fa-solid fa-circle-check"></i> <?= $success ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>
            <div class="form-group">
                <label class="form-label">NPM</label>
                <input type="text" name="npm_nip" class="form-control" placeholder="Masukkan NPM mahasiswa" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password Sementara</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password untuk mahasiswa" required>
                <small style="color: var(--text-muted); display: block; margin-top: 5px;">*Password ini akan digunakan mahasiswa untuk login pertama kali.</small>
            </div>
            
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;"><i class="fa-solid fa-user-plus"></i> Daftarkan Mahasiswa</button>
        </form>
    </div>
</div>

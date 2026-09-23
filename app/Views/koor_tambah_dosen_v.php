<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Pendaftaran Dosen</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / Manajemen User / <span style="color: var(--primary-blue);">Daftar Dosen Baru</span>
        </div>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Form Registrasi Dosen Pembimbing / Penguji</h2>
        
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
                <label class="form-label">Nama Lengkap beserta Gelar</label>
                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama lengkap (contoh: Dr. Budi, M.Kom)" required>
            </div>
            <div class="form-group">
                <label class="form-label">NIP</label>
                <input type="text" name="npm_nip" class="form-control" placeholder="Masukkan NIP dosen" required>
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label class="form-label" style="display: block; margin-bottom: 5px;">Program Studi</label>
                <select name="prodi" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Password Sementara</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password untuk login dosen" required>
                <small style="color: var(--text-muted); display: block; margin-top: 5px;">*Password ini akan digunakan dosen untuk login pertama kali.</small>
            </div>
            
            <button type="submit" class="btn btn-primary" style="margin-top: 10px;"><i class="fa-solid fa-user-plus"></i> Daftarkan Dosen</button>
        </form>
    </div>
</div>

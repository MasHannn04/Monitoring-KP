<?php
    $first_name = explode(' ', $_SESSION['nama'])[0];
    $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($first_name) . "&background=EBF4FF&color=103F80";
    $p = isset($_GET['p']) ? $_GET['p'] : '';
?>
    <aside class="sidebar">
        <div class="sidebar-header" style="cursor: pointer;" onclick="window.location.href='<?= base_url('mhs_dashboard') ?>'">
            <i class="fa-solid fa-graduation-cap" style="font-size: 24px;"></i>
            <h2>Monitoring<br>Kerja Praktek</h2>
        </div>
        <div class="sidebar-profile">
            <img src="<?= $avatar_url ?>" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; margin-bottom: 10px; object-fit: cover;">
            <h3><?= htmlspecialchars($_SESSION['nama']) ?></h3>
            <p><?= htmlspecialchars($_SESSION['npm_nip']) ?></p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?= base_url('mhs_dashboard') ?>" class="<?= ($p == 'mhs_dashboard') ? 'active' : '' ?>"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li class="menu-category">Administrasi KP</li>
            <li><a href="<?= base_url('mhs_pengajuan_kelompok') ?>" class="<?= ($p == 'mhs_pengajuan_kelompok') ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Pengajuan Kelompok</a></li>
            <li><a href="<?= base_url('mhs_pengajuan_izin') ?>" class="<?= ($p == 'mhs_pengajuan_izin') ? 'active' : '' ?>"><i class="fa-solid fa-envelope-open-text"></i> Pengajuan Izin KP</a></li>
            <li><a href="<?= base_url('mhs_pengajuan_bimbingan') ?>" class="<?= ($p == 'mhs_pengajuan_bimbingan') ? 'active' : '' ?>"><i class="fa-solid fa-chalkboard-user"></i> Pengajuan Bimbingan</a></li>
            <li class="menu-category">Pelaksanaan KP</li>
            <li><a href="<?= base_url('mhs_kemajuan_kp') ?>" class="<?= ($p == 'mhs_kemajuan_kp') ? 'active' : '' ?>"><i class="fa-solid fa-chart-line"></i> Kemajuan Laporan</a></li>
            <li><a href="<?= base_url('mhs_daftar_seminar') ?>" class="<?= ($p == 'mhs_daftar_seminar') ? 'active' : '' ?>"><i class="fa-solid fa-person-chalkboard"></i> Pendaftaran Seminar</a></li>
            <li><a href="<?= base_url('mhs_kumpul_laporan') ?>" class="<?= ($p == 'mhs_kumpul_laporan') ? 'active' : '' ?>"><i class="fa-solid fa-book"></i> Pengumpulan Laporan</a></li>
        </ul>
    </aside>
    <main class="main-wrapper">

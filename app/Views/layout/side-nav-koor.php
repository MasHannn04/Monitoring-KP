<?php
    $first_name = explode(' ', $_SESSION['nama'])[0];
    $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($first_name) . "&background=EBF4FF&color=103F80";
    $p = explode('/', uri_string())[0];
?>
    <aside class="sidebar">
        <div class="sidebar-header" style="cursor: pointer;" onclick="window.location.href='<?= base_url('koor_dashboard') ?>'">
            <i class="fa-solid fa-graduation-cap" style="font-size: 24px;"></i>
            <h2 style="font-size: 14px; line-height: 1.4;">Monitoring Kerja Praktek<br><span style="font-size: 11px; font-weight: 500; opacity: 0.8;">Sistem Informasi ITATS</span></h2>
            <i class="fa-solid fa-chevron-left sidebar-close" onclick="event.stopPropagation(); document.querySelector('.sidebar').classList.remove('open');"></i>
        </div>
        <div class="sidebar-profile">
            <img src="<?= $avatar_url ?>" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; margin-bottom: 10px; object-fit: cover;">
            <h3><?= htmlspecialchars($_SESSION['nama']) ?></h3>
            <p>Admin / Koordinator</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?= base_url('koor_dashboard') ?>" class="<?= ($p == 'koor_dashboard') ? 'active' : '' ?>"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li class="menu-category">Menu Approval</li>
            <li><a href="<?= base_url('koor_approval_kelompok') ?>" class="<?= ($p == 'koor_approval_kelompok' || $p == 'koor_detail_kelompok') ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Approval Kelompok</a></li>
            <li><a href="<?= base_url('koor_approval_izin') ?>" class="<?= ($p == 'koor_approval_izin' || $p == 'koor_detail_izin') ? 'active' : '' ?>"><i class="fa-solid fa-envelope-open-text"></i> Approval Izin KP</a></li>
            <li><a href="<?= base_url('koor_approval_bimbingan') ?>" class="<?= ($p == 'koor_approval_bimbingan' || $p == 'koor_detail_bimbingan') ? 'active' : '' ?>"><i class="fa-solid fa-chalkboard-user"></i> Approval Bimbingan</a></li>
            <li><a href="<?= base_url('koor_approval_seminar') ?>" class="<?= ($p == 'koor_approval_seminar' || $p == 'koor_detail_seminar') ? 'active' : '' ?>"><i class="fa-solid fa-person-chalkboard"></i> Approval Seminar</a></li>
            <li><a href="<?= base_url('koor_approval_laporan') ?>" class="<?= ($p == 'koor_approval_laporan') ? 'active' : '' ?>"><i class="fa-solid fa-book"></i> Approval Laporan Akhir</a></li>
            <li class="menu-category">Manajemen User</li>
            <li><a href="<?= base_url('koor_tambah_mahasiswa') ?>" class="<?= ($p == 'koor_tambah_mahasiswa') ? 'active' : '' ?>"><i class="fa-solid fa-user-plus"></i> Tambah Mahasiswa</a></li>
            <li><a href="<?= base_url('koor_list_mahasiswa') ?>" class="<?= ($p == 'koor_list_mahasiswa') ? 'active' : '' ?>"><i class="fa-solid fa-users-viewfinder"></i> Daftar Mahasiswa</a></li>
            <li><a href="<?= base_url('koor_tambah_dosen') ?>" class="<?= ($p == 'koor_tambah_dosen') ? 'active' : '' ?>"><i class="fa-solid fa-user-tie"></i> Tambah Dosen</a></li>
            <li><a href="<?= base_url('koor_list_dosen') ?>" class="<?= ($p == 'koor_list_dosen') ? 'active' : '' ?>"><i class="fa-solid fa-id-card-clip"></i> Daftar Dosen</a></li>
        </ul>
    </aside>
    <main class="main-wrapper">

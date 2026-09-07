<?php
    $first_name = explode(' ', $_SESSION['nama'])[0];
    $avatar_url = "https://ui-avatars.com/api/?name=" . urlencode($first_name) . "&background=EBF4FF&color=103F80";
    $p = isset($_GET['p']) ? $_GET['p'] : '';
?>
    <aside class="sidebar">
        <div class="sidebar-header" style="cursor: pointer;" onclick="window.location.href='<?= base_url('dosen_dashboard') ?>'">
            <i class="fa-solid fa-graduation-cap" style="font-size: 24px;"></i>
            <h2>Monitoring<br>Kerja Praktek</h2>
        </div>
        <div class="sidebar-profile">
            <img src="<?= $avatar_url ?>" alt="Profile" style="width: 60px; height: 60px; border-radius: 50%; margin-bottom: 10px; object-fit: cover;">
            <h3><?= htmlspecialchars($_SESSION['nama']) ?></h3>
            <p>Dosen Informatika</p>
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?= base_url('dosen_dashboard') ?>" class="<?= ($p == 'dosen_dashboard') ? 'active' : '' ?>"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li class="menu-category">Menu Pembimbing</li>
            <li><a href="<?= base_url('dosen_list_bimbingan') ?>" class="<?= ($p == 'dosen_list_bimbingan' || $p == 'dosen_detail_bimbingan') ? 'active' : '' ?>"><i class="fa-solid fa-users"></i> Mahasiswa Bimbingan</a></li>
            <li><a href="<?= base_url('dosen_approval_seminar') ?>" class="<?= ($p == 'dosen_approval_seminar') ? 'active' : '' ?>"><i class="fa-solid fa-user-check"></i> Validasi Syarat Sidang</a></li>
            <li><a href="<?= base_url('dosen_pengumpulan_laporan') ?>" class="<?= ($p == 'dosen_pengumpulan_laporan') ? 'active' : '' ?>"><i class="fa-solid fa-book-open"></i> Validasi Laporan Akhir</a></li>
            <li class="menu-category">Menu Penguji</li>
            <li><a href="<?= base_url('dosen_jadwal_seminar') ?>" class="<?= ($p == 'dosen_jadwal_seminar' || $p == 'dosen_detail_sidang') ? 'active' : '' ?>"><i class="fa-solid fa-calendar-days"></i> Jadwal Sidang Seminar</a></li>
        </ul>
    </aside>
    <main class="main-wrapper">

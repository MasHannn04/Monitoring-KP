<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Login::index');

$routes->match(['get', 'post'], 'dosen_approval_seminar', 'DosenApprovalSeminar::index');
$routes->match(['get', 'post'], 'dosen_dashboard', 'DosenDashboard::index');
$routes->match(['get', 'post'], 'dosen_detail_bimbingan', 'DosenDetailBimbingan::index');
$routes->match(['get', 'post'], 'dosen_detail_sidang', 'DosenDetailSidang::index');
$routes->match(['get', 'post'], 'dosen_jadwal_seminar', 'DosenJadwalSeminar::index');
$routes->match(['get', 'post'], 'dosen_list_bimbingan', 'DosenListBimbingan::index');
$routes->match(['get', 'post'], 'dosen_pengumpulan_laporan', 'DosenPengumpulanLaporan::index');
$routes->match(['get', 'post'], 'koor_approval_bimbingan', 'KoorApprovalBimbingan::index');
$routes->match(['get', 'post'], 'koor_approval_izin', 'KoorApprovalIzin::index');
$routes->match(['get', 'post'], 'koor_approval_kelompok', 'KoorApprovalKelompok::index');
$routes->match(['get', 'post'], 'koor_approval_laporan', 'KoorApprovalLaporan::index');
$routes->match(['get', 'post'], 'koor_approval_seminar', 'KoorApprovalSeminar::index');
$routes->match(['get', 'post'], 'koor_dashboard', 'KoorDashboard::index');
$routes->match(['get', 'post'], 'koor_detail_bimbingan', 'KoorDetailBimbingan::index');
$routes->match(['get', 'post'], 'koor_detail_izin', 'KoorDetailIzin::index');
$routes->match(['get', 'post'], 'koor_detail_kelompok', 'KoorDetailKelompok::index');
$routes->match(['get', 'post'], 'koor_detail_seminar', 'KoorDetailSeminar::index');
$routes->match(['get', 'post'], 'koor_list_dosen', 'KoorListDosen::index');
$routes->match(['get', 'post'], 'koor_list_mahasiswa', 'KoorListMahasiswa::index');
$routes->match(['get', 'post'], 'koor_tambah_dosen', 'KoorTambahDosen::index');
$routes->match(['get', 'post'], 'koor_tambah_mahasiswa', 'KoorTambahMahasiswa::index');
$routes->match(['get', 'post'], 'login', 'Login::index');
$routes->match(['get', 'post'], 'logout', 'Logout::index');
$routes->match(['get', 'post'], 'mhs_daftar_seminar', 'MhsDaftarSeminar::index');
$routes->match(['get', 'post'], 'mhs_dashboard', 'MhsDashboard::index');
$routes->match(['get', 'post'], 'mhs_kemajuan_kp', 'MhsKemajuanKp::index');
$routes->match(['get', 'post'], 'mhs_kumpul_laporan', 'MhsKumpulLaporan::index');
$routes->match(['get', 'post'], 'mhs_pengajuan_bimbingan', 'MhsPengajuanBimbingan::index');
$routes->match(['get', 'post'], 'mhs_pengajuan_izin', 'MhsPengajuanIzin::index');
$routes->match(['get', 'post'], 'mhs_pengajuan_kelompok', 'MhsPengajuanKelompok::index');

$routes->match(['get', 'post'], 'view_pdf', 'ViewPdf::index');
$routes->match(['get', 'post'], 'index.php', 'Login::index');

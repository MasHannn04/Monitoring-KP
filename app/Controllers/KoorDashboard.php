<?php

namespace App\Controllers;

class KoorDashboard extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();

// Stats matching HTML design
$q1 = $db->query("SELECT COUNT(*) as c FROM instansi WHERE status_izin = 'menunggu'");
$izin_baru = $q1->getRowArray()['c'];

$q2 = $db->query("SELECT COUNT(*) as c FROM bimbingan WHERE status_bimbingan = 'menunggu'");
$plot_dosen = $q2->getRowArray()['c'];

$q3 = $db->query("SELECT COUNT(*) as c FROM seminar WHERE status_koor = 'menunggu' AND (status_dospem = 'acc' OR status_dospem = 'disetujui')");
$jadwal_sidang = $q3->getRowArray()['c'];

$q4 = $db->query("SELECT COUNT(*) as c FROM bimbingan WHERE status_bimbingan = 'disetujui'");
$kelompok_aktif = $q4->getRowArray()['c'];

// Daftar Kelompok KP Aktif
$query_kelompok = "
    SELECT k.id, u.nama as ketua_nama, 
           (SELECT COUNT(*) FROM anggota_kelompok WHERE kelompok_id = k.id AND status_anggota = 'menerima') as jml_anggota,
           i.nama_instansi,
           k.status_kelompok,
           DATE_FORMAT(k.created_at, '%d-%b-%Y') as tgl_update
    FROM kelompok k
    JOIN users u ON k.ketua_id = u.id
    LEFT JOIN instansi i ON k.id = i.kelompok_id
    WHERE k.status_kelompok NOT IN ('draft', 'ditolak')
    ORDER BY k.created_at DESC
";
$list_kelompok = $db->query($query_kelompok);

$page_title = 'Dashboard Koordinator';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_dashboard_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

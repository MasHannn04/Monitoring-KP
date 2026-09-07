<?php

namespace App\Controllers;

class DosenDashboard extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dosen') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();

$dosen_id = $_SESSION['user_id'];

$q1 = $db->query("SELECT COUNT(*) as c FROM kelompok WHERE dospem_id = $dosen_id AND status_kelompok = 'disetujui'");
$mhs_bimbingan = $q1->getRowArray()['c'];

$q2 = $db->query("SELECT COUNT(*) as c FROM seminar s JOIN kelompok k ON s.kelompok_id = k.id WHERE (s.penguji1_id = $dosen_id OR s.penguji2_id = $dosen_id OR k.dospem_id = $dosen_id) AND s.status_koor = 'dijadwalkan'");
$jadwal_sidang = $q2 ? $q2->getRowArray()['c'] : 0;

$page_title = 'Dashboard Dosen';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-dosen.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('dosen_dashboard_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

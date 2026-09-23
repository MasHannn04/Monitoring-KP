<?php

namespace App\Controllers;

class MhsDashboard extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    return redirect()->to(base_url('login'));
}

$db = \Config\Database::connect();
helper('kp_status');

$user_id = (int)$_SESSION['user_id'];

$status_info = get_status_kp($user_id, $db);
$kelompok = $status_info['kelompok'];
$status_kp = $status_info['status_kp'];
$status_color = $status_info['status_color'];
$status_icon = $status_info['status_icon'];
$progress_width = $status_info['progress_width'];

$nilai_final = null;
$huruf_final = '-';
$nilai_perusahaan_done = false;

if (!empty($kelompok['id'])) {
    $kel_id = $kelompok['id'];
    $ql = $db->query("SELECT * FROM laporan_akhir WHERE kelompok_id = $kel_id");
    $laporan_data = null;
    if($ql && $ql->getNumRows() > 0) {
        $laporan_data = $ql->getRowArray();
    }
    
    $qs = $db->query("SELECT nilai_penguji1, nilai_penguji2 FROM anggota_kelompok WHERE kelompok_id = $kel_id AND mahasiswa_id = $user_id");
    $sem = $qs->getRowArray();
    if ($sem) {
        if ($sem['nilai_penguji1'] !== null && $sem['nilai_penguji2'] !== null) {
            if ($laporan_data && $laporan_data['nilai_perusahaan'] !== null) {
                $nilai_final = ((($sem['nilai_penguji1'] + $sem['nilai_penguji2']) / 2) + $laporan_data['nilai_perusahaan']) / 2;
                $nilai_perusahaan_done = true;
            } else {
                $nilai_final = ($sem['nilai_penguji1'] + $sem['nilai_penguji2']) / 2;
                $nilai_perusahaan_done = false;
            }
            if($nilai_final <= 40) $huruf_final = 'E';
            else if($nilai_final <= 50) $huruf_final = 'D';
            else if($nilai_final <= 60) $huruf_final = 'C';
            else if($nilai_final <= 65) $huruf_final = 'C+';
            else if($nilai_final <= 72) $huruf_final = 'B-';
            else if($nilai_final <= 75) $huruf_final = 'B';
            else if($nilai_final <= 79) $huruf_final = 'B+';
            else if($nilai_final <= 85) $huruf_final = 'A-';
            else if($nilai_final <= 90) $huruf_final = 'A';
            else $huruf_final = 'A+';
        }
    }
}

$page_title = 'Dashboard Mahasiswa';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-mhs.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('mhs_dashboard_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

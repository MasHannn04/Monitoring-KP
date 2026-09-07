<?php

namespace App\Controllers;

class MhsKemajuanKp extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


helper('workflow');

$workflow = check_mhs_workflow($db, $_SESSION['user_id'], 4);
if (!$workflow['allowed']) {
    $locked_message = $workflow['message'];
    $locked_redirect = $workflow['redirect_link'];
    $locked_button = $workflow['button_text'];
}

$mhs_id = $_SESSION['user_id'];
$q = $db->query("SELECT a.kelompok_id FROM anggota_kelompok a JOIN kelompok k ON a.kelompok_id = k.id WHERE a.mahasiswa_id = $mhs_id AND a.status_anggota = 'menerima' AND k.status_kelompok != 'ditolak' ORDER BY k.id DESC LIMIT 1");
$kel_id = 0;
if($q->getNumRows() > 0) {
    $kel_id = $q->getRowArray()['kelompok_id'];
}

$bimbingan_data = [];
$dospem_nama = "-";
$judul_kp = "-";
$logs = [];
$status_bimbingan = 'Menunggu Data';

if ($kel_id > 0) {
    $qb = $db->query("SELECT b.*, u.nama as dospem_nama FROM bimbingan b JOIN kelompok k ON b.kelompok_id = k.id LEFT JOIN users u ON k.dospem_id = u.id WHERE b.kelompok_id = $kel_id ORDER BY b.id DESC LIMIT 1");
    if($qb->getNumRows() > 0) {
        $bimbingan_data = $qb->getRowArray();
        $dospem_nama = $bimbingan_data['dospem_nama'] ?? "Belum ada Dosen Pembimbing";
        $judul_kp = $bimbingan_data['judul_laporan'] ?? "Belum ada Judul Laporan";
        // Map status bimbingan based on workflow
        $status_bimbingan = ($bimbingan_data['status_dospem'] == 'disetujui') ? 'Bimbingan Selesai (Di-ACC)' : 'Sedang Berjalan';
    }

    $qlog = $db->query("SELECT * FROM log_bimbingan WHERE kelompok_id = $kel_id ORDER BY id ASC");
    if ($qlog) {
        foreach ($qlog->getResultArray() as $r) {
            $logs[] = $r;
        }
    }
}

// Log cannot be readonly really, because they might add multiple logs.
// We just need the workflow guard to prevent access if not allowed.

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $kel_id > 0 && $workflow['allowed']) {
    $catatan = $db->escapeString($_POST['catatan'] ?? '');
    $tgl = date('Y-m-d');
    
    $db->query("INSERT INTO log_bimbingan (kelompok_id, tgl_bimbingan, catatan, status_log) VALUES ($kel_id, '$tgl', '$catatan', 'menunggu')");
    
    $_SESSION['swal_msg'] = 'Log bimbingan dikirim, menunggu review Dosen!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_kemajuan_kp'));
}


$page_title = 'Mhs Kemajuan Kp';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-mhs.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('mhs_kemajuan_kp_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

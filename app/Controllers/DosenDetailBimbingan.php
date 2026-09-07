<?php

namespace App\Controllers;

class DosenDetailBimbingan extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dosen') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


$kel_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$kelompok_data = null;
$logs = [];

if ($kel_id > 0) {
    // Ambil info kelompok
    $q = $db->query("
        SELECT k.id, u.nama as ketua, u.npm_nip, i.nama_instansi, b.judul_laporan, b.status_dospem
        FROM kelompok k 
        JOIN users u ON k.ketua_id = u.id 
        LEFT JOIN instansi i ON k.id = i.kelompok_id
        LEFT JOIN bimbingan b ON k.id = b.kelompok_id
        WHERE k.id = $kel_id
        ORDER BY b.id DESC LIMIT 1
    ");
    if($q->getNumRows() > 0) {
        $kelompok_data = $q->getRowArray();
    }
    
    $qlog = $db->query("SELECT * FROM log_bimbingan WHERE kelompok_id = $kel_id ORDER BY id ASC");
    if ($qlog) {
        foreach ($qlog->getResultArray() as $r) {
            $logs[] = $r;
        }
    }
} else {
    echo "ID Kelompok tidak valid.";
 return;
}

$total_logs = count($logs);
$total_acc = 0;
foreach($logs as $log) {
    if($log['status_log'] == 'acc') $total_acc++;
}
$can_approve_all = ($total_logs >= 10 && $total_acc == $total_logs);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve_all'])) {
        if (!$can_approve_all) {
            $_SESSION['swal_msg'] = 'Syarat bimbingan minimal 10 kali dan semua di-ACC belum terpenuhi!';
            $_SESSION['swal_type'] = 'error';
            return redirect()->to(base_url('dosen_detail_bimbingan?id=' . $kel_id));
        }
        $db->query("UPDATE bimbingan SET status_dospem = 'disetujui' WHERE kelompok_id = $kel_id");
        $_SESSION['swal_msg'] = 'Seluruh progres bimbingan telah di-ACC! Mahasiswa sekarang dapat mendaftar seminar.';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('dosen_detail_bimbingan?id=' . $kel_id));
    }
    
    if (isset($_POST['log_id'])) {
        $log_id = (int)$_POST['log_id'];
        $catatan_dosen = $db->escapeString($_POST['catatan_dosen'] ?? '');
        
        if (isset($_POST['approve'])) {
            $db->query("UPDATE log_bimbingan SET catatan_dosen = '$catatan_dosen', status_log = 'acc' WHERE id = $log_id");
        } else if (isset($_POST['reject'])) {
            $db->query("UPDATE log_bimbingan SET catatan_dosen = '$catatan_dosen', status_log = 'revisi' WHERE id = $log_id");
        }
        
        $_SESSION['swal_msg'] = 'Log berhasil diproses!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('dosen_detail_bimbingan?id=' . $kel_id));
    }
}


$page_title = 'Dosen Detail Bimbingan';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-dosen.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('dosen_detail_bimbingan_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

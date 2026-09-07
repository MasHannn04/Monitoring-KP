<?php

namespace App\Controllers;

class KoorApprovalKelompok extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    // Action dari tombol Setujui di list
    $id = (int)$_POST['kelompok_id'];
    if ($_POST['action'] == 'approve') {
        $db->query("UPDATE kelompok SET status_kelompok = 'disetujui' WHERE id = $id");
    } elseif ($_POST['action'] == 'reject') {
        $db->query("UPDATE kelompok SET status_kelompok = 'ditolak' WHERE id = $id");
    }
    $_SESSION['swal_msg'] = 'Status kelompok diperbarui!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_kelompok'));
}



$q_kel = $db->query("SELECT k.id, k.created_at FROM kelompok k WHERE k.status_kelompok = 'menunggu_validasi'");
$kelompok_list = [];
if($q_kel) {
    foreach ($q_kel->getResultArray() as $r){ 
        $kel_id = $r['id'];
        $q_m = $db->query("SELECT u.nama, a.is_ketua, a.status_anggota FROM anggota_kelompok a JOIN users u ON a.mahasiswa_id = u.id WHERE a.kelompok_id = $kel_id ORDER BY a.is_ketua DESC");
        $members = [];
        $semua_menerima = true;
        foreach ($q_m->getResultArray() as $m) {
            if($m['status_anggota'] != 'menerima') $semua_menerima = false;
            $members[] = $m;
        }
        $r['members'] = $members;
        $r['semua_menerima'] = $semua_menerima;
        $kelompok_list[] = $r; 
    }
}
$page_title = 'Koor Approval Kelompok';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_approval_kelompok_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

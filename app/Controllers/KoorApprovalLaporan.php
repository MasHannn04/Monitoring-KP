<?php

namespace App\Controllers;

class KoorApprovalLaporan extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['laporan_id'])) {
    $laporan_id = (int)$_POST['laporan_id'];
    if(isset($_POST['approve'])) {
        $db->query("UPDATE laporan_akhir SET status_koor = 'acc' WHERE id = $laporan_id");
        $_SESSION['swal_msg'] = 'SOP SELESAI! Mahasiswa lulus KP!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_laporan'));
    } return;
}

$q = $db->query("
    SELECT l.*, u.nama as ketua, u.npm_nip 
    FROM laporan_akhir l
    JOIN kelompok k ON l.kelompok_id = k.id
    JOIN users u ON k.ketua_id = u.id
    WHERE l.status_koor = 'menunggu' AND l.status_dospem = 'acc'
");
$laporan_list = [];
if($q) {
    foreach ($q->getResultArray() as $r) {
        $laporan_list[] = $r;
    }
}


$page_title = 'Koor Approval Laporan';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_approval_laporan_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

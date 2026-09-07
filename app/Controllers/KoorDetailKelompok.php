<?php

namespace App\Controllers;

class KoorDetailKelompok extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
    if (isset($_POST['approve'])) {
        $db->query("UPDATE kelompok SET status_kelompok = 'disetujui' WHERE id = $id");
    } else {
        $note = $db->escapeString($_POST['koor_note'] ?? '');
        $db->query("UPDATE kelompok SET status_kelompok = 'ditolak', koor_note = '$note' WHERE id = $id");
    }
    $_SESSION['swal_msg'] = 'Validasi selesai!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_kelompok'));
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = $db->query("SELECT * FROM kelompok WHERE id = $id");
$kelompok = $q->getRowArray();
if (!$kelompok) {
    echo "Data tidak ditemukan.";
 return;
}

$q_m = $db->query("SELECT u.nama, u.npm_nip, a.is_ketua, a.file_riwayat_studi FROM anggota_kelompok a JOIN users u ON a.mahasiswa_id = u.id WHERE a.kelompok_id = $id ORDER BY a.is_ketua DESC");
$members = [];
foreach ($q_m->getResultArray() as $m) {
    $members[] = $m;
}


$page_title = 'Koor Detail Kelompok';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_detail_kelompok_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

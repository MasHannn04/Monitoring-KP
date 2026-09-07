<?php

namespace App\Controllers;

class DosenApprovalSeminar extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dosen') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['seminar_id'])) {
    $seminar_id = (int)$_POST['seminar_id'];
    if(isset($_POST['approve'])) {
        $db->query("UPDATE seminar SET status_dospem = 'acc' WHERE id = $seminar_id");
        $_SESSION['swal_msg'] = 'Seminar disetujui, diteruskan ke Koordinator!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('dosen_approval_seminar'));
    } else if(isset($_POST['reject'])) {
        $catatan = $db->escapeString($_POST['catatan_tolak'] ?? '');
        $db->query("UPDATE seminar SET status_dospem = 'tolak', catatan_tolak = '$catatan' WHERE id = $seminar_id");
        $_SESSION['swal_msg'] = 'Seminar dikembalikan ke mahasiswa!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('dosen_approval_seminar'));
    } return;
}

$dosen_id = $_SESSION['user_id'];
$q = $db->query("
    SELECT s.*, u.nama as ketua, u.npm_nip, k.id as kelompok_id
    FROM seminar s
    JOIN kelompok k ON s.kelompok_id = k.id
    JOIN users u ON k.ketua_id = u.id
    WHERE k.dospem_id = $dosen_id AND s.status_dospem = 'menunggu'
");
$seminar_list = [];
if($q) {
    foreach ($q->getResultArray() as $r) {
        $seminar_list[] = $r;
    }
}


$page_title = 'Dosen Approval Seminar';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-dosen.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('dosen_approval_seminar_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

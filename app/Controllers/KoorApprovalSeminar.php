<?php

namespace App\Controllers;

class KoorApprovalSeminar extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


$q = $db->query("
    SELECT s.*, u.nama as ketua, u.npm_nip, i.nama_instansi, ud.nama as nama_dospem 
    FROM seminar s 
    JOIN kelompok k ON s.kelompok_id = k.id 
    JOIN users u ON k.ketua_id = u.id 
    LEFT JOIN instansi i ON k.id = i.kelompok_id 
    LEFT JOIN users ud ON k.dospem_id = ud.id 
    WHERE s.status_koor = 'menunggu' AND s.status_dospem = 'acc'
");
$seminar_list = [];
if($q) {
    foreach ($q->getResultArray() as $r) {
        $seminar_list[] = $r;
    }
}


$page_title = 'Koor Approval Seminar';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_approval_seminar_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

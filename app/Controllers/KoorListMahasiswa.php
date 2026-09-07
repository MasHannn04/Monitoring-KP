<?php

namespace App\Controllers;

class KoorListMahasiswa extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();
helper('kp_status');

$q_users = $db->query("SELECT * FROM users WHERE role = 'mahasiswa' ORDER BY nama ASC");
$mahasiswa_list = [];
if($q_users) {
    foreach ($q_users->getResultArray() as $r) {
        $status_info = get_status_kp($r['id'], $db);
        $r['status_info'] = $status_info;
        $mahasiswa_list[] = $r;
    }
}

$page_title = 'Daftar Mahasiswa';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_list_mahasiswa_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

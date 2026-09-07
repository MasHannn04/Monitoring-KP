<?php

namespace App\Controllers;

class DosenListBimbingan extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dosen') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();
helper('kp_status');

$dosen_id = (int)$_SESSION['user_id'];

// Get all students associated with any group where dospem_id = $dosen_id
$q_users = $db->query("
    SELECT u.* 
    FROM users u 
    JOIN anggota_kelompok a ON u.id = a.mahasiswa_id 
    JOIN kelompok k ON a.kelompok_id = k.id 
    WHERE k.dospem_id = $dosen_id AND a.status_anggota IN ('menerima', 'ketua')
    GROUP BY u.id
    ORDER BY u.nama ASC
");

$mahasiswa_list = [];
if($q_users) {
    foreach ($q_users->getResultArray() as $r) {
        $status_info = get_status_kp($r['id'], $db);
        $r['status_info'] = $status_info;
        $mahasiswa_list[] = $r;
    }
}

$page_title = 'Dosen List Bimbingan';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-dosen.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('dosen_list_bimbingan_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

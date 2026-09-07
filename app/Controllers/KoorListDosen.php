<?php

namespace App\Controllers;

class KoorListDosen extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();

// Get list of Dosen
$q_dosen = $db->query("SELECT * FROM users WHERE role = 'dosen' ORDER BY nama ASC");
$dosen_list = [];

if($q_dosen) {
    foreach ($q_dosen->getResultArray() as $r) {
        $dosen_id = $r['id'];
        
        // Count mahasiswa bimbingan (based on kelompok where dospem_id is this dosen)
        $q_bimbingan = $db->query("
            SELECT COUNT(u.id) as total 
            FROM users u 
            JOIN anggota_kelompok a ON u.id = a.mahasiswa_id 
            JOIN kelompok k ON a.kelompok_id = k.id 
            WHERE k.dospem_id = $dosen_id AND a.status_anggota IN ('menerima', 'ketua')
        ");
        $r['total_bimbingan'] = $q_bimbingan ? $q_bimbingan->getRowArray()['total'] : 0;
        
        // Count jadwal penguji (based on seminar where penguji_id is this dosen)
        $q_penguji = $db->query("
            SELECT COUNT(k.id) as total 
            FROM seminar s 
            JOIN kelompok k ON s.kelompok_id = k.id 
            WHERE s.penguji2_id = $dosen_id
        ");
        $r['total_penguji'] = $q_penguji ? $q_penguji->getRowArray()['total'] : 0;
        
        $dosen_list[] = $r;
    }
}

$page_title = 'Daftar Dosen';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_list_dosen_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

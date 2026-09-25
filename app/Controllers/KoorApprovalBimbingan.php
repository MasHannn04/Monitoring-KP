<?php

namespace App\Controllers;

class KoorApprovalBimbingan extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();






$q_bim = $db->query("
    SELECT b.id, b.tgl_mulai_kp, b.tgl_selesai_kp, b.status_bimbingan, k.id as kel_id, k.created_at, u.nama as ketua, 
           i.nama_instansi,
           (SELECT count(*) FROM anggota_kelompok WHERE kelompok_id = k.id AND status_anggota = 'menerima') as jumlah_anggota
    FROM bimbingan b 
    JOIN kelompok k ON b.kelompok_id = k.id 
    JOIN users u ON k.ketua_id = u.id 
    LEFT JOIN instansi i ON k.id = i.kelompok_id
    WHERE b.status_bimbingan IN ('menunggu', 'disetujui') ORDER BY b.id DESC
");
$bimbingan_list = [];
if ($q_bim) {
    foreach ($q_bim->getResultArray() as $r){ $bimbingan_list[] = $r; }
}
$page_title = 'Koor Approval Bimbingan';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_approval_bimbingan_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

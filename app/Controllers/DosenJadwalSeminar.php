<?php

namespace App\Controllers;

class DosenJadwalSeminar extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dosen') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();

// TODO: Tambahkan logika CRUD di sini


$dosen_id = $_SESSION['user_id'];
$q_sem = $db->query("
    SELECT s.*, u.nama as ketua, u.npm_nip, k.dospem_id, b.judul_laporan, i.nama_instansi,
           ud.nama as nama_dospem, up1.nama as nama_penguji1, up2.nama as nama_penguji2
    FROM seminar s 
    JOIN kelompok k ON s.kelompok_id = k.id 
    JOIN users u ON k.ketua_id = u.id 
    LEFT JOIN bimbingan b ON b.id = (SELECT id FROM bimbingan WHERE kelompok_id = k.id ORDER BY id DESC LIMIT 1)
    LEFT JOIN instansi i ON k.id = i.kelompok_id
    LEFT JOIN users ud ON k.dospem_id = ud.id
    LEFT JOIN users up1 ON s.penguji1_id = up1.id
    LEFT JOIN users up2 ON s.penguji2_id = up2.id
    WHERE s.status_koor = 'dijadwalkan' 
      AND (k.dospem_id = $dosen_id OR s.penguji1_id = $dosen_id OR s.penguji2_id = $dosen_id)
      AND s.id = (SELECT id FROM seminar WHERE kelompok_id = k.id ORDER BY id DESC LIMIT 1)
");
$seminar_list = [];
if($q_sem) {
    foreach ($q_sem->getResultArray() as $r){ $seminar_list[] = $r; }
}
$page_title = 'Dosen Jadwal Seminar';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-dosen.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('dosen_jadwal_seminar_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

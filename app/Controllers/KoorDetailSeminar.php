<?php

namespace App\Controllers;

class KoorDetailSeminar extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();

$seminar_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['terbitkan'])) {
        $penguji1 = (int)$_POST['penguji1_id'];
        $penguji2 = (int)$_POST['penguji2_id'];
        $tgl = $db->escapeString($_POST['tgl_seminar']);
        $jam = $db->escapeString($_POST['jam_seminar']);
        $ruang = $db->escapeString($_POST['ruangan']);
        
        $db->query("UPDATE seminar SET status_koor = 'dijadwalkan', penguji1_id = $penguji1, penguji2_id = $penguji2, tgl_seminar = '$tgl', jam_seminar = '$jam', ruangan = '$ruang' WHERE id = $seminar_id");
        
        $_SESSION['swal_msg'] = 'Seminar berhasil dijadwalkan!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_seminar'));
    } else if (isset($_POST['tolak'])) {
        $catatan = $db->escapeString($_POST['catatan_tolak'] ?? '');
        $db->query("UPDATE seminar SET status_koor = 'tolak', catatan_tolak = '$catatan' WHERE id = $seminar_id");
        $_SESSION['swal_msg'] = 'Pendaftaran seminar ditolak dan dikembalikan ke mahasiswa!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_seminar'));
    }
}

$seminar_data = null;
if ($seminar_id > 0) {
    $q = $db->query("
        SELECT s.*, u.nama as ketua, u.npm_nip, i.nama_instansi, ud.nama as nama_dospem, 
               b.judul_laporan, b.tgl_mulai_kp, b.tgl_selesai_kp, k.dospem_id
        FROM seminar s 
        JOIN kelompok k ON s.kelompok_id = k.id 
        JOIN users u ON k.ketua_id = u.id 
        LEFT JOIN instansi i ON k.id = i.kelompok_id 
        LEFT JOIN users ud ON k.dospem_id = ud.id 
        LEFT JOIN bimbingan b ON k.id = b.kelompok_id
        WHERE s.id = $seminar_id
    ");
    if($q && $q->getNumRows() > 0) {
        $seminar_data = $q->getRowArray();
    }
}

if(!$seminar_data) {
    echo "Data seminar tidak ditemukan.";
 return;
}

// Get dosen list (exclude dospem)
$dospem_id = $seminar_data['dospem_id'];
$qdosen = $db->query("SELECT id, nama FROM users WHERE role = 'dosen' AND id != $dospem_id");
$dosen_list = [];
if($qdosen) {
    foreach ($qdosen->getResultArray() as $rd){ $dosen_list[] = $rd; }
}
$page_title = 'Koor Detail Seminar';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_detail_seminar_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

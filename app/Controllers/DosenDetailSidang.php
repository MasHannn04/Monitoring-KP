<?php

namespace App\Controllers;

class DosenDetailSidang extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dosen') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


$seminar_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nilai'])) {
    $nilai = (float)$_POST['nilai'];
    $revisi = $db->escapeString($_POST['revisi']);
    $dosen_id = $_SESSION['user_id'];
    
    $qs = $db->query("SELECT s.*, k.dospem_id FROM seminar s JOIN kelompok k ON s.kelompok_id = k.id WHERE s.id = $seminar_id");
    $sem = $qs->getRowArray();
    
    $updates = [];
    if($sem['dospem_id'] == $dosen_id) {
        $updates[] = "nilai_pembimbing = $nilai, revisi_pembimbing = '$revisi'";
    }
    if($sem['penguji1_id'] == $dosen_id) {
        $updates[] = "nilai_penguji1 = $nilai, revisi_penguji1 = '$revisi'";
    }
    if($sem['penguji2_id'] == $dosen_id) {
        $updates[] = "nilai_penguji2 = $nilai, revisi_penguji2 = '$revisi'";
    }
    
    if(!empty($updates)) {
        $sql = "UPDATE seminar SET " . implode(", ", $updates) . " WHERE id = $seminar_id";
        $db->query($sql);
    }
    
    $_SESSION['swal_msg'] = 'Nilai dan revisi berhasil disimpan!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('dosen_detail_sidang?id=' . $seminar_id));
}

$seminar_data = null;
if($seminar_id > 0) {
    $q = $db->query("
        SELECT s.*, u.nama as ketua, u.npm_nip, k.dospem_id, b.judul_laporan,
               ud.nama as nama_dospem, up1.nama as nama_penguji1, up2.nama as nama_penguji2
        FROM seminar s 
        JOIN kelompok k ON s.kelompok_id = k.id 
        JOIN users u ON k.ketua_id = u.id 
        LEFT JOIN bimbingan b ON k.id = b.kelompok_id
        LEFT JOIN users ud ON k.dospem_id = ud.id
        LEFT JOIN users up1 ON s.penguji1_id = up1.id
        LEFT JOIN users up2 ON s.penguji2_id = up2.id
        WHERE s.id = $seminar_id
    ");
    if($q && $q->getNumRows() > 0) {
        $seminar_data = $q->getRowArray();
    }
}

if(!$seminar_data) {
    echo "Data sidang tidak ditemukan.";
 return;
}


$page_title = 'Dosen Detail Sidang';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-dosen.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('dosen_detail_sidang_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

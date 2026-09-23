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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nilai_mahasiswa'])) {
    $dosen_id = $_SESSION['user_id'];
    
    $qs = $db->query("SELECT s.*, k.dospem_id FROM seminar s JOIN kelompok k ON s.kelompok_id = k.id WHERE s.id = $seminar_id");
    $sem = $qs->getRowArray();
    
    $is_penguji1 = ($sem['penguji1_id'] == $dosen_id);
    $is_penguji2 = ($sem['penguji2_id'] == $dosen_id);
    
    foreach ($_POST['nilai_mahasiswa'] as $mhs_id => $nilai) {
        $nilai_val = (float)$nilai;
        $revisi_val = $db->escapeString($_POST['revisi_mahasiswa'][$mhs_id] ?? '');
        
        $updates = [];
        if ($is_penguji1) {
            $updates[] = "nilai_penguji1 = $nilai_val, revisi_penguji1 = '$revisi_val'";
        }
        if ($is_penguji2) {
            $updates[] = "nilai_penguji2 = $nilai_val, revisi_penguji2 = '$revisi_val'";
        }
        
        if (!empty($updates)) {
            $sql = "UPDATE anggota_kelompok SET " . implode(", ", $updates) . " WHERE kelompok_id = " . $sem['kelompok_id'] . " AND mahasiswa_id = " . (int)$mhs_id;
            $db->query($sql);
        }
    }
    
    $_SESSION['swal_msg'] = 'Nilai dan revisi berhasil disimpan!';
    $_SESSION['swal_type'] = 'success';
    return redirect()->to(base_url('dosen_detail_sidang?id=' . $seminar_id));
}

$seminar_data = null;
$anggota_list = [];
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
        
        // Fetch anggota_list
        $q_anggota = $db->query("
            SELECT ak.*, u.nama, u.npm_nip 
            FROM anggota_kelompok ak
            JOIN users u ON ak.mahasiswa_id = u.id
            WHERE ak.kelompok_id = " . $seminar_data['kelompok_id'] . "
            ORDER BY ak.is_ketua DESC, u.npm_nip ASC
        ");
        $anggota_list = $q_anggota->getResultArray();
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

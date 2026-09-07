<?php

namespace App\Controllers;

class MhsDaftarSeminar extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


helper('workflow');


$workflow = check_mhs_workflow($db, $_SESSION['user_id'], 5);
if (!$workflow['allowed']) {
    $locked_message = $workflow['message'];
    $locked_redirect = $workflow['redirect_link'];
    $locked_button = $workflow['button_text'];
}

$mhs_id = $_SESSION['user_id'];
$q = $db->query("SELECT a.kelompok_id, a.is_ketua FROM anggota_kelompok a JOIN kelompok k ON a.kelompok_id = k.id WHERE a.mahasiswa_id = $mhs_id AND a.status_anggota = 'menerima' AND k.status_kelompok != 'ditolak' ORDER BY k.id DESC LIMIT 1");
$kel_id = 0;
$is_user_ketua = false;
if($q->getNumRows() > 0) {
    $row_user = $q->getRowArray();
    $kel_id = $row_user['kelompok_id'];
    $is_user_ketua = (bool)$row_user['is_ketua'];
}

$seminar_data = null;
$is_readonly = false;
$bimbingan_data = null;

if ($kel_id > 0) {
    // Fetch bimbingan to get judul_laporan
    $qb = $db->query("SELECT * FROM bimbingan WHERE kelompok_id = $kel_id ORDER BY id DESC LIMIT 1");
    if($qb->getNumRows() > 0) {
        $bimbingan_data = $qb->getRowArray();
    }

    $qs = $db->query("
        SELECT s.*, 
               u1.nama as nama_penguji1, 
               u2.nama as nama_penguji2 
        FROM seminar s 
        LEFT JOIN users u1 ON s.penguji1_id = u1.id 
        LEFT JOIN users u2 ON s.penguji2_id = u2.id 
        WHERE s.kelompok_id = $kel_id 
        ORDER BY s.id DESC LIMIT 1
    ");
    if($qs->getNumRows() > 0) {
        $seminar_data = $qs->getRowArray();
        if ($seminar_data['status_dospem'] != 'tolak' && $seminar_data['status_koor'] != 'tolak') {
            $is_readonly = true;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$is_readonly && $kel_id > 0 && $workflow['allowed']) {
    if (!$is_user_ketua) {
        $_SESSION['swal_msg'] = 'Akses Ditolak: Hanya ketua kelompok yang dapat mengajukan form pendaftaran seminar!';
            $_SESSION['swal_type'] = 'error';
            return redirect()->to(base_url('mhs_daftar_seminar'));
    }

    $judul_laporan = $db->escapeString($_POST['judul_laporan'] ?? '');
    
    // Update judul di bimbingan
    $db->query("UPDATE bimbingan SET judul_laporan = '$judul_laporan' WHERE kelompok_id = $kel_id");
    
    // Handle File Uploads
    $upload_dir = FCPATH . 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_draft = '';
    $file_slip = '';

    if (isset($_FILES['file_draft_laporan']) && $_FILES['file_draft_laporan']['error'] == 0) {
        $res = safe_upload_file($_FILES['file_draft_laporan'], $upload_dir, 'draft_laporan');
        if ($res) $file_draft = $res;
    }
    
    if (isset($_FILES['file_slip_seminar']) && $_FILES['file_slip_seminar']['error'] == 0) {
        $res = safe_upload_file($_FILES['file_slip_seminar'], $upload_dir, 'slip_seminar');
        if ($res) $file_slip = $res;
    }
    
    if($seminar_data && ($seminar_data['status_dospem'] == 'tolak' || $seminar_data['status_koor'] == 'tolak')) {
        // Keep old files if not re-uploaded
        if(!$file_draft) $file_draft = $seminar_data['file_draft_laporan'];
        if(!$file_slip) $file_slip = $seminar_data['file_slip_seminar'];
        
        $db->query("UPDATE seminar SET file_draft_laporan = '$file_draft', file_slip_seminar = '$file_slip', status_dospem = 'menunggu', status_koor = 'menunggu' WHERE kelompok_id = $kel_id");
    } else {
        $db->query("INSERT INTO seminar (kelompok_id, file_draft_laporan, file_slip_seminar, status_dospem, status_koor) 
                      VALUES ($kel_id, '$file_draft', '$file_slip', 'menunggu', 'menunggu')");
    }
    
    $_SESSION['swal_msg'] = 'Pendaftaran Seminar Terkirim!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_daftar_seminar'));
}


$page_title = 'Mhs Daftar Seminar';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-mhs.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('mhs_daftar_seminar_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

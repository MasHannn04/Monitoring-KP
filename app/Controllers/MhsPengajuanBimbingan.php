<?php

namespace App\Controllers;

class MhsPengajuanBimbingan extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


helper('workflow');


$workflow = check_mhs_workflow($db, $_SESSION['user_id'], 3);
if (!$workflow['allowed']) {
    $locked_message = $workflow['message'];
    $locked_redirect = $workflow['redirect_link'];
    $locked_button = $workflow['button_text'];
}

$mhs_id = $_SESSION['user_id'];
$q = $db->query("SELECT a.kelompok_id FROM anggota_kelompok a JOIN kelompok k ON a.kelompok_id = k.id WHERE a.mahasiswa_id = $mhs_id AND a.status_anggota = 'menerima' AND k.status_kelompok != 'ditolak' ORDER BY k.id DESC LIMIT 1");
$kel_id = 0;
if($q->getNumRows() > 0) {
    $kel_id = $q->getRowArray()['kelompok_id'];
}

$bimbingan_data = null;
$instansi_data = null;
$dospem_nama = null;
$is_readonly = false;
$is_user_ketua = false;

if ($kel_id > 0) {
    // Check if current user is ketua
    $qc = $db->query("SELECT is_ketua FROM anggota_kelompok WHERE kelompok_id = $kel_id AND mahasiswa_id = $mhs_id");
    if($qc->getNumRows() > 0) {
        $is_user_ketua = (bool)$qc->getRowArray()['is_ketua'];
    }

    // Fetch Instansi
    $qi = $db->query("SELECT * FROM instansi WHERE kelompok_id = $kel_id ORDER BY id DESC LIMIT 1");
    if($qi->getNumRows() > 0) {
        $instansi_data = $qi->getRowArray();
    }
    
    // Fetch Dospem Name
    $qd = $db->query("SELECT u.nama FROM kelompok k LEFT JOIN users u ON k.dospem_id = u.id WHERE k.id = $kel_id");
    if($qd->getNumRows() > 0) {
        $d_row = $qd->getRowArray();
        if ($d_row['nama']) {
            $dospem_nama = $d_row['nama'];
        }
    }

    // Fetch Bimbingan
    $qb = $db->query("SELECT * FROM bimbingan WHERE kelompok_id = $kel_id ORDER BY id DESC LIMIT 1");
    if($qb->getNumRows() > 0) {
        $bimbingan_data = $qb->getRowArray();
        if (in_array($bimbingan_data['status_bimbingan'], ['disetujui', 'menunggu'])) {
            $is_readonly = true;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$is_readonly && $kel_id > 0 && $workflow['allowed']) {
    if (!$is_user_ketua) {
        $_SESSION['swal_msg'] = 'Akses Ditolak: Hanya ketua kelompok yang dapat mengajukan form bimbingan!';
            $_SESSION['swal_type'] = 'error';
            return redirect()->to(base_url('mhs_pengajuan_bimbingan'));
    }
    
    $no_surat = $db->escapeString($_POST['field_1'] ?? '');
    $tgl_surat = $db->escapeString($_POST['field_2'] ?? date('Y-m-d'));
    $tgl_mulai = $db->escapeString($_POST['field_3'] ?? date('Y-m-d'));
    $tgl_selesai = $db->escapeString($_POST['field_4'] ?? date('Y-m-d'));
    
    $file_surat = 'dummy_surat.pdf';
    $file_slip = 'dummy_slip.jpg';
    $upload_dir = FCPATH . 'uploads/';
    
    if (isset($_FILES['file_surat']) && $_FILES['file_surat']['error'] == UPLOAD_ERR_OK) {
        $res = safe_upload_file($_FILES['file_surat'], $upload_dir, 'surat');
        if ($res) $file_surat = $res;
    }
    
    if (isset($_FILES['file_slip']) && $_FILES['file_slip']['error'] == UPLOAD_ERR_OK) {
        $res = safe_upload_file($_FILES['file_slip'], $upload_dir, 'slip');
        if ($res) $file_slip = $res;
    }

    $db->query("INSERT INTO bimbingan (kelompok_id, no_surat_balasan, tgl_surat_balasan, tgl_mulai_kp, tgl_selesai_kp, file_surat_balasan, file_slip_bimbingan, status_bimbingan) 
                  VALUES ($kel_id, '$no_surat', '$tgl_surat', '$tgl_mulai', '$tgl_selesai', '$file_surat', '$file_slip', 'menunggu')");
    
    $_SESSION['swal_msg'] = 'Pengajuan Bimbingan berhasil dikirim!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_bimbingan'));
}


$page_title = 'Mhs Pengajuan Bimbingan';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-mhs.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('mhs_pengajuan_bimbingan_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

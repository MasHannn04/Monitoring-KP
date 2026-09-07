<?php

namespace App\Controllers;

class KoorDetailBimbingan extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();



$bimbingan_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = (int)$_POST['bimbingan_id'];
    if ($_POST['action'] == 'approve') {
        if (!isset($_FILES['surat_tugas']) || $_FILES['surat_tugas']['error'] == UPLOAD_ERR_NO_FILE) {
            $_SESSION['swal_msg'] = 'Gagal: Berkas Surat Tugas (PDF) harus diunggah untuk menyetujui!';
            $_SESSION['swal_type'] = 'success';
            echo "<script>window.history.back();</script>";
 return;
        }
        
        $dospem_id = (int)$_POST['dospem_id'];
        if ($dospem_id <= 0) {
            $_SESSION['swal_msg'] = 'Gagal: Anda harus memilih Dosen Pembimbing!';
            $_SESSION['swal_type'] = 'success';
            echo "<script>window.history.back();</script>";
 return;
        }

        $filename = safe_upload_file($_FILES['surat_tugas'], FCPATH . 'uploads/', 'tugas', ['pdf'], ['application/pdf']);
        if (!$filename) {
            $_SESSION['swal_msg'] = 'Error Upload: Gagal menyimpan file!';
            $_SESSION['swal_type'] = 'error';
            echo "<script>window.history.back();</script>";
 return;
        }
        
        // Approve bimbingan
        $db->query("UPDATE bimbingan SET status_bimbingan = 'disetujui', file_surat_tugas = '$filename' WHERE id = $id");
        
        // Find kelompok_id for this bimbingan
        $qb = $db->query("SELECT kelompok_id FROM bimbingan WHERE id = $id");
        if($qb->getNumRows() > 0) {
            $kel_id = $qb->getRowArray()['kelompok_id'];
            $db->query("UPDATE kelompok SET dospem_id = $dospem_id WHERE id = $kel_id");
        }

    } elseif ($_POST['action'] == 'reject') {
        $note = $db->escapeString($_POST['bimbingan_note'] ?? '');
        $db->query("UPDATE bimbingan SET status_bimbingan = 'ditolak', bimbingan_note = '$note' WHERE id = $id");
    }
    
    $_SESSION['swal_msg'] = 'Validasi Bimbingan & Dospem tersimpan!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_bimbingan'));
}

$bimbingan_data = null;
$instansi_data = null;
$anggota_list = [];

if ($bimbingan_id > 0) {
    $q = $db->query("SELECT * FROM bimbingan WHERE id = $bimbingan_id");
    if($q->getNumRows() > 0) {
        $bimbingan_data = $q->getRowArray();
        $kel_id = $bimbingan_data['kelompok_id'];
        
        $qi = $db->query("SELECT * FROM instansi WHERE kelompok_id = $kel_id ORDER BY id DESC LIMIT 1");
        if($qi->getNumRows() > 0) {
            $instansi_data = $qi->getRowArray();
        }

        $qa = $db->query("SELECT u.nama, u.npm_nip, u.email, a.is_ketua, a.no_wa FROM anggota_kelompok a JOIN users u ON a.mahasiswa_id = u.id WHERE a.kelompok_id = $kel_id AND a.status_anggota = 'menerima' ORDER BY a.is_ketua DESC");
        foreach ($qa->getResultArray() as $r) {
            $anggota_list[] = $r;
        }
    } else {
        $_SESSION['swal_msg'] = 'Data bimbingan tidak ditemukan!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_bimbingan'));
    }
} else {
    $_SESSION['swal_msg'] = 'ID tidak valid!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_bimbingan'));
}

// Fetch list of dosen for dropdown
$dosen_list = [];
$qd = $db->query("SELECT id, nama FROM users WHERE role = 'dosen'");
foreach ($qd->getResultArray() as $r) {
    $dosen_list[] = $r;
}

$page_title = 'Koor Detail Bimbingan';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_detail_bimbingan_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

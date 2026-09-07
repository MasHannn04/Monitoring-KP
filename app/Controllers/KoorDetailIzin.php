<?php

namespace App\Controllers;

class KoorDetailIzin extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();




$instansi_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = (int)$_POST['instansi_id'];
    if ($_POST['action'] == 'approve') {
        if (!isset($_FILES['surat_izin']) || $_FILES['surat_izin']['error'] == UPLOAD_ERR_NO_FILE) {
            $_SESSION['swal_msg'] = 'Gagal: Berkas Surat Izin (PDF) harus diunggah untuk menyetujui!';
            $_SESSION['swal_type'] = 'success';
            echo "<script>window.history.back();</script>";
 return;
        }
        $filename = safe_upload_file($_FILES['surat_izin'], FCPATH . 'uploads/', 'izin', ['pdf'], ['application/pdf']);
        if (!$filename) {
            $_SESSION['swal_msg'] = 'Error Upload: Gagal memindahkan file!';
            $_SESSION['swal_type'] = 'error';
            echo "<script>window.history.back();</script>";
 return;
        }
        $db->query("UPDATE instansi SET status_izin = 'disetujui', file_surat_izin = '$filename' WHERE id = $id");
    } elseif ($_POST['action'] == 'reject') {
        $note = $db->escapeString($_POST['izin_note'] ?? '');
        $db->query("UPDATE instansi SET status_izin = 'ditolak', izin_note = '$note' WHERE id = $id");
    }
    $_SESSION['swal_msg'] = 'Status Izin diperbarui!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_izin'));
}

$instansi_data = null;
$anggota_list = [];

if ($instansi_id > 0) {
    $q = $db->query("SELECT * FROM instansi WHERE id = $instansi_id");
    if($q->getNumRows() > 0) {
        $instansi_data = $q->getRowArray();
        $kel_id = $instansi_data['kelompok_id'];
        
        $qa = $db->query("SELECT u.nama, u.npm_nip, u.email, a.is_ketua, a.no_wa FROM anggota_kelompok a JOIN users u ON a.mahasiswa_id = u.id WHERE a.kelompok_id = $kel_id AND a.status_anggota = 'menerima' ORDER BY a.is_ketua DESC");
        foreach ($qa->getResultArray() as $r) {
            $anggota_list[] = $r;
        }
    } else {
        $_SESSION['swal_msg'] = 'Data tidak ditemukan!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_izin'));
    }
} else {
    $_SESSION['swal_msg'] = 'ID tidak valid!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('koor_approval_izin'));
}


$page_title = 'Koor Detail Izin';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_detail_izin_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

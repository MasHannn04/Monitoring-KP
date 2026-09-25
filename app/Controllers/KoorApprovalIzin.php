<?php

namespace App\Controllers;

class KoorApprovalIzin extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $id = (int)$_POST['instansi_id'];
    if ($_POST['action'] == 'approve') {
        if (!isset($_FILES['surat_izin']) || $_FILES['surat_izin']['error'] == UPLOAD_ERR_NO_FILE) {
            $_SESSION['swal_msg'] = 'Gagal: Berkas Surat Izin (PDF) harus diunggah untuk menyetujui!';
            $_SESSION['swal_type'] = 'error';
            return redirect()->to(base_url('koor_approval_izin'));
        }
        $filename = safe_upload_file($_FILES['surat_izin'], FCPATH . 'uploads/', 'izin', ['pdf'], ['application/pdf']);
        if (!$filename) {
            $_SESSION['swal_msg'] = 'Error Upload: Gagal memindahkan file!';
            $_SESSION['swal_type'] = 'error';
            return redirect()->to(base_url('koor_approval_izin'));
        }
        $db->query("UPDATE instansi SET status_izin = 'disetujui', file_surat_izin = '$filename' WHERE id = $id");
    } elseif ($_POST['action'] == 'reject') {
        $db->query("UPDATE instansi SET status_izin = 'ditolak' WHERE id = $id");
    }
    $_SESSION['swal_msg'] = 'Status Izin diperbarui!';
    $_SESSION['swal_type'] = 'success';
    return redirect()->to(base_url('koor_approval_izin'));
}

$menunggu_izin = [];
$q_izin = $db->query("
    SELECT i.*, k.created_at, u.nama as ketua_nama,
           (SELECT count(*) FROM anggota_kelompok WHERE kelompok_id = k.id AND status_anggota = 'menerima') as jumlah_anggota
    FROM instansi i 
    JOIN kelompok k ON i.kelompok_id = k.id 
    JOIN users u ON k.ketua_id = u.id 
    WHERE i.status_izin IN ('menunggu', 'disetujui') ORDER BY i.id DESC
");
if($q_izin) {
    foreach ($q_izin->getResultArray() as $row) {
        $menunggu_izin[] = $row;
    }
}


$page_title = 'Koor Approval Izin';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_approval_izin_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

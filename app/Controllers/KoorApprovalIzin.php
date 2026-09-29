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
    $action = $_POST['action'];
    
    if ($action == 'approve') {
        $id = (int)$_POST['instansi_id'];
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
    } elseif ($action == 'reject') {
        $id = (int)$_POST['instansi_id'];
        $db->query("UPDATE instansi SET status_izin = 'ditolak' WHERE id = $id");
    } elseif ($action == 'approve_reset') {
        $kel_id = (int)$_POST['kelompok_id'];
        $db->query("DELETE FROM laporan_akhir WHERE kelompok_id = $kel_id");
        $db->query("DELETE FROM seminar WHERE kelompok_id = $kel_id");
        $db->query("DELETE FROM log_bimbingan WHERE kelompok_id = $kel_id");
        $db->query("DELETE FROM bimbingan WHERE kelompok_id = $kel_id");
        $db->query("DELETE FROM instansi WHERE kelompok_id = $kel_id");
        $db->query("UPDATE kelompok SET status_reset = 'disetujui' WHERE id = $kel_id");
        $_SESSION['swal_msg'] = 'Reset progress disetujui! Kelompok ini akan kembali ke tahap Pengajuan Izin.';
        $_SESSION['swal_type'] = 'success';
        return redirect()->to(base_url('koor_approval_izin'));
    } elseif ($action == 'reject_reset') {
        $kel_id = (int)$_POST['kelompok_id'];
        $db->query("UPDATE kelompok SET status_reset = 'ditolak' WHERE id = $kel_id");
        $_SESSION['swal_msg'] = 'Permohonan reset ditolak.';
        $_SESSION['swal_type'] = 'success';
        return redirect()->to(base_url('koor_approval_izin'));
    }
    $_SESSION['swal_msg'] = 'Status diperbarui!';
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

$reset_requests = [];
$q_reset = $db->query("
    SELECT k.id as kelompok_id, k.alasan_reset, u.nama as ketua_nama,
           (SELECT nama_instansi FROM instansi WHERE kelompok_id = k.id LIMIT 1) as instansi_lama
    FROM kelompok k
    JOIN users u ON k.ketua_id = u.id
    WHERE k.status_reset = 'menunggu'
");
if($q_reset) {
    foreach ($q_reset->getResultArray() as $row) {
        $reset_requests[] = $row;
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

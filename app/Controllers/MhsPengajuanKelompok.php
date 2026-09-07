<?php

namespace App\Controllers;

class MhsPengajuanKelompok extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();

$user_id = $_SESSION['user_id'];

// --- GET ACTIVE GROUP ---
$active_group = null;
$state = 'belum_punya';
$rejection_reason = null;
$q_ag = $db->query("SELECT k.*, a.is_ketua FROM anggota_kelompok a JOIN kelompok k ON a.kelompok_id = k.id WHERE a.mahasiswa_id = $user_id AND a.status_anggota = 'menerima' ORDER BY k.created_at DESC LIMIT 1");
if ($q_ag->getNumRows() > 0) {
    $active_group = $q_ag->getRowArray();
    if ($active_group['status_kelompok'] == 'draft') {
        $state = 'draft';
    } elseif ($active_group['status_kelompok'] == 'ditolak') {
        $state = 'belum_punya';
        $rejection_reason = $active_group['koor_note'];
    } else {
        $state = 'terkunci';
    }
}

// --- HANDLE POST ACTIONS ---
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'create_draft' && $state == 'belum_punya') {
        $upload_dir = FCPATH . 'uploads/';
        $khs_file = '';
        if (isset($_FILES['khs']) && $_FILES['khs']['error'] == 0) {
            $khs_file = safe_upload_file($_FILES['khs'], $upload_dir, 'khs', ['pdf'], ['application/pdf']);
        }
        if (!$khs_file) {
            $_SESSION['swal_msg'] = 'Error: Anda harus mengupload KHS/Transkrip (PDF)!';
            $_SESSION['swal_type'] = 'error';
            echo "<script>window.history.back();</script>";
 return;
        }
        // 1. Insert into kelompok
        $db->query("INSERT INTO kelompok (ketua_id, status_kelompok) VALUES ($user_id, 'draft')");
        $kel_id = $db->insertID();
        
        // 2. Insert self
        $db->query("INSERT INTO anggota_kelompok (kelompok_id, mahasiswa_id, is_ketua, status_anggota, file_riwayat_studi) VALUES ($kel_id, $user_id, 1, 'menerima', '$khs_file')");
        
        $_SESSION['swal_msg'] = 'Draft kelompok berhasil dibuat! Anda sekarang dapat mulai mengundang anggota lain.';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_kelompok'));
    }

    if ($action == 'ajukan_final' && $state == 'draft' && $active_group['is_ketua']) {
        $kel_id = $active_group['id'];
        
        // Check if all accepted and have KHS
        $q_cek = $db->query("SELECT count(*) as c FROM anggota_kelompok WHERE kelompok_id = $kel_id AND (status_anggota != 'menerima' OR file_riwayat_studi = '' OR file_riwayat_studi IS NULL)");
        if ($q_cek->getRowArray()['c'] == 0) {
            $db->query("UPDATE kelompok SET status_kelompok = 'menunggu_validasi' WHERE id = $kel_id");
            $_SESSION['swal_msg'] = 'Kelompok berhasil diajukan ke Koordinator!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_kelompok'));
        } else {
            $_SESSION['swal_msg'] = 'Masih ada anggota yang belum mengkonfirmasi atau belum mengupload Riwayat Studi (KHS)!';
            $_SESSION['swal_type'] = 'error';
            return redirect()->to(base_url('mhs_pengajuan_kelompok'));
        } return;
    }

    if ($action == 'hapus_anggota' && $state == 'draft' && $active_group['is_ketua']) {
        $hapus_id = (int)$_POST['hapus_id'];
        $kel_id = $active_group['id'];
        $db->query("UPDATE anggota_kelompok SET status_anggota = 'dikeluarkan' WHERE kelompok_id = $kel_id AND mahasiswa_id = $hapus_id");
        $_SESSION['swal_msg'] = 'Anggota dihapus.';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_kelompok'));
    }

    if ($action == 'add_invite' && $state == 'draft' && $active_group['is_ketua']) {
        $kel_id = $active_group['id'];
        $undang_id = (int)$_POST['undang_id'];
        
        // Cek jumlah anggota
        $q_count = $db->query("SELECT count(*) as c FROM anggota_kelompok WHERE kelompok_id = $kel_id AND status_anggota != 'menolak'");
        if ($q_count->getRowArray()['c'] >= 3) {
            $_SESSION['swal_msg'] = 'Kelompok sudah penuh (Maksimal 3 anggota).';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_kelompok'));
        }

        if ($undang_id > 0) {
            $q_cek = $db->query("SELECT * FROM anggota_kelompok WHERE kelompok_id = $kel_id AND mahasiswa_id = $undang_id");
            if ($q_cek->getNumRows() > 0) {
                $db->query("UPDATE anggota_kelompok SET status_anggota = 'menunggu' WHERE kelompok_id = $kel_id AND mahasiswa_id = $undang_id");
            } else {
                $db->query("INSERT INTO anggota_kelompok (kelompok_id, mahasiswa_id, is_ketua, status_anggota) VALUES ($kel_id, $undang_id, 0, 'menunggu')");
            }
            $_SESSION['swal_msg'] = 'Undangan berhasil dikirim!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_kelompok'));
        } return;
    }

    if ($action == 'terima_invite' && $state == 'belum_punya') {
        $kel_id = (int)$_POST['kel_id'];
        $upload_dir = FCPATH . 'uploads/';
        $khs_file = '';
        if (isset($_FILES['khs']) && $_FILES['khs']['error'] == 0) {
            $khs_file = safe_upload_file($_FILES['khs'], $upload_dir, 'khs', ['pdf'], ['application/pdf']);
        }
        if (!$khs_file) {
            $_SESSION['swal_msg'] = 'Error: Anda harus mengupload KHS/Transkrip (PDF) untuk menerima undangan!';
            $_SESSION['swal_type'] = 'error';
            echo "<script>window.history.back();</script>";
 return;
        }
        $db->query("UPDATE anggota_kelompok SET status_anggota = 'menerima', file_riwayat_studi = '$khs_file' WHERE kelompok_id = $kel_id AND mahasiswa_id = $user_id");
        $_SESSION['swal_msg'] = 'Undangan diterima! Kelompok Anda sekarang telah terbentuk.';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_kelompok'));
    }

    if ($action == 'tolak_invite') {
        $kel_id = (int)$_POST['kel_id'];
        $db->query("UPDATE anggota_kelompok SET status_anggota = 'menolak' WHERE kelompok_id = $kel_id AND mahasiswa_id = $user_id");
        $_SESSION['swal_msg'] = 'Undangan ditolak.';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_kelompok'));
    }
}

// --- FETCH DATA FOR VIEW ---
$search_results = [];
if (($state == 'belum_punya' || $state == 'draft') && isset($_GET['q']) && !empty($_GET['q'])) {
    $q = $db->escapeString($_GET['q']);
    $active_kel_id = $active_group ? $active_group['id'] : 0;
    // Search students not currently in an active group
    $sql = "SELECT u.* FROM users u 
            WHERE u.role = 'mahasiswa' AND u.id != $user_id 
            AND (u.nama LIKE '%$q%' OR u.npm_nip LIKE '%$q%')
            AND u.id NOT IN (
                SELECT a.mahasiswa_id 
                FROM anggota_kelompok a 
                JOIN kelompok k ON a.kelompok_id = k.id 
                WHERE (a.status_anggota = 'menerima' AND k.status_kelompok != 'ditolak')
                   OR (a.kelompok_id = $active_kel_id AND a.status_anggota NOT IN ('dikeluarkan', 'menolak'))
            )";
    $res = $db->query($sql);
    foreach ($res->getResultArray() as $r) {
        $search_results[] = $r;
    }
}

// Fetch incoming invites
$incoming_invites = [];
if ($state == 'belum_punya') {
    $q_inv = $db->query("SELECT a.kelompok_id, u.nama as ketua_nama FROM anggota_kelompok a JOIN kelompok k ON a.kelompok_id = k.id JOIN users u ON k.ketua_id = u.id WHERE a.mahasiswa_id = $user_id AND a.status_anggota = 'menunggu'");
    foreach ($q_inv->getResultArray() as $row) {
        $incoming_invites[] = $row;
    }
}

// Fetch members of active group if in draft or terkunci
$group_members = [];
$all_accepted = true;
if ($active_group) {
    $kel_id = $active_group['id'];
    $q_m = $db->query("SELECT u.nama, u.npm_nip, a.is_ketua, a.status_anggota, a.mahasiswa_id FROM anggota_kelompok a JOIN users u ON a.mahasiswa_id = u.id WHERE a.kelompok_id = $kel_id AND a.status_anggota != 'dikeluarkan' ORDER BY a.is_ketua DESC");
    foreach ($q_m->getResultArray() as $row) {
        $group_members[] = $row;
        if ($row['status_anggota'] != 'menerima') {
            $all_accepted = false;
        }
    }
}

// Fetch submission history (for groups that were submitted to Koordinator)
$submission_history = [];
$q_history = $db->query("
    SELECT k.status_kelompok, k.created_at, u.nama as ketua_nama, k.koor_note 
    FROM kelompok k 
    JOIN users u ON k.ketua_id = u.id 
    WHERE k.status_kelompok != 'draft' 
      AND k.id IN (SELECT kelompok_id FROM anggota_kelompok WHERE mahasiswa_id = $user_id)
    ORDER BY k.created_at DESC
");
foreach ($q_history->getResultArray() as $row) {
    $submission_history[] = $row;
}

// Fetch group activity history
$activity_history = [];
$sql_activity = "
    SELECT 'sebagai_anggota' as role_type, k.created_at, u.nama as target_nama, a.status_anggota 
    FROM anggota_kelompok a
    JOIN kelompok k ON a.kelompok_id = k.id
    JOIN users u ON k.ketua_id = u.id
    WHERE a.mahasiswa_id = $user_id AND a.is_ketua = 0
    UNION
    SELECT 'sebagai_ketua' as role_type, k.created_at, u.nama as target_nama, a.status_anggota
    FROM kelompok k
    JOIN anggota_kelompok a ON k.id = a.kelompok_id
    JOIN users u ON a.mahasiswa_id = u.id
    WHERE k.ketua_id = $user_id AND a.mahasiswa_id != $user_id
    ORDER BY created_at DESC
";
$q_act = $db->query($sql_activity);
if ($q_act) {
    foreach ($q_act->getResultArray() as $row) {
        $activity_history[] = $row;
    }
}

$page_title = 'Mhs Pengajuan Kelompok';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-mhs.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('mhs_pengajuan_kelompok_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

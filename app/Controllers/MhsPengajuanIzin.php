<?php

namespace App\Controllers;

class MhsPengajuanIzin extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();
helper('workflow');

$workflow = check_mhs_workflow($db, $_SESSION['user_id'], 2);
if (!$workflow['allowed']) {
    $locked_message = $workflow['message'];
    $locked_redirect = $workflow['redirect_link'];
    $locked_button = $workflow['button_text'];
}

$mhs_id = $_SESSION['user_id'];
$q = $db->query("SELECT a.kelompok_id, a.is_ketua, k.status_kelompok FROM anggota_kelompok a JOIN kelompok k ON a.kelompok_id = k.id WHERE a.mahasiswa_id = $mhs_id AND a.status_anggota = 'menerima' AND k.status_kelompok != 'ditolak' ORDER BY k.id DESC LIMIT 1");
$kel_id = 0;
$is_user_ketua = false;
$status_kelompok = 'belum_punya';
if($q->getNumRows() > 0) {
    $row_user = $q->getRowArray();
    $kel_id = $row_user['kelompok_id'];
    $is_user_ketua = $row_user['is_ketua'];
    $status_kelompok = $row_user['status_kelompok'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $kel_id > 0) {
    $action = $_POST['action'] ?? 'simpan_draft';
    
    // Save contact data
    $qa = $db->query("SELECT mahasiswa_id FROM anggota_kelompok WHERE kelompok_id = $kel_id AND status_anggota IN ('menerima', 'menunggu')");
    foreach ($qa->getResultArray() as $row) {
        $a_id = $row['mahasiswa_id'];
        if ($is_user_ketua || $a_id == $mhs_id) {
            $wa = $db->escapeString($_POST['wa_'.$a_id] ?? '');
            $email = $db->escapeString($_POST['email_'.$a_id] ?? '');
            if(!empty($wa)) {
                $db->query("UPDATE anggota_kelompok SET no_wa = '$wa' WHERE kelompok_id = $kel_id AND mahasiswa_id = $a_id");
            }
            if(!empty($email)) {
                $db->query("UPDATE users SET email = '$email' WHERE id = $a_id");
            }
        }
    }
    
    // Save instansi if ketua
    if ($is_user_ketua) {
        $nama_instansi = $db->escapeString($_POST['field_5'] ?? '');
        $kota = $db->escapeString($_POST['field_6'] ?? '');
        $ditujukan = $db->escapeString($_POST['field_7'] ?? '');
        $bidang = $db->escapeString($_POST['field_8'] ?? '');
        $alamat = $db->escapeString($_POST['field_9'] ?? '');
        $lama = $db->escapeString($_POST['field_10'] ?? '1 Bulan');
        
        $q_cek = $db->query("SELECT id FROM instansi WHERE kelompok_id = $kel_id");
        if ($q_cek->getNumRows() > 0) {
            $db->query("UPDATE instansi SET nama_instansi='$nama_instansi', kota='$kota', ditujukan_kepada='$ditujukan', bidang_kp='$bidang', alamat='$alamat', lama_kp='$lama' WHERE kelompok_id = $kel_id");
        } else {
            $db->query("INSERT INTO instansi (kelompok_id, nama_instansi, kota, alamat, ditujukan_kepada, bidang_kp, lama_kp, status_izin) 
                          VALUES ($kel_id, '$nama_instansi', '$kota', '$alamat', '$ditujukan', '$bidang', '$lama', 'draft')");
        }
    }
    
    if ($action == 'kirim_pengajuan' && $is_user_ketua) {
        $valid = true;
        
        // 1. Cek email & wa anggota
        $qa = $db->query("SELECT u.email, a.no_wa FROM anggota_kelompok a JOIN users u ON a.mahasiswa_id = u.id WHERE a.kelompok_id = $kel_id AND a.status_anggota IN ('menerima', 'menunggu')");
        foreach ($qa->getResultArray() as $r) {
            if(empty(trim($r['email'])) || empty(trim($r['no_wa']))) {
                $valid = false;
                break;
            }
        }
        
        // 2. Cek instansi
        if ($valid) {
            $qi = $db->query("SELECT * FROM instansi WHERE kelompok_id = $kel_id");
            if ($qi->getNumRows() > 0) {
                $r = $qi->getRowArray();
                if(empty(trim($r['nama_instansi'])) || empty(trim($r['kota'])) || empty(trim($r['ditujukan_kepada'])) || empty(trim($r['bidang_kp'])) || empty(trim($r['alamat'])) || empty(trim($r['lama_kp']))) {
                    $valid = false;
                }
            } else {
                $valid = false;
            }
        }
        
        if ($valid) {
            $tgl_now = date('Y-m-d');
            $db->query("UPDATE instansi SET status_izin = 'menunggu', tanggal_pengajuan = '$tgl_now' WHERE kelompok_id = $kel_id");
            $_SESSION['swal_msg'] = 'Surat izin berhasil diajukan ke Koordinator!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_izin'));
        } else {
            $_SESSION['swal_msg'] = 'GAGAL MENGIRIM: Mohon lengkapi seluruh data kontak (Email dan WA semua anggota) serta data instansi terlebih dahulu!';
            $_SESSION['swal_type'] = 'error';
            return redirect()->to(base_url('mhs_pengajuan_izin'));
        } return;
    }

    $_SESSION['swal_msg'] = 'Data berhasil disimpan sebagai draft!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_pengajuan_izin'));
}

$anggota_list = [];
$instansi_data = null;
if($kel_id > 0) {
    $qa = $db->query("SELECT u.id as mhs_id, u.nama, u.npm_nip, u.email, a.is_ketua, a.status_anggota, a.no_wa FROM anggota_kelompok a JOIN users u ON a.mahasiswa_id = u.id WHERE a.kelompok_id = $kel_id AND a.status_anggota IN ('menerima', 'menunggu') ORDER BY a.is_ketua DESC");
    foreach ($qa->getResultArray() as $row) {
        $anggota_list[] = $row;
    }
    
    $qi = $db->query("SELECT * FROM instansi WHERE kelompok_id = $kel_id");
    if($qi->getNumRows() > 0) {
        $instansi_data = $qi->getRowArray();
    }
}


$is_readonly = false;
if (isset($instansi_data) && in_array($instansi_data['status_izin'], ['menunggu', 'disetujui'])) {
    $is_readonly = true;
}

$izin_history = [];
if($kel_id > 0) {
    // In a real app we might have a separate history table for each submission attempt, 
    // but here we just show the current record as the history since it gets overwritten/updated.
    if ($instansi_data) {
        $izin_history[] = $instansi_data;
    }
}

$page_title = 'Mhs Pengajuan Izin';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-mhs.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('mhs_pengajuan_izin_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

<?php

namespace App\Controllers;

class MhsKumpulLaporan extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'mahasiswa') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


helper('workflow');


$workflow = check_mhs_workflow($db, $_SESSION['user_id'], 6);
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

$laporan_data = null;
$is_readonly = false;
$nilai_final = null;
$huruf_final = '-';
$nilai_perusahaan_done = false;

if ($kel_id > 0) {
    $ql = $db->query("SELECT * FROM laporan_akhir WHERE kelompok_id = $kel_id");
    if($ql->getNumRows() > 0) {
        $laporan_data = $ql->getRowArray();
        if ($laporan_data['status_dospem'] != 'tolak' && $laporan_data['status_koor'] != 'tolak') {
            $is_readonly = true;
        }
    }

    // Get grades
    $qs = $db->query("SELECT nilai_penguji1, nilai_penguji2 FROM anggota_kelompok WHERE kelompok_id = $kel_id AND mahasiswa_id = $mhs_id");
    if($qs && $qs->getNumRows() > 0) {
        $sem = $qs->getRowArray();
        if ($sem['nilai_penguji1'] !== null && $sem['nilai_penguji2'] !== null) {
            if ($laporan_data && $laporan_data['nilai_perusahaan'] !== null) {
                $nilai_final = ((($sem['nilai_penguji1'] + $sem['nilai_penguji2']) / 2) + $laporan_data['nilai_perusahaan']) / 2;
                $nilai_perusahaan_done = true;
            } else {
                $nilai_final = ($sem['nilai_penguji1'] + $sem['nilai_penguji2']) / 2;
                $nilai_perusahaan_done = false;
            }
            if($nilai_final <= 40) $huruf_final = 'E';
            else if($nilai_final <= 50) $huruf_final = 'D';
            else if($nilai_final <= 60) $huruf_final = 'C';
            else if($nilai_final <= 65) $huruf_final = 'C+';
            else if($nilai_final <= 72) $huruf_final = 'B-';
            else if($nilai_final <= 75) $huruf_final = 'B';
            else if($nilai_final <= 79) $huruf_final = 'B+';
            else if($nilai_final <= 85) $huruf_final = 'A-';
            else if($nilai_final <= 90) $huruf_final = 'A';
            else $huruf_final = 'A+';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$is_readonly && $kel_id > 0 && $workflow['allowed']) {
    
    $upload_dir = FCPATH . 'uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $file_laporan = '';
    $file_tugas = '';
    $file_nilai = '';

    if (isset($_FILES['file_laporan_final']) && $_FILES['file_laporan_final']['error'] == 0) {
        $res = safe_upload_file($_FILES['file_laporan_final'], $upload_dir, 'laporan_final');
        if ($res) $file_laporan = $res;
    }
    
    if (isset($_FILES['file_surat_tugas']) && $_FILES['file_surat_tugas']['error'] == 0) {
        $res = safe_upload_file($_FILES['file_surat_tugas'], $upload_dir, 'surat_tugas');
        if ($res) $file_tugas = $res;
    }
    
    if (isset($_FILES['file_nilai_perusahaan']) && $_FILES['file_nilai_perusahaan']['error'] == 0) {
        $res = safe_upload_file($_FILES['file_nilai_perusahaan'], $upload_dir, 'nilai');
        if ($res) $file_nilai = $res;
    }

    if($laporan_data && ($laporan_data['status_dospem'] == 'tolak' || $laporan_data['status_koor'] == 'tolak')) {
        if(!$file_laporan) $file_laporan = $laporan_data['file_laporan_final'];
        if(!$file_tugas) $file_tugas = $laporan_data['file_surat_tugas'];
        if(!$file_nilai) $file_nilai = $laporan_data['file_nilai_perusahaan'];
        
        $db->query("UPDATE laporan_akhir SET file_laporan_final = '$file_laporan', file_surat_tugas = '$file_tugas', file_nilai_perusahaan = '$file_nilai', status_dospem = 'menunggu', status_koor = 'menunggu', tgl_pengumpulan = NOW() WHERE kelompok_id = $kel_id");
    } else {
        $db->query("INSERT INTO laporan_akhir (kelompok_id, file_laporan_final, file_surat_tugas, file_nilai_perusahaan, status_dospem, status_koor) 
                      VALUES ($kel_id, '$file_laporan', '$file_tugas', '$file_nilai', 'menunggu', 'menunggu')");
    }
    
    $_SESSION['swal_msg'] = 'Laporan Final Terkumpul!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('mhs_kumpul_laporan'));
}


$page_title = 'Mhs Kumpul Laporan';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-mhs.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('mhs_kumpul_laporan_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

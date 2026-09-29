<?php

namespace App\Controllers;

class KoorDetailKelompok extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
    
    if (isset($_POST['kick_member'])) {
        $kel_id = $id;
        $mhs_id = (int)$_POST['mhs_id'];

        $cek = $db->query("SELECT is_ketua FROM anggota_kelompok WHERE kelompok_id = $kel_id AND mahasiswa_id = $mhs_id")->getRowArray();
        $db->query("UPDATE anggota_kelompok SET status_anggota = 'dikeluarkan' WHERE kelompok_id = $kel_id AND mahasiswa_id = $mhs_id");

        if ($cek && $cek['is_ketua']) {
            $lain = $db->query("SELECT mahasiswa_id FROM anggota_kelompok WHERE kelompok_id = $kel_id AND status_anggota = 'menerima' LIMIT 1")->getRowArray();
            if ($lain) {
                $new_ketua = $lain['mahasiswa_id'];
                $db->query("UPDATE anggota_kelompok SET is_ketua = 1 WHERE kelompok_id = $kel_id AND mahasiswa_id = $new_ketua");
                $db->query("UPDATE kelompok SET ketua_id = $new_ketua WHERE id = $kel_id");
                $_SESSION['swal_msg'] = 'Mahasiswa dikeluarkan. Karena ia ketua, status ketua dipindah ke anggota lain.';
            } else {
                $db->query("UPDATE kelompok SET status_kelompok = 'ditolak', koor_note = 'Dibatalkan sistem karena semua anggota telah dikeluarkan.' WHERE id = $kel_id");
                $_SESSION['swal_msg'] = 'Mahasiswa dikeluarkan. Kelompok dibatalkan karena tidak ada anggota tersisa.';
            }
        } else {
            $_SESSION['swal_msg'] = 'Mahasiswa berhasil dikeluarkan dari kelompok.';
        }
        $_SESSION['swal_type'] = 'success';
        return redirect()->to(base_url('koor_detail_kelompok?id=' . $kel_id));
    }
    
    if (isset($_POST['approve'])) {
        $db->query("UPDATE kelompok SET status_kelompok = 'disetujui' WHERE id = $id");
    } else {
        $note = $db->escapeString($_POST['koor_note'] ?? '');
        $db->query("UPDATE kelompok SET status_kelompok = 'ditolak', koor_note = '$note' WHERE id = $id");
    }
    $_SESSION['swal_msg'] = 'Validasi selesai!';
    $_SESSION['swal_type'] = 'success';
    return redirect()->to(base_url('koor_approval_kelompok'));
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$q = $db->query("SELECT * FROM kelompok WHERE id = $id");
$kelompok = $q->getRowArray();
if (!$kelompok) {
    echo "Data tidak ditemukan.";
 return;
}

$q_m = $db->query("SELECT u.id as mhs_id, u.nama, u.npm_nip, a.is_ketua, a.status_anggota, a.file_riwayat_studi FROM anggota_kelompok a JOIN users u ON a.mahasiswa_id = u.id WHERE a.kelompok_id = $id ORDER BY a.is_ketua DESC, a.status_anggota ASC");
$members = [];
$active_members_count = 0;
foreach ($q_m->getResultArray() as $m) {
    $members[] = $m;
    if ($m['status_anggota'] == 'menerima') {
        $active_members_count++;
    }
}


$page_title = 'Koor Detail Kelompok';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_detail_kelompok_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

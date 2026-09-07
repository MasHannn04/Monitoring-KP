<?php

namespace App\Controllers;

class DosenPengumpulanLaporan extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'dosen') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['laporan_id'])) {
    $laporan_id = (int)$_POST['laporan_id'];
    $catatan = $db->escapeString($_POST['catatan'] ?? '');
    
    if(isset($_POST['approve'])) {
        $nilai_perusahaan = isset($_POST['nilai_perusahaan']) ? (float)$_POST['nilai_perusahaan'] : null;
        if ($nilai_perusahaan !== null) {
            $db->query("UPDATE laporan_akhir SET status_dospem = 'acc', catatan = '$catatan', nilai_perusahaan = $nilai_perusahaan WHERE id = $laporan_id");
        } else {
            $db->query("UPDATE laporan_akhir SET status_dospem = 'acc', catatan = '$catatan' WHERE id = $laporan_id");
        }
        $_SESSION['swal_msg'] = 'Laporan disetujui Dosen!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('dosen_pengumpulan_laporan'));
    } else if (isset($_POST['reject'])) {
        $db->query("UPDATE laporan_akhir SET status_dospem = 'tolak', catatan = '$catatan' WHERE id = $laporan_id");
        $_SESSION['swal_msg'] = 'Laporan ditolak / butuh revisi!';
            $_SESSION['swal_type'] = 'success';
            return redirect()->to(base_url('dosen_pengumpulan_laporan'));
    } return;
}

$dosen_id = $_SESSION['user_id'];
$q = $db->query("
    SELECT l.*, u.nama as ketua, u.npm_nip 
    FROM laporan_akhir l
    JOIN kelompok k ON l.kelompok_id = k.id
    JOIN users u ON k.ketua_id = u.id
    WHERE k.dospem_id = $dosen_id
");
$laporan_list = [];
if($q) {
    foreach ($q->getResultArray() as $r) {
        $laporan_list[] = $r;
    }
}


$page_title = 'Dosen Pengumpulan Laporan';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-dosen.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('dosen_pengumpulan_laporan_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

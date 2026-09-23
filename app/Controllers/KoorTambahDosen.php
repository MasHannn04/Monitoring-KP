<?php

namespace App\Controllers;

class KoorTambahDosen extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $db->escapeString($_POST['nama']);
    $npm = $db->escapeString($_POST['npm_nip']);
    $password = $db->escapeString($_POST['password']);
    $prodi = $db->escapeString($_POST['prodi'] ?? 'Sistem Informasi');
    
    // Cek format NIP (12 angka)
    if (!preg_match('/^\d{12}$/', $npm)) {
        $error = "Format NIP tidak valid! Harap masukkan 12 digit angka tanpa spasi atau tanda baca.";
    } else {
        // Cek duplikasi
        $cek = $db->query("SELECT id FROM users WHERE npm_nip = '$npm'");
        if($cek && $cek->getNumRows() > 0) {
            $error = "Dosen dengan NIP tersebut sudah terdaftar!";
        } else {
            $insert = $db->query("INSERT INTO users (npm_nip, nama, password, role, prodi) VALUES ('$npm', '$nama', '$password', 'dosen', '$prodi')");
            if($insert) {
                $success = "Dosen berhasil didaftarkan!";
            } else {
                $error = "Gagal mendaftarkan dosen.";
            }
        }
    }
}

$page_title = 'Tambah Dosen';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_tambah_dosen_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

<?php

namespace App\Controllers;

class KoorTambahMahasiswa extends BaseController
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
    
    // Cek duplikasi
    $cek = $db->query("SELECT id FROM users WHERE npm_nip = '$npm'");
    if($cek && $cek->getNumRows() > 0) {
        $error = "Mahasiswa dengan NPM tersebut sudah terdaftar!";
    } else {
        $insert = $db->query("INSERT INTO users (npm_nip, nama, password, role) VALUES ('$npm', '$nama', '$password', 'mahasiswa')");
        if($insert) {
            $success = "Mahasiswa berhasil didaftarkan!";
        } else {
            $error = "Gagal mendaftarkan mahasiswa.";
        }
    }
}

$page_title = 'Tambah Mahasiswa';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_tambah_mahasiswa_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

<?php

namespace App\Controllers;

class KoorListMahasiswa extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
    return redirect()->to(base_url('login'));
}
$db = \Config\Database::connect();
helper('kp_status');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $user_id = (int)$_POST['id'];
    
    if ($action == 'edit') {
        $nama = $db->escapeString($_POST['nama']);
        $npm_nip = $db->escapeString($_POST['npm_nip']);
        $password = $_POST['password'];
        
        // Validasi Format NPM
        if (!preg_match('/^\d{2}\.\d{4}\.\d{1}\.\d{5}$/', $npm_nip)) {
            $error = "Format NPM tidak valid! Harap gunakan format: xx.xxxx.x.xxxxx";
        } else {
            // Cek duplikasi
            $cek = $db->query("SELECT id FROM users WHERE npm_nip = '$npm_nip' AND id != $user_id");
            if($cek && $cek->getNumRows() > 0) {
                $error = "Mahasiswa dengan NPM tersebut sudah terdaftar!";
            } else {
                if (!empty($password)) {
                    $pass_esc = $db->escapeString($password);
                    $db->query("UPDATE users SET nama = '$nama', npm_nip = '$npm_nip', password = '$pass_esc' WHERE id = $user_id AND role = 'mahasiswa'");
                } else {
                    $db->query("UPDATE users SET nama = '$nama', npm_nip = '$npm_nip' WHERE id = $user_id AND role = 'mahasiswa'");
                }
                $success = 'Data mahasiswa berhasil diupdate.';
            }
        }
    } elseif ($action == 'delete') {
        $db->query("DELETE FROM users WHERE id = $user_id AND role = 'mahasiswa'");
        $success = 'Data mahasiswa berhasil dihapus.';
    }
}

$q_users = $db->query("SELECT * FROM users WHERE role = 'mahasiswa' ORDER BY nama ASC");
$mahasiswa_list = [];
if($q_users) {
    foreach ($q_users->getResultArray() as $r) {
        $status_info = get_status_kp($r['id'], $db);
        $r['status_info'] = $status_info;
        $mahasiswa_list[] = $r;
    }
}

$page_title = 'Daftar Mahasiswa';
echo view('layout/header.php', get_defined_vars());
echo view('layout/side-nav-koor.php', get_defined_vars());
echo view('layout/top-nav.php', get_defined_vars());
echo view('koor_list_mahasiswa_v.php', get_defined_vars());
echo view('layout/footer.php', get_defined_vars());

    }
}

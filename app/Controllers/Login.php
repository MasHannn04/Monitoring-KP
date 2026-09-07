<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        $session = session();

if (isset($_SESSION['nama'])) {
    if ($_SESSION['role'] == 'mahasiswa') return redirect()->to(base_url('mhs_dashboard'));
    elseif ($_SESSION['role'] == 'koordinator') return redirect()->to(base_url('koor_dashboard'));
    elseif ($_SESSION['role'] == 'dosen') return redirect()->to(base_url('dosen_dashboard'));
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = \Config\Database::connect();
    
    $npm_nip = $db->escapeString($_POST['npm_nip']);
    $password = $db->escapeString($_POST['password']);
    
    $query = "SELECT * FROM users WHERE npm_nip = '$npm_nip' AND password = '$password'";
    $result = $db->query($query);
    
    if ($result->getNumRows() > 0) {
        $user = $result->getRowArray();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['npm_nip'] = $user['npm_nip'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['last_activity'] = time(); // For session timeout
        
        // Remember me
        if (isset($_POST['remember'])) {
            $token = bin2hex(random_bytes(32)); // 64 chars
            $db->query("UPDATE users SET remember_token = '$token' WHERE id = " . $user['id']);
            // 7 days cookie
            setcookie('remember_token', $token, time() + (7 * 24 * 60 * 60), "/");
        }
        
        if ($user['role'] == 'mahasiswa') return redirect()->to(base_url('mhs_dashboard'));
        elseif ($user['role'] == 'koordinator') return redirect()->to(base_url('koor_dashboard'));
        elseif ($user['role'] == 'dosen') return redirect()->to(base_url('dosen_dashboard'));
    } else {
        $error = 'NPM/NIP atau Password salah!';
    }
}

$page_title = 'Login - Sistem Informasi KP';
echo view('layout/header.php', get_defined_vars());
echo view('login_v.php', get_defined_vars());
// no footer and sidebar for login page

    }
}

<?php

namespace App\Controllers;

class Logout extends BaseController
{
    public function index()
    {
        $session = session();

$db = \Config\Database::connect();

if (isset($_SESSION['user_id'])) {
    $user_id = (int)$_SESSION['user_id'];
    $db->query("UPDATE users SET remember_token = NULL WHERE id = $user_id");
}

if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, "/");
}

$session->destroy();
return redirect()->to(base_url('login'));

    }
}

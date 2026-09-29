<?php

namespace App\Controllers;

class GantiPassword extends BaseController
{
    public function index()
    {
        $session = session();

        // Must be logged in
        if (!isset($_SESSION['user_id'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sesi Anda telah berakhir, silakan login kembali.'
            ]);
        }

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $user_id = (int)$_SESSION['user_id'];
            $pass_lama = (string)$this->request->getPost('password_lama');
            $pass_baru = (string)$this->request->getPost('password_baru');
            $pass_konfirmasi = (string)$this->request->getPost('konfirmasi_password');

            // Validations
            if (empty($pass_lama) || empty($pass_baru) || empty($pass_konfirmasi)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Semua kolom password wajib diisi!'
                ]);
            }

            if (strlen($pass_baru) < 6) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password baru minimal harus 6 karakter!'
                ]);
            }

            if ($pass_baru !== $pass_konfirmasi) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Konfirmasi password baru tidak cocok!'
                ]);
            }

            $db = \Config\Database::connect();
            $user = $db->query("SELECT id, npm_nip, password FROM users WHERE id = $user_id")->getRowArray();

            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan!'
                ]);
            }

            // Verify old password
            if (!password_verify($pass_lama, $user['password'])) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password lama yang Anda masukkan salah!'
                ]);
            }

            // Check if new password is same as npm_nip
            if ($pass_baru === $user['npm_nip']) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password baru tidak boleh sama dengan NPM/NIP default Anda!'
                ]);
            }

            // Check if new password is same as old password
            if ($pass_lama === $pass_baru) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Password baru tidak boleh sama dengan password lama!'
                ]);
            }

            // Hash new password and save
            $hashed = password_hash($pass_baru, PASSWORD_BCRYPT);
            $update = $db->query("UPDATE users SET password = '$hashed' WHERE id = $user_id");

            if ($update) {
                $_SESSION['is_default_password'] = false;
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Password Anda berhasil diperbarui! Halaman akan dimuat ulang.'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Gagal memperbarui password di database. Silakan coba lagi.'
                ]);
            }
        }

        // If accessed directly via GET, redirect
        return redirect()->to(base_url('login'));
    }
}

<?php

namespace App\Controllers;

class KoorRekapNilai extends BaseController
{
    public function index()
    {
        $session = session();

        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'koordinator') {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        
        $query = "
            SELECT 
                u.npm_nip, 
                u.nama, 
                ak.nilai_penguji1, 
                ak.nilai_penguji2, 
                l.nilai_perusahaan
            FROM users u
            JOIN anggota_kelompok ak ON u.id = ak.mahasiswa_id
            JOIN seminar s ON ak.kelompok_id = s.kelompok_id
            LEFT JOIN laporan_akhir l ON s.kelompok_id = l.kelompok_id
            WHERE u.role = 'mahasiswa' 
            ORDER BY u.npm_nip ASC
        ";
        
        $mahasiswa_list = $db->query($query)->getResultArray();
        
        // Calculate grades
        foreach ($mahasiswa_list as &$m) {
            $m['rata_dosen'] = null;
            $m['nilai_akhir'] = null;
            $m['huruf'] = '-';
            
            if ($m['nilai_penguji1'] !== null && $m['nilai_penguji2'] !== null) {
                $m['rata_dosen'] = ($m['nilai_penguji1'] + $m['nilai_penguji2']) / 2;
                
                if ($m['nilai_perusahaan'] !== null) {
                    $m['nilai_akhir'] = ($m['rata_dosen'] + $m['nilai_perusahaan']) / 2;
                } else {
                    $m['nilai_akhir'] = $m['rata_dosen'];
                }
                
                $nilai = $m['nilai_akhir'];
                if($nilai <= 40) $m['huruf'] = 'E';
                else if($nilai <= 50) $m['huruf'] = 'D';
                else if($nilai <= 60) $m['huruf'] = 'C';
                else if($nilai <= 65) $m['huruf'] = 'C+';
                else if($nilai <= 72) $m['huruf'] = 'B-';
                else if($nilai <= 75) $m['huruf'] = 'B';
                else if($nilai <= 79) $m['huruf'] = 'B+';
                else if($nilai <= 85) $m['huruf'] = 'A-';
                else if($nilai <= 90) $m['huruf'] = 'A';
                else $m['huruf'] = 'A+';
            }
        }

        $page_title = 'Rekap Nilai KP';
        echo view('layout/header.php', get_defined_vars());
        echo view('layout/side-nav-koor.php', get_defined_vars());
        echo view('layout/top-nav.php', get_defined_vars());
        echo view('koor_rekap_nilai_v.php', get_defined_vars());
        echo view('layout/footer.php', get_defined_vars());
    }
}

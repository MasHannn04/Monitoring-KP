<?php
/**
 * Helper function to determine the current progress/status of a Mahasiswa in the KP system.
 * It will return status text, color, icon, and progress width for the dashboard/lists.
 */
function get_status_kp($user_id, $db) {
    $user_id = (int)$user_id;
    $query_kelompok = "SELECT k.*, a.status_anggota, a.is_ketua FROM anggota_kelompok a 
                       LEFT JOIN kelompok k ON a.kelompok_id = k.id 
                       WHERE a.mahasiswa_id = $user_id
                       ORDER BY k.created_at DESC LIMIT 1";
    $result_kelompok = $db->query($query_kelompok);
    $kelompok = $result_kelompok->getRowArray();

    $status_kp = "Belum Membentuk Kelompok";
    $status_color = "var(--text-muted)";
    $status_icon = "fa-users-slash";
    $progress_width = "0%";

    if ($kelompok) {
        if ($kelompok['status_kelompok'] == 'draft' || $kelompok['status_kelompok'] == 'menunggu_validasi') {
            $status_kp = "Pengajuan Kelompok";
            $status_color = "#FFA94D";
            $status_icon = "fa-users-gear";
            $progress_width = "20%";
        } elseif ($kelompok['status_kelompok'] == 'ditolak') {
            $status_kp = "Kelompok Ditolak";
            $status_color = "#dc3545";
            $status_icon = "fa-xmark";
            $progress_width = "5%";
        } else {
            // Cek instansi / izin
            $query_izin = "SELECT * FROM instansi WHERE kelompok_id = " . $kelompok['id'] . " ORDER BY id DESC LIMIT 1";
            $izin = $db->query($query_izin)->getRowArray();
            
            if (!$izin || $izin['status_izin'] == 'menunggu') {
                $status_kp = "Pengajuan Izin KP";
                $status_color = "#FFA94D";
                $status_icon = "fa-envelope-open-text";
                $progress_width = "40%";
            } elseif ($izin['status_izin'] == 'ditolak') {
                $status_kp = "Izin Ditolak";
                $status_color = "#dc3545";
                $status_icon = "fa-xmark";
                $progress_width = "30%";
            } else {
                // Cek bimbingan
                $query_bimbingan = "SELECT * FROM bimbingan WHERE kelompok_id = " . $kelompok['id'] . " ORDER BY id DESC LIMIT 1";
                $bimbingan = $db->query($query_bimbingan)->getRowArray();
                
                if (!$bimbingan || $bimbingan['status_bimbingan'] == 'menunggu') {
                    $status_kp = "Pengajuan Bimbingan";
                    $status_color = "#FFA94D";
                    $status_icon = "fa-chalkboard-user";
                    $progress_width = "60%";
                } elseif ($bimbingan['status_bimbingan'] == 'ditolak') {
                    $status_kp = "Bimbingan Ditolak";
                    $status_color = "#dc3545";
                    $status_icon = "fa-xmark";
                    $progress_width = "50%";
                } elseif ($bimbingan['status_dospem'] != 'disetujui') {
                    $status_kp = "Pelaksanaan & Laporan";
                    $status_color = "var(--primary-blue)";
                    $status_icon = "fa-pen-to-square";
                    $progress_width = "70%";
                } else {
                    // Cek seminar
                    $query_seminar = "SELECT * FROM seminar WHERE kelompok_id = " . $kelompok['id'] . " ORDER BY id DESC LIMIT 1";
                    $seminar = $db->query($query_seminar)->getRowArray();
                    
                    if (!$seminar || ($seminar['status_dospem'] == 'menunggu' || $seminar['status_koor'] == 'menunggu' || $seminar['status_dospem'] == 'tolak' || $seminar['status_koor'] == 'tolak')) {
                        $status_kp = "Pendaftaran Seminar";
                        $status_color = "var(--primary-blue)";
                        $status_icon = "fa-spinner";
                        $progress_width = "80%";
                    } else {
                        $status_kp = "Menunggu Sidang";
                        $status_color = "var(--primary-blue)";
                        $status_icon = "fa-person-chalkboard";
                        $progress_width = "90%";
                        
                        // Cek nilai akhir
                        $query_laporan = "SELECT * FROM laporan_akhir WHERE kelompok_id = " . $kelompok['id'] . " ORDER BY id DESC LIMIT 1";
                        $laporan = $db->query($query_laporan)->getRowArray();
                        if($laporan && $laporan['status_koor'] == 'acc') {
                            $status_kp = "Selesai Kerja Praktek";
                            $status_color = "#198754"; // var(--success-green)
                            $status_icon = "fa-check-double";
                            $progress_width = "100%";
                        }
                    }
                }
            }
        }
    }

    return [
        'status_kp' => $status_kp,
        'status_color' => $status_color,
        'status_icon' => $status_icon,
        'progress_width' => $progress_width,
        'kelompok' => $kelompok
    ];
}
?>

<?php
function check_mhs_workflow($db, $user_id, $required_level) {
    $user_id = (int)$user_id;
    // Basic init
    $state = [
        'allowed' => true,
        'message' => '',
        'redirect_link' => '',
        'button_text' => ''
    ];

    if ($required_level <= 1) return $state;

    // Get active kelompok
    $q_kel = $db->query("
        SELECT k.id as kelompok_id, k.status_kelompok 
        FROM kelompok k 
        JOIN anggota_kelompok a ON k.id = a.kelompok_id 
        WHERE a.mahasiswa_id = $user_id AND a.status_anggota = 'menerima' AND k.status_kelompok != 'ditolak'
        ORDER BY k.id DESC LIMIT 1
    ");
    
    if ($q_kel->getNumRows() == 0) {
        $state['allowed'] = false;
        $state['message'] = 'Anda belum tergabung dalam kelompok Kerja Praktek atau kelompok Anda belum disetujui.';
        $state['redirect_link'] = 'mhs_pengajuan_kelompok';
        $state['button_text'] = 'Menuju Pengajuan Kelompok';
        return $state;
    }

    $kel = $q_kel->getRowArray();
    $kel_id = $kel['kelompok_id'];

    // Level 2: Pengajuan Izin KP requires Kelompok = disetujui
    if ($required_level >= 2) {
        if ($kel['status_kelompok'] != 'disetujui') {
            $state['allowed'] = false;
            $state['message'] = 'Kelompok Anda belum disetujui oleh Koordinator. Anda tidak dapat mengakses Pengajuan Izin KP hingga kelompok resmi disetujui.';
            $state['redirect_link'] = 'mhs_pengajuan_kelompok';
            $state['button_text'] = 'Kembali ke Pengajuan Kelompok';
            return $state;
        }
    }

    // Level 3: Pengajuan Bimbingan requires Izin KP = disetujui
    if ($required_level >= 3) {
        $q_izin = $db->query("SELECT status_izin FROM instansi WHERE kelompok_id = $kel_id ORDER BY id DESC LIMIT 1");
        $izin_ok = false;
        if ($q_izin->getNumRows() > 0) {
            $izin = $q_izin->getRowArray();
            if ($izin['status_izin'] == 'disetujui') {
                $izin_ok = true;
            }
        }
        if (!$izin_ok) {
            $state['allowed'] = false;
            $state['message'] = 'Pengajuan Izin KP Anda belum disetujui. Anda tidak dapat mengakses Pengajuan Bimbingan hingga Izin KP disetujui dan Surat Balasan dari instansi diterima.';
            $state['redirect_link'] = 'mhs_pengajuan_izin';
            $state['button_text'] = 'Kembali ke Pengajuan Izin KP';
            return $state;
        }
    }

    // Level 4: Kemajuan Laporan requires Bimbingan = disetujui (Dosen Pembimbing plot)
    if ($required_level >= 4) {
        $q_bimb = $db->query("SELECT status_bimbingan FROM bimbingan WHERE kelompok_id = $kel_id ORDER BY id DESC LIMIT 1");
        $bimb_ok = false;
        if ($q_bimb->getNumRows() > 0) {
            $bimb = $q_bimb->getRowArray();
            if ($bimb['status_bimbingan'] == 'disetujui') {
                $bimb_ok = true;
            }
        }
        if (!$bimb_ok) {
            $state['allowed'] = false;
            $state['message'] = 'Pengajuan Bimbingan Anda belum disetujui Koordinator (Dosen Pembimbing belum ditentukan). Anda belum bisa mengisi log kemajuan.';
            $state['redirect_link'] = 'mhs_pengajuan_bimbingan';
            $state['button_text'] = 'Kembali ke Pengajuan Bimbingan';
            return $state;
        }
    }

    // Level 5: Pendaftaran Seminar requires Kemajuan Laporan (bimbingan disetujui Dosen Pembimbing secara keseluruhan)
    if ($required_level >= 5) {
        $q_bimb = $db->query("SELECT status_dospem FROM bimbingan WHERE kelompok_id = $kel_id ORDER BY id DESC LIMIT 1");
        $bimb_selesai = false;
        if ($q_bimb && $q_bimb->getNumRows() > 0) {
            $bimb_selesai = ($q_bimb->getRowArray()['status_dospem'] == 'disetujui');
        }
        if (!$bimb_selesai) {
            $state['allowed'] = false;
            $state['message'] = 'Seluruh kemajuan Bimbingan Anda belum di-ACC secara final oleh Dosen Pembimbing. Anda belum bisa mendaftar Seminar KP.';
            $state['redirect_link'] = 'mhs_kemajuan_kp';
            $state['button_text'] = 'Kembali ke Kemajuan Laporan';
            return $state;
        }
    }

    // Level 6: Pengumpulan Laporan requires Seminar exists and graded
    if ($required_level >= 6) {
        $q_sem = $db->query("SELECT id FROM seminar WHERE kelompok_id = $kel_id ORDER BY id DESC LIMIT 1");
        if ($q_sem->getNumRows() == 0) {
            $state['allowed'] = false;
            $state['message'] = 'Anda belum mendaftar Seminar KP. Anda tidak dapat mengumpulkan Laporan Akhir hingga tahap Seminar dilalui.';
            $state['redirect_link'] = 'mhs_daftar_seminar';
            $state['button_text'] = 'Menuju Pendaftaran Seminar';
            return $state;
        } else {
            $q_ak = $db->query("SELECT nilai_penguji1, nilai_penguji2 FROM anggota_kelompok WHERE kelompok_id = $kel_id AND mahasiswa_id = $user_id");
            $ak = $q_ak->getRowArray();
            if (!$ak || $ak['nilai_penguji1'] === null || $ak['nilai_penguji2'] === null) {
                $state['allowed'] = false;
                $state['message'] = 'Nilai sidang Anda belum lengkap dimasukkan oleh seluruh dosen (Pembimbing & Penguji). Anda belum dapat mengumpulkan laporan akhir.';
                $state['redirect_link'] = 'mhs_dashboard';
                $state['button_text'] = 'Kembali ke Dashboard';
                return $state;
            }
        }
    }

    return $state;
}
?>

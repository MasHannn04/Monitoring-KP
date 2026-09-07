<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Dashboard Dosen</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Dashboard</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px;">
        <!-- Card 1 -->
        <div class="card" style="display: flex; align-items: center; padding: 25px;">
            <div style="background-color: #EBF4FF; width: 60px; height: 60px; border-radius: 12px; display: flex; justify-content: center; align-items: center; margin-right: 20px;">
                <i class="fa-solid fa-users" style="font-size: 24px; color: var(--primary-blue);"></i>
            </div>
            <div>
                <div style="font-size: 32px; font-weight: 700; color: var(--text-dark); line-height: 1; margin-bottom: 5px;"><?= $mhs_bimbingan ?></div>
                <div style="font-size: 13px; color: var(--text-muted);">Kelompok Mahasiswa Bimbingan Aktif</div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="card" style="display: flex; align-items: center; padding: 25px;">
            <div style="background-color: #FFF4E5; width: 60px; height: 60px; border-radius: 12px; display: flex; justify-content: center; align-items: center; margin-right: 20px;">
                <i class="fa-solid fa-calendar-check" style="font-size: 24px; color: #FFA94D;"></i>
            </div>
            <div>
                <div style="font-size: 32px; font-weight: 700; color: var(--text-dark); line-height: 1; margin-bottom: 5px;"><?= $jadwal_sidang ?></div>
                <div style="font-size: 13px; color: var(--text-muted);">Jadwal Sidang Menunggu Nilai</div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 15px;"><i class="fa-solid fa-bullhorn" style="color: var(--primary-blue); margin-right: 8px;"></i> Papan Pengumuman & Pengingat</h2>
        <div style="background-color: #f8f9fa; border-left: 4px solid var(--primary-blue); padding: 15px; border-radius: 4px; margin-bottom: 10px;">
            <div style="font-weight: 600; font-size: 13px; margin-bottom: 5px;">Masa Bimbingan Kerja Praktek</div>
            <div style="font-size: 12px; color: var(--text-muted);">Bapak/Ibu Dosen diharap mengingatkan mahasiswa bimbingannya agar segera menyelesaikan laporan paling lambat bulan depan sebelum periode pendaftaran sidang ditutup.</div>
        </div>
    </div>
</div>

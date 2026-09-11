<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Dashboard Mahasiswa</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Dashboard</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div>
            <?php if(isset($huruf_final) && $huruf_final !== '-'): ?>
            <div class="card" style="display: flex; justify-content: space-between; align-items: center; background-color: #f8f9fa; border: 1px solid var(--border-color); margin-bottom: 20px;">
                <div>
                    <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 5px; color: var(--primary-blue);"><i class="fa-solid fa-graduation-cap"></i> Hasil Penilaian Sidang KP</h2>
                    <p style="font-size: 13px; color: var(--text-muted); margin: 0;">Rata-rata Nilai Angka: <strong><?= number_format($nilai_final, 2) ?></strong></p>
                    <?php if(!$nilai_perusahaan_done): ?>
                    <p style="font-size: 11px; color: #dc3545; margin: 5px 0 0 0;"><i>*(Nilai dari perusahaan belum diinputkan oleh dosen pembimbing)</i></p>
                    <?php endif; ?>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 12px; color: var(--text-muted);">Nilai Akhir Huruf</div>
                    <div style="font-size: 32px; font-weight: 800; color: var(--success-green); line-height: 1;"><?= $huruf_final ?></div>
                </div>
            </div>
            <?php endif; ?>

            <div class="card" style="margin-bottom: 20px;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;"><i class="fa-solid fa-chart-pie"></i> Progres Kerja Praktek</h2>
                
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background-color: <?= $status_color ?>; color: white; display: flex; align-items: center; justify-content: center; font-size: 24px;">
                        <i class="fa-solid <?= $status_icon ?>"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 5px;">Status Saat Ini</div>
                        <div style="font-size: 18px; font-weight: 700; color: <?= $status_color ?>;"><?= htmlspecialchars($status_kp) ?></div>
                    </div>
                </div>

                <div style="background-color: #e9ecef; border-radius: 10px; height: 15px; width: 100%; overflow: hidden;">
                    <div style="background-color: <?= $status_color ?>; width: <?= $progress_width ?>; height: 100%; border-radius: 10px; transition: width 1s ease-in-out;"></div>
                </div>
                <div style="text-align: right; font-size: 12px; color: var(--text-muted); margin-top: 5px; font-weight: 600;">
                    <?= $progress_width ?> Selesai
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 15px;"><i class="fa-solid fa-bullhorn"></i> Pengumuman Koordinator</h2>
                <div style="padding: 15px; border-left: 4px solid var(--primary-blue); background-color: #F4F9FF; margin-bottom: 10px; border-radius: 4px;">
                    <div style="font-size: 13px; font-weight: 600; margin-bottom: 5px;">Jadwal Pendaftaran Kelompok KP <?= htmlspecialchars(get_setting('tahun_akademik')) ?></div>
                    <p style="font-size: 12px; margin: 0; line-height: 1.5;">Pendaftaran kelompok Kerja Praktek telah dibuka. Silakan segera bentuk kelompok dengan maksimal 3 anggota dan ajukan melalui menu Pengajuan Kelompok.</p>
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;"><i class="fa-solid fa-list-check"></i> Alur Kerja Praktek</h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px; position: relative;">
                    <!-- Vertical Line -->
                    <div style="position: absolute; left: 11px; top: 10px; bottom: 10px; width: 2px; background-color: #e9ecef; z-index: 1;"></div>

                    <div style="display: flex; gap: 15px; align-items: flex-start; position: relative; z-index: 2;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background-color: <?= ($progress_width == '0%' || $progress_width == '5%') ? '#e9ecef' : 'var(--success-green)' ?>; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px;">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; <?= ($progress_width == '0%' || $progress_width == '5%') ? 'color: var(--text-muted);' : '' ?>">1. Pendaftaran Kelompok</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Bentuk kelompok (Min 1, Max 3)</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; align-items: flex-start; position: relative; z-index: 2;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background-color: <?= (intval($progress_width) < 40) ? '#e9ecef' : 'var(--success-green)' ?>; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px;">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; <?= (intval($progress_width) < 40) ? 'color: var(--text-muted);' : '' ?>">2. Pengajuan Izin KP</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Isi data instansi/perusahaan tujuan</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; align-items: flex-start; position: relative; z-index: 2;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background-color: <?= (intval($progress_width) < 60) ? '#e9ecef' : 'var(--success-green)' ?>; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px;">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; <?= (intval($progress_width) < 60) ? 'color: var(--text-muted);' : '' ?>">3. Pengajuan Bimbingan</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Pilih usulan dosen pembimbing</div>
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; align-items: flex-start; position: relative; z-index: 2;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background-color: <?= (intval($progress_width) < 80) ? '#e9ecef' : 'var(--success-green)' ?>; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px;">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; <?= (intval($progress_width) < 80) ? 'color: var(--text-muted);' : '' ?>">4. Pelaksanaan & Laporan</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Kerjakan KP & catat kemajuan</div>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 15px; align-items: flex-start; position: relative; z-index: 2;">
                        <div style="width: 24px; height: 24px; border-radius: 50%; background-color: <?= (intval($progress_width) < 100) ? '#e9ecef' : 'var(--success-green)' ?>; display: flex; align-items: center; justify-content: center; color: white; font-size: 10px;">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; <?= (intval($progress_width) < 100) ? 'color: var(--text-muted);' : '' ?>">5. Pendaftaran Seminar</div>
                            <div style="font-size: 11px; color: var(--text-muted);">Ajukan jadwal sidang KP</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(isset($locked_message)): ?>
    <?php include __FOLDER_VIEW__ . 'workflow_lock_v.php'; ?>
<?php else: ?>
<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Pendaftaran Seminar KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Pendaftaran Seminar</span>
                </div>
            </div>

            <?php if($is_readonly): ?>
            <div class="alert-success">
                <i class="fa-solid fa-check-circle" style="margin-top: 2px;"></i>
                <div>Pendaftaran Seminar Anda telah dikirim dan sedang dalam proses atau sudah dijadwalkan. Data tidak dapat diubah lagi.</div>
            </div>
            <?php elseif(isset($seminar_data) && ($seminar_data['status_dospem'] == 'tolak' || $seminar_data['status_koor'] == 'tolak')): ?>
            <div class="alert-danger">
                <i class="fa-solid fa-circle-exclamation" style="margin-top: 2px;"></i>
                <div>
                    <strong>Pendaftaran Seminar Ditolak!</strong><br>
                    Silakan perbaiki persyaratan Anda dan unggah ulang file dokumen yang diminta. Alasan penolakan: <em><?= htmlspecialchars($seminar_data['catatan_tolak'] ?? 'Tidak ada catatan') ?></em>
                </div>
            </div>
            <?php endif; ?>

            <div class="card">
                <form method="POST" enctype="multipart/form-data">
                    <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;"><i class="fa-solid fa-list"></i> Data Laporan & Pelaksanaan KP</h3>

                    <div class="form-group">
                        <label class="form-label">Judul Laporan KP (Final)</label>
                        <input type="text" name="judul_laporan" class="form-control" value="<?= htmlspecialchars($bimbingan_data['judul_laporan'] ?? '') ?>" <?= ($is_readonly || !$is_user_ketua) ? 'readonly style="background-color: #e9ecef; cursor: not-allowed;"' : 'required' ?>>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Tanggal Mulai Pelaksanaan KP</label>
                            <input type="date" class="form-control" value="<?= htmlspecialchars($bimbingan_data['tgl_mulai_kp'] ?? '') ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Selesai Pelaksanaan KP</label>
                            <input type="date" class="form-control" value="<?= htmlspecialchars($bimbingan_data['tgl_selesai_kp'] ?? '') ?>" readonly style="background-color: #e9ecef; cursor: not-allowed;">
                        </div>
                    </div>

                    <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px; margin-top: 15px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;"><i class="fa-solid fa-upload"></i> Upload Dokumen Syarat Seminar</h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Upload Slip Pembayaran Seminar KP (JPG/PDF)</label>
                            <div class="file-upload-wrapper" <?= (!$is_readonly && $is_user_ketua) ? 'onclick="document.getElementById(\'file-slip\').click()"' : 'style="background-color: #f8f9fa; cursor: not-allowed;"' ?>>
                                <i class="fa-solid fa-receipt" style="font-size: 24px; color: var(--success-green); margin-bottom: 10px;"></i>
                                <p style="font-size: 13px; font-weight: 600; margin-bottom: 5px;" id="text-file-slip"><?= $is_readonly ? htmlspecialchars($seminar_data['file_slip_seminar']) : 'Upload Slip Pembayaran' ?></p>
                                <input type="file" name="file_slip_seminar" id="file-slip" style="display: none;" accept="application/pdf,image/*" <?= ($is_readonly || !$is_user_ketua) ? '' : 'required onchange="document.getElementById(\'text-file-slip\').innerText = this.files[0].name"' ?>>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Upload Laporan KP (Draft Final) (PDF)</label>
                            <div class="file-upload-wrapper" <?= (!$is_readonly && $is_user_ketua) ? 'onclick="document.getElementById(\'file-laporan\').click()"' : 'style="background-color: #f8f9fa; cursor: not-allowed;"' ?>>
                                <i class="fa-solid fa-file-pdf" style="font-size: 24px; color: #dc3545; margin-bottom: 10px;"></i>
                                <p style="font-size: 13px; font-weight: 600; margin-bottom: 5px;" id="text-file-laporan"><?= $is_readonly ? htmlspecialchars($seminar_data['file_draft_laporan']) : 'Upload Laporan KP' ?></p>
                                <input type="file" name="file_draft_laporan" id="file-laporan" style="display: none;" accept="application/pdf" <?= ($is_readonly || !$is_user_ketua) ? '' : 'required onchange="document.getElementById(\'text-file-laporan\').innerText = this.files[0].name"' ?>>
                            </div>
                        </div>
                    </div>

                    <?php if(!$is_readonly && $is_user_ketua): ?>
                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Daftar Seminar Sekarang</button>
                    </div>
                    <?php elseif(!$is_readonly && !$is_user_ketua): ?>
                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color); text-align: center; color: var(--text-muted); font-size: 13px;">
                        <i>Hanya Ketua Kelompok yang dapat mengisi dan mengajukan form Pendaftaran Seminar.</i>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;"><i class="fa-regular fa-calendar-check" style="color: var(--primary-blue);"></i> Informasi Jadwal Seminar Anda</h2>
                <?php if(isset($seminar_data['status_koor']) && $seminar_data['status_koor'] == 'dijadwalkan'): ?>
                <div style="background-color: #F8F9FA; border: 1px solid var(--success-green); border-radius: 8px; padding: 25px; display: flex; flex-direction: column; gap: 15px;">
                    <div style="display: flex; gap: 15px; align-items: center; border-bottom: 1px solid #dee2e6; padding-bottom: 15px;">
                        <div style="background-color: var(--success-green); color: white; width: 60px; height: 60px; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                            <span style="font-size: 24px; font-weight: 700; line-height: 1;"><?= date('d', strtotime($seminar_data['tgl_seminar'])) ?></span>
                            <span style="font-size: 12px; font-weight: 600; text-transform: uppercase;"><?= date('M', strtotime($seminar_data['tgl_seminar'])) ?></span>
                        </div>
                        <div>
                            <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 5px; color: var(--text-dark);">Sidang Seminar KP</h3>
                            <p style="font-size: 13px; color: var(--text-muted);"><i class="fa-regular fa-clock" style="margin-right: 5px;"></i> <?= date('H:i', strtotime($seminar_data['jam_seminar'])) ?> WIB</p>
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; font-size: 13px;">
                        <div>
                            <div style="color: var(--text-muted); margin-bottom: 3px;">Ruangan</div>
                            <div style="font-weight: 600; color: var(--text-dark);"><i class="fa-solid fa-location-dot" style="margin-right: 5px; color: var(--primary-blue);"></i> <?= htmlspecialchars($seminar_data['ruangan'] ?? '-') ?></div>
                        </div>
                        <div>
                            <div style="color: var(--text-muted); margin-bottom: 3px;">Dosen Pembimbing</div>
                            <div style="font-weight: 600; color: var(--text-dark);"><i class="fa-solid fa-user-tie" style="margin-right: 5px; color: var(--primary-blue);"></i> <?= htmlspecialchars($seminar_data['nama_penguji1'] ?? 'Menunggu') ?></div>
                        </div>
                        <div>
                            <div style="color: var(--text-muted); margin-bottom: 3px;">Dosen Penguji</div>
                            <div style="font-weight: 600; color: var(--text-dark);"><i class="fa-solid fa-user-tie" style="margin-right: 5px; color: var(--primary-blue);"></i> <?= htmlspecialchars($seminar_data['nama_penguji2'] ?? 'Menunggu') ?></div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div style="background-color: #F8F9FA; border: 1px solid var(--border-color); border-radius: 8px; padding: 30px; text-align: center;">
                    <i class="fa-solid fa-clock-rotate-left" style="font-size: 40px; color: #adb5bd; margin-bottom: 15px;"></i>
                    <h3 style="font-size: 16px; color: var(--text-dark); margin-bottom: 5px;">Belum Ada Jadwal</h3>
                    <p style="font-size: 13px; color: var(--text-muted);">Jadwal akan muncul di sini setelah divalidasi dan diatur oleh Koordinator KP.</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
<?php endif; ?>
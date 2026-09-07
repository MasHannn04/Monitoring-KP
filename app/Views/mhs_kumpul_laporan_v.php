<?php if(isset($locked_message)): ?>
    <?= $this->include('workflow_lock_v') ?>
<?php else: ?>
<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Pengumpulan Laporan Akhir KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Pengumpulan Laporan</span>
                </div>
            </div>

            <div class="alert-info">
                <i class="fa-solid fa-circle-info" style="margin-top: 2px;"></i>
                <div>
                    <strong>Informasi:</strong> Unggah Laporan Akhir yang sudah direvisi pasca-sidang beserta berkas kelengkapan administrasi lainnya. Laporan ini akan divalidasi oleh Koordinator KP untuk penerbitan nilai akhir.
                </div>
            </div>

            <?php if($is_readonly): ?>
            <div class="alert-success">
                <i class="fa-solid fa-check-circle" style="margin-top: 2px;"></i>
                <div>Laporan Akhir KP Anda telah dikumpulkan dan sedang dalam proses atau sudah disetujui. Data tidak dapat diubah lagi.</div>
            </div>
            <?php endif; ?>

            <?php if($huruf_final !== '-'): ?>
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

            <div class="card">
                <form method="POST" enctype="multipart/form-data">
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; padding-bottom: 20px;">
                        
                        <div class="form-group" style="height: 100%; margin-bottom: 0;">
                            <label class="form-label" style="text-align: center;">Upload Laporan KP (Final) (PDF)</label>
                            <div class="file-upload-wrapper" style="<?= $is_readonly ? 'background-color: #f8f9fa; cursor: not-allowed;' : 'cursor: pointer; background-color: white;' ?>" <?= !$is_readonly ? 'onclick="document.getElementById(\'file-laporan\').click()"' : '' ?>>
                                <i class="fa-solid fa-file-pdf" style="font-size: 34px; color: #dc3545;"></i>
                                <p style="font-size: 12px; font-weight: 600; margin-top: 12px; margin-bottom: 0; word-break: break-all; padding: 0 10px;" id="text-file-laporan"><?= $is_readonly ? htmlspecialchars($laporan_data['file_laporan_final']) : 'Klik untuk upload' ?></p>
                                <input type="file" name="file_laporan_final" id="file-laporan" style="display: none;" accept="application/pdf" <?= $is_readonly ? '' : 'required onchange="document.getElementById(\'text-file-laporan\').innerText = this.files[0].name"' ?>>
                            </div>
                        </div>

                        <div class="form-group" style="height: 100%; margin-bottom: 0;">
                            <label class="form-label" style="text-align: center;">Upload Surat Tugas (PDF)</label>
                            <div class="file-upload-wrapper" style="<?= $is_readonly ? 'background-color: #f8f9fa; cursor: not-allowed;' : 'cursor: pointer; background-color: white;' ?>" <?= !$is_readonly ? 'onclick="document.getElementById(\'file-tugas\').click()"' : '' ?>>
                                <i class="fa-solid fa-file-signature" style="font-size: 34px; color: var(--primary-blue);"></i>
                                <p style="font-size: 12px; font-weight: 600; margin-top: 12px; margin-bottom: 0; word-break: break-all; padding: 0 10px;" id="text-file-tugas"><?= $is_readonly ? htmlspecialchars($laporan_data['file_surat_tugas']) : 'Klik untuk upload' ?></p>
                                <input type="file" name="file_surat_tugas" id="file-tugas" style="display: none;" accept="application/pdf" <?= $is_readonly ? '' : 'required onchange="document.getElementById(\'text-file-tugas\').innerText = this.files[0].name"' ?>>
                            </div>
                        </div>

                        <div class="form-group" style="height: 100%; margin-bottom: 0;">
                            <label class="form-label" style="text-align: center;">Upload Nilai dari Perusahaan (PDF)</label>
                            <div class="file-upload-wrapper" style="<?= $is_readonly ? 'background-color: #f8f9fa; cursor: not-allowed;' : 'cursor: pointer; background-color: white;' ?>" <?= !$is_readonly ? 'onclick="document.getElementById(\'file-nilai\').click()"' : '' ?>>
                                <i class="fa-solid fa-star-half-stroke" style="font-size: 34px; color: #FFA94D;"></i>
                                <p style="font-size: 12px; font-weight: 600; margin-top: 12px; margin-bottom: 0; word-break: break-all; padding: 0 10px;" id="text-file-nilai"><?= $is_readonly ? htmlspecialchars($laporan_data['file_nilai_perusahaan']) : 'Klik untuk upload' ?></p>
                                <input type="file" name="file_nilai_perusahaan" id="file-nilai" style="display: none;" accept="application/pdf" <?= $is_readonly ? '' : 'required onchange="document.getElementById(\'text-file-nilai\').innerText = this.files[0].name"' ?>>
                            </div>
                        </div>

                    </div>

                    <?php if(!$is_readonly): ?>
                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Kumpulkan Laporan Akhir</button>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Status Pengumpulan & Kelulusan KP</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Kumpul</th>
                                <th>Status Pembimbing</th>
                                <th>Status Koordinator</th>
                                <th>Nilai Akhir KP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!$laporan_data): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada data pengumpulan laporan akhir.</td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td><?= date('d-M-Y', strtotime($laporan_data['tgl_pengumpulan'])) ?></td>
                                <td>
                                    <?php if ($laporan_data['status_dospem'] == 'menunggu'): ?>
                                        <span class="badge" style="background-color: #FFA94D;"><i class="fa-solid fa-clock"></i> Menunggu Dosen</span>
                                    <?php elseif ($laporan_data['status_dospem'] == 'acc'): ?>
                                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Disetujui Dosen</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #dc3545;"><i class="fa-solid fa-xmark"></i> Revisi/Ditolak Dosen</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($laporan_data['status_koor'] == 'menunggu'): ?>
                                        <span class="badge" style="background-color: #FFA94D;"><i class="fa-solid fa-clock"></i> Menunggu Koor</span>
                                    <?php elseif ($laporan_data['status_koor'] == 'acc'): ?>
                                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Disetujui Koor</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #dc3545;"><i class="fa-solid fa-xmark"></i> Revisi/Ditolak Koor</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($laporan_data['nilai_akhir_huruf']): ?>
                                        <div style="font-size: 20px; font-weight: 700; color: var(--primary-blue);"><?= htmlspecialchars($laporan_data['nilai_akhir_huruf']) ?></div>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php endif; ?>
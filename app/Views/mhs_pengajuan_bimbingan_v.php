<?php if(isset($locked_message)): ?>
    <?php include __FOLDER_VIEW__ . 'workflow_lock_v.php'; ?>
<?php else: ?>
<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Pengajuan Bimbingan KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Pengajuan Bimbingan</span>
                </div>
            </div>

            <div class="alert-info">
                <i class="fa-solid fa-circle-info" style="margin-top: 2px;"></i>
                <div>
                    <strong>Informasi:</strong> Form ini diisi setelah Anda mendapatkan balasan diterima dari Instansi/Perusahaan. Lengkapi form dan upload dokumen yang dibutuhkan. Koordinator akan menentukan Dosen Pembimbing untuk Anda.
                </div>
            </div>

            <?php if($is_readonly): ?>
            <div class="alert-success">
                <i class="fa-solid fa-check-circle" style="margin-top: 2px;"></i>
                <div>Pengajuan Bimbingan Anda telah diajukan atau <strong>Disetujui</strong>. Data ini tidak dapat diubah lagi.</div>
            </div>
            <?php endif; ?>
            
            <?php if(isset($bimbingan_data) && $bimbingan_data['status_bimbingan'] == 'ditolak'): ?>
            <div class="alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <div>
                    <div>Pengajuan Bimbingan Anda <strong>Ditolak</strong> oleh Koordinator.</div>
                    <div style="margin-top: 4px;"><strong>Alasan:</strong> <?= htmlspecialchars($bimbingan_data['bimbingan_note'] ?? 'Tidak ada alasan.') ?> Silakan perbaiki data di bawah ini dan ajukan kembali.</div>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($bimbingan_data) && $bimbingan_data['status_bimbingan'] == 'disetujui' && !empty($bimbingan_data['file_surat_tugas'])): ?>
            <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($bimbingan_data['file_surat_tugas']) ?>" target="_blank" class="btn btn-info" style="flex: 1; text-align: center; background-color: #17a2b8; color: white; text-decoration: none; padding: 12px; font-weight: 600;"><i class="fa-solid fa-eye"></i> Lihat Surat Tugas Pembimbing</a>
                <a href="uploads/<?= urlencode($bimbingan_data['file_surat_tugas']) ?>" download class="btn btn-success" style="flex: 1; text-align: center; text-decoration: none; padding: 12px; font-weight: 600;"><i class="fa-solid fa-download"></i> Unduh Surat Tugas</a>
            </div>
            <?php endif; ?>

            <div class="card">
                <form method="POST" action="<?= base_url('mhs_pengajuan_bimbingan') ?>" enctype="multipart/form-data">
                    <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;"><i class="fa-solid fa-building"></i> Data Instansi & Surat Balasan</h3>

                    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Nama Perusahaan / Instansi Tujuan</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($instansi_data['nama_instansi'] ?? 'Belum ada data') ?>" readonly style="background-color: #e9ecef;">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Kota Perusahaan</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($instansi_data['kota'] ?? 'Belum ada data') ?>" readonly style="background-color: #e9ecef;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap Perusahaan</label>
                        <textarea class="form-control" rows="2" readonly style="background-color: #e9ecef;"><?= htmlspecialchars($instansi_data['alamat'] ?? 'Belum ada data') ?></textarea>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Nomor Surat Balasan Perusahaan</label>
                            <input type="text" class="form-control" name="field_1" placeholder="No. Surat dari Perusahaan" value="<?= htmlspecialchars($bimbingan_data['no_surat_balasan'] ?? '') ?>" <?= ($is_readonly || !$is_user_ketua) ? 'readonly style="background-color: #e9ecef; cursor: not-allowed;"' : 'required' ?>>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Surat Balasan Perusahaan</label>
                            <input type="date" class="form-control" name="field_2" value="<?= htmlspecialchars($bimbingan_data['tgl_surat_balasan'] ?? '') ?>" <?= ($is_readonly || !$is_user_ketua) ? 'readonly style="background-color: #e9ecef; cursor: not-allowed;"' : 'required' ?>>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Mulai Pelaksanaan KP</label>
                            <input type="date" class="form-control" name="field_3" value="<?= htmlspecialchars($bimbingan_data['tgl_mulai_kp'] ?? '') ?>" <?= ($is_readonly || !$is_user_ketua) ? 'readonly style="background-color: #e9ecef; cursor: not-allowed;"' : 'required' ?>>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Selesai Pelaksanaan KP</label>
                            <input type="date" class="form-control" name="field_4" value="<?= htmlspecialchars($bimbingan_data['tgl_selesai_kp'] ?? '') ?>" <?= ($is_readonly || !$is_user_ketua) ? 'readonly style="background-color: #e9ecef; cursor: not-allowed;"' : 'required' ?>>
                        </div>
                    </div>

                    <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px; margin-top: 15px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;"><i class="fa-solid fa-upload"></i> Upload Dokumen Pendukung</h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label class="form-label">Upload Surat Balasan (Diterima) (PDF/JPG)</label>
                            <div class="file-upload-wrapper" <?= (!$is_readonly && $is_user_ketua) ? 'onclick="document.getElementById(\'file-surat\').click()"' : 'style="background-color: #f8f9fa; cursor: not-allowed;"' ?>>
                                <i class="fa-solid fa-envelope-open-text" style="font-size: 24px; color: var(--primary-blue); margin-bottom: 10px;"></i>
                                <p id="text-surat" style="font-size: 13px; font-weight: 600;"><?= $is_readonly ? 'Dokumen sudah diupload' : 'Klik untuk upload Surat Balasan' ?></p>
                                <input type="file" name="file_surat" id="file-surat" style="display: none;" accept="application/pdf,image/*" onchange="document.getElementById('text-surat').innerText = this.files[0] ? this.files[0].name : 'Klik untuk upload Surat Balasan'">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Upload Slip Pembayaran Bimbingan KP (JPG/PDF)</label>
                            <div class="file-upload-wrapper" <?= (!$is_readonly && $is_user_ketua) ? 'onclick="document.getElementById(\'file-slip\').click()"' : 'style="background-color: #f8f9fa; cursor: not-allowed;"' ?>>
                                <i class="fa-solid fa-receipt" style="font-size: 24px; color: var(--success-green); margin-bottom: 10px;"></i>
                                <p id="text-slip" style="font-size: 13px; font-weight: 600;"><?= $is_readonly ? 'Dokumen sudah diupload' : 'Klik untuk upload Slip Bayar' ?></p>
                                <input type="file" name="file_slip" id="file-slip" style="display: none;" accept="application/pdf,image/*" onchange="document.getElementById('text-slip').innerText = this.files[0] ? this.files[0].name : 'Klik untuk upload Slip Bayar'">
                            </div>
                        </div>
                    </div>

                    <?php if(!$is_readonly && $is_user_ketua): ?>
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Ajukan Bimbingan</button>
                    </div>
                    <?php elseif(!$is_readonly && !$is_user_ketua): ?>
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border-color); text-align: center; color: var(--text-muted); font-size: 13px;">
                        <i>Hanya Ketua Kelompok yang dapat mengisi dan mengajukan form Bimbingan.</i>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Status Pengajuan Bimbingan</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Instansi Tujuan</th>
                                <th>Status Koordinator</th>
                                <th>Dosen Pembimbing</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($bimbingan_data): ?>
                            <tr>
                                <td><?= htmlspecialchars($instansi_data['nama_instansi'] ?? '-') ?></td>
                                <td>
                                    <?php if($bimbingan_data['status_bimbingan'] == 'menunggu'): ?>
                                        <span class="badge" style="background-color: #FFA94D;">Menunggu Validasi</span>
                                    <?php elseif($bimbingan_data['status_bimbingan'] == 'disetujui'): ?>
                                        <span class="badge badge-success">Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">Ditolak</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($dospem_nama): ?>
                                        <strong><?= htmlspecialchars($dospem_nama) ?></strong>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">Belum ditentukan</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada pengajuan bimbingan.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php endif; ?>
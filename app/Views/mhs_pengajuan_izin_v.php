<?php if(isset($locked_message)): ?>
    <?= $this->include('workflow_lock_v') ?>
<?php else: ?>
<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Pengajuan Surat Izin KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Pengajuan Izin</span>
                </div>
            </div>

            <div class="alert-info">
                <i class="fa-solid fa-circle-info" style="margin-top: 2px;"></i>
                <div>
                    <strong>Informasi:</strong> Lengkapi data instansi dan kontak masing-masing anggota. Form ini akan diproses oleh Koordinator untuk dibuatkan Surat Izin KP Digital.
                </div>
            </div>

            <?php if(isset($instansi_data)): ?>
                <?php if($instansi_data['status_izin'] == 'draft'): ?>
                <div class="alert-secondary">
                    <i class="fa-solid fa-edit" style="margin-top: 2px;"></i>
                    <div>Pengajuan izin KP Anda sedang dalam status <strong>Draft</strong>. Harap lengkapi semua data, kemudian Ketua Kelompok harus menekan tombol Kirim agar diproses.</div>
                </div>
                <?php elseif($instansi_data['status_izin'] == 'menunggu'): ?>
                <div class="alert-warning">
                    <i class="fa-solid fa-clock" style="margin-top: 2px;"></i>
                    <div>Pengajuan izin KP Anda sedang menunggu validasi dari Koordinator. Data tidak dapat diubah sementara.</div>
                </div>
                <?php elseif($instansi_data['status_izin'] == 'disetujui'): ?>
                <div class="alert-success">
                    <i class="fa-solid fa-check-circle" style="margin-top: 2px;"></i>
                    <div>Surat Izin KP Anda telah disetujui dan diterbitkan. Silakan unduh melalui tombol cetak di bawah.</div>
                </div>
                <?php elseif($instansi_data['status_izin'] == 'ditolak'): ?>
                <div class="alert-danger">
                    <i class="fa-solid fa-circle-xmark" style="margin-top: 2px;"></i>
                    <div>Pengajuan Surat Izin KP Anda ditolak. Silakan perbaiki dan ajukan kembali.</div>
                </div>
                <?php endif; ?>
            <?php endif; ?>

            <div class="card">
                <form method="POST" action="<?= base_url('mhs_pengajuan_izin') ?>">
                    <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;"><i class="fa-solid fa-address-book"></i> Data Kontak Anggota Kelompok</h3>
                    
                    <?php foreach($anggota_list as $a): 
                        $can_edit = ($is_user_ketua || $a['mhs_id'] == $_SESSION['user_id']);
                    ?>
                    <div class="contact-grid" style="margin-bottom: 20px;">
                        <div>
                            <div style="font-weight: 600; font-size: 13px;"><?= htmlspecialchars($a['nama']) ?> (<?= htmlspecialchars($a['npm_nip']) ?>)</div>
                            <?php if($a['is_ketua']): ?>
                                <span class="badge badge-primary" style="margin-top: 5px;">Ketua</span>
                            <?php else: ?>
                                <span class="badge" style="background-color: #6c757d; margin-top: 5px;">Anggota</span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 11px;">Nomor WA</label>
                            <input type="text" class="form-control" name="wa_<?= $a['mhs_id'] ?>" placeholder="0812..." value="<?= htmlspecialchars($a['no_wa'] ?? '') ?>" <?= (!$can_edit || $is_readonly) ? 'readonly style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;"' : '' ?>>
                        </div>
                        <div>
                            <label class="form-label" style="font-size: 11px;">Email</label>
                            <input type="email" class="form-control" name="email_<?= $a['mhs_id'] ?>" placeholder="<?= htmlspecialchars($a['npm_nip']) ?>@mhs.itats.ac.id" value="<?= htmlspecialchars($a['email'] ?? '') ?>" <?= (!$can_edit || $is_readonly) ? 'readonly style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;"' : '' ?>>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;"><i class="fa-solid fa-building"></i> Data Instansi / Perusahaan</h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                <div>
                    <label class="form-label">Nama Perusahaan / Instansi Tujuan</label>
                    <input type="text" class="form-control" name="field_5" placeholder="Contoh: PT. Bintang Sejahtera" value="<?= htmlspecialchars($instansi_data['nama_instansi'] ?? '') ?>" <?= (!$is_user_ketua || $is_readonly) ? 'readonly style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;"' : '' ?> required>
                </div>
                <div>
                    <label class="form-label">Kota Perusahaan</label>
                    <input type="text" class="form-control" name="field_6" placeholder="Contoh: Surabaya" value="<?= htmlspecialchars($instansi_data['kota'] ?? '') ?>" <?= (!$is_user_ketua || $is_readonly) ? 'readonly style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;"' : '' ?> required>
                </div>
            </div>
            <div style="margin-bottom: 15px;">
                <label class="form-label">Alamat Lengkap Perusahaan</label>
                <textarea class="form-control" name="field_9" rows="3" placeholder="Masukkan alamat lengkap" <?= (!$is_user_ketua || $is_readonly) ? 'readonly style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;"' : '' ?> required><?= htmlspecialchars($instansi_data['alamat'] ?? '') ?></textarea>
            </div>
            
            <div style="margin-bottom: 15px;">
                <label class="form-label">Penerima Surat Izin KP (Ditujukan Kepada)</label>
                <input type="text" class="form-control" name="field_7" placeholder="Contoh: Yth. HRD Manager / Kepala Bagian SDM" value="<?= htmlspecialchars($instansi_data['ditujukan_kepada'] ?? '') ?>" <?= (!$is_user_ketua || $is_readonly) ? 'readonly style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;"' : '' ?> required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label class="form-label">Bidang KP yang dilaksanakan</label>
                    <?php if (!$is_user_ketua || $is_readonly): ?>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($instansi_data['bidang_kp'] ?? '') ?>" readonly style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;">
                    <?php else: ?>
                        <select class="form-control" name="field_8" required>
                            <option value="">-- Pilih Bidang --</option>
                            <option value="Jaringan Komputer" <?= (isset($instansi_data['bidang_kp']) && $instansi_data['bidang_kp'] == 'Jaringan Komputer') ? 'selected' : '' ?>>Jaringan Komputer</option>
                            <option value="Basis Data" <?= (isset($instansi_data['bidang_kp']) && $instansi_data['bidang_kp'] == 'Basis Data') ? 'selected' : '' ?>>Basis Data</option>
                            <option value="Pemrograman Sistem Informasi" <?= (isset($instansi_data['bidang_kp']) && $instansi_data['bidang_kp'] == 'Pemrograman Sistem Informasi') ? 'selected' : '' ?>>Pemrograman Sistem Informasi</option>
                            <option value="Manajemen IT" <?= (isset($instansi_data['bidang_kp']) && $instansi_data['bidang_kp'] == 'Manajemen IT') ? 'selected' : '' ?>>Manajemen IT</option>
                            <option value="Bisnis Digital" <?= (isset($instansi_data['bidang_kp']) && $instansi_data['bidang_kp'] == 'Bisnis Digital') ? 'selected' : '' ?>>Bisnis Digital</option>
                        </select>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="form-label">Lama KP (Dalam Bulan)</label>
                    <?php if (!$is_user_ketua || $is_readonly): ?>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($instansi_data['lama_kp'] ?? '1 Bulan') ?>" readonly style="background-color: #e9ecef; color: #6c757d; cursor: not-allowed;">
                    <?php else: ?>
                        <select class="form-control" name="field_10" required>
                            <option value="">-- Pilih Lama KP --</option>
                            <option value="1 Bulan" <?= (isset($instansi_data['lama_kp']) && $instansi_data['lama_kp'] == '1 Bulan') ? 'selected' : '' ?>>1 Bulan</option>
                            <option value="2 Bulan" <?= (isset($instansi_data['lama_kp']) && $instansi_data['lama_kp'] == '2 Bulan') ? 'selected' : '' ?>>2 Bulan</option>
                            <option value="3 Bulan" <?= (isset($instansi_data['lama_kp']) && $instansi_data['lama_kp'] == '3 Bulan') ? 'selected' : '' ?>>3 Bulan</option>
                        </select>
                    <?php endif; ?>
                </div>
            </div>

                    
        <?php if(!$is_readonly): ?>
        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button type="submit" name="action" value="simpan_draft" class="btn btn-secondary" style="flex: 1; background-color: #6c757d; border-color: #6c757d;"><i class="fa-solid fa-save"></i> Simpan Data (Draft)</button>
            <?php if($is_user_ketua): ?>
            <button type="submit" name="action" value="kirim_pengajuan" class="btn btn-primary" style="flex: 1;"><i class="fa-solid fa-paper-plane"></i> Kirim ke Koordinator</button>
            <?php endif; ?>
        </div>
        <?php else: ?>
            <?php if($instansi_data['status_izin'] == 'disetujui' && !empty($instansi_data['file_surat_izin'])): ?>
            <div style="display: flex; gap: 15px; margin-top: 30px;">
                <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($instansi_data['file_surat_izin']) ?>" target="_blank" class="btn btn-info" style="flex: 1; text-align: center; background-color: #17a2b8; color: white; text-decoration: none;"><i class="fa-solid fa-eye"></i> Lihat Surat Izin KP</a>
                <a href="uploads/<?= urlencode($instansi_data['file_surat_izin']) ?>" download class="btn btn-success" style="flex: 1; text-align: center; text-decoration: none;"><i class="fa-solid fa-download"></i> Unduh Surat Izin KP</a>
            </div>
            <?php endif; ?>
        <?php endif; ?>

    </form>
</div>
            
            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Riwayat Pengajuan Izin</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Instansi Tujuan</th>
                                <th>Status</th>
                                <th>Surat Izin (Digital)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($izin_history) > 0): ?>
                                <?php foreach($izin_history as $hist): ?>
                                <tr>
                                    <td><?= !empty($hist['tanggal_pengajuan']) ? date('d-M-Y', strtotime($hist['tanggal_pengajuan'])) : 'Belum diajukan' ?></td>
                                    <td><?= htmlspecialchars($hist['nama_instansi']) ?></td>
                                    <td>
                                        <?php if($hist['status_izin'] == 'draft'): ?>
                                            <span class="badge" style="background-color: #6c757d;">Draft</span>
                                        <?php elseif($hist['status_izin'] == 'menunggu'): ?>
                                            <span class="badge" style="background-color: #FFA94D;">Menunggu Validasi</span>
                                        <?php elseif($hist['status_izin'] == 'disetujui'): ?>
                                            <span class="badge badge-success">Disetujui</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Ditolak</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($hist['status_izin'] == 'disetujui' && !empty($hist['file_surat_izin'])): ?>
                                            <div style="display: flex; gap: 5px;">
                                                <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($hist['file_surat_izin']) ?>" target="_blank" class="btn btn-info" style="font-size: 11px; padding: 4px 8px; text-decoration: none; background-color: #17a2b8; color: white;"><i class="fa-solid fa-eye"></i> Lihat</a>
                                                <a href="uploads/<?= urlencode($hist['file_surat_izin']) ?>" download class="btn btn-success" style="font-size: 11px; padding: 4px 8px; text-decoration: none;"><i class="fa-solid fa-download"></i> Unduh</a>
                                            </div>
                                        <?php else: ?>
                                            <span style="color: var(--text-muted); font-size: 12px;">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada riwayat pengajuan izin.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if ($is_user_ketua && count($izin_history) > 0 && empty($status_reset)): ?>
            <div class="card" style="margin-top: 20px; border: 1px solid #dc3545; background-color: #fffafb;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 10px; color: #dc3545;"><i class="fa-solid fa-triangle-exclamation"></i> Pengajuan Ganti Perusahaan</h2>
                <p style="font-size: 13px; margin-bottom: 15px;">Jika Anda ingin mengganti tempat Kerja Praktek (misal karena ditolak oleh perusahaan atau alasan lain), Anda dapat mengajukan reset progres ke Koordinator KP. <br><strong>Perhatian:</strong> Jika disetujui, seluruh data Instansi dan Bimbingan kelompok Anda saat ini akan dihapus dan Anda akan memulai kembali dari pengajuan izin!</p>
                <form method="POST" id="formReset">
                    <input type="hidden" name="action" value="req_reset">
                    <div style="margin-bottom: 15px;">
                        <label class="form-label" style="color: #dc3545;">Alasan Mengganti Perusahaan</label>
                        <textarea name="alasan_reset" class="form-control" rows="3" required placeholder="Tuliskan secara jelas alasan mengapa Anda ingin mengganti instansi..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color: #dc3545; border: none;"><i class="fa-solid fa-rotate-left"></i> Ajukan Permohonan Reset</button>
                </form>
            </div>
            <?php elseif (!empty($status_reset)): ?>
            <div class="card" style="margin-top: 20px; border: 1px solid #FFA94D; background-color: #fffaf0;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 10px; color: #d35400;">Status Pengajuan Ganti Perusahaan</h2>
                <div style="font-size: 13px; margin-bottom: 15px;">
                    <strong>Alasan Pengajuan:</strong> <?= htmlspecialchars($alasan_reset) ?>
                </div>
                <div style="padding: 10px; background-color: #ffe8cc; color: #d35400; font-weight: 600; border-radius: 4px;">
                    <i class="fa-solid fa-info-circle"></i> Status Permohonan: <?= strtoupper($status_reset) ?>
                    <?php if ($status_reset == 'menunggu'): ?>
                        (Sedang menunggu konfirmasi dari Koordinator KP)
                    <?php elseif ($status_reset == 'ditolak'): ?>
                        (Permohonan Anda ditolak oleh Koordinator)
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?php endif; ?>

<script>
if (document.getElementById('formReset')) {
    document.getElementById('formReset').addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Ajukan Reset Perusahaan?',
            text: 'Apakah Anda yakin ingin mengajukan permohonan reset perusahaan? Seluruh progres saat ini akan dihapus jika disetujui.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ajukan Reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
}
</script>
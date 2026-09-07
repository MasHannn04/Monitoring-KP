<?php if(isset($locked_message)): ?>
    <?php include __FOLDER_VIEW__ . 'workflow_lock_v.php'; ?>
<?php else: ?>
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .content-wrapper { padding: 0 !important; }
        .card { box-shadow: none !important; border: none !important; margin-bottom: 10px !important; }
    }
</style>
<div class="content-wrapper">
            <div class="page-header no-print">
                <h1 class="page-title">Pemantauan Kemajuan KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Kemajuan Laporan</span>
                </div>
            </div>

            <div class="card">
                <div class="no-print" style="font-size: 16px; font-weight: 600; color: var(--primary-blue); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
                    <div><i class="fa-solid fa-circle-info"></i> Informasi Bimbingan Dosen</div>
                    <!-- Tombol ini aktif/muncul ketika dosen sudah menekan tombol approval secara keseluruhan -->
                    <?php if(isset($bimbingan_data['status_dospem']) && $bimbingan_data['status_dospem'] == 'disetujui'): ?>
                        <button class="btn btn-primary" style="font-size: 12px; background-color: var(--success-green);" onclick="window.print()"><i class="fa-solid fa-print"></i> Cetak Kartu Bimbingan</button>
                    <?php else: ?>
                        <button class="btn btn-primary" style="font-size: 12px; background-color: #6c757d;" disabled><i class="fa-solid fa-print"></i> Cetak Kartu Bimbingan (Menunggu Approval Dosen)</button>
                    <?php endif; ?>
                </div>
                
                <div class="info-grid" style="margin-bottom: 20px;">
                    <div>
                        <div class="info-label">Dosen Pembimbing</div>
                        <div class="info-value"><?= htmlspecialchars($dospem_nama) ?></div>
                    </div>
                    <div>
                        <div class="info-label">Status Bimbingan</div>
                        <div class="info-value">
                            <?php if ($status_bimbingan == 'Bimbingan Selesai (Di-ACC)'): ?>
                                <span style="color: var(--success-green);"><i class="fa-solid fa-check-circle"></i> <?= htmlspecialchars($status_bimbingan) ?></span>
                            <?php else: ?>
                                <span style="color: #FFA94D;"><i class="fa-solid fa-spinner"></i> <?= htmlspecialchars($status_bimbingan) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div style="padding-top: 15px; border-top: 1px solid var(--border-color);">
                    <div class="info-label">Judul Kerja Praktek</div>
                    <div class="info-value"><?= htmlspecialchars($judul_kp) ?></div>
                </div>
            </div>

            <div class="card">
                <div class="table-header">
                    <h2 style="font-size: 16px; font-weight: 600;">Log Bimbingan</h2>
                </div>

                <div class="no-print" style="margin-bottom: 20px; padding: 15px; border: 1px solid var(--border-color); border-radius: 6px; background-color: #f9f9f9;">
                    <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 10px;">Tambah Log Baru</h3>
                    <form method="POST">
                        <textarea name="catatan" class="form-control" style="width: 100%; height: 80px; margin-bottom: 10px;" placeholder="Tuliskan progres / catatan bimbingan hari ini..." required></textarea>
                        <button type="submit" class="btn btn-primary" style="font-size: 13px;"><i class="fa-solid fa-paper-plane"></i> Kirim Log Bimbingan</button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="10%">Bimbingan Ke-</th>
                                <th width="20%">Tgl Bimbingan</th>
                                <th width="70%">Konten Bimbingan / Catatan Revisi Dosen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                            <tr>
                                <td colspan="3" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada log bimbingan.</td>
                            </tr>
                            <?php else: ?>
                            <?php $i=1; foreach($logs as $log): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d-M-Y', strtotime($log['tgl_bimbingan'])) ?></td>
                                <td>
                                    <div style="margin-bottom: 5px;"><strong>Catatan Mahasiswa:</strong><br><?= nl2br(htmlspecialchars($log['catatan'])) ?></div>
                                    <div style="padding: 10px; background-color: #f1f1f1; border-left: 3px solid var(--primary-blue); font-size: 12px; margin-top: 10px;">
                                        <strong>Catatan Revisi/Balasan Dosen:</strong><br>
                                        <?= nl2br(htmlspecialchars($log['catatan_dosen'] ?? 'Belum ada balasan dari dosen.')) ?>
                                    </div>
                                    <div style="margin-top: 5px;">
                                        <strong>Status:</strong> 
                                        <?php if($log['status_log'] == 'acc'): ?>
                                            <span style="color: var(--success-green); font-weight: 600;">Di-ACC</span>
                                        <?php elseif($log['status_log'] == 'revisi'): ?>
                                            <span style="color: #dc3545; font-weight: 600;">Revisi</span>
                                        <?php else: ?>
                                            <span style="color: #FFA94D; font-weight: 600;">Menunggu Review</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php endif; ?>
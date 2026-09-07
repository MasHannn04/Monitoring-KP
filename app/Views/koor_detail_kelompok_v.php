<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Validasi Kelompok KP (Riwayat Studi)</h1>
                <div class="breadcrumb">
                    <a href="<?= base_url('koor_approval_kelompok') ?>">Approval Kelompok</a> / <span style="color: var(--primary-blue);">Detail Validasi</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                <div class="card">
                    <h2 style="font-size: 15px; font-weight: 600; margin-bottom: 20px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Dokumen Riwayat Studi Anggota</h2>
                    
                    <div class="alert-warning">
                        <i class="fa-solid fa-triangle-exclamation" style="margin-top: 2px;"></i>
                        <div>Periksa dokumen riwayat studi tiap mahasiswa untuk memastikan mereka memenuhi syarat batas SKS untuk mengambil Kerja Praktek.</div>
                    </div>

                    <?php $i=1; foreach($members as $m): ?>
                    <div class="member-card">
                        <div class="member-header" style="justify-content: space-between; align-items: flex-start;">
                            <div>
                                <div style="font-weight: 600; font-size: 14px; margin-bottom: 6px;"><?= $i++ ?>. <?= htmlspecialchars($m['nama']) ?> (<?= htmlspecialchars($m['npm_nip']) ?>)</div>
                                <div style="font-size: 12px; color: var(--text-muted);">Status: <span style="color: var(--success-green);"><i class="fa-solid fa-check"></i> Mengajukan Validasi</span></div>
                            </div>
                            <div>
                                <?= $m['is_ketua'] ? '<span class="badge badge-primary">Ketua</span>' : '<span class="badge" style="background-color: #6c757d;">Anggota</span>' ?>
                            </div>
                        </div>
                        <div class="doc-box">
                            <div>
                                <div style="font-weight: 600; font-size: 13px;"><i class="fa-solid fa-file-pdf" style="color: #dc3545;"></i> Riwayat Studi (KHS/Transkrip)</div>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($m['file_riwayat_studi'] ?? '-') ?></div>
                            </div>
                            <?php if (!empty($m['file_riwayat_studi'])): ?>
                            <div style="display: flex; gap: 5px;">
                                <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($m['file_riwayat_studi']) ?>" target="_blank" class="btn btn-info" style="font-size: 12px; padding: 5px 10px; text-decoration: none; background-color: #17a2b8; color: white;"><i class="fa-solid fa-eye"></i> Lihat</a>
                                <a href="uploads/<?= urlencode($m['file_riwayat_studi']) ?>" download class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; text-decoration: none;"><i class="fa-solid fa-download"></i> Unduh</a>
                            </div>
                            <?php else: ?>
                            <span class="badge" style="background-color: #dc3545;">Belum Upload</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>

                <div>
                    <div class="action-box">
                        <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px;">Validasi Pengajuan Kelompok</h3>
                        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">Tolak kelompok jika ada anggota yang SKS-nya belum mencukupi standar Koordinator.</p>
                        
                        <form method="POST" action="<?= base_url('koor_detail_kelompok') ?>?id=<?= $id ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <div style="margin-bottom: 20px;">
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Alasan Penolakan (Hanya diisi jika menolak)</label>
                                <textarea name="koor_note" rows="4" style="width: 100%; font-size: 12px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" placeholder="Contoh: SKS anggota 2 belum memenuhi batas minimal..."></textarea>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <button type="submit" name="approve" value="1" class="btn btn-success" style="flex: 1; font-size: 13px;"><i class="fa-solid fa-check"></i> Setujui Kelompok</button>
                                <button type="submit" name="reject" value="1" class="btn btn-primary" style="flex: 1; font-size: 13px; background-color: #dc3545;"><i class="fa-solid fa-xmark"></i> Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
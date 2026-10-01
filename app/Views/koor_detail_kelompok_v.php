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
                                <div style="font-size: 12px; color: var(--text-muted);">
                                    Status: 
                                    <?php if ($m['status_anggota'] == 'menerima'): ?>
                                        <span style="color: var(--success-green);"><i class="fa-solid fa-check"></i> Aktif</span>
                                    <?php elseif ($m['status_anggota'] == 'dikeluarkan'): ?>
                                        <span style="color: #dc3545;"><i class="fa-solid fa-user-xmark"></i> Dikeluarkan</span>
                                    <?php else: ?>
                                        <span style="color: #FFA94D;"><?= ucfirst($m['status_anggota']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div style="display: flex; gap: 10px; align-items: center;">
                                <?= $m['is_ketua'] ? '<span class="badge badge-primary">Ketua</span>' : '<span class="badge" style="background-color: #6c757d;">Anggota</span>' ?>
                                
                                <?php if ($m['status_anggota'] == 'menerima' && $active_members_count > 1): ?>
                                <form method="POST" action="<?= base_url('koor_detail_kelompok') ?>?id=<?= $id ?>" onsubmit="return confirm('Yakin ingin mengeluarkan mahasiswa ini? Ia harus mendaftar kelompok baru dari awal jika dikeluarkan.');" style="margin:0;">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <input type="hidden" name="mhs_id" value="<?= $m['mhs_id'] ?>">
                                    <button type="submit" name="kick_member" value="1" class="btn btn-primary" style="font-size: 11px; padding: 4px 8px; background-color: #dc3545; border: none; border-radius: 4px;" title="Keluarkan dari kelompok"><i class="fa-solid fa-user-minus"></i> Kick</button>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="doc-box">
                            <div>
                                <div style="font-weight: 600; font-size: 13px;"><i class="fa-solid fa-file-pdf" style="color: #dc3545;"></i> Riwayat Studi</div>
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
                        
                        <?php if($kelompok['status_kelompok'] != 'disetujui' && $kelompok['status_kelompok'] != 'ditolak'): ?>
                        <form method="POST" action="<?= base_url('koor_detail_kelompok') ?>?id=<?= $id ?>">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <div style="margin-bottom: 20px;">
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Catatan Koordinator / Alasan Penolakan (Jika Ada)</label>
                                <textarea name="koor_note" rows="4" style="width: 100%; font-size: 12px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" placeholder="Isi catatan jika ada pesan khusus, atau alasan jika ditolak..."></textarea>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <button type="submit" name="approve" value="1" class="btn btn-success" style="flex: 1; font-size: 13px;"><i class="fa-solid fa-check"></i> Setujui Kelompok</button>
                                <button type="submit" formnovalidate name="reject" value="1" class="btn btn-primary" style="flex: 1; font-size: 13px; background-color: #dc3545;"><i class="fa-solid fa-xmark"></i> Tolak</button>
                            </div>
                        </form>
                        <?php else: ?>
                            <div style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; text-align: center; margin-top: 10px;">
                                <i class="fa-solid fa-circle-check"></i> Pengajuan kelompok ini telah <strong style="text-transform:uppercase;"><?= $kelompok['status_kelompok'] ?></strong>.
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($kelompok['status_kelompok'] == 'disetujui'): ?>
                    <div class="action-box" style="margin-top: 20px;">
                        <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px;"><i class="fa-solid fa-user-plus"></i> Tambah Anggota Susulan</h3>
                        <?php if($active_members_count >= 3): ?>
                            <div class="alert-info" style="margin-bottom: 0;">Kelompok sudah penuh (3 anggota).</div>
                        <?php elseif($jadwal_seminar_keluar): ?>
                            <div class="alert-warning" style="margin-bottom: 0;">Tidak dapat menambah anggota (Jadwal Sidang sudah keluar).</div>
                        <?php else: ?>
                            <form method="POST" action="<?= base_url('koor_detail_kelompok') ?>?id=<?= $id ?>">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <div style="margin-bottom: 15px;">
                                    <label class="form-label">Pilih Mahasiswa</label>
                                    <select name="mhs_id" class="form-control" required>
                                        <option value="">-- Pilih Mahasiswa Tanpa Kelompok --</option>
                                        <?php foreach($mhs_belum_kelompok as $m): ?>
                                            <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['npm_nip']) ?> - <?= htmlspecialchars($m['nama']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" name="add_member" value="1" class="btn btn-primary" style="font-size: 13px; width: 100%;"><i class="fa-solid fa-plus"></i> Tambahkan ke Kelompok</button>
                            </form>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </div>
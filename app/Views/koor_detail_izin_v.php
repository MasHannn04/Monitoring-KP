<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Detail Form Pengajuan Izin</h1>
                <div class="breadcrumb">
                    <a href="<?= base_url('koor_approval_izin') ?>">Approval Izin</a> / <span style="color: var(--primary-blue);">Detail Form</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                <div class="card">
                    <h2 style="font-size: 15px; font-weight: 600; margin-bottom: 20px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Data Instansi Tujuan</h2>
                    
                    <div class="detail-grid">
                        <div class="detail-label">Nama Perusahaan</div>
                        <div class="detail-value"><?= htmlspecialchars($instansi_data['nama_instansi']) ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Alamat Perusahaan</div>
                        <div class="detail-value"><?= htmlspecialchars($instansi_data['alamat']) ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Kota</div>
                        <div class="detail-value"><?= htmlspecialchars($instansi_data['kota']) ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Ditujukan Kepada</div>
                        <div class="detail-value"><?= htmlspecialchars($instansi_data['ditujukan_kepada']) ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Bidang KP</div>
                        <div class="detail-value"><?= htmlspecialchars($instansi_data['bidang_kp']) ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Lama Pelaksanaan KP</div>
                        <div class="detail-value"><?= htmlspecialchars($instansi_data['lama_kp']) ?></div>
                    </div>

                    <h2 style="font-size: 15px; font-weight: 600; margin-bottom: 20px; margin-top: 30px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Data Anggota Kelompok</h2>
                    
                    <?php 
                    $counter = 1;
                    foreach($anggota_list as $a): 
                    ?>
                    <div class="contact-box" style="display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 600; font-size: 13px; margin-bottom: 5px;"><?= $counter++ ?>. <?= htmlspecialchars($a['nama']) ?> (<?= htmlspecialchars($a['npm_nip']) ?>)</div>
                            <div style="font-size: 12px; color: var(--text-muted);"><i class="fa-solid fa-phone"></i> <?= htmlspecialchars($a['no_wa'] ?? '-') ?> <span style="margin: 0 5px;">|</span> <i class="fa-solid fa-envelope"></i> <?= htmlspecialchars($a['email'] ?? '-') ?></div>
                        </div>
                        <div>
                            <?php if($a['is_ketua']): ?>
                                <span class="badge badge-primary">Ketua</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Anggota</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div>

                <div>
                    <div class="action-box">
                        <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px;">Validasi Pengajuan</h3>
                        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">Jika data sudah benar, silakan buat Surat Izin KP secara manual dan unggah versi digitalnya (PDF) ke sistem untuk diteruskan ke mahasiswa.</p>
                        
                        <form method="POST" action="<?= base_url('koor_detail_izin') ?>?id=<?= $instansi_id ?>" enctype="multipart/form-data">
                            <input type="hidden" name="instansi_id" value="<?= $instansi_id ?>">
                            
                            <div style="margin-bottom: 15px;">
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Upload Surat Izin Digital (PDF) (Jika Disetujui)</label>
                                <input type="file" name="surat_izin" style="width: 100%; font-size: 12px; padding: 5px; border: 1px solid var(--border-color); border-radius: 4px;" accept="application/pdf">
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Alasan Penolakan (Hanya diisi jika menolak)</label>
                                <textarea name="izin_note" rows="3" style="width: 100%; font-size: 12px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" placeholder="Isi alasan menolak..."></textarea>
                            </div>

                            <div style="display: flex; gap: 10px;">
                                <button type="submit" name="action" value="approve" class="btn btn-success" style="flex: 1; font-size: 13px;"><i class="fa-solid fa-check"></i> Setujui</button>
                                <button type="submit" name="action" value="reject" class="btn btn-primary" style="flex: 1; font-size: 13px; background-color: #dc3545;"><i class="fa-solid fa-xmark"></i> Tolak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Detail Form Pengajuan Bimbingan</h1>
                <div class="breadcrumb">
                    <a href="<?= base_url('koor_approval_bimbingan') ?>">Approval Bimbingan</a> / <span style="color: var(--primary-blue);">Detail Form</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                <div class="card">
                    <h2 style="font-size: 15px; font-weight: 600; margin-bottom: 20px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Data Pengajuan Bimbingan & Surat Balasan</h2>
                    
                    <?php
                    $ketua_nama = '';
                    $ketua_npm = '';
                    foreach($anggota_list as $a) {
                        if($a['is_ketua']) {
                            $ketua_nama = $a['nama'];
                            $ketua_npm = $a['npm_nip'];
                            break;
                        }
                    }
                    ?>
                    <div class="detail-grid">
                        <div class="detail-label">Ketua Kelompok</div>
                        <div class="detail-value"><?= htmlspecialchars($ketua_nama) ?> (<?= htmlspecialchars($ketua_npm) ?>)</div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Instansi Tujuan</div>
                        <div class="detail-value"><?= htmlspecialchars($instansi_data['nama_instansi'] ?? '-') ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Nomor Surat Balasan</div>
                        <div class="detail-value"><?= htmlspecialchars($bimbingan_data['no_surat_balasan'] ?? '-') ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Tgl Surat Balasan</div>
                        <div class="detail-value"><?= date('d F Y', strtotime($bimbingan_data['tgl_surat_balasan'] ?? 'now')) ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Pelaksanaan KP</div>
                        <div class="detail-value"><?= date('d F Y', strtotime($bimbingan_data['tgl_mulai_kp'] ?? 'now')) ?> s/d <?= date('d F Y', strtotime($bimbingan_data['tgl_selesai_kp'] ?? 'now')) ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Usulan Judul Sementara</div>
                        <div class="detail-value">-</div>
                    </div>

                    <h2 style="font-size: 15px; font-weight: 600; margin-bottom: 20px; margin-top: 30px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Dokumen Pendukung Mahasiswa</h2>
                    
                    <div class="doc-box">
                        <div>
                            <div style="font-weight: 600; font-size: 13px;"><i class="fa-solid fa-file-pdf" style="color: #dc3545;"></i> Surat Balasan Perusahaan (Bukti Diterima)</div>
                            <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($bimbingan_data['file_surat_balasan'] ?? '-') ?></div>
                        </div>
                        <?php if(!empty($bimbingan_data['file_surat_balasan'])): ?>
                        <div>
                            <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($bimbingan_data['file_surat_balasan']) ?>" target="_blank" class="btn btn-info" style="font-size: 12px; padding: 5px 10px; text-decoration: none; background-color: #17a2b8; color: white;"><i class="fa-solid fa-eye"></i> Lihat</a>
                            <a href="uploads/<?= urlencode($bimbingan_data['file_surat_balasan']) ?>" download class="btn btn-success" style="font-size: 12px; padding: 5px 10px; text-decoration: none;"><i class="fa-solid fa-download"></i> Unduh</a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="doc-box">
                        <div>
                            <div style="font-weight: 600; font-size: 13px;"><i class="fa-solid fa-file-image" style="color: var(--success-green);"></i> Slip Pembayaran Bimbingan KP</div>
                            <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($bimbingan_data['file_slip_bimbingan'] ?? '-') ?></div>
                        </div>
                        <?php if(!empty($bimbingan_data['file_slip_bimbingan'])): ?>
                        <div>
                            <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($bimbingan_data['file_slip_bimbingan']) ?>" target="_blank" class="btn btn-info" style="font-size: 12px; padding: 5px 10px; text-decoration: none; background-color: #17a2b8; color: white;"><i class="fa-solid fa-eye"></i> Lihat</a>
                            <a href="uploads/<?= urlencode($bimbingan_data['file_slip_bimbingan']) ?>" download class="btn btn-success" style="font-size: 12px; padding: 5px 10px; text-decoration: none;"><i class="fa-solid fa-download"></i> Unduh</a>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>

                <div>
                    <div class="action-box">
                        <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px;">Validasi & Plot Dosen</h3>
                        <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 20px;">Tentukan dosen pembimbing dan unggah Surat Tugas beserta berkas pendukung KP untuk diserahkan ke mahasiswa.</p>
                        
                        <form method="POST" action="<?= base_url('koor_detail_bimbingan') ?>?id=<?= $bimbingan_id ?>" enctype="multipart/form-data">
                            <input type="hidden" name="bimbingan_id" value="<?= $bimbingan_id ?>">
                            <div style="margin-bottom: 15px;">
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Pilih Dosen Pembimbing</label>
                                <select name="dospem_id" style="width: 100%; font-size: 12px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;">
                                    <option value="">-- Pilih Dosen --</option>
                                    <?php foreach($dosen_list as $d): ?>
                                        <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nama']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div style="margin-bottom: 15px;">
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Upload Surat Tugas Bimbingan (PDF) (Jika disetujui)</label>
                                <input type="file" name="surat_tugas" style="width: 100%; font-size: 12px; padding: 5px; border: 1px solid var(--border-color); border-radius: 4px;" accept="application/pdf">
                            </div>

                            <div style="margin-bottom: 20px;">
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Alasan Penolakan (Hanya diisi jika menolak)</label>
                                <textarea name="bimbingan_note" rows="3" style="width: 100%; font-size: 12px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" placeholder="Isi alasan menolak..."></textarea>
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
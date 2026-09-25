<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Proses & Atur Jadwal Seminar</h1>
                <div class="breadcrumb">
                    <a href="<?= base_url('koor_approval_seminar') ?>">Approval Seminar</a> / <span style="color: var(--primary-blue);">Atur Jadwal</span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
                <div class="card">
                    <h2 style="font-size: 15px; font-weight: 600; margin-bottom: 20px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Data Pendaftaran Seminar</h2>
                    
                    <div class="detail-grid">
                        <div class="detail-label">Ketua Kelompok</div>
                        <div class="detail-value"><?= htmlspecialchars($seminar_data['ketua'] ?? '-') ?> (<?= htmlspecialchars($seminar_data['npm_nip'] ?? '-') ?>)</div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Judul Laporan</div>
                        <div class="detail-value"><?= htmlspecialchars($seminar_data['judul_laporan'] ?? 'Belum ada judul') ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Pelaksanaan KP</div>
                        <div class="detail-value"><?= htmlspecialchars($seminar_data['tgl_mulai_kp'] ?? '-') ?> s/d <?= htmlspecialchars($seminar_data['tgl_selesai_kp'] ?? '-') ?></div>
                    </div>
                    <div class="detail-grid">
                        <div class="detail-label">Dosen Pembimbing</div>
                        <div class="detail-value"><?= htmlspecialchars($seminar_data['nama_dospem'] ?? '-') ?></div>
                    </div>

                    <h2 style="font-size: 15px; font-weight: 600; margin-bottom: 20px; margin-top: 30px; color: var(--primary-blue); border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Dokumen Pendaftaran Mahasiswa</h2>
                    
                    <div class="doc-box">
                        <div>
                            <div style="font-weight: 600; font-size: 13px;"><i class="fa-solid fa-file-pdf" style="color: #dc3545;"></i> Draft Laporan KP Final</div>
                            <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($seminar_data['file_draft_laporan'] ?? '-') ?></div>
                        </div>
                        <?php if(!empty($seminar_data['file_draft_laporan'])): ?>
                        <div>
                            <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($seminar_data['file_draft_laporan']) ?>" target="_blank" class="btn btn-info" style="font-size: 12px; padding: 5px 10px; text-decoration: none; background-color: #17a2b8; color: white;"><i class="fa-solid fa-eye"></i> Lihat</a>
                            <a href="uploads/<?= urlencode($seminar_data['file_draft_laporan']) ?>" download class="btn btn-success" style="font-size: 12px; padding: 5px 10px; text-decoration: none;"><i class="fa-solid fa-download"></i> Unduh</a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="doc-box">
                        <div>
                            <div style="font-weight: 600; font-size: 13px;"><i class="fa-solid fa-receipt" style="color: var(--success-green);"></i> Slip Pembayaran Seminar</div>
                            <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($seminar_data['file_slip_seminar'] ?? '-') ?></div>
                        </div>
                        <?php if(!empty($seminar_data['file_slip_seminar'])): ?>
                        <div>
                            <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($seminar_data['file_slip_seminar']) ?>" target="_blank" class="btn btn-info" style="font-size: 12px; padding: 5px 10px; text-decoration: none; background-color: #17a2b8; color: white;"><i class="fa-solid fa-eye"></i> Lihat</a>
                            <a href="uploads/<?= urlencode($seminar_data['file_slip_seminar']) ?>" download class="btn btn-success" style="font-size: 12px; padding: 5px 10px; text-decoration: none;"><i class="fa-solid fa-download"></i> Unduh</a>
                        </div>
                        <?php endif; ?>
                    </div>

                </div>

                <div>
                    <?php if($seminar_data['status_koor'] != 'dijadwalkan' && $seminar_data['status_koor'] != 'acc' && $seminar_data['status_koor'] != 'tolak'): ?>
                    <form method="POST" class="action-box">
                        <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px;">Tentukan Jadwal & Penguji (Terima)</h3>
                        
                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Dosen Pembimbing</label>
                            <input type="hidden" name="penguji1_id" value="<?= $seminar_data['dospem_id'] ?>">
                            <div style="width: 100%; font-size: 12px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px; background-color: #e9ecef; cursor: not-allowed; color: var(--text-dark);">
                                <?= htmlspecialchars($seminar_data['nama_dospem']) ?>
                            </div>
                        </div>

                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Pilih Dosen Penguji</label>
                            <select name="penguji2_id" style="width: 100%; font-size: 12px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" required>
                                <option value="">-- Pilih Penguji --</option>
                                <?php foreach($dosen_list as $d): ?>
                                <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div style="margin-bottom: 15px; display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div>
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Tanggal Seminar</label>
                                <input type="date" name="tgl_seminar" style="width: 100%; font-size: 12px; padding: 6px; border: 1px solid var(--border-color); border-radius: 4px;" required>
                            </div>
                            <div>
                                <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Jam</label>
                                <input type="time" name="jam_seminar" style="width: 100%; font-size: 12px; padding: 6px; border: 1px solid var(--border-color); border-radius: 4px;" required>
                            </div>
                        </div>
                        
                        <div style="margin-bottom: 20px;">
                            <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Ruangan / Link Meet</label>
                            <input type="text" name="ruangan" style="width: 100%; font-size: 12px; padding: 6px; border: 1px solid var(--border-color); border-radius: 4px;" placeholder="Contoh: Ruang A-202" required>
                        </div>

                        <button type="submit" name="terbitkan" class="btn btn-success" style="width: 100%; font-size: 13px;"><i class="fa-solid fa-paper-plane"></i> Terbitkan Jadwal</button>
                    </form>

                    <form method="POST" class="action-box" style="margin-top: 20px;">
                        <h3 style="font-size: 15px; font-weight: 600; margin-bottom: 15px; color: #dc3545;">Tolak Pendaftaran</h3>
                        <div style="margin-bottom: 20px;">
                            <label style="font-size: 12px; font-weight: 600; display: block; margin-bottom: 5px;">Alasan Penolakan</label>
                            <textarea name="catatan_tolak" rows="3" style="width: 100%; font-size: 12px; padding: 8px; border: 1px solid var(--border-color); border-radius: 4px;" placeholder="Isi alasan dokumen dikembalikan..." required></textarea>
                        </div>
                        <button type="submit" name="tolak" class="btn btn-primary" style="width: 100%; font-size: 13px; background-color: #dc3545;"><i class="fa-solid fa-xmark"></i> Tolak Pendaftaran</button>
                    </form>
                    <?php else: ?>
                        <div style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px; text-align: center; margin-top: 10px;">
                            <i class="fa-solid fa-circle-check"></i> Pendaftaran seminar ini telah <strong style="text-transform:uppercase;"><?= $seminar_data['status_koor'] ?></strong>.
                        </div>
                        <?php if($seminar_data['status_koor'] == 'dijadwalkan' || $seminar_data['status_koor'] == 'acc'): ?>
                            <div style="margin-top: 20px; font-size: 13px; line-height: 1.6; padding: 15px; border: 1px solid var(--border-color); border-radius: 4px; background: #fff;">
                                <strong>Jadwal Seminar:</strong><br>
                                Tanggal: <?= date('d F Y', strtotime($seminar_data['tgl_seminar'])) ?><br>
                                Jam: <?= date('H:i', strtotime($seminar_data['jam_seminar'])) ?><br>
                                Ruangan: <?= htmlspecialchars($seminar_data['ruangan']) ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
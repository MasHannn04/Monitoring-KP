<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Validasi Pendaftaran Seminar</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Validasi Seminar</span>
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pendaftaran Seminar Bimbingan Anda</h2>
                
                <div class="alert-info">
                    <i class="fa-solid fa-circle-info" style="margin-top: 2px;"></i>
                    <div>Validasi persyaratan seminar mahasiswa bimbingan Anda sebelum diteruskan ke Koordinator untuk dijadwalkan sidangnya.</div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mahasiswa / Kelompok</th>
                                <th>Judul Laporan</th>
                                <th>Dokumen Syarat</th>
                                <th>Aksi (Validasi Dosen)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($seminar_list)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada pendaftaran seminar yang menunggu validasi.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($seminar_list as $s): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($s['ketua']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($s['npm_nip']) ?></div>
                                </td>
                                <td><div style="font-size: 12px;">Menunggu Judul Laporan Final</div></td>
                                <td>
                                <div style="display: flex; flex-direction: column; gap: 5px;">
                                    <?php if(!empty($s['file_draft_laporan'])): ?>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px;">
                                        <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($s['file_draft_laporan']) ?>" target="_blank" class="btn btn-primary" style="font-size: 11px; padding: 5px 10px; display: flex; justify-content: center; align-items: center; gap: 5px; white-space: nowrap;"><i class="fa-solid fa-eye"></i> Laporan</a>
                                        <a href="uploads/<?= urlencode($s['file_draft_laporan']) ?>" download class="btn btn-success" style="font-size: 11px; padding: 5px 10px; display: flex; justify-content: center; align-items: center; gap: 5px; white-space: nowrap;"><i class="fa-solid fa-download"></i> Unduh</a>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if(!empty($s['file_slip_seminar'])): ?>
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 5px;">
                                        <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($s['file_slip_seminar']) ?>" target="_blank" class="btn btn-primary" style="font-size: 11px; padding: 5px 10px; background-color: #FFA94D; border: none; color: #fff; display: flex; justify-content: center; align-items: center; gap: 5px; white-space: nowrap;"><i class="fa-solid fa-eye"></i> Slip</a>
                                        <a href="uploads/<?= urlencode($s['file_slip_seminar']) ?>" download class="btn btn-success" style="font-size: 11px; padding: 5px 10px; background-color: #28a745; border: none; color: #fff; display: flex; justify-content: center; align-items: center; gap: 5px; white-space: nowrap;"><i class="fa-solid fa-download"></i> Unduh</a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                </td>
                                <td style="vertical-align: middle;">
                                    <form method="POST" style="display: flex; gap: 8px; align-items: stretch;">
                                        <input type="hidden" name="seminar_id" value="<?= $s['id'] ?>">
                                        <div style="display: flex; flex-direction: column; gap: 5px; flex: 1;">
                                            <button type="submit" name="approve" class="btn btn-success" style="font-size: 11px; padding: 5px 10px; width: 100%; flex: 1;"><i class="fa-solid fa-check"></i> Setujui & Teruskan</button>
                                            <button type="submit" name="reject" class="btn btn-primary" style="font-size: 11px; padding: 5px 10px; width: 100%; background-color: #dc3545; flex: 1;"><i class="fa-solid fa-xmark"></i> Tolak</button>
                                        </div>
                                        <div style="flex: 1.5;">
                                            <textarea name="catatan_tolak" class="form-control" style="width: 100%; height: 100%; min-height: 55px; font-size: 11px; resize: none; padding: 8px;" placeholder="Alasan penolakan (jika ditolak)..."></textarea>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
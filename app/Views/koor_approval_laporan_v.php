<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Validasi Pengumpulan Laporan Akhir</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Approval Laporan</span>
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pengumpulan Laporan (Menunggu Validasi)</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Kumpul</th>
                                <th>Ketua Kelompok</th>
                                <th>Status Dosen Pembimbing</th>
                                <th>Dokumen Lengkap</th>
                                <th>Aksi (Validasi Akhir)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($laporan_list)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada laporan yang menunggu validasi kelulusan.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($laporan_list as $l): ?>
                            <tr>
                                <td><?= isset($l['tgl_pengumpulan']) && $l['tgl_pengumpulan'] ? date('d-M-Y', strtotime($l['tgl_pengumpulan'])) : '-' ?></td>
                                <td>
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($l['ketua']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($l['npm_nip']) ?></div>
                                </td>
                                <td><span class="badge badge-success"><i class="fa-solid fa-check-double"></i> Approved (ACC)</span></td>
                                <td>
                                    <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($l['file_laporan_final']) ?>" target="_blank" class="btn btn-primary" style="font-size: 11px; padding: 3px 8px; margin-bottom: 3px; width: 100%; text-align: left; text-decoration:none;"><i class="fa-solid fa-file-pdf"></i> Laporan KP Final</a>
                                    <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($l['file_surat_tugas']) ?>" target="_blank" class="btn btn-primary" style="font-size: 11px; padding: 3px 8px; margin-bottom: 3px; width: 100%; text-align: left; text-decoration:none;"><i class="fa-solid fa-file-signature"></i> Surat Tugas</a>
                                    <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($l['file_nilai_perusahaan']) ?>" target="_blank" class="btn btn-primary" style="font-size: 11px; padding: 3px 8px; width: 100%; text-align: left; background-color: #FFA94D; text-decoration:none;"><i class="fa-solid fa-star"></i> Nilai Perusahaan</a>
                                </td>
                                <td style="vertical-align: middle;">
                                    <form method="POST" style="display:flex; flex-direction:column; gap:5px;">
                                        <input type="hidden" name="laporan_id" value="<?= $l['id'] ?>">

                                        <button type="submit" name="approve" class="btn btn-success" style="font-size: 12px; padding: 6px 12px; width: 100%;"><i class="fa-solid fa-check-circle"></i> Validasi Kelulusan</button>
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
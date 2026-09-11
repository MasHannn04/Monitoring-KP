<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Approval Laporan Akhir KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / Dashboard / <span style="color: var(--primary-blue);">Pengumpulan Laporan</span>
                </div>
            </div>

            <div class="card">
                <div class="table-header">
                    <h2 style="font-size: 16px; font-weight: 600;">Daftar Pengumpulan Laporan Mahasiswa Bimbingan</h2>
                </div>

                <div class="table-controls" style="justify-content: space-between; margin-bottom: 15px;">
                    <div>Tampilkan <select style="margin: 0 5px;"><option>10</option></select> data</div>
                    <div>Cari: <input type="text"></div>
                </div>

                <div class="table-responsive">
                    <table class="table" style="font-size: 12px; width: 100%;">
                        <thead>
                            <tr>
                                <th>No <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                                <th>NPM <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                                <th>Nama Mahasiswa <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                                <th>File Laporan <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                                <th>Status <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                                <th>Aksi Persetujuan <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($laporan_list)): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada laporan.</td>
                            </tr>
                            <?php else: ?>
                            <?php $i=1; foreach($laporan_list as $l): ?>
                            <tr>
                                <td style="white-space: nowrap;"><?= $i++ ?></td>
                                <td style="white-space: nowrap;"><?= htmlspecialchars($l['npm_nip']) ?></td>
                                <td style="white-space: normal; word-wrap: break-word;"><?= htmlspecialchars($l['ketua']) ?></td>
                                <td style="white-space: nowrap; line-height: 1.8;">
                                    <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($l['file_laporan_final']) ?>" target="_blank" style="color: var(--primary-blue); text-decoration: none;"><i class="fa-solid fa-file-pdf" style="width: 15px;"></i> Draft Laporan Akhir</a><br>
                                    <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($l['file_surat_tugas']) ?>" target="_blank" style="color: var(--primary-blue); text-decoration: none;"><i class="fa-solid fa-file-pdf" style="width: 15px;"></i> Surat Tugas</a><br>
                                    <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($l['file_nilai_perusahaan']) ?>" target="_blank" style="color: var(--primary-blue); text-decoration: none;"><i class="fa-solid fa-file-pdf" style="width: 15px;"></i> Nilai Perusahaan</a>
                                </td>
                                <td style="white-space: nowrap;">
                                    <?php if($l['status_dospem'] == 'acc'): ?>
                                        <span class="badge badge-success"><i class="fa-solid fa-check-double"></i> Disetujui Dosen</span>
                                    <?php elseif($l['status_dospem'] == 'tolak'): ?>
                                        <span class="badge" style="background-color: #dc3545;">Ditolak / Revisi</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #FFA94D;">Menunggu Persetujuan</span>
                                    <?php endif; ?>
                                </td>
                                <td style="min-width: 140px;">
                                    <?php if($l['status_dospem'] == 'menunggu'): ?>
                                    <form method="POST" style="display:flex; flex-direction:column; gap:8px;">
                                        <input type="hidden" name="laporan_id" value="<?= $l['id'] ?>">
                                        <input type="text" name="catatan" class="form-control" placeholder="Catatan opsional..." style="font-size:11px; padding:4px;">
                                        <input type="number" name="nilai_perusahaan" class="form-control" placeholder="Nilai Perusahaan (0-100)" min="0" max="100" step="0.01" style="font-size:11px; padding:4px;" required>
                                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:5px;">
                                            <button type="submit" name="approve" class="btn btn-success" style="width: 100%; border-radius: 4px; padding: 6px; font-size: 12px; display: flex; align-items: center; justify-content: center; gap: 4px; border: none; height: 32px; font-weight: 600;" title="Setujui"><i class="fa-solid fa-check"></i> Terima</button>
                                            <button type="submit" name="reject" class="btn btn-primary" style="background-color: #dc3545; color: white; width: 100%; border-radius: 4px; padding: 6px; font-size: 12px; display: flex; align-items: center; justify-content: center; gap: 4px; border: none; height: 32px; font-weight: 600;" title="Tolak / Revisi" formnovalidate><i class="fa-solid fa-xmark"></i> Tolak</button>
                                        </div>
                                    </form>
                                    <?php else: ?>
                                        <button class="btn btn-primary" style="background-color: #6c757d; font-size: 11px;" disabled>Selesai</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="pagination-wrapper">
                    <div>Menampilkan 1 sampai 2 dari 2 data</div>
                    <div class="page-controls">
                        <button disabled>Sebelumnya</button>
                        <button class="active">1</button>
                        <button disabled>Selanjutnya</button>
                    </div>
                </div>
            </div>
        </div>
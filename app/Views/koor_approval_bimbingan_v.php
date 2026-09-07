<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Approval Pengajuan Bimbingan</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Approval Bimbingan</span>
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pengajuan Bimbingan & Plot Dosen</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tgl Pengajuan</th>
                                <th>Ketua Kelompok</th>
                                <th>Instansi / Tgl Pelaksanaan KP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bimbingan_list)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada pengajuan bimbingan yang menunggu validasi.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($bimbingan_list as $b): ?>
                            <tr>
                                <td><?= date('d-M-Y', strtotime($b['created_at'] ?? 'now')) ?></td>
                                <td>
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($b['ketua']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Kelompok <?= $b['jumlah_anggota'] ?> Anggota</div>
                                </td>
                                <td>
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($b['nama_instansi'] ?? 'Belum ada data') ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);">
                                        <?= date('d M', strtotime($b['tgl_mulai_kp'] ?? 'now')) ?> - <?= date('d M Y', strtotime($b['tgl_selesai_kp'] ?? 'now')) ?>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= base_url('koor_detail_bimbingan') ?>?id=<?= $b['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block; margin-right: 5px;"><i class="fa-solid fa-eye"></i> Detail & Proses Form</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
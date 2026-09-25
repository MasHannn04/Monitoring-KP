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
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $has_menunggu = false;
                            foreach($bimbingan_list as $b) {
                                if($b['status_bimbingan'] != 'disetujui' && $b['status_bimbingan'] != 'ditolak') {
                                    $has_menunggu = true;
                                    break;
                                }
                            }
                            if (!$has_menunggu): 
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada pengajuan bimbingan yang menunggu validasi.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($bimbingan_list as $b): if($b['status_bimbingan'] != 'disetujui' && $b['status_bimbingan'] != 'ditolak'): ?>
                            <tr>
                                <td><?= date('d-M-Y', strtotime($b['created_at'] ?? 'now')) ?></td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($b['ketua']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Kelompok <?= $b['jumlah_anggota'] ?> Anggota</div>
                                </td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 250px;">
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($b['nama_instansi'] ?? 'Belum ada data') ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);">
                                        <?= date('d M', strtotime($b['tgl_mulai_kp'] ?? 'now')) ?> - <?= date('d M Y', strtotime($b['tgl_selesai_kp'] ?? 'now')) ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if($b['status_bimbingan'] == 'disetujui'): ?>
                                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #FFA94D;"><i class="fa-solid fa-clock"></i> Menunggu Validasi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('koor_detail_bimbingan') ?>?id=<?= $b['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block; margin-right: 5px;"><i class="fa-solid fa-eye"></i> Detail & Proses Form</a>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" style="margin-top: 30px;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Riwayat Pengajuan Bimbingan (Disetujui)</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tgl Pengajuan</th>
                                <th>Ketua Kelompok</th>
                                <th>Instansi / Tgl Pelaksanaan KP</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $has_acc = false;
                            foreach($bimbingan_list as $b) {
                                if($b['status_bimbingan'] == 'disetujui') {
                                    $has_acc = true;
                                    break;
                                }
                            }
                            if (!$has_acc): 
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada pengajuan bimbingan yang disetujui.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($bimbingan_list as $b): if($b['status_bimbingan'] == 'disetujui'): ?>
                            <tr>
                                <td><?= date('d-M-Y', strtotime($b['created_at'] ?? 'now')) ?></td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($b['ketua']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);">Kelompok <?= $b['jumlah_anggota'] ?> Anggota</div>
                                </td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 250px;">
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($b['nama_instansi'] ?? 'Belum ada data') ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);">
                                        <?= date('d M', strtotime($b['tgl_mulai_kp'] ?? 'now')) ?> - <?= date('d M Y', strtotime($b['tgl_selesai_kp'] ?? 'now')) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-success"><i class="fa-solid fa-check"></i> Disetujui</span>
                                </td>
                                <td>
                                    <a href="<?= base_url('koor_detail_bimbingan') ?>?id=<?= $b['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block; margin-right: 5px;"><i class="fa-solid fa-eye"></i> Detail & Proses Form</a>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
        </div>
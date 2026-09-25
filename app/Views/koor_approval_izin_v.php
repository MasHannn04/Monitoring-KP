<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Approval Pengajuan Izin KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Approval Izin</span>
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pengajuan Izin</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tgl Pengajuan</th>
                                <th>Ketua Kelompok</th>
                                <th>Instansi Tujuan</th>
                                <th>Kota</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $has_menunggu = false;
                            foreach($menunggu_izin as $izin) {
                                if($izin['status_izin'] != 'disetujui' && $izin['status_izin'] != 'ditolak') {
                                    $has_menunggu = true;
                                    break;
                                }
                            }
                            if ($has_menunggu): 
                            ?>
                                <?php foreach($menunggu_izin as $izin): if($izin['status_izin'] != 'disetujui' && $izin['status_izin'] != 'ditolak'): ?>
                                <tr>
                                    <td><?= date('d-M-Y', strtotime($izin['created_at'])) ?></td>
                                    <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                        <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($izin['ketua_nama']) ?></div>
                                        <div style="font-size: 11px; color: var(--text-muted);"><?= $izin['jumlah_anggota'] ?> Anggota</div>
                                    </td>
                                    <td style="white-space: normal; word-wrap: break-word; max-width: 250px;"><?= htmlspecialchars($izin['nama_instansi']) ?></td>
                                    <td><?= htmlspecialchars($izin['kota']) ?></td>
                                    <td>
                                        <?php if($izin['status_izin'] == 'disetujui'): ?>
                                            <span class="badge badge-success"><i class="fa-solid fa-check"></i> Disetujui</span>
                                        <?php else: ?>
                                            <span class="badge" style="background-color: #FFA94D;"><i class="fa-solid fa-clock"></i> Menunggu Validasi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('koor_detail_izin') ?>?id=<?= $izin['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 15px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;"><i class="fa-solid fa-list-check"></i> Proses Validasi</a>
                                    </td>
                                </tr>
                                <?php endif; endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada pengajuan izin KP yang menunggu validasi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" style="margin-top: 30px;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Riwayat Pengajuan Izin (Disetujui)</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tgl Pengajuan</th>
                                <th>Ketua Kelompok</th>
                                <th>Instansi Tujuan</th>
                                <th>Kota</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $has_acc = false;
                            foreach($menunggu_izin as $izin) {
                                if($izin['status_izin'] == 'disetujui') {
                                    $has_acc = true;
                                    break;
                                }
                            }
                            if ($has_acc): 
                            ?>
                                <?php foreach($menunggu_izin as $izin): if($izin['status_izin'] == 'disetujui'): ?>
                                <tr>
                                    <td><?= date('d-M-Y', strtotime($izin['created_at'])) ?></td>
                                    <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                        <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($izin['ketua_nama']) ?></div>
                                        <div style="font-size: 11px; color: var(--text-muted);"><?= $izin['jumlah_anggota'] ?> Anggota</div>
                                    </td>
                                    <td style="white-space: normal; word-wrap: break-word; max-width: 250px;"><?= htmlspecialchars($izin['nama_instansi']) ?></td>
                                    <td><?= htmlspecialchars($izin['kota']) ?></td>
                                    <td>
                                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Disetujui</span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('koor_detail_izin') ?>?id=<?= $izin['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 15px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; background-color: #6c757d;"><i class="fa-solid fa-eye"></i> Detail Validasi</a>
                                    </td>
                                </tr>
                                <?php endif; endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada pengajuan izin yang disetujui.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
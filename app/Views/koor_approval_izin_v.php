<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Approval Pengajuan Izin KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Approval Izin</span>
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pengajuan Izin Menunggu Validasi</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tgl Pengajuan</th>
                                <th>Ketua Kelompok</th>
                                <th>Instansi Tujuan</th>
                                <th>Kota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($menunggu_izin) > 0): ?>
                                <?php foreach($menunggu_izin as $izin): ?>
                                <tr>
                                    <td><?= date('d-M-Y', strtotime($izin['created_at'])) ?></td>
                                    <td>
                                        <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($izin['ketua_nama']) ?></div>
                                        <div style="font-size: 11px; color: var(--text-muted);"><?= $izin['jumlah_anggota'] ?> Anggota</div>
                                    </td>
                                    <td><?= htmlspecialchars($izin['nama_instansi']) ?></td>
                                    <td><?= htmlspecialchars($izin['kota']) ?></td>
                                    <td>
                                        <a href="<?= base_url('koor_detail_izin') ?>?id=<?= $izin['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 6px 15px; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;"><i class="fa-solid fa-list-check"></i> Proses Validasi</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada pengajuan izin KP yang menunggu validasi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
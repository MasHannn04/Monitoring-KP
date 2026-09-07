<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Approval Kelompok KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Approval Kelompok</span>
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pengajuan Kelompok Baru</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Anggota Kelompok</th>
                                <th>Status Konfirmasi Anggota</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($kelompok_list)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada pengajuan kelompok yang menunggu validasi.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($kelompok_list as $k): ?>
                            <tr>
                                <td><?= date('d-M-Y', strtotime($k['created_at'])) ?></td>
                                <td>
                                    <?php $i = 1; foreach($k['members'] as $m): ?>
                                    <div style="<?= $m['is_ketua'] ? 'font-weight: 600; margin-bottom: 3px;' : 'font-size: 12px; color: var(--text-muted);' ?>">
                                        <?= $i++ ?>. <?= htmlspecialchars($m['nama']) ?> <?= $m['is_ketua'] ? '(Ketua)' : '(Anggota)' ?>
                                    </div>
                                    <?php endforeach; ?>
                                </td>
                                <td>
                                    <?php if($k['semua_menerima']): ?>
                                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Lengkap (Disetujui Anggota)</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #FFA94D;"><i class="fa-solid fa-clock"></i> Menunggu Konfirmasi Anggota</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('koor_detail_kelompok') ?>?id=<?= $k['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block;"><i class="fa-solid fa-eye"></i> Detail Validasi</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
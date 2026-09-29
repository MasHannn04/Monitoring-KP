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
                    <table class="table datatable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Anggota Kelompok</th>
                                <th>Status Konfirmasi Anggota</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($kelompok_list as $k): if ($k['status_kelompok'] != 'disetujui' && $k['status_kelompok'] != 'ditolak'): ?>
                            <tr>
                                <td><?= date('d-M-Y', strtotime($k['created_at'])) ?></td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 250px;">
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
                                    <?php if($k['status_kelompok'] == 'disetujui'): ?>
                                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #FFA94D;"><i class="fa-solid fa-clock"></i> Menunggu Validasi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('koor_detail_kelompok') ?>?id=<?= $k['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block;"><i class="fa-solid fa-eye"></i> Detail Validasi</a>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" style="margin-top: 30px;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Riwayat Kelompok (Disetujui)</h2>
                <div class="table-responsive">
                    <table class="table datatable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Tanggal Pengajuan</th>
                                <th>Anggota Kelompok</th>
                                <th>Status Konfirmasi Anggota</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($kelompok_list as $k): if ($k['status_kelompok'] == 'disetujui'): ?>
                            <tr>
                                <td><?= date('d-M-Y', strtotime($k['created_at'])) ?></td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 250px;">
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
                                    <?php if($k['status_kelompok'] == 'disetujui'): ?>
                                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Disetujui</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #FFA94D;"><i class="fa-solid fa-clock"></i> Menunggu Validasi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('koor_detail_kelompok') ?>?id=<?= $k['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block;"><i class="fa-solid fa-eye"></i> Detail Validasi</a>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

<!-- jQuery (Required by DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('.datatable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "lengthMenu": [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, "Semua"]],
            "pageLength": 25,
            "order": []
        });
    });
</script>
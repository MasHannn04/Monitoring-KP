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
                    <table class="table datatable" style="width: 100%;">
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
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" style="margin-top: 30px;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Riwayat Pengajuan Bimbingan (Disetujui)</h2>
                <div class="table-responsive">
                    <table class="table datatable" style="width: 100%;">
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
                        </tbody>
                    </table>
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
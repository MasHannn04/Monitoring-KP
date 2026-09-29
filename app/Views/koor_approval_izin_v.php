<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Approval Pengajuan Izin KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Approval Izin</span>
                </div>
            </div>

            <?php if(count($reset_requests) > 0): ?>
            <div class="card" style="margin-bottom: 30px; border: 1px solid #dc3545; background-color: #fffafb;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px; color: #dc3545;"><i class="fa-solid fa-triangle-exclamation"></i> Menunggu Konfirmasi Ganti Perusahaan</h2>
                <div class="table-responsive">
                    <table class="table" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Ketua Kelompok</th>
                                <th>Instansi Lama</th>
                                <th>Alasan Ganti Perusahaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($reset_requests as $req): ?>
                                <tr>
                                    <td><div style="font-weight: 600;"><?= htmlspecialchars($req['ketua_nama']) ?></div></td>
                                    <td><?= htmlspecialchars($req['instansi_lama']) ?></td>
                                    <td style="max-width: 300px;"><?= htmlspecialchars($req['alasan_reset']) ?></td>
                                    <td>
                                        <form method="POST" style="display:flex; gap:5px;" id="formReset_<?= $req['kelompok_id'] ?>">
                                            <input type="hidden" name="kelompok_id" value="<?= $req['kelompok_id'] ?>">
                                            <input type="hidden" name="action" id="action_<?= $req['kelompok_id'] ?>" value="">
                                            <button type="button" class="btn btn-success" style="font-size: 12px; padding: 6px 10px;" title="Setujui Reset" onclick="confirmResetKoor(<?= $req['kelompok_id'] ?>, 'approve_reset')"><i class="fa-solid fa-check"></i> Setujui</button>
                                            <button type="button" class="btn btn-danger" style="font-size: 12px; padding: 6px 10px; background-color: #dc3545;" title="Tolak Reset" onclick="confirmResetKoor(<?= $req['kelompok_id'] ?>, 'reject_reset')"><i class="fa-solid fa-xmark"></i> Tolak</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pengajuan Izin</h2>
                <div class="table-responsive">
                    <table class="table datatable" style="width: 100%;">
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
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" style="margin-top: 30px;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Riwayat Pengajuan Izin (Disetujui)</h2>
                <div class="table-responsive">
                    <table class="table datatable" style="width: 100%;">
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

    function confirmResetKoor(id, actionType) {
        let title = actionType === 'approve_reset' ? 'Setujui Reset Perusahaan?' : 'Tolak Reset Perusahaan?';
        let text = actionType === 'approve_reset' ? 'Jika disetujui, seluruh progres kelompok ini akan dihapus dan mereka akan mengulang dari tahap pengajuan izin.' : 'Jika ditolak, kelompok ini harus melanjutkan KP di perusahaan yang lama.';
        let icon = actionType === 'approve_reset' ? 'warning' : 'info';
        let confirmColor = actionType === 'approve_reset' ? 'var(--success-green)' : '#dc3545';
        let btnText = actionType === 'approve_reset' ? 'Ya, Setujui' : 'Ya, Tolak';

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: btnText,
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('action_' + id).value = actionType;
                document.getElementById('formReset_' + id).submit();
            }
        });
    }
</script>
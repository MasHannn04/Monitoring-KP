<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Konten Bimbingan KP</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <a href="<?= base_url('dosen_list_bimbingan') ?>">Bimbingan KP</a> / <span style="color: var(--primary-blue);">Detail Konten</span>
                </div>
            </div>

            <div class="card">
                <div style="font-size: 16px; font-weight: 600; color: var(--primary-blue); margin-bottom: 20px;">
                    <i class="fa-solid fa-circle-info"></i> Informasi Mahasiswa & Dosen
                </div>
                
                <div class="info-grid" style="margin-bottom: 20px;">
                    <div>
                        <div class="info-label">Nama Mahasiswa</div>
                        <div class="info-value"><?= htmlspecialchars($kelompok_data['ketua'] ?? '-') ?></div>
                    </div>
                    <div>
                        <div class="info-label">NPM</div>
                        <div class="info-value"><?= htmlspecialchars($kelompok_data['npm_nip'] ?? '-') ?></div>
                    </div>
                    <div>
                        <div class="info-label">Dosen Pembimbing</div>
                        <div class="info-value"><?= htmlspecialchars($_SESSION['user_name'] ?? 'Dosen') ?></div>
                    </div>
                    <div>
                        <div class="info-label">Instansi / Tempat KP</div>
                        <div class="info-value"><?= htmlspecialchars($kelompok_data['nama_instansi'] ?? 'Belum ada instansi') ?></div>
                    </div>
                </div>
                
                <div style="padding-top: 15px; border-top: 1px solid var(--border-color);">
                    <div class="info-label">Judul Kerja Praktek</div>
                    <div class="info-value"><?= htmlspecialchars($kelompok_data['judul_laporan'] ?? 'Belum ada judul') ?></div>
                </div>
            </div>

            <div class="card">
                <div class="table-header">
                    <h2 style="font-size: 16px; font-weight: 600;">Log Bimbingan KP</h2>
                    <div class="table-controls">
                        <?php if(isset($kelompok_data['status_dospem']) && $kelompok_data['status_dospem'] == 'disetujui'): ?>
                            <span class="badge badge-success" style="padding: 10px; font-size: 13px;"><i class="fa-solid fa-check"></i> Seluruh Bimbingan Di-ACC</span>
                        <?php elseif(isset($can_approve_all) && $can_approve_all): ?>
                            <form method="POST" style="margin:0;" id="form-acc-akhir">
                                <input type="hidden" name="approve_all" value="1">
                                <button type="button" class="btn btn-primary" onclick="confirmAccAkhir()" style="background-color: var(--success-green);"><i class="fa-solid fa-check-double"></i> Selesaikan & ACC Bimbingan</button>
                            </form>
                        <?php else: ?>
                            <div style="text-align: right;">
                                <button class="btn btn-secondary" disabled style="background-color: #6c757d; cursor: not-allowed;" title="Minimal 10 kali bimbingan dan semua harus di-ACC">
                                    <i class="fa-solid fa-lock"></i> Selesaikan & ACC Bimbingan
                                </button>
                                <div style="font-size: 11px; color: #dc3545; margin-top: 5px;">*Butuh min. 10 Log Bimbingan yang telah di-ACC. Saat ini: <?= isset($total_acc) ? $total_acc : 0 ?>/10.</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="table-controls" style="justify-content: space-between; margin-bottom: 15px;">
                    <div>Tampilkan <select style="margin: 0 5px;"><option>10</option></select> data</div>
                    <div>Cari: <input type="text"></div>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">No <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                                <th width="20%">Tgl Bimbingan <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                                <th width="60%">Konten Bimbingan <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                                <th width="15%">Aksi <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($logs)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada log bimbingan.</td>
                            </tr>
                            <?php else: ?>
                            <?php $i=1; foreach($logs as $log): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d-M-Y', strtotime($log['tgl_bimbingan'])) ?></td>
                                <td>
                                    <strong>Catatan Mahasiswa:</strong> <?= htmlspecialchars($log['catatan']) ?>
                                </td>
                                <td>
                                    <?php if($log['status_log'] == 'acc'): ?>
                                        <div style="margin-bottom: 10px; font-size: 13px;">
                                            <strong>Catatan/Balasan Dosen:</strong><br>
                                            <?= nl2br(htmlspecialchars($log['catatan_dosen'] ?? '-')) ?>
                                        </div>
                                        <span class="badge badge-success" style="padding: 5px 10px;"><i class="fa-solid fa-check"></i> Telah Di-ACC</span>
                                    <?php else: ?>
                                        <form method="POST" style="display:flex; gap: 10px; align-items: start; flex-direction: column;">
                                            <input type="hidden" name="log_id" value="<?= $log['id'] ?>">
                                            <textarea name="catatan_dosen" class="form-control" style="width:100%; height: 60px;" placeholder="Beri catatan revisi/ACC (opsional)"><?= htmlspecialchars($log['catatan_dosen'] ?? '') ?></textarea>
                                            
                                            <div style="display:flex; gap: 10px; margin-top: 5px;">
                                                <button type="submit" name="approve" class="btn btn-primary" style="background-color: var(--success-green); padding: 5px 10px; font-size:12px;"><i class="fa-solid fa-check"></i> ACC</button>
                                                
                                                <?php if($log['status_log'] == 'revisi'): ?>
                                                    <button type="submit" name="reject" class="btn btn-primary" style="background-color: #dc3545; padding: 5px 10px; font-size:12px;" title="Perbarui Catatan Revisi"><i class="fa-solid fa-rotate-left"></i> Update Revisi</button>
                                                <?php else: ?>
                                                    <button type="submit" name="reject" class="btn btn-primary" style="background-color: #dc3545; padding: 5px 10px; font-size:12px;"><i class="fa-solid fa-rotate-left"></i> Revisi</button>
                                                <?php endif; ?>
                                            </div>
                                        </form>
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
<script>
function confirmAccAkhir() {
    Swal.fire({
        title: 'Selesaikan Bimbingan?',
        text: 'Apakah Anda yakin ingin memberikan ACC akhir untuk seluruh progres bimbingan ini? Mahasiswa akan dapat mendaftar seminar setelah ini.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: 'var(--success-green)',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fa-solid fa-check-double"></i> Ya, ACC Semua!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-acc-akhir').submit();
        }
    });
}
</script>
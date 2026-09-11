

<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Dashboard Koordinator</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Dashboard</span>
        </div>
    </div>

    <?php if(!empty($success_msg)): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-check"></i> <?= $success_msg ?>
        </div>
    <?php endif; ?>

    <div class="card" style="margin-bottom: 20px; background-color: #F4F9FF; border: 1px solid var(--primary-blue);">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; color: var(--primary-blue);"><i class="fa-solid fa-gear"></i> Pengaturan Pengumuman Akademik</h2>
        <form method="POST" style="display: flex; gap: 15px; align-items: flex-end; flex-wrap: wrap;">
            <input type="hidden" name="action" value="update_settings">
            <div class="form-group" style="flex: 1; min-width: 250px; margin: 0;">
                <label class="form-label">Tahun Akademik & Semester Aktif</label>
                <input type="text" name="tahun_akademik" class="form-control" value="<?= htmlspecialchars(get_setting('tahun_akademik')) ?>" placeholder="Cth: 2026/2027 - Ganjil" required>
            </div>
            <button type="submit" class="btn btn-primary" style="padding: 8px 20px;"><i class="fa-solid fa-save"></i> Simpan Pengaturan</button>
        </form>
    </div>

    <div class="dashboard-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $izin_baru ?></h3>
                <p>Menunggu Approval Izin</p>
            </div>
            <div class="stat-icon icon-orange"><i class="fa-solid fa-envelope-open-text"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $plot_dosen ?></h3>
                <p>Menunggu Plot Dosen</p>
            </div>
            <div class="stat-icon icon-red"><i class="fa-solid fa-chalkboard-user"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $jadwal_sidang ?></h3>
                <p>Menunggu Jadwal Sidang</p>
            </div>
            <div class="stat-icon icon-blue"><i class="fa-solid fa-calendar-days"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $kelompok_aktif ?></h3>
                <p>Kelompok Aktif (Bimbingan)</p>
            </div>
            <div class="stat-icon icon-green"><i class="fa-solid fa-users"></i></div>
        </div>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Kelompok KP Aktif (Rekap Keseluruhan)</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Ketua Kelompok</th>
                        <th>Instansi</th>
                        <th>Status Terakhir</th>
                        <th>Tanggal Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    if($list_kelompok && $list_kelompok->getNumRows() > 0) {
                        foreach($list_kelompok->getResultArray() as $row) {
                            // Determine status badge
                            $status_badge = '<span class="badge" style="background-color: var(--text-muted);">Menunggu</span>';
                            if ($row['status_kelompok'] == 'menunggu_validasi') {
                                $status_badge = '<span class="badge" style="background-color: #FFA94D;">Pengajuan Kelompok</span>';
                            } elseif ($row['status_kelompok'] == 'disetujui') {
                                $status_badge = '<span class="badge badge-success">Disetujui/Aktif</span>';
                            }
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td>
                            <div style="font-weight: 600;"><?= htmlspecialchars($row['ketua_nama']) ?></div>
                            <div style="font-size: 11px; color: var(--text-muted);">Anggota: <?= $row['jml_anggota'] ?> Mahasiswa</div>
                        </td>
                        <td><?= $row['nama_instansi'] ? htmlspecialchars($row['nama_instansi']) : '-' ?></td>
                        <td><?= $status_badge ?></td>
                        <td><?= $row['tgl_update'] ?></td>
                    </tr>
                    <?php 
                        } 
                    } else {
                    ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: var(--text-muted);">Belum ada kelompok KP aktif.</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Daftar Mahasiswa KP</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / Manajemen User / <span style="color: var(--primary-blue);">Daftar Mahasiswa</span>
        </div>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Semua Mahasiswa Terdaftar</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>NPM</th>
                        <th>Nama Lengkap</th>
                        <th>Kelompok</th>
                        <th>Progress / Status KP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($mahasiswa_list)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada mahasiswa yang terdaftar.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($mahasiswa_list as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['npm_nip']) ?></td>
                        <td><?= htmlspecialchars($m['nama']) ?></td>
                        <td>
                            <?php if ($m['status_info']['kelompok']): ?>
                                <?php
                                    $kelompok = $m['status_info']['kelompok'];
                                    if ($kelompok['status_kelompok'] == 'acc' || $kelompok['status_kelompok'] == 'disetujui' || $kelompok['status_kelompok'] == 'menunggu_validasi' || $kelompok['status_kelompok'] == 'draft') {
                                        echo "<span class='badge badge-success' style='background-color: var(--primary-blue);'>ID: KP-".str_pad($kelompok['id'], 3, '0', STR_PAD_LEFT)."</span>";
                                    } else {
                                        echo "<span class='badge badge-danger'>Ditolak</span>";
                                    }
                                ?>
                            <?php else: ?>
                                <span class="badge badge-warning" style="background-color: #f8f9fa; color: var(--text-muted); border: 1px solid #dee2e6;">Belum Ada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 24px; height: 24px; border-radius: 50%; background-color: <?= $m['status_info']['status_color'] ?>; color: white; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                                    <i class="fa-solid <?= $m['status_info']['status_icon'] ?>"></i>
                                </div>
                                <div>
                                    <div style="font-size: 12px; font-weight: 600; color: <?= $m['status_info']['status_color'] ?>;">
                                        <?= htmlspecialchars($m['status_info']['status_kp']) ?>
                                    </div>
                                    <div style="font-size: 10px; color: var(--text-muted);">
                                        <?= $m['status_info']['progress_width'] ?> Selesai
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

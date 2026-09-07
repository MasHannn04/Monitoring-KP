<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Approval Pendaftaran Seminar</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Approval Seminar</span>
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pendaftaran Seminar Menunggu Jadwal</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ketua Kelompok</th>
                                <th>Instansi Tujuan</th>
                                <th>Dosen Pembimbing</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($seminar_list)): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada pendaftaran seminar yang menunggu jadwal.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($seminar_list as $s): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($s['ketua']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($s['npm_nip']) ?></div>
                                </td>
                                <td><?= htmlspecialchars($s['nama_instansi'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($s['nama_dospem'] ?? '-') ?></td>
                                <td>
                                    <a href="<?= base_url('koor_detail_seminar') ?>?id=<?= $s['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block; margin-right: 5px;"><i class="fa-solid fa-eye"></i> Proses & Atur Jadwal</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
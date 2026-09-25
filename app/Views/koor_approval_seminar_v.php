<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Approval Pendaftaran Seminar</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Approval Seminar</span>
                </div>
            </div>

            <div class="card">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Daftar Pendaftaran Seminar</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ketua Kelompok</th>
                                <th>Instansi Tujuan</th>
                                <th>Dosen Pembimbing</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $has_menunggu = false;
                            foreach($seminar_list as $s) {
                                if($s['status_koor'] != 'acc' && $s['status_koor'] != 'dijadwalkan' && $s['status_koor'] != 'tolak') {
                                    $has_menunggu = true;
                                    break;
                                }
                            }
                            if(!$has_menunggu): 
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada pendaftaran seminar yang menunggu jadwal.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($seminar_list as $s): if($s['status_koor'] != 'acc' && $s['status_koor'] != 'dijadwalkan' && $s['status_koor'] != 'tolak'): ?>
                            <tr>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($s['ketua']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($s['npm_nip']) ?></div>
                                </td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 250px;"><?= htmlspecialchars($s['nama_instansi'] ?? '-') ?></td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;"><?= htmlspecialchars($s['nama_dospem'] ?? '-') ?></td>
                                <td>
                                    <?php if($s['status_koor'] == 'acc'): ?>
                                        <span class="badge badge-success"><i class="fa-solid fa-check"></i> Dijadwalkan</span>
                                    <?php else: ?>
                                        <span class="badge" style="background-color: #FFA94D;"><i class="fa-solid fa-clock"></i> Menunggu Jadwal</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('koor_detail_seminar') ?>?id=<?= $s['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block; margin-right: 5px;"><i class="fa-solid fa-eye"></i> Proses & Atur Jadwal</a>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card" style="margin-top: 30px;">
                <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Riwayat Seminar (Dijadwalkan)</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ketua Kelompok</th>
                                <th>Instansi Tujuan</th>
                                <th>Dosen Pembimbing</th>
                                <th>Status Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $has_acc = false;
                            foreach($seminar_list as $s) {
                                if($s['status_koor'] == 'acc' || $s['status_koor'] == 'dijadwalkan') {
                                    $has_acc = true;
                                    break;
                                }
                            }
                            if(!$has_acc): 
                            ?>
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada jadwal seminar.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach($seminar_list as $s): if($s['status_koor'] == 'acc' || $s['status_koor'] == 'dijadwalkan'): ?>
                            <tr>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;">
                                    <div style="font-weight: 600; margin-bottom: 3px;"><?= htmlspecialchars($s['ketua']) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($s['npm_nip']) ?></div>
                                </td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 250px;"><?= htmlspecialchars($s['nama_instansi'] ?? '-') ?></td>
                                <td style="white-space: normal; word-wrap: break-word; max-width: 200px;"><?= htmlspecialchars($s['nama_dospem'] ?? '-') ?></td>
                                <td>
                                    <span class="badge badge-success"><i class="fa-solid fa-check"></i> Dijadwalkan</span>
                                </td>
                                <td>
                                    <a href="<?= base_url('koor_detail_seminar') ?>?id=<?= $s['id'] ?>" class="btn btn-primary" style="font-size: 12px; padding: 5px 10px; background-color: #6c757d; text-decoration: none; display: inline-block; margin-right: 5px;"><i class="fa-solid fa-eye"></i> Detail Jadwal</a>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
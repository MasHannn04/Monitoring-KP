<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Jadwal Seminar KP</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / Dashboard / <span style="color: var(--primary-blue);">Jadwal Seminar KP</span>
        </div>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Statistik Jadwal Seminar</h2>
        
        <div class="dashboard-grid" style="margin-bottom: 0;">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>0</h3>
                    <p>Belum Dinilai</p>
                </div>
                <div class="stat-icon icon-red"><i class="fa-solid fa-pen"></i></div>
            </div>
            <div class="stat-card" style="background-color: #F0FAF0; border-color: #c3e6cb;">
                <div class="stat-info">
                    <h3 style="color: var(--success-green);">37</h3>
                    <p style="color: var(--success-green);">Sudah Dinilai</p>
                </div>
                <div class="stat-icon icon-green"><i class="fa-solid fa-check"></i></div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>10</h3>
                    <p>Sebagai Sekretaris</p>
                </div>
                <div class="stat-icon icon-blue"><i class="fa-solid fa-user-tie"></i></div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>0</h3>
                    <p>Peran Lainnya</p>
                </div>
                <div class="stat-icon icon-yellow"><i class="fa-solid fa-users"></i></div>
            </div>
        </div>
    </div>

    <?php 
    // Filter data seminar berdasarkan peran
    $list_pembimbing = [];
    $list_penguji = [];
    if(!empty($seminar_list)) {
        foreach($seminar_list as $s) {
            if ($s['dospem_id'] == $_SESSION['user_id']) {
                $list_pembimbing[] = $s;
            }
            if (($s['penguji1_id'] == $_SESSION['user_id'] || $s['penguji2_id'] == $_SESSION['user_id']) && $s['dospem_id'] != $_SESSION['user_id']) {
                $list_penguji[] = $s;
            }
        }
    }
    ?>

    <!-- JADWAL SEBAGAI PEMBIMBING -->
    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Jadwal Seminar (Sebagai Pembimbing)</h2>
        <div class="table-responsive">
            <table class="table" style="font-size: 12px; width: 100%; min-width: 700px;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th width="5%">No <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="15%">NPM <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="25%">Nama <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="25%">Penguji <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="20%">Jadwal & Tempat <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="10%">Aksi <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($list_pembimbing)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada jadwal seminar.</td>
                    </tr>
                    <?php else: ?>
                    <?php $i=1; foreach($list_pembimbing as $s): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td style="white-space: nowrap;"><?= htmlspecialchars($s['npm_nip'] ?? '') ?></td>
                        <td style="white-space: normal; word-wrap: break-word; min-width: 150px;"><?= htmlspecialchars($s['ketua'] ?? '') ?></td>
                        <td style="line-height: 1.6; white-space: normal; word-wrap: break-word; min-width: 150px;">
                            <?php if($s['nama_penguji2']): ?>• <?= htmlspecialchars($s['nama_penguji2']) ?><?php else: ?>-<?php endif; ?>
                        </td>
                        <td style="white-space: nowrap;">
                            <i class="fa-regular fa-calendar" style="color:var(--primary-blue); width: 12px;"></i> <?= $s['tgl_seminar'] ? date('d-M-Y', strtotime($s['tgl_seminar'])) : '-' ?><br>
                            <i class="fa-regular fa-clock" style="color:var(--primary-blue); width: 12px;"></i> <?= $s['jam_seminar'] ? date('H:i', strtotime($s['jam_seminar'])) : '-' ?><br>
                            <i class="fa-solid fa-location-dot" style="color:var(--primary-blue); width: 12px;"></i> <?= htmlspecialchars($s['ruangan'] ?? '-') ?>
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="<?= base_url('dosen_detail_sidang') ?>?id=<?= $s['id'] ?>" class="btn btn-primary" style="font-size: 11px;"><i class="fa-solid fa-eye"></i> Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JADWAL SEBAGAI PENGUJI -->
    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Jadwal Seminar (Sebagai Penguji)</h2>
        <div class="table-responsive">
            <table class="table" style="font-size: 12px; width: 100%; min-width: 700px;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th width="5%">No <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="15%">NPM <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="25%">Nama <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="25%">Pembimbing <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="20%">Jadwal & Tempat <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                        <th width="10%">Aksi <i class="fa-solid fa-sort" style="color: #ccc; font-size: 10px;"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($list_penguji)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 20px;">Tidak ada jadwal seminar.</td>
                    </tr>
                    <?php else: ?>
                    <?php $i=1; foreach($list_penguji as $s): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td style="white-space: nowrap;"><?= htmlspecialchars($s['npm_nip'] ?? '') ?></td>
                        <td style="white-space: normal; word-wrap: break-word; min-width: 150px;"><?= htmlspecialchars($s['ketua'] ?? '') ?></td>
                        <td style="line-height: 1.6; white-space: normal; word-wrap: break-word; min-width: 150px;">
                            • <?= htmlspecialchars($s['nama_dospem'] ?? '-') ?>
                        </td>
                        <td style="white-space: nowrap;">
                            <i class="fa-regular fa-calendar" style="color:var(--primary-blue); width: 12px;"></i> <?= $s['tgl_seminar'] ? date('d-M-Y', strtotime($s['tgl_seminar'])) : '-' ?><br>
                            <i class="fa-regular fa-clock" style="color:var(--primary-blue); width: 12px;"></i> <?= $s['jam_seminar'] ? date('H:i', strtotime($s['jam_seminar'])) : '-' ?><br>
                            <i class="fa-solid fa-location-dot" style="color:var(--primary-blue); width: 12px;"></i> <?= htmlspecialchars($s['ruangan'] ?? '-') ?>
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="<?= base_url('dosen_detail_sidang') ?>?id=<?= $s['id'] ?>" class="btn btn-primary" style="font-size: 11px;"><i class="fa-solid fa-eye"></i> Detail</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Daftar Dosen</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / Manajemen User / <span style="color: var(--primary-blue);">Daftar Dosen</span>
        </div>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Semua Dosen Terdaftar</h2>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Dosen</th>
                        <th>Beban Mahasiswa Bimbingan</th>
                        <th>Beban Jadwal Penguji</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($dosen_list)): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada dosen yang terdaftar.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($dosen_list as $d): ?>
                    <tr>
                        <td><?= htmlspecialchars($d['npm_nip']) ?></td>
                        <td style="font-weight: 600;"><?= htmlspecialchars($d['nama']) ?></td>
                        <td>
                            <span class="badge badge-primary" style="background-color: var(--primary-blue); font-size: 12px;"><i class="fa-solid fa-users"></i> <?= $d['total_bimbingan'] ?> Mahasiswa</span>
                        </td>
                        <td>
                            <span class="badge badge-warning" style="background-color: #FFA94D; color: white; font-size: 12px;"><i class="fa-solid fa-gavel"></i> <?= $d['total_penguji'] ?> Kelompok</span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

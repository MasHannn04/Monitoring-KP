<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Daftar Mahasiswa KP</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / Manajemen User / <span style="color: var(--primary-blue);">Daftar Mahasiswa</span>
        </div>
    </div>

    <div class="card">
        <?php if(!empty($error)): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <i class="fa-solid fa-circle-exclamation"></i> <?= $error ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($success)): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                <i class="fa-solid fa-circle-check"></i> <?= $success ?>
            </div>
        <?php endif; ?>
        
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Semua Mahasiswa Terdaftar</h2>
        <div class="table-responsive">
            <table class="table" style="font-size: 12px; width: 100%;">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">NPM</th>
                        <th style="white-space: nowrap;">Nama Lengkap</th>
                        <th style="white-space: nowrap;">Kelompok</th>
                        <th style="white-space: nowrap;">Progress / Status KP</th>
                        <th style="text-align: center; white-space: nowrap;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($mahasiswa_list)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada mahasiswa yang terdaftar.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($mahasiswa_list as $m): ?>
                    <tr>
                        <td style="white-space: nowrap;"><?= htmlspecialchars($m['npm_nip']) ?></td>
                        <td style="white-space: normal; word-wrap: break-word; min-width: 150px;"><?= htmlspecialchars($m['nama']) ?></td>
                        <td style="white-space: nowrap;">
                            <?php if (!empty($m['status_info']['kelompok']['id'])): ?>
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
                        <td style="white-space: nowrap;">
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
                        <td style="text-align: center; white-space: nowrap;">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="openEditModal(<?= $m['id'] ?>, '<?= htmlspecialchars(addslashes($m['nama'])) ?>', '<?= htmlspecialchars(addslashes($m['npm_nip'])) ?>')" style="padding: 4px 8px; font-size: 12px; margin-right: 5px;" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mahasiswa ini?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $m['id'] ?>">
                                <button type="submit" class="btn btn-sm btn-outline-danger" style="padding: 4px 8px; font-size: 12px;" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 20px; border-radius: 8px; width: 400px; max-width: 90%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; font-size: 16px;">Edit Data Mahasiswa</h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px;">Nama Lengkap</label>
                <input type="text" name="nama" id="edit_nama" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px;">NPM</label>
                <input type="text" name="npm_nip" id="edit_npm" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px;">Password Baru <small>(kosongkan jika tidak ingin diubah)</small></label>
                <input type="password" name="password" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div style="text-align: right;">
                <button type="button" onclick="closeEditModal()" class="btn btn-secondary" style="margin-right: 10px; padding: 8px 15px; background: #6c757d; color: white; border: none; border-radius: 4px; cursor: pointer;">Batal</button>
                <button type="submit" class="btn btn-primary" style="padding: 8px 15px; background: var(--primary-blue); color: white; border: none; border-radius: 4px; cursor: pointer;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, nama, npm) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_npm').value = npm;
    document.getElementById('editModal').style.display = 'flex';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>

<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Daftar Dosen</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / Manajemen User / <span style="color: var(--primary-blue);">Daftar Dosen</span>
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
        
        <div class="table-responsive">
            <table class="table" style="font-size: 12px; width: 100%; margin-bottom: 0;">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">NIP</th>
                        <th style="white-space: nowrap;">Nama Dosen</th>
                        <th style="white-space: nowrap;">Program Studi</th>
                        <th style="white-space: nowrap; text-align: center;">Beban Mahasiswa Bimbingan</th>
                        <th style="white-space: nowrap; text-align: center;">Beban Jadwal Penguji</th>
                        <th style="white-space: nowrap; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($dosen_list)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada dosen yang terdaftar.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($dosen_list as $d): ?>
                    <tr>
                        <td style="white-space: nowrap;"><?= htmlspecialchars($d['npm_nip']) ?></td>
                        <td style="white-space: normal; word-wrap: break-word; min-width: 150px; font-weight: 600; line-height: 1.4;"><?= htmlspecialchars($d['nama']) ?></td>
                        <td style="white-space: nowrap;"><?= htmlspecialchars($d['prodi'] ?? 'Sistem Informasi') ?></td>
                        <td style="white-space: nowrap; text-align: center;">
                            <span class="badge badge-primary" style="background-color: var(--primary-blue); font-size: 12px;"><i class="fa-solid fa-users"></i> <?= $d['total_bimbingan'] ?> Mahasiswa</span>
                        </td>
                        <td style="white-space: nowrap; text-align: center;">
                            <span class="badge badge-warning" style="background-color: #FFA94D; color: white; font-size: 12px;"><i class="fa-solid fa-gavel"></i> <?= $d['total_penguji'] ?> Kelompok</span>
                        </td>
                        <td style="white-space: nowrap; text-align: center;">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="openEditModal(<?= $d['id'] ?>, '<?= htmlspecialchars(addslashes($d['nama'])) ?>', '<?= htmlspecialchars(addslashes($d['npm_nip'])) ?>', '<?= htmlspecialchars(addslashes($d['prodi'] ?? 'Sistem Informasi')) ?>')" style="padding: 4px 8px; font-size: 12px; margin-right: 5px;" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dosen ini?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $d['id'] ?>">
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
            <h3 style="margin: 0; font-size: 16px;">Edit Data Dosen</h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 20px; cursor: pointer;">&times;</button>
        </div>
        <form method="POST">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px;">Nama Dosen Lengkap</label>
                <input type="text" name="nama" id="edit_nama" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px;">NIP</label>
                <input type="text" name="npm_nip" id="edit_npm" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-size: 13px;">Program Studi</label>
                <select name="prodi" id="edit_prodi" class="form-control" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="Sistem Informasi">Sistem Informasi</option>
                    <option value="Teknik Informatika">Teknik Informatika</option>
                </select>
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
function openEditModal(id, nama, npm, prodi) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_npm').value = npm;
    document.getElementById('edit_prodi').value = prodi;
    document.getElementById('editModal').style.display = 'flex';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}
</script>

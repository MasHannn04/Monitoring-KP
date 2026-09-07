<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Pengajuan Kelompok KP</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / <span style="color: var(--primary-blue);">Pengajuan Kelompok</span>
        </div>
    </div>

    <?php if ($state == 'terkunci'): ?>
    <div class="alert-success">
        <i class="fa-solid fa-check-circle" style="margin-top: 2px;"></i> 
        <div>Kelompok Anda telah diajukan/disetujui. Data tidak dapat diubah lagi.</div>
    </div>
    <?php else: ?>
    <div class="alert-info">
        <i class="fa-solid fa-circle-info" style="margin-top: 2px;"></i>
        <div>
            <strong>Informasi:</strong> Bentuk kelompok KP Anda di sini (Maksimal 3 Mahasiswa, Minimal 1). Cari teman menggunakan NPM atau Nama untuk mengirim ajakan. Teman yang diajak harus melakukan konfirmasi persetujuan di akun mereka.
        </div>
    </div>
    <?php endif; ?>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <!-- KOLOM KIRI: FORM / DAFTAR ANGGOTA -->
        <div class="card">
            <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Formulir Pendaftaran Kelompok</h2>
            
            <?php if ($state == 'belum_punya' && $rejection_reason): ?>
            <div class="alert-danger">
                <i class="fa-solid fa-circle-xmark" style="margin-top: 2px;"></i>
                <div>
                    <strong>Pengajuan Sebelumnya Ditolak:</strong> <?= htmlspecialchars($rejection_reason) ?><br>
                    Silakan bentuk kelompok baru.
                </div>
            </div>
            <?php endif; ?>

            <?php if ($state == 'belum_punya'): ?>
            <!-- FORM BUAT KELOMPOK BARU -->
            <form method="POST" action="<?= base_url('mhs_pengajuan_kelompok') ?>" enctype="multipart/form-data" onsubmit="if(!document.getElementById('file-studi').value) { alert('PERINGATAN: Anda belum memasukkan file Riwayat Studi (KHS/Transkrip). Silakan pilih file PDF terlebih dahulu!'); return false; }">
                <input type="hidden" name="action" value="create_draft">
                <div class="form-group">
                    <label class="form-label">Tahun Akademik / Semester</label>
                    <input type="text" class="form-control" value="2026/2027 - Ganjil" readonly style="background-color: #e9ecef;">
                </div>

                <div class="form-group" style="margin-top: 30px;">
                    <label class="form-label">Anggota Kelompok Saat Ini (Anda sebagai Ketua)</label>
                    <div class="member-list">
                        <div class="member-item">
                            <div>
                                <div style="font-weight: 600; font-size: 14px; margin-bottom: 3px;"><?= htmlspecialchars($_SESSION['nama']) ?> (Anda)</div>
                                <div style="font-size: 12px; color: var(--text-muted);"><?= htmlspecialchars($_SESSION['npm_nip'] ?? '-') ?></div>
                            </div>
                            <span class="badge badge-primary">Ketua</span>
                        </div>
                    </div>
                </div>

                <div class="alert-secondary">
                    <i class="fa-solid fa-lightbulb" style="color: #ffc107; margin-top: 2px;"></i> 
                    <div><strong>Ingin mengundang teman?</strong> Buat Draft Kelompok terlebih dahulu dengan mengunggah KHS Anda di bawah ini. Fitur pencarian dan undangan anggota akan otomatis terbuka setelah draft kelompok Anda berhasil dibuat.</div>
                </div>
                


                <div class="form-group" style="padding: 20px; border: 1px solid var(--border-color); border-radius: 8px; background-color: #F8F9FA; margin-top: 30px;">
                    <label class="form-label">Upload Dokumen Riwayat Studi Anda (KHS/Transkrip)</label>
                    <div class="alert-info" style="margin-bottom: 15px; padding: 10px 15px; font-size: 12px;">
                        <i class="fa-solid fa-triangle-exclamation"></i> Syarat wajib untuk validasi kelompok.
                    </div>
                    <div class="file-upload-wrapper" onclick="document.getElementById('file-studi').click()" style="padding: 20px; cursor: pointer; border: 2px dashed var(--primary-blue); border-radius: 6px; text-align: center; background-color: white;">
                        <i class="fa-solid fa-file-pdf" style="font-size: 24px; color: #dc3545; margin-bottom: 10px;"></i>
                        <p id="file-name-display" style="font-size: 13px; font-weight: 600; margin-bottom: 5px;">Klik untuk upload KHS/Transkrip (PDF)</p>
                        <input type="file" id="file-studi" name="khs" style="display: none;" accept="application/pdf" required onchange="document.getElementById('file-name-display').innerText = this.files.length > 0 ? 'Terpilih: ' + this.files[0].name : 'Klik untuk upload KHS/Transkrip (PDF)'; document.getElementById('file-name-display').style.color = this.files.length > 0 ? 'green' : 'inherit';">
                    </div>
                </div>

                <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save"></i> Buat Draft Kelompok</button>
                </div>
            </form>
            <?php else: ?>
            <!-- DRAFT / TERKUNCI MODE -->
            <div class="form-group">
                <label class="form-label">Tahun Akademik / Semester</label>
                <input type="text" class="form-control" value="2026/2027 - Ganjil" readonly style="background-color: #e9ecef;">
            </div>
            
            <div class="form-group" style="margin-top: 30px;">
                <label class="form-label">Anggota Kelompok Saat Ini</label>
                <div class="member-list">
                    <?php foreach($group_members as $m): ?>
                    <div class="member-item">
                        <div>
                            <div style="font-weight: 600; font-size: 14px; margin-bottom: 3px;"><?= htmlspecialchars($m['nama']) ?> <?= ($m['mahasiswa_id'] == $_SESSION['user_id']) ? '(Anda)' : '' ?></div>
                            <div style="font-size: 12px; color: var(--text-muted);"><?= htmlspecialchars($m['npm_nip']) ?></div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <?php if ($m['is_ketua']): ?>
                                <span class="badge badge-primary">Ketua</span>
                            <?php else: ?>
                                <?php if($m['status_anggota'] == 'menunggu'): ?>
                                    <span class="badge" style="background-color: #FFA94D;">Menunggu Konfirmasi</span>
                                <?php elseif($m['status_anggota'] == 'menerima'): ?>
                                    <span class="badge badge-success">Disetujui</span>
                                <?php elseif($m['status_anggota'] == 'menolak'): ?>
                                    <span class="badge badge-danger">Ditolak</span>
                                <?php endif; ?>
                                
                                <?php if ($state == 'draft' && $active_group['is_ketua']): ?>
                                <form method="POST" action="<?= base_url('mhs_pengajuan_kelompok') ?>" style="margin: 0; display: flex;">
                                    <input type="hidden" name="action" value="hapus_anggota">
                                    <input type="hidden" name="hapus_id" value="<?= $m['mahasiswa_id'] ?>">
                                    <button type="submit" class="btn btn-primary btn-icon" style="background-color: #dc3545; width: 28px; height: 28px;" title="Hapus Anggota"><i class="fa-solid fa-trash" style="font-size: 11px;"></i></button>
                                </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ($state == 'draft' && $active_group['is_ketua'] && count($group_members) < 3): ?>
            <div class="form-group" style="padding: 20px; border: 1px solid #1C5AA5; border-radius: 8px; background-color: #F4F9FF;">
                <label class="form-label" style="color: #1C5AA5;">Tambah Anggota Baru</label>
                <div style="display: flex; gap: 10px; margin-bottom: 15px;">
                    <input type="text" id="search_q" class="form-control" placeholder="Ketik NPM atau Nama lalu tekan Enter..." style="flex: 1; border-color: #1C5AA5;" onkeypress="if(event.key === 'Enter' || event.keyCode === 13) { window.location='<?= base_url('mhs_pengajuan_kelompok') ?>?q='+this.value; return false; }">
                    <button type="button" class="btn btn-primary" onclick="window.location='<?= base_url('mhs_pengajuan_kelompok') ?>?q='+document.getElementById('search_q').value;"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                </div>
                
                <?php if (isset($_GET['q'])): ?>
                <div class="search-result" style="display: block;">
                    <?php if (count($search_results) > 0): ?>
                        <?php foreach($search_results as $s): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; padding: 10px 0;">
                            <div>
                                <div style="font-weight: 600; font-size: 13px;"><?= htmlspecialchars($s['nama']) ?></div>
                                <div style="font-size: 11px; color: var(--text-muted);"><?= htmlspecialchars($s['npm_nip']) ?></div>
                            </div>
                            <form method="POST" action="<?= base_url('mhs_pengajuan_kelompok') ?>" style="margin: 0;">
                                <input type="hidden" name="action" value="add_invite">
                                <input type="hidden" name="undang_id" value="<?= $s['id'] ?>">
                                <button type="submit" class="btn btn-success" style="font-size: 12px;"><i class="fa-solid fa-paper-plane"></i> Undang</button>
                            </form>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div style="font-size: 12px; color: var(--text-muted);">Tidak ditemukan mahasiswa yang tersedia.</div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if ($state == 'draft' && $active_group['is_ketua']): ?>
                <?php if ($all_accepted): ?>
                <form method="POST" action="<?= base_url('mhs_pengajuan_kelompok') ?>" style="margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end;">
                    <input type="hidden" name="action" value="ajukan_final">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Ajukan Kelompok ke Koordinator</button>
                </form>
                <?php else: ?>
                <div class="alert-warning">
                    <i class="fa-solid fa-circle-exclamation" style="margin-top: 2px;"></i>
                    <div>Tombol pengajuan ke koordinator akan muncul setelah seluruh anggota menerima undangan.</div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php endif; ?> <!-- End If State -->
        </div>

        <!-- KOLOM KANAN: NOTIFIKASI & RIWAYAT -->
        <div>
            <?php if ($state == 'belum_punya'): ?>
            <div class="card" style="background-color: #FFFDF0; border-left: 4px solid #FFA94D; margin-bottom: 20px;">
                <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 10px;"><i class="fa-solid fa-bell"></i> Ajakan Kelompok Masuk</h3>
                <?php if (count($incoming_invites) > 0): ?>
                    <?php foreach($incoming_invites as $inv): ?>
                    <div style="background: white; border: 1px solid var(--border-color); padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                        <div style="font-size: 13px; font-weight: 600;">Ketua: <?= htmlspecialchars($inv['ketua_nama']) ?></div>
                        
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #eee;">
                            <form method="POST" action="<?= base_url('mhs_pengajuan_kelompok') ?>" enctype="multipart/form-data" style="margin-bottom: 12px;">
                                <input type="hidden" name="action" value="terima_invite">
                                <input type="hidden" name="kel_id" value="<?= $inv['kelompok_id'] ?>">
                                <div style="font-size: 11px; margin-bottom: 8px; color: var(--text-muted);">Upload KHS untuk menerima ajakan:</div>
                                <input type="file" name="khs" accept=".pdf" required class="form-control" style="font-size: 12px; padding: 8px; margin-bottom: 10px;">
                                <button type="submit" class="btn btn-success" style="width: 100%;"><i class="fa-solid fa-check"></i> Terima Ajakan & Upload</button>
                            </form>
                            <form method="POST" action="<?= base_url('mhs_pengajuan_kelompok') ?>">
                                <input type="hidden" name="action" value="tolak_invite">
                                <input type="hidden" name="kel_id" value="<?= $inv['kelompok_id'] ?>">
                                <button type="submit" class="btn btn-primary" style="width: 100%; background-color: #dc3545;"><i class="fa-solid fa-times"></i> Tolak Ajakan</button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 15px;">Anda tidak memiliki undangan untuk bergabung dengan kelompok lain saat ini.</p>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="card" style="margin-bottom: 20px;">
                <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;"><i class="fa-solid fa-history"></i> Riwayat Aktivitas</h3>
                <?php if (count($activity_history) > 0): ?>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                    <?php foreach($activity_history as $act): 
                        $icon = 'fa-circle-info';
                        $color = '#1C5AA5';
                        $text = '';
                        if ($act['role_type'] == 'sebagai_anggota') {
                            if ($act['status_anggota'] == 'menerima') { $icon = 'fa-check'; $color = 'green'; $text = "Bergabung ke kelompok {$act['target_nama']}"; }
                            elseif ($act['status_anggota'] == 'menolak') { $icon = 'fa-times'; $color = 'red'; $text = "Menolak ajakan {$act['target_nama']}"; }
                            elseif ($act['status_anggota'] == 'dikeluarkan') { $icon = 'fa-user-minus'; $color = 'red'; $text = "Dikeluarkan oleh {$act['target_nama']}"; }
                            else { $text = "Diundang oleh {$act['target_nama']}"; }
                        } else {
                            if ($act['status_anggota'] == 'menerima') { $icon = 'fa-check'; $color = 'green'; $text = "{$act['target_nama']} menyetujui ajakan"; }
                            elseif ($act['status_anggota'] == 'menolak') { $icon = 'fa-times'; $color = 'red'; $text = "{$act['target_nama']} menolak ajakan"; }
                            elseif ($act['status_anggota'] == 'dikeluarkan') { $icon = 'fa-user-minus'; $color = 'red'; $text = "Mengeluarkan {$act['target_nama']}"; }
                            else { $text = "Mengundang {$act['target_nama']}"; $color = 'orange'; }
                        }
                    ?>
                        <div style="display: flex; gap: 10px; align-items: flex-start; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                            <i class="fa-solid <?= $icon ?>" style="color: <?= $color ?>; margin-top: 3px;"></i>
                            <div>
                                <div style="font-size: 12px; font-weight: 600;"><?= htmlspecialchars($text) ?></div>
                                <div style="font-size: 10px; color: var(--text-muted);"><?= date('d M Y', strtotime($act['created_at'])) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="font-size: 12px; color: var(--text-muted);">Belum ada riwayat aktivitas.</p>
                <?php endif; ?>
            </div>

            <div class="card">
                <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;"><i class="fa-solid fa-list-check"></i> Riwayat Pengajuan Koordinator</h3>
                <?php if (count($submission_history) > 0): ?>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                    <?php foreach($submission_history as $sub): ?>
                        <div style="background: #f8f9fa; border: 1px solid #ddd; padding: 10px; border-radius: 4px;">
                            <div style="font-size: 11px; color: var(--text-muted); margin-bottom: 5px;"><?= date('d M Y', strtotime($sub['created_at'])) ?></div>
                            <div style="font-size: 12px; font-weight: 600;">Ketua: <?= htmlspecialchars($sub['ketua_nama']) ?></div>
                            <div style="font-size: 12px; margin-top: 5px;">
                                Status: <strong><?= strtoupper($sub['status_kelompok']) ?></strong>
                            </div>
                            <?php if ($sub['status_kelompok'] == 'ditolak'): ?>
                                <div style="font-size: 11px; color: #dc3545; margin-top: 5px;">Alasan: <?= htmlspecialchars($sub['koor_note']) ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p style="font-size: 12px; color: var(--text-muted);">Belum ada riwayat pengajuan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<div class="content-wrapper">
            <div class="page-header">
                <h1 class="page-title">Detail Sidang Kerja Praktek</h1>
                <div class="breadcrumb">
                    <a href="#"><i class="fa-solid fa-house"></i></a> / <a href="<?= base_url('dosen_jadwal_seminar') ?>">Jadwal Seminar KP</a> / <span style="color: var(--primary-blue);">Detail Sidang KP</span>
                </div>
            </div>

            <div class="card">
                <div class="section-title">
                    <i class="fa-solid fa-list-ul"></i> Informasi Sidang KP
                </div>
                
                <div class="info-grid" style="margin-bottom: 25px;">
                    <div>
                        <div class="info-label">Nama Mahasiswa</div>
                        <div class="info-value"><?= htmlspecialchars($seminar_data['ketua'] ?? '-') ?></div>
                    </div>
                    <div>
                        <div class="info-label">NPM</div>
                        <div class="info-value"><?= htmlspecialchars($seminar_data['npm_nip'] ?? '-') ?></div>
                    </div>
                    <div>
                        <div class="info-label">Judul Kerja Praktek</div>
                        <div class="info-value"><?= htmlspecialchars($seminar_data['judul_laporan'] ?? 'Belum ada judul') ?></div>
                    </div>
                    <div>
                        <div class="info-label">Tanggal & Tempat Sidang</div>
                        <div class="info-value" style="font-weight: 400;">
                            <i class="fa-regular fa-calendar" style="color:var(--primary-blue); width: 15px;"></i> <?= $seminar_data['tgl_seminar'] ? date('d-M-Y', strtotime($seminar_data['tgl_seminar'])) : '-' ?><br>
                            <i class="fa-regular fa-clock" style="color:var(--primary-blue); width: 15px;"></i> <?= $seminar_data['jam_seminar'] ? date('H:i', strtotime($seminar_data['jam_seminar'])) : '-' ?><br>
                            <i class="fa-solid fa-location-dot" style="color:var(--primary-blue); width: 15px;"></i> <?= htmlspecialchars($seminar_data['ruangan'] ?? '-') ?>
                        </div>
                    </div>
                </div>

                <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Dokumen Pendaftaran</h3>
                <div class="table-responsive" style="margin-bottom: 30px;">
                    <table class="table" style="border: 1px solid var(--border-color);">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis File</th>
                                <th>Nama File & Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Draft Laporan Akhir KP</td>
                                <td>
                                    <?php if(!empty($seminar_data['file_draft_laporan'])): ?>
                                    <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($seminar_data['file_draft_laporan']) ?>" target="_blank" class="btn btn-download" style="background-color: #17a2b8; color: white; border: none; margin-right: 5px;"><i class="fa-solid fa-eye"></i> Lihat</a>
                                    <a href="uploads/<?= urlencode($seminar_data['file_draft_laporan']) ?>" download class="btn btn-download"><i class="fa-solid fa-download"></i> Download</a>
                                    <?php endif; ?>
                                    <span style="color: var(--text-muted); margin-left: 10px; font-size: 12px;"><?= htmlspecialchars($seminar_data['file_draft_laporan'] ?? '-') ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Slip Pembayaran Sidang</td>
                                <td>
                                    <?php if(!empty($seminar_data['file_slip_seminar'])): ?>
                                    <a href="<?= base_url('view_pdf') ?>?file=<?= urlencode($seminar_data['file_slip_seminar']) ?>" target="_blank" class="btn btn-download" style="background-color: #17a2b8; color: white; border: none; margin-right: 5px;"><i class="fa-solid fa-eye"></i> Lihat</a>
                                    <a href="uploads/<?= urlencode($seminar_data['file_slip_seminar']) ?>" download class="btn btn-download"><i class="fa-solid fa-download"></i> Download</a>
                                    <?php endif; ?>
                                    <span style="color: var(--text-muted); margin-left: 10px; font-size: 12px;"><?= htmlspecialchars($seminar_data['file_slip_seminar'] ?? '-') ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <h3 style="font-size: 14px; font-weight: 600; margin-bottom: 15px;">Penilaian Penguji</h3>
                <div style="background-color: var(--white); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 30px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                        <div>
                            <div style="color: var(--primary-blue); font-weight: 600; margin-bottom: 10px;">
                                <i class="fa-solid fa-circle-info"></i> Informasi Pembimbing & Penguji
                            </div>
                            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 5px;"><i class="fa-solid fa-users"></i> Daftar Pembimbing:</div>
                            <div class="badge badge-primary" style="background-color: #E2E8F0; color: #333; font-weight: 600;"><?= htmlspecialchars($seminar_data['nama_dospem'] ?? '-') ?></div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 5px;"><i class="fa-solid fa-user-check"></i> Peran Anda di Sidang Ini:</div>
                            <div class="badge badge-success" style="font-size: 13px; padding: 6px 12px;">
                                <?php
                                $peran = [];
                                if ($_SESSION['user_id'] == $seminar_data['dospem_id']) $peran[] = 'Pembimbing';
                                if ($_SESSION['user_id'] == $seminar_data['penguji1_id']) $peran[] = 'Penguji 1';
                                if ($_SESSION['user_id'] == $seminar_data['penguji2_id']) $peran[] = 'Penguji 2';
                                echo !empty($peran) ? implode(', ', $peran) : '-';
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table" style="border: 1px solid var(--border-color); margin-bottom: 0;">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th>NPM</th>
                                    <th>Nama Mahasiswa</th>
                                    <th style="text-align: center;">Penguji 1</th>
                                    <th style="text-align: center;">Penguji 2</th>
                                    <th style="text-align: center;">Rata-rata Dosen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($anggota_list as $ak): 
                                    $n1 = $ak['nilai_penguji1'];
                                    $n2 = $ak['nilai_penguji2'];
                                    $rata2 = '-';
                                    if($n1 !== null && $n2 !== null) $rata2 = number_format(($n1 + $n2) / 2, 2);
                                ?>
                                <tr>
                                    <td><?= htmlspecialchars($ak['npm_nip']) ?></td>
                                    <td><?= htmlspecialchars($ak['nama']) ?></td>
                                    <td align="center" style="font-weight: 700; color: var(--primary-blue);"><?= $n1 !== null ? $n1 : '-' ?></td>
                                    <td align="center" style="font-weight: 700; color: var(--primary-blue);"><?= $n2 !== null ? $n2 : '-' ?></td>
                                    <td align="center" style="font-weight: 700; color: var(--success-green);"><?= $rata2 ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 30px;">
                    <a href="<?= base_url('dosen_jadwal_seminar') ?>" class="btn btn-primary" style="background-color: #103F80; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                    <button class="btn btn-primary" onclick="document.getElementById('form-penilaian').style.display='block';"><i class="fa-solid fa-pen-to-square"></i> Tambah Catatan Revisi & Penilaian</button>
                </div>

                <?php
                // Check if any existing grade has been filled by current user
                $has_graded = false;
                foreach($anggota_list as $ak) {
                    if ($_SESSION['user_id'] == $seminar_data['penguji1_id'] && $ak['nilai_penguji1'] !== null) {
                        $has_graded = true; break;
                    }
                    if ($_SESSION['user_id'] == $seminar_data['penguji2_id'] && $ak['nilai_penguji2'] !== null) {
                        $has_graded = true; break;
                    }
                }
                ?>
                <div id="form-penilaian" style="display: <?= $has_graded ? 'block' : 'none' ?>; margin-top: 30px; padding: 25px; border: 1px solid var(--border-color); border-radius: 8px; background-color: #f8f9fa;">
                    <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 20px; color: var(--primary-blue);"><i class="fa-solid fa-star"></i> Form Penilaian & Revisi</h3>
                    
                    <!-- Tabel Konversi Nilai -->
                    <div style="margin-bottom: 20px; background: white; padding: 15px; border: 1px solid var(--border-color); border-radius: 6px;">
                        <h4 style="font-size: 13px; font-weight: 600; margin-bottom: 10px;">Pedoman Konversi Nilai (ITATS)</h4>
                        <table style="width: 100%; font-size: 12px; border-collapse: collapse; text-align: center;">
                            <thead>
                                <tr style="background-color: #E2E8F0;">
                                    <th style="border: 1px solid #cbd5e1; padding: 5px;">Huruf</th>
                                    <th style="border: 1px solid #cbd5e1; padding: 5px;">Min</th>
                                    <th style="border: 1px solid #cbd5e1; padding: 5px;">Med</th>
                                    <th style="border: 1px solid #cbd5e1; padding: 5px;">Max</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td style="border: 1px solid #cbd5e1; padding: 4px;">E</td><td style="border: 1px solid #cbd5e1;">0</td><td style="border: 1px solid #cbd5e1;">20</td><td style="border: 1px solid #cbd5e1;">40</td></tr>
                                <tr style="background: #f8f9fa;"><td style="border: 1px solid #cbd5e1; padding: 4px;">D</td><td style="border: 1px solid #cbd5e1;">41</td><td style="border: 1px solid #cbd5e1;">45.5</td><td style="border: 1px solid #cbd5e1;">50</td></tr>
                                <tr><td style="border: 1px solid #cbd5e1; padding: 4px;">C</td><td style="border: 1px solid #cbd5e1;">51</td><td style="border: 1px solid #cbd5e1;">55.5</td><td style="border: 1px solid #cbd5e1;">60</td></tr>
                                <tr style="background: #f8f9fa;"><td style="border: 1px solid #cbd5e1; padding: 4px;">C+</td><td style="border: 1px solid #cbd5e1;">61</td><td style="border: 1px solid #cbd5e1;">63</td><td style="border: 1px solid #cbd5e1;">65</td></tr>
                                <tr><td style="border: 1px solid #cbd5e1; padding: 4px;">B-</td><td style="border: 1px solid #cbd5e1;">66</td><td style="border: 1px solid #cbd5e1;">69</td><td style="border: 1px solid #cbd5e1;">72</td></tr>
                                <tr style="background: #f8f9fa;"><td style="border: 1px solid #cbd5e1; padding: 4px;">B</td><td style="border: 1px solid #cbd5e1;">73</td><td style="border: 1px solid #cbd5e1;">74</td><td style="border: 1px solid #cbd5e1;">75</td></tr>
                                <tr><td style="border: 1px solid #cbd5e1; padding: 4px;">B+</td><td style="border: 1px solid #cbd5e1;">76</td><td style="border: 1px solid #cbd5e1;">77.5</td><td style="border: 1px solid #cbd5e1;">79</td></tr>
                                <tr style="background: #f8f9fa;"><td style="border: 1px solid #cbd5e1; padding: 4px;">A-</td><td style="border: 1px solid #cbd5e1;">80</td><td style="border: 1px solid #cbd5e1;">82.5</td><td style="border: 1px solid #cbd5e1;">85</td></tr>
                                <tr><td style="border: 1px solid #cbd5e1; padding: 4px;">A</td><td style="border: 1px solid #cbd5e1;">86</td><td style="border: 1px solid #cbd5e1;">88</td><td style="border: 1px solid #cbd5e1;">90</td></tr>
                                <tr style="background: #f8f9fa;"><td style="border: 1px solid #cbd5e1; padding: 4px;">A+</td><td style="border: 1px solid #cbd5e1;">91</td><td style="border: 1px solid #cbd5e1;">95.5</td><td style="border: 1px solid #cbd5e1;">100</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <form method="POST">
                        <?php foreach($anggota_list as $index => $ak): 
                            $ex_nilai = '';
                            $ex_revisi = '';
                            if ($_SESSION['user_id'] == $seminar_data['penguji1_id'] && $ak['nilai_penguji1'] !== null) {
                                $ex_nilai = $ak['nilai_penguji1'];
                                $ex_revisi = $ak['revisi_penguji1'];
                            } else if ($_SESSION['user_id'] == $seminar_data['penguji2_id'] && $ak['nilai_penguji2'] !== null) {
                                $ex_nilai = $ak['nilai_penguji2'];
                                $ex_revisi = $ak['revisi_penguji2'];
                            }
                        ?>
                        <div style="background: white; padding: 15px; border: 1px solid var(--border-color); border-radius: 8px; margin-bottom: 20px;">
                            <h4 style="font-size: 14px; font-weight: 600; color: var(--primary-blue); margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Mahasiswa <?= $index+1 ?>: <?= htmlspecialchars($ak['nama']) ?> (<?= htmlspecialchars($ak['npm_nip']) ?>)</h4>
                            <div class="form-group">
                                <label class="form-label">Nilai Angka (0-100)</label>
                                <input type="number" name="nilai_mahasiswa[<?= $ak['mahasiswa_id'] ?>]" class="form-control" min="0" max="100" step="0.01" required value="<?= htmlspecialchars((string)$ex_nilai) ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Catatan Revisi / Masukan</label>
                                <textarea name="revisi_mahasiswa[<?= $ak['mahasiswa_id'] ?>]" class="form-control" rows="3" required placeholder="Tuliskan catatan revisi untuk mahasiswa..."><?= htmlspecialchars($ex_revisi) ?></textarea>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Simpan Semua Penilaian</button>
                            <button type="button" class="btn btn-primary" style="background-color: #6c757d;" onclick="document.getElementById('form-penilaian').style.display='none';"><i class="fa-solid fa-times"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                                if ($_SESSION['user_id'] == $seminar_data['penguji2_id']) $peran[] = 'Penguji';
                                echo !empty($peran) ? implode(', ', $peran) : '-';
                                ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table" style="border: 1px solid var(--border-color); margin-bottom: 0;">
                            <tbody>
                                <tr style="background-color: #f8f9fa;">
                                    <td width="30%" style="font-weight: 600; color: var(--text-muted);">Pembimbing</td>
                                    <td width="40%" style="font-weight: 500;"><?= htmlspecialchars($seminar_data['nama_dospem'] ?? '-') ?></td>
                                    <td width="15%" align="right" style="color: var(--text-muted);">Nilai :</td>
                                    <td width="15%" align="center" style="font-weight: 700; font-size: 14px; color: var(--primary-blue);"><?= $seminar_data['nilai_pembimbing'] !== null ? $seminar_data['nilai_pembimbing'] : '-' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; color: var(--text-muted);">Penguji</td>
                                    <td style="font-weight: 500;"><?= htmlspecialchars($seminar_data['nama_penguji2'] ?? '-') ?></td>
                                    <td align="right" style="color: var(--text-muted);">Nilai :</td>
                                    <td align="center" style="font-weight: 700; font-size: 14px; color: var(--primary-blue);"><?= $seminar_data['nilai_penguji2'] !== null ? $seminar_data['nilai_penguji2'] : '-' ?></td>
                                </tr>
                                <?php
                                    $total_nilai = 0;
                                    $count = 0;
                                    if($seminar_data['nilai_pembimbing'] !== null) { $total_nilai += $seminar_data['nilai_pembimbing']; $count++; }
                                    if($seminar_data['nilai_penguji2'] !== null) { $total_nilai += $seminar_data['nilai_penguji2']; $count++; }
                                    $rata_rata = $count > 0 ? number_format($total_nilai / $count, 2) : '-';
                                ?>
                                <tr style="background-color: #F0FAF0;">
                                    <td colspan="2" align="right" style="font-weight: 600; color: var(--success-green);">Total Penilaian Akhir KP (Rata-rata)</td>
                                    <td align="right" style="font-weight: 600; color: var(--success-green);">Total Nilai :</td>
                                    <td align="center" style="font-weight: 700; font-size: 16px; color: var(--success-green);"><?= $rata_rata ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; margin-top: 30px;">
                    <a href="<?= base_url('dosen_jadwal_seminar') ?>" class="btn btn-primary" style="background-color: #103F80; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                    <button class="btn btn-primary" onclick="document.getElementById('form-penilaian').style.display='block';"><i class="fa-solid fa-pen-to-square"></i> Tambah Catatan Revisi & Penilaian</button>
                </div>

                <?php
                // Get existing grade if any
                $existing_nilai = '';
                $existing_revisi = '';
                if ($_SESSION['user_id'] == $seminar_data['dospem_id'] && $seminar_data['nilai_pembimbing'] !== null) {
                    $existing_nilai = $seminar_data['nilai_pembimbing'];
                    $existing_revisi = $seminar_data['revisi_pembimbing'];
                } else if ($_SESSION['user_id'] == $seminar_data['penguji2_id'] && $seminar_data['nilai_penguji2'] !== null) {
                    $existing_nilai = $seminar_data['nilai_penguji2'];
                    $existing_revisi = $seminar_data['revisi_penguji2'];
                }
                ?>
                <div id="form-penilaian" style="display: <?= $existing_nilai !== '' ? 'block' : 'none' ?>; margin-top: 30px; padding: 25px; border: 1px solid var(--border-color); border-radius: 8px; background-color: #f8f9fa;">
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
                        <div class="form-group">
                            <label class="form-label">Nilai Angka (0-100)</label>
                            <input type="number" name="nilai" class="form-control" min="0" max="100" step="0.01" required value="<?= htmlspecialchars((string)$existing_nilai) ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Catatan Revisi / Masukan</label>
                            <textarea name="revisi" class="form-control" rows="4" required placeholder="Tuliskan catatan revisi untuk mahasiswa..."><?= htmlspecialchars($existing_revisi) ?></textarea>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i> Simpan Penilaian</button>
                            <button type="button" class="btn btn-primary" style="background-color: #6c757d;" onclick="document.getElementById('form-penilaian').style.display='none';"><i class="fa-solid fa-times"></i> Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
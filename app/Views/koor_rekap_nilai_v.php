<div class="content-wrapper">
    <div class="page-header">
        <h1 class="page-title">Rekap Nilai KP</h1>
        <div class="breadcrumb">
            <a href="#"><i class="fa-solid fa-house"></i></a> / Rekap Data / <span style="color: var(--primary-blue);">Rekap Nilai KP</span>
        </div>
    </div>

    <div class="card">
        <h2 style="font-size: 16px; font-weight: 600; margin-bottom: 20px;">Rekap Keseluruhan Nilai Mahasiswa</h2>
        
        <div class="table-responsive">
            <table class="table" style="font-size: 12px; width: 100%; border-collapse: collapse;" id="rekapTable">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;">Tgl Seminar</th>
                        <th style="white-space: nowrap;">NPM</th>
                        <th style="min-width: 120px; max-width: 180px; white-space: normal;">Nama Lengkap</th>
                        <th style="text-align: center;">Penguji 1</th>
                        <th style="text-align: center;">Penguji 2</th>
                        <th style="text-align: center; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">Nilai Perusahaan</th>
                        <th style="text-align: center; background-color: #f8f9fa;">Nilai Akhir</th>
                        <th style="text-align: center; background-color: #f8f9fa;">Huruf</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($mahasiswa_list)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 20px;">Belum ada data nilai mahasiswa.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach($mahasiswa_list as $m): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="white-space: nowrap; padding: 10px; color: var(--text-muted); font-size: 11px;"><?= $m['tgl_seminar'] ? date('Y-m-d', strtotime($m['tgl_seminar'])) : '-' ?></td>
                        <td style="white-space: nowrap; padding: 10px;"><?= htmlspecialchars($m['npm_nip']) ?></td>
                        <td style="padding: 10px; font-weight: 500; max-width: 180px; white-space: normal; word-wrap: break-word;"><?= htmlspecialchars($m['nama']) ?></td>
                        
                        <!-- Penguji 1 -->
                        <td style="text-align: center; padding: 10px;">
                            <?= ($m['nilai_penguji1'] !== null) ? number_format($m['nilai_penguji1'], 2) : '<span style="color: #dc3545; font-size: 10px;"><i class="fa-solid fa-xmark"></i> Belum ada</span>' ?>
                        </td>
                        
                        <!-- Penguji 2 -->
                        <td style="text-align: center; padding: 10px;">
                            <?= ($m['nilai_penguji2'] !== null) ? number_format($m['nilai_penguji2'], 2) : '<span style="color: #dc3545; font-size: 10px;"><i class="fa-solid fa-xmark"></i> Belum ada</span>' ?>
                        </td>
                        
                        <!-- Nilai Perusahaan -->
                        <td style="text-align: center; padding: 10px; border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6;">
                            <?= ($m['nilai_perusahaan'] !== null) ? number_format($m['nilai_perusahaan'], 2) : '<span style="color: #dc3545; font-size: 10px;"><i class="fa-solid fa-xmark"></i> Belum ada</span>' ?>
                        </td>
                        
                        <!-- Nilai Akhir -->
                        <td style="text-align: center; padding: 10px; font-weight: 700; background-color: #f8f9fa;">
                            <?= ($m['nilai_akhir'] !== null) ? number_format($m['nilai_akhir'], 2) : '-' ?>
                        </td>
                        
                        <!-- Huruf -->
                        <td style="text-align: center; padding: 10px; font-weight: 800; font-size: 14px; background-color: #f8f9fa; color: <?= ($m['huruf'] != '-') ? 'var(--success-green)' : 'inherit' ?>;">
                            <?= $m['huruf'] ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- jQuery (Required by DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#rekapTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
            },
            "lengthMenu": [[25, 50, 100, 200, 500, -1], [25, 50, 100, 200, 500, "Semua"]],
            "pageLength": 25,
            "order": [[ 0, "desc" ]]
        });
    });
</script>

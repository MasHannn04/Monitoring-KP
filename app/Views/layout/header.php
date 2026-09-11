<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title : 'Sistem Informasi Kerja Praktek' ?></title>
    <link rel="stylesheet" href="<?= base_url('asset/css/style.css') ?>?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Tambahan style spesifik bisa ditaruh di sini jika diperlukan */
        html, body {
            overflow-x: hidden;
            width: 100%;
        }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; margin-bottom: 8px; font-size: 13px; font-weight: 600; color: var(--text-dark); }
        .form-control { width: 100%; padding: 10px 15px; font-size: 14px; border: 1px solid var(--border-color); border-radius: 6px; outline: none; transition: border-color 0.2s; }
        .form-control:focus { border-color: var(--primary-blue); }
        .file-upload-wrapper { border: 2px dashed var(--border-color); padding: 25px; text-align: center; border-radius: 6px; background-color: #F8F9FA; cursor: pointer; height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; }
        .file-upload-wrapper:hover { border-color: var(--primary-blue); background-color: #EBF4FF; }
        .alert-info, .alert-success, .alert-warning, .alert-danger, .alert-secondary { padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-size: 13px; display: flex; align-items: center; gap: 12px; line-height: 1.6; }
        .alert-info { background-color: #E8F4FD; color: #0c5460; border: 1px solid #b8daff; }
        .alert-success { background-color: #D4EDDA; color: #155724; border: 1px solid #c3e6cb; }
        .alert-warning { background-color: #FFF4E5; color: #D39E00; border: 1px solid #ffe8cc; color: #856404; }
        .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-secondary { background-color: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; }
        .detail-grid { display: grid; grid-template-columns: 200px 1fr; gap: 15px; margin-bottom: 12px; font-size: 13px; border-bottom: 1px dashed #e9ecef; padding-bottom: 8px; }
        .detail-label { font-weight: 600; color: var(--text-muted); }
        .detail-value { font-weight: 500; color: #333; }
        .contact-box { background-color: #f8f9fa; border: 1px solid #e9ecef; padding: 15px; border-radius: 6px; margin-bottom: 15px; }
        .action-box { background-color: #f4f9ff; border: 1px solid #cce5ff; padding: 20px; border-radius: 8px; }
        .member-card { background-color: white; border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 15px; }
        .member-header { display: flex; align-items: center; gap: 15px; border-bottom: 1px dashed var(--border-color); padding-bottom: 15px; margin-bottom: 15px; }
        .doc-box { display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; background-color: #f8f9fa; border-radius: 6px; border: 1px solid #e9ecef; margin-bottom: 10px; }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

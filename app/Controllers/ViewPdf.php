<?php

namespace App\Controllers;

class ViewPdf extends BaseController
{
    public function index()
    {
        $session = session();

if (!isset($_SESSION['user_id'])) { return;
}

$file = $_GET['file'] ?? '';
$path = FCPATH . 'uploads/' . basename($file);

if (!$file || !file_exists($path) || strtolower(pathinfo($path, PATHINFO_EXTENSION)) !== 'pdf') {
    die("File tidak ditemukan atau format tidak valid.");
}

// Convert PDF to base64 to bypass IDM interception completely
$pdf_base64 = base64_encode(file_get_contents($path));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Dokumen KHS - <?= htmlspecialchars(basename($file)) ?></title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: #333;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <!-- Embedding as base64 data URI prevents IDM from sniffing the network request -->
    <iframe src="data:application/pdf;base64,<?= $pdf_base64 ?>"></iframe>
</body>
</html>

<?php
    }
}

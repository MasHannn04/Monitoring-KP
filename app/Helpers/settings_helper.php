<?php
function get_setting($key) {
    $file = WRITEPATH . 'settings.json';
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $data = json_decode($json, true);
        if (isset($data[$key])) {
            return $data[$key];
        }
    }
    // Default value if not found
    if ($key == 'tahun_akademik') return '2026/2027 - Ganjil';
    return '';
}

function set_setting($key, $value) {
    $file = WRITEPATH . 'settings.json';
    $data = [];
    if (file_exists($file)) {
        $json = file_get_contents($file);
        $data = json_decode($json, true);
    }
    $data[$key] = $value;
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}
?>

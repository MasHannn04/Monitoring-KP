<?php
function safe_upload_file($file_input, $upload_dir, $prefix_name = '', $custom_exts = null, $custom_mimes = null) {
    if (!isset($file_input) || $file_input['error'] != UPLOAD_ERR_OK) {
        return false;
    }

    $allowed_exts = $custom_exts ?? ['pdf', 'png', 'jpg', 'jpeg', 'zip', 'rar'];
    $allowed_mimes = $custom_mimes ?? [
        'application/pdf', 
        'image/png', 
        'image/jpeg', 
        'application/zip',
        'application/x-zip-compressed',
        'application/x-rar-compressed'
    ];

    $file_tmp = $file_input['tmp_name'];
    $file_name = $file_input['name'];
    
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_exts)) {
        $allowed_str = strtoupper(implode(', ', $allowed_exts));
        echo "<script>alert('Error: Ekstensi file .$ext tidak diizinkan! Harap upload file $allowed_str.'); window.history.back();</script>";
        exit;
    }

    // Check MIME type if possible
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file_tmp);
        finfo_close($finfo);
        
        if (!in_array($mime, $allowed_mimes)) {
            echo "<script>alert('Error: Format file ($mime) tidak sesuai dengan kontennya!'); window.history.back();</script>";
            exit;
        }
    }

    // Secure the file name
    $safe_name = preg_replace('/[^a-zA-Z0-9.-]/', '_', basename($file_name));
    $final_name = time() . '_' . $prefix_name . '_' . $safe_name;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    if (move_uploaded_file($file_tmp, $upload_dir . $final_name)) {
        return $final_name;
    }

    return false;
}
?>

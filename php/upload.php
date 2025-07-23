<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $img = $_FILES['image'];
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        echo "<p>Unsupported file type.</p>";
        exit;
    }

    if ($img['size'] > 5 * 1024 * 1024) { // 5MB max
        echo "<p>File too large (max 5MB).</p>";
        exit;
    }

    // Use absolute path to avoid directory issues
    $filename = uniqid() . "." . $ext;
    $destination = UPLOAD_DIR . $filename;

    if (move_uploaded_file($img['tmp_name'], $destination)) {
        $url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . "/uploads/" . $filename;
        echo "<p>Upload successful!</p>";
        echo "<input type='text' value='$url' readonly style='width:100%;'>";
        echo "<p><img src='$url' alt='Uploaded Image' style='max-width:100%; margin-top:10px;'></p>";
    } else {
        echo "<p>Upload failed. Try again.</p>";
        echo "<pre>";
        print_r($img);
        echo "</pre>";
    }
} else {
    echo "<p>No image received.</p>";
}
?>

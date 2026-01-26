<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

// ================== AMBIL DATA ==================
$title       = $_POST['title'];
$description = $_POST['description'];
$provider    = $_POST['provider'];
$amount      = $_POST['amount'];
$quota       = $_POST['quota'];
$deadline    = $_POST['deadline'];

// ================== UPLOAD GAMBAR ==================
$folder = "../uploads/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$namaFile = time() . "_" . basename($_FILES['image']['name']);
$tmpFile  = $_FILES['image']['tmp_name'];

$target = $folder . $namaFile;

// validasi gambar
$ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
$allowed = ['jpg', 'jpeg', 'png', 'webp'];

if (!in_array($ext, $allowed)) {
    die("Format gambar tidak didukung!");
}

if (!move_uploaded_file($tmpFile, $target)) {
    die("Upload gambar gagal!");
}

// ================== SIMPAN DATABASE ==================
$query = mysqli_query($conn, "

INSERT INTO beasiswa 
(title, description, provider, image, amount, quota, deadline)

VALUES
('$title','$description','$provider','$namaFile','$amount','$quota','$deadline')

");

if ($query) {
    header("Location: add_beasiswa.php?success=1");
    exit;
} else {
    echo "Gagal menyimpan: " . mysqli_error($conn);
}

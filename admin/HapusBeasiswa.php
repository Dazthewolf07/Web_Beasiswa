<?php
session_start();
include '../koneksi.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

$id = $_GET['id'];

// hapus gambar dulu
$q = mysqli_query($conn, "SELECT image FROM beasiswa WHERE id=$id");
$row = mysqli_fetch_assoc($q);

unlink("../uploads/" . $row['image']);

mysqli_query($conn, "DELETE FROM beasiswa WHERE id=$id");

header("Location: add_beasiswa.php");

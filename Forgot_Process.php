<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

include 'koneksi.php';
include 'Navbar.php'; // Pastikan koneksi.php menghasilkan $koneksi sebagai *link identifier* prosedural (bukan objek)

header('Content-Type: application/json');

// Validasi metode request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Metode request tidak valid']);
    exit;
}

// Sanitasi dan validasi email
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Format email tidak valid']);
    exit;
}

// === PROSEDURAL MYSQLI: Cek email di database ===
$stmt = mysqli_prepare($koneksi, "SELECT id FROM users WHERE email = ?");
if (!$stmt) {
    error_log("Prepare gagal (SELECT): " . mysqli_error($koneksi));
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem. Coba lagi nanti.']);
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt); // Wajib untuk mysqli_stmt_num_rows()
$num_rows = mysqli_stmt_num_rows($stmt);
mysqli_stmt_close($stmt);

if ($num_rows !== 1) {
    echo json_encode(['success' => false, 'message' => 'Email tidak terdaftar di sistem kami']);
    exit;
}

// === PROSEDURAL MYSQLI: Simpan token reset ===
$token = bin2hex(random_bytes(32));
$expires_at = date("Y-m-d H:i:s", strtotime("+1 hour"));

$stmt = mysqli_prepare($koneksi, "INSERT INTO password_resets (email, token, expires_at) VALUES (?, ?, ?)");
if (!$stmt) {
    error_log("Prepare gagal (INSERT): " . mysqli_error($koneksi));
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem. Coba lagi nanti.']);
    exit;
}

mysqli_stmt_bind_param($stmt, "sss", $email, $token, $expires_at);
if (!mysqli_stmt_execute($stmt)) {
    error_log("Eksekusi INSERT gagal: " . mysqli_stmt_error($stmt));
    mysqli_stmt_close($stmt);
    echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem. Coba lagi nanti.']);
    exit;
}
mysqli_stmt_close($stmt);

// Generate link reset (HANYA UNTUK DEMO - di produksi kirim via email)
$resetLink = "http://localhost/TugasAkhir/Reset_Password.php?token=" . urlencode($token);

echo json_encode([
    'success' => true,
    'message' => 'Link reset password berhasil dibuat!',
    'resetLink' => $resetLink // HAPUS di produksi! Jangan kembalikan link ke klien
]);

mysqli_close($koneksi);

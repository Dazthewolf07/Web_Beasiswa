<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "web_beasiswa_ukk";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$koneksi = mysqli_connect("localhost","root","","web_beasiswa_ukk");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
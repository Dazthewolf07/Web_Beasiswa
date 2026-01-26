<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../koneksi.php';


if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../Login.php');
    exit;
}

// Statistik
$totalBeasiswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM beasiswa"))['total'];
$totalUser = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$deadlineDekat = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM beasiswa WHERE deadline >= CURDATE() AND deadline <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)"))['total'];

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background: #f4f6f9;
            font-family: Arial
        }

        .dashboard {
            padding: 40px
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .1)
        }

        .card h2 {
            margin: 0;
            color: #004aad
        }

        .menu {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px
        }

        .menu a {
            background: #7200ff;
            color: white;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            font-weight: 600
        }

        .menu a:hover {
            opacity: .85
        }

        /* Reset dasar */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(90deg, #2ceaaa 0%, #0052ff 100%);
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            color: #111;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #007bff 0%, #0048d9 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12.8px 16px;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-wrap: wrap;
        }

        .navbar-left {
            font-weight: 700;
            color: #000;
            font-size: 17.6px;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 32px;
            font-weight: 600;
            font-size: 15.2px;
            color: #000;
        }

        .navbar-menu .dropdown {
            position: relative;
            cursor: pointer;
        }

        .navbar-menu .dropdown span::after {
            content: "▼";
            margin-left: 6.4px;
            font-size: 11.2px;
            display: inline-block;
            vertical-align: middle;
        }

        .navbar-menu a,
        .navbar-menu span {
            color: #000;
            font-weight: 600;
        }

        .btn-daftar {
            background-color: #7200ff;
            padding: 8px 22.4px;
            border-radius: 8px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border: none;
        }

        .btn-daftar:hover,
        .btn-daftar:focus {
            background-color: #5a00cc;
            outline: none;
        }

        /* Hero Section - Adapted for Login */
        .hero {
            position: relative;
            background-image: url(BackgroundImage.jpeg);
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 16px 64px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 0 0 32px 32px;
            min-height: 60vh;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            border-radius: 0 0 32px 32px;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .hero-welcome {
            font-weight: 600;
            font-size: 17.6px;
            margin-bottom: 9.6px;
        }

        .hero-title {
            font-size: 44.8px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 32px;
        }

        .login-form {
            background: rgba(255, 255, 255, 0.95);
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .login-form h2 {
            margin: 0 0 24px 0;
            color: #111;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .login-input {
            width: 100%;
            padding: 12.8px 16px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .login-input:focus {
            outline: none;
            border-color: #7200ff;
        }

        .login-button {
            background-color: #7200ff;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 700;
            padding: 12.8px 32px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .login-button:hover,
        .login-button:focus {
            background-color: #5a00cc;
            outline: none;
        }

        .login-links {
            text-align: center;
            margin-top: 16px;
        }

        .login-links a {
            color: #7200ff;
            font-size: 14.4px;
            text-decoration: underline;
        }

        /* Why Choose Section - Repurposed for Login Benefits */
        .why-choose {
            display: grid;
            grid-template-columns: 1fr 1fr;
            max-width: 1200px;
            margin: 64px auto;
            border-radius: 0 0 32px 32px;
            overflow: hidden;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .why-left {
            background: linear-gradient(90deg, #2ceaaa 0%, #0052ff 100%);
            padding: 48px 32px;
            color: #000;
            font-weight: 700;
            border-radius: 0 0 0 32px;
        }

        .why-left small {
            font-weight: 400;
            font-size: 14.4px;
        }

        .why-left h2 {
            margin-top: 16px;
            font-size: 32px;
            line-height: 1.15;
        }

        .why-right {
            background: linear-gradient(90deg, #7200ff 0%, #0040cc 100%);
            padding: 48px 32px;
            color: white;
            display: flex;
            flex-direction: column;
            gap: 32px;
            border-radius: 0 0 2rem 0;
        }

        .feature {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .icon-circle {
            background: white;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Simple icon shapes using SVG */
        .icon-circle svg {
            width: 20px;
            height: 20px;
            fill: #7200ff;
        }

        .feature-text {
            flex-grow: 1;
        }

        .feature-title {
            font-weight: 700;
            font-size: 17.6px;
            margin-bottom: 3.2px;
        }

        .feature-desc {
            font-weight: 400;
            font-size: 14.4px;
        }

        /* Responsive */
        @media (max-width: 900px) {
            .why-choose {
                grid-template-columns: 1fr;
                border-radius: 32px;
                margin: 48px 16px 64px;
            }

            .why-left,
            .why-right {
                border-radius: 32px;
                padding: 32px 24px;
            }

            .why-right {
                gap: 24px;
            }
        }

        @media (max-width: 600px) {
            .navbar {
                justify-content: center;
                gap: 16px;
            }

            .navbar-left {
                order: 1;
                flex-grow: 1;
                text-align: center;
            }

            .navbar-menu {
                order: 2;
                gap: 19.2px;
                flex-wrap: wrap;
                justify-content: center;
                margin-top: 9.6px;
            }

            .btn-daftar {
                order: 3;
                width: 100%;
                max-width: 160px;
                margin: 8px auto 0;
                text-align: center;
            }

            .hero {
                padding: 56px 16px 48px;
            }

            .hero-title {
                font-size: 30.4px;
            }

            .login-form {
                padding: 24px;
            }
        }
    </style>
</head>

<body>

    <div class="dashboard">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin 👋</p>

        <div class="cards">
            <div class="card">
                <h2><?= $totalBeasiswa ?></h2>
                <p>Total Beasiswa</p>
            </div>
            <div class="card">
                <h2><?= $totalUser ?></h2>
                <p>Total User</p>
            </div>
            <div class="card">
                <h2><?= $deadlineDekat ?></h2>
                <p>Deadline 7 Hari</p>
            </div>
        </div>

        <div class="menu">
            <a href="AddBeasiswa.php">➕ Tambah Beasiswa</a>
            <a href="KelolaBeasiswa.php">📋 Kelola Beasiswa</a>
            <a href="../Logout.php">🚪 Logout</a>
        </div>

    </div>
</body>

</html>
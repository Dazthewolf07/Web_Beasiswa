<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

// ambil data
$data = mysqli_query($conn, "SELECT * FROM beasiswa ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Kelola Beasiswa</title>

    <!-- CSS Lama -->
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9
        }

        .container {
            max-width: 1100px;
            margin: 30px auto
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd
        }

        img {
            width: 80px
        }

        button {
            background: #7200ff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px
        }

        a.hapus {
            color: red;
            text-decoration: none
        }
    </style>

    <!-- CSS BARU YANG KAMU KIRIM -->
    <style>
        /* Reset dasar */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(90deg, #2ceaaa 0%, #0052ff 100%);
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #111;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(90deg, #007BFF 0%, #0048D9 100%);
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
            gap: 2rem;
            font-weight: 600;
            font-size: 15.2px;
            color: #000;
        }

        .navbar-menu a,
        .navbar-menu span {
            color: #000;
            font-weight: 600;
        }

        .btn-daftar {
            background-color: #7200FF;
            padding: 8px 22.4px;
            border-radius: 8px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-daftar:hover,
        .btn-daftar:focus {
            background-color: #5a00cc;
            outline: none;
        }

        /* Hero Section - Adapted for About Us */
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
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 0 0 32px 32px;
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
            max-width: 700px;
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
            margin-bottom: 24px;
        }

        .search-form {
            display: flex;
            gap: 12.8px;
        }

        .search-input {
            flex: 1;
            padding: 11.2px 16px;
            border-radius: 32px;
            border: none;
            font-size: 16px;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .search-input::placeholder {
            color: #333;
        }

        .search-input:focus {
            outline: none;
            opacity: 1;
        }

        .search-button {
            background-color: #7200ff;
            border: none;
            border-radius: 32px;
            color: white;
            font-weight: 700;
            padding: 0 22.4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .search-button:hover,
        .search-button:focus {
            background-color: #5a00cc;
            outline: none;
        }

        /* Why Choose Section */
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
            border-radius: 0 0 32px 0;
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

            .search-button {
                padding: 0 1.6px;
                font-size: 14.4px;
            }
        }

        /* ===== FORM ADMIN ADD BEASISWA ===== */

        .form-box {
            max-width: 650px;
            margin: 60px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 32px;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 28px;
            font-size: 28px;
            font-weight: 800;
            color: #111;
        }

        /* group tiap input */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        /* input & textarea */
        .form-input,
        .form-textarea,
        .form-file {
            width: 100%;
            padding: 13px 16px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 15px;
            transition: all 0.25s ease;
            background: white;
        }

        .form-textarea {
            resize: vertical;
            min-height: 110px;
        }

        .form-input:focus,
        .form-textarea:focus,
        .form-file:focus {
            outline: none;
            border-color: #7200ff;
            box-shadow: 0 0 0 3px rgba(114, 0, 255, 0.15);
        }

        /* tombol */
        .form-btn {
            margin-top: 12px;
            width: 100%;
            background-color: #7200ff;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            padding: 14px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .form-btn:hover {
            background-color: #5a00cc;
        }

        /* link kembali */
        .back-link {
            display: block;
            margin-top: 18px;
            text-align: center;
            font-weight: 600;
            color: #7200ff;
        }

        /* responsive */
        @media (max-width: 600px) {
            .form-box {
                margin: 30px 16px;
                padding: 24px;
            }
        }
    </style>

</head>


<body>

    <div class="container">

        <!-- ================= FORM TAMBAH ================= -->
        <div class="form-box">

            <h2>Tambah Beasiswa</h2>

            <form action="proses_tambah_beasiswa.php"
                method="POST"
                enctype="multipart/form-data">

                <div class="form-group">
                    <label>Judul Beasiswa</label>
                    <input type="text" name="title" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-textarea" required></textarea>
                </div>

                <div class="form-group">
                    <label>Penyelenggara</label>
                    <input type="text" name="provider" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" name="image" class="form-file" required>
                </div>

                <div class="form-group">
                    <label>Dana</label>
                    <input type="number" name="amount" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Kuota</label>
                    <input type="number" name="quota" class="form-input" required>
                </div>

                <div class="form-group">
                    <label>Deadline</label>
                    <input type="date" name="deadline" class="form-input" required>
                </div>

                <button type="submit" class="form-btn">Tambah Beasiswa</button>

            </form>

            <a href="dashboard.php" class="back-link">⬅ Kembali ke Dashboard</a>

        </div>


        <!-- ================= LIST DATA ================= -->
        <div class="box">
            <h2>Daftar Beasiswa</h2>

            <table>
                <tr>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th>Penyelenggara</th>
                    <th>Dana</th>
                    <th>Kuota</th>
                    <th>Aksi</th>
                </tr>

                <?php while ($b = mysqli_fetch_assoc($data)) { ?>

                    <tr>
                        <td><img src="../uploads/<?= $b['image'] ?>"></td>
                        <td><?= $b['title'] ?></td>
                        <td><?= $b['provider'] ?></td>
                        <td><?= number_format($b['amount']) ?></td>
                        <td><?= $b['quota'] ?></td>
                        <td>
                            <a class="hapus"
                                href="HapusBeasiswa.php?id=<?= $b['id'] ?>"
                                onclick="return confirm('Hapus data?')">
                                Hapus
                            </a>
                        </td>
                    </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>

</html>
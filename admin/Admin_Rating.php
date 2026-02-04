<?php
session_start();
include '../koneksi.php';
include 'NavbarAdmin.php';

/* ===== CEK ADMIN ===== */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

/* ===== AMBIL DATA RATING ===== */
$query = mysqli_query($koneksi, "
  SELECT 
    penilaian.id,
    users.nama,
    penilaian.rating,
    penilaian.created_at
  FROM penilaian
  JOIN users ON penilaian.user_id = users.id
  ORDER BY penilaian.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Rating Pengunjung</title>
    <link rel="stylesheet" href="Style.css">
    <style>
        body {
            background: linear-gradient(90deg, #2ceaaa 0%, #0052ff 100%);
            font-family: Arial;
            margin: 0;
        }

        .admin-rating-page {
            padding: 40px;
        }

        .admin-rating-box {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .1);
        }

        .admin-rating-box h1 {
            margin-bottom: 25px;
            color: #004aad;
        }

        /* ===== TABLE ===== */

        .rating-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rating-table th {
            background: #7200ff;
            color: white;
            padding: 14px;
            text-align: left;
        }

        .rating-table td {
            padding: 14px;
            border-bottom: 1px solid #eee;
        }

        .rating-table tr:hover {
            background: #f5f7ff;
        }

        .rating-table td:nth-child(3) {
            font-weight: bold;
            color: #ffb400;
        }

        /* ===== BACK BUTTON ===== */

        .back-dashboard {
            display: inline-block;
            margin-bottom: 20px;
            background: #004aad;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
        }

        .back-dashboard:hover {
            opacity: .85;
        }
    </style>
</head>

<body>
    <div class="admin-rating-page">

        <a href="Dashboard.php" class="back-dashboard">⬅ Kembali ke Dashboard</a>

        <div class="admin-rating-box">

            <h1>Daftar User yang Memberi Rating</h1>
            <table class="rating-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Rating</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>

                    <?php $no = 1;
                    while ($row = mysqli_fetch_assoc($query)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama']) ?></td>
                            <td>⭐ <?= $row['rating'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                        </tr>
                    <?php endwhile; ?>

                </tbody>
            </table>
            </section>
        </div>
    </div>

</body>

</html>
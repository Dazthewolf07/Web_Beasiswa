<?php
session_start();
include '../koneksi.php';
include 'NavbarAdmin.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM beasiswa ORDER BY id DESC");
?>

<head>
    <style>
        /* ===== RESET DASAR ===== */
        * {
            box-sizing: border-box;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            margin: 0;
            background: linear-gradient(90deg, #2ceaaa 0%, #0052ff 100%);
        }

        .main-wrapper {
            padding: 40px;
        }

        /* ===== CONTAINER ===== */
        .kelola-container {
            max-width: 1200px;
            margin: auto;
            background: white;
            text-align: center;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
        }

        /* ===== JUDUL ===== */
        .kelola-container h2 {
            text-align: center;
            font-size: 32px;
            margin-bottom: 25px;
            font-weight: 800;
        }

        /* ===== TABEL ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
            border-radius: 16px;
        }

        /* header */
        table th {
            background: linear-gradient(90deg, #7200ff, #0040cc);
            color: white;
            padding: 14px;
            text-align: center;
            font-size: 15px;
        }

        /* isi */
        table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        /* row hover */
        table tr:hover {
            background: #f7f9ff;
        }

        /* ===== GAMBAR ===== */
        table img {
            width: 90px;
            height: 65px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, .15);
        }

        /* ===== BUTTON ===== */
        .btn-edit,
        .btn-hapus {
            padding: 7px 14px;
            border-radius: 8px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            font-size: 13px;
        }

        .btn-edit {
            background: #2ceaaa;
            color: black;
        }

        .btn-hapus {
            background: #ff4d4d;
            color: white;
        }

        .btn-edit:hover {
            background: #1ec99a;
        }

        .btn-hapus:hover {
            background: #e63939;
        }

        /* ===== BACK BUTTON ===== */
        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            background: #7200ff;
            color: white;
            padding: 10px 22px;
            border-radius: 10px;
            font-weight: 700;
        }

        .back-btn:hover {
            background: #5a00cc;
        }

        /* ===== RESPONSIVE ===== */
        @media(max-width:900px) {
            table {
                font-size: 13px;
            }

            table img {
                width: 70px;
                height: 55px;
            }
        }
    </style>

</head>

<h2>Kelola Beasiswa</h2>

<table>
    <tr>
        <th>Gambar</th>
        <th>Judul</th>
        <th>Penyelenggara</th>
        <th>Dana</th>
        <th>Kuota</th>
        <th>Deadline</th>
        <th>Aksi</th>
    </tr>

    <?php while ($b = mysqli_fetch_assoc($data)) { ?>

        <tr>
            <td><img src="../uploads/<?= $b['image'] ?>"></td>
            <td><?= $b['title'] ?></td>
            <td><?= $b['provider'] ?></td>
            <td><?= number_format($b['amount']) ?></td>
            <td><?= $b['quota'] ?></td>
            <td><?= $b['deadline'] ?></td>
            <td>
                <a href="EditBeasiswa.php?id=<?= $b['id'] ?>">Edit</a> |
                <a href="HapusBeasiswa.php?id=<?= $b['id'] ?>"
                    onclick="return confirm('Hapus data?')">Hapus</a>
            </td>
        </tr>

    <?php } ?>

</table>
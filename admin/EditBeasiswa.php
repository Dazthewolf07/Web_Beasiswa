<?php
session_start();
include '../koneksi.php';

/* ===== CEK ADMIN ===== */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../Login.php");
    exit;
}

/* ================== PROSES UPDATE ================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'];
    $title = $_POST['title'];
    $provider = $_POST['provider'];
    $quota = $_POST['quota'];
    $deadline = $_POST['deadline'];
    $description = $_POST['description'];

    if (!empty($_FILES['gambar']['name'])) {

        $namaFile = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp, "../uploads/$namaFile");

        $query = "UPDATE beasiswa SET
                    title='$title',
                    provider='$provider',
                    quota='$quota',
                    deadline='$deadline',
                    description='$description',
                    image='$namaFile'
                  WHERE id='$id'";
    } else {

        $query = "UPDATE beasiswa SET
                    title='$title',
                    provider='$provider',
                    quota='$quota',
                    deadline='$deadline',
                    description='$description'
                  WHERE id='$id'";
    }

    mysqli_query($koneksi, $query);

    header("Location: KelolaBeasiswa.php");
    exit;
}

/* ===== AMBIL DATA UNTUK FORM ===== */
if (!isset($_GET['id'])) {
    header("Location: KelolaBeasiswa.php");
    exit;
}

$id = $_GET['id'];

$data = mysqli_query($koneksi, "SELECT * FROM beasiswa WHERE id='$id'");
$beasiswa = mysqli_fetch_assoc($data);

if (!$beasiswa) {
    header("Location: KelolaBeasiswa.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Beasiswa</title>

    <style>
        /* ==== STYLE FORM ==== */
        body {
            margin: 0;
            background: linear-gradient(90deg, #2ceaaa, #0052ff);
            padding: 40px;
            font-family: Segoe UI;
        }

        .form-box {
            max-width: 700px;
            background: white;
            margin: auto;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 800;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-weight: 700;
            display: block;
            margin-bottom: 6px;
        }

        input,
        textarea {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        input:focus,
        textarea:focus {
            outline: none;
            border-color: #7200ff;
        }

        /* preview */
        .preview-img {
            margin-top: 10px;
        }

        .preview-img img {
            width: 140px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, .2);
        }

        /* button */
        .btn-submit {
            background: #7200ff;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #5a00cc;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            background: #2ceaaa;
            padding: 8px 18px;
            border-radius: 10px;
            font-weight: 700;
            color: black;
            text-decoration: none;
        }
    </style>

</head>

<body>

    <div class="form-box">

        <a href="KelolaBeasiswa.php" class="back-btn">⬅ Kembali</a>

        <h2>Edit Beasiswa</h2>

        <form method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $beasiswa['id']; ?>">

            <div class="form-group">
                <label>Nama Beasiswa</label>
                <input type="text" name="title"
                    value="<?= htmlspecialchars($beasiswa['title']); ?>">
            </div>

            <div class=" form-group">
                <label>Penyelenggara</label>
                <input type="text" name="provider" value="<?= htmlspecialchars($beasiswa['provider']); ?>">
            </div>

            <div class=" form-group">
                <label>Jumlah Kuota</label>
                <input type="number" name="quota" value="<?= $beasiswa['quota']; ?>">

                <div class=" form-group">
                    <label>Deadline</label>
                    <input type="date" name="deadline" value="<?= $beasiswa['deadline']; ?>">
                </div>

                <div class=" form-group">
                    <label>Keterangan</label>
                    <textarea name="description">
                <?= htmlspecialchars($beasiswa['description']); ?></textarea>

                    <div class="form-group">
                        <label>Gambar (opsional)</label>
                        <input type="file" name="gambar">

                        <div class="preview-img">
                            <img src="../uploads/<?= $beasiswa['image']; ?>">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">💾 Simpan Perubahan</button>
                </div>

</body>

</html>
<?php
include 'koneksi.php';
include 'navbar.php';
$result = mysqli_query($koneksi, "SELECT * FROM beasiswa ORDER BY deadline ASC");

while ($row = mysqli_fetch_assoc($result)) {
?>
    <div class="beasiswa-card">

        <img src="uploads/<?= $row['image']; ?>" width="100%">

        <h3><?= $row['title']; ?></h3>

        <p><?= $row['description']; ?></p>

        <small>Penyelenggara: <?= $row['provider']; ?></small>

        <p>Dana: Rp <?= number_format($row['amount']); ?></p>

        <p>Kuota: <?= $row['quota']; ?></p>

        <p>Deadline: <?= $row['deadline']; ?></p>

    </div>
<?php } ?>



<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Beasiswa - Web Beasiswa</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      /* ==== Tambahan CSS Dropdown ==== */
      .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #004aad;
        color: black;
        padding: 10px 20px;
      }

      .navbar a {
        color: black;
        text-decoration: none;
        margin: 0 10px;
        font-weight: 500;
      }

      .navbar-menu {
        display: flex;
        align-items: center;
        position: relative;
      }

      .btn-daftar {
        background-color: #7200ff;
        padding: 8px 22.4px;
        border-radius: 8px;
        color: white;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.3s ease;
      }

      /* ==== Konten Beasiswa ==== */
      .beasiswa-section {
        padding: 60px 20px;
        text-align: center;
      }

      .beasiswa-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 40px;
      }

      .beasiswa-card {
        background-color: grey;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: left;
      }

      .beasiswa-card h3 {
        margin-top: 0;
        color: #004aad;
      }

      .beasiswa-card p {
        color: #555;
      }
    </style>
  </head>

  <body>
  
    <!-- ===== Konten Halaman Beasiswa ===== -->
    <section class="beasiswa-section">
      <h1>Daftar Beasiswa yang Tersedia</h1>
      <p>Temukan berbagai peluang beasiswa yang sesuai dengan minat dan kebutuhanmu.</p>

      <div class="beasiswa-list">
        <div class="beasiswa-card" id="na">
          <h3>Beasiswa SMA/SMK</h3>
          <p>Program beasiswa yang diselenggarakan oleh pemerintah Indonesia untuk siswa SMA/SMK</p>
        </div>

        <div class="beasiswa-card" id="S1">
          <h3>Beasiswa S1</h3>
          <p>Program beasiswa yang disenggarakan oleh pemerintah bersama dengan ptn Indonesia untuk Mahasiswa yang baru lulus SMA/SMK</p>
        </div>
      </div>
    </section>
  </body>
</html>

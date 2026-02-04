<?php
session_start();
include 'koneksi.php';
include 'Navbar.php';

$result = mysqli_query($koneksi, "SELECT * FROM beasiswa ORDER BY deadline ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <style>
    /* ================= PAGE BACKGROUND ================= */
    body {
      background: linear-gradient(90deg, #2ceaaa 0%, #0052ff 100%);
      margin: 0;
      font-family: Arial, sans-serif;
    }

    /* ================= SECTION ================= */
    .beasiswa-section {
      padding: 80px 60px;
      max-width: 1300px;
      margin: auto;
    }

    .beasiswa-section h2 {
      font-family: Arial, Helvetica, sans-serif;
      text-align: center;
      font-size: 36px;
      margin-bottom: 40px;
      color: black;
    }

    /* ================= GRID ================= */
    .beasiswa-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }

    /* ================= CARD ================= */
    .beasiswa-card {
      background: white;
      border-radius: 18px;
      overflow: hidden;
      box-shadow: 0 8px 22px rgba(0, 0, 0, .08);
      transition: .3s ease;
      display: flex;
      flex-direction: column;
    }

    .beasiswa-card:hover {
      transform: translateY(-6px);
    }

    /* ================= IMAGE ================= */
    .beasiswa-img {
      width: 100%;
      height: 150px;
      object-fit: contain;
      background: #f3f4f6;
      padding: 10px;
    }

    /* ================= CONTENT ================= */
    .beasiswa-card h3 {
      padding: 18px 20px 5px;
      margin: 0;
      font-size: 20px;
    }

    .beasiswa-card .desc {
      padding: 0 20px;
      font-size: 14px;
      color: #555;
    }

    .beasiswa-card small {
      padding: 8px 20px;
      color: #777;
    }

    /* ================= INFO ROW ================= */
    .beasiswa-card .info {
      display: flex;
      justify-content: space-between;
      padding: 12px 20px;
      font-weight: 600;
    }

    /* ================= DEADLINE ================= */
    .deadline {
      padding: 12px 20px 18px;
      font-weight: bold;
      color: #e03a3a;
    }

    /* ================= RESPONSIVE ================= */
    @media(max-width:768px) {
      .beasiswa-section {
        padding: 60px 20px;
      }
    }
  </style>
</head>

<body>

  <!-- 🔽 BAGIAN PERTAMA MASUK DI SINI -->
  <div class="beasiswa-section">
    <h2>Daftar Beasiswa</h2>

    <div class="beasiswa-list">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="beasiswa-card">

          <img class="beasiswa-img" src="uploads/<?= $row['image']; ?>" alt="<?= $row['title']; ?>">

          <h3><?= $row['title']; ?></h3>

          <p class="desc"><?= $row['description']; ?></p>

          <small>Penyelenggara: <?= $row['provider']; ?></small>

          <div class="info">
            <span>Dana: Rp <?= number_format($row['amount']); ?></span>
            <span>Kuota: <?= $row['quota']; ?></span>
          </div>

          <p class="deadline">📅 <?= $row['deadline']; ?></p>

        </div>
      <?php } ?>
    </div>
  </div>

</body>

</html>
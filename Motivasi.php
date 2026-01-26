<?php
include 'koneksi.php';
include 'Navbar.php'; 

?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Motivasi - Web Beasiswa</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      /* ==== Navbar (disesuaikan dari halaman utama) ==== */
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
      }

      .btn-daftar {
        background-color: #7200ff;
        padding: 8px 16px;
        border-radius: 8px;
        color: white;
        font-weight: 600;
        text-decoration: none;
      }

      /* ==== Konten Motivasi ==== */
      .motivasi-section {
        padding: 60px 20px;
        text-align: center;
      }

      .motivasi-section h1 {
        color: #004aad;
        margin-bottom: 10px;
      }

      .motivasi-section p {
        color: #555;
        max-width: 700px;
        margin: 0 auto 30px;
      }

      .quote-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-top: 40px;
      }

      .quote-card {
        background-color: #f9f9f9;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 30px 20px;
        text-align: center;
        font-style: italic;
        color: #333;
      }

      .quote-author {
        margin-top: 10px;
        font-weight: bold;
        color: #004aad;
      }
    </style>
  </head>

  <body>
   
    <!-- ===== Konten Halaman Motivasi ===== -->
    <section class="motivasi-section">
      <h1>Motivasi untuk Meraih Beasiswa</h1>
      <p>Setiap langkah kecil yang kamu ambil hari ini bisa membawamu lebih dekat pada mimpi besar. Jangan pernah menyerah, karena peluang besar datang bagi mereka yang terus berusaha.</p>

      <div class="quote-list">
        <div class="quote-card">
          “Pendidikan adalah senjata paling ampuh yang bisa kamu gunakan untuk mengubah dunia.”
          <div class="quote-author">— Nelson Mandela</div>
        </div>

        <div class="quote-card">
          “Jangan takut gagal. Gagal hanyalah batu loncatan menuju kesuksesan yang lebih besar.”
          <div class="quote-author">— Thomas A. Edison</div>
        </div>

        <div class="quote-card">
          “Kerja keras mengalahkan bakat ketika bakat tidak bekerja keras.”
          <div class="quote-author">— Tim Notke</div>
        </div>

        <div class="quote-card">
          “Jika kamu tidak bisa terbang, berlarilah. Jika tidak bisa berlari, berjalanlah. Jika tidak bisa berjalan, merangkaklah. Tapi apapun yang kamu lakukan, teruslah bergerak maju.”
          <div class="quote-author">— Martin Luther King Jr.</div>
        </div>
      </div>
    </section>
  </body>
</html>

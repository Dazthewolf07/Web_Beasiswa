<?php
session_start();
include 'koneksi.php';
include 'Navbar.php';

$user_id = $_SESSION['id'] ?? null;
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {

  $rating = intval($_POST['rating']);

  if ($rating >= 1 && $rating <= 5) {

    $stmt = mysqli_prepare(
      $koneksi,
      "INSERT INTO penilaian (user_id, rating) VALUES (?, ?)"
    );

    mysqli_stmt_bind_param($stmt, "ii", $user_id, $rating);
    mysqli_stmt_execute($stmt);

    $success = "Terima kasih atas penilaian Anda!";
  }
}

$avg = mysqli_query(
  $koneksi,
  "SELECT ROUND(AVG(rating),1) as rata FROM penilaian"
);

$dataAvg = mysqli_fetch_assoc($avg);
?>


<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Tentang kita - Web Beasiswa</title>
  <link rel="stylesheet" href="Style.css" />
  <style>
    /* ===== REVIEW SECTION ===== */

    .review-section {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      padding: 90px 8%;
      background: linear-gradient(135deg, #f5f9ff, #eef3ff);
    }

    .review-left small {
      color: #4f7cff;
      font-weight: 600;
      letter-spacing: 1px;
    }

    .review-left h2 {
      font-size: 40px;
      margin: 10px 0 20px;
    }

    .rating-summary {
      margin-top: 15px;
      font-size: 18px;
      background: rgba(79, 124, 255, 0.1);
      display: inline-block;
      padding: 8px 16px;
      border-radius: 12px;
    }

    .review-right {
      background: white;
      padding: 40px;
      border-radius: 25px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, .08);
    }

    /* ===== FORM ===== */

    .review-form label {
      font-weight: 600;
      display: block;
      margin-bottom: 10px;
    }

    .star-select {
      display: flex;
      gap: 10px;
      font-size: 34px;
      margin-bottom: 25px;
    }

    .star-select input {
      display: none;
    }

    .star-select label {
      cursor: pointer;
      color: #ccc;
      transition: .2s;
    }

    .star-select input:checked~label,
    .star-select label:hover,
    .star-select label:hover~label {
      color: gold;
    }

    /* ===== BUTTON ===== */

    .review-btn {
      background: #4f7cff;
      color: white;
      padding: 12px 30px;
      border-radius: 25px;
      border: none;
      font-weight: 600;
      cursor: pointer;
      transition: .3s;
    }

    .review-btn:hover {
      background: #365fe0;
    }

    /* ===== MESSAGE ===== */

    .success-msg {
      color: green;
      margin-bottom: 15px;
    }

    .login-note {
      color: #777;
    }

    /* ===== RESPONSIVE ===== */

    @media (max-width: 768px) {
      .review-section {
        grid-template-columns: 1fr;
      }

      .review-left h2 {
        font-size: 32px;
      }
    }
  </style>
</head>

<body>

  <section class="hero" aria-label="Banner utama dengan gambar pribadi atau latar belakang inspiratif">
    <div class="hero-content">
      <p class="hero-welcome">Selamat datang di Web Beasiswa saya:</p>
      <h1 class="hero-title">Tentang saya:</h1>
      <p class="bio-text">
        Halo! Saya Arya Nugraha Al Gizhwan, seorang pengembang web dengan passion untuk menciptakan hal-hal inovatif. Saya telah menempuh perjalanan Sekolah Menegah Kejuruan selama 3 tahun terakhir. Di sini, saya berbagi cerita,
        pengalaman, dan inspirasi saya untuk membantu orang lain mencapai potensi maksimal dan mendapatkan beasiswa mereka.
      </p>
    </div>
  </section>

  <section class="why-choose" aria-labelledby="why-choose-title">
    <div class="why-left">
      <small>Alasan yang tak membuatmu ragu</small>
      <h2 id="why-choose-title">
        Mengapa memilih <br />
        Web Beasiswa?
      </h2>
    </div>
    <div class="why-right">
      <div class="feature" tabindex="0" aria-label="Fitur akses mudah: Materi, tugas, dan feedback tersimpan rapi">
        <div class="icon-circle" aria-hidden="true">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M3 13h2v-2H3v2zm0-4h2V7H3v2zm0 8h2v-2H3v2zM7 13h11v-2H7v2zm0-4h11V7H7v2zm0 8h11v-2H7v2z" />
          </svg>
        </div>
        <div class="feature-text">
          <div class="feature-title">Easy Access</div>
          <div class="feature-desc">Materi, tugas, dan feedback tersimpan rapi</div>
        </div>
      </div>
      <div class="feature" tabindex="0" aria-label="Fitur evaluasi kinerja: Pemberian evaluasi akhir belajar">
        <div class="icon-circle" aria-hidden="true">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M17 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7l-4-4zM7 19v-1h6v1H7zm4-5H7v-2h4v2zm0-4H7V8h4v2z" />
          </svg>
        </div>
        <div class="feature-text">
          <div class="feature-title">Evaluation Performance</div>
          <div class="feature-desc">Pemberian evaluasi akhir belajar</div>
        </div>
      </div>
    </div>
  </section>

  <section class="review-section">
    <div class="review-left">
      <small>Penilaian Pengunjung</small>
      <h2>Beri Review Singkat<br>untuk Web Beasiswa</h2>

      <div class="rating-summary">
        ⭐ Rating rata-rata:
        <strong><?= $dataAvg['rata'] ?? '0' ?>/5</strong>
      </div>
    </div>

    <div class="review-right">

      <?php if (!empty($success)): ?>
        <p class="success-msg"><?= $success ?></p>
      <?php endif; ?>

      <?php if ($user_id): ?>
        <form method="POST" class="review-form">

          <label>Rating</label>
          <div class="star-select">
            <input type="radio" id="star5" name="rating" value="5" required>
            <label for="star5">★</label>

            <input type="radio" id="star4" name="rating" value="4">
            <label for="star4">★</label>

            <input type="radio" id="star3" name="rating" value="3">
            <label for="star3">★</label>

            <input type="radio" id="star2" name="rating" value="2">
            <label for="star2">★</label>

            <input type="radio" id="star1" name="rating" value="1">
            <label for="star1">★</label>
          </div>

          <button type="submit" class="review-btn">Kirim Penilaian</button>
        </form>
      <?php else: ?>
        <p class="login-note">Silakan login untuk memberi review.</p>
      <?php endif; ?>

    </div>
  </section>
</body>

</html>
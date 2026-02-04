<?php
session_start();
include 'koneksi.php';
include 'Navbar.php'; // Pastikan koneksi database tersedia
date_default_timezone_set('Asia/Jakarta');

// Inisialisasi variabel
$alert_message = '';
$alert_type = '';
$email_value = '';

// Proses form jika metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email'] ?? '');
  $email_value = htmlspecialchars($email); // Untuk repopulate form

  // Validasi email
  if (empty($email)) {
    $alert_message = 'Email tidak boleh kosong!';
    $alert_type = 'error';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $alert_message = 'Format email tidak valid!';
    $alert_type = 'error';
  } else {
    // Cek email di database (hindari kebocoran informasi)
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Selalu tampilkan pesan sukses generik (best practice keamanan)
    $alert_message = 'Jika email terdaftar, link reset password telah dikirim ke inbox/spam Anda.';
    $alert_type = 'success';

    // Jika email ditemukan, proses reset token
    if ($result->num_rows > 0) {
      $token = bin2hex(random_bytes(32)); // Token acak 64 karakter
      $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

      // Simpan token ke database
      $stmt_reset = $conn->prepare("INSERT INTO password_resets (email, token, expiry) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token=?, expiry=?");
      $stmt_reset->bind_param("sssss", $email, $token, $expiry, $token, $expiry);

      if ($stmt_reset->execute()) {

        // redirect langsung (DEV MODE)
        header("Location: /TugasAkhir/ResetPassword.php?email=" . urlencode($email) . "&token=$token");
        exit;

        // email tetap dikirim jika mau
        @mail($email, $subject, $message, $headers);
      }
      $stmt_reset->close();
    }
    $stmt->close();
  }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Lupa Kata Sandi - Web Beasiswa</title>
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

    /* ================= HERO ================= */
    .hero {
      position: relative;
      background-image: url(BackgroundImage.jpeg);
      background-size: cover;
      background-position: center;
      color: white;
      padding: 80px 16px 64px;
      display: flex;
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
    }

    .hero-content {
      position: relative;
      z-index: 1;
      max-width: 650px;
      width: 100%;
    }

    .hero-welcome {
      font-weight: 600;
      font-size: 17.6px;
    }

    .hero-title {
      font-size: 44.8px;
      font-weight: 900;
      margin-bottom: 20px;
    }

    /* ================= FORGOT FORM ================= */
    .forgot-form {
      background: rgba(255, 255, 255, 0.95);
      padding: 32px;
      border-radius: 20px;
      color: #111;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
    }

    .forgot-form h2 {
      margin-top: 0;
      font-size: 22px;
      font-weight: 800;
    }

    .form-group {
      margin-bottom: 18px;
    }

    .form-group label {
      font-weight: 600;
      display: block;
      margin-bottom: 6px;
    }

    .forgot-input {
      width: 100%;
      padding: 12px 16px;
      border-radius: 30px;
      border: 1px solid #ccc;
      font-size: 15px;
    }

    .forgot-input:focus {
      outline: none;
      border-color: #7200ff;
    }

    /* Button */
    .forgot-button {
      width: 100%;
      background: linear-gradient(90deg, #7200ff, #0040cc);
      border: none;
      border-radius: 30px;
      padding: 12px;
      color: white;
      font-weight: 700;
      cursor: pointer;
      transition: transform .2s ease, background .3s;
    }

    .forgot-button:hover {
      transform: translateY(-2px);
      background: linear-gradient(90deg, #5a00cc, #002fa8);
    }

    .forgot-links {
      text-align: center;
      margin-top: 14px;
    }

    .forgot-links a {
      font-weight: 600;
      color: #0052ff;
    }

    /* ================= ALERT ================= */
    .alert {
      padding: 14px;
      border-radius: 10px;
      margin-bottom: 18px;
      font-weight: 600;
    }

    .alert-success {
      background: #d1fae5;
      color: #065f46;
    }

    .alert-error {
      background: #fee2e2;
      color: #991b1b;
    }

    /* ================= WHY CHOOSE ================= */
    .why-choose {
      display: grid;
      grid-template-columns: 1fr 1fr;
      max-width: 1200px;
      margin: 64px auto;
      border-radius: 32px;
      overflow: hidden;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    .why-left {
      background: linear-gradient(90deg, #2ceaaa, #0052ff);
      padding: 48px 32px;
      font-weight: 700;
    }

    .why-left h2 {
      margin-top: 14px;
      font-size: 32px;
    }

    .why-right {
      background: linear-gradient(90deg, #7200ff, #0040cc);
      padding: 48px 32px;
      color: white;
      display: flex;
      flex-direction: column;
      gap: 28px;
    }

    .feature {
      display: flex;
      gap: 16px;
    }

    .icon-circle {
      background: white;
      border-radius: 50%;
      width: 35px;
      height: 35px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .icon-circle svg {
      width: 20px;
      height: 20px;
      fill: #7200ff;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width:900px) {
      .why-choose {
        grid-template-columns: 1fr;
        margin: 40px 16px;
      }
    }

    @media (max-width:600px) {
      .hero-title {
        font-size: 30px;
      }

      .forgot-form {
        padding: 22px;
      }
    }
  </style>
</head>

<body>
  <?php include 'Navbar.php'; ?> <!-- Dipindah ke dalam body (struktur HTML valid) -->

  <section class="hero" aria-label="Halaman lupa kata sandi dengan gambar latar belakang">
    <div class="hero-content">
      <p class="hero-welcome">Pulihkan akses akun Anda di Web Beasiswa:</p>
      <h1 class="hero-title">Lupa Kata Sandi?</h1>

      <!-- Alert ditampilkan berdasarkan kondisi PHP -->
      <?php if ($alert_message): ?>
        <div id="alertBox" class="alert alert-<?php echo $alert_type; ?>" style="display:block;">
          <?php echo htmlspecialchars($alert_message); ?>
        </div>
      <?php endif; ?>

      <form method="POST" role="form" aria-label="Form lupa kata sandi">
        <h2>Pulihkan Kata Sandi Anda</h2>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            class="forgot-input"
            placeholder="Masukkan email Anda"
            aria-label="Email untuk reset kata sandi"
            name="email"
            value="<?php echo $email_value; ?>"
            required />
        </div>
        <button type="submit" class="forgot-button" aria-label="Kirim permintaan reset kata sandi">KIRIM PERMINTAAN</button>
        <div class="forgot-links">
          <a href="Login.php" aria-label="Kembali ke halaman login">Kembali ke Login</a>
        </div>
      </form>
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
      <div class="feature" tabindex="0" aria-label="Akses mudah: Materi, tugas, dan feedback tersimpan rapi">
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
      <div class="feature" tabindex="0" aria-label="Evaluasi kinerja: Pemberian evaluasi akhir belajar">
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

  <!-- Auto-hide alert sukses (hanya jika ada pesan sukses) -->
  <?php if ($alert_type === 'success' && $alert_message): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
          const alertBox = document.getElementById('alertBox');
          if (alertBox) alertBox.style.display = 'none';
        }, 5000);
      });
    </script>
  <?php endif; ?>
</body>

</html>
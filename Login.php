<?php
session_start();
include 'koneksi.php';
include 'navbar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = mysqli_query(
    $koneksi,
    "SELECT * FROM users WHERE email='$email'"
  );

  if (!$query) {
    die(mysqli_error($koneksi));
  }

  if (mysqli_num_rows($query) === 1) {

    $row = mysqli_fetch_assoc($query);

    if (password_verify($password, $row['password'])) {

      $_SESSION['login'] = true;
      $_SESSION['nama'] = $row['nama'];
      $_SESSION['id'] = $row['id'];
      $_SESSION['role'] = $row['role'];

      if ($row['role'] == 'admin') {
        header("Location: admin/Dashboard.php");
      } else {
        header("Location: index.php");
      }
      exit;
    } else {
      echo "Password salah!";
    }
  } else {
    echo "Email tidak ditemukan!";
  }
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login - Web Beasiswa</title>
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

  <section class="hero" aria-label="Halaman login dengan gambar latar belakang">
    <div class="hero-content">
      <p class="hero-welcome">Selamat datang kembali di Web Beasiswa Saya:</p>
      <h1 class="hero-title">Masuk ke Akun Kamu</h1>
      <form class="login-form" method="POST" action="" role="form" aria-label="Form login">
        <h2>Masuk dengan Akun Anda</h2>
        <div class="form-group">
          <label for="email">Email atau Username</label>
          <input type="text" id="email" class="login-input" placeholder="Masukkan email atau username" aria-label="Email atau Username" name="email" required />
        </div>
        <div class="form-group">
          <label for="password">Kata Sandi</label>
          <input type="password" id="password" class="login-input" placeholder="Masukkan kata sandi" aria-label="Kata Sandi" name="password" required />
          <div style="display: flex;">
            <input type="checkbox" onclick="myFunction()">
            <div style="color:#000">Show Password</div>
          </div>
        </div>
        <button type="submit" class="login-button" aria-label="Masuk ke akun">MASUK</button>
        <div class="login-links">
          <a href="ForgotPassword.php" aria-label="Lupa kata sandi?">Lupa kata sandi?</a> |
          <a href="SignIn.php" aria-label="Belum punya akun? Daftar sekarang">Belum punya akun? Daftar</a>
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
</body>

<script>
  function myFunction() {
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
</script>

</html>
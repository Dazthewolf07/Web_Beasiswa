
<?php
include 'koneksi.php';
include 'Navbar.php'; 

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
        padding: 0.8rem 1rem;
        position: sticky;
        top: 0;
        z-index: 100;
        flex-wrap: wrap;
      }

      .navbar-left {
        font-weight: 700;
        color: #000;
        font-size: 1.1rem;
      }

      .navbar-menu {
        display: flex;
        align-items: center;
        gap: 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        color: #000;
      }

      .navbar-menu .dropdown {
        position: relative;
        cursor: pointer;
      }

      .navbar-menu .dropdown span::after {
        content: "▼";
        margin-left: 0.3rem;
        font-size: 0.7rem;
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
        padding: 0.5rem 1.4rem;
        border-radius: 0.5rem;
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

      /* Hero Section - Adapted for Forgot Password */
      .hero {
        position: relative;
        background-image: url(BackgroundImage.jpeg);
        background-size: cover;
        background-position: center;
        color: white;
        padding: 5rem 1rem 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
        border-radius: 0 0 2rem 2rem;
        min-height: 60vh;
      }

      .hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        border-radius: 0 0 2rem 2rem;
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
        font-size: 1.1rem;
        margin-bottom: 0.6rem;
      }

      .hero-title {
        font-size: 2.8rem;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 2rem;
      }

      .forgot-form {
        background: rgba(255, 255, 255, 0.95);
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
      }

      .forgot-form h2 {
        margin: 0 0 1.5rem 0;
        color: #111;
        font-size: 1.5rem;
      }

      .form-group {
        margin-bottom: 1rem;
      }

      .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #333;
      }

      .forgot-input {
        width: 100%;
        padding: 0.8rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #ddd;
        font-size: 1rem;
        transition: border-color 0.3s ease;
      }

      .forgot-input:focus {
        outline: none;
        border-color: #7200ff;
      }

      .forgot-button {
        background-color: #7200ff;
        border: none;
        border-radius: 0.5rem;
        color: white;
        font-weight: 700;
        padding: 0.8rem 2rem;
        cursor: pointer;
        font-size: 1rem;
        width: 100%;
        transition: background-color 0.3s ease;
      }
      .forgot-button:hover,
      .forgot-button:focus {
        background-color: #5a00cc;
        outline: none;
      }

      .forgot-links {
        text-align: center;
        margin-top: 1rem;
      }

      .forgot-links a {
        color: #7200ff;
        font-size: 0.9rem;
        text-decoration: underline;
      }

      /* Why Choose Section - Repurposed for Forgot Password Benefits */
      .why-choose {
        display: grid;
        grid-template-columns: 1fr 1fr;
        max-width: 1200px;
        margin: 4rem auto;
        border-radius: 0 0 2rem 2rem;
        overflow: hidden;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
      }

      .why-left {
        background: linear-gradient(90deg, #2ceaaa 0%, #0052ff 100%);
        padding: 3rem 2rem;
        color: #000;
        font-weight: 700;
        border-radius: 0 0 0 2rem;
      }

      .why-left small {
        font-weight: 400;
        font-size: 0.9rem;
      }

      .why-left h2 {
        margin-top: 1rem;
        font-size: 2rem;
        line-height: 1.15;
      }

      .why-right {
        background: linear-gradient(90deg, #7200ff 0%, #0040cc 100%);
        padding: 3rem 2rem;
        color: white;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        border-radius: 0 0 2rem 0;
      }

      .feature {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
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
        font-size: 1.1rem;
        margin-bottom: 0.2rem;
      }

      .feature-desc {
        font-weight: 400;
        font-size: 0.9rem;
      }

      /* Responsive */
      @media (max-width: 900px) {
        .why-choose {
          grid-template-columns: 1fr;
          border-radius: 2rem;
          margin: 3rem 1rem 4rem;
        }
        .why-left,
        .why-right {
          border-radius: 2rem;
          padding: 2rem 1.5rem;
        }
        .why-right {
          gap: 1.5rem;
        }
      }

      @media (max-width: 600px) {
        .navbar {
          justify-content: center;
          gap: 1rem;
        }
        .navbar-left {
          order: 1;
          flex-grow: 1;
          text-align: center;
        }
        .navbar-menu {
          order: 2;
          gap: 1.2rem;
          flex-wrap: wrap;
          justify-content: center;
          margin-top: 0.6rem;
        }
        .btn-daftar {
          order: 3;
          width: 100%;
          max-width: 160px;
          margin: 0.5rem auto 0;
          text-align: center;
        }
        .hero {
          padding: 3.5rem 1rem 3rem;
        }
        .hero-title {
          font-size: 1.9rem;
        }
        .forgot-form {
          padding: 1.5rem;
        }
      }
    </style>
  </head>
  <body>
    
    <section class="hero" aria-label="Halaman lupa kata sandi dengan gambar latar belakang">
      <div class="hero-content">
        <p class="hero-welcome">Pulihkan akses akun Anda di Web Beasiswa:</p>
        <h1 class="hero-title">Lupa Kata Sandi?</h1>
        <form class="forgot-form" method="POST" action="/forgot-password" role="form" aria-label="Form lupa kata sandi">
          <h2>Pulihkan Kata Sandi Anda</h2>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" class="forgot-input" placeholder="Masukkan email Anda" aria-label="Email untuk reset kata sandi" name="email" required />
          </div>
          <button onclick="" type="submit" class="forgot-button" aria-label="Kirim permintaan reset kata sandi">KIRIM PERMINTAAN</button>
          <div class="forgot-links">
            <a href="Login.php" aria-label="Kembali ke halaman login">Kembali ke Login</a>
          </div>
        </form>
      </div>
    </section>

    <
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
</html>

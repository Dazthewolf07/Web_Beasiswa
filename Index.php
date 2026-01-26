<?php
include 'koneksi.php';
include 'Navbar.php'; 
?>


<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Halaman Utama - Web Beasiswa</title>
    <link rel="stylesheet" href="style.css" />
  </head>

  <body>
   

    <section class="hero" aria-label="Banner utama dengan gambar tiga siswa menggunakan laptop dan buku">
      <div class="hero-content">
        <p class="hero-welcome">Selamat datang di Web Beasiswa Saya:</p>
        <h1 class="hero-title">Temukan Beasiswa Impian Kamu</h1>
        <form class="search-form" role="search" aria-label="Pencarian beasiswa">
          <input type="search" class="search-input" placeholder="Cari Beasiswa" aria-label="Input pencarian beasiswa" name="search" required />
          <button type="submit" class="search-button" aria-label="Mulai pencarian">CARI</button>
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
  </body>
</html>
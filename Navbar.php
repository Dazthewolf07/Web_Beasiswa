<?php

if (session_status() === PHP_SESSION_NONE)
?>

<nav class="navbar">
  <div class="navbar-left">Web Beasiswa</div>

  <div class="navbar-menu">
    <a href="Index.php">Home</a>
    <a href="AboutUs.php">About Us</a>
    <a href="Beasiswa.php">Beasiswa</a>
    <a href="Motivasi.php">Motivasi</a>
  </div>

  <div class="navbar-right">
    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
      <div class="user-box">
        <span class="user-name">
          👤 <?= htmlspecialchars($_SESSION['nama']); ?>
        </span>
        <a href="logout.php" class="btn-logout">Logout</a>
      </div>
    <?php else: ?>
      <a href="Login.php" class="btn-daftar">Login</a>
    <?php endif; ?>
  </div>
</nav>

<style>
  /* ================= NAVBAR ================= */
  .navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #0a57d5;
    padding: 14px 50px;
    position: sticky;
    top: 0;
    z-index: 999;
  }

  /* ================= LEFT ================= */
  .navbar-left {
    font-size: 22px;
    font-weight: bold;
    color: black;
  }

  /* ================= MENU ================= */
  .navbar-menu {
    display: flex;
    gap: 36px;
  }

  .navbar-menu a {
    color: black;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
    position: relative;
  }

  /* underline hover */
  .navbar-menu a::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 0;
    height: 2px;
    background: white;
    transition: .3s;
  }

  .navbar-menu a:hover::after {
    width: 100%;
  }

  /* ================= RIGHT ================= */
  .navbar-right {
    display: flex;
    align-items: center;
  }

  /* user login */
  .user-box {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .user-name {
    font-weight: 600;
    color: black;
  }

  /* ================= BUTTON ================= */
  .btn-daftar {
    background: linear-gradient(135deg, #7b00ff, #a100ff);
    padding: 8px 22px;
    border-radius: 10px;
    color: white;
    font-weight: 700;
    text-decoration: none;
    transition: .3s ease;
  }

  .btn-daftar:hover {
    opacity: .9;
    transform: scale(1.05);
  }

  .btn-logout {
    background: crimson;
    padding: 6px 16px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    font-weight: 600;
  }

  .btn-logout:hover {
    opacity: .85;
  }

  /* ================= RESPONSIVE ================= */
  @media(max-width:900px) {
    .navbar {
      padding: 14px 20px;
    }

    .navbar-menu {
      gap: 18px;
    }
  }

  @media(max-width:650px) {
    .navbar-menu {
      display: none;
    }
  }
</style>
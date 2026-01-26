<?php if (isset($_SESSION['login'])): ?>
  <span>Halo, <?= htmlspecialchars($_SESSION['nama']); ?></span>
  <a href="logout.php">Logout</a>
<?php endif; ?>
<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
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
      <a href="SignIn.php" class="btn-daftar">Daftar</a>
    <?php endif; ?>
  </div>
</nav>
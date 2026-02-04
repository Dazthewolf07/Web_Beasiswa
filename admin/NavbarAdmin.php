<?php
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<nav class="navbar admin-navbar">
    <div class="nav-logo">
        <a href="Dashboard.php">AdminPanel</a>
    </div>

    <ul class="nav-menu">
        <li><a href="Dashboard.php">Dashboard</a></li>
        <li><a href="KelolaBeasiswa.php">Kelola Beasiswa</a></li>
        <li><a href="AddBeasiswa.php">Tambah Beasiswa</a></li>
        <li><a href="Admin_Rating.php">Rating</a></li>
    </ul>

    <div class="nav-right">
        <span class="admin-name">
            <?= $_SESSION['nama']; ?>
        </span>
</nav>

<style>
    /* ================= ADMIN NAVBAR ================= */
    .admin-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #0a57d5;
        padding: 14px 50px;
        position: sticky !important;
        top: 0;
        z-index: 9999;
    }

    /* ================= LEFT ================= */
    .admin-navbar .nav-logo a {
        font-size: 22px;
        font-weight: bold;
        color: white;
        text-decoration: none;
    }

    /* ================= CENTER MENU ================= */
    .admin-navbar .nav-menu {
        list-style: none;
        display: flex;
        gap: 36px;
        margin: 0;
        padding: 0;
    }

    .admin-navbar .nav-menu a {
        color: #e5e7eb;
        text-decoration: none;
        font-weight: 500;
        font-size: 16px;
        position: relative;
    }

    /* underline hover */
    .admin-navbar .nav-menu a::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -6px;
        width: 0;
        height: 2px;
        background: #60a5fa;
        transition: .3s;
    }

    .admin-navbar .nav-menu a:hover::after {
        width: 100%;
    }

    /* ================= RIGHT ================= */
    .admin-navbar .nav-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .admin-name {
        background: rgba(255, 255, 255, 0.15);
        padding: 6px 14px;
        border-radius: 8px;
        font-weight: 600;
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(4px);
    }

    /* ================= RESPONSIVE ================= */
    @media(max-width:900px) {
        .admin-navbar {
            padding: 14px 20px;
        }

        .admin-navbar .nav-menu {
            gap: 18px;
        }
    }

    @media(max-width:650px) {
        .admin-navbar .nav-menu {
            display: none;
        }
    }
</style>
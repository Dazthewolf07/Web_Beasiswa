<?php
session_start();
include 'koneksi.php';
include 'Navbar.php';

$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';

$valid = false;

/* ===============================
   VALIDASI SAAT GET
================================ */
if ($email && $token) {
    $stmt = $conn->prepare(
        "SELECT * FROM password_resets
     WHERE email=? AND token=?"
    );
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $valid = true;
    }
}

/* ===============================
   PROSES RESET SAAT POST
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';

    // VALIDASI TOKEN LAGI (WAJIB)
    $stmt = $conn->prepare(
        "SELECT * FROM password_resets
      WHERE email=? AND token=?"
    );
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $check = $stmt->get_result();

    if ($check->num_rows !== 1) {
        die("Token tidak valid atau sudah kadaluarsa.");
    }

    // Hash password
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Update password user
    $stmt2 = $conn->prepare(
        "UPDATE users SET password=? WHERE email=?"
    );
    $stmt2->bind_param("ss", $hash, $email);
    $stmt2->execute();

    // Hapus token reset
    $stmt3 = $conn->prepare(
        "DELETE FROM password_resets WHERE email=?"
    );
    $stmt3->bind_param("s", $email);
    $stmt3->execute();

    echo "Password berhasil diubah. <a href='Login.php'>Login</a>";
    exit;
}
?>

<?php if ($valid): ?>
    <form method="POST">
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

    </form>
<?php else: ?>
    <p>Token tidak valid atau sudah kadaluarsa.</p>
<?php endif; ?>

<style>
    body {
        background: linear-gradient(90deg, #2ceaaa 0%, #0052ff 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
    }

    .reset-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .reset-card {
        background: white;
        padding: 32px;
        border-radius: 18px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .25);
    }

    .reset-card h2 {
        margin-top: 0;
        text-align: center;
        font-weight: 800;
    }

    .reset-input {
        width: 100%;
        padding: 12px 16px;
        border-radius: 25px;
        border: 1px solid #ccc;
        margin-bottom: 14px;
        font-size: 15px;
    }

    .reset-input:focus {
        outline: none;
        border-color: #7200ff;
    }

    .reset-btn {
        width: 100%;
        background: linear-gradient(90deg, #7200ff, #0040cc);
        border: none;
        border-radius: 25px;
        padding: 12px;
        color: white;
        font-weight: 700;
        cursor: pointer;
    }

    .reset-btn:hover {
        background: linear-gradient(90deg, #5a00cc, #002fa8);
    }
</style>

<div class="reset-container">
    <div class="reset-card">
        <h2>Reset Password</h2>

        <form method="POST">
            <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <input type="password"
                id="password"
                class="reset-input"
                name="password"
                required
                placeholder="Password baru">

            <button class="reset-btn">Reset Password</button>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:12px;">
                <input type="checkbox" onclick="myFunction()">
                <div style="color:#000;font-weight:600;">Show Password</div>
            </div>
        </form>
    </div>
</div>

<script>
    function myFunction() {
        const x = document.getElementById("password");
        if (!x) return;

        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
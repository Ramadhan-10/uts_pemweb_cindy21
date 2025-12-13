<?php
session_start(); // Wajib ada di baris paling atas
include 'includes/db.php';
include 'includes/header.php';

// Jika sudah login, langsung lempar ke dashboard (cegah akses halaman login lagi)
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

// LOGIKA LOGIN
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek Database
    $sql = "SELECT * FROM tabel_admin WHERE username = :username AND password = :password";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username, 'password' => $password]);
    $user = $stmt->fetch();

    if ($user) {
        // Login Berhasil
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php"); // Pindah ke halaman admin
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<div class="container" style="margin-top: 120px; margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white text-center py-3 rounded-top-4" style="background-color: #1a2c4e;">
                    <h4 class="mb-0 fw-bold"><i class="fa-solid fa-lock me-2"></i> Login Admin</h4>
                </div>

                <div class="card-body p-4">
                    
                    <?php if($error): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            <div><?= $error ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary">Username</label>
                            <input type="text" name="username" class="form-control form-control-lg fs-6" placeholder="Masukkan username" required autofocus>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg fs-6" placeholder="Masukkan password" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg fs-6 fw-bold" style="background-color: #1a2c4e; border: none;">
                                Masuk Dashboard
                            </button>
                        </div>
                    </form>
                    
                    <div class="text-center mt-4">
                        <a href="index.php" class="text-decoration-none small text-muted hover-underline">
                            &larr; Kembali ke Web Utama
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
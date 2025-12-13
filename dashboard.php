<?php
session_start();
// Cek keamanan: Jika belum login, tendang balik ke login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Dashboard Admin FDC</a>
        <div class="d-flex align-items-center text-white">
            <span class="me-3">Halo, <?= $_SESSION['username'] ?></span>
            <a href="logout.php" class="btn btn-danger btn-sm"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-primary"><i class="fa-solid fa-users"></i> Data Pendaftar Masuk</h5>
        </div>
        <div class="card-body">
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NIM</th>
                            <th>Jurusan</th>
                            <th>Divisi Pilihan</th>
                            <th>Tanggal Daftar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query mengambil data pendaftar dari yang terbaru
                        $stmt = $pdo->query("SELECT * FROM tabel_pendaftar ORDER BY id DESC");
                        $no = 1;
                        while ($row = $stmt->fetch()) {
                        ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="fw-bold"><?= $row['nama_lengkap'] ?></td>
                            <td><?= $row['nim'] ?></td>
                            <td><?= $row['jurusan'] ?></td>
                            <td>
                                <span class="badge bg-info text-dark"><?= $row['divisi_pilihan'] ?></span>
                            </td>
                            <td class="small text-muted"><?= $row['tanggal_daftar'] ?></td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php } ?>
                        
                        <?php if($no == 1): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data pendaftar.</td>
                            </tr>
                        <?php endif; ?>
                        
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
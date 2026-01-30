<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
include '../includes/db.php';

// Hitung statistik
$total_anggota = $pdo->query("SELECT COUNT(*) FROM tabel_anggota")->fetchColumn();
$total_pendaftar = $pdo->query("SELECT COUNT(*) FROM tabel_pendaftar")->fetchColumn();
$total_divisi = $pdo->query("SELECT COUNT(*) FROM tabel_divisi")->fetchColumn();
$pending = $pdo->query("SELECT COUNT(*) FROM tabel_pendaftar WHERE status='pending'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - FDC</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #1a2c4e 0%, #0d1a30 100%); }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: #fff; }
        .stat-card { border-radius: 15px; border: none; transition: transform 0.3s; }
        .stat-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 col-lg-10 px-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                <h1 class="h3 fw-bold text-primary"><i class="fa-solid fa-gauge-high me-2"></i>Dashboard Admin</h1>
                <span class="text-muted">Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</span>
            </div>
            
            <div class="row g-4 mb-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-white-50">Total Anggota</h6>
                                    <h2 class="mb-0 fw-bold"><?= $total_anggota ?></h2>
                                </div>
                                <i class="fa-solid fa-users fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-white-50">Total Pendaftar</h6>
                                    <h2 class="mb-0 fw-bold"><?= $total_pendaftar ?></h2>
                                </div>
                                <i class="fa-solid fa-user-plus fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-white-50">Total Divisi</h6>
                                    <h2 class="mb-0 fw-bold"><?= $total_divisi ?></h2>
                                </div>
                                <i class="fa-solid fa-sitemap fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card stat-card shadow-sm bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="text-dark opacity-75">Pending</h6>
                                    <h2 class="mb-0 fw-bold"><?= $pending ?></h2>
                                </div>
                                <i class="fa-solid fa-clock fa-2x opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-file-pdf text-danger me-2"></i>Generate Laporan PDF</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="laporan_pdf.php?type=pendaftar" class="btn btn-outline-danger w-100 py-3">
                                <i class="fa-solid fa-download me-2"></i>Laporan Pendaftar
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="laporan_pdf.php?type=anggota" class="btn btn-outline-danger w-100 py-3">
                                <i class="fa-solid fa-download me-2"></i>Laporan Anggota
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="laporan_pdf.php?type=divisi" class="btn btn-outline-danger w-100 py-3">
                                <i class="fa-solid fa-download me-2"></i>Laporan Divisi
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

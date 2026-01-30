<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }
include '../includes/db.php';

// Handle Delete
if (isset($_GET['hapus'])) {
    $stmt = $pdo->prepare("DELETE FROM tabel_divisi WHERE id = ?");
    $stmt->execute([$_GET['hapus']]);
    header("Location: divisi.php?msg=deleted"); exit;
}

// Handle Create/Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_divisi'];
    $desc = $_POST['deskripsi'];
    
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE tabel_divisi SET nama_divisi=?, deskripsi=? WHERE id=?");
        $stmt->execute([$nama, $desc, $_POST['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO tabel_divisi (nama_divisi, deskripsi) VALUES (?, ?)");
        $stmt->execute([$nama, $desc]);
    }
    header("Location: divisi.php?msg=saved"); exit;
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM tabel_divisi WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}

$divisi_list = $pdo->query("SELECT * FROM tabel_divisi ORDER BY id ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Divisi - FDC Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #1a2c4e 0%, #0d1a30 100%); }
        .sidebar .nav-link { color: rgba(255,255,255,0.8); padding: 12px 20px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: #fff; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include 'includes/sidebar.php'; ?>
        
        <main class="col-md-9 col-lg-10 px-4 py-4">
            <h1 class="h3 fw-bold text-primary mb-4"><i class="fa-solid fa-sitemap me-2"></i>Kelola Divisi</h1>
            
            <?php if(isset($_GET['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    Data berhasil diproses! <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3"><h5 class="mb-0"><?= $edit_data ? 'Edit' : 'Tambah' ?> Divisi</h5></div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Nama Divisi</label>
                                <input type="text" name="nama_divisi" class="form-control" value="<?= $edit_data['nama_divisi'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Deskripsi</label>
                                <input type="text" name="deskripsi" class="form-control" value="<?= $edit_data['deskripsi'] ?? '' ?>">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Simpan</button>
                            <?php if($edit_data): ?><a href="divisi.php" class="btn btn-secondary">Batal</a><?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr><th>No</th><th>Nama Divisi</th><th>Deskripsi</th><th>Aksi</th></tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($divisi_list as $row): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['nama_divisi']) ?></td>
                                <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                                <td>
                                    <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></a>
                                    <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus divisi ini?')"><i class="fa-solid fa-trash"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

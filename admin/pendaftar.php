<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }
include '../includes/db.php';

// Handle Delete
if (isset($_GET['hapus'])) {
    $stmt = $pdo->prepare("DELETE FROM tabel_pendaftar WHERE id = ?");
    $stmt->execute([$_GET['hapus']]);
    header("Location: pendaftar.php?msg=deleted"); exit;
}

// Handle Status Update
if (isset($_GET['status']) && isset($_GET['id'])) {
    $stmt = $pdo->prepare("UPDATE tabel_pendaftar SET status = ? WHERE id = ?");
    $stmt->execute([$_GET['status'], $_GET['id']]);
    header("Location: pendaftar.php?msg=updated"); exit;
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['id'])) {
    $stmt = $pdo->prepare("UPDATE tabel_pendaftar SET nama_lengkap=?, nim=?, email=?, jurusan=?, divisi_id=?, alasan_bergabung=? WHERE id=?");
    $stmt->execute([$_POST['nama'], $_POST['nim'], $_POST['email'], $_POST['jurusan'], $_POST['divisi_id'], $_POST['alasan'], $_POST['id']]);
    header("Location: pendaftar.php?msg=updated"); exit;
}

$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM tabel_pendaftar WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}

$pendaftar = $pdo->query("SELECT p.*, d.nama_divisi FROM tabel_pendaftar p 
    LEFT JOIN tabel_divisi d ON p.divisi_id = d.id ORDER BY p.id DESC")->fetchAll();
$divisi_list = $pdo->query("SELECT * FROM tabel_divisi WHERE id > 1")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar - FDC Admin</title>
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
            <h1 class="h3 fw-bold text-primary mb-4"><i class="fa-solid fa-user-plus me-2"></i>Data Pendaftar</h1>
            
            <?php if(isset($_GET['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    Data berhasil diproses! <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <?php if($edit_data): ?>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3"><h5 class="mb-0">Edit Pendaftar</h5></div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $edit_data['nama_lengkap'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">NIM</label>
                                <input type="text" name="nim" class="form-control" value="<?= $edit_data['nim'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= $edit_data['email'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control" value="<?= $edit_data['jurusan'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Divisi</label>
                                <select name="divisi_id" class="form-select" required>
                                    <?php foreach($divisi_list as $d): ?>
                                        <option value="<?= $d['id'] ?>" <?= $edit_data['divisi_id'] == $d['id'] ? 'selected' : '' ?>><?= $d['nama_divisi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alasan</label>
                                <textarea name="alasan" class="form-control"><?= $edit_data['alasan_bergabung'] ?></textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="pendaftar.php" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr><th>No</th><th>Nama</th><th>NIM</th><th>Email</th><th>Divisi</th><th>Status</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($pendaftar as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                                    <td><?= $row['nim'] ?></td>
                                    <td><?= $row['email'] ?></td>
                                    <td><span class="badge bg-info"><?= $row['nama_divisi'] ?></span></td>
                                    <td>
                                        <?php 
                                        $badge = ['pending'=>'warning','diterima'=>'success','ditolak'=>'danger'];
                                        echo '<span class="badge bg-'.$badge[$row['status']].'">'.$row['status'].'</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <a href="?status=diterima&id=<?= $row['id'] ?>" class="btn btn-sm btn-success" title="Terima"><i class="fa-solid fa-check"></i></a>
                                        <a href="?status=ditolak&id=<?= $row['id'] ?>" class="btn btn-sm btn-secondary" title="Tolak"><i class="fa-solid fa-times"></i></a>
                                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></a>
                                        <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')"><i class="fa-solid fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

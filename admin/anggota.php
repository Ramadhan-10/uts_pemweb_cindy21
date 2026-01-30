<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit; }
include '../includes/db.php';

$msg = '';

// Handle Delete
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    $stmt = $pdo->prepare("DELETE FROM tabel_anggota WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: anggota.php?msg=deleted");
    exit;
}

// Handle Create/Update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $divisi_id = $_POST['divisi_id'];
    
    if (!empty($_POST['id'])) {
        $stmt = $pdo->prepare("UPDATE tabel_anggota SET nama=?, jabatan=?, divisi_id=? WHERE id=?");
        $stmt->execute([$nama, $jabatan, $divisi_id, $_POST['id']]);
        $msg = 'updated';
    } else {
        $stmt = $pdo->prepare("INSERT INTO tabel_anggota (nama, jabatan, divisi_id) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $jabatan, $divisi_id]);
        $msg = 'created';
    }
    header("Location: anggota.php?msg=$msg");
    exit;
}

// Get data for edit
$edit_data = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM tabel_anggota WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $edit_data = $stmt->fetch();
}

// Fetch all
$anggota = $pdo->query("SELECT a.*, d.nama_divisi FROM tabel_anggota a 
    LEFT JOIN tabel_divisi d ON a.divisi_id = d.id ORDER BY a.id DESC")->fetchAll();
$divisi_list = $pdo->query("SELECT * FROM tabel_divisi")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Anggota - FDC Admin</title>
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
            <h1 class="h3 fw-bold text-primary mb-4"><i class="fa-solid fa-users me-2"></i>Kelola Anggota</h1>
            
            <?php if(isset($_GET['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    Data berhasil <?= $_GET['msg'] == 'deleted' ? 'dihapus' : ($_GET['msg'] == 'updated' ? 'diupdate' : 'ditambahkan') ?>!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0"><?= $edit_data ? 'Edit' : 'Tambah' ?> Anggota</h5>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?= $edit_data['nama'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" value="<?= $edit_data['jabatan'] ?? '' ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Divisi</label>
                                <select name="divisi_id" class="form-select" required>
                                    <?php foreach($divisi_list as $d): ?>
                                        <option value="<?= $d['id'] ?>" <?= ($edit_data['divisi_id'] ?? '') == $d['id'] ? 'selected' : '' ?>>
                                            <?= $d['nama_divisi'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-save me-2"></i>Simpan</button>
                            <?php if($edit_data): ?>
                                <a href="anggota.php" class="btn btn-secondary">Batal</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr><th>No</th><th>Nama</th><th>Jabatan</th><th>Divisi</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($anggota as $row): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td class="fw-bold"><?= htmlspecialchars($row['nama']) ?></td>
                                    <td><?= htmlspecialchars($row['jabatan']) ?></td>
                                    <td><span class="badge bg-info"><?= $row['nama_divisi'] ?></span></td>
                                    <td>
                                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-edit"></i></a>
                                        <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus anggota ini?')"><i class="fa-solid fa-trash"></i></a>
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

<?php 
include 'includes/db.php';
include 'includes/header.php'; 

// Get anggota from database grouped by divisi
$anggota_data = $pdo->query("SELECT a.*, d.nama_divisi FROM tabel_anggota a 
    LEFT JOIN tabel_divisi d ON a.divisi_id = d.id 
    ORDER BY d.id, a.id")->fetchAll();

// Group by divisi
$struktur = [];
foreach ($anggota_data as $row) {
    $divisi = $row['nama_divisi'] ?? 'Lainnya';
    if (!isset($struktur[$divisi])) {
        $struktur[$divisi] = [];
    }
    $struktur[$divisi][] = [
        'nama' => $row['nama'],
        'jabatan' => $row['jabatan'],
        'foto' => $row['foto']
    ];
}
?>

<div class="bg-dark text-white py-5 text-center mb-5">
    <div class="container">
        <h1 class="fw-bold">Struktur Organisasi</h1>
        <p class="lead">Orang-orang hebat di balik layar.</p>
    </div>
</div>

<div class="container mb-5">
    
    <?php foreach ($struktur as $nama_dept => $anggota_list): ?>
        
        <div class="mb-5">
            <h3 class="border-start border-5 border-primary ps-3 fw-bold mb-4 text-uppercase">
                <?= htmlspecialchars($nama_dept) ?>
            </h3>

            <div class="row g-4">
                <?php foreach ($anggota_list as $anggota): ?>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card h-100 border-0 shadow-sm text-center p-3 hover-effect">
                        <div class="card-body">
                            <img src="assets/images/<?= $anggota['foto'] ?>" 
                                 onerror="this.src='https://via.placeholder.com/150'"
                                 alt="Foto Profil" 
                                 class="rounded-circle mb-3 border border-3 border-light shadow-sm"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            
                            <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($anggota['nama']) ?></h5>
                            <p class="card-text text-muted small text-uppercase mb-3"><?= htmlspecialchars($anggota['jabatan']) ?></p>
                            
                            <div>
                                <a href="#" class="text-secondary me-2"><i class="fa-brands fa-instagram"></i></a>
                                <a href="#" class="text-secondary"><i class="fa-brands fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php endforeach; ?>
</div>

<?php include 'includes/footer.php'; ?>
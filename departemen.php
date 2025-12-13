<?php include 'includes/header.php'; 

// --- DATA ANGGOTA (EDIT DISINI) ---
// Format: "Nama Departemen" => [Daftar Anggota]
$struktur = [
    "Badan Pengurus Harian (BPH)" => [
        ["nama" => "Lora Nurmaya", "jabatan" => "Ketua FDC"],
        ["nama" => "Fryda Septiani DP", "jabatan" => "Wakil FDC"],
        ["nama" => "Cindy Marcellina", "jabatan" => "Sekretaris"],
        ["nama" => "Tania Refiane Rismawaty", "jabatan" => "Bendahara"]
    ],
];
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
                <?= $nama_dept ?>
            </h3>

            <div class="row g-4">
                <?php foreach ($anggota_list as $anggota): ?>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card h-100 border-0 shadow-sm text-center p-3 hover-effect">
                        <div class="card-body">
                            <img src="https://via.placeholder.com/150" 
                                 alt="Foto Profil" 
                                 class="rounded-circle mb-3 border border-3 border-light shadow-sm"
                                 style="width: 100px; height: 100px; object-fit: cover;">
                            
                            <h5 class="card-title fw-bold mb-1"><?= $anggota['nama'] ?></h5>
                            <p class="card-text text-muted small text-uppercase mb-3"><?= $anggota['jabatan'] ?></p>
                            
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
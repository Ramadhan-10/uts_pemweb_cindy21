<div class="col-md-3 col-lg-2 sidebar p-0">
    <div class="p-3 text-center border-bottom border-secondary">
        <h5 class="text-white fw-bold mb-0"><i class="fa-solid fa-star me-2"></i>FDC Admin</h5>
    </div>
    <nav class="nav flex-column py-3">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="index.php">
            <i class="fa-solid fa-gauge-high me-2"></i>Dashboard
        </a>
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'anggota.php' ? 'active' : '' ?>" href="anggota.php">
            <i class="fa-solid fa-users me-2"></i>Kelola Anggota
        </a>
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pendaftar.php' ? 'active' : '' ?>" href="pendaftar.php">
            <i class="fa-solid fa-user-plus me-2"></i>Data Pendaftar
        </a>
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'divisi.php' ? 'active' : '' ?>" href="divisi.php">
            <i class="fa-solid fa-sitemap me-2"></i>Kelola Divisi
        </a>
        <hr class="border-secondary mx-3">
        <a class="nav-link" href="../index.php" target="_blank">
            <i class="fa-solid fa-globe me-2"></i>Lihat Website
        </a>
        <a class="nav-link text-danger" href="../logout.php">
            <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
        </a>
    </nav>
</div>

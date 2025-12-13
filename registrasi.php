<?php 
// Memanggil koneksi database dan header
include 'includes/db.php'; 
include 'includes/header.php'; 

$pesan_notifikasi = "";

// LOGIKA PHP: MENERIMA DATA FORM SAAT TOMBOL DIKLIK
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil data dari form
    $nama = htmlspecialchars($_POST['nama']);
    $nim = htmlspecialchars($_POST['nim']);
    $email = htmlspecialchars($_POST['email']);
    $jurusan = htmlspecialchars($_POST['jurusan']);
    $divisi = htmlspecialchars($_POST['divisi']);
    $alasan = htmlspecialchars($_POST['alasan']);

    // Cek apakah data wajib sudah terisi
    if(!empty($nama) && !empty($nim) && !empty($email)) {
        
        try {
            // Query Insert data ke tabel database 'pendaftar'
            $sql = "INSERT INTO tabel_pendaftar (nama_lengkap, nim, email, jurusan, divisi_pilihan, alasan_bergabung) 
                    VALUES (:nama, :nim, :email, :jurusan, :divisi, :alasan)";
            
            $stmt = $pdo->prepare($sql);
            
            // Binding data untuk keamanan
            $data = [
                'nama' => $nama,
                'nim' => $nim,
                'email' => $email,
                'jurusan' => $jurusan,
                'divisi' => $divisi,
                'alasan' => $alasan
            ];

            // Eksekusi simpan
            if($stmt->execute($data)) {
                $pesan_notifikasi = "
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Berhasil!</strong> Data pendaftaranmu sudah kami terima.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            }
        } catch (PDOException $e) {
            $pesan_notifikasi = "<div class='alert alert-danger'>Gagal menyimpan: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<div class="container-fluid p-5 text-white text-center" 
     style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/banner.jpg'); background-size: cover; background-position: center;">
    <h1 class="fw-bold">Open Recruitment</h1>
    <p class="lead">Bergabunglah menjadi bagian dari perubahan!</p>
</div>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <?php echo $pesan_notifikasi; ?>

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-dark text-white text-center py-3">
                    <h5 class="mb-0">Formulir Pendaftaran Anggota</h5>
                </div>
                <div class="card-body p-5">
                    
                    <form action="" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama" placeholder="Sesuai KTM" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">NIM</label>
                                <input type="number" class="form-control" name="nim" placeholder="Contoh: 12345678" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="nama@univ.ac.id" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jurusan</label>
                                <input type="text" class="form-control" name="jurusan" placeholder="Contoh: Informatika" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-primary">Divisi Pilihan</label>
                            <select class="form-select" name="divisi" required>
                                <option value="" selected disabled>-- Pilih Divisi --</option>
                                <option value="Tradisional">Tradisional</option>
                                <option value="Modern">Modern</option>
                                <option value="Kpop">Kpop</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Alasan Bergabung</label>
                            <textarea class="form-control" name="alasan" rows="4" placeholder="Ceritakan motivasimu..." required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-dark btn-lg">
                                Kirim Pendaftaran
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
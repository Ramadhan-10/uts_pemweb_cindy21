<?php
// --- KONFIGURASI DATABASE ---
$host = 'localhost';       // Server lokal (biasanya localhost)
$dbname = 'db_organisasi'; // Nama Database (HARUS SAMA dengan yang kamu buat di phpMyAdmin)
$username = 'root';        // Username default XAMPP
$password = '';            // Password default XAMPP (biasanya kosong)

// --- KONEKSI MENGGUNAKAN PDO ---
try {
    // Membuat koneksi baru
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Mengatur mode error ke Exception agar mudah mendeteksi kesalahan query
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Jika berhasil, kode akan lanjut tanpa masalah.
    // echo "Koneksi Berhasil"; // Uncomment baris ini jika ingin tes koneksi saja

} catch(PDOException $e) {
    // Jika koneksi gagal, program berhenti dan menampilkan pesan error
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>
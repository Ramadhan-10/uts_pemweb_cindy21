/**
 * TUGAS PEMROGRAMAN WEB
 * File: assets/js/script.js
 * Deskripsi: Mengatur interaktivitas website (Navbar, Validasi Form, dll)
 */

// Pastikan seluruh elemen HTML sudah dimuat sebelum menjalankan script
document.addEventListener("DOMContentLoaded", function() {
    
    // --- 1. FITUR HIGHLIGHT MENU AKTIF ---
    // Mengambil nama file dari URL saat ini (misal: index.php)
    const currentLocation = location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll(".nav-link");

    navLinks.forEach(link => {
        // Jika href link sama dengan nama file saat ini, tambahkan class 'active'
        if (link.getAttribute("href") === currentLocation) {
            link.classList.add("active");
            link.classList.add("fw-bold"); // Bootstrap class untuk tebal
            link.style.color = "#1a2c4e"; // Warna biru tua
        }
    });


    // --- 2. FITUR NAVBAR SCROLL EFFECT ---
    // Saat user scroll ke bawah, navbar diberi bayangan agar kontras
    const navbar = document.querySelector(".navbar");

    window.addEventListener("scroll", function() {
        if (window.scrollY > 50) {
            navbar.classList.add("shadow-sm"); // Tambah bayangan tipis
            navbar.style.paddingTop = "10px";  // Memperkecil padding (animasi halus)
            navbar.style.paddingBottom = "10px";
        } else {
            navbar.classList.remove("shadow-sm"); // Hapus bayangan jika di atas
            navbar.style.paddingTop = "15px";     // Kembalikan padding asli
            navbar.style.paddingBottom = "15px";
        }
    });


    // --- 3. VALIDASI FORM REGISTRASI (Client Side) ---
    // Cek apakah kita sedang di halaman registrasi (apakah ada form?)
    const formRegistrasi = document.querySelector("form");
    
    if (formRegistrasi) {
        formRegistrasi.addEventListener("submit", function(event) {
            
            // Ambil nilai input
            const nimInput = document.querySelector("input[name='nim']").value;
            const alasanInput = document.querySelector("textarea[name='alasan']").value;

            // Validasi 1: NIM harus angka (meski type=number, jaga-jaga) dan minimal panjangnya
            if (nimInput.length < 5) {
                alert("❌ NIM terlihat tidak valid (terlalu pendek). Mohon cek kembali.");
                event.preventDefault(); // Mencegah form dikirim ke PHP
                return;
            }

            // Validasi 2: Alasan harus niat (minimal 20 karakter)
            if (alasanInput.length < 20) {
                alert("⚠️ Mohon isi alasan bergabung lebih detail (minimal 20 karakter) agar kami bisa menilainya.");
                event.preventDefault(); // Mencegah form dikirim
                return;
            }

            // Jika lolos validasi
            // alert("Data valid! Sedang mengirim..."); // Opsional: Tampilkan pesan
        });
    }

});

/**
 * Fungsi Tambahan: Konfirmasi sebelum menghapus data (Digunakan di Dashboard)
 * Dipanggil langsung lewat atribut onclick="" di HTML
 */
function konfirmasiHapus() {
    return confirm("Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak bisa dibatalkan.");
}
-- Database: db_organisasi
-- Relasi: tabel_divisi → tabel_anggota, tabel_pendaftar

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Tabel Divisi (Parent)
CREATE TABLE `tabel_divisi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_divisi` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tabel_divisi` (`id`, `nama_divisi`, `deskripsi`) VALUES
(1, 'BPH', 'Badan Pengurus Harian'),
(2, 'Tradisional', 'Divisi Tari Tradisional'),
(3, 'Modern', 'Divisi Tari Modern'),
(4, 'Kpop', 'Divisi Dance K-Pop');

-- Tabel Admin
CREATE TABLE `tabel_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tabel_admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- Tabel Anggota (FK: divisi_id)
CREATE TABLE `tabel_anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `created_at` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_anggota_divisi` FOREIGN KEY (`divisi_id`) REFERENCES `tabel_divisi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tabel_anggota` (`id`, `nama`, `jabatan`, `divisi_id`) VALUES
(1, 'Lora Nurmaya', 'Ketua FDC', 1),
(2, 'Fryda Septiani DP', 'Wakil FDC', 1),
(3, 'Cindy Marcellina', 'Sekretaris', 1),
(4, 'Tania Refiane Rismawaty', 'Bendahara', 1);

-- Tabel Pendaftar (FK: divisi_id)
CREATE TABLE `tabel_pendaftar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `divisi_id` int(11) NOT NULL,
  `alasan_bergabung` text NOT NULL,
  `status` enum('pending','diterima','ditolak') DEFAULT 'pending',
  `tanggal_daftar` timestamp DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_pendaftar_divisi` FOREIGN KEY (`divisi_id`) REFERENCES `tabel_divisi` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `tabel_pendaftar` (`id`, `nama_lengkap`, `nim`, `email`, `jurusan`, `divisi_id`, `alasan_bergabung`) VALUES
(1, 'Cindy Marcellina', '23031', 'cindyajala@gmail.com', 'informatika', 2, 'pengen belajar tari');

COMMIT;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2025 pada 09.52
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_organisasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_admin`
--

CREATE TABLE `tabel_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_admin`
--

INSERT INTO `tabel_admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_anggota`
--

CREATE TABLE `tabel_anggota` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jabatan` varchar(100) NOT NULL,
  `divisi` varchar(50) NOT NULL,
  `foto` varchar(255) NOT NULL DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_anggota`
--

INSERT INTO `tabel_anggota` (`id`, `nama`, `jabatan`, `divisi`, `foto`) VALUES
(1, 'Lora Nurmaya', 'Ketua FDC', 'BPH', 'default.png'),
(2, 'Fryda Septiani DP', 'Wakil FDC', 'BPH', 'default.png'),
(3, 'Cindy Marcellina', 'Sekretaris', 'BPH', 'default.png'),
(4, 'Tania Refiane Rismawaty', 'Bendahara', 'BPH', 'default.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_pendaftar`
--

CREATE TABLE `tabel_pendaftar` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `divisi_pilihan` varchar(50) NOT NULL,
  `alasan_bergabung` text NOT NULL,
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_pendaftar`
--

INSERT INTO `tabel_pendaftar` (`id`, `nama_lengkap`, `nim`, `email`, `jurusan`, `divisi_pilihan`, `alasan_bergabung`, `tanggal_daftar`) VALUES
(1, 'Cindy Marcellina', '23031', 'cindyajala@gmail.com', 'informatika', 'Tari', 'pengen belajar tari trus pengen punya relasi juga', '2025-11-19 15:38:47');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tabel_admin`
--
ALTER TABLE `tabel_admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tabel_anggota`
--
ALTER TABLE `tabel_anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tabel_pendaftar`
--
ALTER TABLE `tabel_pendaftar`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tabel_admin`
--
ALTER TABLE `tabel_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tabel_anggota`
--
ALTER TABLE `tabel_anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tabel_pendaftar`
--
ALTER TABLE `tabel_pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

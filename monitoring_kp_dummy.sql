-- phpMyAdmin SQL Dump
-- version 5.2.0
-- Host: 127.0.0.1
-- Generation Time: Sep 07, 2026 at 10:00 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+07:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitoring_kp`
--
CREATE DATABASE IF NOT EXISTS `monitoring_kp` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `monitoring_kp`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `npm_nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('mahasiswa','dosen','koordinator') NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `npm_nip`, `nama`, `password`, `role`, `email`) VALUES
(1, 'koor', 'Bapak Koordinator KP', 'koor123', 'koordinator', 'koordinator@kampus.ac.id'),
(2, 'dosen1', 'Bapak Dosen Satu S.Kom., M.Kom.', 'dosen123', 'dosen', 'dosen1@kampus.ac.id'),
(3, 'dosen2', 'Ibu Dosen Dua S.Kom., M.Kom.', 'dosen123', 'dosen', 'dosen2@kampus.ac.id'),
(4, 'mhs1', 'Mahasiswa Satu', 'mhs123', 'mahasiswa', 'mhs1@mhs.kampus.ac.id'),
(5, 'mhs2', 'Mahasiswa Dua', 'mhs123', 'mahasiswa', 'mhs2@mhs.kampus.ac.id'),
(6, 'mhs3', 'Mahasiswa Tiga', 'mhs123', 'mahasiswa', 'mhs3@mhs.kampus.ac.id');


-- --------------------------------------------------------

--
-- Table structure for table `kelompok`
--

CREATE TABLE `kelompok` (
  `id` int(11) NOT NULL,
  `ketua_id` int(11) NOT NULL,
  `dospem_id` int(11) DEFAULT NULL,
  `judul_laporan` varchar(255) DEFAULT NULL,
  `status_kelompok` enum('draft','menunggu_validasi','disetujui','ditolak') DEFAULT 'draft',
  `koor_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `anggota_kelompok`
--

CREATE TABLE `anggota_kelompok` (
  `id` int(11) NOT NULL,
  `kelompok_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `is_ketua` tinyint(1) DEFAULT 0,
  `status_anggota` enum('menunggu','menerima','menolak') DEFAULT 'menunggu',
  `no_wa` varchar(20) DEFAULT NULL,
  `file_riwayat_studi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `instansi`
--

CREATE TABLE `instansi` (
  `id` int(11) NOT NULL,
  `kelompok_id` int(11) NOT NULL,
  `nama_instansi` varchar(255) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `ditujukan_kepada` varchar(150) NOT NULL,
  `bidang_kp` varchar(100) NOT NULL,
  `lama_kp` varchar(20) NOT NULL,
  `file_surat_izin` varchar(255) DEFAULT NULL,
  `status_izin` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `izin_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `bimbingan`
--

CREATE TABLE `bimbingan` (
  `id` int(11) NOT NULL,
  `kelompok_id` int(11) NOT NULL,
  `no_surat_balasan` varchar(100) NOT NULL,
  `tgl_surat_balasan` date NOT NULL,
  `tgl_mulai_kp` date NOT NULL,
  `tgl_selesai_kp` date NOT NULL,
  `file_surat_balasan` varchar(255) NOT NULL,
  `file_slip_bimbingan` varchar(255) NOT NULL,
  `file_surat_tugas` varchar(255) DEFAULT NULL,
  `file_berkas_pendukung` varchar(255) DEFAULT NULL,
  `status_bimbingan` enum('menunggu','disetujui','ditolak') DEFAULT 'menunggu',
  `bimbingan_note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `log_bimbingan`
--

CREATE TABLE `log_bimbingan` (
  `id` int(11) NOT NULL,
  `kelompok_id` int(11) NOT NULL,
  `tgl_bimbingan` date NOT NULL,
  `catatan` text NOT NULL,
  `status_log` enum('revisi','acc') DEFAULT 'revisi'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `seminar`
--

CREATE TABLE `seminar` (
  `id` int(11) NOT NULL,
  `kelompok_id` int(11) NOT NULL,
  `file_draft_laporan` varchar(255) NOT NULL,
  `file_slip_seminar` varchar(255) NOT NULL,
  `status_dospem` enum('menunggu','acc','tolak') DEFAULT 'menunggu',
  `status_koor` enum('menunggu','dijadwalkan','tolak') DEFAULT 'menunggu',
  `tgl_seminar` date DEFAULT NULL,
  `jam_seminar` time DEFAULT NULL,
  `ruangan` varchar(100) DEFAULT NULL,
  `penguji1_id` int(11) DEFAULT NULL,
  `penguji2_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `sidang_nilai`
--

CREATE TABLE `sidang_nilai` (
  `id` int(11) NOT NULL,
  `seminar_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `nilai_angka` float DEFAULT NULL,
  `nilai_huruf` varchar(2) DEFAULT NULL,
  `revisi` text DEFAULT NULL,
  `tipe_dosen` enum('pembimbing','penguji1','penguji2') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- --------------------------------------------------------

--
-- Table structure for table `laporan_akhir`
--

CREATE TABLE `laporan_akhir` (
  `id` int(11) NOT NULL,
  `kelompok_id` int(11) NOT NULL,
  `file_laporan_final` varchar(255) NOT NULL,
  `file_surat_tugas` varchar(255) NOT NULL,
  `file_nilai_perusahaan` varchar(255) NOT NULL,
  `status_dospem` enum('menunggu','acc','tolak') DEFAULT 'menunggu',
  `status_koor` enum('menunggu','acc','tolak') DEFAULT 'menunggu',
  `catatan` text DEFAULT NULL,
  `nilai_akhir_huruf` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Indexes for dumped tables
--

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `npm_nip` (`npm_nip`);

ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ketua_id` (`ketua_id`),
  ADD KEY `dospem_id` (`dospem_id`);

ALTER TABLE `anggota_kelompok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelompok_id` (`kelompok_id`),
  ADD KEY `mahasiswa_id` (`mahasiswa_id`);

ALTER TABLE `instansi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelompok_id` (`kelompok_id`);

ALTER TABLE `bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelompok_id` (`kelompok_id`);

ALTER TABLE `log_bimbingan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelompok_id` (`kelompok_id`);

ALTER TABLE `seminar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelompok_id` (`kelompok_id`);

ALTER TABLE `sidang_nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seminar_id` (`seminar_id`);

ALTER TABLE `laporan_akhir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelompok_id` (`kelompok_id`);

--
-- AUTO_INCREMENT for dumped tables
--

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `kelompok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `anggota_kelompok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `instansi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `bimbingan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `log_bimbingan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `seminar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `sidang_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `laporan_akhir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

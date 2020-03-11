-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2020 at 03:37 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cit_jobdesc`
--

-- --------------------------------------------------------

--
-- Table structure for table `hasil_kerja`
--

CREATE TABLE `hasil_kerja` (
  `id_hasil` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `hasil_judul` text NOT NULL,
  `hasil_periode` varchar(255) NOT NULL,
  `hasil_tujuan` text NOT NULL,
  `hasil_report` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hasil_kerja`
--

INSERT INTO `hasil_kerja` (`id_hasil`, `id_jabatan`, `hasil_judul`, `hasil_periode`, `hasil_tujuan`, `hasil_report`) VALUES
(2, 22, 'Hasil Kerja 1', 'Harian', 'Tujuan Kerja 1', ''),
(3, 22, 'Hasil KeRJA 2', 'Sesuai Kebutuhan', 'Ini bener 2', '');

-- --------------------------------------------------------

--
-- Table structure for table `kualifikasi`
--

CREATE TABLE `kualifikasi` (
  `id_kualifikasi` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `kualifikasi_pendidikan` varchar(255) NOT NULL,
  `kualifikasi_jekel` varchar(255) NOT NULL,
  `kualifikasi_usia` int(11) NOT NULL,
  `kualifikasi_kerja` varchar(255) NOT NULL,
  `kualifikasi_bidang` varchar(255) NOT NULL,
  `kualifikasi_bahasa` varchar(255) NOT NULL,
  `kualifikasi_komputer` varchar(255) NOT NULL,
  `kualifikasi_khusus` varchar(255) NOT NULL,
  `kualifikasi_lain` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tj_khusus`
--

CREATE TABLE `tj_khusus` (
  `id_khusus` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `khusus_tj` text NOT NULL,
  `khusus_skala` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tj_khusus`
--

INSERT INTO `tj_khusus` (`id_khusus`, `id_jabatan`, `khusus_tj`, `khusus_skala`) VALUES
(2, 22, 'Ini Tanggung Jawab Khusus 1', 'Sesuai Kebutuhan'),
(3, 22, 'Yang Ke2', 'Mingguan');

-- --------------------------------------------------------

--
-- Table structure for table `tj_umum`
--

CREATE TABLE `tj_umum` (
  `id_umum` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `umum_tj` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tj_umum`
--

INSERT INTO `tj_umum` (`id_umum`, `id_jabatan`, `umum_tj`) VALUES
(1, 22, 'Mengimplementasikan target jangka pendek dan panjang yang sudah ditetapkan'),
(2, 22, 'Menjalankan strategi jangka pendek dan panjang yang sudah ditetapkan'),
(3, 22, 'Mengajukan usulan penambahan tenaga kerja jika diluar standart yang sudah ditetapkan'),
(4, 22, 'Memberikan usulan terkait perbaikan prosedur kerja (SOP)'),
(5, 22, 'Mengajukan usulan penambahan tenaga kerja jika diluar standart yang sudah ditetapkan'),
(6, 22, 'Berorientasi pada perbaikan kesinambungan terkait QCDSM (Quality, Cost, Delivery, Safety, Moral)'),
(7, 22, 'Memberikan usulan terkait pengembangan tenaga kerja kepada kepala departemen');

-- --------------------------------------------------------

--
-- Table structure for table `tujuan`
--

CREATE TABLE `tujuan` (
  `id_tujuan` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `jobdesc_tujuan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tujuan`
--

INSERT INTO `tujuan` (`id_tujuan`, `id_jabatan`, `jobdesc_tujuan`) VALUES
(5, 22, 'Tujuan Jabatan Direktur Utama');

-- --------------------------------------------------------

--
-- Table structure for table `wewenang`
--

CREATE TABLE `wewenang` (
  `id_wewenang` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `jobdesc_wewenang` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wewenang`
--

INSERT INTO `wewenang` (`id_wewenang`, `id_jabatan`, `jobdesc_wewenang`) VALUES
(1, 22, 'Wewenang Direktur Utama');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hasil_kerja`
--
ALTER TABLE `hasil_kerja`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indexes for table `kualifikasi`
--
ALTER TABLE `kualifikasi`
  ADD PRIMARY KEY (`id_kualifikasi`);

--
-- Indexes for table `tj_khusus`
--
ALTER TABLE `tj_khusus`
  ADD PRIMARY KEY (`id_khusus`);

--
-- Indexes for table `tj_umum`
--
ALTER TABLE `tj_umum`
  ADD PRIMARY KEY (`id_umum`);

--
-- Indexes for table `tujuan`
--
ALTER TABLE `tujuan`
  ADD PRIMARY KEY (`id_tujuan`);

--
-- Indexes for table `wewenang`
--
ALTER TABLE `wewenang`
  ADD PRIMARY KEY (`id_wewenang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hasil_kerja`
--
ALTER TABLE `hasil_kerja`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kualifikasi`
--
ALTER TABLE `kualifikasi`
  MODIFY `id_kualifikasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tj_khusus`
--
ALTER TABLE `tj_khusus`
  MODIFY `id_khusus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tj_umum`
--
ALTER TABLE `tj_umum`
  MODIFY `id_umum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tujuan`
--
ALTER TABLE `tujuan`
  MODIFY `id_tujuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `wewenang`
--
ALTER TABLE `wewenang`
  MODIFY `id_wewenang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

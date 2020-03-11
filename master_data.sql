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
-- Database: `master_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobdesc_tj_umum`
--

CREATE TABLE `jobdesc_tj_umum` (
  `id_umum` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `umum_nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobdesc_tj_umum`
--

INSERT INTO `jobdesc_tj_umum` (`id_umum`, `id_jabatan`, `umum_nama`) VALUES
(1, 7, 'Tanggung Jawab Umum Pertama'),
(2, 7, 'Yang Kedua');

-- --------------------------------------------------------

--
-- Table structure for table `jobdesc_tujuan`
--

CREATE TABLE `jobdesc_tujuan` (
  `id_tujuan` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `tujuan_nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `jobdesc_wewenang`
--

CREATE TABLE `jobdesc_wewenang` (
  `id_wewenang` int(11) NOT NULL,
  `id_jabatan` int(11) NOT NULL,
  `wewenang_nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobdesc_wewenang`
--

INSERT INTO `jobdesc_wewenang` (`id_wewenang`, `id_jabatan`, `wewenang_nama`) VALUES
(1, 7, 'Wewenang 1');

-- --------------------------------------------------------

--
-- Table structure for table `kpi_corporate`
--

CREATE TABLE `kpi_corporate` (
  `id_corporate` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `corporate_nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kpi_corporate`
--

INSERT INTO `kpi_corporate` (`id_corporate`, `id_kategori`, `corporate_nama`) VALUES
(6, 1, 'Corporate Financial 1'),
(7, 1, 'Financial 2');

-- --------------------------------------------------------

--
-- Table structure for table `kpi_kategori`
--

CREATE TABLE `kpi_kategori` (
  `id_kategori` int(11) NOT NULL,
  `kategori_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kpi_kategori`
--

INSERT INTO `kpi_kategori` (`id_kategori`, `kategori_nama`) VALUES
(1, 'Financial'),
(2, 'Customer'),
(3, 'Internal  Business Process'),
(4, 'The Learning and Growth');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan_departement`
--

CREATE TABLE `perusahaan_departement` (
  `id_departement` int(11) NOT NULL,
  `id_divisi` int(11) NOT NULL,
  `departement_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan_departement`
--

INSERT INTO `perusahaan_departement` (`id_departement`, `id_divisi`, `departement_nama`) VALUES
(10, 8, 'Corporate');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan_divisi`
--

CREATE TABLE `perusahaan_divisi` (
  `id_divisi` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `divisi_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan_divisi`
--

INSERT INTO `perusahaan_divisi` (`id_divisi`, `id_level`, `divisi_nama`) VALUES
(8, 7, 'Corporate'),
(9, 1, 'Corporate');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan_jabatan`
--

CREATE TABLE `perusahaan_jabatan` (
  `id_jabatan` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `id_departement` int(11) NOT NULL,
  `jabatan_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan_jabatan`
--

INSERT INTO `perusahaan_jabatan` (`id_jabatan`, `parent_id`, `id_departement`, `jabatan_nama`) VALUES
(7, NULL, 10, 'Direktur Utama');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan_jenis`
--

CREATE TABLE `perusahaan_jenis` (
  `id_jenus` int(11) NOT NULL,
  `jenus_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan_jenis`
--

INSERT INTO `perusahaan_jenis` (`id_jenus`, `jenus_nama`) VALUES
(1, 'Manufacture'),
(2, 'Jasa '),
(3, 'Dagang'),
(4, 'Ekstraktif'),
(5, 'Agraris');

-- --------------------------------------------------------

--
-- Table structure for table `perusahaan_level`
--

CREATE TABLE `perusahaan_level` (
  `id_level` int(11) NOT NULL,
  `id_jenus` int(11) NOT NULL,
  `level_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `perusahaan_level`
--

INSERT INTO `perusahaan_level` (`id_level`, `id_jenus`, `level_nama`) VALUES
(1, 1, 'Executive'),
(2, 1, 'Division'),
(3, 1, 'Department'),
(4, 1, 'Section '),
(5, 1, 'Unit'),
(6, 1, 'Worker'),
(7, 2, 'Direksi'),
(8, 2, 'Pimpinan Cabang'),
(9, 2, 'Kepala Bagian'),
(10, 2, 'Kepala Sub Bagian '),
(11, 2, 'Staff'),
(12, 2, 'Clerk'),
(13, 3, 'Executive'),
(14, 3, 'Division'),
(15, 3, 'Department'),
(16, 3, 'Section '),
(17, 3, 'Unit'),
(18, 3, 'Worker'),
(19, 4, 'Executive'),
(20, 4, 'Division'),
(21, 4, 'Department'),
(22, 4, 'Section '),
(23, 4, 'Unit'),
(24, 4, 'Worker'),
(25, 5, 'Executive'),
(26, 5, 'Division'),
(27, 5, 'Department'),
(28, 5, 'Section '),
(29, 5, 'Unit'),
(30, 5, 'Worker');

-- --------------------------------------------------------

--
-- Table structure for table `tj_umum`
--

CREATE TABLE `tj_umum` (
  `id_umum` int(11) NOT NULL,
  `umum_tj` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tj_umum`
--

INSERT INTO `tj_umum` (`id_umum`, `umum_tj`) VALUES
(1, 'Mengimplementasikan target jangka pendek dan panjang yang sudah ditetapkan'),
(2, 'Menjalankan strategi jangka pendek dan panjang yang sudah ditetapkan'),
(3, 'Menjalankan prosedur kerja (SOP) sesuai dengan ketentuan'),
(4, 'Memberikan usulan terkait perbaikan prosedur kerja (SOP)'),
(5, 'Melakukan pengawasan dan pengendalian kinerja untuk seksi masing-masing dan mendukung pencapaian target divisi'),
(6, 'Melakukan koordinasi internal section'),
(7, 'Membuat usulan biaya operasional sesuai dengan kebutuhan'),
(8, 'Membantu kepala departemen membuat proposal terkait biaya yang diluar kebijakan otoriasasi dan sistem budgeting dalam hal pengumpulan data-data'),
(9, 'Memberikan ususlan kepada kepala departemen terkait rotasi, mutasi, dan promosi'),
(10, 'Berorientasi pada perbaikan kesinambungan terkait QCDSM (Quality, Cost, Delivery, Safety, Moral)'),
(11, 'Mengajukan usulan penambahan tenaga kerja jika diluar standart yang sudah ditetapkan'),
(12, 'Memberikan usulan terkait pengembangan tenaga kerja kepada kepala departemen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jobdesc_tj_umum`
--
ALTER TABLE `jobdesc_tj_umum`
  ADD PRIMARY KEY (`id_umum`);

--
-- Indexes for table `jobdesc_tujuan`
--
ALTER TABLE `jobdesc_tujuan`
  ADD PRIMARY KEY (`id_tujuan`);

--
-- Indexes for table `jobdesc_wewenang`
--
ALTER TABLE `jobdesc_wewenang`
  ADD PRIMARY KEY (`id_wewenang`);

--
-- Indexes for table `kpi_corporate`
--
ALTER TABLE `kpi_corporate`
  ADD PRIMARY KEY (`id_corporate`);

--
-- Indexes for table `kpi_kategori`
--
ALTER TABLE `kpi_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `perusahaan_departement`
--
ALTER TABLE `perusahaan_departement`
  ADD PRIMARY KEY (`id_departement`);

--
-- Indexes for table `perusahaan_divisi`
--
ALTER TABLE `perusahaan_divisi`
  ADD PRIMARY KEY (`id_divisi`);

--
-- Indexes for table `perusahaan_jabatan`
--
ALTER TABLE `perusahaan_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `perusahaan_jenis`
--
ALTER TABLE `perusahaan_jenis`
  ADD PRIMARY KEY (`id_jenus`);

--
-- Indexes for table `perusahaan_level`
--
ALTER TABLE `perusahaan_level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indexes for table `tj_umum`
--
ALTER TABLE `tj_umum`
  ADD PRIMARY KEY (`id_umum`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jobdesc_tj_umum`
--
ALTER TABLE `jobdesc_tj_umum`
  MODIFY `id_umum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobdesc_tujuan`
--
ALTER TABLE `jobdesc_tujuan`
  MODIFY `id_tujuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobdesc_wewenang`
--
ALTER TABLE `jobdesc_wewenang`
  MODIFY `id_wewenang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kpi_corporate`
--
ALTER TABLE `kpi_corporate`
  MODIFY `id_corporate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `kpi_kategori`
--
ALTER TABLE `kpi_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `perusahaan_departement`
--
ALTER TABLE `perusahaan_departement`
  MODIFY `id_departement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `perusahaan_divisi`
--
ALTER TABLE `perusahaan_divisi`
  MODIFY `id_divisi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `perusahaan_jabatan`
--
ALTER TABLE `perusahaan_jabatan`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `perusahaan_jenis`
--
ALTER TABLE `perusahaan_jenis`
  MODIFY `id_jenus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `perusahaan_level`
--
ALTER TABLE `perusahaan_level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tj_umum`
--
ALTER TABLE `tj_umum`
  MODIFY `id_umum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

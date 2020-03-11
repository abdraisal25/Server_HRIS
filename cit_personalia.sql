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
-- Database: `cit_personalia`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id_user` int(11) NOT NULL,
  `id_perusahaan` int(11) NOT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `user_nip` varchar(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_nama` varchar(255) NOT NULL,
  `user_panggilan` varchar(255) DEFAULT NULL,
  `user_kelamin` varchar(255) DEFAULT NULL,
  `user_darah` varchar(255) DEFAULT NULL,
  `user_tempat_lahir` varchar(255) DEFAULT NULL,
  `user_tanggal_lahir` varchar(255) DEFAULT NULL,
  `user_agama` varchar(255) DEFAULT NULL,
  `user_perkawinan` varchar(255) DEFAULT NULL,
  `user_telp` varchar(255) DEFAULT NULL,
  `user_ktp` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `user_alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id_user`, `id_perusahaan`, `id_jabatan`, `user_nip`, `user_username`, `user_password`, `user_nama`, `user_panggilan`, `user_kelamin`, `user_darah`, `user_tempat_lahir`, `user_tanggal_lahir`, `user_agama`, `user_perkawinan`, `user_telp`, `user_ktp`, `user_email`, `user_alamat`) VALUES
(2, 3, NULL, '123456', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'nama user', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'diananur67@gmail.com', NULL),
(3, 4, NULL, '11241', 'baruaku', '89ccfac87d8d06db06bf3211cb2d69ed', 'Diana Nur Anggreini', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'diananur67@gmail.com', NULL),
(7, 14, NULL, '', 'admin', '0192023a7bbd73250516f069df18b500', 'Rais Alhakim', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '081515139080', NULL, 'raisz.borneo25@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `keluarga`
--

CREATE TABLE `keluarga` (
  `id_keluarga` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `keluarga_hubungan` varchar(255) NOT NULL,
  `keluarga_nama` varchar(255) NOT NULL,
  `keluarga_kelamin` varchar(255) NOT NULL,
  `keluarga_tempat_lahir` varchar(255) NOT NULL,
  `keluarga_tanggal_lahir` varchar(255) NOT NULL,
  `keluarga_pendidikan` varchar(255) NOT NULL,
  `keluarga_telp` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `lain`
--

CREATE TABLE `lain` (
  `id_personalia_lain` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `lain_hobby` varchar(255) NOT NULL,
  `lain_kesehatan` varchar(255) NOT NULL,
  `lain_cita` varchar(255) NOT NULL,
  `lain_kelebihan` text NOT NULL,
  `lain_kekuarangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `organisasi`
--

CREATE TABLE `organisasi` (
  `id_organisasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `organisasi_nama` varchar(255) NOT NULL,
  `organisasi_tempat` varchar(255) NOT NULL,
  `organisasi_jabatan` varchar(255) NOT NULL,
  `organisasi_mulai` varchar(255) NOT NULL,
  `organiasasi_selesai` varchar(255) NOT NULL,
  `organisasi_deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pendidikan`
--

CREATE TABLE `pendidikan` (
  `id_pendidikan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pendidikan_level` varchar(255) NOT NULL,
  `pendidikan_institusi` varchar(255) NOT NULL,
  `pendidikan_kota` varchar(255) NOT NULL,
  `pendidikan_jurusan` varchar(255) NOT NULL,
  `pendidikan_mulai` varchar(255) NOT NULL,
  `pendidikan_selesai` varchar(255) NOT NULL,
  `pendidikan_gelar` varchar(255) NOT NULL,
  `pendidikan_ipk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengalaman`
--

CREATE TABLE `pengalaman` (
  `id_pengalaman` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `pengalaman_mulai` varchar(255) NOT NULL,
  `pengalaman_selesai` varchar(255) NOT NULL,
  `pengalaman_perusahaan` varchar(255) NOT NULL,
  `pengalaman_jenus` varchar(255) NOT NULL,
  `pengalaman_alamat` text NOT NULL,
  `pengalaman_telp` varchar(255) NOT NULL,
  `pengalaman_jabatan` varchar(255) NOT NULL,
  `pengalaman_gaji` varchar(255) NOT NULL,
  `pengalaman_tunjangan` text NOT NULL,
  `pengalaman_atasan` varchar(255) NOT NULL,
  `pengalaman_berhenti` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `keluarga`
--
ALTER TABLE `keluarga`
  ADD PRIMARY KEY (`id_keluarga`);

--
-- Indexes for table `lain`
--
ALTER TABLE `lain`
  ADD PRIMARY KEY (`id_personalia_lain`);

--
-- Indexes for table `organisasi`
--
ALTER TABLE `organisasi`
  ADD PRIMARY KEY (`id_organisasi`);

--
-- Indexes for table `pendidikan`
--
ALTER TABLE `pendidikan`
  ADD PRIMARY KEY (`id_pendidikan`);

--
-- Indexes for table `pengalaman`
--
ALTER TABLE `pengalaman`
  ADD PRIMARY KEY (`id_pengalaman`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `keluarga`
--
ALTER TABLE `keluarga`
  MODIFY `id_keluarga` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lain`
--
ALTER TABLE `lain`
  MODIFY `id_personalia_lain` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `organisasi`
--
ALTER TABLE `organisasi`
  MODIFY `id_organisasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pendidikan`
--
ALTER TABLE `pendidikan`
  MODIFY `id_pendidikan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengalaman`
--
ALTER TABLE `pengalaman`
  MODIFY `id_pengalaman` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

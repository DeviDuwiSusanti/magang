-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2025 at 02:57 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magang_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_profile_user`
--

DROP TABLE IF EXISTS `tb_profile_user`;
CREATE TABLE IF NOT EXISTS `tb_profile_user` (
  `id_user` varchar(14) NOT NULL,
  `nama_user` varchar(100) DEFAULT NULL,
  `nik` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nisn` char(10) DEFAULT NULL,
  `nim` varchar(15) DEFAULT NULL,
  `nip` char(18) DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat_user` text,
  `gambar_user` varchar(100) DEFAULT NULL,
  `telepone_user` varchar(15) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `id_instansi` varchar(10) DEFAULT NULL,
  `id_bidang` varchar(12) DEFAULT NULL,
  `id_pendidikan` varchar(7) DEFAULT NULL,
  `id_pengajuan` varchar(10) DEFAULT NULL,
  `status_active` char(1) DEFAULT '1',
  `create_by` varchar(14) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` varchar(14) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  KEY `id_instansi` (`id_instansi`),
  KEY `id_bidang` (`id_bidang`),
  KEY `id_pengajuan` (`id_pengajuan`),
  KEY `id_pendidikan` (`id_pendidikan`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_profile_user`
--

INSERT INTO `tb_profile_user` (`id_user`, `nama_user`, `nik`, `nisn`, `nim`, `nip`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat_user`, `gambar_user`, `telepone_user`, `jabatan`, `id_instansi`, `id_bidang`, `id_pendidikan`, `id_pengajuan`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('2502171103', 'REVIKA SYARIQATUN ALIFIA', '3201010101010103', '1234567890', '220411100008', NULL, '0', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, '010101', '2025022601', '1', '2502171103', '2025-02-26 21:06:57', NULL, NULL),
('250217110301', 'SAIFUL ANAM', '3201010101010105', '1234567892', '220411100157', NULL, '1', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, '010101', '2025022601', '1', '2502171103', '2025-02-26 21:06:57', NULL, NULL),
('2502171104', 'DEVI DUWI SUSANTI', '3201010101010104', '1234567891', '220411100043', NULL, '0', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, '010101', '2025022602', '1', '2502171104', '2025-02-26 21:06:57', NULL, NULL),
('2502171101', 'MISHBAHUS SURUR', '3201010101010101', NULL, NULL, '123456789012345678', '1', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, NULL, NULL, '1', 'developer', '2025-02-26 21:06:57', NULL, NULL),
('2502171102', 'HENDRA HARTONO', '3201010101010102', NULL, NULL, '123456789012345677', '1', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, '438010000', NULL, NULL, NULL, '1', '2502171101', '2025-02-26 21:06:57', NULL, NULL),
('250217110302', 'ALI RIDHO', '3201010101010106', '1234567893', '220411100023', NULL, '1', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, '010101', '2025022601', '1', '2502171103', '2025-02-26 21:06:57', NULL, NULL),
('250217110303', 'MUHAMMAD MAHREZA RIZKY FAHROZY', '3201010101010107', '1234567894', '220411100064', NULL, '1', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, '010101', '2025022601', '1', '2502171103', '2025-02-26 21:06:57', NULL, NULL),
('250217110401', 'ADYAN BHAGASKARA', '3201010101010121', '1234567882', '220411100114', NULL, '1', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, '010101', '2025022602', '1', '2502171104', '2025-02-26 21:06:57', NULL, NULL),
('250217110402', 'MUHAMMAD HABIBUR ROHMAN', '3201010101010111', '1234567881', '220411100079', NULL, '1', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, '010101', '2025022602', '1', '2502171104', '2025-02-26 21:06:57', NULL, NULL),
('250217110403', 'HABLUL WARID GHOZALI', '3201010101010211', '1234567884', '220411100019', NULL, '1', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, NULL, NULL, NULL, '010101', '2025022602', '1', '2502171104', '2025-02-26 21:06:57', NULL, NULL),
('4380100000101', 'NIKEN SALINDRI', '3201010122211122', NULL, NULL, '12345678902345655', '0', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', 'avatar.png', NULL, 'IT CONSULTANT', NULL, '43801000001', NULL, NULL, '1', '2502171102', '2025-02-26 21:06:57', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

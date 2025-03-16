-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 05, 2025 at 12:35 PM
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
-- Table structure for table `tb_logbook`
--

DROP TABLE IF EXISTS `tb_logbook`;
CREATE TABLE IF NOT EXISTS `tb_logbook` (
  `id_logbook` char(12) NOT NULL,
  `tanggal_logbook` date DEFAULT NULL,
  `kegiatan_logbook` text,
  `keterangan_logbook` text,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `foto_kegiatan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tanda_tangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `id_pengajuan` char(10) DEFAULT NULL,
  `id_user` varchar(14) DEFAULT NULL,
  `status_active` char(1) DEFAULT '1',
  `create_by` varchar(14) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` varchar(14) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_logbook`),
  KEY `id_pengajuan` (`id_pengajuan`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

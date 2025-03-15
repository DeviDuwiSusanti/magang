-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2025 at 02:51 AM
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
-- Table structure for table `tb_bidang`
--

DROP TABLE IF EXISTS `tb_bidang`;
CREATE TABLE IF NOT EXISTS `tb_bidang` (
  `id_bidang` varchar(12) NOT NULL,
  `nama_bidang` varchar(100) DEFAULT NULL,
  `deskripsi_bidang` text,
  `kriteria_bidang` text,
  `dokumen_prasyarat` text,
  `kuota_bidang` varchar(2) DEFAULT NULL,
  `id_instansi` varchar(10) DEFAULT NULL,
  `status_active` char(1) DEFAULT '1',
  `create_by` varchar(14) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` varchar(14) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_bidang`),
  KEY `id_instansi` (`id_instansi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_bidang`
--

INSERT INTO `tb_bidang` (`id_bidang`, `nama_bidang`, `deskripsi_bidang`, `kriteria_bidang`, `dokumen_prasyarat`, `kuota_bidang`, `id_instansi`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('438010001', 'Bidang Administrasi Umum', 'Bidang yang mengerjana ini ini ini', 'luluasn s1, ipk 2,5', 'cv, ktp, bangkesbangpol', '4', '438010000', '1', '2402171102', '2025-02-26 21:10:33', NULL, '2025-03-02 21:25:51'),
('438010002', 'Bidang Hukum dan Perundang-undangan', NULL, NULL, NULL, '3', '438051700', '1', '2402171102', '2025-02-26 21:10:33', NULL, '2025-03-02 21:26:14'),
('438010003', 'Bidang Keuangan dan Aset', NULL, NULL, NULL, '4', '438051700', '1', '2402171102', '2025-02-26 21:10:33', NULL, '2025-03-02 21:26:26'),
('438010004', 'Bidang Kepegawaian', NULL, NULL, NULL, '4', '438010000', '1', '2402171102', '2025-02-26 21:10:33', NULL, '2025-03-02 21:26:30'),
('438010005', 'Bidang Perencanaan dan Evaluasi', NULL, NULL, NULL, NULL, '438010000', '1', '2402171102', '2025-02-26 21:10:33', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumen`
--

DROP TABLE IF EXISTS `tb_dokumen`;
CREATE TABLE IF NOT EXISTS `tb_dokumen` (
  `id_dokumen` char(12) NOT NULL,
  `nama_dokumen` varchar(100) DEFAULT NULL,
  `jenis_dokumen` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_pengajuan` char(10) DEFAULT NULL,
  `id_user` varchar(14) DEFAULT NULL,
  `status_active` char(1) DEFAULT '1',
  `create_by` varchar(14) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` varchar(14) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dokumen`),
  KEY `id_pengajuan` (`id_pengajuan`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_dokumen`
--

INSERT INTO `tb_dokumen` (`id_dokumen`, `nama_dokumen`, `jenis_dokumen`, `file_path`, `id_pengajuan`, `id_user`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('250217110410', 'krs5.pdf', '2', '../assets/doc/krs5.pdf', '2025030101', '2502171104', '1', '2502171104', '2025-03-02 11:59:01', NULL, '2025-03-02 11:59:01'),
('250217110411', 'devi transkip.pdf', '2', '../assets/doc/devi transkip.pdf', '2025030101', '2502171104', '1', '2502171104', '2025-03-02 11:59:01', NULL, '2025-03-02 11:59:01'),
('250217110412', 'Putih Minimalis Sederhana Profesional Administrasi Perkantoran Resume.pdf', '2', '../assets/doc/Putih Minimalis Sederhana Profesional Administrasi Perkantoran Resume.pdf', '2025030101', '2502171104', '1', '2502171104', '2025-03-02 12:03:46', NULL, '2025-03-02 12:03:46'),
('250217110413', 'Surat Balasan Magang Diskominfo Sidoarjo.pdf', '2', '../assets/doc/Surat Balasan Magang Diskominfo Sidoarjo.pdf', '2025030101', '2502171104', '1', '2502171104', '2025-03-02 12:06:15', NULL, '2025-03-02 12:06:15'),
('202503020101', 'ktp', '1', '../assets/doc/', '2025030201', '2502171104', '1', '2502171104', '2025-03-02 12:41:19', '', '0000-00-00 00:00:00'),
('202503020201', 'ktp', '1', '../assets/doc/Surat Balasan Magang Diskominfo Sidoarjo.pdf', '2025030202', '2502171104', '1', '2502171104', '2025-03-02 12:53:48', '', '0000-00-00 00:00:00'),
('202503020202', 'cv', '1', '../assets/doc/matkul konversi.pdf', '2025030202', '2502171104', '1', '2502171104', '2025-03-02 12:53:48', '', '0000-00-00 00:00:00'),
('202503020301', '', 'i', '../assets/doc/', '2025030203', '2502171104', '1', '2502171104', '2025-03-02 13:47:05', '', '0000-00-00 00:00:00'),
('202503020302', '', 'i', '../assets/doc/', '2025030203', '2502171104', 'Y', '2502171104', '2025-03-02 13:47:05', '', '0000-00-00 00:00:00'),
('202503020401', 'ktp', 'i', '../assets/doc/', '2025030204', '2502171104', '1', '2502171104', '2025-03-02 19:22:55', '', '0000-00-00 00:00:00'),
('202503020402', 'cv', 'i', '../assets/doc/', '2025030204', '2502171104', '1', '2502171104', '2025-03-02 19:22:55', '', '0000-00-00 00:00:00'),
('202503020501', 'ktp', 'i', '../assets/doc/', '2025030205', '2502171104', '1', '2502171104', '2025-03-02 19:27:35', '', '0000-00-00 00:00:00'),
('202503020502', 'cv', 'i', '../assets/doc/', '2025030205', '2502171104', '1', '2502171104', '2025-03-02 19:27:35', '', '0000-00-00 00:00:00'),
('202503020601', 'ktp', 'i', '../assets/doc/Bukti_Daftar_Ulang-220411100043 - Copy.pdf', '2025030206', '2502171104', '1', '2502171104', '2025-03-02 19:38:51', '', '0000-00-00 00:00:00'),
('202503020602', 'cv', 'i', '../assets/doc/matkul konversi.pdf', '2025030206', '2502171104', '1', '2502171104', '2025-03-02 19:38:51', '', '0000-00-00 00:00:00'),
('202503020701', 'ktp', 'i', '../assets/doc/Bukti_Daftar_Ulang-220411100043 - Copy.pdf', '2025030207', '2502171104', '1', '2502171104', '2025-03-02 19:40:35', '', '0000-00-00 00:00:00'),
('202503020702', 'cv', 'i', '../assets/doc/matkul konversi.pdf', '2025030207', '2502171104', '1', '2502171104', '2025-03-02 19:40:35', '', '0000-00-00 00:00:00'),
('202503020801', 'ktp', 'i', '../assets/doc/Bukti_Daftar_Ulang-220411100043 - Copy.pdf', '2025030208', '2502171104', '1', '2502171104', '2025-03-02 19:54:52', '', '0000-00-00 00:00:00'),
('202503020802', 'cv', 'i', '../assets/doc/matkul konversi.pdf', '2025030208', '2502171104', '1', '2502171104', '2025-03-02 19:54:52', '', '0000-00-00 00:00:00'),
('202503020901', 'ktp', 'i', '../assets/doc/Bukti_Daftar_Ulang-220411100043 - Copy.pdf', '2025030209', '2502171104', '1', '2502171104', '2025-03-02 19:56:58', '', '0000-00-00 00:00:00'),
('202503020902', 'cv', 'i', '../assets/doc/matkul konversi.pdf', '2025030209', '2502171104', '1', '2502171104', '2025-03-02 19:56:58', '', '0000-00-00 00:00:00'),
('202503021001', 'ktp', 'i', '../assets/doc/Bukti_Daftar_Ulang-220411100043 - Copy.pdf', '2025030210', '2502171104', '1', '2502171104', '2025-03-02 20:00:51', '', '0000-00-00 00:00:00'),
('202503021002', 'cv', 'i', '../assets/doc/matkul konversi.pdf', '2025030210', '2502171104', '1', '2502171104', '2025-03-02 20:00:51', '', '0000-00-00 00:00:00'),
('202503021101', 'ktp', 'i', '../assets/doc/', '2025030211', '2502171104', '1', '2502171104', '2025-03-02 20:20:46', '', '0000-00-00 00:00:00'),
('202503021102', 'cv', 'i', '../assets/doc/', '2025030211', '2502171104', '1', '2502171104', '2025-03-02 20:20:46', '', '0000-00-00 00:00:00'),
('202503021201', 'ktp', 'i', '../assets/doc/Bukti_Daftar_Ulang-220411100043 - Copy.pdf', '2025030212', '2502171104', '1', '2502171104', '2025-03-02 20:39:34', '', '0000-00-00 00:00:00'),
('202503021202', 'cv', 'i', '../assets/doc/matkul konversi.pdf', '2025030212', '2502171104', '1', '2502171104', '2025-03-02 20:39:34', '', '0000-00-00 00:00:00'),
('202503021301', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030213', '2502171104', '1', '2502171104', '2025-03-02 21:27:56', '', '0000-00-00 00:00:00'),
('202503021302', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030213', '2502171104', '1', '2502171104', '2025-03-02 21:27:56', '', '0000-00-00 00:00:00'),
('202503021401', 'ktp', 'i', '../assets/doc/', '2025030214', '2502171104', '1', '2502171104', '2025-03-02 22:12:20', '', '0000-00-00 00:00:00'),
('202503021402', 'cv', 'i', '../assets/doc/', '2025030214', '2502171104', '1', '2502171104', '2025-03-02 22:12:20', '', '0000-00-00 00:00:00'),
('202503021501', 'ktp', 'i', '../assets/doc/', '2025030215', '2502171104', '1', '2502171104', '2025-03-02 22:12:31', '', '0000-00-00 00:00:00'),
('202503021502', 'cv', 'i', '../assets/doc/', '2025030215', '2502171104', '1', '2502171104', '2025-03-02 22:12:31', '', '0000-00-00 00:00:00'),
('202503021601', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030216', '2502171104', '1', '2502171104', '2025-03-02 22:57:51', '', '0000-00-00 00:00:00'),
('202503021602', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030216', '2502171104', '1', '2502171104', '2025-03-02 22:57:51', '', '0000-00-00 00:00:00'),
('202503021701', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030217', '2502171104', '1', '2502171104', '2025-03-02 22:59:21', '', '0000-00-00 00:00:00'),
('202503021702', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030217', '2502171104', '1', '2502171104', '2025-03-02 22:59:21', '', '0000-00-00 00:00:00'),
('202503021801', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030218', '2502171104', '1', '2502171104', '2025-03-02 22:59:47', '', '0000-00-00 00:00:00'),
('202503021802', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030218', '2502171104', '1', '2502171104', '2025-03-02 22:59:47', '', '0000-00-00 00:00:00'),
('202503021901', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030219', '2502171104', '1', '2502171104', '2025-03-02 23:00:50', '', '0000-00-00 00:00:00'),
('202503021902', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030219', '2502171104', '1', '2502171104', '2025-03-02 23:00:50', '', '0000-00-00 00:00:00'),
('202503020103', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030201', '2502171104', '1', '2502171104', '2025-03-03 03:38:46', '', '0000-00-00 00:00:00'),
('202503020104', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030201', '2502171104', '1', '2502171104', '2025-03-03 03:38:46', '', '0000-00-00 00:00:00'),
('202503020203', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030202', '2502171104', '1', '2502171104', '2025-03-03 04:09:09', '', '0000-00-00 00:00:00'),
('202503020204', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030202', '2502171104', '1', '2502171104', '2025-03-03 04:09:09', '', '0000-00-00 00:00:00'),
('202503020303', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030203', '2502171104', '1', '2502171104', '2025-03-03 04:11:17', '', '0000-00-00 00:00:00'),
('202503020304', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030203', '2502171104', '1', '2502171104', '2025-03-03 04:11:17', '', '0000-00-00 00:00:00'),
('202503020403', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030204', '2502171104', '1', '2502171104', '2025-03-03 04:13:26', '', '0000-00-00 00:00:00'),
('202503020404', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030204', '2502171104', '1', '2502171104', '2025-03-03 04:13:26', '', '0000-00-00 00:00:00'),
('202503020503', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030205', '2502171104', '1', '2502171104', '2025-03-03 04:16:23', '', '0000-00-00 00:00:00'),
('202503020504', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030205', '2502171104', '1', '2502171104', '2025-03-03 04:16:23', '', '0000-00-00 00:00:00'),
('202503020105', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030201', '2502171104', '1', '2502171104', '2025-03-03 04:46:59', '', '0000-00-00 00:00:00'),
('202503020106', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030201', '2502171104', '1', '2502171104', '2025-03-03 04:46:59', '', '0000-00-00 00:00:00'),
('202503020205', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030202', '2502171104', '1', '2502171104', '2025-03-03 05:11:37', '', '0000-00-00 00:00:00'),
('202503020206', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030202', '2502171104', '1', '2502171104', '2025-03-03 05:11:37', '', '0000-00-00 00:00:00'),
('202503030101', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030301', '2502171104', '1', '2502171104', '2025-03-03 11:39:00', '', '0000-00-00 00:00:00'),
('202503030102', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030301', '2502171104', '1', '2502171104', '2025-03-03 11:39:00', '', '0000-00-00 00:00:00'),
('202503030201', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030302', '2502171104', '1', '2502171104', '2025-03-03 21:14:27', '', '0000-00-00 00:00:00'),
('202503030202', 'cv', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030302', '2502171104', '1', '2502171104', '2025-03-03 21:14:27', '', '0000-00-00 00:00:00'),
('202503040101', 'ktp', 'i', '../assets/doc/22-043_Devi Duwi Susanti_UTS.pdf', '2025030401', '2502171104', '1', '2502171104', '2025-03-04 09:27:24', '', '0000-00-00 00:00:00'),
('202503040102', 'cv', 'i', '../assets/doc/Surat Balasan Magang Diskominfo Sidoarjo.pdf', '2025030401', '2502171104', '1', '2502171104', '2025-03-04 09:27:24', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_instansi`
--

DROP TABLE IF EXISTS `tb_instansi`;
CREATE TABLE IF NOT EXISTS `tb_instansi` (
  `id_instansi` varchar(10) NOT NULL,
  `nama_pendek` varchar(100) DEFAULT NULL,
  `nama_panjang` varchar(255) DEFAULT NULL,
  `group_instansi` varchar(100) DEFAULT NULL,
  `telepone_instansi` varchar(20) DEFAULT NULL,
  `alamat_instansi` text,
  `lokasi_instansi` text,
  `deskripsi_instansi` text,
  `gambar_instansi` varchar(100) DEFAULT NULL,
  `status_active` char(1) DEFAULT '1',
  `create_by` varchar(14) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` varchar(14) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_instansi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_instansi`
--

INSERT INTO `tb_instansi` (`id_instansi`, `nama_pendek`, `nama_panjang`, `group_instansi`, `telepone_instansi`, `alamat_instansi`, `lokasi_instansi`, `deskripsi_instansi`, `gambar_instansi`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('438010000', 'SEKRETARIAT DAERAH', 'SEKRETARIAT DAERAH', '', '', '', '', '', 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', '2502251101', '2025-02-25 16:31:56'),
('438020000', 'Staf Ahli Bupati', 'Staf Ahli Bupati', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438030000', 'SEKRETARIAT DPRD', 'SEKRETARIAT DPRD', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438040000', 'Inspektorat Daerah', 'Inspektorat Daerah', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050100', 'Dinas Pendidikan dan Kebudayaan', 'Dinas Pendidikan dan Kebudayaan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050200', 'Dinas Kesehatan', 'Dinas Kesehatan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050201', 'RSUD Sidoarjo', 'RSUD Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050202', 'RSUD Sidoarjo Barat', 'RSUD Sidoarjo Barat', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050300', 'DINAS PUBMSDA', 'Dinas Pekerjaan Umum Bina Marga Dan Sumber Daya Air', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050400', 'DP2CKTR', 'Dinas Perumahan, Permukiman, Cipta Karya dan Tata Ruang', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050500', 'SATPOL PP', 'Satuan Polisi Pamong Praja', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050600', 'Dinas Sosial', 'Dinas Sosial', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050700', 'Dinas Tenaga Kerja', 'Dinas Tenaga Kerja', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438050900', 'DINAS P3AKB', 'Dinas Pemberdayaan Perempuan, Perlindungan Anak Dan Keluarga Berencana', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051000', 'Dinas Pangan dan Pertanian', 'Dinas Pangan dan Pertanian', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051100', 'Dinas Lingkungan Hidup dan Kebersihan', 'Dinas Lingkungan Hidup dan Kebersihan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051200', 'Dinas Kependudukan dan Pencatatan Sipil', 'Dinas Kependudukan dan Pencatatan Sipil', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051300', 'Dinas Perhubungan', 'Dinas Perhubungan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051400', 'Dinas Komunikasi dan Informatika', 'Dinas Komunikasi dan Informatika', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051500', 'Dinas Koperasi dan Usaha Mikro', 'Dinas Koperasi dan Usaha Mikro', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051600', 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051700', 'Dinas Kepemudaan, Olahraga, dan Pariwisata', 'Dinas Kepemudaan, Olahraga, dan Pariwisata', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051800', 'Dinas Perpustakaan dan Kearsipan', 'Dinas Perpustakaan dan Kearsipan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438051900', 'Dinas Perikanan', 'Dinas Perikanan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438052000', 'Dinas Perindustrian dan Perdagangan', 'Dinas Perindustrian dan Perdagangan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438060100', 'Badan Perencanaan Pembangunan Daerah', 'Badan Perencanaan Pembangunan Daerah', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438060200', 'Badan Pengelolaan Keuangan dan Aset Daerah', 'Badan Pengelolaan Keuangan dan Aset Daerah', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438060300', 'Badan Pelayanan Pajak Daerah', 'Badan Pelayanan Pajak Daerah', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438060400', 'Badan Kepegawaian Daerah', 'Badan Kepegawaian Daerah', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438060500', 'Badan Kesatuan Bangsa dan Politik', 'Badan Kesatuan Bangsa dan Politik', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438060600', 'BPBD', 'Badan Penanggulangan Bencana Daerah', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070100', 'Kecamatan Sidoarjo', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070101', 'Kelurahan Magersari', 'Kelurahan Magersari', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070102', 'Kelurahan Pucang', 'Kelurahan Pucang', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070103', 'Kelurahan Sidoklumpuk', 'Kelurahan Sidoklumpuk', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070104', 'Kelurahan Sidokumpul', 'Kelurahan Sidokumpul', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070105', 'Kelurahan Pucanganom', 'Kelurahan Pucanganom', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070106', 'Kelurahan Bulusidokare', 'Kelurahan Bulusidokare', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070107', 'Kelurahan Sekardangan', 'Kelurahan Sekardangan', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070108', 'Kelurahan Celep', 'Kelurahan Celep', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070109', 'Kelurahan Sidokare', 'Kelurahan Sidokare', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070110', 'Kelurahan Pekauman', 'Kelurahan Pekauman', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070111', 'Kelurahan Lemahputro', 'Kelurahan Lemahputro', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070112', 'Kelurahan Gebang', 'Kelurahan Gebang', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070113', 'Kelurahan Urangagung', 'Kelurahan Urangagung', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070114', 'Kelurahan Cemengkalang', 'Kelurahan Cemengkalang', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070200', 'Kecamatan Candi', 'Kecamatan Candi', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070300', 'Kecamatan Buduran', 'Kecamatan Buduran', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070400', 'Kecamatan Gedangan', 'Kecamatan Gedangan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070500', 'Kecamatan Sedati', 'Kecamatan Sedati', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070600', 'Kecamatan Waru', 'Kecamatan Waru', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070700', 'Kecamatan Taman', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070701', 'Kelurahan Taman', 'Kelurahan Taman', 'Kecamatan Taman', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070702', 'Kelurahan Ketegan', 'Kelurahan Ketegan', 'Kecamatan Taman', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070703', 'Kelurahan Sepanjang', 'Kelurahan Sepanjang', 'Kecamatan Taman', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070704', 'Kelurahan Wonocolo', 'Kelurahan Wonocolo', 'Kecamatan Taman', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070705', 'Kelurahan Bebekan', 'Kelurahan Bebekan', 'Kecamatan Taman', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070706', 'Kelurahan Ngelom', 'Kelurahan Ngelom', 'Kecamatan Taman', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070707', 'Kelurahan Kalijaten', 'Kelurahan Kalijaten', 'Kecamatan Taman', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070708', 'Kelurahan Geluran', 'Kelurahan Geluran', 'Kecamatan Taman', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070800', 'Kecamatan Krian', 'Kecamatan Krian', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070801', 'Kelurahan Krian', 'Kelurahan Krian', 'Kecamatan Krian', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070802', 'Kelurahan Tambakkemerakan', 'Kelurahan Tambakkemerakan', 'Kecamatan Krian', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070803', 'Kelurahan Kemasan', 'Kelurahan Kemasan', 'Kecamatan Krian', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438070900', 'Kecamatan Wonoayu', 'Kecamatan Wonoayu', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071000', 'Kecamatan Sukodono', 'Kecamatan Sukodono', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071100', 'Kecamatan Balongbendo', 'Kecamatan Balongbendo', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071200', 'Kecamatan Tarik', 'Kecamatan Tarik', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071300', 'Kecamatan Tulangan', 'Kecamatan Tulangan', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071400', 'Kecamatan Prambon', 'Kecamatan Prambon', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071500', 'Kecamatan Krembung', 'Kecamatan Krembung', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071600', 'Kecamatan Tanggulangin', 'Kecamatan Tanggulangin', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071700', 'Kecamatan Jabon', 'Kecamatan Jabon', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071800', 'Kecamatan Porong', 'Kecamatan Porong', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071801', 'Kelurahan Porong', 'Kelurahan Porong', 'Kecamatan Porong', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071802', 'Kelurahan Mindi', 'Kelurahan Mindi', 'Kecamatan Porong', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071803', 'Kelurahan Juwetkenongo', 'Kelurahan Juwetkenongo', 'Kecamatan Porong', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071804', 'Kelurahan Gedang', 'Kelurahan Gedang', 'Kecamatan Porong', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071805', 'Kelurahan Siring', 'Kelurahan Siring', 'Kecamatan Porong', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438071806', 'Kelurahan Jatirejo', 'Kelurahan Jatirejo', 'Kecamatan Porong', NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438080100', 'Perusahaan Umum Daerah Air Minum Delta Tirta', 'Perusahaan Umum Daerah Air Minum Delta Tirta', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438080200', 'Perusahaan Umum Daerah Aneka Usaha', 'Perusahaan Umum Daerah Aneka Usaha', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('438080300', 'Perusahaan Perseroan Daerah Delta Artha', 'Perusahaan Perseroan Daerah Delta Artha', NULL, NULL, NULL, NULL, NULL, 'logo_kab_sidoarjo.png', '1', '2502140804', '2025-02-25 16:10:36', NULL, NULL),
('1111222222', 'ww', 'qqqwwwwwwwwwwww', '1111111111', '1111111112222', '', '', '', 'logo_kab_sidoarjo.png', '0', '2502251101', '2025-02-26 05:49:59', '2502251101', '2025-02-26 05:50:57'),
('4380100000', '1', 'q', 'q', '1', '', '', '', 'logo_kab_sidoarjo.png', '1', '2502251101', '2025-02-26 07:58:59', NULL, NULL);

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

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendidikan`
--

DROP TABLE IF EXISTS `tb_pendidikan`;
CREATE TABLE IF NOT EXISTS `tb_pendidikan` (
  `id_pendidikan` varchar(7) NOT NULL,
  `nama_pendidikan` varchar(255) DEFAULT NULL,
  `fakultas` varchar(100) DEFAULT NULL,
  `jurusan` varchar(150) DEFAULT NULL,
  `alamat_pendidikan` text,
  `status_active` char(1) DEFAULT '1',
  `create_by` varchar(14) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` varchar(14) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pendidikan`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pendidikan`
--

INSERT INTO `tb_pendidikan` (`id_pendidikan`, `nama_pendidikan`, `fakultas`, `jurusan`, `alamat_pendidikan`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('00101', 'SMK Negeri 1 Sidoarjo', NULL, 'Teknik Konstruksi dan Perumahan', 'Jl. Monginsidi, Sidoklumpuk, Sidoarjo 61215', '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00102', 'SMK Negeri 1 Sidoarjo', NULL, 'Desain Pemodelan dan Informasi Bangunan', 'Jl. Monginsidi, Sidoklumpuk, Sidoarjo 61215', '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00103', 'SMK Negeri 1 Sidoarjo', NULL, 'Teknik Instalasi Tenaga Listrik', 'Jl. Monginsidi, Sidoklumpuk, Sidoarjo 61215', '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00104', 'SMK Negeri 1 Sidoarjo', NULL, 'Teknik Pendinginan dan Tata Udara', 'Jl. Monginsidi, Sidoklumpuk, Sidoarjo 61215', '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00105', 'SMK Negeri 1 Sidoarjo', NULL, 'Teknik Pemesinan', 'Jl. Monginsidi, Sidoklumpuk, Sidoarjo 61215', '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00106', 'SMK Negeri 1 Sidoarjo', NULL, 'Teknik Kendaraan Ringan Otomotif', 'Jl. Monginsidi, Sidoklumpuk, Sidoarjo 61215', '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00107', 'SMK Negeri 1 Sidoarjo', NULL, 'Teknik Audio Video', 'Jl. Monginsidi, Sidoklumpuk, Sidoarjo 61215', '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00201', 'SMK Yos Sudarso 2 Sidoarjo', NULL, 'Teknik Transmisi Telekomunikasi', NULL, '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00202', 'SMK Yos Sudarso 2 Sidoarjo', NULL, 'Perawat Kesehatan', NULL, '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('00203', 'SMK Yos Sudarso 2 Sidoarjo', NULL, 'Farmasi', NULL, '1', '2402171101', '2025-02-25 16:11:53', NULL, NULL),
('0010101', 'Universitas Trunojoyo Madura', 'Fakultas Ekonomi dan Bisnis', 'D-3 Akuntansi Sektor Publik', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010102', 'Universitas Trunojoyo Madura', 'Fakultas Ekonomi dan Bisnis', 'D-3 Kewirausahaan', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010103', 'Universitas Trunojoyo Madura', 'Fakultas Ekonomi dan Bisnis', 'S-1 Manajemen', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010104', 'Universitas Trunojoyo Madura', 'Fakultas Ekonomi dan Bisnis', 'S-1 Akuntansi', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010105', 'Universitas Trunojoyo Madura', 'Fakultas Ekonomi dan Bisnis', 'S-1 Ekonomi Pembangunan', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010106', 'Universitas Trunojoyo Madura', 'Fakultas Ekonomi dan Bisnis', 'S-2 Ilmu Ekonomi', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010107', 'Universitas Trunojoyo Madura', 'Fakultas Ekonomi dan Bisnis', 'S-2 Manajemen', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010108', 'Universitas Trunojoyo Madura', 'Fakultas Ekonomi dan Bisnis', 'S-2 Akuntansi Forensik', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010201', 'Universitas Trunojoyo Madura', 'Fakultas Pertanian', 'S-1 Teknologi Industri Pertanian', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010202', 'Universitas Trunojoyo Madura', 'Fakultas Pertanian', 'S-1 Agribisnis', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010203', 'Universitas Trunojoyo Madura', 'Fakultas Pertanian', 'S-1 Agroekoteknologi', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010204', 'Universitas Trunojoyo Madura', 'Fakultas Pertanian', 'S-1 Ilmu Kelautan dan Perikanan', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010205', 'Universitas Trunojoyo Madura', 'Fakultas Pertanian', 'S-1 Manajemen Sumberdaya Perairan', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010206', 'Universitas Trunojoyo Madura', 'Fakultas Pertanian', 'S-2 Pengelolaan Sumber Daya Alam', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010301', 'Universitas Trunojoyo Madura', 'Fakultas Teknik', 'S-1 Teknik Mekatronika', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010302', 'Universitas Trunojoyo Madura', 'Fakultas Teknik', 'S-1 Teknik Mesin', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010303', 'Universitas Trunojoyo Madura', 'Fakultas Teknik', 'S-1 Teknik Informatika', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010304', 'Universitas Trunojoyo Madura', 'Fakultas Teknik', 'S-1 Teknik Industri', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010305', 'Universitas Trunojoyo Madura', 'Fakultas Teknik', 'S-1 Teknik Elektro', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010306', 'Universitas Trunojoyo Madura', 'Fakultas Teknik', 'S-1 Sistem Informasi', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010401', 'Universitas Trunojoyo Madura', 'Fakultas Hukum', 'S-1 Ilmu Hukum', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010402', 'Universitas Trunojoyo Madura', 'Fakultas Hukum', 'S-2 Ilmu Hukum', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010501', 'Universitas Trunojoyo Madura', 'Fakultas Ilmu Pendidikan', 'S-1 Pendidikan Guru Sekolah Dasar', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010502', 'Universitas Trunojoyo Madura', 'Fakultas Ilmu Pendidikan', 'S-1 Pendidikan Anak Usia Dini', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010503', 'Universitas Trunojoyo Madura', 'Fakultas Ilmu Pendidikan', 'S-1 Pendidikan Ilmu Pengetahuan Alam', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010504', 'Universitas Trunojoyo Madura', 'Fakultas Ilmu Pendidikan', 'S-1 Pendidikan Informatika', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010505', 'Universitas Trunojoyo Madura', 'Fakultas Ilmu Pendidikan', 'S-1 Pendidikan Bahasa dan Sastra Indonesia', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010601', 'Universitas Trunojoyo Madura', 'Fakultas Ilmu Sosial dan Ilmu Budaya', 'S-1 Sosiologi', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010602', 'Universitas Trunojoyo Madura', 'Fakultas Ilmu Sosial dan Ilmu Budaya', 'S-1 Ilmu Komunikasi', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010603', 'Universitas Trunojoyo Madura', 'Fakultas Ilmu Sosial dan Ilmu Budaya', 'S-1 Sastra Inggris', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010701', 'Universitas Trunojoyo Madura', 'Fakultas Keislaman', 'S-1 Hukum Bisnis Syariah', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0010702', 'Universitas Trunojoyo Madura', 'Fakultas Keislaman', 'S-1 Ekonomi Syariah', NULL, '1', '2402171101', '2025-02-25 16:12:18', NULL, NULL),
('0020101', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Sains dan Analitika Data', 'Fisika', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020102', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Sains dan Analitika Data', 'Matematika', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020103', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Sains dan Analitika Data', 'Statistika', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020104', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Sains dan Analitika Data', 'Kimia', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020105', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Sains dan Analitika Data', 'Biologi', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020106', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Sains dan Analitika Data', 'Aktuaria', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020201', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Industri dan Rekayasa Sistem', 'Teknik Mesin', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020202', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Industri dan Rekayasa Sistem', 'Teknik Kimia', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020203', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Industri dan Rekayasa Sistem', 'Teknik Fisika', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020204', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Industri dan Rekayasa Sistem', 'Teknik Sistem dan Industri', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020205', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Industri dan Rekayasa Sistem', 'Teknik Material', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020301', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknik Sipil, Perencanaan, dan Kebumian', 'Teknik Sipil', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020302', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknik Sipil, Perencanaan, dan Kebumian', 'Arsitektur', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020303', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknik Sipil, Perencanaan, dan Kebumian', 'Teknik Lingkungan', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020304', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknik Sipil, Perencanaan, dan Kebumian', 'Perencanaan Wilayah dan Kota', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020305', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknik Sipil, Perencanaan, dan Kebumian', 'Teknik Geomatika', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020306', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknik Sipil, Perencanaan, dan Kebumian', 'Teknik Geofisika', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020401', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Kelautan', 'Teknik Perkapalan', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020402', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Kelautan', 'Teknik Sistem Perkapalan', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020403', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Kelautan', 'Teknik Kelautan', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020404', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Kelautan', 'Teknik Transportasi Laut', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020501', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Teknik Elektro', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020502', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Teknik Biomedik', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020503', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Teknik Informatika', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020504', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Teknologi Informasi', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020505', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Sistem Informasi', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020506', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Teknik Telekomunikasi', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020507', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Teknik Komputer', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020508', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Teknologi Elektro dan Informatika Cerdas', 'Teknologi Kedokteran', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020601', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Desain Kreatif dan Bisnis Digital', 'Desain Interior', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020602', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Desain Kreatif dan Bisnis Digital', 'Desain Komunikasi Visual', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020603', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Desain Kreatif dan Bisnis Digital', 'Manajemen Bisnis', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0020604', 'Institut Teknologi Sepuluh Nopember', 'Fakultas Desain Kreatif dan Bisnis Digital', 'Studi Pembangunan', NULL, '1', '2402171101', '2025-02-26 21:08:58', NULL, NULL),
('0030101', 'Universitas Airlangga', 'Fakultas Kedokteran', 'Kedokteran', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030102', 'Universitas Airlangga', 'Fakultas Kedokteran', 'Kebidanan', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030201', 'Universitas Airlangga', 'Fakultas Kedokteran Gigi', 'Kedokteran Gigi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030301', 'Universitas Airlangga', 'Fakultas Hukum', 'Ilmu Hukum', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030401', 'Universitas Airlangga', 'Fakultas Ekonomi dan Bisnis', 'Akuntansi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030402', 'Universitas Airlangga', 'Fakultas Ekonomi dan Bisnis', 'Manajemen', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030403', 'Universitas Airlangga', 'Fakultas Ekonomi dan Bisnis', 'Ekonomi Pembangunan', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030501', 'Universitas Airlangga', 'Fakultas Farmasi', 'Farmasi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030601', 'Universitas Airlangga', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Sosiologi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030602', 'Universitas Airlangga', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Ilmu Komunikasi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030603', 'Universitas Airlangga', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Ilmu Politik', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030604', 'Universitas Airlangga', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Hubungan Internasional', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030605', 'Universitas Airlangga', 'Fakultas Ilmu Sosial dan Ilmu Politik', 'Antropologi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030701', 'Universitas Airlangga', 'Fakultas Sains dan Teknologi', 'Matematika', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030702', 'Universitas Airlangga', 'Fakultas Sains dan Teknologi', 'Fisika', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030703', 'Universitas Airlangga', 'Fakultas Sains dan Teknologi', 'Biologi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030704', 'Universitas Airlangga', 'Fakultas Sains dan Teknologi', 'Kimia', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030705', 'Universitas Airlangga', 'Fakultas Sains dan Teknologi', 'Statistika', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030706', 'Universitas Airlangga', 'Fakultas Sains dan Teknologi', 'Sistem Informasi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030707', 'Universitas Airlangga', 'Fakultas Sains dan Teknologi', 'Teknik Lingkungan', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030708', 'Universitas Airlangga', 'Fakultas Sains dan Teknologi', 'Teknik Biomedis', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030801', 'Universitas Airlangga', 'Fakultas Kesehatan Masyarakat', 'Kesehatan Masyarakat', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030802', 'Universitas Airlangga', 'Fakultas Kesehatan Masyarakat', 'Ilmu Gizi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0030901', 'Universitas Airlangga', 'Fakultas Psikologi', 'Psikologi', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031001', 'Universitas Airlangga', 'Fakultas Ilmu Budaya', 'Sastra Indonesia', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031002', 'Universitas Airlangga', 'Fakultas Ilmu Budaya', 'Sastra Inggris', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031003', 'Universitas Airlangga', 'Fakultas Ilmu Budaya', 'Sastra Jepang', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031004', 'Universitas Airlangga', 'Fakultas Ilmu Budaya', 'Ilmu Sejarah', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031101', 'Universitas Airlangga', 'Fakultas Keperawatan', 'Keperawatan', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031201', 'Universitas Airlangga', 'Fakultas Perikanan dan Kelautan', 'Budidaya Perairan', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031202', 'Universitas Airlangga', 'Fakultas Perikanan dan Kelautan', 'Manajemen Sumber Daya Perairan', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031301', 'Universitas Airlangga', 'Fakultas Kedokteran Hewan', 'Kedokteran Hewan', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL),
('0031401', 'Universitas Airlangga', 'Fakultas Vokasi', 'Program Diploma (D3 & D4)', NULL, '1', '2402171101', '2025-02-26 21:09:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengajuan`
--

DROP TABLE IF EXISTS `tb_pengajuan`;
CREATE TABLE IF NOT EXISTS `tb_pengajuan` (
  `id_pengajuan` char(10) NOT NULL,
  `id_user` varchar(14) DEFAULT NULL,
  `id_instansi` varchar(10) DEFAULT NULL,
  `id_bidang` varchar(12) DEFAULT NULL,
  `jenis_pengajuan` varchar(100) DEFAULT NULL,
  `jumlah_pelamar` varchar(2) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_pengajuan` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '1',
  `status_active` char(1) DEFAULT '1',
  `create_by` varchar(14) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` varchar(14) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengajuan`),
  KEY `id_user` (`id_user`),
  KEY `id_instansi` (`id_instansi`),
  KEY `id_bidang` (`id_bidang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
('2502171104', 'DEVI DUWI SUSANTI', '3201010101010104', '', '220411100012', NULL, '0', 'Jakarta', '2003-02-17', 'Jl. Merdeka No. 1', '67b1fb1b02f38.jpg', '63257235341', NULL, NULL, NULL, '0010105', '2025030401', '1', '2502171104', '2025-02-26 21:06:57', NULL, '2025-03-04 09:27:24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id_user` varchar(14) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `level` char(1) DEFAULT NULL,
  `otp` char(6) DEFAULT NULL,
  `otp_expired` datetime DEFAULT NULL,
  `status_active` char(1) DEFAULT '1',
  `create_by` varchar(14) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` varchar(14) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `email`, `level`, `otp`, `otp_expired`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('2502171104', 'devia@gmail.com', '3', NULL, NULL, '1', '2502171104', '2025-02-26 20:46:28', NULL, '2025-03-04 09:26:20');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

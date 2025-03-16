-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 17, 2025 at 04:37 PM
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
-- Database: `db_magang`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_bidang`
--

DROP TABLE IF EXISTS `tb_bidang`;
CREATE TABLE IF NOT EXISTS `tb_bidang` (
  `id_bidang` varchar(11) NOT NULL,
  `nama_bidang` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `deskripsi_bidang` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `kriteria` text,
  `kuota` char(2) DEFAULT NULL,
  `dokumen_prasyarat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `id_instansi` varchar(9) DEFAULT NULL,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_bidang`),
  KEY `id_instansi` (`id_instansi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_bidang`
--

INSERT INTO `tb_bidang` (`id_bidang`, `nama_bidang`, `deskripsi_bidang`, `kriteria`, `kuota`, `dokumen_prasyarat`, `id_instansi`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('B4380701041', 'Pemberdayaan Masyarakat', 'Bidang sosial dan ekonomi', 'Mahasiswa Sosiologi, Mahasiswa Ilmu Komunikasi', '5', 'KTP, Surat Rekomendasi, CV, Proposal Magang', '438070104', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50'),
('B4380701052', 'Teknologi Informasi', 'Bidang pengelolaan sistem informasi', 'Mahasiswa Sistem Informasi, Mahasiswa Teknik Informatika', '3', 'KTP, CV, Surat Pengantar, Sertifikat Kompetensi', '438070105', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50'),
('B4380701051', 'Administrasi Kependudukan', 'Bidang pencatatan sipil', 'Mahasiswa Hukum, Mahasiswa Administrasi Publik', '0', 'KTP, Surat Keterangan, CV, Proposal Magang', '438070105', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 11:48:48'),
('B4380701062', 'Pelayanan Publik', 'Bidang layanan masyarakat', 'Mahasiswa Ilmu Pemerintahan, Mahasiswa Administrasi Publik', '6', 'KTP, Surat Pengantar, CV, Surat Rekomendasi', '438070106', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50'),
('B4380701061', 'Keuangan', 'Bidang pengelolaan keuangan', 'Mahasiswa Akuntansi, Mahasiswa Ekonomi', '4', 'KTP, Transkrip Nilai, CV, Proposal Magang', '438070106', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50'),
('B4380701071', 'Administrasi', 'Bidang administrasi umum', 'Mahasiswa Administrasi Publik, Mahasiswa Manajemen', '5', 'KTP, Surat Pengantar, CV, Proposal Magang', '438070107', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50'),
('B4380701072', 'IT Support', 'Bidang teknologi informasi', 'Mahasiswa Teknik Informatika, Mahasiswa Sistem Informasi', '3', 'KTP, CV, Surat Pengantar, Sertifikat Kompetensi', '438070107', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50'),
('B4380701042', 'Humas', 'Bidang komunikasi dan informasi', 'Mahasiswa Ilmu Komunikasi, Mahasiswa Jurnalistik', '4', 'KTP, CV, Surat Pengantar, Portofolio', '438070104', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50'),
('B4380701031', 'Layanan Perizinan', 'Bidang pengurusan izin usaha', 'Mahasiswa Administrasi Bisnis, Mahasiswa Hukum', '4', 'KTP, Surat Lamaran, CV, Proposal Magang', '438070103', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50'),
('B4380701032', 'Kepegawaian', 'Bidang manajemen sumber daya manusia', 'Mahasiswa Manajemen, Mahasiswa Psikologi', '3', 'KTP, CV, Surat Pengantar, Sertifikat Kompetensi', '438070103', 'Y', NULL, '2025-02-17 09:58:50', '2502140804', '2025-02-17 09:58:50');

-- --------------------------------------------------------

--
-- Table structure for table `tb_dokumen`
--

DROP TABLE IF EXISTS `tb_dokumen`;
CREATE TABLE IF NOT EXISTS `tb_dokumen` (
  `id_dokumen` char(12) NOT NULL,
  `nama_dokumen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jenis_dokumen` varchar(20) NOT NULL,
  `file_path` varchar(100) DEFAULT NULL,
  `id_pengajuan` char(10) DEFAULT NULL,
  `id_user` char(10) NOT NULL,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dokumen`),
  KEY `id_pengajuan` (`id_pengajuan`),
  KEY `fk_tb_dokumen_tb_user` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_instansi`
--

DROP TABLE IF EXISTS `tb_instansi`;
CREATE TABLE IF NOT EXISTS `tb_instansi` (
  `id_instansi` varchar(9) NOT NULL,
  `nama_pendek` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama_panjang` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `group_instansi` varchar(50) DEFAULT NULL,
  `alamat_instansi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `lokasi_instansi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `telepone_instansi` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `deskripsi_instansi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `gambar_instansi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_instansi`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_instansi`
--

INSERT INTO `tb_instansi` (`id_instansi`, `nama_pendek`, `nama_panjang`, `group_instansi`, `alamat_instansi`, `lokasi_instansi`, `telepone_instansi`, `deskripsi_instansi`, `gambar_instansi`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('438070107', 'Kelurahan Sekardangan', 'Kelurahan Sekardangan', 'Kecamatan Sidoarjo', 'kecamatan Sidoarjo, Kabupaten Sidoarjo, Jawa Timur, Indonesia.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7911.98731498656!2d112.7241915!3d-7.465950499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e6d71e2e7351%3A0x5f1df990f0b101cb!2sSekardangan%2C%20Kec.%20Sidoarjo%2C%20Kabupaten%20Sidoarjo%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1739763636907!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '083617362512', 'https://kelsekardangan.sidoarjokab.go.id/', NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, '2025-02-17 10:40:46'),
('438070106', 'Kelurahan Bulusidokare', 'Kelurahan Bulusidokare', 'Kecamatan Sidoarjo', 'kecamatan Sidoarjo, Kabupaten Sidoarjo, Jawa Timur, Indonesia.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7912.106546243543!2d112.72386449999999!3d-7.459358949999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e6ce2a378a3d%3A0xc4f8e79b214cb78c!2sBulusidokare%2C%20Kec.%20Sidoarjo%2C%20Kabupaten%20Sidoarjo%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1739763593863!5m2!1sid!2sid\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '084625371623', 'https://kelbulusidokare.sidoarjokab.go.id/', NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, '2025-02-17 10:40:14'),
('438070105', 'Kelurahan Pucanganom', 'Kelurahan Pucanganom', 'Kecamatan Sidoarjo', 'kecamatan Sidoarjo, Kabupaten Sidoarjo, Jawa Timur, Indonesia.', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.151203002589!2d112.7220722!3d-7.4485185000000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e6b61307d325%3A0x6f794bd0399e7337!2sKantor%20Kelurahan%20Sidoklumpuk!5e0!3m2!1sid!2sid!4v1739762004533!5m2!1sid!2sid\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '0846523711', 'https://kelpucanganom.sidoarjokab.go.id/', NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, '2025-02-17 10:36:58'),
('438070104', 'Kelurahan Sidokumpul', 'Kelurahan Sidokumpul', 'Kecamatan Sidoarjo', '17, Jl. Diponegoro Gang Kelurahan No.1, RT.17/RW.3, Rw3, Sidokumpul, Kabupaten Sidoarjo, Jawa Timur 61213', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.1114797208347!2d112.7150525!3d-7.452917599999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e134d29227ad%3A0x7b675f9048f5e451!2sKantor%20Kelurahan%20Sidokumpul!5e0!3m2!1sid!2sid!4v1739763516396!5m2!1sid!2sid\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '0973266653', 'https://kelsidokumpul.sidoarjokab.go.id/', NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, '2025-02-17 10:38:52'),
('438070103', 'Kelurahan Sidoklumpuk', 'Kelurahan Sidoklumpuk', 'Kecamatan Sidoarjo', 'Jl. Kartini No.47, Sidoklumpuk, Sidokumpul, Kec. Sidoarjo, Kabupaten Sidoarjo, Jawa Timur 61218', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3956.151203002589!2d112.7220722!3d-7.4485185000000005!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7e6b61307d325%3A0x6f794bd0399e7337!2sKantor%20Kelurahan%20Sidoklumpuk!5e0!3m2!1sid!2sid!4v1739762004533!5m2!1sid!2sid\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '084673242', 'https://kelsidoklumpuk.sidoarjokab.go.id/', NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, '2025-02-17 10:37:30'),
('438070102', 'Kelurahan Pucang', 'Kelurahan Pucang', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070101', 'Kelurahan Magersari', 'Kelurahan Magersari', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070100', 'Kecamatan Sidoarjo', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438060600', 'BPBD', 'Badan Penanggulangan Bencana Daerah', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438060500', 'Badan Kesatuan Bangsa dan Politik', 'Badan Kesatuan Bangsa dan Politik', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438060400', 'Badan Kepegawaian Daerah', 'Badan Kepegawaian Daerah', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438060300', 'Badan Pelayanan Pajak Daerah', 'Badan Pelayanan Pajak Daerah', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438060200', 'Badan Pengelolaan Keuangan dan Aset Daerah', 'Badan Pengelolaan Keuangan dan Aset Daerah', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438060100', 'Badan Perencanaan Pembangunan Daerah', 'Badan Perencanaan Pembangunan Daerah', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438052000', 'Dinas Perindustrian dan Perdagangan', 'Dinas Perindustrian dan Perdagangan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051900', 'Dinas Perikanan', 'Dinas Perikanan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051800', 'Dinas Perpustakaan dan Kearsipan', 'Dinas Perpustakaan dan Kearsipan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051700', 'Dinas Kepemudaan, Olahraga, dan Pariwisata', 'Dinas Kepemudaan, Olahraga, dan Pariwisata', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051600', 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', 'Dinas Penanaman Modal dan Pelayanan Terpadu Satu Pintu', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051500', 'Dinas Koperasi dan Usaha Mikro', 'Dinas Koperasi dan Usaha Mikro', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051400', 'Dinas Komunikasi dan Informatika', 'Dinas Komunikasi dan Informatika', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051300', 'Dinas Perhubungan', 'Dinas Perhubungan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051200', 'Dinas Kependudukan dan Pencatatan Sipil', 'Dinas Kependudukan dan Pencatatan Sipil', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051100', 'Dinas Lingkungan Hidup dan Kebersihan', 'Dinas Lingkungan Hidup dan Kebersihan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438051000', 'Dinas Pangan dan Pertanian', 'Dinas Pangan dan Pertanian', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050900', 'DINAS P3AKB', 'Dinas Pemberdayaan Perempuan, Perlindungan Anak Dan Keluarga Berencana', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050700', 'Dinas Tenaga Kerja', 'Dinas Tenaga Kerja', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050600', 'Dinas Sosial', 'Dinas Sosial', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050500', 'SATPOL PP', 'Satuan Polisi Pamong Praja', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050400', 'DP2CKTR', 'Dinas Perumahan, Permukiman, Cipta Karya dan Tata Ruang', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050300', 'DINAS PUBMSDA', 'Dinas Pekerjaan Umum Bina Marga Dan Sumber Daya Air', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050202', 'RSUD Sidoarjo Barat', 'RSUD Sidoarjo Barat', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050201', 'RSUD Sidoarjo', 'RSUD Sidoarjo', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050200', 'Dinas Kesehatan', 'Dinas Kesehatan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438050100', 'Dinas Pendidikan dan Kebudayaan', 'Dinas Pendidikan dan Kebudayaan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438030000', 'SEKRETARIAT DPRD', 'SEKRETARIAT DPRD', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438040000', 'Inspektorat Daerah', 'Inspektorat Daerah', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438020000', 'Staf Ahli Bupati', 'Staf Ahli Bupati', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438010000', 'SEKRETARIAT DAERAH', 'SEKRETARIAT DAERAH', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070108', 'Kelurahan Celep', 'Kelurahan Celep', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070109', 'Kelurahan Sidokare', 'Kelurahan Sidokare', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070110', 'Kelurahan Pekauman', 'Kelurahan Pekauman', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070111', 'Kelurahan Lemahputro', 'Kelurahan Lemahputro', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070112', 'Kelurahan Gebang', 'Kelurahan Gebang', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070113', 'Kelurahan Urangagung', 'Kelurahan Urangagung', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070114', 'Kelurahan Cemengkalang', 'Kelurahan Cemengkalang', 'Kecamatan Sidoarjo', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070200', 'Kecamatan Candi', 'Kecamatan Candi', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070300', 'Kecamatan Buduran', 'Kecamatan Buduran', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070400', 'Kecamatan Gedangan', 'Kecamatan Gedangan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070500', 'Kecamatan Sedati', 'Kecamatan Sedati', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070600', 'Kecamatan Waru', 'Kecamatan Waru', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070700', 'Kecamatan Taman', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070701', 'Kelurahan Taman', 'Kelurahan Taman', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070702', 'Kelurahan Ketegan', 'Kelurahan Ketegan', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070703', 'Kelurahan Sepanjang', 'Kelurahan Sepanjang', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070704', 'Kelurahan Wonocolo', 'Kelurahan Wonocolo', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070705', 'Kelurahan Bebekan', 'Kelurahan Bebekan', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070706', 'Kelurahan Ngelom', 'Kelurahan Ngelom', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070707', 'Kelurahan Kalijaten', 'Kelurahan Kalijaten', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070708', 'Kelurahan Geluran', 'Kelurahan Geluran', 'Kecamatan Taman', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070800', 'Kecamatan Krian', 'Kecamatan Krian', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070801', 'Kelurahan Krian', 'Kelurahan Krian', 'Kecamatan Krian', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070802', 'Kelurahan Tambakkemerakan', 'Kelurahan Tambakkemerakan', 'Kecamatan Krian', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070803', 'Kelurahan Kemasan', 'Kelurahan Kemasan', 'Kecamatan Krian', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438070900', 'Kecamatan Wonoayu', 'Kecamatan Wonoayu', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071000', 'Kecamatan Sukodono', 'Kecamatan Sukodono', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071100', 'Kecamatan Balongbendo', 'Kecamatan Balongbendo', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071200', 'Kecamatan Tarik', 'Kecamatan Tarik', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071300', 'Kecamatan Tulangan', 'Kecamatan Tulangan', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071400', 'Kecamatan Prambon', 'Kecamatan Prambon', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071500', 'Kecamatan Krembung', 'Kecamatan Krembung', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071600', 'Kecamatan Tanggulangin', 'Kecamatan Tanggulangin', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071700', 'Kecamatan Jabon', 'Kecamatan Jabon', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071800', 'Kecamatan Porong', 'Kecamatan Porong', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071801', 'Kelurahan Porong', 'Kelurahan Porong', 'Kecamatan Porong', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071802', 'Kelurahan Mindi', 'Kelurahan Mindi', 'Kecamatan Porong', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071803', 'Kelurahan Juwetkenongo', 'Kelurahan Juwetkenongo', 'Kecamatan Porong', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071804', 'Kelurahan Gedang', 'Kelurahan Gedang', 'Kecamatan Porong', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071805', 'Kelurahan Siring', 'Kelurahan Siring', 'Kecamatan Porong', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438071806', 'Kelurahan Jatirejo', 'Kelurahan Jatirejo', 'Kecamatan Porong', NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438080100', 'Perusahaan Umum Daerah Air Minum Delta Tirta', 'Perusahaan Umum Daerah Air Minum Delta Tirta', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438080200', 'Perusahaan Umum Daerah Aneka Usaha', 'Perusahaan Umum Daerah Aneka Usaha', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL),
('438080300', 'Perusahaan Perseroan Daerah Delta Artha', 'Perusahaan Perseroan Daerah Delta Artha', NULL, NULL, NULL, NULL, NULL, NULL, 'Y', '2502140804', '2025-02-16 01:28:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_logbook`
--

DROP TABLE IF EXISTS `tb_logbook`;
CREATE TABLE IF NOT EXISTS `tb_logbook` (
  `id_logbook` char(12) NOT NULL,
  `tanggal_logbook` date NOT NULL,
  `kegiatan_logbook` text NOT NULL,
  `keterangan_logbook` text,
  `id_pengajuan` char(10) NOT NULL,
  `id_user` char(10) NOT NULL,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_logbook`),
  KEY `fk_logbook_pengajuan` (`id_pengajuan`),
  KEY `fk_logbook_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_logbook`
--

INSERT INTO `tb_logbook` (`id_logbook`, `tanggal_logbook`, `kegiatan_logbook`, `keterangan_logbook`, `id_pengajuan`, `id_user`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('123456789000', '2025-02-17', 'membuat flowchart2', 'Tugas 1 membuat flowchart', '1234567890', '2502161101', 'Y', NULL, '2025-02-17 11:06:36', NULL, '2025-02-17 11:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembimbing`
--

DROP TABLE IF EXISTS `tb_pembimbing`;
CREATE TABLE IF NOT EXISTS `tb_pembimbing` (
  `id_pembimbing` varchar(13) NOT NULL,
  `nik_pembimbing` char(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nip_pembimbing` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nama_pembimbing` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL,
  `telepone_pembimbing` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_bidang` varchar(11) DEFAULT NULL,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pembimbing`),
  KEY `id_bidang` (`id_bidang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendidikan`
--

DROP TABLE IF EXISTS `tb_pendidikan`;
CREATE TABLE IF NOT EXISTS `tb_pendidikan` (
  `id_pendidikan` varchar(7) NOT NULL,
  `nama_pendidikan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fakultas` varchar(50) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `alamat_pendidikan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pendidikan`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pendidikan`
--

INSERT INTO `tb_pendidikan` (`id_pendidikan`, `nama_pendidikan`, `fakultas`, `jurusan`, `alamat_pendidikan`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('0010101', 'Universitas Trunojoyo Madura', 'Fakultas Teknik', 'Teknik Informatika', 'JL. Telang Kecamatan Kamal Kabupaten bangkalan', 'Y', '25010201', '2025-02-13 23:20:21', NULL, NULL),
('0010102', 'Universitas Trunojoyo Madura', 'Fakultas Teknik', 'Teknik Industri', 'JL. Telang Kecamatan Kamal Kabupaten bangkalan', 'Y', '25010201', '2025-02-13 23:26:07', NULL, NULL),
('0010201', 'Universitas Trunojoyo Madura', 'Fakultas Pendidikan', 'PGSD', 'JL. Telang Kecamatan Kamal Kabupaten bangkalan', 'Y', '25010201', '2025-02-13 23:26:07', NULL, NULL),
('0010202', 'Universitas Trunojoyo Madura', 'Fakultas Pendidikan', 'PGPAUD', 'JL. Telang Kecamatan Kamal Kabupaten bangkalan', 'Y', '25010201', '2025-02-13 23:26:07', NULL, NULL),
('0020101', 'Universitas Negri Surabaya', 'Fakultas Teknik', 'Teknik Industri', 'Surabaya', 'Y', '25010201', '2025-02-13 23:26:07', NULL, NULL),
('0020102', 'Universitas Negri Surabaya', 'Fakultas Teknik', 'Teknik Elektro', 'Surabaya', 'Y', '25010201', '2025-02-13 23:26:07', NULL, NULL),
('00101', 'SMK KRIAN 1', '', 'Rekayasa Perangkat Lunak', 'Sidoarjo', 'Y', '25010201', '2025-02-13 23:26:07', NULL, '2025-02-16 18:07:20'),
('00102', 'SMK KRIAN 1', '', 'Akuntansi', 'Sidoarjo', 'Y', '25010201', '2025-02-13 23:26:07', NULL, '2025-02-16 18:07:20'),
('00201', 'SMK BUDURAN 1', '', 'Teknik Komputer Jaringan', 'Sidoarjo', 'Y', '25010201', '2025-02-13 23:26:07', NULL, '2025-02-16 18:07:20'),
('00202', 'SMK BUDURAN 1', '', 'Multimedia', 'Sidoarjo', 'Y', '25010201', '2025-02-13 23:26:07', NULL, '2025-02-16 18:07:20'),
('0030101', 'Universitas Airlangga', 'Fakultas Pendidikan', 'Pendidikan Guru', 'surabaya', 'Y', '25010201', '2025-02-14 15:25:26', NULL, NULL),
('0030201', 'Universitas Airlangga', 'Fakultas Ilmu Sosial Dan Budaya', 'Sastra Inggris', 'surabaya', 'Y', '25010201', '2025-02-14 15:26:16', NULL, NULL),
('00301', 'SMK KRIAN 2', '', 'TKJ', 'sidoarjo', 'Y', '25010201', '2025-02-14 15:27:24', NULL, NULL),
('00302', 'SMK KRIAN 2', '', 'RPL', 'sidoarjo', 'Y', '25010201', '2025-02-14 15:27:24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengajuan`
--

DROP TABLE IF EXISTS `tb_pengajuan`;
CREATE TABLE IF NOT EXISTS `tb_pengajuan` (
  `id_pengajuan` char(10) NOT NULL,
  `id_user` char(10) DEFAULT NULL,
  `id_instansi` varchar(9) DEFAULT NULL,
  `id_bidang` varchar(11) DEFAULT NULL,
  `jenis_pengajuan` varchar(50) DEFAULT NULL,
  `calon_pelamar` varchar(2) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_selesai` date DEFAULT NULL,
  `status_pengajuan` varchar(20) DEFAULT NULL,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pengajuan`),
  KEY `id_user` (`id_user`),
  KEY `id_instansi` (`id_instansi`),
  KEY `id_bidang` (`id_bidang`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pengajuan`
--

INSERT INTO `tb_pengajuan` (`id_pengajuan`, `id_user`, `id_instansi`, `id_bidang`, `jenis_pengajuan`, `calon_pelamar`, `tanggal_mulai`, `tanggal_selesai`, `status_pengajuan`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('1234567890', '2502161101', '438070107', 'B4380701071', 'Magang', '1', '2025-02-01', '2025-05-31', 'Diterima', 'Y', NULL, '2025-02-17 11:04:58', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_profile_user`
--

DROP TABLE IF EXISTS `tb_profile_user`;
CREATE TABLE IF NOT EXISTS `tb_profile_user` (
  `id_user` char(10) NOT NULL,
  `nama_user` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nik` char(16) DEFAULT NULL,
  `nisn` char(10) DEFAULT NULL,
  `nim` varchar(15) DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat_user` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `gambar` varchar(100) DEFAULT NULL,
  `id_instansi` varchar(9) DEFAULT NULL,
  `id_pendidikan` varchar(7) DEFAULT NULL,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `telepone` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_instansi` (`id_instansi`),
  KEY `id_pendidikan` (`id_pendidikan`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_profile_user`
--

INSERT INTO `tb_profile_user` (`id_user`, `nama_user`, `nik`, `nisn`, `nim`, `jenis_kelamin`, `tempat_lahir`, `tanggal_lahir`, `alamat_user`, `gambar`, `id_instansi`, `id_pendidikan`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`, `telepone`) VALUES
('1', 'DEVI DUWI SUSANTI', '3123456785040002', '0012345673', NULL, 'P', 'Bojonegoro', '2004-05-18', 'bojonrgoro', 'avatar.png', NULL, '00201', 'Y', '2502140804', '2025-02-14 15:40:09', NULL, '2025-02-15 22:02:22', '123403255502'),
('2', 'HENDRA HARTONO', '3521245678900002', '0231234122', '220411100142', 'L', 'Bojonegoro', '2004-01-20', 'bojonegoro', 'avatar.png', NULL, '0020101', 'Y', '2502140803', '2025-02-14 15:39:15', NULL, '2025-02-15 22:02:22', '234123255502'),
('3', 'MISHBAHUS SURUR', '3526083005040002', '0044119922', '220411100013', 'L', 'Bangkalan', '2004-05-30', 'Jl.Sakera Sepulu No 52', '67af0095d756e.JPG', NULL, '0010101', 'Y', '2502140801', '2025-02-14 15:36:37', NULL, '2025-02-14 22:18:19', '0895803255502'),
('4', 'Revika Syariqatun Alifia', '3426012345040001', '5375723167', '', 'P', 'Bojonegoro', '2003-04-09', 'Bojonegoro', '1739702560_6 Monthly Membership Programs for Entrepreneurs.jpg', NULL, '00101', 'Y', '2502140802', '2025-02-14 15:38:07', NULL, '2025-02-16 18:31:07', '089712342341'),
('2502161101', 'Sarah', '3522209581003000', '0023459922', '0023459922', 'P', 'Bojonegoro', '2006-06-06', 'Bojonegoro', '67b1d064ea36b.png', NULL, '0010101', 'Y', '2502161101', '2025-02-16 18:47:48', NULL, NULL, '019382738212');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id_user` char(10) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `level` char(1) DEFAULT NULL,
  `otp` char(6) DEFAULT NULL,
  `otp_expired` datetime DEFAULT NULL,
  `status_active` char(1) DEFAULT 'Y',
  `create_by` char(10) DEFAULT NULL,
  `create_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `change_by` char(10) DEFAULT NULL,
  `change_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `email`, `level`, `otp`, `otp_expired`, `status_active`, `create_by`, `create_date`, `change_by`, `change_date`) VALUES
('1', 'heviaa@gmail.com', '1', NULL, NULL, 'Y', '2502140804', '2025-02-14 15:40:09', NULL, '2025-02-15 19:30:40'),
('2', 'hendra@gmail.com', '2', NULL, NULL, 'Y', '2502140803', '2025-02-14 15:39:15', NULL, '2025-02-15 11:42:43'),
('4', 'revika1@gmail.com', '3', NULL, NULL, 'Y', '2502140802', '2025-02-14 15:38:07', NULL, '2025-02-17 12:03:20'),
('3', 'mishbahus30@gmail.com', '4', NULL, NULL, 'Y', '2502140801', '2025-02-14 15:36:37', NULL, '2025-02-16 23:29:23'),
('2502161101', 'sarah@gmail.com', '3', NULL, NULL, 'Y', '2502161101', '2025-02-16 18:47:48', NULL, '2025-02-17 17:06:15'),
('67b311be95', 'sarah@gmail.com', '4', NULL, NULL, '1', NULL, '2025-02-17 10:38:54', NULL, NULL),
('67b311cfc7', 'sarah@gmail.com', '4', NULL, NULL, '1', NULL, '2025-02-17 10:39:11', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 04, 2025 at 02:56 AM
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
('2502171104', 'duwisusantidevi@gmail.com', '3', NULL, NULL, '1', '2502171104', '2025-02-26 20:46:28', NULL, '2025-03-04 09:53:35'),
('250217110301', 'saifulanam@gmail.com', '4', NULL, NULL, '1', '2502171103', '2025-02-26 20:46:28', NULL, NULL),
('250217110302', 'aliridho@gmail.com', '4', NULL, NULL, '1', '2502171103', '2025-02-26 20:46:28', NULL, NULL),
('2502171101', 'mishbahus30@gmail.com', '1', NULL, NULL, '1', 'developer', '2025-02-26 20:46:28', NULL, NULL),
('2502171102', 'hendrahartono815@gmail.com', '2', NULL, NULL, '1', '2502171101', '2025-02-26 20:46:28', NULL, NULL),
('2502171103', 'cacaalifiaaa@gmail.com', '3', NULL, NULL, '1', '2502171103', '2025-02-26 20:46:28', NULL, NULL),
('250217110303', 'mochammadmahrezarizkyfahrozi@gmail.com', '4', NULL, NULL, '1', '2502171103', '2025-02-26 20:46:28', NULL, NULL),
('250217110401', 'adyanbhagaskara@gmail.com', '4', NULL, NULL, '1', '2502171104', '2025-02-26 20:46:28', NULL, NULL),
('250217110402', 'muhammadhabiburrohman@gmail.com', '4', NULL, NULL, '1', '2502171104', '2025-02-26 20:46:28', NULL, NULL),
('250217110403', 'hablulwaridghozali@gmail.com', '4', NULL, NULL, '1', '2502171104', '2025-02-26 20:46:28', NULL, NULL),
('4380100000101', 'nikensalindri@gmail.com', '5', NULL, NULL, '1', '2502171102', '2025-02-26 20:46:28', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

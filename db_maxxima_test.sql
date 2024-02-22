-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 22, 2024 at 03:21 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_maxxima_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `krs`
--

CREATE TABLE `krs` (
  `id_krs` int(11) NOT NULL,
  `nim` char(10) NOT NULL,
  `nama_mk` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `krs`
--

INSERT INTO `krs` (`id_krs`, `nim`, `nama_mk`, `created_at`, `updated_at`) VALUES
(9, '2108048012', 'Dasar Komputer', '2024-02-22 00:14:49', '2024-02-22 00:14:49'),
(20, '2108048011', 'Bahasa Inggris', '2024-02-22 07:59:54', '2024-02-22 07:59:54'),
(22, '2108048011', 'Komputasi', '2024-02-22 08:24:38', '2024-02-22 08:24:38'),
(24, '2108048011', 'Jerman', '2024-02-22 08:26:05', '2024-02-22 08:26:05'),
(25, '2108048011', 'Korea', '2024-02-22 08:26:55', '2024-02-22 08:26:55'),
(27, '1234567890', 'Komputasi Dasar', '2024-02-22 08:45:16', '2024-02-22 08:45:16'),
(28, '1234567890', 'Bahasa Inggris', '2024-02-22 08:45:16', '2024-02-22 08:45:16'),
(29, '1234567890', 'Bahasa Arab', '2024-02-22 08:48:54', '2024-02-22 08:48:54'),
(30, '2108048020', 'Sastra Seni', '2024-02-22 08:50:11', '2024-02-22 08:50:11'),
(31, '1234567890', 'Pemrograman Web I', '2024-02-22 09:04:13', '2024-02-22 09:04:13'),
(32, '1234567890', 'Pemrograman Mobile', '2024-02-22 09:04:13', '2024-02-22 09:04:13');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` char(10) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `jk` enum('L','P') NOT NULL,
  `alamat` text NOT NULL,
  `file_krs` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `nama`, `jk`, `alamat`, `file_krs`, `created_at`, `updated_at`) VALUES
('1234567890', 'Furizal', 'L', 'Jl. Tuanku Tambusai, Pekanbaru, Riau', '20240222020351File 4 test.pdf', '2024-02-21 01:43:04', '2024-02-21 01:43:04'),
('2108048011', 'Rohani', 'P', 'Jl. Gadjah Mada, Yogyakarta, DIY', '20240222020323File 2 test.pdf', '2024-02-22 00:19:52', '2024-02-22 00:19:52'),
('2108048012', 'Dani Asmana', 'L', 'Jl. Ahmad Dahlan No.23, Batam, Kepulauan Riau', '20240222020343File 3 test.pdf', '2024-02-22 00:14:49', '2024-02-22 00:14:49'),
('2108048020', 'Rafika Anggraini', 'P', 'Jl. Pemuda No.3, Rokan Hulu, Riau', '20240222020256File 1 test.pdf', '2024-02-22 08:50:11', '2024-02-22 08:50:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `krs`
--
ALTER TABLE `krs`
  ADD PRIMARY KEY (`id_krs`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `krs`
--
ALTER TABLE `krs`
  MODIFY `id_krs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

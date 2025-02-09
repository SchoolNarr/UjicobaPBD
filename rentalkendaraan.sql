-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2025 at 08:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rentalkendaraan`
--

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `ID_Kendaraan` int(11) NOT NULL,
  `ID_Sewa` int(11) NOT NULL,
  `No_Polisi` varchar(20) NOT NULL,
  `Jenis_Kendaraan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`ID_Kendaraan`, `ID_Sewa`, `No_Polisi`, `Jenis_Kendaraan`) VALUES
(1, 1, 'L 1234 AB', 'Mobil'),
(2, 2, 'L 5678 CD', 'Motor'),
(3, 3, 'L 4325 CL', 'Mobil'),
(4, 4, 'L 2312 FD', 'Motor'),
(5, 5, 'L 2468 LK', 'Motor');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `ID_Pelanggan` int(11) NOT NULL,
  `Nama_Penyewa` varchar(100) NOT NULL,
  `No_KTP_SIM` varchar(50) NOT NULL,
  `Alamat` varchar(255) DEFAULT NULL,
  `No_Telp_HP` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`ID_Pelanggan`, `Nama_Penyewa`, `No_KTP_SIM`, `Alamat`, `No_Telp_HP`) VALUES
(1, 'Jono', '123456789', 'Surabaya', '08123456789'),
(2, 'Joni', '246802468', 'Bandung', '08777123456'),
(3, 'Jona', '234234324', 'Serang', '08836723543'),
(4, 'Jone', '345436543', 'Jakarta', '08543890345'),
(5, 'jonu', '257687314', 'Depok', '08902346545');

-- --------------------------------------------------------

--
-- Table structure for table `penyewaan`
--

CREATE TABLE `penyewaan` (
  `ID_Sewa` int(11) NOT NULL,
  `ID_Pelanggan` int(11) NOT NULL,
  `Lama_Sewa` varchar(50) DEFAULT NULL,
  `Tanggal_Diambil` date NOT NULL,
  `Waktu_Diambil` time NOT NULL,
  `Tanggal_Dikembalikan` date DEFAULT NULL,
  `Waktu_Dikembalikan` time DEFAULT NULL,
  `Driver_Non_Driver` varchar(50) DEFAULT NULL,
  `Biaya_Sewa` decimal(10,2) DEFAULT NULL,
  `Keterangan_Lain` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penyewaan`
--

INSERT INTO `penyewaan` (`ID_Sewa`, `ID_Pelanggan`, `Lama_Sewa`, `Tanggal_Diambil`, `Waktu_Diambil`, `Tanggal_Dikembalikan`, `Waktu_Dikembalikan`, `Driver_Non_Driver`, `Biaya_Sewa`, `Keterangan_Lain`) VALUES
(1, 1, '3 Hari', '2025-02-01', '09:00:00', '2025-02-04', '09:00:00', 'Driver', 1500000.00, 'Tidak ada'),
(2, 2, '3 Hari', '2025-01-02', '09:00:00', '2025-04-02', '09:00:00', 'Driver', 500000.00, 'Tidak ada'),
(3, 3, '3 Hari', '2025-02-01', '09:00:00', '2025-02-04', '09:00:00', 'Driver', 1500000.00, 'Tidak ada'),
(4, 4, '3 Hari', '2025-01-02', '09:00:00', '2025-04-02', '09:00:00', 'Driver', 500000.00, 'Tidak ada'),
(5, 5, '3 Hari', '2025-01-02', '09:00:00', '2025-04-02', '09:00:00', 'Driver', 500000.00, 'Tidak ada');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`ID_Kendaraan`),
  ADD KEY `ID_Sewa` (`ID_Sewa`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`ID_Pelanggan`);

--
-- Indexes for table `penyewaan`
--
ALTER TABLE `penyewaan`
  ADD PRIMARY KEY (`ID_Sewa`),
  ADD KEY `ID_Pelanggan` (`ID_Pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `ID_Kendaraan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `ID_Pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `penyewaan`
--
ALTER TABLE `penyewaan`
  MODIFY `ID_Sewa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD CONSTRAINT `kendaraan_ibfk_1` FOREIGN KEY (`ID_Sewa`) REFERENCES `penyewaan` (`ID_Sewa`);

--
-- Constraints for table `penyewaan`
--
ALTER TABLE `penyewaan`
  ADD CONSTRAINT `penyewaan_ibfk_1` FOREIGN KEY (`ID_Pelanggan`) REFERENCES `pelanggan` (`ID_Pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

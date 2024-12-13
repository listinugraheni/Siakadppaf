-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2024 at 05:13 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siakad`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_absensi`
--

CREATE TABLE `tbl_absensi` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id_santri` int(11) NOT NULL,
  `status` enum('Hadir','Sakit','Izin','Alfa') NOT NULL,
  `id_guru` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `mengajar` varchar(128) NOT NULL,
  `telpon` varchar(20) NOT NULL,
  `alamat` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`id`, `nama`, `mengajar`, `telpon`, `alamat`) VALUES
(6, 'Irsyidatu Ma\'wa', 'Hafalan Surat & Doa', '089619335948', 'Soman Lor, Selomartani, Kalasan, Sleman'),
(7, 'Alif Nur Rizqy', 'Fasholatan', '083149286002', 'Kadirojo I, Purwomartani, Kalasan, Sleman'),
(8, 'Arkhan Nur Fauzi', 'Hafalan Surat & Doa', '082324757703', 'Dayakan, Purwomartani, Kalasan, Sleman'),
(9, 'Alifia Nardia', 'Fasholatan', '082223904935', 'Cupuwatu I, Purwomartani, Kalasan, Sleman '),
(13, 'Anisa Wahyu Khasanah', 'Juz Amma & Al Qur\'an', '0895421433407', 'Dayakan, Purwomartani');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_laporan`
--

CREATE TABLE `tbl_laporan` (
  `id` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_santri` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `catatan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mapel`
--

CREATE TABLE `tbl_mapel` (
  `id` int(11) NOT NULL,
  `hari` varchar(100) NOT NULL,
  `pelajaran` varchar(50) NOT NULL,
  `guru` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_mapel`
--

INSERT INTO `tbl_mapel` (`id`, `hari`, `pelajaran`, `guru`) VALUES
(1, 'Senin', 'Hafalan Surat dan Doa', 'Irsyidatu Ma&#039;wa'),
(2, 'Selasa', 'Fasholatan', 'Alif Nur Rizqy'),
(3, 'Rabu', 'Juz Amma & Al Qur\'an', 'Anisa Wahyu Khasanah'),
(4, 'Jumat', 'Hafalan Surat dan Doa', 'Arkhan Nur Fauzi'),
(5, 'Sabtu', 'Fasholatan', 'Alifia Nardia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_santri`
--

CREATE TABLE `tbl_santri` (
  `id` int(10) NOT NULL,
  `nis` char(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_santri`
--

INSERT INTO `tbl_santri` (`id`, `nis`, `nama`, `alamat`) VALUES
(1, 'PPAF002', 'Hani', 'Sempu, Wedomartani'),
(2, 'PPAF003', 'Sauqi Nur Cahya', 'Dayakan, Purwomartani'),
(3, 'PPAF004', 'Hasyim', 'Sempu, Wedomartani'),
(4, 'PPAF005', 'Nadya', 'Salakan, Selomartani'),
(5, 'PPAF006', 'Tasya', 'Sambiroto, Purwomartani'),
(6, 'PPAF007', 'Nayara', 'Sanggrahan, Purwomartani'),
(7, 'PPAF008', 'Kaila', 'Salakan, Purwomartani');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tpa`
--

CREATE TABLE `tbl_tpa` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(256) NOT NULL,
  `nama` varchar(128) NOT NULL,
  `alamat` varchar(128) NOT NULL,
  `jenisuser` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `nama`, `alamat`, `jenisuser`) VALUES
(1, 'admin', '$2y$10$kW2HRTPNihVzEG91em6LSum80uwkoI8gtX805uAOqBb4BRQUUMEMm', 'fadli', 'sanggrahan', 'admin'),
(2, 'user', '$2y$10$KGqsHM9QSSlBXJs596KD0uBA83WZPRj3wZxS02Ece8KWDwyi9w6Ei', 'lala', 'dayakan', 'santri'),
(4, 'Irsyidatu', '$2y$10$7wdrNvrchKh17famcJw1zuTjRKiAxUEu63s87fLFEhCIIUjmMzdE2', 'Irsyidatu Ma\\\'wa', 'Soman, Selomartani, Kalasan, Sleman', 'guru'),
(5, 'listi', '$2y$10$mxGn4863J0QFj49AN8uXFOGi8RXinuuakyWLJuM2K7FUmXqU3FGYq', 'Listi Nugraheni', 'Dayakan05/02, Sanggrahan, Purwomartani, Kalasan, Sleman, Yogyakarta', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_santri` (`id_santri`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_santri` (`id_santri`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `tbl_mapel`
--
ALTER TABLE `tbl_mapel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_santri`
--
ALTER TABLE `tbl_santri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nis` (`nis`);

--
-- Indexes for table `tbl_tpa`
--
ALTER TABLE `tbl_tpa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_mapel`
--
ALTER TABLE `tbl_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_santri`
--
ALTER TABLE `tbl_santri`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  ADD CONSTRAINT `tbl_absensi_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `tbl_santri` (`id`),
  ADD CONSTRAINT `tbl_absensi_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `tbl_guru` (`id`);

--
-- Constraints for table `tbl_laporan`
--
ALTER TABLE `tbl_laporan`
  ADD CONSTRAINT `tbl_laporan_ibfk_1` FOREIGN KEY (`id_santri`) REFERENCES `tbl_santri` (`id`),
  ADD CONSTRAINT `tbl_laporan_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `tbl_guru` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

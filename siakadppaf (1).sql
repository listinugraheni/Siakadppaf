-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2024 at 04:40 AM
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
-- Database: `siakadppaf`
--

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
(13, 'Anisa Wahyu', 'Juz Amma & Al Qur\'an', '0895421433407', 'Dayakan, Purwomartani');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_laporan_mengaji`
--

CREATE TABLE `tbl_laporan_mengaji` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama` varchar(100) NOT NULL,
  `pelajaran` varchar(100) NOT NULL,
  `guru` varchar(100) NOT NULL,
  `laporan` text NOT NULL,
  `santri_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_laporan_mengaji`
--

INSERT INTO `tbl_laporan_mengaji` (`id`, `tanggal`, `nama`, `pelajaran`, `guru`, `laporan`, `santri_id`) VALUES
(22, '2024-08-26', 'Sauqi Nur Cahya', 'Juz Amma & Al Qur\'an', 'Anisa Wahyu Khasanah', 'Lanjut Surat Al-Baqoroh ayat 90', 0),
(26, '2024-08-26', 'Dwiyan Diki Mahendra', 'Fasholatan', 'Alif Nur Rizqy', 'Hafalan doa iftitah sudah lancar. jangan lupa praktekkan pada sholat 5 waktu', 0),
(27, '2024-08-26', 'Hasna Faiqah Azkiya', 'Fasholatan', 'Alifia Nardia', 'Hafalan doa iftitah masih kurang lancar. Lanjutkan hafalan dirumah!', 0),
(28, '2024-08-27', 'Hasna Faiqah Azkiya', 'Juz Amma & Al Qur\'an', 'Anisa Wahyu Khasanah', 'Lanjut Surat at-takatsur', 0),
(29, '2024-08-27', 'Sauqi Nur Cahya', 'Fasholatan', 'Alif Nur Rizqy', 'Hafalan bacaan doa qunut kurang lancar. lanjutkan hafalah dirumah', 0),
(30, '2024-08-27', 'Dwiyan Diki Mahendra', 'Fasholatan', 'Alif Nur Rizqy', 'Hafalah doa qunut sudah lancar.', 0),
(31, '2024-08-27', 'Sauqi Nur Cahya', 'Hafalan Surat dan Doa', 'Irsyidatu Ma\'wa', 'Hafalan doa masuk kamar mandi sudah lancar', 0);

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
(1, 'Senin', 'Hafalan Surat dan Doa', 'Irsyidatu Ma\'wa'),
(2, 'Selasa', 'Fasholatan', 'Alif Nur Rizqy'),
(3, 'Rabu', 'Juz Amma & Al Qur\'an', 'Anisa Wahyu Khasanah'),
(4, 'Jumat', 'Hafalan Surat dan Doa', 'Arkhan Nur Fauzi'),
(5, 'Sabtu', 'Fasholatan', 'Alifia Nardia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_newuser`
--

CREATE TABLE `tbl_newuser` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','santri') NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telpon` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_newuser`
--

INSERT INTO `tbl_newuser` (`id`, `username`, `password`, `role`, `nama`, `telpon`, `alamat`) VALUES
(11, 'listi', '$2y$10$NQ4lwpSUWfHYj6A1jJvsmuHEuo54Nl5TfJNtpJAZy9.grD8zDOqjK', 'admin', 'Listi Nugraheni', '089622255011', 'Dayakan, Purwomartani'),
(12, 'Sauqi', '$2y$10$63ALoeZ/ojwQOrVJUubbS.aoSnMIEKfcSSF0VCzGaJILx.sG/RXti', 'santri', 'Sauqi Nur Cahya', '0895380852010', 'Sanggrahan, Purwomartani'),
(13, 'hasnafaiqah', '$2y$10$G/XVYikpZ9GEnlaUsrsBxeFW0yRQXMHgkGHfitEL5HjP8mlSWA03K', 'santri', 'Hasna Faiqah Azkiya', '089525581400', 'Demangan, Selomartani'),
(14, 'Irsyidatu', '$2y$10$8TF9urAmXIWMPkOwtKpuAOnCn4N4VdIyQMOcnEFT4kTFuZYhMh3/O', 'admin', 'Irsyidatu Ma\'wa', '0895705438961', 'Soman, Selomartani'),
(15, 'Putri', '$2y$10$edOrBr40IDZDx2Db3/G8/ODbsXQsfTLqgPtB6bGlavt3tcGENfIpm', 'admin', 'Latifah Rosdiana Putri', '089523506444', 'Dayakan, Purwomartani'),
(16, 'Dwiyandiki', '$2y$10$TgAOis9zxZichVPhDuzu3Ok3nMVfBSldCca4KxtP5GashGyUfmAyC', 'santri', 'Dwiyan Diki Mahendra', '0895401218535', 'Dayakan, Purwomartani'),
(17, 'alifnur', '$2y$10$6V25yDOPiMZRQ/HNzXiixOzqOqYYNqXx94lyKM/ad1EBAw945mzgq', 'admin', 'Alif Nur Rizqy', '083149286002', 'Kadirojo II, Purwomartani');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_santri`
--

CREATE TABLE `tbl_santri` (
  `id` int(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `telpon` varchar(20) NOT NULL,
  `alamat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_santri`
--

INSERT INTO `tbl_santri` (`id`, `nama`, `telpon`, `alamat`) VALUES
(8, 'Sauqi Nur Cahya', '0895380852010', 'Dayakan, Purwomartani'),
(9, 'Hasna Faiqah Azkiya', '089525581400', 'Demangan, Selomartani');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_laporan_mengaji`
--
ALTER TABLE `tbl_laporan_mengaji`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_mapel`
--
ALTER TABLE `tbl_mapel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelajaran` (`pelajaran`);

--
-- Indexes for table `tbl_newuser`
--
ALTER TABLE `tbl_newuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nama` (`nama`);

--
-- Indexes for table `tbl_santri`
--
ALTER TABLE `tbl_santri`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_laporan_mengaji`
--
ALTER TABLE `tbl_laporan_mengaji`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tbl_mapel`
--
ALTER TABLE `tbl_mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_newuser`
--
ALTER TABLE `tbl_newuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tbl_santri`
--
ALTER TABLE `tbl_santri`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

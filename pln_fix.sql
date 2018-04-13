-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2018 at 01:26 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pln_fix`
--

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `userlevel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `userlevel`) VALUES
('admin', 'admin', 1),
('kasir', 'kasir', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `no_pelanggan` varchar(50) NOT NULL,
  `nama_pelanggan` varchar(30) NOT NULL,
  `alamat_pelanggan` text NOT NULL,
  `id_tarif` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`no_pelanggan`, `nama_pelanggan`, `alamat_pelanggan`, `id_tarif`) VALUES
('1', 'Dimas', 'Jonggol', 't002'),
('2', 'Pak. H. Aulia Idrawan, CCIE, C', 'MQ4', 't002');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `tgl_bayar` date NOT NULL,
  `id_tagihan` int(11) NOT NULL,
  `biaya_denda` double NOT NULL,
  `biaya_admin` double NOT NULL,
  `status_pembayaran` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `tgl_bayar`, `id_tagihan`, `biaya_denda`, `biaya_admin`, `status_pembayaran`) VALUES
(1, '2018-03-21', 2, 2000, 5000, 'Lunas'),
(2, '2018-10-10', 1, 1000, 5000, 'Lunas');

--
-- Triggers `pembayaran`
--
DELIMITER $$
CREATE TRIGGER `status` AFTER INSERT ON `pembayaran` FOR EACH ROW BEGIN
 UPDATE tagihan SET tagihan.status_tagihan = 'sudah bayar'
  WHERE new.id_tagihan=tagihan.id_tagihan;
  
  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `query_pembayaran`
-- (See below for the actual view)
--
CREATE TABLE `query_pembayaran` (
`id_pembayaran` int(11)
,`tgl_bayar` date
,`id_tagihan` int(11)
,`tahun_tagih` year(4)
,`bulan_tagih` varchar(10)
,`pemakaian` int(11)
,`no_pelanggan` varchar(10)
,`nama_pelanggan` varchar(30)
,`daya` varchar(50)
,`tarif_perkwh` double
,`ket` varchar(50)
,`biaya_denda` double
,`biaya_admin` double
,`status_pembayaran` varchar(15)
,`Total_tagihan` double
);

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id_tagihan` int(11) NOT NULL,
  `tahun_tagih` year(4) NOT NULL,
  `bulan_tagih` varchar(10) NOT NULL,
  `pemakaian` int(11) NOT NULL,
  `status_tagihan` varchar(15) NOT NULL,
  `no_pelanggan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id_tagihan`, `tahun_tagih`, `bulan_tagih`, `pemakaian`, `status_tagihan`, `no_pelanggan`) VALUES
(1, 2018, 'Desember', 100, 'Belum Bayar', '1'),
(2, 2017, 'Februari', 4000, 'Lunas', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` varchar(50) NOT NULL,
  `daya` varchar(50) NOT NULL,
  `tarif_perkwh` double NOT NULL,
  `ket` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `daya`, `tarif_perkwh`, `ket`) VALUES
('t001', 'R-1/450 VA', 415, 'Non Subsidi'),
('t002', 'R-1/900 VA', 586, 'Subsidi'),
('t003', 'R-1/450 VA', 1352, 'Non Subsidi');

-- --------------------------------------------------------

--
-- Structure for view `query_pembayaran`
--
DROP TABLE IF EXISTS `query_pembayaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_pembayaran`  AS  select `pembayaran`.`id_pembayaran` AS `id_pembayaran`,`pembayaran`.`tgl_bayar` AS `tgl_bayar`,`pembayaran`.`id_tagihan` AS `id_tagihan`,`tagihan`.`tahun_tagih` AS `tahun_tagih`,`tagihan`.`bulan_tagih` AS `bulan_tagih`,`tagihan`.`pemakaian` AS `pemakaian`,`tagihan`.`no_pelanggan` AS `no_pelanggan`,`pelanggan`.`nama_pelanggan` AS `nama_pelanggan`,`tarif`.`daya` AS `daya`,`tarif`.`tarif_perkwh` AS `tarif_perkwh`,`tarif`.`ket` AS `ket`,`pembayaran`.`biaya_denda` AS `biaya_denda`,`pembayaran`.`biaya_admin` AS `biaya_admin`,`pembayaran`.`status_pembayaran` AS `status_pembayaran`,((`tagihan`.`pemakaian` * `tarif`.`tarif_perkwh`) + (`pembayaran`.`biaya_denda` + `pembayaran`.`biaya_admin`)) AS `Total_tagihan` from (((`pembayaran` join `pelanggan`) join `tarif`) join `tagihan`) where ((`pembayaran`.`id_tagihan` = `tagihan`.`id_tagihan`) and (`tagihan`.`no_pelanggan` = `pelanggan`.`no_pelanggan`) and (`pelanggan`.`id_tarif` = `tarif`.`id_tarif`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`no_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id_tagihan`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id_tagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2016 at 10:48 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `clean_inv`
--

-- --------------------------------------------------------

--
-- Table structure for table `sdk_waste`
--

CREATE TABLE IF NOT EXISTS `sdk_waste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(50) NOT NULL,
  `time_input` datetime NOT NULL,
  `user` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbladminreq`
--

CREATE TABLE IF NOT EXISTS `tbladminreq` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbladminreq`
--

INSERT INTO `tbladminreq` (`id`, `nama`, `keterangan`, `status`) VALUES
(1, 'BAR', 'eko', '1'),
(2, 'BAR', 'dodi', '1'),
(3, 'Kitchen', 'Fachmy', '1'),
(4, 'Service', 'Adit', '1'),
(5, 'Asset', 'Antony', '1'),
(6, 'Kitchen', 'Ryan', '1'),
(7, 'Service', 'Giofanny', '1'),
(8, 'Service', 'Cahyadi', '1'),
(9, 'Asset', 'Fachmy_Ast', '1'),
(10, 'Asset', 'Eko_Ast', '1'),
(11, 'Asset', 'Rebecca', '1'),
(12, 'Kitchen', 'Bayu', '1'),
(13, 'Asset', 'Florina Megawati', '1'),
(14, 'Asset', 'Bayu-A', '1'),
(15, 'Bar', 'Andro', '1'),
(16, 'Bar', 'Basri', '1'),
(17, 'Kitchen', 'Awang', '1'),
(18, 'Service', 'Ridwan', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbladminstatusakses`
--

CREATE TABLE IF NOT EXISTS `tbladminstatusakses` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `access_level` varchar(50) NOT NULL,
  `form_report` varchar(50) NOT NULL,
  `keterangan` varchar(100) NOT NULL,
  `enabled` bit(1) NOT NULL DEFAULT b'1',
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Dumping data for table `tbladminstatusakses`
--

INSERT INTO `tbladminstatusakses` (`id`, `access_level`, `form_report`, `keterangan`, `enabled`, `status`) VALUES
(1, 'Administrator', '(Menu Admin)', 'Menu Admin', '1', '1'),
(2, 'Administrator', '(Menu Master File)', 'Menu Master File', '1', '1'),
(3, 'Administrator', '(Menu Report)', 'Menu Report', '1', '1'),
(4, 'Administrator', '(Menu Transaction)', 'Menu Transaction', '1', '1'),
(5, 'Administrator', '(Menu User Account)', 'Menu User Account', '1', '1'),
(6, 'Administrator', '(Menu Utility)', 'Menu Utility', '1', '1'),
(7, 'Administrator', 'Admin - Status Akses', 'Status Akses', '1', '1'),
(22, 'Manager', '(Menu Admin)', 'Menu Admin', '1', '1'),
(23, 'Manager', '(Menu Master File)', 'Menu Master File', '1', '1'),
(24, 'Manager', '(Menu Report)', 'Menu Report', '1', '1'),
(25, 'Manager', '(Menu Transaction)', 'Menu Transaction', '1', '1'),
(26, 'Manager', '(Menu User Account)', 'Menu User Account', '1', '1'),
(27, 'Manager', '(Menu Utility)', 'Menu Utility', '1', '1'),
(28, 'Manager', 'Admin - Status Akses', 'Status Akses', '1', '1'),
(29, 'Purchasing', '(Menu Admin)', 'Menu Admin', '1', '1'),
(30, 'Purchasing', '(Menu Master File)', 'Menu Master File', '1', '1'),
(31, 'Purchasing', '(Menu Report)', 'Menu Report', '1', '1'),
(32, 'Purchasing', '(Menu Transaction)', 'Menu Transaction', '1', '1'),
(33, 'Purchasing', '(Menu User Account)', 'Menu User Account', '1', '1'),
(34, 'Purchasing', '(Menu Utility)', 'Menu Utility', '1', '1'),
(35, 'Purchasing', 'Admin - Status Akses', 'Status Akses', '1', '1'),
(36, 'Administrator', 'Admin - Requester', 'Requester', '1', '1'),
(37, 'Manager', 'Admin - Requester', 'Requester', '1', '1'),
(38, 'Purchasing', 'Admin - Requester', 'Requester', '1', '1'),
(39, 'Administrator', 'Master File - Daftar Barang', 'Daftar Barang', '1', '1'),
(40, 'Manager', 'Master File - Daftar Barang', 'Daftar Barang', '1', '1'),
(41, 'Purchasing', 'Master File - Daftar Barang', 'Daftar Barang', '1', '1'),
(42, 'Administrator', 'Master File - Daftar Supplier', 'Daftar Supplier', '1', '1'),
(43, 'Manager', 'Master File - Daftar Supplier', 'Daftar Supplier', '1', '1'),
(44, 'Purchasing', 'Master File - Daftar Supplier', 'Daftar Supplier', '1', '1'),
(45, 'Administrator', 'Transaction - Keluar Barang', 'Keluar Barang', '1', '1'),
(46, 'Manager', 'Transaction - Keluar Barang', 'Keluar Barang', '1', '1'),
(47, 'Purchasing', 'Transaction - Keluar Barang', 'Keluar Barang', '1', '1'),
(48, 'Administrator', 'Transaction - Masuk Barang', 'Masuk Barang', '1', '1'),
(49, 'Manager', 'Transaction - Masuk Barang', 'Masuk Barang', '1', '1'),
(50, 'Purchasing', 'Transaction - Masuk Barang', 'Masuk Barang', '1', '1'),
(51, 'Administrator', 'Transaction - Pembelian', 'Pembelian', '1', '1'),
(52, 'Manager', 'Transaction - Pembelian', 'Pembelian', '1', '1'),
(53, 'Purchasing', 'Transaction - Pembelian', 'Pembelian', '1', '1'),
(54, 'Administrator', 'Transaction - Waste', 'Waste', '1', '1'),
(55, 'Manager', 'Transaction - Waste', 'Waste', '1', '1'),
(56, 'Purchasing', 'Transaction - Waste', 'Waste', '1', '1'),
(57, 'Administrator', 'Report - Transaksi Barang', 'Transaksi Barang', '1', '1'),
(58, 'Manager', 'Report - Transaksi Barang', 'Transaksi Barang', '1', '1'),
(59, 'Purchasing', 'Report - Transaksi Barang', 'Transaksi Barang', '1', '1'),
(60, 'Administrator', 'Report - Stock Opname', 'Stock Opname', '1', '1'),
(61, 'Manager', 'Report - Stock Opname', 'Stock Opname', '1', '1'),
(62, 'Purchasing', 'Report - Stock Opname', 'Stock Opname', '1', '1'),
(63, 'Administrator', 'Utility - Stock On Hand', 'Stock On Hand', '1', '1'),
(64, 'Manager', 'Utility - Stock On Hand', 'Stock On Hand', '1', '1'),
(65, 'Purchasing', 'Utility - Stock On Hand', 'Stock On Hand', '1', '1'),
(66, 'Administrator', 'Utility - Stock Opname', 'Stock Opname', '1', '1'),
(67, 'Manager', 'Utility - Stock Opname', 'Stock Opname', '1', '1'),
(68, 'Purchasing', 'Utility - Stock Opname', 'Stock Opname', '1', '1'),
(69, 'Administrator', 'Utility - User Track', 'User Track', '1', '1'),
(70, 'Manager', 'Utility - User Track', 'User Track', '1', '1'),
(71, 'Purchasing', 'Utility - User Track', 'User Track', '1', '1'),
(72, 'Administrator', 'User Account - Add User', 'Add User', '1', '1'),
(73, 'Manager', 'User Account - Add User', 'Add User', '1', '1'),
(74, 'Purchasing', 'User Account - Add User', 'Add User', '1', '1'),
(75, 'Administrator', 'User Account - Change Password', 'Change Password', '1', '1'),
(76, 'Manager', 'User Account - Change Password', 'Change Password', '1', '1'),
(77, 'Purchasing', 'User Account - Change Password', 'Change Password', '1', '1'),
(78, 'Administrator', 'Admin - Department', 'Department', '1', '1'),
(79, 'Manager', 'Admin - Department', 'Department', '1', '1'),
(80, 'Purchasing', 'Admin - Department', 'Department', '1', '1'),
(81, 'Administrator', 'Master File - Daftar Resep', 'Daftar Resep', '1', '1'),
(82, 'Manager', 'Master File - Daftar Resep', 'Daftar Resep', '1', '1'),
(83, 'Purchasing', 'Master File - Daftar Resep', 'Daftar Resep', '1', '1'),
(84, 'Gudang', '(Menu Admin)', 'Menu Admin', '1', '1'),
(85, 'Gudang', '(Menu Master File)', 'Menu Master File', '1', '1'),
(86, 'Gudang', '(Menu Report)', 'Menu Report', '1', '1'),
(87, 'Gudang', '(Menu Transaction)', 'Menu Transaction', '1', '1'),
(88, 'Gudang', '(Menu User Account)', 'Menu User Account', '1', '1'),
(89, 'Gudang', '(Menu Utility)', 'Menu Utility', '1', '1'),
(90, 'Gudang', 'Admin - Department', 'Department', '1', '1'),
(91, 'Gudang', 'Admin - Requester', 'Requester', '1', '1'),
(92, 'Gudang', 'Admin - Status Akses', 'Status Akses', '1', '1'),
(93, 'Gudang', 'Master File - Daftar Barang', 'Daftar Barang', '1', '1'),
(94, 'Gudang', 'Master File - Daftar Resep', 'Daftar Resep', '1', '1'),
(95, 'Gudang', 'Master File - Daftar Supplier', 'Daftar Supplier', '1', '1'),
(96, 'Gudang', 'Report - Stock Opname', 'Stock Opname', '1', '1'),
(97, 'Gudang', 'Report - Transaksi Barang', 'Transaksi Barang', '1', '1'),
(98, 'Gudang', 'Transaction - Keluar Barang', 'Keluar Barang', '1', '1'),
(99, 'Gudang', 'Transaction - Masuk Barang', 'Masuk Barang', '1', '1'),
(100, 'Gudang', 'Transaction - Pembelian', 'Pembelian', '1', '1'),
(101, 'Gudang', 'Transaction - Waste', 'Waste', '1', '1'),
(102, 'Gudang', 'User Account - Add User', 'Add User', '1', '1'),
(103, 'Gudang', 'User Account - Change Password', 'Change Password', '1', '1'),
(104, 'Gudang', 'Utility - Stock On Hand', 'Stock On Hand', '1', '1'),
(105, 'Gudang', 'Utility - Stock Opname', 'Stock Opname', '1', '1'),
(106, 'Gudang', 'Utility - User Track', 'User Track', '1', '1'),
(107, 'Administrator', 'Transaction - Manufaktur', 'Manufaktur', '1', '1'),
(108, 'Gudang', 'Transaction - Manufaktur', 'Manufaktur', '1', '1'),
(109, 'Manager', 'Transaction - Manufaktur', 'Manufaktur', '1', '1'),
(110, 'Purchasing', 'Transaction - Manufaktur', 'Manufaktur', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblhistoriharga`
--

CREATE TABLE IF NOT EXISTS `tblhistoriharga` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(10) NOT NULL,
  `harga` double NOT NULL,
  `harga_baru` double NOT NULL,
  `tanggal` datetime NOT NULL,
  `user` varchar(20) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblhistoripo`
--

CREATE TABLE IF NOT EXISTS `tblhistoripo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_po` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `kode_barang` varchar(10) NOT NULL,
  `harga` double NOT NULL,
  `harga_baru` double NOT NULL,
  `jumlah` int(5) NOT NULL,
  `jumlah_baru` int(5) NOT NULL,
  `diskon` double NOT NULL,
  `diskon_baru` double NOT NULL,
  `type_disc` varchar(10) NOT NULL,
  `type_disc_baru` varchar(10) NOT NULL,
  `user` varchar(50) NOT NULL,
  `keterangan` varchar(50) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterbank`
--

CREATE TABLE IF NOT EXISTS `tblmasterbank` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_bank` varchar(3) NOT NULL,
  `nama_bank` varchar(10) NOT NULL,
  `kode_issuer` varchar(3) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `tblmasterbank`
--

INSERT INTO `tblmasterbank` (`id`, `kode_bank`, `nama_bank`, `kode_issuer`, `keterangan`, `status`) VALUES
(8, 'B01', 'BCA', 'I02', '', '1'),
(7, 'B20', 'BCA', 'I01', '', '1'),
(6, 'B21', 'ANZ', 'I02', '', '1'),
(5, 'B22', 'ANZ', 'I01', '', '1'),
(9, 'B23', 'BII', 'I01', '', '1'),
(10, 'B24', 'BII', 'I02', '', '1'),
(11, 'B25', 'BNI', 'I01', '', '1'),
(12, 'B26', 'BNI', 'I02', '', '1'),
(13, 'B27', 'BRI', 'I01', '', '1'),
(14, 'B37', 'BRI', 'I02', '', '1'),
(15, 'B36', 'BTN', 'I01', '', '1'),
(16, 'B28', 'BTN', 'I02', '', '1'),
(17, 'B29', 'Bukopin', 'I01', '', '1'),
(18, 'B30', 'Bukopin', 'I02', '', '1'),
(19, 'B31', 'CIMB Niaga', 'I01', '', '1'),
(20, 'B32', 'CIMB Niaga', 'I02', '', '1'),
(21, 'B33', 'Citibank', 'I01', '', '1'),
(22, 'B34', 'Citibank', 'I02', '', '1'),
(23, 'B35', 'Danamon', 'I01', '', '1'),
(24, 'B47', 'Danamon', 'I02', '', '1'),
(25, 'B46', 'Danamon', 'I03', '', '1'),
(26, 'B45', 'HSBC', 'I01', '', '1'),
(27, 'B44', 'HSBC', 'I02', '', '1'),
(28, 'B43', 'ICB Bumipu', 'I01', '', '1'),
(29, 'B42', 'ICB Bumipu', 'I02', '', '1'),
(30, 'B41', 'Mandiri', 'I01', '', '1'),
(31, 'B40', 'Mandiri', 'I02', '', '1'),
(32, 'B39', 'Mega', 'I01', '', '1'),
(33, 'B38', 'Mega', 'I02', '', '1'),
(34, 'B56', 'OCBC NISP', 'I01', '', '1'),
(35, 'B55', 'OCBC NISP', 'I02', '', '1'),
(36, 'B48', 'Panin', 'I01', '', '1'),
(37, 'B49', 'Panin', 'I02', '', '1'),
(38, 'B50', 'Permata', 'I01', '', '1'),
(39, 'B51', 'Permata', 'I02', '', '1'),
(40, 'B52', 'Stanchart', 'I01', '', '1'),
(41, 'B53', 'Stanchart', 'I02', '', '1'),
(42, 'B54', 'UOB', 'I01', '', '1'),
(43, 'B55', 'UOB', 'I02', '', '1'),
(44, 'B57', 'AEON', 'I02', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterbarang`
--

CREATE TABLE IF NOT EXISTS `tblmasterbarang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(50) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `jml_konv` int(11) NOT NULL,
  `satuan_konv` varchar(20) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `harga` double NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tblmasterbarang`
--

INSERT INTO `tblmasterbarang` (`id`, `kode_barang`, `nama_barang`, `satuan`, `jml_konv`, `satuan_konv`, `keterangan`, `harga`, `status`) VALUES
(1, 'BG00001', 'Garam Dolphine', 'Kg', 1000, 'Gram', '', 1000, '1'),
(2, 'BG00002', 'Wortel', 'Kg', 1000, 'Gram', '', 20000, '1'),
(3, 'BG00003', 'Chicken Powder', 'Pcs', 1, 'Pcs', '', 5000, '1'),
(4, 'BG00004', 'Kecap Bango 600ml', 'botol', 6, 'Gram', '', 10000, '1'),
(5, 'BG00005', 'Diamond Ice Cream Vanilla', 'box', 1000, 'Gram', '', 40000, '1'),
(6, 'BG00006', 'Iceberg Lettuce', 'pack', 1000, 'Gram', '', 20000, '1'),
(7, 'BG00007', 'Jamur Shimeji', 'Liter', 100, 'ML', '', 30000, '1'),
(8, 'BG00008', 'Smoke Cheese', 'Kg', 1000, 'Gram', '', 30000, '1'),
(9, 'BG00009', 'Nasi Putih', 'Pcs', 250, 'Gram', '', 5000, '0'),
(10, 'BG00010', 'Beras', 'Liter', 1, 'Liter', '', 7000, '1'),
(11, 'BG00011', 'Paha ayam tanpa kulit', 'gram', 1, 'gram', '', 5000, '1'),
(12, 'BG00012', 'Tahu Pong', 'Kg', 1000, 'Gram', '', 10000, '1'),
(13, 'BG00013', 'Terong', 'Kg', 1000, 'Gram', '', 7500, '1'),
(14, 'BG00014', 'Mini Strawberry Cakes', 'Pcs', 1, 'Pcs', '', 54000, '1'),
(15, 'BG00015', 'Mini Chocolate Cake', 'Loyang', 6, 'pcs', '', 300000, '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmastercategory`
--

CREATE TABLE IF NOT EXISTS `tblmastercategory` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_cat` varchar(5) NOT NULL,
  `nama_cat` varchar(30) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tblmastercategory`
--

INSERT INTO `tblmastercategory` (`id`, `kode_cat`, `nama_cat`, `status`) VALUES
(3, 'C0001', 'Asian Corner', '1'),
(4, 'C0002', 'Soft Drink', '1'),
(5, 'C0003', 'Cakes', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmastercustomer`
--

CREATE TABLE IF NOT EXISTS `tblmastercustomer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_cust` varchar(5) NOT NULL,
  `nama_cust` varchar(50) NOT NULL,
  `kode_ctype` varchar(3) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `tblmastercustomer`
--

INSERT INTO `tblmastercustomer` (`id`, `kode_cust`, `nama_cust`, `kode_ctype`, `pin`, `keterangan`, `status`) VALUES
(1, 'C0001', 'Prinantors', 'CT4', '12345', '', '1'),
(2, 'C0002', 'William', 'CT1', '5678', '', '1'),
(3, 'C0003', 'Sidik', 'CT2', '1357', '', '1'),
(4, 'C0004', 'Effendy', 'CT1', 'PZN-490880', '', '1'),
(5, 'C0005', 'Anez', 'CT1', '1', '', '1'),
(7, 'C0006', 'ADE', 'CT5', '01', '', '1'),
(8, 'C0007', 'wakakak', 'CT2', '1234', '', '0'),
(9, 'C0008', 'MR. EMM', 'CT2', '02', '', '1'),
(10, 'C0009', 'TAMU REGULER', 'CT2', '11', '', '1'),
(11, 'C0010', 'ADE 10%', 'CT9', '12', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmastercustomer_type`
--

CREATE TABLE IF NOT EXISTS `tblmastercustomer_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_ctype` varchar(10) NOT NULL,
  `nama_ctype` varchar(25) NOT NULL,
  `disc` double NOT NULL,
  `svc` double NOT NULL,
  `tax` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `tblmastercustomer_type`
--

INSERT INTO `tblmastercustomer_type` (`id`, `kode_ctype`, `nama_ctype`, `disc`, `svc`, `tax`, `keterangan`, `status`) VALUES
(1, 'CT1', 'Owner', 15, 0, 0, '', '1'),
(2, 'CT2', 'Member', 10, 5, 10, '', '1'),
(3, 'CT3', 'Marketing', 0, 0, 0, '', '1'),
(4, 'CT4', 'Gold Member', 25, 6.5, 10, '', '1'),
(5, 'CT5', 'DISC PROMO 15%', 15, 0, 10, '', '1'),
(42, 'CT8', 'wawa', 0, 0, 0, '', '0'),
(41, 'CT7', 'Ganteng Cekali', 55, 34, 10, '', '1'),
(40, 'CT6', 'wkwk', 5, 5, 5, '', '0'),
(43, 'CT9', 'ADE 10%', 10, 0, 10, '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterdisc`
--

CREATE TABLE IF NOT EXISTS `tblmasterdisc` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_disc` varchar(3) NOT NULL,
  `nama_disc` varchar(10) NOT NULL,
  `type_disc` varchar(1) NOT NULL DEFAULT 'N',
  `nominal_disc` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `tblmasterdisc`
--

INSERT INTO `tblmasterdisc` (`id`, `kode_disc`, `nama_disc`, `type_disc`, `nominal_disc`, `keterangan`, `status`) VALUES
(1, 'D01', '5 %', 'P', 5, '', '1'),
(2, 'D02', '10 %', 'P', 10, '', '1'),
(3, 'D03', '15 %', 'P', 15, '', '1'),
(4, 'D04', '20 %', 'P', 20, '', '1'),
(5, 'D05', '25 %', 'P', 25, '', '1'),
(6, 'D06', '50 %', 'P', 50, '', '1'),
(7, 'D07', '75 %', 'P', 75, '', '1'),
(8, 'D08', '5000', 'N', 5000, '', '1'),
(9, 'D09', '10000', 'N', 10000, '', '1'),
(10, 'D10', '15000', 'N', 15000, '', '1'),
(11, 'D11', '25000', 'N', 25000, '', '1'),
(12, 'D12', 'No Disc', 'P', 0, '', '1'),
(13, 'D13', '17.5%', 'P', 17.5, '', '1'),
(14, 'D14', 'Freeeeeee', 'P', 0, '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterissuer`
--

CREATE TABLE IF NOT EXISTS `tblmasterissuer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_issuer` varchar(3) NOT NULL,
  `nama_issuer` varchar(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tblmasterissuer`
--

INSERT INTO `tblmasterissuer` (`id`, `kode_issuer`, `nama_issuer`, `keterangan`, `status`) VALUES
(1, 'I01', 'VISA', '', '1'),
(2, 'I02', 'Master Card', '', '1'),
(3, 'I03', 'AMEX', '', '1'),
(4, 'I04', 'Diner`s', '', '1'),
(5, 'I05', 'JCB', '', '1'),
(6, 'I06', 'Other', '', '1'),
(7, 'I07', 'Disc card', '', '1'),
(8, 'I08', 'BANK NENEK', '', '0'),
(9, 'I09', 'Bams', '', '0'),
(10, 'I10', 'ganteng', '', '0');

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterlokasi`
--

CREATE TABLE IF NOT EXISTS `tblmasterlokasi` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_lokasi` varchar(3) NOT NULL,
  `nama_lokasi` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `svc` varchar(3) NOT NULL,
  `tax` varchar(3) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `takeaway` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tblmasterlokasi`
--

INSERT INTO `tblmasterlokasi` (`id`, `kode_lokasi`, `nama_lokasi`, `keterangan`, `svc`, `tax`, `status`, `takeaway`) VALUES
(1, 'L01', 'Indoor', '', '', '', '1', ''),
(2, 'L02', 'Outdoor', '', '', '', '1', ''),
(3, 'L03', 'Smoking', '', '', '', '0', ''),
(4, 'L04', 'Rooftop', '', '', '', '0', ''),
(5, 'L05', 'Take Away', '', '0', '', '1', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `tblmastermeja`
--

CREATE TABLE IF NOT EXISTS `tblmastermeja` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_meja` varchar(10) NOT NULL,
  `nama_meja` varchar(10) NOT NULL,
  `kode_lokasi` varchar(3) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `tblmastermeja`
--

INSERT INTO `tblmastermeja` (`id`, `kode_meja`, `nama_meja`, `kode_lokasi`, `keterangan`, `status`) VALUES
(1, 'T001', 'I01', 'L01', '', '1'),
(2, 'T002', 'I02', 'L01', '', '1'),
(3, 'T003', 'I03', 'L01', '', '1'),
(4, 'T004', 'O01', 'L02', '', '1'),
(5, 'T005', 'O02', 'L02', '', '1'),
(6, 'T006', 'O03', 'L02', '', '1'),
(7, 'T007', 'T01', 'L05', '', '1'),
(8, 'T008', 'T02', 'L05', '', '1'),
(9, 'T009', 'T03', 'L05', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmastermenu`
--

CREATE TABLE IF NOT EXISTS `tblmastermenu` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_menu` varchar(5) NOT NULL,
  `nama_menu` varchar(30) NOT NULL,
  `kode_cat` varchar(5) NOT NULL,
  `paket` varchar(5) NOT NULL DEFAULT '0',
  `harga` double NOT NULL,
  `tax` varchar(1) NOT NULL DEFAULT '0',
  `svc` varchar(1) NOT NULL DEFAULT '0',
  `kode_printer` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `img` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tblmastermenu`
--

INSERT INTO `tblmastermenu` (`id`, `kode_menu`, `nama_menu`, `kode_cat`, `paket`, `harga`, `tax`, `svc`, `kode_printer`, `keterangan`, `status`, `img`) VALUES
(1, 'M0001', 'Nasi Goreng Kampung', 'C0001', '', 65000, '0', '0', 'P01', '', '1', 'nasgorkampung.jpg'),
(2, 'M0002', 'Nasi Goreng Seafood', 'C0001', '', 60000, '0', '0', 'P01', '', '1', 'nasgorseafood.png'),
(3, 'M0003', 'Coca Cola', 'C0002', '', 10000, '0', '0', 'P01', '', '1', 'cola.jpg'),
(4, 'M0004', 'Fanta', 'C0002', '', 10000, '0', '0', 'P01', '', '1', 'fanta.jpg'),
(5, 'M0005', 'Air mineral', 'C0002', '', 8000, '0', '0', 'P01', '', '1', 'mineral.jpg'),
(6, 'M0006', 'Mini Strawberry Cakes', 'C0003', '', 44000, '0', '0', 'P01', '', '1', 'stawcake.jpg'),
(7, 'M0007', 'Mini Chocolate Cake', 'C0003', '', 54000, '0', '0', 'P01', '', '1', 'chococake.jpg'),
(8, 'M0008', 'Marinate Paha Ayam', 'C0001', '', 30000, '0', '0', 'P01', '', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblmastermenu_paket`
--

CREATE TABLE IF NOT EXISTS `tblmastermenu_paket` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_menupaket` varchar(5) NOT NULL,
  `kode_menu` varchar(5) NOT NULL,
  `qty` int(11) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterprinter`
--

CREATE TABLE IF NOT EXISTS `tblmasterprinter` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_printer` varchar(3) NOT NULL,
  `printer_alias` varchar(10) NOT NULL,
  `printer_loc` varchar(50) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tblmasterprinter`
--

INSERT INTO `tblmasterprinter` (`id`, `kode_printer`, `printer_alias`, `printer_loc`, `keterangan`, `status`) VALUES
(1, 'P01', 'K1', 'Generic', '', '1'),
(2, 'P02', 'K2', 'Generic', '', '1'),
(3, 'P03', 'K3', 'Generic', '', '1'),
(4, 'P04', 'B1', 'Generic', '', '1'),
(5, 'P05', 'C1', 'Generic', '', '1'),
(6, 'P06', 'XPS', 'Microsoft XPS Document Writer', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterresep`
--

CREATE TABLE IF NOT EXISTS `tblmasterresep` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_resep` varchar(10) NOT NULL,
  `nama_resep` varchar(50) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tblmasterresep`
--

INSERT INTO `tblmasterresep` (`id`, `kode_resep`, `nama_resep`, `satuan`, `keterangan`, `status`) VALUES
(1, 'RC00001', 'Marinate Paha Ayam', 'Gram', '', '1'),
(2, 'RC00002', 'Nasi Goreng Kampung', 'Serve', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterresep_detail`
--

CREATE TABLE IF NOT EXISTS `tblmasterresep_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_resep` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tblmasterresep_detail`
--

INSERT INTO `tblmasterresep_detail` (`id`, `kode_resep`, `kode_barang`, `jumlah`, `satuan`, `keterangan`, `status`) VALUES
(1, 'RC00001', 'BG00001', 40, 'Gram', '', '1'),
(2, 'RC00001', 'BG00011', 10, 'gram', '', '1'),
(3, 'RC00001', 'BG00003', 3, 'Pcs', '', '1'),
(4, 'RC00001', 'BG00004', 40, 'Gram', '', '1'),
(5, 'RC00001', 'BG00012', 120, 'Gram', '', '1'),
(6, 'RC00001', 'BG00013', 20, 'Gram', '', '1'),
(24, 'RC00002', 'RC00001', 10, 'Gram', '', '1'),
(23, 'RC00002', 'BG00008', 20, 'Gram', '', '1'),
(22, 'RC00002', 'BG00007', 15, 'ML', '', '1'),
(21, 'RC00002', 'BG00006', 30, 'Gram', '', '1'),
(20, 'RC00002', 'BG00005', 10, 'Gram', '', '1'),
(19, 'RC00002', 'BG00004', 5, 'Gram', '', '1'),
(18, 'RC00002', 'BG00003', 1, 'Pcs', '', '1'),
(17, 'RC00002', 'BG00002', 30, 'Gram', '', '1'),
(16, 'RC00002', 'BG00001', 3, 'Gram', '', '1'),
(25, 'RC00002', 'BG00009', 250, 'Gram', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmastersupplier`
--

CREATE TABLE IF NOT EXISTS `tblmastersupplier` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_supplier` varchar(5) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `pic` varchar(20) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `no_telp` varchar(50) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tblmastersupplier`
--

INSERT INTO `tblmastersupplier` (`id`, `kode_supplier`, `nama_supplier`, `pic`, `alamat`, `no_telp`, `keterangan`, `status`) VALUES
(1, 'SP001', 'Kitchenia', 'Bambang', 'Jl.Galur', '021-42889827', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblmasterwaiter`
--

CREATE TABLE IF NOT EXISTS `tblmasterwaiter` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_waiter` varchar(5) NOT NULL,
  `nama_waiter` varchar(50) NOT NULL,
  `pin` varchar(20) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tblmasterwaiter`
--

INSERT INTO `tblmasterwaiter` (`id`, `kode_waiter`, `nama_waiter`, `pin`, `keterangan`, `status`) VALUES
(1, 'W001', 'Empri', '0', 'Manager', '1'),
(2, 'W002', 'Susis', '1', 'Waiter', '1'),
(4, 'W003', 'Sidik', '123', 'Kasir', '1'),
(6, 'W0004', 'sdksss', '04444', 'Kitchen', '0'),
(7, 'W004', 'Sidik', '11', 'SIDIK', '0'),
(8, 'W005', 'bamssss', '000', 'Manager', '0'),
(9, 'W006', 'Bams', '123', 'None', '1'),
(10, 'W007', 'RIDWAN', '1', 'Kasir', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblpos_to_inv`
--

CREATE TABLE IF NOT EXISTS `tblpos_to_inv` (
  `pos_id` varchar(10) NOT NULL,
  `inv_id` varchar(10) NOT NULL,
  `input_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblpos_to_inv`
--

INSERT INTO `tblpos_to_inv` (`pos_id`, `inv_id`, `input_date`) VALUES
('M0001', 'RC00002', '2016-09-08 14:59:58'),
('M0008', 'RC00001', '2016-09-08 17:34:50'),
('M0006', 'BG00014', '2016-09-09 09:19:03'),
('M0007', 'BG00015', '2016-09-09 09:22:24');

-- --------------------------------------------------------

--
-- Table structure for table `tbltransaksibarang`
--

CREATE TABLE IF NOT EXISTS `tbltransaksibarang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_transaksi` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=246 ;

--
-- Dumping data for table `tbltransaksibarang`
--

INSERT INTO `tbltransaksibarang` (`id`, `no_bukti`, `tanggal`, `jenis_transaksi`, `kode_barang`, `jumlah`, `keterangan`, `per`, `status`) VALUES
(1, 'MSK/1609/0001', '2016-09-08', 'MSK', 'BG00001', 2000, '', '1609', '1'),
(2, 'MSK/1609/0001', '2016-09-08', 'MSK', 'BG00002', 2000, '', '1609', '1'),
(3, 'MSK/1609/0001', '2016-09-08', 'MSK', 'BG00003', 12, '', '1609', '1'),
(4, 'MSK/1609/0001', '2016-09-08', 'MSK', 'BG00004', 30, '', '1609', '1'),
(5, 'MSK/1609/0001', '2016-09-08', 'MSK', 'BG00005', 3000, '', '1609', '1'),
(6, 'MSK/1609/0001', '2016-09-08', 'MSK', 'BG00006', 3000, '', '1609', '1'),
(7, 'MSK/1609/0001', '2016-09-08', 'MSK', 'BG00007', 200, '', '1609', '1'),
(8, 'MSK/1609/0001', '2016-09-08', 'MSK', 'BG00008', 5000, '', '1609', '1'),
(9, 'MSK/1609/0002', '2016-09-08', 'MSK', 'BG00001', 20000, '', '1609', '1'),
(10, 'MSK/1609/0002', '2016-09-08', 'MSK', 'BG00002', 10000, '', '1609', '1'),
(11, 'MSK/1609/0002', '2016-09-08', 'MSK', 'BG00003', 25, '', '1609', '1'),
(12, 'MSK/1609/0002', '2016-09-08', 'MSK', 'BG00004', 120, '', '1609', '1'),
(13, 'MSK/1609/0002', '2016-09-08', 'MSK', 'BG00005', 15000, '', '1609', '1'),
(14, 'MSK/1609/0002', '2016-09-08', 'MSK', 'BG00006', 10000, '', '1609', '1'),
(15, 'MSK/1609/0002', '2016-09-08', 'MSK', 'BG00007', 1500, '', '1609', '1'),
(16, 'MSK/1609/0002', '2016-09-08', 'MSK', 'BG00008', 10000, '', '1609', '1'),
(17, 'MSK/1609/0003', '2016-09-08', 'MSK', 'BG00012', 30000, '', '1609', '1'),
(18, 'MSK/1609/0003', '2016-09-08', 'MSK', 'BG00013', 15000, '', '1609', '1'),
(19, 'MFC/1609/0001', '2016-09-08', 'MFC', 'RC00001', 300, '', '1609', '1'),
(20, 'MFC/1609/0001', '2016-09-08', 'MFC', 'BG00001', -12000, 'RC00001-', '1609', '1'),
(21, 'MFC/1609/0001', '2016-09-08', 'MFC', 'BG00011', -3000, 'RC00001-', '1609', '1'),
(22, 'MFC/1609/0001', '2016-09-08', 'MFC', 'BG00003', -900, 'RC00001-', '1609', '1'),
(23, 'MFC/1609/0001', '2016-09-08', 'MFC', 'BG00004', -12000, 'RC00001-', '1609', '1'),
(24, 'MFC/1609/0001', '2016-09-08', 'MFC', 'BG00012', -36000, 'RC00001-', '1609', '1'),
(25, 'MFC/1609/0001', '2016-09-08', 'MFC', 'BG00013', -6000, 'RC00001-', '1609', '1'),
(26, 'T16090001', '2016-09-08', 'POS', 'M0001', -2, '', '1609', '1'),
(210, 'MFC/1609/0002', '2016-09-08', 'MFC', 'RC00002', 4, '', '____', '1'),
(211, 'MFC/1609/0002', '2016-09-08', 'MFC', 'RC00001', -40, 'RC00002-', '____', '1'),
(212, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00008', -80, 'RC00002-', '____', '1'),
(213, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00007', -60, 'RC00002-', '____', '1'),
(214, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00006', -120, 'RC00002-', '____', '1'),
(215, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00005', -40, 'RC00002-', '____', '1'),
(216, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00004', -20, 'RC00002-', '____', '1'),
(228, 'MFC/1609/0003', '2016-09-09', 'MFC', 'RC00002', 10, '', '1609', '1'),
(227, 'T16090006', '2016-09-09', 'POS', 'M0001', -1, '', '1609', '1'),
(226, 'T16090006', '2016-09-09', 'POS', 'M0007', -2, '', '1609', '1'),
(225, 'MSK/1609/0004', '2016-09-09', 'MSK', 'BG00015', 12, '', '1609', '1'),
(224, 'T16090005', '2016-09-09', 'POS', 'M0006', -1, '', '1609', '1'),
(223, 'T16090001', '2016-09-08', 'POS', 'M0008', -1, '', '1609', '1'),
(222, 'T16090005', '2016-09-08', 'POS', 'M0001', -2, '', '1609', '1'),
(220, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00009', -1000, 'RC00002-', '____', '1'),
(219, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00001', -12, 'RC00002-', '____', '1'),
(218, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00002', -120, 'RC00002-', '____', '1'),
(217, 'MFC/1609/0002', '2016-09-08', 'MFC', 'BG00003', -4, 'RC00002-', '____', '1'),
(221, 'T16090004', '2016-09-08', 'POS', 'M0001', -2, '', '1609', '1'),
(184, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00001', 0, 'Gram', '1609', '1'),
(185, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00001', 0, 'Gram', '1609', '1'),
(186, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00002', 0, 'Gram', '1609', '1'),
(183, 'T16090003', '2016-09-09', 'POS', 'M0001', -2, '', '1609', '1'),
(187, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00002', 0, 'Gram', '1609', '1'),
(188, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00003', 0, 'Pcs', '1609', '1'),
(189, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00003', 0, 'Pcs', '1609', '1'),
(190, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00004', 0, 'Gram', '1609', '1'),
(191, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00004', 0, 'Gram', '1609', '1'),
(192, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00005', 0, 'Gram', '1609', '1'),
(193, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00005', 0, 'Gram', '1609', '1'),
(194, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00006', 0, 'Gram', '1609', '1'),
(195, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00006', 0, 'Gram', '1609', '1'),
(196, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00007', 0, 'ML', '1609', '1'),
(197, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00007', 0, 'ML', '1609', '1'),
(198, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00008', 0, 'Gram', '1609', '1'),
(199, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00008', 0, 'Gram', '1609', '1'),
(200, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00011', 0, 'gram', '1609', '1'),
(201, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00011', 0, 'gram', '1609', '1'),
(202, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00012', 0, 'Gram', '1609', '1'),
(203, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00012', 0, 'Gram', '1609', '1'),
(204, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'BG00013', 0, 'Gram', '1609', '1'),
(205, 'SOP/1609/0001', '2016-09-08', 'SA', 'BG00013', 0, 'Gram', '1609', '1'),
(206, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'RC00001', 0, 'Gram', '1609', '1'),
(207, 'SOP/1609/0001', '2016-09-08', 'SA', 'RC00001', 0, 'Gram', '1609', '1'),
(208, 'SOP/1609/0001', '2016-09-07', 'ADJ SO', 'RC00002', 0, 'Serve', '1609', '1'),
(209, 'SOP/1609/0001', '2016-09-08', 'SA', 'RC00002', 0, 'Serve', '1609', '1'),
(229, 'MFC/1609/0003', '2016-09-09', 'MFC', 'RC00001', -100, 'RC00002-', '1609', '1'),
(230, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00008', -200, 'RC00002-', '1609', '1'),
(231, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00007', -150, 'RC00002-', '1609', '1'),
(232, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00006', -300, 'RC00002-', '1609', '1'),
(233, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00005', -100, 'RC00002-', '1609', '1'),
(234, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00004', -50, 'RC00002-', '1609', '1'),
(235, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00003', -10, 'RC00002-', '1609', '1'),
(236, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00002', -300, 'RC00002-', '1609', '1'),
(237, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00001', -30, 'RC00002-', '1609', '1'),
(238, 'MFC/1609/0003', '2016-09-09', 'MFC', 'BG00009', -2500, 'RC00002-', '1609', '1'),
(239, 'MFC/1609/0004', '2016-09-09', 'MFC', 'RC00001', 400, '', '1609', '1'),
(240, 'MFC/1609/0004', '2016-09-09', 'MFC', 'BG00001', -16000, 'RC00001-', '1609', '1'),
(241, 'MFC/1609/0004', '2016-09-09', 'MFC', 'BG00011', -4000, 'RC00001-', '1609', '1'),
(242, 'MFC/1609/0004', '2016-09-09', 'MFC', 'BG00003', -1200, 'RC00001-', '1609', '1'),
(243, 'MFC/1609/0004', '2016-09-09', 'MFC', 'BG00004', -16000, 'RC00001-', '1609', '1'),
(244, 'MFC/1609/0004', '2016-09-09', 'MFC', 'BG00012', -48000, 'RC00001-', '1609', '1'),
(245, 'MFC/1609/0004', '2016-09-09', 'MFC', 'BG00013', -8000, 'RC00001-', '1609', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbltranskeluar_detail`
--

CREATE TABLE IF NOT EXISTS `tbltranskeluar_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `type` varchar(1) NOT NULL DEFAULT 'F',
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltranskeluar_master`
--

CREATE TABLE IF NOT EXISTS `tbltranskeluar_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `no_reff` varchar(50) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltransmasuk_detail`
--

CREATE TABLE IF NOT EXISTS `tbltransmasuk_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltransmasuk_master`
--

CREATE TABLE IF NOT EXISTS `tbltransmasuk_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `no_po` varchar(13) NOT NULL,
  `no_reff` varchar(50) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltransmfc_detail`
--

CREATE TABLE IF NOT EXISTS `tbltransmfc_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `type` varchar(1) NOT NULL DEFAULT 'F',
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbltransmfc_detail`
--

INSERT INTO `tbltransmfc_detail` (`id`, `no_bukti`, `kode_barang`, `jumlah`, `keterangan`, `type`, `per`, `status`) VALUES
(1, 'MFC/1609/0001', 'RC00001', 300, '', 'R', '1609', '1'),
(2, 'MFC/1609/0002', 'RC00002', 4, '', 'R', '____', '1'),
(3, 'MFC/1609/0003', 'RC00002', 10, '', 'R', '1609', '1'),
(4, 'MFC/1609/0004', 'RC00001', 400, '', 'R', '1609', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbltransmfc_master`
--

CREATE TABLE IF NOT EXISTS `tbltransmfc_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `no_reff` varchar(50) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbltransmfc_master`
--

INSERT INTO `tbltransmfc_master` (`id`, `no_bukti`, `tanggal`, `no_reff`, `keterangan`, `per`, `status`) VALUES
(1, 'MFC/1609/0001', '2016-09-08', '', '', '1609', '1'),
(2, 'MFC/1609/0002', '2016-09-08', '', '', '____', '1'),
(3, 'MFC/1609/0003', '2016-09-09', '7776', '', '1609', '1'),
(4, 'MFC/1609/0004', '2016-09-09', '123', '', '1609', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbltransorder_detail`
--

CREATE TABLE IF NOT EXISTS `tbltransorder_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `no_split` varchar(13) NOT NULL,
  `kode_menu` varchar(10) NOT NULL,
  `qty` double NOT NULL,
  `harga` double NOT NULL,
  `time_order` datetime NOT NULL,
  `order_status` varchar(200) NOT NULL,
  `comment` varchar(200) NOT NULL,
  `comment_to` int(50) NOT NULL,
  `kode_waiter` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `zstatus` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `tbltransorder_detail`
--

INSERT INTO `tbltransorder_detail` (`id`, `no_bukti`, `no_split`, `kode_menu`, `qty`, `harga`, `time_order`, `order_status`, `comment`, `comment_to`, `kode_waiter`, `keterangan`, `per`, `status`, `zstatus`) VALUES
(1, 'T16090001', '', 'M0001', 2, 65000, '2016-09-08 15:00:12', 'PRC', '', 0, 'W003', '', '1609', '1', ''),
(2, 'T16090001', '', 'CMT-M0001', 0, 0, '2016-09-08 15:00:12', 'PRC', 'Pedas', 1, 'W003', '', '1609', '1', ''),
(3, 'T16090002', '', 'M0005', 1, 8000, '2016-09-08 15:49:28', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(15, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:05:36', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(14, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:04:43', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(13, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:04:22', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(12, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:03:28', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(11, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 15:59:29', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(10, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 15:58:18', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(16, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:06:10', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(17, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:07:58', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(18, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:08:40', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(19, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:09:36', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(20, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:11:14', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(21, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:11:32', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(22, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:13:21', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(23, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:14:14', 'PRC', '', 0, 'W003', '', '1609', '0', ''),
(24, 'T16090002', '', 'M0003', 1, 10000, '2016-09-08 16:15:10', 'PRC', '', 0, 'W003', '', '1609', '2', ''),
(25, 'T16090002', '', 'M0004', 1, 10000, '2016-09-08 16:15:12', 'PRC', '', 0, 'W003', '', '1609', '2', ''),
(26, 'T16090002', '', 'M0005', 1, 8000, '2016-09-08 16:21:07', 'PRC', '', 0, 'W003', '', '1609', '2', ''),
(27, 'T16090003', '', 'M0001', 2, 65000, '2016-09-08 16:47:24', 'PRC', '', 0, 'W003', '', '1609', '1', ''),
(28, 'T16090004', '', 'M0001', 2, 65000, '2016-09-08 17:18:19', 'PRC', '', 0, 'W003', '', '1609', '1', ''),
(29, 'T16090005', '', 'M0001', 2, 65000, '2016-09-08 17:49:06', 'PRC', '', 0, 'W003', '', '1609', '1', ''),
(30, 'T16090001', '', 'M0008', 1, 30000, '2016-09-08 17:55:48', 'PRC', '', 0, 'W003', '', '1609', '1', ''),
(31, 'T16090005', '', 'M0006', 1, 44000, '2016-09-09 09:15:32', 'PRC', '', 0, 'W003', '', '1609', '1', ''),
(32, 'T16090005', '', 'CMT-M0006', 0, 0, '2016-09-09 09:15:32', 'PRC', 'Sendok nya 2', 31, 'W003', '', '1609', '1', ''),
(33, 'T16090006', '', 'M0007', 2, 54000, '2016-09-09 09:24:08', 'PRC', '', 0, 'W003', '', '1609', '1', ''),
(34, 'T16090006', '', 'M0001', 1, 65000, '2016-09-09 09:26:52', 'PRC', '', 0, 'W003', '', '1609', '1', ''),
(35, 'T16090006', '', 'CMT-M0001', 0, 0, '2016-09-09 09:26:52', 'PRC', 'pedas', 34, 'W003', '', '1609', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbltransorder_master`
--

CREATE TABLE IF NOT EXISTS `tbltransorder_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `no_split` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_meja` varchar(4) NOT NULL,
  `pax` int(11) NOT NULL,
  `kasir` varchar(20) NOT NULL,
  `time_in` datetime NOT NULL,
  `time_out` datetime NOT NULL,
  `kode_cust` varchar(5) NOT NULL,
  `disc` double NOT NULL DEFAULT '0',
  `svc` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0',
  `xprint` int(11) NOT NULL DEFAULT '1',
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `zstatus` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbltransorder_master`
--

INSERT INTO `tbltransorder_master` (`id`, `no_bukti`, `no_split`, `tanggal`, `kode_meja`, `pax`, `kasir`, `time_in`, `time_out`, `kode_cust`, `disc`, `svc`, `tax`, `xprint`, `keterangan`, `per`, `status`, `zstatus`) VALUES
(1, 'T16090001', '', '2016-09-08', 'T001', 0, 'W003', '2016-09-08 15:00:12', '0000-00-00 00:00:00', '', 0, 6.5, 10, 0, 'OPEN', '1609', '1', ''),
(2, 'T16090002', '', '2016-09-08', 'T002', 0, 'W003', '2016-09-08 15:49:28', '0000-00-00 00:00:00', '', 0, 6.5, 10, 0, 'OPEN', '1609', '1', ''),
(12, 'T16090006', '', '2016-09-09', 'T003', 0, 'W003', '2016-09-09 09:24:08', '0000-00-00 00:00:00', '', 10, 6.5, 10, 0, 'OPEN', '1609', '1', ''),
(11, 'T16090005', '', '2016-09-08', 'T003', 0, 'W003', '2016-09-08 17:49:06', '2016-09-09 09:17:33', '', 0, 6.5, 10, 0, 'CLOSE', '1609', '1', ''),
(10, 'T16090004', '', '2016-09-08', 'T009', 0, 'W003', '2016-09-08 17:18:19', '0000-00-00 00:00:00', '', 0, 6.5, 10, 0, 'OPEN', '1609', '1', ''),
(9, 'T16090003', '', '2016-09-08', 'T005', 0, 'W003', '2016-09-08 16:47:24', '0000-00-00 00:00:00', '', 0, 6.5, 10, 0, 'OPEN', '1609', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbltranspayment`
--

CREATE TABLE IF NOT EXISTS `tbltranspayment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `user` varchar(10) NOT NULL,
  `tanggal` datetime NOT NULL,
  `jenis` varchar(5) NOT NULL,
  `no_kartu` varchar(20) NOT NULL,
  `nominal` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `kembali` double NOT NULL,
  `bank` varchar(5) NOT NULL,
  `pettycash` varchar(10) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  `zstatus` varchar(5) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbltranspayment`
--

INSERT INTO `tbltranspayment` (`id`, `no_bukti`, `user`, `tanggal`, `jenis`, `no_kartu`, `nominal`, `keterangan`, `kembali`, `bank`, `pettycash`, `status`, `zstatus`) VALUES
(1, 'T16090005', 'W003', '2016-09-09 09:17:33', 'CSH', '', 205000, '', -1159, '', '', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbltranspo_detail`
--

CREATE TABLE IF NOT EXISTS `tbltranspo_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(50) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah` double NOT NULL,
  `harga` double NOT NULL,
  `diskon` double NOT NULL,
  `type_disc` varchar(10) NOT NULL,
  `closing` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbltranspo_detail`
--

INSERT INTO `tbltranspo_detail` (`id`, `no_bukti`, `kode_barang`, `jumlah`, `harga`, `diskon`, `type_disc`, `closing`, `keterangan`, `per`, `status`) VALUES
(1, '0001/BG/IX/16/001-Kitchen', 'BG00001', 2, 1000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(2, '0001/BG/IX/16/001-Kitchen', 'BG00002', 2, 20000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(3, '0001/BG/IX/16/001-Kitchen', 'BG00003', 12, 5000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(4, '0001/BG/IX/16/001-Kitchen', 'BG00004', 5, 10000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(5, '0001/BG/IX/16/001-Kitchen', 'BG00005', 3, 40000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(6, '0001/BG/IX/16/001-Kitchen', 'BG00006', 3, 20000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(7, '0001/BG/IX/16/001-Kitchen', 'BG00007', 2, 30000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(8, '0001/BG/IX/16/001-Kitchen', 'BG00008', 5, 30000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(9, '0002/BG/IX/16/002-Kitchen', 'BG00001', 20, 1000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(10, '0002/BG/IX/16/002-Kitchen', 'BG00002', 10, 20000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(11, '0002/BG/IX/16/002-Kitchen', 'BG00003', 25, 5000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(12, '0002/BG/IX/16/002-Kitchen', 'BG00004', 20, 10000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(13, '0002/BG/IX/16/002-Kitchen', 'BG00005', 15, 40000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(14, '0002/BG/IX/16/002-Kitchen', 'BG00006', 10, 20000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(15, '0002/BG/IX/16/002-Kitchen', 'BG00007', 15, 30000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(16, '0002/BG/IX/16/002-Kitchen', 'BG00008', 10, 30000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(17, '0003/BG/IX/16/9999-Kitchen', 'BG00012', 30, 10000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(18, '0003/BG/IX/16/9999-Kitchen', 'BG00013', 15, 7500, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2'),
(19, '0004/BG/IX/16/887-Kitchen', 'BG00015', 2, 300000, 0, 'Nominal', '1900-01-01 00:00:00', '', '1609', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbltranspo_master`
--

CREATE TABLE IF NOT EXISTS `tbltranspo_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_supp` varchar(5) NOT NULL,
  `requester` varchar(20) NOT NULL,
  `no_reff` varchar(50) NOT NULL,
  `diskon` double NOT NULL,
  `type_disc` varchar(1) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `ppn` varchar(1) NOT NULL DEFAULT '0',
  `req_del` date NOT NULL,
  `xprint` int(11) DEFAULT '0',
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tbltranspo_master`
--

INSERT INTO `tbltranspo_master` (`id`, `no_bukti`, `tanggal`, `kode_supp`, `requester`, `no_reff`, `diskon`, `type_disc`, `keterangan`, `ppn`, `req_del`, `xprint`, `per`, `status`) VALUES
(1, '0001/BG/IX/16/001-Kitchen', '2016-09-08', 'SP001', 'Ryan', '001', 0, 'N', '', '0', '2016-09-08', 0, '1609', '2'),
(2, '0002/BG/IX/16/002-Kitchen', '2016-09-08', 'SP001', 'Ryan', '002', 0, 'N', '', '0', '2016-09-08', 0, '1609', '2'),
(3, '0003/BG/IX/16/9999-Kitchen', '2016-09-08', 'SP001', 'Bayu', '9999', 0, 'N', '', '0', '2016-09-08', 0, '1609', '2'),
(4, '0004/BG/IX/16/887-Kitchen', '2016-09-09', 'SP001', 'Bayu', '887', 0, 'N', '', '0', '2016-09-08', 0, '1609', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbltransprosespo`
--

CREATE TABLE IF NOT EXISTS `tbltransprosespo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `no_po` varchar(50) NOT NULL,
  `no_sj` varchar(50) NOT NULL,
  `tanggal_sj` date NOT NULL,
  `up` varchar(20) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `jumlah` double NOT NULL,
  `cacat` double NOT NULL,
  `lebih` double NOT NULL,
  `stok` double NOT NULL,
  `keterangan_po` varchar(200) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tbltransprosespo`
--

INSERT INTO `tbltransprosespo` (`id`, `no_bukti`, `tanggal`, `no_po`, `no_sj`, `tanggal_sj`, `up`, `kode_barang`, `nama_barang`, `jumlah`, `cacat`, `lebih`, `stok`, `keterangan_po`, `keterangan`, `per`, `status`) VALUES
(1, 'MSK/1609/0001', '2016-09-08', '0001/BG/IX/16/001-Kitchen', '982', '2016-09-08', '', 'BG00001', 'Garam Dolphine', -2, 0, 0, -2, '', '', '1609', '1'),
(2, 'MSK/1609/0001', '2016-09-08', '0001/BG/IX/16/001-Kitchen', '982', '2016-09-08', '', 'BG00002', 'Wortel', -2, 0, 0, -2, '', '', '1609', '1'),
(3, 'MSK/1609/0001', '2016-09-08', '0001/BG/IX/16/001-Kitchen', '982', '2016-09-08', '', 'BG00003', 'Chicken Powder', -12, 0, 0, -12, '', '', '1609', '1'),
(4, 'MSK/1609/0001', '2016-09-08', '0001/BG/IX/16/001-Kitchen', '982', '2016-09-08', '', 'BG00004', 'Kecap Bango 600ml', -5, 0, 0, -5, '', '', '1609', '1'),
(5, 'MSK/1609/0001', '2016-09-08', '0001/BG/IX/16/001-Kitchen', '982', '2016-09-08', '', 'BG00005', 'Diamond Ice Cream Vanilla', -3, 0, 0, -3, '', '', '1609', '1'),
(6, 'MSK/1609/0001', '2016-09-08', '0001/BG/IX/16/001-Kitchen', '982', '2016-09-08', '', 'BG00006', 'Iceberg Lettuce', -3, 0, 0, -3, '', '', '1609', '1'),
(7, 'MSK/1609/0001', '2016-09-08', '0001/BG/IX/16/001-Kitchen', '982', '2016-09-08', '', 'BG00007', 'Jamur Shimeji', -2, 0, 0, -2, '', '', '1609', '1'),
(8, 'MSK/1609/0001', '2016-09-08', '0001/BG/IX/16/001-Kitchen', '982', '2016-09-08', '', 'BG00008', 'Smoke Cheese', -5, 0, 0, -5, '', '', '1609', '1'),
(9, 'MSK/1609/0002', '2016-09-08', '0002/BG/IX/16/002-Kitchen', '9281', '2016-09-08', '', 'BG00001', 'Garam Dolphine', -20, 0, 0, -20, '', '', '1609', '1'),
(10, 'MSK/1609/0002', '2016-09-08', '0002/BG/IX/16/002-Kitchen', '9281', '2016-09-08', '', 'BG00002', 'Wortel', -10, 0, 0, -10, '', '', '1609', '1'),
(11, 'MSK/1609/0002', '2016-09-08', '0002/BG/IX/16/002-Kitchen', '9281', '2016-09-08', '', 'BG00003', 'Chicken Powder', -25, 0, 0, -25, '', '', '1609', '1'),
(12, 'MSK/1609/0002', '2016-09-08', '0002/BG/IX/16/002-Kitchen', '9281', '2016-09-08', '', 'BG00004', 'Kecap Bango 600ml', -20, 0, 0, -20, '', '', '1609', '1'),
(13, 'MSK/1609/0002', '2016-09-08', '0002/BG/IX/16/002-Kitchen', '9281', '2016-09-08', '', 'BG00005', 'Diamond Ice Cream Vanilla', -15, 0, 0, -15, '', '', '1609', '1'),
(14, 'MSK/1609/0002', '2016-09-08', '0002/BG/IX/16/002-Kitchen', '9281', '2016-09-08', '', 'BG00006', 'Iceberg Lettuce', -10, 0, 0, -10, '', '', '1609', '1'),
(15, 'MSK/1609/0002', '2016-09-08', '0002/BG/IX/16/002-Kitchen', '9281', '2016-09-08', '', 'BG00007', 'Jamur Shimeji', -15, 0, 0, -15, '', '', '1609', '1'),
(16, 'MSK/1609/0002', '2016-09-08', '0002/BG/IX/16/002-Kitchen', '9281', '2016-09-08', '', 'BG00008', 'Smoke Cheese', -10, 0, 0, -10, '', '', '1609', '1'),
(17, 'MSK/1609/0003', '2016-09-08', '0003/BG/IX/16/9999-Kitchen', '9217', '2016-09-08', '', 'BG00012', 'Tahu Pong', -30, 0, 0, -30, '', '', '1609', '1'),
(18, 'MSK/1609/0003', '2016-09-08', '0003/BG/IX/16/9999-Kitchen', '9217', '2016-09-08', '', 'BG00013', 'Terong', -15, 0, 0, -15, '', '', '1609', '1'),
(19, 'MSK/1609/0004', '2016-09-09', '0004/BG/IX/16/887-Kitchen', '721', '2016-09-09', '', 'BG00015', 'Mini Chocolate Cake', -2, 0, 0, -2, '', '', '1609', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbltranswaste_detail`
--

CREATE TABLE IF NOT EXISTS `tbltranswaste_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `jumlah` double NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `type` varchar(1) NOT NULL DEFAULT 'F',
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltranswaste_master`
--

CREATE TABLE IF NOT EXISTS `tbltranswaste_master` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(13) NOT NULL,
  `tanggal` date NOT NULL,
  `no_reff` varchar(50) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `per` varchar(4) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltrans_summary`
--

CREATE TABLE IF NOT EXISTS `tbltrans_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(15) NOT NULL,
  `user` varchar(10) NOT NULL,
  `pax` varchar(3) NOT NULL,
  `sub_total` float NOT NULL,
  `disc` float NOT NULL,
  `svc` float NOT NULL,
  `tax` float NOT NULL,
  `total` float NOT NULL,
  `zstatus` varchar(5) NOT NULL,
  `pettycash` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbltrans_summary`
--

INSERT INTO `tbltrans_summary` (`id`, `no_bukti`, `user`, `pax`, `sub_total`, `disc`, `svc`, `tax`, `total`, `zstatus`, `pettycash`) VALUES
(1, 'T16090005', 'W003', '3', 174000, 0, 11310, 18531, 203841, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE IF NOT EXISTS `tbluser` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `access_level` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `on_line` varchar(10) NOT NULL DEFAULT 'No',
  `net` varchar(50) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `nama`, `access_level`, `user_id`, `password`, `on_line`, `net`, `status`) VALUES
(1, 'Administrator', 'Administrator', 'admin', 'admin123', 'Yes', '25.14.182.200', '1'),
(30, 'AR', 'Manager', 'opsmgr', 'opsmgr', 'Yes', '25.47.146.185', '1'),
(31, 'Rebecca', 'Purchasing', 'cha', 'cha', 'Yes', '25.15.56.100', '1'),
(32, 'Fransisca', 'Purchasing', 'sis', 'sis', 'Yes', '25.39.182.207', '1'),
(33, 'Atin', 'Purchasing', 'atin', 'atin', 'Yes', '192.168.1.101', '1'),
(34, 'Fian', 'Gudang', 'fian', 'fian', 'No', '', '1'),
(35, 'Pri', 'Administrator', 'pri', 'pri', 'Yes', '25.14.182.200', '1'),
(36, 'Florina', 'Manager', 'flo', 'flo', 'No', '', '1'),
(37, 'Indah', 'Purchasing', 'ind', 'ind123', 'Yes', '25.49.52.215', '1'),
(38, 'Angel', 'Manager', 'xia', 'xia', 'Yes', '25.20.155.151', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblusertrack`
--

CREATE TABLE IF NOT EXISTS `tblusertrack` (
  `track_no` bigint(8) NOT NULL AUTO_INCREMENT,
  `log_into` varchar(50) NOT NULL,
  `user_id` varchar(50) NOT NULL,
  `in_time` datetime NOT NULL,
  `out_time` datetime NOT NULL,
  PRIMARY KEY (`track_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `tblusertrack`
--

INSERT INTO `tblusertrack` (`track_no`, `log_into`, `user_id`, `in_time`, `out_time`) VALUES
(1, 'Web', 'W003', '2016-09-08 13:13:50', '0000-00-00 00:00:00'),
(2, 'Web', 'W003', '2016-09-08 13:14:10', '0000-00-00 00:00:00'),
(3, 'Administrator', 'pri', '2016-09-08 13:50:17', '2016-09-08 13:50:54'),
(4, 'Administrator', 'pri', '2016-09-08 13:51:46', '0000-00-00 00:00:00'),
(5, 'Administrator', 'pri', '2016-09-08 14:14:19', '2016-09-08 14:19:44'),
(6, 'Administrator', 'pri', '2016-09-08 14:20:26', '0000-00-00 00:00:00'),
(7, 'Administrator', 'pri', '2016-09-08 14:39:51', '0000-00-00 00:00:00'),
(8, 'Administrator', 'pri', '2016-09-08 14:50:15', '0000-00-00 00:00:00'),
(9, 'Web', 'W003', '2016-09-08 14:59:47', '0000-00-00 00:00:00'),
(10, 'Administrator', 'pri', '2016-09-08 15:04:55', '0000-00-00 00:00:00'),
(11, 'Administrator', 'pri', '2016-09-08 15:08:55', '0000-00-00 00:00:00'),
(12, 'Administrator', 'pri', '2016-09-08 15:13:31', '0000-00-00 00:00:00'),
(13, 'Administrator', 'pri', '2016-09-08 15:16:53', '0000-00-00 00:00:00'),
(14, 'Administrator', 'pri', '2016-09-08 15:23:02', '0000-00-00 00:00:00'),
(15, 'Administrator', 'pri', '2016-09-08 15:25:02', '0000-00-00 00:00:00'),
(16, 'Administrator', 'pri', '2016-09-08 16:03:59', '0000-00-00 00:00:00'),
(17, 'Administrator', 'pri', '2016-09-08 16:05:40', '0000-00-00 00:00:00'),
(18, 'Administrator', 'pri', '2016-09-08 16:12:10', '0000-00-00 00:00:00'),
(19, 'Administrator', 'pri', '2016-09-08 16:36:06', '0000-00-00 00:00:00'),
(20, 'Administrator', 'pri', '2016-09-08 16:41:46', '0000-00-00 00:00:00'),
(21, 'Administrator', 'pri', '2016-09-08 16:43:54', '0000-00-00 00:00:00'),
(22, 'Administrator', 'pri', '2016-09-08 16:44:13', '0000-00-00 00:00:00'),
(23, 'Administrator', 'pri', '2016-09-08 16:47:26', '0000-00-00 00:00:00'),
(24, 'Administrator', 'pri', '2016-09-08 16:50:54', '0000-00-00 00:00:00'),
(25, 'Administrator', 'pri', '2016-09-08 17:00:11', '0000-00-00 00:00:00'),
(26, 'Administrator', 'pri', '2016-09-08 17:01:01', '0000-00-00 00:00:00'),
(27, 'Administrator', 'pri', '2016-09-08 17:01:28', '0000-00-00 00:00:00'),
(28, 'Administrator', 'pri', '2016-09-08 17:04:24', '0000-00-00 00:00:00'),
(29, 'Administrator', 'pri', '2016-09-08 17:05:41', '0000-00-00 00:00:00'),
(30, 'Administrator', 'pri', '2016-09-08 17:16:27', '0000-00-00 00:00:00'),
(31, 'Administrator', 'pri', '2016-09-08 17:17:17', '2016-09-08 17:31:11'),
(32, 'Administrator', 'pri', '2016-09-08 17:31:35', '2016-09-08 18:05:45'),
(33, 'Web', 'W003', '2016-09-08 17:34:18', '0000-00-00 00:00:00'),
(34, 'Administrator', 'pri', '2016-09-08 17:46:21', '0000-00-00 00:00:00'),
(35, 'Web', 'W003', '2016-09-08 17:48:55', '0000-00-00 00:00:00'),
(36, 'Administrator', 'pri', '2016-09-08 17:57:03', '0000-00-00 00:00:00'),
(37, 'Administrator', 'pri', '2016-09-08 17:59:50', '0000-00-00 00:00:00'),
(38, 'Administrator', 'pri', '2016-09-09 09:14:33', '2016-09-09 09:21:26'),
(39, 'Administrator', 'pri', '2016-09-09 09:21:40', '0000-00-00 00:00:00'),
(40, 'Web', 'W003', '2016-09-09 11:02:40', '0000-00-00 00:00:00'),
(41, 'Web', 'W003', '2016-09-09 13:29:28', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tblusertrackdetail`
--

CREATE TABLE IF NOT EXISTS `tblusertrackdetail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `track_no` bigint(20) NOT NULL,
  `kegiatan` varchar(50) NOT NULL,
  `no_bukti` varchar(50) NOT NULL,
  `waktu` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

--
-- Dumping data for table `tblusertrackdetail`
--

INSERT INTO `tblusertrackdetail` (`id`, `track_no`, `kegiatan`, `no_bukti`, `waktu`) VALUES
(1, 2, 'Input Category', 'C0001', '2016-09-08 13:14:22'),
(2, 2, 'Input Category', 'C0002', '2016-09-08 13:14:28'),
(3, 2, 'Delete Lokasi', 'L03', '2016-09-08 13:15:54'),
(4, 2, 'Delete Lokasi', 'L04', '2016-09-08 13:15:59'),
(5, 2, 'Input Meja', 'T001', '2016-09-08 13:16:09'),
(6, 2, 'Input Meja', 'T002', '2016-09-08 13:16:13'),
(7, 2, 'Input Meja', 'T003', '2016-09-08 13:16:20'),
(8, 2, 'Input Meja', 'T004', '2016-09-08 13:20:36'),
(9, 2, 'Input Meja', 'T005', '2016-09-08 13:20:40'),
(10, 2, 'Input Meja', 'T006', '2016-09-08 13:20:47'),
(11, 2, 'Input Meja', 'T007', '2016-09-08 13:20:52'),
(12, 2, 'Input Meja', 'T008', '2016-09-08 13:20:57'),
(13, 2, 'Input Meja', 'T009', '2016-09-08 13:21:01'),
(14, 2, 'Input Category', 'C0001', '2016-09-08 13:21:43'),
(15, 2, 'Input Category', 'C0002', '2016-09-08 13:21:47'),
(16, 2, 'Input Category', 'C0003', '2016-09-08 13:21:51'),
(17, 2, 'Input Product ../img/menu/', 'M0001', '2016-09-08 13:22:20'),
(18, 2, 'Input Product ../img/menu/', 'M0002', '2016-09-08 13:22:35'),
(19, 2, 'Edit Product', 'M0001', '2016-09-08 13:24:12'),
(20, 2, 'Edit Product', 'M0001', '2016-09-08 13:25:17'),
(21, 2, 'Edit Product', 'M0002', '2016-09-08 13:26:17'),
(22, 2, 'Input Product ../img/menu/cola.jpg', 'M0003', '2016-09-08 13:29:26'),
(23, 2, 'Edit Product', 'M0003', '2016-09-08 13:31:02'),
(24, 2, 'Input Product ../img/menu/fanta.jpg', 'M0004', '2016-09-08 13:32:59'),
(25, 2, 'Input Product ../img/menu/mineral.jpg', 'M0005', '2016-09-08 13:35:49'),
(26, 2, 'Input Product ../img/menu/stawcake.jpg', 'M0006', '2016-09-08 13:41:55'),
(27, 2, 'Input Product ../img/menu/chococake.jpg', 'M0007', '2016-09-08 13:43:26'),
(28, 4, 'Daftar Barang (Add Record)', 'BG00001', '2016-09-08 13:52:33'),
(29, 4, 'Daftar Barang (Add Record)', 'BG00002', '2016-09-08 13:53:53'),
(30, 4, 'Daftar Barang (Add Record)', 'BG00003', '2016-09-08 13:54:32'),
(31, 5, 'Daftar Barang (Add Record)', 'BG00004', '2016-09-08 14:14:55'),
(32, 5, 'Daftar Barang (Add Record)', 'BG00005', '2016-09-08 14:15:49'),
(33, 5, 'Daftar Barang (Add Record)', 'BG00006', '2016-09-08 14:17:04'),
(34, 5, 'Daftar Barang (Add Record)', 'BG00007', '2016-09-08 14:17:39'),
(35, 5, 'Daftar Barang (Add Record)', 'BG00008', '2016-09-08 14:18:06'),
(36, 5, 'Daftar Barang (Add Record)', 'BG00009', '2016-09-08 14:18:25'),
(37, 5, 'Daftar Barang (Delete Record)', 'BG00009', '2016-09-08 14:18:39'),
(38, 5, 'Daftar Barang (Add Record)', 'BG00010', '2016-09-08 14:19:26'),
(39, 6, 'Daftar Barang (Add Record)', 'BG00011', '2016-09-08 14:21:32'),
(40, 6, 'Daftar Barang (Add Record)', 'BG00012', '2016-09-08 14:22:18'),
(41, 6, 'Daftar Barang (Add Record)', 'BG00013', '2016-09-08 14:22:32'),
(42, 6, 'Daftar Resep (Add Record)', 'RC00001', '2016-09-08 14:24:48'),
(43, 6, 'Daftar Resep (Add Record)', 'RC00002', '2016-09-08 14:27:43'),
(44, 6, 'Daftar Barang (Delete Record)', 'BG00009', '2016-09-08 14:28:54'),
(45, 6, 'Daftar Barang (Delete Record)', 'BG00009', '2016-09-08 14:29:12'),
(46, 6, 'Daftar Resep (Edit Record)', 'RC00002', '2016-09-08 14:30:39'),
(47, 6, 'Daftar Supplier (Add Record)', 'SP001', '2016-09-08 14:31:23'),
(48, 6, 'Trans - PO (Add Record)', '0001/BG/IX/16/001-Kitchen', '2016-09-08 14:33:41'),
(49, 6, 'Trans - Proses PO (Add Record)', 'MSK/1609/0001', '2016-09-08 14:34:56'),
(50, 8, 'Trans - PO (Add Record)', '0002/BG/IX/16/002-Kitchen', '2016-09-08 14:52:18'),
(51, 8, 'Trans - Proses PO (Add Record)', 'MSK/1609/0002', '2016-09-08 14:52:38'),
(52, 7, 'Daftar Barang (Delete Record)', 'BG00009', '2016-09-08 14:54:01'),
(53, 8, 'Trans - PO (Add Record)', '0003/BG/IX/16/9999-Kitchen', '2016-09-08 14:57:02'),
(54, 8, 'Trans - Proses PO (Add Record)', 'MSK/1609/0003', '2016-09-08 14:57:17'),
(55, 7, 'Trans - Mfc (Add Record)', 'MFC/1609/0001', '2016-09-08 14:57:25'),
(56, 9, 'Edit Configuration', '', '2016-09-08 15:13:24'),
(57, 13, 'Trans - SO (Add Record)', 'SOP/1609/0001', '2016-09-08 15:19:19'),
(58, 15, 'Trans - SO (Add Record)', 'SOP/1609/0001', '2016-09-08 15:29:37'),
(59, 17, 'Trans - SO (Add Record)', 'SOP/1609/0001', '2016-09-08 16:10:45'),
(60, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:39'),
(61, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:41'),
(62, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:42'),
(63, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:43'),
(64, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:44'),
(65, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:44'),
(66, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:45'),
(67, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:46'),
(68, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:47'),
(69, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:48'),
(70, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:48'),
(71, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:50'),
(72, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:50'),
(73, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:53'),
(74, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:54'),
(75, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:56'),
(76, 9, 'Delete Item M0004', 'T16090002', '2016-09-08 16:14:56'),
(77, 9, 'Delete Item M0005', 'T16090002', '2016-09-08 16:14:58'),
(78, 9, 'Delete Item M0005', 'T16090002', '2016-09-08 16:14:59'),
(79, 18, 'Trans - SO (Add Record)', 'SOP/1609/0002', '2016-09-08 16:34:40'),
(80, 19, 'Trans - SO (Add Record)', 'SOP/1609/0001', '2016-09-08 16:37:15'),
(81, 19, 'Trans - SO (Add Record)', 'SOP/1609/0001', '2016-09-08 16:38:33'),
(82, 23, 'Trans - SO (Add Record)', 'SOP/1609/0001', '2016-09-08 16:50:17'),
(83, 24, 'Trans - Mfc (Add Record)', 'MFC/1609/0002', '2016-09-08 16:52:10'),
(84, 33, 'Input Product ../img/menu/', 'M0008', '2016-09-08 17:34:41'),
(85, 35, 'Input Payment CSH-/:205000', 'T16090005', '2016-09-09 09:17:33'),
(86, 38, 'Daftar Barang (Add Record)', 'BG00014', '2016-09-09 09:18:48'),
(87, 39, 'Daftar Barang (Add Record)', 'BG00015', '2016-09-09 09:22:08'),
(88, 39, 'Trans - PO (Add Record)', '0004/BG/IX/16/887-Kitchen', '2016-09-09 09:23:30'),
(89, 39, 'Trans - Proses PO (Add Record)', 'MSK/1609/0004', '2016-09-09 09:23:45'),
(90, 39, 'Trans - Mfc (Add Record)', 'MFC/1609/0003', '2016-09-09 09:28:20'),
(91, 39, 'Trans - Mfc (Add Record)', 'MFC/1609/0004', '2016-09-09 09:30:28'),
(92, 41, 'Print Preview Bill', 'T16090006', '2016-09-09 13:43:40'),
(93, 41, 'Give Disc Bill 10 P', 'T16090006', '2016-09-09 13:43:48'),
(94, 35, 'Edit Configuration', '', '2016-09-09 15:22:18'),
(95, 35, 'Delete Product', '8', '2016-09-09 15:23:13');

-- --------------------------------------------------------

--
-- Table structure for table `tblutilitysetting`
--

CREATE TABLE IF NOT EXISTS `tblutilitysetting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `resto_name` varchar(23) NOT NULL,
  `resto_add1` varchar(36) NOT NULL,
  `resto_add2` varchar(36) NOT NULL,
  `resto_phone` varchar(36) NOT NULL,
  `footer_line1` varchar(100) NOT NULL,
  `footer_line2` varchar(36) NOT NULL,
  `footer_line3` varchar(36) NOT NULL,
  `svc` double NOT NULL,
  `tax` double NOT NULL,
  `upsell` int(11) NOT NULL,
  `rounding` varchar(1) NOT NULL DEFAULT '0',
  `rounding_val` double NOT NULL,
  `print_co` varchar(100) NOT NULL,
  `print_bill` varchar(100) NOT NULL,
  `dualscreen` varchar(2) NOT NULL DEFAULT '0',
  `last_number` varchar(6) NOT NULL,
  `buka` varchar(2) NOT NULL,
  `tutup` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tblutilitysetting`
--

INSERT INTO `tblutilitysetting` (`id`, `resto_name`, `resto_add1`, `resto_add2`, `resto_phone`, `footer_line1`, `footer_line2`, `footer_line3`, `svc`, `tax`, `upsell`, `rounding`, `rounding_val`, `print_co`, `print_bill`, `dualscreen`, `last_number`, `buka`, `tutup`) VALUES
(1, 'Bakers Gallery', 'Kota Kasablanka', '', '', 'Barang yang sudah dibeli ', 'tidak bisa dikembalikan', '', 6.5, 10, 10, '0', 0, 'Generic', 'Generic', '', '', '7', '23');

-- --------------------------------------------------------

--
-- Table structure for table `tblutilityso`
--

CREATE TABLE IF NOT EXISTS `tblutilityso` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `kode_barang` varchar(15) NOT NULL,
  `stocksys` double NOT NULL,
  `stockso` double NOT NULL,
  `keterangan` varchar(500) NOT NULL,
  `per` varchar(2) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=92 ;

--
-- Dumping data for table `tblutilityso`
--

INSERT INTO `tblutilityso` (`id`, `no_bukti`, `tanggal`, `kode_barang`, `stocksys`, `stockso`, `keterangan`, `per`, `status`) VALUES
(91, 'SOP/1609/0001', '2016-09-07', 'RC00002', 0, 0, 'Serve', '16', '1'),
(89, 'SOP/1609/0001', '2016-09-07', 'BG00013', 0, 0, 'Gram', '16', '1'),
(90, 'SOP/1609/0001', '2016-09-07', 'RC00001', 0, 0, 'Gram', '16', '1'),
(88, 'SOP/1609/0001', '2016-09-07', 'BG00012', 0, 0, 'Gram', '16', '1'),
(87, 'SOP/1609/0001', '2016-09-07', 'BG00011', 0, 0, 'gram', '16', '1'),
(86, 'SOP/1609/0001', '2016-09-07', 'BG00008', 0, 0, 'Gram', '16', '1'),
(85, 'SOP/1609/0001', '2016-09-07', 'BG00007', 0, 0, 'ML', '16', '1'),
(84, 'SOP/1609/0001', '2016-09-07', 'BG00006', 0, 0, 'Gram', '16', '1'),
(83, 'SOP/1609/0001', '2016-09-07', 'BG00005', 0, 0, 'Gram', '16', '1'),
(82, 'SOP/1609/0001', '2016-09-07', 'BG00004', 0, 0, 'Gram', '16', '1'),
(81, 'SOP/1609/0001', '2016-09-07', 'BG00003', 0, 0, 'Pcs', '16', '1'),
(80, 'SOP/1609/0001', '2016-09-07', 'BG00002', 0, 0, 'Gram', '16', '1'),
(79, 'SOP/1609/0001', '2016-09-07', 'BG00001', 0, 0, 'Gram', '16', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pettycash`
--

CREATE TABLE IF NOT EXISTS `tbl_pettycash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(10) NOT NULL,
  `modal` varchar(10) NOT NULL,
  `in_time` datetime NOT NULL,
  `out_time` datetime NOT NULL,
  `status` varchar(2) NOT NULL,
  `transaksi` int(20) NOT NULL,
  `close_nominal` int(25) NOT NULL,
  `zstatus` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_pettycash`
--

INSERT INTO `tbl_pettycash` (`id`, `user`, `modal`, `in_time`, `out_time`, `status`, `transaksi`, `close_nominal`, `zstatus`) VALUES
(1, 'W003', '100000', '2016-09-09 09:17:15', '0000-00-00 00:00:00', '1', 203841, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE IF NOT EXISTS `tbl_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `access` text NOT NULL,
  `status` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`id`, `name`, `access`, `status`) VALUES
(1, 'Kasir', 'm_kasir:1|m_manager:1|m_waiter:1|m_kitchen:1|m_admin:1', '1'),
(2, 'Kitchen', 'm_kasir:0|m_manager:0|m_waiter:0|m_kitchen:1|m_admin:0', '1'),
(3, 'Manager', 'm_kasir:0|m_manager:1|m_waiter:0|m_kitchen:0|m_admin:0', '1'),
(4, 'Admin', 'm_kasir:0|m_manager:0|m_waiter:0|m_kitchen:0|m_admin:1', '1'),
(5, 'Administrator', 'm_kasir:1|m_manager:1|m_waiter:1|m_kitchen:1|m_admin:1', '1'),
(6, 'Waiter', 'm_kasir:0|m_manager:0|m_waiter:1|m_kitchen:0|m_admin:0', '1'),
(7, 'SIDIK', 'm_kasir:0|m_manager:0|m_waiter:0|m_kitchen:0|m_admin:0|', '1'),
(8, 'bams', 'm_kasir:1|m_manager:1|m_waiter:1|m_kitchen:1|m_admin:1|', '1'),
(9, 'Ramos', 'm_kasir:on|m_manager:on|m_waiter:on|m_kitchen:on|m_admin:on|', '0'),
(10, 'Ganteng', 'm_kasir:1|m_manager:1|m_waiter:1|m_kitchen:1|m_admin:1|', '0'),
(11, 'wewew', 'm_kasir:1|m_manager:0|m_waiter:0|m_kitchen:1|m_admin:1|', '0'),
(12, 'None', 'm_kasir:1|m_manager:1|m_waiter:1|m_kitchen:1|m_admin:1|', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_zreport`
--

CREATE TABLE IF NOT EXISTS `tbl_zreport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `close_date` datetime NOT NULL,
  `user` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

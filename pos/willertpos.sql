-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2016 at 05:47 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `willertpos`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

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
(10, 'Administrator', '(Menu POS)', 'Menu POS', '1', '1'),
(11, 'Kasir', '(Menu Admin)', 'Menu Admin', '0', '1'),
(12, 'Kasir', '(Menu Master File)', 'Menu Master File', '0', '1'),
(13, 'Kasir', '(Menu POS)', 'Menu POS', '1', '1'),
(14, 'Kasir', '(Menu Report)', 'Menu Report', '0', '1'),
(15, 'Kasir', '(Menu Transaction)', 'Menu Transaction', '0', '1'),
(16, 'Kasir', '(Menu User Account)', 'Menu User Account', '0', '1'),
(17, 'Kasir', '(Menu Utility)', 'Menu Utility', '0', '1'),
(18, 'Kasir', 'Admin - Status Akses', 'Status Akses', '1', '1');

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
(14, 'B02', 'BRI', 'I02', '', '1'),
(15, 'B02', 'BTN', 'I01', '', '1'),
(16, 'B02', 'BTN', 'I02', '', '1'),
(17, 'B02', 'Bukopin', 'I01', '', '1'),
(18, 'B02', 'Bukopin', 'I02', '', '1'),
(19, 'B02', 'CIMB Niaga', 'I01', '', '1'),
(20, 'B02', 'CIMB Niaga', 'I02', '', '1'),
(21, 'B02', 'Citibank', 'I01', '', '1'),
(22, 'B02', 'Citibank', 'I02', '', '1'),
(23, 'B02', 'Danamon', 'I01', '', '1'),
(24, 'B03', 'Danamon', 'I02', '', '1'),
(25, 'B03', 'Danamon', 'I03', '', '1'),
(26, 'B03', 'HSBC', 'I01', '', '1'),
(27, 'B03', 'HSBC', 'I02', '', '1'),
(28, 'B03', 'ICB Bumipu', 'I01', '', '1'),
(29, 'B03', 'ICB Bumipu', 'I02', '', '1'),
(30, 'B03', 'Mandiri', 'I01', '', '1'),
(31, 'B03', 'Mandiri', 'I02', '', '1'),
(32, 'B03', 'Mega', 'I01', '', '1'),
(33, 'B03', 'Mega', 'I02', '', '1'),
(34, 'B04', 'OCBC NISP', 'I01', '', '1'),
(35, 'B04', 'OCBC NISP', 'I02', '', '1'),
(36, 'B04', 'Panin', 'I01', '', '1'),
(37, 'B04', 'Panin', 'I02', '', '1'),
(38, 'B04', 'Permata', 'I01', '', '1'),
(39, 'B04', 'Permata', 'I02', '', '1'),
(40, 'B04', 'Stanchart', 'I01', '', '1'),
(41, 'B04', 'Stanchart', 'I02', '', '1'),
(42, 'B04', 'UOB', 'I01', '', '1'),
(43, 'B04', 'UOB', 'I02', '', '1'),
(44, 'B05', 'AEON', 'I02', '', '1'),
(45, 'B28', 'ganteng', 'I03', '', '1'),
(46, 'B29', 'bankku', 'I04', '', '0'),
(47, 'B30', 'Sidik', 'I10', '', '1');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tblmastercategory`
--

INSERT INTO `tblmastercategory` (`id`, `kode_cat`, `nama_cat`, `status`) VALUES
(9, 'C0004', 'Blissful Tea', '1'),
(8, 'C0003', 'Artisan Tea', '1'),
(7, 'C0002', 'Soft Drinks', '1'),
(6, 'C0001', 'Beers', '1'),
(10, 'C0005', 'Mocktails', '1'),
(11, 'C0006', 'Healthy Juice', '1'),
(12, 'C0007', 'Hot Coffee', '1'),
(13, 'C0008', 'Flavoured Coffee', '1'),
(14, 'C0009', 'Ice Blended Crème Latte', '0'),
(15, 'C0010', 'Others Drinks', '1'),
(16, 'C0011', 'Western Corner', '1'),
(17, 'C0012', 'Pannacottas', '1'),
(18, 'C0013', 'Cakes', '1'),
(19, 'C0014', 'Pastries', '1'),
(20, 'C0015', 'Small Bites', '1'),
(21, 'C0016', 'Breakfast', '1'),
(22, 'C0017', 'Asian Corner', '1'),
(23, 'C0018', 'Soups', '1'),
(24, 'C0019', 'Salads', '1'),
(25, 'C0020', 'PACKAGE', '1'),
(26, 'C0021', 'SIDIK', '0');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tblmastercustomer`
--

INSERT INTO `tblmastercustomer` (`id`, `kode_cust`, `nama_cust`, `kode_ctype`, `pin`, `keterangan`, `status`) VALUES
(1, 'C0001', 'Prinantors', 'CT4', '12345', '', '1'),
(2, 'C0002', 'William', 'CT1', '5678', '', '1'),
(3, 'C0003', 'Sidik', 'CT2', '1357', '', '1'),
(4, 'C0004', 'Effendy', 'CT1', 'PZN-490880', '', '1'),
(5, 'C0005', 'Anez', 'CT1', '1', '', '1'),
(7, 'C0006', 'Ganstengs', 'CT1', '00001', '', '1'),
(8, 'C0007', 'wakakak', 'CT2', '1234', '', '0');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `tblmastercustomer_type`
--

INSERT INTO `tblmastercustomer_type` (`id`, `kode_ctype`, `nama_ctype`, `disc`, `svc`, `tax`, `keterangan`, `status`) VALUES
(1, 'CT1', 'Owner', 25, 0, 0, '', '1'),
(2, 'CT2', 'Silver Member', 10, 6.5, 10, '', '1'),
(3, 'CT3', 'Marketing', 0, 0, 0, '', '1'),
(4, 'CT4', 'Gold Member', 25, 6.5, 10, '', '1'),
(5, 'CT5', 'Freeeeee', 10, 10, 10, '', '1'),
(42, 'CT8', 'wawa', 0, 0, 0, '', '0'),
(41, 'CT7', 'Ganteng Cekali', 55, 34, 10, '', '1'),
(40, 'CT6', 'wkwk', 5, 5, 5, '', '0');

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
(2, 'D02', '10 %%', 'P', 10, '', '1'),
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
  `status` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `tblmasterlokasi`
--

INSERT INTO `tblmasterlokasi` (`id`, `kode_lokasi`, `nama_lokasi`, `keterangan`, `status`) VALUES
(1, 'L01', 'Indoor', '', '1'),
(2, 'L02', 'Outdoor', '', '1'),
(3, 'L03', 'Smoking', '', '1'),
(4, 'L04', 'Rooftop', '', '1'),
(5, 'L05', 'Take Away', '', '1');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=121 ;

--
-- Dumping data for table `tblmastermeja`
--

INSERT INTO `tblmastermeja` (`id`, `kode_meja`, `nama_meja`, `kode_lokasi`, `keterangan`, `status`) VALUES
(20, 'T010', 'I10', 'L01', '', '1'),
(19, 'T009', 'I09', 'L01', '', '1'),
(18, 'T008', 'I08', 'L01', '', '1'),
(17, 'T007', 'I07', 'L01', '', '1'),
(16, 'T006', 'I06', 'L01', '', '0'),
(15, 'T005', 'I05', 'L01', '', '1'),
(14, 'T004', 'I04', 'L01', '', '1'),
(13, 'T003', 'I03', 'L01', '', '0'),
(12, 'T002', 'I02eehe', 'L01', '', '0'),
(11, 'T001', 'I0111111', 'L02', '', '0'),
(21, 'T011', 'I11', 'L01', '', '1'),
(22, 'T012', 'I12', 'L01', '', '1'),
(23, 'T013', 'I13', 'L01', '', '1'),
(24, 'T014', 'I14', 'L01', '', '1'),
(25, 'T015', 'I15', 'L01', '', '1'),
(26, 'T016', 'I16', 'L01', '', '1'),
(27, 'T017', 'I17', 'L01', '', '1'),
(28, 'T018', 'I18', 'L01', '', '1'),
(29, 'T019', 'I19', 'L01', '', '1'),
(30, 'T020', 'I20', 'L01', '', '1'),
(31, 'T021', 'I21', 'L01', '', '1'),
(32, 'T022', 'I22', 'L01', '', '1'),
(33, 'T023', 'I23', 'L01', '', '1'),
(34, 'T024', 'I24', 'L01', '', '1'),
(35, 'T025', 'I25', 'L01', '', '1'),
(36, 'T026', 'O01', 'L02', '', '1'),
(37, 'T027', 'O02', 'L02', '', '1'),
(38, 'T028', 'O03', 'L02', '', '1'),
(39, 'T029', 'O04', 'L02', '', '1'),
(40, 'T030', 'O05', 'L02', '', '1'),
(41, 'T031', 'O06', 'L02', '', '1'),
(42, 'T032', 'O07', 'L02', '', '1'),
(43, 'T033', 'O08', 'L02', '', '1'),
(44, 'T034', 'O09', 'L02', '', '1'),
(45, 'T035', 'O10', 'L02', '', '1'),
(46, 'T036', 'O11', 'L02', '', '1'),
(47, 'T037', 'O12', 'L02', '', '1'),
(48, 'T038', 'O13', 'L02', '', '1'),
(49, 'T039', 'O14', 'L02', '', '1'),
(50, 'T040', 'O15', 'L02', '', '1'),
(51, 'T041', 'O16', 'L02', '', '1'),
(52, 'T042', 'O17', 'L02', '', '1'),
(53, 'T043', 'O18', 'L02', '', '1'),
(54, 'T044', 'O19', 'L02', '', '1'),
(55, 'T045', 'O20', 'L02', '', '1'),
(56, 'T046', 'O21', 'L02', '', '1'),
(57, 'T047', 'O22', 'L02', '', '1'),
(58, 'T048', 'O23', 'L02', '', '1'),
(59, 'T049', 'O24', 'L02', '', '1'),
(60, 'T050', 'O25', 'L02', '', '1'),
(61, 'T051', 'S01', 'L03', '', '1'),
(62, 'T052', 'S02', 'L03', '', '1'),
(63, 'T053', 'S03', 'L03', '', '1'),
(64, 'T054', 'S04', 'L03', '', '1'),
(65, 'T055', 'S05', 'L03', '', '1'),
(66, 'T056', 'S06', 'L03', '', '1'),
(67, 'T057', 'S07', 'L03', '', '1'),
(68, 'T058', 'S08', 'L03', '', '1'),
(69, 'T059', 'S09', 'L03', '', '1'),
(70, 'T060', 'S10', 'L03', '', '1'),
(71, 'T061', 'S11', 'L03', '', '1'),
(72, 'T062', 'S12', 'L03', '', '1'),
(73, 'T063', 'S13', 'L03', '', '1'),
(74, 'T064', 'S14', 'L03', '', '1'),
(75, 'T065', 'S15', 'L03', '', '1'),
(76, 'T066', 'R01', 'L04', '', '1'),
(77, 'T067', 'R02', 'L04', '', '1'),
(78, 'T068', 'R03', 'L04', '', '1'),
(79, 'T069', 'R04', 'L04', '', '1'),
(80, 'T070', 'R05', 'L04', '', '1'),
(81, 'T071', 'R06', 'L04', '', '1'),
(82, 'T072', 'R07', 'L04', '', '1'),
(83, 'T073', 'R08', 'L04', '', '1'),
(84, 'T074', 'R09', 'L04', '', '1'),
(85, 'T075', 'R10', 'L04', '', '1'),
(86, 'T076', 'R11', 'L04', '', '1'),
(87, 'T077', 'R12', 'L04', '', '1'),
(88, 'T078', 'R13', 'L04', '', '1'),
(89, 'T079', 'R14', 'L04', '', '1'),
(90, 'T080', 'R15', 'L04', '', '1'),
(91, 'T081', 'R16', 'L04', '', '1'),
(92, 'T082', 'R17', 'L04', '', '1'),
(93, 'T083', 'R18', 'L04', '', '1'),
(94, 'T084', 'R19', 'L04', '', '1'),
(95, 'T085', 'R20', 'L04', '', '1'),
(96, 'T086', 'R21', 'L04', '', '1'),
(97, 'T087', 'R22', 'L04', '', '1'),
(98, 'T088', 'R23', 'L04', '', '1'),
(99, 'T089', 'R24', 'L04', '', '1'),
(100, 'T090', 'R25', 'L04', '', '1'),
(101, 'T091', 'T01', 'L05', '', '1'),
(102, 'T092', 'T02', 'L05', '', '1'),
(103, 'T093', 'T03', 'L05', '', '1'),
(104, 'T094', 'T04', 'L05', '', '2'),
(105, 'T095', 'T05', 'L05', '', '1'),
(106, 'T096', 'T06', 'L05', '', '1'),
(107, 'T097', 'T07', 'L05', '', '1'),
(108, 'T098', 'T08', 'L05', '', '1'),
(109, 'T099', 'T09', 'L05', '', '1');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=286 ;

--
-- Dumping data for table `tblmastermenu`
--

INSERT INTO `tblmastermenu` (`id`, `kode_menu`, `nama_menu`, `kode_cat`, `paket`, `harga`, `tax`, `svc`, `kode_printer`, `keterangan`, `status`, `img`) VALUES
(112, 'M0001', 'Bintang (330 ml)', 'C0001', '0', 45000, '0', '0', 'P02', '', '0', 'gado.jpg'),
(113, 'M0002', 'San Miguel (330 ml)sss', 'C0001', '', 40000, '0', '0', 'P01', '', '1', '318MWIn8NXL.jpg'),
(114, 'M0003', 'Heineken (330ml)s', 'C0001', '', 45000, '0', '0', 'P01', '', '1', '12745447_1049563198418288_4603910818529251586_n.jpg'),
(115, 'M0004', 'Coke', 'C0002', '0', 35000, '0', '0', 'P01', '', '1', 'soft_drinks.jpg'),
(116, 'M0005', 'Spritteeee', 'C0002', '0', 35000, '0', '0', 'P01', '', '1', 'soft_drinks.jpg'),
(117, 'M0006', 'Equil Natural', 'C0002', '0', 35000, '1', '0', 'P01', '', '1', ''),
(118, 'M0007', 'Equil Sparkling', 'C0002', '0', 35000, '0', '0', 'P01', '', '1', ''),
(119, 'M0008', 'English Breakfast', 'C0003', '0', 25000, '0', '0', 'P01', '', '1', ''),
(120, 'M0009', 'Papermint Tea', 'C0003', '0', 25000, '0', '0', 'P01', '', '1', ''),
(121, 'M0010', 'Camomile', 'C0003', '0', 25000, '0', '0', 'P01', '', '1', ''),
(122, 'M0011', 'Rooibos Vanilla', 'C0003', '0', 25000, '0', '0', 'P01', '', '1', ''),
(123, 'M0012', 'Verbena', 'C0003', '0', 25000, '0', '0', 'P01', '', '1', ''),
(124, 'M0013', 'Ice Tea', 'C0004', '0', 25000, '0', '0', 'P01', '', '1', 'ice_tea.jpg'),
(125, 'M0014', 'Lemon Tea', 'C0004', '0', 35000, '0', '0', 'P01', '', '1', ''),
(126, 'M0015', 'Lychee Ice Tea', 'C0004', '0', 35000, '0', '0', 'P01', '', '1', ''),
(127, 'M0016', 'King Strawberry', 'C0005', '0', 49000, '0', '0', 'P01', '', '1', ''),
(128, 'M0017', 'Mango Maniac', 'C0005', '0', 49000, '0', '0', 'P01', '', '1', 'jus_mangga.jpg'),
(129, 'M0018', 'Freshly Squeezed', 'C0006', '0', 49000, '0', '0', 'P01', '', '1', ''),
(130, 'M0019', 'Dragon Crushed', 'C0006', '0', 49000, '0', '0', 'P01', '', '1', ''),
(131, 'M0020', 'Beetroort Berry', 'C0006', '0', 49000, '0', '0', 'P01', '', '1', ''),
(132, 'M0021', 'Bendera Indonesia', 'C0006', '0', 49000, '0', '0', 'P01', '', '1', ''),
(133, 'M0022', 'BG Detox', 'C0006', '0', 49000, '0', '0', 'P01', '', '0', ''),
(134, 'M0023', 'Espresso', 'C0007', '0', 25000, '0', '0', 'P01', '', '1', ''),
(135, 'M0024', 'Macchiato', 'C0007', '0', 25000, '0', '0', 'P01', '', '1', ''),
(136, 'M0025', 'Americano', 'C0007', '0', 25000, '0', '0', 'P01', '', '1', ''),
(137, 'M0026', 'Piccolo Latte', 'C0007', '0', 30000, '0', '0', 'P01', '', '1', ''),
(138, 'M0027', 'Cappuccino', 'C0007', '0', 30000, '0', '0', 'P01', '', '1', 'hot_coffee.jpg'),
(139, 'M0028', 'Caffe Latte', 'C0007', '0', 30000, '0', '0', 'P01', '', '1', ''),
(140, 'M0029', 'Flat White', 'C0007', '0', 30000, '0', '0', 'P01', '', '1', ''),
(141, 'M0030', 'Caramel Latte', 'C0008', '0', 35000, '0', '0', 'P01', '', '1', ''),
(142, 'M0031', 'Hazelnut Latte', 'C0008', '0', 35000, '0', '0', 'P01', '', '1', ''),
(143, 'M0032', 'Vanilla Latte', 'C0008', '0', 35000, '0', '0', 'P01', '', '1', ''),
(144, 'M0033', 'Mocha Latte', 'C0008', '0', 35000, '0', '0', 'P01', '', '1', ''),
(145, 'M0034', 'Caramel Vanilla Latte', 'C0008', '0', 35000, '0', '0', 'P01', '', '1', ''),
(146, 'M0035', 'Vanilla Blast', 'C0009', '0', 45000, '0', '0', 'P01', '', '1', ''),
(147, 'M0036', 'Hazelnut Mocha', 'C0009', '0', 45000, '0', '0', 'P01', '', '1', ''),
(148, 'M0037', 'Caramel Latte', 'C0009', '0', 45000, '0', '0', 'P01', '', '1', ''),
(149, 'M0038', 'Mochaccino', 'C0009', '0', 45000, '0', '0', 'P01', '', '1', ''),
(150, 'M0039', 'Hot Chocoholic', 'C0010', '0', 35000, '0', '0', 'P01', '', '1', ''),
(151, 'M0040', 'Green Tea Latte', 'C0010', '0', 35000, '0', '0', 'P02', '', '1', ''),
(152, 'M0041', 'Ice Chocoholic', 'C0010', '0', 45000, '0', '0', 'P01', '', '1', ''),
(153, 'M0042', 'Freezle Green Tea', 'C0010', '0', 45000, '0', '0', 'P01', '', '1', ''),
(154, 'M0043', 'Choco Hazelnut', 'C0010', '0', 45000, '0', '0', 'P01', '', '1', ''),
(155, 'M0044', 'Choco Chips', 'C0010', '0', 45000, '0', '0', 'P01', '', '1', ''),
(156, 'M0045', 'Risotto', 'C0011', '0', 55000, '0', '0', 'P01', '', '1', ''),
(157, 'M0046', 'Fish n Chips', 'C0011', '0', 59000, '0', '0', 'P01', '', '1', ''),
(158, 'M0047', 'BBQ Seared Chicken With Velvet', 'C0011', '0', 59000, '0', '0', 'P01', '', '1', ''),
(159, 'M0048', 'Rice Chicken Gratin', 'C0011', '0', 70000, '0', '0', 'P01', '', '1', ''),
(160, 'M0049', 'Fettucine Taragon', 'C0011', '0', 70000, '0', '0', 'P01', '', '1', ''),
(161, 'M0050', 'Pasta Carbonara', 'C0011', '0', 70000, '0', '0', 'P01', '', '1', ''),
(162, 'M0051', 'Roast Baby Chicken', 'C0011', '0', 75000, '0', '0', 'P01', '', '1', ''),
(163, 'M0052', 'Spicy Duck Sphagetti Aglio Oli', 'C0011', '0', 75000, '0', '0', 'P01', '', '1', ''),
(164, 'M0053', 'Spicy Seafood Sphagetti Aglio ', 'C0011', '0', 89000, '0', '0', 'P01', '', '1', ''),
(165, 'M0054', 'Steak Sandwich', 'C0011', '0', 90000, '0', '0', 'P01', '', '1', ''),
(166, 'M0055', 'Baked Salmon', 'C0011', '0', 99000, '0', '0', 'P01', '', '1', ''),
(167, 'M0056', 'Triplet', 'C0012', '0', 35000, '0', '0', 'P01', '', '1', ''),
(168, 'M0057', 'Chocolate', 'C0012', '0', 35000, '0', '0', 'P01', '', '1', ''),
(169, 'M0058', 'Straberry', 'C0012', '0', 35000, '0', '0', 'P01', '', '1', ''),
(170, 'M0059', 'Espresso', 'C0012', '0', 35000, '0', '0', 'P01', '', '1', ''),
(171, 'M0060', 'Cakes', 'C0013', '0', 45000, '0', '0', 'P01', '', '1', ''),
(172, 'M0061', 'Plain Croissant', 'C0014', '0', 20000, '0', '0', 'P01', '', '1', ''),
(173, 'M0062', 'Chocolate Croissant', 'C0014', '0', 20000, '0', '0', 'P01', '', '1', ''),
(174, 'M0063', 'Raisin Roll', 'C0014', '0', 22000, '0', '0', 'P01', '', '1', ''),
(175, 'M0064', 'Cinnamon Roll', 'C0014', '0', 22000, '0', '0', 'P01', '', '1', ''),
(176, 'M0065', 'Chocolate Danish', 'C0014', '0', 22000, '0', '0', 'P01', '', '1', ''),
(177, 'M0066', 'Blueberry Danish', 'C0014', '0', 22000, '0', '0', 'P01', '', '1', ''),
(178, 'M0067', 'Almond', 'C0014', 'on', 28000, '0', '0', 'P01', '', '1', ''),
(179, 'M0068', 'Apple Pie', 'C0014', '0', 35000, '0', '0', 'P01', '', '1', ''),
(180, 'M0069', 'Chicken Pie', 'C0014', '0', 39000, '0', '0', 'P01', '', '1', ''),
(181, 'M0070', 'French Fries', 'C0015', '0', 29000, '0', '0', 'P01', '', '1', ''),
(182, 'M0071', 'Parmesan Garlic Baguette', 'C0015', '0', 30000, '0', '0', 'P01', '', '1', ''),
(183, 'M0072', 'Marinated Chicken Wings', 'C0015', '0', 35000, '0', '0', 'P01', '', '1', 'Buffalo-Chicken-Wings.jpg'),
(184, 'M0073', 'Rustic Potato Boats', 'C0015', '0', 35000, '0', '0', 'P01', '', '1', ''),
(185, 'M0074', 'Chermoula Chicken Strips', 'C0015', '0', 38000, '0', '0', 'P01', '', '1', ''),
(186, 'M0075', 'Melted Croguete', 'C0015', '0', 38000, '0', '0', 'P01', '', '1', ''),
(187, 'M0076', 'Flaky Puff Pizza', 'C0015', '0', 45000, '0', '0', 'P01', '', '1', ''),
(188, 'M0077', 'Crispy Calamary', 'C0015', '0', 49000, '0', '0', 'P01', '', '1', ''),
(189, 'M0078', 'Bread Basket', 'C0016', '0', 34000, '0', '0', 'P01', '', '1', ''),
(190, 'M0079', 'Egg Supreme', 'C0016', '0', 34000, '0', '0', 'P01', '', '1', ''),
(191, 'M0080', 'Indonesian Fried Rice', 'C0016', '0', 39000, '0', '0', 'P01', '', '1', ''),
(192, 'M0081', 'French Toast Lover', 'C0016', '0', 40000, '0', '0', 'P01', '', '1', ''),
(193, 'M0082', 'Old Fashined Breakfast', 'C0016', '0', 55000, '0', '0', 'P01', '', '1', ''),
(194, 'M0083', 'Sunshine Eggle', 'C0016', '0', 55000, '0', '0', 'P01', '', '1', ''),
(195, 'M0084', 'Continental Breakfast', 'C0016', '0', 65000, '0', '0', 'P01', '', '1', ''),
(196, 'M0085', 'Nasi Goreng Kampung', 'C0017', '0', 55000, '0', '0', 'P01', '', '1', ''),
(197, 'M0086', 'Seafood Fried Rice', 'C0017', '0', 60000, '0', '0', 'P01', '', '1', 'shrimp-fried-rice.jpg'),
(198, 'M0087', 'Duck Fried Rice', 'C0017', '0', 65000, '0', '0', 'P01', '', '1', ''),
(199, 'M0088', 'Vegetarian Curry Laksa', 'C0017', '0', 68000, '0', '0', 'P01', '', '1', 'IMG_8956.jpg'),
(200, 'M0089', 'Chicken Curry Laksa', 'C0017', '0', 68000, '0', '0', 'P01', '', '1', ''),
(201, 'M0090', 'Seafood Curry Laksa', 'C0017', '0', 68000, '0', '0', 'P01', '', '1', ''),
(202, 'M0091', 'Chicken Tom Yum Soup', 'C0018', '0', 39000, '0', '0', 'P01', '', '1', ''),
(203, 'M0092', 'Seafood Tom Yum Soup', 'C0018', '0', 39000, '0', '0', 'P01', '', '1', ''),
(204, 'M0093', 'Classic Creamy Mushroom Soup', 'C0018', '0', 39000, '0', '0', 'P01', '', '1', ''),
(205, 'M0094', 'Vegetarian Caesar Salads', 'C0019', '0', 50000, '0', '0', 'P01', '', '1', ''),
(206, 'M0095', 'Grilled Chicken Caesar Salads', 'C0019', '0', 50000, '0', '0', 'P01', '', '1', ''),
(207, 'M0096', 'Thai Beef Salad', 'C0019', '0', 65000, '0', '0', 'P01', '', '1', ''),
(270, 'M0103', 'CAKES BUY 1 GET 1', 'C0020', 'on', 35000, '0', '0', 'P01', '', '1', ''),
(285, 'M0104', 'BUY 2 GET 1 FREE CARAMEL VANIL', 'C0020', 'on', 150000, '0', '0', 'P01', '', '1', '23570.jpg');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `tblmastermenu_paket`
--

INSERT INTO `tblmastermenu_paket` (`id`, `kode_menupaket`, `kode_menu`, `qty`, `keterangan`, `status`) VALUES
(53, 'M0104', 'M0034', 3, '', '1'),
(52, 'M0103', 'M0060', 2, '', '1'),
(51, 'M0102', 'M0068', 2, '', '1'),
(50, 'M0102', 'M0010', 5, '', '1');

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
(1, 'P01', 'K1', 'Microsoft XPS Document Writer', '', '1'),
(2, 'P02', 'K2', 'Microsoft XPS Document Writer', '', '1'),
(3, 'P03', 'K3', 'Generic', '', '1'),
(4, 'P04', 'B1', 'Generic', '', '1'),
(5, 'P05', 'C1', 'Generic', '', '1'),
(6, 'P06', 'sdd', 'dsa', '', '1');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

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
(9, 'W006', 'Bams', '123', 'None', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tblpos_to_inv`
--

CREATE TABLE IF NOT EXISTS `tblpos_to_inv` (
  `pos_id` varchar(10) NOT NULL,
  `inv_id` varchar(10) NOT NULL,
  `input_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbltransaksibarang`
--

CREATE TABLE IF NOT EXISTS `tbltransaksibarang` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(15) NOT NULL,
  `tanggal` datetime NOT NULL,
  `jenis_transaksi` varchar(10) NOT NULL,
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbltrans_summary`
--

CREATE TABLE IF NOT EXISTS `tbltrans_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_bukti` varchar(15) NOT NULL,
  `user` varchar(10) NOT NULL,
  `sub_total` float NOT NULL,
  `disc` float NOT NULL,
  `svc` float NOT NULL,
  `tax` float NOT NULL,
  `total` float NOT NULL,
  `zstatus` varchar(5) NOT NULL,
  `pettycash` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`id`, `nama`, `access_level`, `user_id`, `password`, `on_line`, `net`, `status`) VALUES
(1, 'Administrator', 'Administrator', 'admin', 'admin', 'No', '', '1'),
(2, 'Pri', 'Administrator', 'pri', 'pri', 'No', '192.168.1.196', '1'),
(26, 'Anez', 'Administrator', 'anez', 'anez', 'Yes', '25.14.182.200', '1'),
(27, 'Sidik', 'Kasir', 's', 's', 'No', '', '1'),
(28, 'Dani', 'Kasir', 'd', 'd', 'Yes', '25.14.182.200', '1');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `footer_line1` varchar(36) NOT NULL,
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
(1, 'Warung Sidik', 'Galur', 'Selatan', '000123', '', '', '', 10, 10, 5, '0', 0, 'Microsoft XPS Document Writer', 'Microsoft XPS Document Writer', '', '', '9', '23');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

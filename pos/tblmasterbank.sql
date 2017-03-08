-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 18, 2016 at 07:07 AM
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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

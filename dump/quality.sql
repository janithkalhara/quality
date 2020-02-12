-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 20, 2013 at 12:05 AM
-- Server version: 5.5.31
-- PHP Version: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `quality`
--

-- --------------------------------------------------------

--
-- Table structure for table `qa_ap_acerValue`
--

CREATE TABLE IF NOT EXISTS `qa_ap_acerValue` (
  `revisionId` varchar(20) NOT NULL,
  `weekCount` varchar(20) NOT NULL,
  `week` varchar(20) NOT NULL,
  `weekNumber` int(3) NOT NULL,
  `noOfAcers` decimal(8,2) NOT NULL,
  `seeded` tinyint(2) NOT NULL,
  PRIMARY KEY (`revisionId`,`weekCount`,`week`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_ap_acerValue`
--

INSERT INTO `qa_ap_acerValue` (`revisionId`, `weekCount`, `week`, `weekNumber`, `noOfAcers`, `seeded`) VALUES
('103-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('103-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('103-12-1', '1', '12-01/18-01/2013', 2, 0.00, 0),
('103-12-1', '1', '19-01/25-01/2013', 3, 20.00, 0),
('104-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('104-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('104-12-1', '1', '12-01/18-01/2013', 2, 0.00, 0),
('104-12-1', '1', '19-01/25-01/2013', 3, 0.00, 0),
('104-12-1', '1', '26-01/01-02/2013', 4, 40.00, 0),
('105-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('105-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('105-12-1', '1', '12-01/18-01/2013', 2, 0.00, 0),
('105-12-1', '1', '19-01/25-01/2013', 3, 0.00, 0),
('105-12-1', '1', '26-01/01-02/2013', 4, 20.00, 0),
('106-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('106-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('106-12-1', '1', '12-01/18-01/2013', 2, 0.00, 0),
('106-12-1', '1', '19-01/25-01/2013', 3, 0.00, 0),
('106-12-1', '1', '26-01/01-02/2013', 4, 0.00, 0),
('106-12-1', '1', '02-02/08-02/2013', 5, 20.00, 0),
('107-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('107-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('107-12-1', '1', '12-01/18-01/2013', 2, 0.00, 0),
('107-12-1', '1', '19-01/25-01/2013', 3, 0.00, 0),
('107-12-1', '1', '26-01/01-02/2013', 4, 0.00, 0),
('107-12-1', '1', '02-02/08-02/2013', 5, 20.00, 0),
('108-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('108-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('108-12-1', '1', '12-01/18-01/2013', 2, 0.00, 0),
('108-12-1', '1', '19-01/25-01/2013', 3, 0.00, 0),
('108-12-1', '1', '26-01/01-02/2013', 4, 25.00, 0),
('108-12-1', '1', '02-02/08-02/2013', 5, 0.00, 0),
('95-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('95-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('95-12-1', '1', '12-01/18-01/2013', 2, 20.00, 0),
('95-12-1', '1', '19-01/25-01/2013', 3, 10.00, 0),
('96-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('96-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('96-12-1', '1', '12-01/18-01/2013', 2, 20.00, 0),
('98-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('98-12-1', '1', '05-01/11-01/2013', 1, 40.00, 0),
('98-12-1', '1', '12-01/18-01/2013', 2, 10.00, 0),
('97-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('97-12-1', '1', '05-01/11-01/2013', 1, 20.00, 0),
('97-12-1', '1', '12-01/18-01/2013', 2, 20.00, 0),
('99-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('99-12-1', '1', '05-01/11-01/2013', 1, 25.00, 0),
('99-12-1', '1', '12-01/18-01/2013', 2, 25.00, 0),
('100-12-1', '1', '29-12/04-01/2012', 0, 20.00, 0),
('100-12-1', '1', '05-01/11-01/2013', 1, 30.00, 0),
('101-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('101-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('101-12-1', '1', '12-01/18-01/2013', 2, 0.00, 0),
('101-12-1', '1', '19-01/25-01/2013', 3, 10.00, 0),
('102-12-1', '1', '29-12/04-01/2012', 0, 0.00, 0),
('102-12-1', '1', '05-01/11-01/2013', 1, 0.00, 0),
('102-12-1', '1', '12-01/18-01/2013', 2, 0.00, 0),
('102-12-1', '1', '19-01/25-01/2013', 3, 30.00, 0),
('95-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('95-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('95-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('95-12-3', '3', '19-01/25-01/2013', 3, 10.00, 0),
('96-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('96-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('96-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('96-12-3', '3', '19-01/25-01/2013', 3, 20.00, 0),
('98-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('98-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('98-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('98-12-3', '3', '19-01/25-01/2013', 3, 40.00, 0),
('98-12-3', '3', '26-01/01-02/2013', 4, 5.00, 0),
('97-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('97-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('97-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('97-12-3', '3', '19-01/25-01/2013', 3, 15.00, 0),
('97-12-3', '3', '26-01/01-02/2013', 4, 10.00, 0),
('99-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('99-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('99-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('99-12-3', '3', '19-01/25-01/2013', 3, 25.00, 0),
('99-12-3', '3', '26-01/01-02/2013', 4, 25.00, 0),
('100-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('100-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('100-12-3', '3', '12-01/18-01/2013', 2, 10.00, 0),
('100-12-3', '3', '19-01/25-01/2013', 3, 15.00, 0),
('101-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('101-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('101-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('101-12-3', '3', '19-01/25-01/2013', 3, 0.00, 0),
('101-12-3', '3', '26-01/01-02/2013', 4, 0.00, 0),
('101-12-3', '3', '02-02/08-02/2013', 5, 10.00, 0),
('102-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('102-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('102-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('102-12-3', '3', '19-01/25-01/2013', 3, 0.00, 0),
('102-12-3', '3', '26-01/01-02/2013', 4, 0.00, 0),
('102-12-3', '3', '02-02/08-02/2013', 5, 0.00, 0),
('102-12-3', '3', '09-02/15-02/2013', 6, 0.00, 0),
('102-12-3', '3', '16-02/22-02/2013', 7, 10.00, 0),
('102-12-3', '3', '23-02/01-03/2013', 8, 20.00, 0),
('102-12-3', '3', '02-03/08-03/2013', 9, 0.00, 0),
('103-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('103-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('103-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('103-12-3', '3', '19-01/25-01/2013', 3, 0.00, 0),
('103-12-3', '3', '26-01/01-02/2013', 4, 10.00, 0),
('103-12-3', '3', '02-02/08-02/2013', 5, 10.00, 0),
('104-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('104-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('104-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('104-12-3', '3', '19-01/25-01/2013', 3, 10.00, 0),
('104-12-3', '3', '26-01/01-02/2013', 4, 20.00, 0),
('104-12-3', '3', '02-02/08-02/2013', 5, 10.00, 0),
('105-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('105-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('105-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('105-12-3', '3', '19-01/25-01/2013', 3, 0.00, 0),
('105-12-3', '3', '26-01/01-02/2013', 4, 20.00, 0),
('106-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('106-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('106-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('106-12-3', '3', '19-01/25-01/2013', 3, 0.00, 0),
('106-12-3', '3', '26-01/01-02/2013', 4, 0.00, 0),
('106-12-3', '3', '02-02/08-02/2013', 5, 20.00, 0),
('107-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('107-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('107-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('107-12-3', '3', '19-01/25-01/2013', 3, 0.00, 0),
('107-12-3', '3', '26-01/01-02/2013', 4, 0.00, 0),
('107-12-3', '3', '02-02/08-02/2013', 5, 20.00, 0),
('108-12-3', '3', '29-12/04-01/2012', 0, 0.00, 0),
('108-12-3', '3', '05-01/11-01/2013', 1, 0.00, 0),
('108-12-3', '3', '12-01/18-01/2013', 2, 0.00, 0),
('108-12-3', '3', '19-01/25-01/2013', 3, 0.00, 0),
('108-12-3', '3', '26-01/01-02/2013', 4, 0.00, 0),
('108-12-3', '3', '02-02/08-02/2013', 5, 0.00, 0),
('108-12-3', '3', '09-02/15-02/2013', 6, 0.00, 0),
('108-12-3', '3', '16-02/22-02/2013', 7, 25.00, 0),
('95-12-4', '4', '29-12/04-01/2012', 0, 0.00, 0),
('95-12-4', '4', '05-01/11-01/2013', 1, 0.00, 0),
('95-12-4', '4', '12-01/18-01/2013', 2, 10.00, 0),
('95-12-4', '4', '19-01/25-01/2013', 3, 0.00, 0),
('96-12-4', '4', '29-12/04-01/2012', 0, 0.00, 0),
('96-12-4', '4', '05-01/11-01/2013', 1, 0.00, 0),
('96-12-4', '4', '12-01/18-01/2013', 2, 5.00, 0),
('96-12-4', '4', '19-01/25-01/2013', 3, 15.00, 0),
('98-12-4', '4', '29-12/04-01/2012', 0, 0.00, 0),
('98-12-4', '4', '05-01/11-01/2013', 1, 0.00, 0),
('98-12-4', '4', '12-01/18-01/2013', 2, 0.00, 0),
('98-12-4', '4', '19-01/25-01/2013', 3, 40.00, 0),
('98-12-4', '4', '26-01/01-02/2013', 4, 5.00, 0),
('97-12-4', '4', '29-12/04-01/2012', 0, 0.00, 0),
('97-12-4', '4', '05-01/11-01/2013', 1, 0.00, 0),
('97-12-4', '4', '12-01/18-01/2013', 2, 0.00, 0),
('97-12-4', '4', '19-01/25-01/2013', 3, 15.00, 0),
('97-12-4', '4', '26-01/01-02/2013', 4, 10.00, 0),
('99-12-4', '4', '29-12/04-01/2012', 0, 0.00, 0),
('99-12-4', '4', '05-01/11-01/2013', 1, 0.00, 0),
('99-12-4', '4', '12-01/18-01/2013', 2, 0.00, 0),
('99-12-4', '4', '19-01/25-01/2013', 3, 25.00, 0),
('99-12-4', '4', '26-01/01-02/2013', 4, 25.00, 0),
('100-12-4', '4', '29-12/04-01/2012', 0, 0.00, 0),
('100-12-4', '4', '05-01/11-01/2013', 1, 0.00, 0),
('100-12-4', '4', '12-01/18-01/2013', 2, 10.00, 0),
('100-12-4', '4', '19-01/25-01/2013', 3, 15.00, 0),
('101-12-4', '4', '29-12/04-01/2012', 0, 0.00, 0),
('101-12-4', '4', '05-01/11-01/2013', 1, 0.00, 0),
('101-12-4', '4', '12-01/18-01/2013', 2, 0.00, 0),
('101-12-4', '4', '19-01/25-01/2013', 3, 0.00, 0),
('101-12-4', '4', '26-01/01-02/2013', 4, 0.00, 0),
('101-12-4', '4', '02-02/08-02/2013', 5, 10.00, 0),
('108-12-4', '4', '29-12/04-01/2012', 0, 0.00, 0),
('108-12-4', '4', '05-01/11-01/2013', 1, 0.00, 0),
('108-12-4', '4', '12-01/18-01/2013', 2, 0.00, 0),
('108-12-4', '4', '19-01/25-01/2013', 3, 0.00, 0),
('108-12-4', '4', '26-01/01-02/2013', 4, 0.00, 0),
('108-12-4', '4', '02-02/08-02/2013', 5, 0.00, 0),
('108-12-4', '4', '09-02/15-02/2013', 6, 0.00, 0),
('108-12-4', '4', '16-02/22-02/2013', 7, 10.00, 0),
('108-12-4', '4', '23-02/01-03/2013', 8, 20.00, 0),
('95-12-5', '5', '29-12/04-01/2012', 0, 0.00, 0),
('95-12-5', '5', '05-01/11-01/2013', 1, 0.00, 0),
('95-12-5', '5', '12-01/18-01/2013', 2, 10.00, 1),
('95-12-5', '5', '19-01/25-01/2013', 3, 1.00, 1),
('96-12-5', '5', '29-12/04-01/2012', 0, 0.00, 0),
('96-12-5', '5', '05-01/11-01/2013', 1, 0.00, 0),
('96-12-5', '5', '12-01/18-01/2013', 2, 5.00, 1),
('96-12-5', '5', '19-01/25-01/2013', 3, 11.00, 1),
('96-12-6', '6', '29-12/04-01/2012', 0, 0.00, 0),
('96-12-6', '6', '05-01/11-01/2013', 1, 0.00, 0),
('96-12-6', '6', '12-01/18-01/2013', 2, 10.00, 1),
('96-12-6', '6', '19-01/25-01/2013', 3, 1.00, 1),
('98-12-6', '6', '29-12/04-01/2012', 0, 0.00, 0),
('98-12-6', '6', '05-01/11-01/2013', 1, 0.00, 0),
('98-12-6', '6', '12-01/18-01/2013', 2, 0.00, 0),
('98-12-6', '6', '19-01/25-01/2013', 3, 0.00, 0),
('98-12-6', '6', '26-01/01-02/2013', 4, 22.00, 1),
('98-12-6', '6', '02-02/08-02/2013', 5, 23.00, 0),
('97-12-6', '6', '29-12/04-01/2012', 0, 0.00, 0),
('97-12-6', '6', '05-01/11-01/2013', 1, 0.00, 0),
('97-12-6', '6', '12-01/18-01/2013', 2, 0.00, 0),
('97-12-6', '6', '19-01/25-01/2013', 3, 0.00, 0),
('97-12-6', '6', '26-01/01-02/2013', 4, 7.00, 1),
('97-12-6', '6', '02-02/08-02/2013', 5, 3.00, 0),
('99-12-6', '6', '29-12/04-01/2012', 0, 0.00, 0),
('99-12-6', '6', '05-01/11-01/2013', 1, 0.00, 0),
('99-12-6', '6', '12-01/18-01/2013', 2, 0.00, 0),
('99-12-6', '6', '19-01/25-01/2013', 3, 0.00, 0),
('99-12-6', '6', '26-01/01-02/2013', 4, 25.00, 1),
('99-12-6', '6', '02-02/08-02/2013', 5, 15.00, 0),
('100-12-6', '6', '29-12/04-01/2012', 0, 0.00, 0),
('100-12-6', '6', '05-01/11-01/2013', 1, 0.00, 0),
('100-12-6', '6', '12-01/18-01/2013', 2, 10.00, 1),
('100-12-6', '6', '19-01/25-01/2013', 3, 12.00, 1),
('100-12-6', '6', '26-01/01-02/2013', 4, 3.00, 1),
('103-12-6', '6', '29-12/04-01/2012', 0, 0.00, 0),
('103-12-6', '6', '05-01/11-01/2013', 1, 0.00, 0),
('103-12-6', '6', '12-01/18-01/2013', 2, 0.00, 0),
('103-12-6', '6', '19-01/25-01/2013', 3, 0.00, 0),
('103-12-6', '6', '26-01/01-02/2013', 4, 10.00, 1),
('103-12-6', '6', '02-02/08-02/2013', 5, 0.00, 0),
('95-12-6', '6', '29-12/04-01/2012', 0, 0.00, 0),
('95-12-6', '6', '05-01/11-01/2013', 1, 0.00, 0),
('95-12-6', '6', '12-01/18-01/2013', 2, 10.00, 1),
('95-12-6', '6', '19-01/25-01/2013', 3, 1.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `qa_ap_GradeShare`
--

CREATE TABLE IF NOT EXISTS `qa_ap_GradeShare` (
  `gradeId` varchar(10) NOT NULL,
  `share` decimal(5,2) NOT NULL,
  `gradeCategory` varchar(20) NOT NULL,
  `fruitCount` varchar(20) NOT NULL,
  PRIMARY KEY (`gradeId`,`gradeCategory`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_ap_GradeShare`
--

INSERT INTO `qa_ap_GradeShare` (`gradeId`, `share`, `gradeCategory`, `fruitCount`) VALUES
('31', 0.70, 'Large', '10/15(No.3)'),
('32', 0.05, 'Large', '5/10(No.4)'),
('35', 0.08, 'Large', '15/25(No.2)'),
('36', 0.17, 'Large', 'CRS'),
('44', 0.35, 'Small', '160/250'),
('45', 0.25, 'Small', '90/150'),
('46', 0.15, 'Small', '20/80'),
('47', 0.10, 'Small', '5/20'),
('48', 0.15, 'Small', 'CRS'),
('44', 0.35, '5', '160/250'),
('45', 0.25, '5', '90/150'),
('46', 0.15, '5', '20/80'),
('47', 0.10, '5', '5/20'),
('48', 0.15, '5', 'CRS'),
('31', 0.70, '2', '10/15(No.3)'),
('32', 0.05, '2', '5/10(No.4)'),
('35', 0.08, '2', '15/25(No.2)'),
('36', 0.17, '2', 'CRS');

-- --------------------------------------------------------

--
-- Table structure for table `qa_ap_gradeWeekPercentages`
--

CREATE TABLE IF NOT EXISTS `qa_ap_gradeWeekPercentages` (
  `seasonId` varchar(5) NOT NULL,
  `cate_id` int(10) NOT NULL,
  `gradeName` varchar(25) NOT NULL,
  `weekNo` int(2) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  PRIMARY KEY (`seasonId`,`cate_id`,`weekNo`),
  KEY `gradeName` (`gradeName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_ap_gradeWeekPercentages`
--

INSERT INTO `qa_ap_gradeWeekPercentages` (`seasonId`, `cate_id`, `gradeName`, `weekNo`, `percentage`) VALUES
('12', 2, 'Large', 1, 10.00),
('12', 2, 'Large', 2, 30.00),
('12', 2, 'Large', 3, 40.00),
('12', 2, 'Large', 4, 20.00),
('12', 6, '160/250+20/80', 1, 10.70),
('12', 6, '160/250+20/80', 2, 17.60),
('12', 6, '160/250+20/80', 3, 17.20),
('12', 6, '160/250+20/80', 4, 19.40),
('12', 6, '160/250+20/80', 5, 17.40),
('12', 6, '160/250+20/80', 6, 11.20),
('12', 6, '160/250+20/80', 7, 6.50),
('12', 5, 'Small', 7, 6.50),
('12', 5, 'Small', 6, 11.20),
('12', 5, 'Small', 5, 17.40),
('12', 5, 'Small', 4, 19.40),
('12', 5, 'Small', 3, 17.20),
('12', 5, 'Small', 2, 17.60),
('12', 5, 'Small', 1, 10.70);

-- --------------------------------------------------------

--
-- Table structure for table `qa_ap_patternValue`
--

CREATE TABLE IF NOT EXISTS `qa_ap_patternValue` (
  `arrivalId` varchar(20) NOT NULL,
  `weekNo` varchar(20) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  PRIMARY KEY (`arrivalId`,`weekNo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qa_ap_revision`
--

CREATE TABLE IF NOT EXISTS `qa_ap_revision` (
  `revisionId` varchar(20) NOT NULL,
  `projectId` varchar(20) NOT NULL,
  `seasonId` varchar(20) NOT NULL,
  `weekCount` varchar(20) NOT NULL,
  PRIMARY KEY (`revisionId`,`projectId`,`seasonId`,`weekCount`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_ap_revision`
--

INSERT INTO `qa_ap_revision` (`revisionId`, `projectId`, `seasonId`, `weekCount`) VALUES
('100-12-3', '100', '12', '3'),
('100-12-4', '100', '12', '4'),
('100-12-6', '100', '12', '6'),
('101-12-3', '101', '12', '3'),
('101-12-4', '101', '12', '4'),
('102-12-3', '102', '12', '3'),
('103-12-3', '103', '12', '3'),
('103-12-6', '103', '12', '6'),
('104-12-3', '104', '12', '3'),
('105-12-3', '105', '12', '3'),
('106-12-3', '106', '12', '3'),
('107-12-3', '107', '12', '3'),
('108-12-3', '108', '12', '3'),
('108-12-4', '108', '12', '4'),
('95-12-3', '95', '12', '3'),
('95-12-4', '95', '12', '4'),
('95-12-5', '95', '12', '5'),
('95-12-6', '95', '12', '6'),
('96-12-3', '96', '12', '3'),
('96-12-4', '96', '12', '4'),
('96-12-5', '96', '12', '5'),
('96-12-6', '96', '12', '6'),
('97-12-3', '97', '12', '3'),
('97-12-4', '97', '12', '4'),
('97-12-6', '97', '12', '6'),
('98-12-3', '98', '12', '3'),
('98-12-4', '98', '12', '4'),
('98-12-6', '98', '12', '6'),
('99-12-3', '99', '12', '3'),
('99-12-4', '99', '12', '4'),
('99-12-6', '99', '12', '6');

-- --------------------------------------------------------

--
-- Table structure for table `qa_ap_seedingPlan`
--

CREATE TABLE IF NOT EXISTS `qa_ap_seedingPlan` (
  `planId` varchar(20) NOT NULL,
  `projectId` varchar(20) NOT NULL,
  `seasonId` varchar(20) NOT NULL,
  `weekCount` varchar(20) NOT NULL,
  PRIMARY KEY (`planId`,`projectId`,`seasonId`,`weekCount`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_ap_seedingPlan`
--

INSERT INTO `qa_ap_seedingPlan` (`planId`, `projectId`, `seasonId`, `weekCount`) VALUES
('100-12-1', '100', '12', '1'),
('101-12-1', '101', '12', '1'),
('102-12-1', '102', '12', '1'),
('103-12-1', '103', '12', '1'),
('104-12-1', '104', '12', '1'),
('105-12-1', '105', '12', '1'),
('106-12-1', '106', '12', '1'),
('107-12-1', '107', '12', '1'),
('108-12-1', '108', '12', '1'),
('95-12-1', '95', '12', '1'),
('96-12-1', '96', '12', '1'),
('97-12-1', '97', '12', '1'),
('98-12-1', '98', '12', '1'),
('99-12-1', '99', '12', '1');

-- --------------------------------------------------------

--
-- Table structure for table `qa_ap_week`
--

CREATE TABLE IF NOT EXISTS `qa_ap_week` (
  `revisionId` varchar(10) NOT NULL,
  `weekCount` int(11) NOT NULL,
  `weekNo` varchar(20) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`revisionId`,`weekCount`,`weekNo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qa_ap_ypaValues`
--

CREATE TABLE IF NOT EXISTS `qa_ap_ypaValues` (
  `projectId` varchar(5) NOT NULL,
  `seasonId` varchar(10) NOT NULL,
  `ypa` decimal(5,2) NOT NULL,
  PRIMARY KEY (`projectId`,`seasonId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_ap_ypaValues`
--

INSERT INTO `qa_ap_ypaValues` (`projectId`, `seasonId`, `ypa`) VALUES
('95', '12', 3.00),
('96', '12', 3.00),
('103', '12', 5.00),
('104', '12', 5.00),
('105', '12', 5.00),
('106', '12', 5.00),
('107', '12', 3.00),
('108', '12', 5.00),
('98', '12', 3.00),
('99', '12', 3.00),
('100', '12', 3.00),
('101', '12', 3.00),
('102', '12', 3.00),
('97', '12', 3.00);

-- --------------------------------------------------------

--
-- Table structure for table `qa_area`
--

CREATE TABLE IF NOT EXISTS `qa_area` (
  `areaId` int(20) NOT NULL AUTO_INCREMENT,
  `season` int(5) NOT NULL,
  `areaName` varchar(100) NOT NULL,
  `cate_id` int(10) NOT NULL,
  `areaType` int(10) NOT NULL,
  `inchargeName` varchar(40) NOT NULL,
  `userId` varchar(100) NOT NULL,
  PRIMARY KEY (`areaId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=113 ;

--
-- Dumping data for table `qa_area`
--

INSERT INTO `qa_area` (`areaId`, `season`, `areaName`, `cate_id`, `areaType`, `inchargeName`, `userId`) VALUES
(21, 9, 'Dissanayake-EX', 2, 1, 'DMHB Dissanayake', 'dissanayake'),
(22, 12, 'Sarath-EX', 2, 1, 'Sarath Wijewardhana', 'wijewardhana'),
(110, 12, 'Bakamuna-L-IN', 6, 0, 'WS Senevirathne', 'senevirathnews'),
(111, 12, 'Ampara-L', 6, 0, 'G Attanayaka', 'attanayaka'),
(112, 12, 'Medirigiriya-L-IN', 6, 0, 'WS Senevirathne', 'senevirathnews'),
(65, 10, 'Dayarathna-L-EX', 2, 1, 'AK Dayarathna', 'dayarathna'),
(72, 12, 'Tennison-L-EX', 2, 1, 'Tennision Karunarathne', 'karunarathne'),
(95, 12, 'Medirigiriya-S-IN', 5, 0, 'WS Senevirathne', 'senevirathnews'),
(96, 12, 'Bakamuna-S-IN', 5, 0, 'WS Senevirathne', 'senevirathnews'),
(97, 12, 'System B-S-IN', 5, 0, 'Ajith Indunil', 'indunil'),
(98, 12, 'Mahiyanganaya-S-IN', 5, 0, 'AMNG Sarath', 'sarath'),
(99, 12, 'Welikanda-S-IN', 5, 0, 'SV Fernando', 'fernandosv'),
(100, 12, 'Ampara-S-IN', 5, 0, 'G Attanayaka', 'attanayaka'),
(101, 12, 'Rideegama-S-IN', 5, 0, 'Upul Siriniwasa', 'Upul'),
(102, 12, 'North & East-S-IN', 5, 0, 'Mahend raj', 'mahendraj'),
(103, 12, 'Rathnayake-L-EX', 2, 1, 'RMKB Rathnayaka', 'rathnayaka'),
(105, 12, 'Dissanayake-L-EX', 2, 1, 'DMHB Dissanayake', 'dissanayake'),
(106, 12, 'Ajith-L-EX', 2, 1, 'Ajith Kumara', 'ajith'),
(107, 12, 'Saranga-L-EX', 2, 1, 'Mannapperuma EX', 'mannapperuma'),
(108, 12, 'North & East-L-EX', 2, 1, 'Mahend raj', 'mahendraj'),
(109, 12, 'Green House-S-IN', 5, 0, 'Green House', 'nalaka');

-- --------------------------------------------------------

--
-- Table structure for table `qa_arrivalData`
--

CREATE TABLE IF NOT EXISTS `qa_arrivalData` (
  `weekNo` varchar(40) NOT NULL,
  `project` varchar(120) NOT NULL,
  `projectId` varchar(5) NOT NULL,
  `gradeId` varchar(40) NOT NULL,
  `seasonId` varchar(120) NOT NULL,
  `cropFrom` date NOT NULL,
  `cropTo` date NOT NULL,
  `quantity` decimal(12,2) NOT NULL,
  PRIMARY KEY (`weekNo`,`project`,`projectId`,`gradeId`,`seasonId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `qa_center`
--

CREATE TABLE IF NOT EXISTS `qa_center` (
  `centerId` int(20) NOT NULL AUTO_INCREMENT,
  `areaId` varchar(20) NOT NULL,
  `centerName` varchar(40) NOT NULL,
  PRIMARY KEY (`centerId`,`areaId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=417 ;

--
-- Dumping data for table `qa_center`
--

INSERT INTO `qa_center` (`centerId`, `areaId`, `centerName`) VALUES
(3, '5', 'kumbukgate'),
(4, '9', 'Deegama'),
(10, '9', 'Neegama'),
(11, '11', 'Deegama'),
(12, '11', 'Neerammulla'),
(13, '11', 'Weligampaha'),
(14, '11', 'Nikagolla'),
(15, '11', 'Gatakulayaya'),
(16, '11', 'Track -10'),
(146, '49', 'Babarawana'),
(18, '11', 'Rathmale'),
(19, '11', 'Kalawana'),
(20, '11', 'Uthuruwella'),
(22, '13', 'Palamunei'),
(23, '13', 'Settipalayam'),
(24, '13', 'Eraur'),
(25, '13', 'Kurukamadam'),
(27, '13', 'Kiranchikulam'),
(28, '13', 'Poonachimune'),
(29, '13', 'Kalawanchikidy'),
(30, '14', 'Atharagala'),
(132, '49', 'Salpitigama'),
(131, '49', 'Namalgama'),
(125, '50', 'Yakkura'),
(124, '50', 'Ellewewa'),
(52, '17', 'Bathalagoda'),
(51, '17', 'Eppawala'),
(410, '112', 'Yatiyalpathana 1'),
(409, '112', 'NewTown'),
(118, '45', 'Yakkura'),
(130, '50', 'Madagampitiya'),
(116, '49', 'Ranhelagama'),
(53, '17', 'Menaragala'),
(57, '19', 'Girithale'),
(60, '21', 'Medawachchiya'),
(61, '21', 'Thabbowa'),
(112, '45', 'Ranhelagama'),
(111, '45', 'Ellewewa'),
(110, '45', 'Namalgama'),
(98, '48', 'a'),
(99, '45', 'Medagampitiya'),
(104, '48', 'a'),
(81, '32', 'Arawa'),
(82, '32', 'Kiriwehera'),
(83, '32', 'Akiriyawatte'),
(84, '32', 'Track-10'),
(87, '32', 'Hepola'),
(397, '95', '1-B yaya'),
(396, '95', 'Sansungama'),
(392, '95', 'Yatiyalpathana'),
(391, '95', 'New Town'),
(390, '100', 'Kahatagasyaya'),
(408, '111', 'Namalthalawa 1'),
(386, '100', 'Namalthalawa'),
(389, '100', 'Nawagiriyawa'),
(388, '100', '10-Ela'),
(387, '100', 'Gonagolla'),
(402, '96', 'Puwakgaha ulpatha'),
(401, '96', 'Diggalpitiya'),
(399, '96', 'Ambangaga'),
(400, '96', 'Ihakuluwewa'),
(407, '111', 'kahatagasyaya 1 '),
(406, '111', 'Nawagiriyawa 1'),
(405, '111', '10- Ela'),
(398, '96', 'Nikapitiya'),
(225, '65', 'Godakawela'),
(404, '111', 'Gonagala'),
(403, '110', 'Ambangala'),
(278, '65', 'Kaltota'),
(395, '95', 'Batukotuwa'),
(415, '112', '1- B Yaya'),
(331, '72', 'Nikawewa'),
(393, '95', 'South Ela'),
(414, '112', 'Sansungama 1'),
(411, '112', 'South- Ela'),
(412, '112', 'Yaya- 12'),
(346, '72', 'Ruwanpura'),
(413, '112', 'Batukotuwa 1'),
(384, '109', 'Alawwa'),
(379, '103', 'Okkampitiya'),
(380, '103', 'Siyambalanduwa'),
(394, '95', 'Yaya-12'),
(385, '106', 'center1'),
(416, '98', 'center 001');

-- --------------------------------------------------------

--
-- Table structure for table `qa_centerQuantity`
--

CREATE TABLE IF NOT EXISTS `qa_centerQuantity` (
  `id` int(20) NOT NULL,
  `project` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `vehicleNo` varchar(100) NOT NULL,
  `center` varchar(100) NOT NULL,
  `tmNo` varchar(100) NOT NULL,
  `grade1` decimal(6,2) NOT NULL,
  `grade2` decimal(6,2) NOT NULL,
  `grade3` decimal(6,2) NOT NULL,
  `grade4` decimal(6,2) NOT NULL,
  `grade5` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`,`date`,`vehicleNo`,`center`,`tmNo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_centerQuantity`
--

INSERT INTO `qa_centerQuantity` (`id`, `project`, `date`, `vehicleNo`, `center`, `tmNo`, `grade1`, `grade2`, `grade3`, `grade4`, `grade5`) VALUES
(87, 'Ampara', '2012-09-21 03:00:00', '22-2222', '08-Ela', '12345', 320.00, 456.00, 22.00, 15.00, 0.00),
(87, 'Ampara', '2012-09-21 03:00:00', '22-2222', '03-Ela', '78945', 450.00, 658.00, 125.00, 412.00, 0.00),
(87, 'Ampara', '2012-09-21 03:00:00', '22-2222', 'Pothana', '45689', 251.00, 224.00, 781.00, 120.00, 0.00),
(87, 'Ampara', '2012-12-11 00:00:00', '2323', 'Himdurawa', '23', 232.00, 0.00, 0.00, 0.00, 0.00),
(94, 'Kathnoruwa-M-IN', '2012-12-19 04:21:00', 'PS-1226', 'aththanagalla', '149713', 304.50, 61.00, 93.50, 0.00, 0.00),
(94, 'Kathnoruwa-M-IN', '2012-12-17 05:45:00', 'PS-1226', 'aththanagalla', '149712', 369.50, 79.00, 118.00, 0.00, 0.00),
(106, 'Ajith-L-EX', '2013-02-23 11:00:00', '223', 'center1', '232', 232.00, 0.00, 0.00, 0.00, 0.00),
(86, '', '2012-12-29 09:00:00', '2333', 'center1', '232', 232.00, 232.00, 232.00, 0.00, 0.00),
(94, 'Kathnoruwa-M-IN', '2012-10-15 05:00:00', 'PS-1226', 'aththanagalla', '149711', 547.00, 134.50, 181.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `qa_centerQuantitySmall`
--

CREATE TABLE IF NOT EXISTS `qa_centerQuantitySmall` (
  `id` int(10) NOT NULL,
  `project` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `vehicleNo` varchar(50) NOT NULL,
  `center` varchar(100) NOT NULL,
  `tmNo` varchar(100) NOT NULL,
  `grade1` decimal(8,2) NOT NULL,
  `grade2` decimal(8,2) NOT NULL,
  `grade3` decimal(8,2) NOT NULL,
  `grade4` decimal(8,2) NOT NULL,
  `grade5` decimal(8,2) NOT NULL,
  PRIMARY KEY (`project`,`date`,`vehicleNo`,`center`,`tmNo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_centerQuantitySmall`
--

INSERT INTO `qa_centerQuantitySmall` (`id`, `project`, `date`, `vehicleNo`, `center`, `tmNo`, `grade1`, `grade2`, `grade3`, `grade4`, `grade5`) VALUES
(109, 'Green House-S-IN', '2013-02-11 15:05:00', '48-0443', 'Alawwa', '158722', 85.80, 0.00, 0.00, 0.00, 5.70),
(109, 'Green House-S-IN', '2013-02-11 15:05:00', '48-0443', 'Alawwa', '158723', 88.00, 0.00, 0.00, 0.00, 9.20),
(109, 'Green House-S-IN', '2013-02-11 15:05:00', '48-0443', 'Alawwa', '158724', 83.00, 4.00, 0.00, 0.00, 15.30),
(109, 'Green House-S-IN', '2013-02-13 16:00:00', '48-0443', 'Alawwa', '158725', 84.00, 0.00, 0.00, 0.00, 16.80),
(109, 'Green House-S-IN', '2013-02-13 13:20:00', '48-0443', 'Alawwa', '158726', 70.30, 0.00, 0.00, 0.00, 13.30),
(109, 'Green House-S-IN', '2013-02-14 14:11:00', '43-4050', 'Alawwa', '158727', 82.90, 0.00, 0.00, 0.00, 17.70),
(109, 'Green House-S-IN', '2013-02-16 16:24:00', 'YP-4142', 'Alawwa', '158730', 222.50, 0.00, 0.00, 0.00, 64.50),
(100, '', '2013-02-24 06:55:00', '48-9093', 'Nawagiriyawa', '136934', 86.00, 40.00, 0.00, 0.00, 0.00),
(100, '', '2013-02-24 06:55:00', '48-9093', '10-Ela', '155607', 22.00, 23.00, 0.00, 0.00, 0.00),
(100, '', '2013-02-24 06:55:00', '48-9093', 'Gonagolla', '154000', 24.00, 14.00, 0.00, 0.00, 0.00),
(100, '', '2013-02-24 06:55:00', '48-9093', 'Namalthalawa', '155517', 6.00, 4.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-02-26 06:30:00', '68-7094', 'Nawagiriyawa', '136935', 123.50, 36.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-02-26 06:30:00', '68-7094', 'Gonagolla', '155619', 78.00, 23.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-02-26 06:30:00', '68-7094', '10-Ela', '155610', 118.50, 25.50, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-02-26 06:30:00', '68-7094', 'Namalthalawa', '155516', 58.00, 18.50, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-02-28 05:00:00', '48-9093', 'Nawagiriyawa', '136936', 192.00, 48.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-02-28 05:00:00', '48-9093', 'Namalthalawa', '155519', 66.00, 20.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-02-28 05:00:00', '48-9093', 'Gonagolla', '155620', 96.00, 34.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-02-28 05:00:00', '48-9093', '10-Ela', '155611', 109.00, 18.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', 'Yaya-12', '157403', 28.00, 5.00, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', '1-B yaya', '157453', 18.00, 4.00, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', 'New Town', '157202', 15.00, 16.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', 'Batukotuwa', '137785', 44.50, 12.00, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', 'Sansungama', '137188', 66.50, 41.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', 'South Ela', '157503', 114.50, 22.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', 'Yatiyalpathana', '157253', 40.70, 49.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', '1-B yaya', '157452', 17.00, 4.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', 'Sansungama', '137187', 19.00, 14.00, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', 'Yatiyalpathana', '157252', 22.00, 23.00, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', 'South Ela', '157502', 57.50, 21.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', 'Yaya-12', '157402', 28.00, 5.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', 'New Town', '157201', 7.50, 8.50, 0.00, 0.00, 0.00),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', 'Batukotuwa', '137784', 14.70, 4.50, 0.00, 0.00, 0.00),
(96, 'Bakamuna-S-IN', '2013-02-27 06:00:00', '68-7094', 'Ihakuluwewa', '156852', 166.80, 64.60, 0.00, 0.00, 0.00),
(96, 'Bakamuna-S-IN', '2013-02-27 06:00:00', '68-7094', 'Ambangaga', '156751', 17.80, 14.40, 0.00, 0.00, 0.00),
(96, 'Bakamuna-S-IN', '2013-02-27 06:00:00', '68-7094', 'Nikapitiya', '156954', 71.00, 46.10, 0.00, 0.00, 0.00),
(96, 'Bakamuna-S-IN', '2013-02-27 06:00:00', '68-7094', 'Diggalpitiya', '156903', 81.50, 100.00, 0.00, 0.00, 0.00),
(96, 'Bakamuna-S-IN', '2013-02-25 03:30:00', '48-9093', 'Diggalpitiya', '156902', 51.50, 21.50, 0.00, 0.00, 0.00),
(96, 'Bakamuna-S-IN', '2013-02-25 03:30:00', '48-9093', 'Nikapitiya', '156953', 23.00, 11.90, 0.00, 0.00, 0.00),
(96, 'Bakamuna-S-IN', '2013-02-25 03:30:00', '48-9093', 'Ihakuluwewa', '156851', 84.00, 45.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-03-04 07:05:00', '88-8888', 'Namalthalawa', '22222', 0.00, 20.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-03-04 07:05:00', '88-8888', 'Gonagolla', '33333', 0.00, 75.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-03-04 07:05:00', '88-8888', '10-Ela', '44444', 0.00, 220.00, 0.00, 0.00, 0.00),
(100, 'Ampara-S-IN', '2013-03-04 07:05:00', '88-8888', 'Nawagiriyawa', '55555', 0.00, 210.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `qa_center_fakes`
--

CREATE TABLE IF NOT EXISTS `qa_center_fakes` (
  `id` int(10) NOT NULL,
  `seasonId` int(4) NOT NULL,
  `project` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `vehicleNo` varchar(10) NOT NULL,
  `centerFakeId` mediumint(2) NOT NULL,
  `centerName` varchar(20) NOT NULL,
  `TMno` varchar(10) NOT NULL,
  PRIMARY KEY (`id`,`seasonId`,`date`,`vehicleNo`,`centerFakeId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_center_fakes`
--

INSERT INTO `qa_center_fakes` (`id`, `seasonId`, `project`, `date`, `vehicleNo`, `centerFakeId`, `centerName`, `TMno`) VALUES
(87, 10, 'Ampara', '2012-09-21 03:00:00', '22-2222', 0, '03-Ela', '78945'),
(87, 10, 'Ampara', '2012-09-21 03:00:00', '22-2222', 1, 'Pothana', '45689'),
(87, 10, 'Ampara', '2012-09-21 03:00:00', '22-2222', 2, '08-Ela', '12345'),
(87, 11, 'Ampara', '2012-12-11 00:00:00', '2323', 0, 'Himdurawa', '23'),
(94, 11, 'Kathnoruwa-M-IN', '2012-12-19 04:21:00', 'PS-1226', 0, 'aththanagalla', '149713'),
(94, 11, 'Kathnoruwa-M-IN', '2012-12-17 05:45:00', 'PS-1226', 0, 'aththanagalla', '149712'),
(106, 12, 'Ajith-L-EX', '2013-02-23 11:00:00', '223', 0, 'center1', '232'),
(86, 11, '', '2012-12-29 09:00:00', '2333', 0, 'center1', '232'),
(94, 11, 'Kathnoruwa-M-IN', '2012-10-15 05:00:00', 'PS-1226', 0, 'aththanagalla', '149711');

-- --------------------------------------------------------

--
-- Table structure for table `qa_confirmed_stocks`
--

CREATE TABLE IF NOT EXISTS `qa_confirmed_stocks` (
  `id` int(10) NOT NULL,
  `vehicleNo` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`,`vehicleNo`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_confirmed_stocks`
--

INSERT INTO `qa_confirmed_stocks` (`id`, `vehicleNo`, `date`) VALUES
(87, '22-2222', '2012-09-21 03:00:00'),
(87, '2323', '2012-12-11 00:00:00'),
(94, 'PS-1226', '2012-10-15 05:00:00'),
(94, 'PS-1226', '2012-12-17 05:45:00'),
(94, 'PS-1226', '2012-12-19 04:21:00'),
(95, '48-9093', '2013-02-25 03:30:00'),
(95, '48-9093', '2013-02-27 06:00:00'),
(96, '48-9093', '2013-02-25 03:30:00'),
(96, '68-7094', '2013-02-27 06:00:00'),
(100, '48-9093', '2013-02-28 05:00:00'),
(100, '68-7094', '2013-02-26 06:30:00'),
(100, '88-8888', '2013-03-04 07:05:00'),
(106, '223', '2013-02-23 11:00:00'),
(109, '43-4050', '2013-02-14 14:11:00'),
(109, '48-0443', '2013-02-11 15:05:00'),
(109, '48-0443', '2013-02-13 13:20:00'),
(109, '48-0443', '2013-02-13 16:00:00'),
(109, 'YP-4142', '2013-02-16 16:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `qa_crateQuantity`
--

CREATE TABLE IF NOT EXISTS `qa_crateQuantity` (
  `crateRange` varchar(20) NOT NULL,
  `numOfSample` decimal(6,0) NOT NULL,
  `maxQuantity` decimal(6,0) NOT NULL,
  PRIMARY KEY (`crateRange`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_crateQuantity`
--

INSERT INTO `qa_crateQuantity` (`crateRange`, `numOfSample`, `maxQuantity`) VALUES
('2-90', 5, 1),
('91-150', 8, 2),
('151-500', 13, 3);

-- --------------------------------------------------------

--
-- Table structure for table `qa_grade`
--

CREATE TABLE IF NOT EXISTS `qa_grade` (
  `cate_id` int(10) NOT NULL,
  `gradeId` int(20) NOT NULL AUTO_INCREMENT,
  `gradeCategory` varchar(100) NOT NULL,
  `fruitCount` varchar(20) NOT NULL,
  `diameter` varchar(20) NOT NULL,
  `sampleWeight` decimal(6,0) NOT NULL,
  PRIMARY KEY (`cate_id`,`gradeId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `qa_grade`
--

INSERT INTO `qa_grade` (`cate_id`, `gradeId`, `gradeCategory`, `fruitCount`, `diameter`, `sampleWeight`) VALUES
(1, 40, 'Medium', 'CRS', '< 45 mm', 5),
(1, 39, 'Medium', '5/20', '29-44 mm', 7),
(1, 38, 'Medium', '20/80', '17-29 mm', 2),
(2, 32, 'Large', '5/10(No.4)', '42-45 mm', 8),
(2, 31, 'Large', '10/15(No.3)', '30-42 mm', 5),
(3, 28, '20/80+No.03', '20/80', '17-29 mm', 2),
(3, 29, '20/80+No.03', '5/30Mix', '29-42 mm', 7),
(2, 35, 'Large', '15/25(No.2)', '24-30 mm', 5),
(3, 30, '20/80+No.03', 'CRS', '< 45 mm', 5),
(2, 36, 'Large', 'CRS', '< 45 mm', 5),
(4, 37, 'CRS', 'CRS', '< 45 mm', 5),
(5, 44, 'Small', '160/250', '11-14', 1),
(5, 45, 'Small', '90/150', '14-17', 1),
(5, 46, 'Small', '20/80', '17-29', 1),
(5, 47, 'Small', '5/20', '29-44', 2),
(5, 48, 'Small', 'CRS', 'CRS', 5),
(6, 59, '160/250+20/80', 'CRS', '< 45 mm', 5),
(6, 55, '160/250+20/80', '5/20', '29-44 mm', 7),
(6, 54, '160/250+20/80', '20/80', '17-29 mm', 2),
(7, 60, 'No.4-M', 'No.4-M', '39-42', 8),
(3, 61, '20/80+No.03', '90/150', '14.5-17', 1),
(11, 2, 'new CATT', '34', '344', 44),
(11, 1, 'new CATT', '333', '444', 33);

-- --------------------------------------------------------

--
-- Table structure for table `qa_gradeCategory`
--

CREATE TABLE IF NOT EXISTS `qa_gradeCategory` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `qa_gradeCategory`
--

INSERT INTO `qa_gradeCategory` (`id`, `name`) VALUES
(1, 'Medium'),
(2, 'Large'),
(3, '20/80+No.03'),
(4, 'CRS'),
(5, 'Small'),
(6, '160/250+20/80');

-- --------------------------------------------------------

--
-- Table structure for table `qa_gradeStock`
--

CREATE TABLE IF NOT EXISTS `qa_gradeStock` (
  `id` int(10) NOT NULL,
  `project` varchar(50) NOT NULL,
  `vehicleNo` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `gradeId` varchar(20) NOT NULL,
  `noOfCrates` varchar(20) NOT NULL,
  `notedWeight` decimal(10,2) NOT NULL,
  `trueWeight` decimal(10,2) NOT NULL,
  `averageFruitCount` decimal(6,0) NOT NULL,
  `fruitCount` int(5) NOT NULL,
  `sumOfSmallFruit` decimal(6,0) NOT NULL,
  `sumOfLargeFruit` decimal(6,0) NOT NULL,
  `sumOfFlyAttacked` decimal(6,0) NOT NULL,
  `sumOfPeeledOff` decimal(6,0) NOT NULL,
  `sumOfBoreAttacked` decimal(6,0) NOT NULL,
  `sumOfSandEmbedded` decimal(6,0) NOT NULL,
  `sumOfShrivelled` decimal(6,0) NOT NULL,
  `sumOfDeformed` decimal(6,0) NOT NULL,
  `sumOfVirusAttacked` decimal(6,0) NOT NULL,
  `sumOfMechanicalDamaged` decimal(6,0) NOT NULL,
  `sumOfYellowish` decimal(6,0) NOT NULL,
  `sumOfRustPatches` decimal(6,0) NOT NULL,
  `sumOf45` decimal(6,0) NOT NULL,
  `sumOfRotten` int(5) NOT NULL,
  `totalPerOfDefectGrade` decimal(10,2) NOT NULL,
  `totalPerOfDefect` decimal(10,2) NOT NULL,
  `reducedPerOfDefectGrade` decimal(10,2) NOT NULL,
  `reducedPerOfDefect` decimal(10,2) NOT NULL,
  `payableQuantity` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`,`vehicleNo`,`date`,`gradeId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_gradeStock`
--

INSERT INTO `qa_gradeStock` (`id`, `project`, `vehicleNo`, `date`, `gradeId`, `noOfCrates`, `notedWeight`, `trueWeight`, `averageFruitCount`, `fruitCount`, `sumOfSmallFruit`, `sumOfLargeFruit`, `sumOfFlyAttacked`, `sumOfPeeledOff`, `sumOfBoreAttacked`, `sumOfSandEmbedded`, `sumOfShrivelled`, `sumOfDeformed`, `sumOfVirusAttacked`, `sumOfMechanicalDamaged`, `sumOfYellowish`, `sumOfRustPatches`, `sumOf45`, `sumOfRotten`, `totalPerOfDefectGrade`, `totalPerOfDefect`, `reducedPerOfDefectGrade`, `reducedPerOfDefect`, `payableQuantity`) VALUES
(60, 'SystemB-mix-IN', '22-2222', '2012-08-19 00:00:00', '28', '/10', 332.00, 330.00, 27, 133, 0, 0, 1, 1, 5, 0, 0, 0, 4, 0, 0, 0, 0, 0, 0.00, 4.07, 0.00, 0.00, 330.00),
(87, 'Ampara', '22-2222', '2012-09-21 03:00:00', '31', '56', 1021.00, 1000.50, 31, 124, 0, 2, 0, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0, 9, 0.32, 0.48, 0.00, 1.45, 985.99),
(87, 'Ampara', '22-2222', '2012-09-21 03:00:00', '32', '15', 1338.00, 1303.00, 20, 78, 0, 0, 0, 5, 0, 2, 0, 1, 0, 1, 0, 0, 0, 9, 0.00, 1.41, 0.00, 1.41, 1284.63),
(87, 'Ampara', '22-2222', '2012-09-21 03:00:00', '35', '10', 928.00, 852.00, 36, 179, 0, 0, 1, 0, 1, 2, 0, 1, 4, 0, 0, 0, 1, 6, 0.00, 1.10, 0.00, 0.67, 846.29),
(87, 'Ampara', '22-2222', '2012-09-21 03:00:00', '36', '6', 547.00, 432.80, 29, 144, 0, 9, 1, 0, 0, 1, 0, 1, 0, 1, 1, 0, 1, 9, 1.24, 0.84, 0.00, 1.24, 427.43),
(87, 'Ampara', '2323', '2012-12-11 00:00:00', '31', '23', 232.00, 230.00, 124, 124, 2, 4, 0, 0, 0, 4, 0, 0, 4, 0, 0, 0, 0, 0, 0.97, 1.30, 0.00, 0.00, 230.00),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-12-19 04:21:00', '28', '12', 304.50, 244.50, 37, 186, 0, 2, 1, 0, 1, 9, 0, 12, 1, 0, 0, 1, 0, 24, 0.54, 6.75, 0.00, 6.49, 228.63),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-12-19 04:21:00', '29', '30', 61.00, 45.20, 10, 29, 0, 0, 0, 0, 0, 14, 0, 5, 0, 0, 4, 0, 0, 11, 0.00, 10.95, 0.00, 9.19, 41.05),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-12-19 04:21:00', '30', '4', 93.50, 65.20, 29, 116, 0, 0, 2, 0, 0, 20, 0, 0, 0, 0, 0, 0, 0, 45, 0.00, 3.79, 0.00, 7.76, 60.14),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-12-17 05:45:00', '28', '16', 369.50, 364.20, 29, 145, 11, 2, 0, 0, 0, 1, 0, 18, 0, 0, 0, 0, 0, 7, 4.48, 6.55, 0.00, 2.41, 355.42),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-12-17 05:45:00', '29', '48', 79.00, 78.40, 10, 41, 0, 0, 0, 0, 2, 1, 0, 10, 0, 0, 2, 0, 0, 15, 0.00, 5.35, 0.00, 5.36, 74.20),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-12-17 05:45:00', '30', '6', 118.00, 90.60, 33, 165, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 0, 0, 0, 37, 0.00, 0.73, 0.00, 4.48, 86.54),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-10-15 05:00:00', '28', '26', 547.00, 540.00, 27, 136, 0, 3, 0, 0, 0, 8, 0, 15, 2, 0, 6, 0, 0, 9, 1.11, 11.48, 0.00, 7.81, 497.83),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-10-15 05:00:00', '29', '6', 134.50, 134.50, 10, 48, 0, 4, 0, 0, 0, 17, 0, 15, 0, 0, 0, 0, 0, 5, 1.14, 9.15, 0.00, 3.58, 129.68),
(94, 'Kathnoruwa-M-IN', 'PS-1226', '2012-10-15 05:00:00', '30', '8', 181.00, 178.40, 35, 177, 0, 0, 0, 3, 1, 44, 0, 0, 0, 0, 0, 0, 0, 13, 0.00, 5.48, 0.00, 1.49, 175.74),
(86, '', '2333', '2012-12-29 09:00:00', '59', '34', 232.00, 214.00, 23, 23, 0, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 2.61, 2.61, 0.00, 0.00, 214.00),
(86, '', '2333', '2012-12-29 09:00:00', '55', '23', 232.00, 228.00, 23, 23, 2, 0, 0, 0, 2, 0, 2, 0, 0, 2, 0, 0, 0, 0, 1.24, 3.72, 0.00, 0.00, 228.00),
(86, '', '2333', '2012-12-29 09:00:00', '54', '23', 232.00, 230.00, 23, 23, 0, 2, 0, 0, 2, 0, 2, 0, 2, 0, 0, 2, 0, 0, 4.35, 17.40, 0.00, 10.40, 206.08),
(106, 'Ajith-L-EX', '223', '2013-02-23 11:00:00', '31', '23', 232.00, 230.00, 23, 23, 0, 0, 3, 0, 0, 3, 0, 0, 0, 3, 0, 0, 0, 0, 0.00, 7.83, 0.00, 0.83, 228.09);

-- --------------------------------------------------------

--
-- Table structure for table `qa_loggedUsers`
--

CREATE TABLE IF NOT EXISTS `qa_loggedUsers` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `userId` varchar(200) NOT NULL,
  `intime` datetime NOT NULL,
  `outtime` datetime NOT NULL,
  `flag` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`,`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `qa_loggedUsers`
--

INSERT INTO `qa_loggedUsers` (`id`, `userId`, `intime`, `outtime`, `flag`) VALUES
(13, 'keerthi', '0000-00-00 00:00:00', '2013-03-05 04:52:39', 0),
(11, 'kasun', '2013-05-19 09:45:26', '0000-00-00 00:00:00', 1),
(14, 'demo', '2012-12-10 08:05:58', '0000-00-00 00:00:00', 1),
(15, 'kumara', '0000-00-00 00:00:00', '2013-03-01 09:06:35', 0),
(16, 'dforz', '2013-01-09 06:26:03', '0000-00-00 00:00:00', 1),
(17, 'ananda', '0000-00-00 00:00:00', '2013-01-22 04:48:14', 0),
(18, 'nadeesha', '2013-03-01 08:56:05', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `qa_news`
--

CREATE TABLE IF NOT EXISTS `qa_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `showing` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `qa_news`
--

INSERT INTO `qa_news` (`id`, `title`, `text`, `showing`) VALUES
(11, 'mgsdfg', 'd<b>gdfgdgd</b><div><br></div><div><b>dfgdfgdgd</b></div>', 0),
(12, 'Maha 2012', '<b>Seeding Acreage</b> 900&nbsp;<div><b>Internal Acreage</b> 223</div><div><b>Small</b> 129&nbsp;</div><div><b>Mix</b> 7&nbsp;</div><div><b>Large</b> 87&nbsp;</div><div><b>External Acreage</b> No.3 236&nbsp;</div><div><b>Mahendraj Acreage</b> No.3 300&nbsp;</div><div><b>Expecting Average</b> Harvest 5090 mt&nbsp;</div><div><font class="Apple-style-span" color="#ffffff"><b>160/250</b> </font>117 mt <b><font class="Apple-style-span" color="#ffffff">90/150</font></b> 94 mt&nbsp;</div><div><font class="Apple-style-span" color="#ffffff">60/80</font> 293 mt<font class="Apple-style-span" color="#ffffff"> 5/30 </font>23 mt&nbsp;</div><div><font class="Apple-style-span" color="#ffffff">10/15</font> 3382 mt<font class="Apple-style-span" color="#ffffff"> 5/10</font> 353 mt&nbsp;</div><div><font class="Apple-style-span" color="#ffffff">CRS</font> 828 mt</div>', 0),
(10, 'Maha 2012', 'Seeding Acreage              900\n   Internal Acreage          223    \n       Small 129\n       Mix     7\n       Large  87\n   External Acreage  No.3    236\n   Mahendraj Acreage No.3    300\n\nExpecting Average Harvest  5090 mt\n       160/250    117 mt\n       90/150      94 mt\n       60/80      293 mt\n       5/30        23 mt\n       10/15     3382 mt\n       5/10       353 mt\n       CRS        828 mt\n\n\n', 0),
(9, 'New ', 'This is important', 0),
(13, 'Maha 2012', '<font class="Apple-style-span" size="1"><b>Seeding Acreage </b>900&nbsp;</font><div><font class="Apple-style-span" size="1"><b>Internal Acreage </b>223&nbsp;</font></div><div><font class="Apple-style-span" size="1"><b><font class="Apple-style-span" color="#990000">Small</font> </b>129 ;&nbsp;<font class="Apple-style-span" color="#990000"><b>Mix</b></font> 7 ;&nbsp;<font class="Apple-style-span" color="#660000"><b>Large</b></font> 87&nbsp;</font></div><div><font class="Apple-style-span" size="1"><b>External Acreage </b>No.3 236&nbsp;</font></div><div><font class="Apple-style-span" size="1">Mahendraj Acreage No.3 300&nbsp;</font></div><div><font class="Apple-style-span" size="1">Expecting Average Harvest 5090 mt&nbsp;</font></div><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><font class="Apple-style-span" size="1"><font class="Apple-style-span" color="#993300">160/250</font> 117 mt&nbsp;</font></div></blockquote><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><font class="Apple-style-span" size="1"><font class="Apple-style-span" color="#993300">90/150</font> 94 mt&nbsp;</font></div></blockquote><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><font class="Apple-style-span" size="1"><font class="Apple-style-span" color="#993300">60/80</font> 293 mt&nbsp;</font></div></blockquote><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><font class="Apple-style-span" size="1"><font class="Apple-style-span" color="#993300">5/30</font> 23 mt&nbsp;</font></div></blockquote><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><font class="Apple-style-span" size="1"><font class="Apple-style-span" color="#993300">10/15</font> 3382 mt&nbsp;</font></div></blockquote><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><font class="Apple-style-span" size="1"><font class="Apple-style-span" color="#993300">5/10</font> 353 mt&nbsp;</font></div></blockquote><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><font class="Apple-style-span" size="1"><font class="Apple-style-span" color="#993300">CRS</font> 828 mt</font></div></blockquote></blockquote>', 0),
(14, 'fghfghf', 'fghfhfhffgh', 0),
(15, 'cvhfghfg', '<b>Seeding Acreage 900&nbsp;</b><div><b>Internal Acreage 223</b>&nbsp;</div><blockquote class="webkit-indent-blockquote" style="margin: 0 0 0 40px; border: none; padding: 0px;"><div><font class="Apple-style-span" color="#bbbbbb">Small</font> 129 ,&nbsp;<font class="Apple-style-span" color="#bbbbbb">Mix</font> 7,&nbsp;<font class="Apple-style-span" color="#999999">Large</font> 87 ,</div></blockquote><div><b>External Acreage No.3 236&nbsp;</b></div><div><b>Mahendraj Acreage No.3 300&nbsp;</b></div><div><b><font class="Apple-style-span" color="#999999">Expecting Average Harvest 5090 mt&nbsp;</font></b></div><div>&nbsp; 1). 160/250 117 mt &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;2). 90/150 94 mt&nbsp;</div><div>&nbsp; 3).60/80 293 mt &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;4).5/30 23 mt&nbsp;</div><div>&nbsp; 5)10/15 3382 mt &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 6).5/10 353 mt&nbsp;</div><div>&nbsp; 7).CRS 828 mt</div>', 0),
(16, 'Maha 2012', '<p class="MsoNormal"><b><u><font size="3">Seeding Acreage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n900</font></u></b><o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp; <i>Internal\nAcreage&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;223&nbsp;</i>&nbsp;&nbsp; <o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Small 129</p><p class="MsoNormal">&nbsp; &nbsp; &nbsp; &nbsp;Mix&nbsp;&nbsp;&nbsp;&nbsp; 7</p><p class="MsoNormal"><o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Large&nbsp; 87<o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp; <i>External\nAcreage&nbsp; No.3&nbsp; &nbsp; &nbsp;&nbsp;236</i><o:p></o:p></p>\n\n<p class="MsoNormal"><i>&nbsp;&nbsp; Mahendraj Acreage\nNo.3&nbsp;&nbsp;&nbsp; 300</i><o:p></o:p></p>\n\n<p class="MsoNormal"><o:p>&nbsp;</o:p></p>\n\n<p class="MsoNormal"><u><font size="3"><b>Expecting Average Harvest&nbsp;\n5090 mt</b></font></u><o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 160/250&nbsp;&nbsp;&nbsp; 117 mt<o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 90/150&nbsp; &nbsp; &nbsp; &nbsp;94 mt<o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 60/80&nbsp; &nbsp; &nbsp; &nbsp;293 mt<o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5/30&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;23 mt<o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10/15&nbsp; &nbsp; &nbsp;3382 mt<o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 5/10&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;353 mt<o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CRS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 828 mt<o:p></o:p></p>', 0),
(17, 'Maha 2012', '<p class="MsoNormal"><font face="''Comic Sans MS''" size="2"><b><u>Seeding Acreage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n900</u></b></font><o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp; Internal\nAcreage&nbsp;223&nbsp; &nbsp;(Small 129,&nbsp;Mix&nbsp;7, Large&nbsp;87)</p><p class="MsoNormal"><o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp; External\nAcreage&nbsp; No.3 &nbsp;&nbsp;=236<o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp;&nbsp; Mahendraj Acreage\nNo.3 =300</p><p class="MsoNormal"><b><font face="''Comic Sans MS''"><font size="2" style="text-decoration: underline; ">Expecting Average Harvest&nbsp;\n5090 mt</font></font></b></p><p class="MsoNormal"><o:p></o:p></p>\n\n<p class="MsoNormal">&nbsp; 160/250&nbsp;=&nbsp;117 mt,90/150=&nbsp;94 mt,&nbsp;60/80=&nbsp;293 mt,&nbsp;5/30=23 mt,10/15=&nbsp;3382 mt&nbsp; &nbsp; &nbsp; &nbsp;5/10=&nbsp;353 mt,CRS=&nbsp;828 mt</p><p class="MsoNormal"><o:p></o:p></p>', 0),
(18, '', '<p class="MsoNormal"><font face="''Comic Sans MS''" size="2"><b><u>Seeding Acreage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;900</u></b></font><o:p></o:p></p><p class="MsoNormal">Internal Acreage&nbsp;223(Small 129,&nbsp;Mix&nbsp;7, Large&nbsp;87)</p><p class="MsoNormal">External Acreage&nbsp;&nbsp;No.3 &nbsp;&nbsp;=236</p><p class="MsoNormal">Mahendraj Acreage No.3 =300</p><p class="MsoNormal"><b><font face="''Comic Sans MS''"><font size="2" style="text-decoration: underline; ">Expecting Average Harvest&nbsp; 5090 mt</font></font></b></p><p class="MsoNormal"><o:p></o:p></p><p class="MsoNormal">160/250&nbsp;=&nbsp;117 mt, 90/150=&nbsp;94 mt,&nbsp;60/80=&nbsp;293 mt,&nbsp;5/30=23 mt,10/15=&nbsp;3382 mt&nbsp; &nbsp; &nbsp; &nbsp;5/10=&nbsp;353 mt,CRS=&nbsp;828 mt</p>', 0),
(19, 'Maha-2012', '<p class="MsoNormal"><font face="''Comic Sans MS''" size="2"><b><u>Seeding Acreage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;900</u></b></font><o:p></o:p></p><p class="MsoNormal">Internal Acreage &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; = 223</p><p class="MsoNormal">(Small 129,&nbsp;Mix&nbsp;7, Large&nbsp;87)</p><p class="MsoNormal">External Acreage&nbsp;&nbsp;No.3 &nbsp;&nbsp;=236</p><p class="MsoNormal">Mahendraj Acreage No.3 =300</p><p class="MsoNormal"><b><font face="''Comic Sans MS''"><font size="2" style="text-decoration: underline; ">Expecting Average Harvest&nbsp; 5090 mt</font></font></b></p><p class="MsoNormal"><o:p></o:p></p><p class="MsoNormal">160/250&nbsp;=&nbsp;117 mt, &nbsp; &nbsp;90/150=&nbsp;94 mt, &nbsp; &nbsp; &nbsp;60/80=&nbsp;293 mt,&nbsp;5/30=23 mt, 10/15=&nbsp;3382 mt, &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 5/10=&nbsp;353 mt,CRS=&nbsp;828 mt</p>', 0),
(20, 'Maha-2012', '<p class="MsoNormal"><font face="''Comic Sans MS''" size="2"><b><u>Seeding Acreage&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;900</u></b></font><o:p></o:p></p><p class="MsoNormal">Internal Acreage &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; = 223</p><p class="MsoNormal">(Small 129,&nbsp;Mix&nbsp;7, Large&nbsp;87)</p><p class="MsoNormal">External Acreage&nbsp;&nbsp;No.3 &nbsp;&nbsp;=236</p><p class="MsoNormal">Mahendraj Acreage No.3 =300</p><p class="MsoNormal"><b><font face="''Comic Sans MS''"><font size="2" style="text-decoration: underline; ">Expecting Average Harvest&nbsp; 5090 mt</font></font></b></p><p class="MsoNormal"><o:p></o:p></p><p class="MsoNormal">160/250&nbsp;=&nbsp;117 mt, &nbsp; &nbsp;90/150=&nbsp;94 mt, &nbsp; &nbsp; &nbsp;60/80=&nbsp;293 mt,&nbsp;5/30=23 mt, 10/15=&nbsp;3382 mt, 5/10=&nbsp;353 mt,CRS=&nbsp;828 mt</p>', 0),
(21, 'asdfghj', 'asdfghjkl', 1);

-- --------------------------------------------------------

--
-- Table structure for table `qa_sample`
--

CREATE TABLE IF NOT EXISTS `qa_sample` (
  `id` int(20) NOT NULL,
  `project` varchar(50) NOT NULL,
  `sampleId` int(10) NOT NULL,
  `vehicleNo` varchar(20) NOT NULL,
  `gradeId` varchar(20) NOT NULL,
  `centerId` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `fruitCount` int(4) NOT NULL,
  `smallFruit` int(6) NOT NULL,
  `largeFruit` int(6) NOT NULL,
  `flyAttacked` int(6) NOT NULL,
  `peeledOff` int(6) NOT NULL,
  `boreAttacked` int(6) NOT NULL,
  `sandEmbedded` int(6) NOT NULL,
  `shrivelled` int(6) NOT NULL,
  `deformed` int(6) NOT NULL,
  `virusAttacked` int(6) NOT NULL,
  `mechanicalDamaged` int(6) NOT NULL,
  `yellowish` int(6) NOT NULL,
  `rustPatches` int(6) NOT NULL,
  `fruits45` int(6) NOT NULL,
  `accepted` varchar(2) NOT NULL,
  `spoiled` int(6) NOT NULL,
  PRIMARY KEY (`id`,`sampleId`,`vehicleNo`,`gradeId`,`centerId`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_sample`
--

INSERT INTO `qa_sample` (`id`, `project`, `sampleId`, `vehicleNo`, `gradeId`, `centerId`, `date`, `fruitCount`, `smallFruit`, `largeFruit`, `flyAttacked`, `peeledOff`, `boreAttacked`, `sandEmbedded`, `shrivelled`, `deformed`, `virusAttacked`, `mechanicalDamaged`, `yellowish`, `rustPatches`, `fruits45`, `accepted`, `spoiled`) VALUES
(87, 'Ampara', 0, '22-2222', '31', '1', '2012-09-21 03:00:00', 45, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(87, 'Ampara', 1, '22-2222', '31', '2', '2012-09-21 03:00:00', 32, 0, 2, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'AC', 4),
(87, 'Ampara', 2, '22-2222', '31', '3', '2012-09-21 03:00:00', 23, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(87, 'Ampara', 3, '22-2222', '31', '4', '2012-09-21 03:00:00', 24, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 'AC', 5),
(87, 'Ampara', 0, '22-2222', '32', '1', '2012-09-21 03:00:00', 32, 0, 0, 0, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(87, 'Ampara', 1, '22-2222', '32', '2', '2012-09-21 03:00:00', 20, 0, 0, 0, 1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'AC', 4),
(87, 'Ampara', 2, '22-2222', '32', '3', '2012-09-21 03:00:00', 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'AC', 0),
(87, 'Ampara', 3, '22-2222', '32', '4', '2012-09-21 03:00:00', 14, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 'AC', 5),
(87, 'Ampara', 0, '22-2222', '35', '1', '2012-09-21 03:00:00', 30, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 1),
(87, 'Ampara', 1, '22-2222', '35', '2', '2012-09-21 03:00:00', 32, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 'AC', 0),
(87, 'Ampara', 2, '22-2222', '35', '3', '2012-09-21 03:00:00', 42, 0, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 'AC', 0),
(87, 'Ampara', 3, '22-2222', '35', '4', '2012-09-21 03:00:00', 50, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'AC', 2),
(87, 'Ampara', 4, '22-2222', '35', '5', '2012-09-21 03:00:00', 25, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 'AC', 3),
(87, 'Ampara', 0, '22-2222', '36', '1', '2012-09-21 03:00:00', 34, 0, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'AC', 0),
(87, 'Ampara', 1, '22-2222', '36', '2', '2012-09-21 03:00:00', 25, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(87, 'Ampara', 2, '22-2222', '36', '3', '2012-09-21 03:00:00', 32, 0, 4, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 'AC', 4),
(87, 'Ampara', 3, '22-2222', '36', '4', '2012-09-21 03:00:00', 26, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'AC', 0),
(87, 'Ampara', 4, '22-2222', '36', '5', '2012-09-21 03:00:00', 27, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 'AC', 5),
(87, 'Ampara', 0, '2323', '31', '2', '2012-12-11 00:00:00', 124, 2, 4, 0, 0, 0, 4, 0, 0, 4, 0, 0, 0, 0, 'AC', 0),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '28', '1', '2012-12-19 04:21:00', 36, 0, 0, 0, 0, 0, 3, 0, 3, 0, 0, 0, 1, 0, 'RE', 6),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '28', '1', '2012-12-19 04:21:00', 40, 0, 0, 1, 0, 0, 0, 0, 2, 1, 0, 0, 0, 0, 'AC', 4),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '28', '1', '2012-12-19 04:21:00', 33, 0, 1, 0, 0, 1, 2, 0, 2, 0, 0, 0, 0, 0, 'AC', 4),
(94, 'Kathnoruwa-M-IN', 3, 'PS-1226', '28', '1', '2012-12-19 04:21:00', 41, 0, 0, 0, 0, 0, 1, 0, 2, 0, 0, 0, 0, 0, 'AC', 6),
(94, 'Kathnoruwa-M-IN', 4, 'PS-1226', '28', '1', '2012-12-19 04:21:00', 36, 0, 1, 0, 0, 0, 3, 0, 3, 0, 0, 0, 0, 0, 'RE', 4),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '29', '1', '2012-12-19 04:21:00', 10, 0, 0, 0, 0, 0, 6, 0, 0, 0, 0, 1, 0, 0, 'RE', 1),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '29', '1', '2012-12-19 04:21:00', 9, 0, 0, 0, 0, 0, 3, 0, 3, 0, 0, 1, 0, 0, 'RE', 2),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '29', '1', '2012-12-19 04:21:00', 10, 0, 0, 0, 0, 0, 5, 0, 2, 0, 0, 2, 0, 0, 'RE', 8),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '30', '1', '2012-12-19 04:21:00', 26, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 10),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '30', '1', '2012-12-19 04:21:00', 28, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 8),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '30', '1', '2012-12-19 04:21:00', 29, 0, 0, 0, 0, 0, 9, 0, 0, 0, 0, 0, 0, 0, 'AC', 15),
(94, 'Kathnoruwa-M-IN', 3, 'PS-1226', '30', '1', '2012-12-19 04:21:00', 33, 0, 0, 0, 0, 0, 11, 0, 0, 0, 0, 0, 0, 0, 'RE', 12),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '28', '1', '2012-12-17 05:45:00', 32, 3, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 'AC', 5),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '28', '1', '2012-12-17 05:45:00', 33, 3, 0, 0, 0, 0, 0, 0, 5, 0, 0, 0, 0, 0, 'RE', 1),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '28', '1', '2012-12-17 05:45:00', 29, 3, 0, 0, 0, 0, 1, 0, 2, 0, 0, 0, 0, 0, 'AC', 0),
(94, 'Kathnoruwa-M-IN', 3, 'PS-1226', '28', '1', '2012-12-17 05:45:00', 26, 2, 2, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 'AC', 1),
(94, 'Kathnoruwa-M-IN', 4, 'PS-1226', '28', '1', '2012-12-17 05:45:00', 25, 0, 0, 0, 0, 0, 0, 0, 5, 0, 0, 0, 0, 0, 'RE', 0),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '29', '1', '2012-12-17 05:45:00', 14, 0, 0, 0, 0, 0, 0, 0, 4, 0, 0, 0, 0, 0, 'AC', 10),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '29', '1', '2012-12-17 05:45:00', 9, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 'AC', 2),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '29', '1', '2012-12-17 05:45:00', 8, 0, 0, 0, 0, 0, 1, 0, 2, 0, 0, 2, 0, 0, 'RE', 2),
(94, 'Kathnoruwa-M-IN', 3, 'PS-1226', '29', '1', '2012-12-17 05:45:00', 10, 0, 0, 0, 0, 2, 0, 0, 1, 0, 0, 0, 0, 0, 'AC', 1),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '30', '1', '2012-12-17 05:45:00', 31, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 12),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '30', '1', '2012-12-17 05:45:00', 34, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 'AC', 8),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '30', '1', '2012-12-17 05:45:00', 35, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'AC', 6),
(94, 'Kathnoruwa-M-IN', 3, 'PS-1226', '30', '1', '2012-12-17 05:45:00', 32, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 7),
(94, 'Kathnoruwa-M-IN', 4, 'PS-1226', '30', '1', '2012-12-17 05:45:00', 33, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'AC', 4),
(94, 'Kathnoruwa-M-IN', 4, 'PS-1226', '30', '1', '2012-10-15 05:00:00', 33, 0, 0, 0, 0, 0, 8, 0, 0, 0, 0, 0, 0, 0, 'AC', 2),
(94, 'Kathnoruwa-M-IN', 4, 'PS-1226', '29', '1', '2012-10-15 05:00:00', 11, 0, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 'AC', 0),
(94, 'Kathnoruwa-M-IN', 4, 'PS-1226', '28', '1', '2012-10-15 05:00:00', 28, 0, 0, 0, 0, 0, 1, 0, 3, 0, 0, 1, 0, 0, 'RE', 3),
(94, 'Kathnoruwa-M-IN', 3, 'PS-1226', '30', '1', '2012-10-15 05:00:00', 33, 0, 0, 0, 0, 0, 9, 0, 0, 0, 0, 0, 0, 0, 'AC', 1),
(94, 'Kathnoruwa-M-IN', 3, 'PS-1226', '29', '1', '2012-10-15 05:00:00', 12, 0, 2, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 'AC', 2),
(94, 'Kathnoruwa-M-IN', 3, 'PS-1226', '28', '1', '2012-10-15 05:00:00', 27, 0, 0, 0, 0, 0, 0, 0, 2, 0, 0, 0, 0, 0, 'AC', 2),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '30', '1', '2012-10-15 05:00:00', 38, 0, 0, 0, 2, 0, 10, 0, 0, 0, 0, 0, 0, 0, 'AC', 5),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '29', '1', '2012-10-15 05:00:00', 9, 0, 2, 0, 0, 0, 7, 0, 2, 0, 0, 0, 0, 0, 'RE', 0),
(94, 'Kathnoruwa-M-IN', 2, 'PS-1226', '28', '1', '2012-10-15 05:00:00', 25, 0, 2, 0, 0, 0, 2, 0, 4, 1, 0, 2, 0, 0, 'RE', 1),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '30', '1', '2012-10-15 05:00:00', 37, 0, 0, 0, 1, 0, 9, 0, 0, 0, 0, 0, 0, 0, 'AC', 2),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '29', '1', '2012-10-15 05:00:00', 8, 0, 0, 0, 0, 0, 8, 0, 5, 0, 0, 0, 0, 0, 'RE', 2),
(86, '', 0, '2333', '59', '1', '2012-12-29 09:00:00', 23, 0, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(86, '', 0, '2333', '55', '1', '2012-12-29 09:00:00', 23, 2, 0, 0, 0, 2, 0, 2, 0, 0, 2, 0, 0, 0, 'AC', 0),
(86, '', 0, '2333', '54', '1', '2012-12-29 09:00:00', 23, 0, 2, 0, 0, 2, 0, 2, 0, 2, 0, 0, 2, 0, 'RE', 0),
(94, 'Kathnoruwa-M-IN', 1, 'PS-1226', '28', '1', '2012-10-15 05:00:00', 30, 0, 0, 0, 0, 0, 2, 0, 3, 1, 0, 1, 0, 0, 'RE', 1),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '30', '1', '2012-10-15 05:00:00', 36, 0, 0, 0, 0, 1, 8, 0, 0, 0, 0, 0, 0, 0, 'AC', 3),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '29', '1', '2012-10-15 05:00:00', 8, 0, 0, 0, 0, 0, 2, 0, 2, 0, 0, 0, 0, 0, 'AC', 1),
(94, 'Kathnoruwa-M-IN', 0, 'PS-1226', '28', '1', '2012-10-15 05:00:00', 26, 0, 1, 0, 0, 0, 3, 0, 3, 0, 0, 2, 0, 0, 'RE', 2),
(106, 'Ajith-L-EX', 0, '223', '31', '1', '2013-02-23 11:00:00', 23, 0, 0, 3, 0, 0, 3, 0, 0, 0, 3, 0, 0, 0, 'RE', 0);

-- --------------------------------------------------------

--
-- Table structure for table `qa_seasons`
--

CREATE TABLE IF NOT EXISTS `qa_seasons` (
  `seasonId` int(3) NOT NULL AUTO_INCREMENT,
  `seasonName` varchar(100) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `flag` int(2) NOT NULL,
  PRIMARY KEY (`seasonId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `qa_seasons`
--

INSERT INTO `qa_seasons` (`seasonId`, `seasonName`, `startDate`, `endDate`, `remarks`, `flag`) VALUES
(9, 'Maha-2012', '2011-12-15', '2012-03-31', '', 0),
(10, 'Yala-2012', '2012-04-01', '2012-09-30', '', 0),
(11, 'Yala Off -2012', '2012-09-01', '2012-12-31', '', 0),
(12, 'Maha- 2013', '2013-01-01', '2013-03-31', '', 1),
(13, 'Yala-2013', '2013-04-01', '2013-09-30', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `qa_small_belongs`
--

CREATE TABLE IF NOT EXISTS `qa_small_belongs` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `project` varchar(50) NOT NULL,
  `vehicleNo` varchar(10) NOT NULL,
  `gradeName` varchar(11) NOT NULL,
  `DQ` decimal(8,2) NOT NULL,
  `AQ` decimal(8,2) NOT NULL,
  `11-14` decimal(8,2) NOT NULL,
  `14-17` decimal(8,2) NOT NULL,
  `17-29` decimal(8,2) NOT NULL,
  `29-44` decimal(8,2) NOT NULL,
  `CRS` decimal(8,2) NOT NULL,
  `reject` decimal(8,2) NOT NULL,
  `hiddenLoss` decimal(8,2) NOT NULL,
  `weightLoss` decimal(8,2) NOT NULL,
  `offGrade` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`,`date`,`vehicleNo`,`gradeName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_small_belongs`
--

INSERT INTO `qa_small_belongs` (`id`, `date`, `project`, `vehicleNo`, `gradeName`, `DQ`, `AQ`, `11-14`, `14-17`, `17-29`, `29-44`, `CRS`, `reject`, `hiddenLoss`, `weightLoss`, `offGrade`) VALUES
(109, '2013-02-11 15:05:00', 'Green House-S-IN', '48-0443', '11-14', 256.80, 231.00, 221.70, 0.00, 0.00, 0.00, 0.00, 9.30, 0.00, 25.80, 0.00),
(109, '2013-02-11 15:05:00', 'Green House-S-IN', '48-0443', '14-17', 4.00, 3.60, 0.00, 3.60, 0.00, 0.00, 0.00, 0.00, 0.00, 0.40, 0.00),
(109, '2013-02-11 15:05:00', 'Green House-S-IN', '48-0443', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-11 15:05:00', 'Green House-S-IN', '48-0443', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-11 15:05:00', 'Green House-S-IN', '48-0443', 'CRS', 30.20, 29.00, 0.00, 0.00, 0.00, 0.00, 28.97, 0.03, 0.00, 1.20, 0.00),
(109, '2013-02-13 16:00:00', 'Green House-S-IN', '48-0443', '11-14', 84.00, 81.00, 81.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 3.00, 0.00),
(109, '2013-02-13 16:00:00', 'Green House-S-IN', '48-0443', '14-17', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-13 16:00:00', 'Green House-S-IN', '48-0443', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-13 16:00:00', 'Green House-S-IN', '48-0443', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-13 16:00:00', 'Green House-S-IN', '48-0443', 'CRS', 16.80, 16.80, 0.00, 0.00, 0.00, 0.00, 16.80, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-13 13:20:00', 'Green House-S-IN', '48-0443', '11-14', 70.30, 66.20, 66.20, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4.10, 0.00),
(109, '2013-02-13 13:20:00', 'Green House-S-IN', '48-0443', '14-17', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-13 13:20:00', 'Green House-S-IN', '48-0443', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-13 13:20:00', 'Green House-S-IN', '48-0443', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-13 13:20:00', 'Green House-S-IN', '48-0443', 'CRS', 13.30, 13.30, 0.00, 0.00, 0.00, 0.00, 13.30, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-14 14:11:00', 'Green House-S-IN', '43-4050', '11-14', 82.90, 79.40, 79.40, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 3.50, 0.00),
(109, '2013-02-14 14:11:00', 'Green House-S-IN', '43-4050', '14-17', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-14 14:11:00', 'Green House-S-IN', '43-4050', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-14 14:11:00', 'Green House-S-IN', '43-4050', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-14 14:11:00', 'Green House-S-IN', '43-4050', 'CRS', 17.70, 17.10, 0.00, 0.00, 0.00, 0.00, 17.10, 0.00, 0.00, 0.60, 0.00),
(109, '2013-02-16 16:24:00', 'Green House-S-IN', 'YP-4142', 'CRS', 64.50, 62.80, 0.00, 0.00, 0.00, 0.00, 62.80, 0.00, 0.00, 1.70, 0.00),
(109, '2013-02-16 16:24:00', 'Green House-S-IN', 'YP-4142', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-16 16:24:00', 'Green House-S-IN', 'YP-4142', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-16 16:24:00', 'Green House-S-IN', 'YP-4142', '14-17', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(109, '2013-02-16 16:24:00', 'Green House-S-IN', 'YP-4142', '11-14', 222.50, 209.80, 209.80, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 12.70, 0.00),
(100, '2013-02-26 06:30:00', 'Ampara-S-IN', '68-7094', '11-14', 378.00, 373.50, 332.80, 38.90, 0.00, 0.00, 1.70, 0.00, 0.10, 4.50, 10.87),
(100, '2013-02-26 06:30:00', 'Ampara-S-IN', '68-7094', '14-17', 103.00, 103.00, 42.40, 53.00, 6.50, 0.00, 1.00, 0.00, 0.10, 0.00, 48.45),
(100, '2013-02-26 06:30:00', 'Ampara-S-IN', '68-7094', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-02-26 06:30:00', 'Ampara-S-IN', '68-7094', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-02-26 06:30:00', 'Ampara-S-IN', '68-7094', 'CRS', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-02-28 05:00:00', 'Ampara-S-IN', '48-9093', '11-14', 463.00, 453.10, 418.80, 31.20, 0.00, 0.00, 2.90, 0.00, 0.20, 9.90, 7.53),
(100, '2013-02-28 05:00:00', 'Ampara-S-IN', '48-9093', '14-17', 120.50, 119.50, 8.90, 93.70, 15.80, 0.00, 0.90, 0.00, 0.20, 1.00, 21.42),
(100, '2013-02-28 05:00:00', 'Ampara-S-IN', '48-9093', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-02-28 05:00:00', 'Ampara-S-IN', '48-9093', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-02-28 05:00:00', 'Ampara-S-IN', '48-9093', 'CRS', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(95, '2013-02-27 06:00:00', 'Medirigiriya-S-IN', '48-9093', '11-14', 327.20, 306.40, 265.50, 38.70, 0.00, 0.00, 2.00, 0.00, 0.20, 20.80, 13.28),
(95, '2013-02-27 06:00:00', 'Medirigiriya-S-IN', '48-9093', '14-17', 151.00, 132.20, 30.70, 80.60, 15.60, 0.00, 3.00, 2.00, 0.30, 18.80, 37.29),
(95, '2013-02-27 06:00:00', 'Medirigiriya-S-IN', '48-9093', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(95, '2013-02-27 06:00:00', 'Medirigiriya-S-IN', '48-9093', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(95, '2013-02-27 06:00:00', 'Medirigiriya-S-IN', '48-9093', 'CRS', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(95, '2013-02-25 03:30:00', 'Medirigiriya-S-IN', '48-9093', '11-14', 165.70, 155.00, 97.50, 51.00, 3.80, 0.00, 2.00, 0.00, 0.70, 10.70, 36.65),
(95, '2013-02-25 03:30:00', 'Medirigiriya-S-IN', '48-9093', '14-17', 81.50, 72.60, 10.40, 36.20, 23.00, 0.00, 2.60, 0.20, 0.20, 8.90, 49.59),
(95, '2013-02-25 03:30:00', 'Medirigiriya-S-IN', '48-9093', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(95, '2013-02-25 03:30:00', 'Medirigiriya-S-IN', '48-9093', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(95, '2013-02-25 03:30:00', 'Medirigiriya-S-IN', '48-9093', 'CRS', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(96, '2013-02-27 06:00:00', 'Bakamuna-S-IN', '68-7094', '11-14', 337.10, 326.80, 300.40, 24.20, 0.00, 0.00, 2.10, 0.00, 0.10, 10.30, 8.05),
(96, '2013-02-27 06:00:00', 'Bakamuna-S-IN', '68-7094', '14-17', 225.10, 218.50, 53.70, 153.70, 7.50, 0.00, 3.30, 0.00, 0.30, 6.60, 29.52),
(96, '2013-02-27 06:00:00', 'Bakamuna-S-IN', '68-7094', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(96, '2013-02-27 06:00:00', 'Bakamuna-S-IN', '68-7094', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(96, '2013-02-27 06:00:00', 'Bakamuna-S-IN', '68-7094', 'CRS', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(96, '2013-02-25 03:30:00', 'Bakamuna-S-IN', '48-9093', '11-14', 158.50, 146.50, 107.20, 35.20, 1.70, 0.00, 1.40, 0.90, 0.10, 12.00, 26.14),
(96, '2013-02-25 03:30:00', 'Bakamuna-S-IN', '48-9093', '14-17', 78.40, 75.00, 2.40, 34.20, 36.40, 0.00, 1.20, 0.70, 0.10, 3.40, 53.33),
(96, '2013-02-25 03:30:00', 'Bakamuna-S-IN', '48-9093', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(96, '2013-02-25 03:30:00', 'Bakamuna-S-IN', '48-9093', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(96, '2013-02-25 03:30:00', 'Bakamuna-S-IN', '48-9093', 'CRS', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-02-24 06:55:00', '', '48-9093', '11-14', 138.00, 138.00, 115.00, 21.90, 0.00, 0.00, 1.00, 0.00, 0.10, 0.00, 16.59),
(100, '2013-02-24 06:55:00', '', '48-9093', '14-17', 81.00, 79.30, 8.30, 61.40, 8.00, 0.00, 1.00, 0.40, 0.20, 1.70, 21.82),
(100, '2013-02-24 06:55:00', '', '48-9093', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-02-24 06:55:00', '', '48-9093', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-02-24 06:55:00', '', '48-9093', 'CRS', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-03-04 07:05:00', 'Ampara-S-IN', '88-8888', '11-14', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-03-04 07:05:00', 'Ampara-S-IN', '88-8888', '14-17', 525.00, 425.00, 101.00, 300.60, 12.20, 0.00, 8.90, 2.20, 0.10, 100.00, 28.73),
(100, '2013-03-04 07:05:00', 'Ampara-S-IN', '88-8888', '17-29', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-03-04 07:05:00', 'Ampara-S-IN', '88-8888', '29-44', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00),
(100, '2013-03-04 07:05:00', 'Ampara-S-IN', '88-8888', 'CRS', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `qa_small_crop`
--

CREATE TABLE IF NOT EXISTS `qa_small_crop` (
  `id` int(10) NOT NULL,
  `project` varchar(50) NOT NULL,
  `centers` text NOT NULL,
  `date` datetime NOT NULL,
  `batchNo` varchar(10) NOT NULL,
  `vehicleNo` varchar(10) NOT NULL,
  `itmNo` varchar(10) NOT NULL,
  `totalOffGrade` float(8,2) NOT NULL,
  `total_DQ` float(8,2) NOT NULL,
  `total_AQ` float(8,2) NOT NULL,
  `11-14Q` float(8,2) NOT NULL,
  `14-17Q` float(8,2) NOT NULL,
  `17-29Q` float(8,2) NOT NULL,
  `29-44Q` float(8,2) NOT NULL,
  `crs` float(8,2) NOT NULL,
  `rejected` float(8,2) NOT NULL,
  `hiddenLoss` float(8,2) NOT NULL,
  `weightLoss` float(8,2) NOT NULL,
  `transport-delivery` varchar(5) NOT NULL,
  `transport-cover` varchar(5) NOT NULL,
  `transport-smell` varchar(5) NOT NULL,
  `transport-otherThings` varchar(5) NOT NULL,
  `transport-labels` varchar(5) NOT NULL,
  `transport-QualityReport` varchar(5) NOT NULL,
  `noOfCrates` varchar(40) NOT NULL,
  `tmNumbers` varchar(300) NOT NULL,
  PRIMARY KEY (`id`,`date`,`vehicleNo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_small_crop`
--

INSERT INTO `qa_small_crop` (`id`, `project`, `centers`, `date`, `batchNo`, `vehicleNo`, `itmNo`, `totalOffGrade`, `total_DQ`, `total_AQ`, `11-14Q`, `14-17Q`, `17-29Q`, `29-44Q`, `crs`, `rejected`, `hiddenLoss`, `weightLoss`, `transport-delivery`, `transport-cover`, `transport-smell`, `transport-otherThings`, `transport-labels`, `transport-QualityReport`, `noOfCrates`, `tmNumbers`) VALUES
(109, 'Green House-S-IN', 'Alawwa,Alawwa,Alawwa,', '2013-02-11 15:05:00', '11232', '48-0443', '6666', 0.00, 291.00, 263.60, 221.70, 3.60, 0.00, 0.00, 28.97, 9.33, 0.00, 27.40, '0', '1', '0', '0', '1', '0', '15', '158722,158723,158724'),
(109, 'Green House-S-IN', 'Alawwa,', '2013-02-13 16:00:00', '11233', '48-0443', '88888', 0.00, 100.80, 97.80, 81.00, 0.00, 0.00, 0.00, 16.80, 0.00, 0.00, 3.00, '0', '1', '0', '0', '1', '0', '5', '158725'),
(109, 'Green House-S-IN', 'Alawwa,', '2013-02-13 13:20:00', '11233', '48-0443', '99999', 0.00, 83.60, 79.50, 66.20, 0.00, 0.00, 0.00, 13.30, 0.00, 0.00, 4.10, '1', '1', '0', '0', '1', '0', '6', '158726'),
(109, 'Green House-S-IN', 'Alawwa,', '2013-02-14 14:11:00', '11235', '43-4050', '1234', 0.00, 100.60, 96.50, 79.40, 0.00, 0.00, 0.00, 17.10, 0.00, 0.00, 4.10, '1', '1', '0', '0', '1', '0', '7', '158727'),
(109, 'Green House-S-IN', 'Alawwa,', '2013-02-16 16:24:00', '11236', 'YP-4142', '2393,2394', 0.00, 287.00, 272.60, 209.80, 0.00, 0.00, 0.00, 62.80, 0.00, 0.00, 14.40, '0', '1', '0', '0', '1', '0', '15', '158730'),
(100, '', 'Namalthalawa,Gonagolla,10-Ela,Nawagiriyawa,', '2013-02-24 06:55:00', '11244', '48-9093', '1606', 7.68, 219.00, 217.30, 123.30, 83.30, 8.00, 0.00, 2.00, 0.40, 0.30, 1.70, '1', '1', '0', '0', '0', '0', '/20', ''),
(100, 'Ampara-S-IN', 'Nawagiriyawa,Gonagolla,10-Ela,Namalthalawa,', '2013-02-26 06:30:00', '11248', '68-7094', '1607', 29.66, 481.00, 476.50, 375.20, 91.90, 6.50, 0.00, 2.70, 0.00, 0.20, 4.50, '1', '1', '0', '0', '1', '0', '/40', '136935,155619,155610,155516'),
(100, 'Ampara-S-IN', 'Nawagiriyawa,Namalthalawa,Gonagolla,10-Ela,', '2013-02-28 05:00:00', '11253', '48-9093', '1606', 14.48, 583.50, 572.60, 427.70, 124.90, 15.80, 0.00, 3.80, 0.00, 0.40, 10.90, '1', '1', '0', '0', '1', '0', '/48', '136936,155519,155620,155611'),
(95, 'Medirigiriya-S-IN', 'Yaya-12,1-B yaya,New Town,Batukotuwa,Sansungama,South Ela,Yatiyalpathana,', '2013-02-27 06:00:00', '11250', '48-9093', '1610', 25.29, 478.20, 438.60, 296.20, 119.30, 15.60, 0.00, 5.00, 2.00, 0.50, 39.60, '1', '1', '0', '0', '1', '0', '/44', '157403,157453,157202,137785,137188,157503,157253'),
(95, 'Medirigiriya-S-IN', '1-B yaya,Sansungama,Yatiyalpathana,South Ela,Yaya-12,New Town,Batukotuwa,', '2013-02-25 03:30:00', '11246', '48-9093', '1611', 43.12, 247.20, 227.60, 107.90, 87.20, 26.80, 0.00, 4.60, 0.20, 0.90, 19.60, '1', '1', '0', '0', '1', '0', '/23', '157452,137187,157252,157502,157402,157201,137784'),
(96, 'Bakamuna-S-IN', 'Ihakuluwewa,Ambangaga,Nikapitiya,Diggalpitiya,', '2013-02-27 06:00:00', '11251', '68-7094', '1611', 18.79, 562.20, 545.30, 354.10, 177.90, 7.50, 0.00, 5.40, 0.00, 0.40, 16.90, '1', '1', '0', '0', '1', '0', '/41', '156852,156751,156954,156903'),
(96, 'Bakamuna-S-IN', 'Diggalpitiya,Nikapitiya,Ihakuluwewa,', '2013-02-25 03:30:00', '11247', '48-9093', '1609', 39.74, 236.90, 221.50, 109.60, 69.40, 38.10, 0.00, 2.60, 1.60, 0.20, 15.40, '1', '1', '0', '0', '1', '0', '/18', '156902,156953,156851'),
(100, 'Ampara-S-IN', 'Namalthalawa,Gonagolla,10-Ela,Nawagiriyawa,', '2013-03-04 07:05:00', '22222', '88-8888', '2222', 28.73, 525.00, 425.00, 101.00, 300.60, 12.20, 0.00, 8.90, 2.20, 0.10, 100.00, '1', '1', '0', '0', '1', '1', '23', '22222,33333,44444,55555');

-- --------------------------------------------------------

--
-- Table structure for table `qa_small_cropSampleGrades`
--

CREATE TABLE IF NOT EXISTS `qa_small_cropSampleGrades` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `gradeName` varchar(20) NOT NULL,
  `project` varchar(50) NOT NULL,
  `vehicleNo` varchar(12) NOT NULL,
  `sampleId` int(3) NOT NULL,
  `sampleNo` int(3) NOT NULL,
  `mellonFlyAttacked` int(6) NOT NULL,
  `peeledOff` int(6) NOT NULL,
  `boreAttacked` int(6) NOT NULL,
  `shrivelled` int(6) NOT NULL,
  `mechanicalDamaged` int(6) NOT NULL,
  `yellowish` int(6) NOT NULL,
  `rustPatches` int(6) NOT NULL,
  `rotten` int(6) NOT NULL,
  `totalDefects` int(6) NOT NULL,
  PRIMARY KEY (`id`,`date`,`gradeName`,`vehicleNo`,`sampleId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_small_cropSampleGrades`
--

INSERT INTO `qa_small_cropSampleGrades` (`id`, `date`, `gradeName`, `project`, `vehicleNo`, `sampleId`, `sampleNo`, `mellonFlyAttacked`, `peeledOff`, `boreAttacked`, `shrivelled`, `mechanicalDamaged`, `yellowish`, `rustPatches`, `rotten`, `totalDefects`) VALUES
(109, '2013-02-11 15:05:00', '11-14', 'Green House-S-IN', '48-0443', 0, 1, 0, 0, 0, 3, 0, 1, 0, 5, 9),
(109, '2013-02-11 15:05:00', '11-14', 'Green House-S-IN', '48-0443', 1, 2, 0, 0, 0, 8, 0, 3, 0, 3, 14),
(109, '2013-02-11 15:05:00', '11-14', 'Green House-S-IN', '48-0443', 2, 3, 0, 0, 0, 9, 0, 0, 0, 0, 9),
(109, '2013-02-11 15:05:00', '11-14', 'Green House-S-IN', '48-0443', 3, 4, 0, 0, 0, 0, 0, 0, 0, 3, 3),
(109, '2013-02-11 15:05:00', '11-14', 'Green House-S-IN', '48-0443', 4, 5, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(109, '2013-02-13 16:00:00', '11-14', 'Green House-S-IN', '48-0443', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-13 16:00:00', '11-14', 'Green House-S-IN', '48-0443', 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(109, '2013-02-13 16:00:00', '11-14', 'Green House-S-IN', '48-0443', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-13 16:00:00', '11-14', 'Green House-S-IN', '48-0443', 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-13 16:00:00', '11-14', 'Green House-S-IN', '48-0443', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-13 13:20:00', '11-14', 'Green House-S-IN', '48-0443', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-13 13:20:00', '11-14', 'Green House-S-IN', '48-0443', 1, 2, 0, 0, 0, 0, 0, 0, 1, 0, 1),
(109, '2013-02-13 13:20:00', '11-14', 'Green House-S-IN', '48-0443', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-13 13:20:00', '11-14', 'Green House-S-IN', '48-0443', 3, 4, 0, 0, 0, 0, 0, 0, 2, 0, 2),
(109, '2013-02-13 13:20:00', '11-14', 'Green House-S-IN', '48-0443', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-14 14:11:00', '11-14', 'Green House-S-IN', '43-4050', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-14 14:11:00', '11-14', 'Green House-S-IN', '43-4050', 1, 2, 0, 0, 0, 1, 0, 0, 1, 0, 2),
(109, '2013-02-14 14:11:00', '11-14', 'Green House-S-IN', '43-4050', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-14 14:11:00', '11-14', 'Green House-S-IN', '43-4050', 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-14 14:11:00', '11-14', 'Green House-S-IN', '43-4050', 4, 5, 0, 0, 0, 0, 0, 0, 2, 0, 2),
(109, '2013-02-16 16:24:00', '11-14', 'Green House-S-IN', 'YP-4142', 3, 4, 0, 0, 0, 3, 0, 0, 0, 0, 3),
(109, '2013-02-16 16:24:00', '11-14', 'Green House-S-IN', 'YP-4142', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(109, '2013-02-16 16:24:00', '11-14', 'Green House-S-IN', 'YP-4142', 1, 2, 0, 0, 0, 3, 0, 0, 0, 0, 3),
(109, '2013-02-16 16:24:00', '11-14', 'Green House-S-IN', 'YP-4142', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(109, '2013-02-16 16:24:00', '11-14', 'Green House-S-IN', 'YP-4142', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-24 06:55:00', '14-17', '', '48-9093', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-24 06:55:00', '14-17', '', '48-9093', 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-24 06:55:00', '14-17', '', '48-9093', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-26 06:30:00', '11-14', 'Ampara-S-IN', '68-7094', 0, 1, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(100, '2013-02-26 06:30:00', '11-14', 'Ampara-S-IN', '68-7094', 1, 2, 0, 0, 0, 2, 0, 0, 0, 0, 2),
(100, '2013-02-26 06:30:00', '11-14', 'Ampara-S-IN', '68-7094', 2, 3, 0, 0, 0, 2, 0, 0, 0, 0, 2),
(100, '2013-02-26 06:30:00', '11-14', 'Ampara-S-IN', '68-7094', 3, 4, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(100, '2013-02-26 06:30:00', '11-14', 'Ampara-S-IN', '68-7094', 4, 5, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(100, '2013-02-26 06:30:00', '14-17', 'Ampara-S-IN', '68-7094', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-26 06:30:00', '14-17', 'Ampara-S-IN', '68-7094', 1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 1),
(100, '2013-02-26 06:30:00', '14-17', 'Ampara-S-IN', '68-7094', 2, 3, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(100, '2013-02-26 06:30:00', '14-17', 'Ampara-S-IN', '68-7094', 3, 4, 1, 0, 0, 1, 0, 0, 0, 0, 2),
(100, '2013-02-28 05:00:00', '11-14', 'Ampara-S-IN', '48-9093', 0, 1, 0, 0, 0, 2, 0, 0, 0, 0, 2),
(100, '2013-02-28 05:00:00', '11-14', 'Ampara-S-IN', '48-9093', 1, 2, 0, 0, 0, 4, 0, 0, 0, 0, 4),
(100, '2013-02-28 05:00:00', '11-14', 'Ampara-S-IN', '48-9093', 2, 3, 0, 0, 0, 2, 0, 0, 0, 0, 2),
(100, '2013-02-28 05:00:00', '11-14', 'Ampara-S-IN', '48-9093', 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-28 05:00:00', '11-14', 'Ampara-S-IN', '48-9093', 4, 5, 0, 0, 0, 1, 0, 0, 0, 1, 2),
(100, '2013-02-28 05:00:00', '14-17', 'Ampara-S-IN', '48-9093', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-28 05:00:00', '14-17', 'Ampara-S-IN', '48-9093', 1, 2, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(100, '2013-02-28 05:00:00', '14-17', 'Ampara-S-IN', '48-9093', 2, 3, 0, 0, 0, 6, 0, 0, 1, 0, 7),
(100, '2013-02-28 05:00:00', '14-17', 'Ampara-S-IN', '48-9093', 3, 4, 1, 0, 1, 0, 0, 0, 0, 0, 2),
(100, '2013-02-28 05:00:00', '14-17', 'Ampara-S-IN', '48-9093', 4, 5, 2, 0, 1, 2, 0, 0, 0, 0, 5),
(95, '2013-02-27 06:00:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-27 06:00:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 1, 2, 0, 0, 1, 0, 1, 0, 0, 0, 2),
(95, '2013-02-27 06:00:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-27 06:00:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 3, 4, 0, 0, 0, 0, 2, 0, 0, 0, 2),
(95, '2013-02-27 06:00:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 4, 5, 1, 0, 0, 0, 0, 0, 0, 0, 1),
(95, '2013-02-27 06:00:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-27 06:00:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 1, 2, 0, 0, 0, 0, 2, 0, 0, 0, 2),
(95, '2013-02-27 06:00:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-27 06:00:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 3, 4, 0, 0, 0, 0, 1, 0, 0, 0, 1),
(95, '2013-02-27 06:00:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-25 03:30:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-25 03:30:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-25 03:30:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-25 03:30:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-25 03:30:00', '11-14', 'Medirigiriya-S-IN', '48-9093', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-25 03:30:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 2),
(95, '2013-02-25 03:30:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-25 03:30:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(95, '2013-02-25 03:30:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 3, 4, 0, 0, 0, 0, 1, 0, 0, 0, 1),
(95, '2013-02-25 03:30:00', '14-17', 'Medirigiriya-S-IN', '48-9093', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-27 06:00:00', '11-14', 'Bakamuna-S-IN', '68-7094', 0, 1, 0, 1, 0, 0, 2, 0, 0, 0, 3),
(96, '2013-02-27 06:00:00', '11-14', 'Bakamuna-S-IN', '68-7094', 1, 2, 0, 0, 0, 0, 1, 0, 0, 0, 1),
(96, '2013-02-27 06:00:00', '11-14', 'Bakamuna-S-IN', '68-7094', 2, 3, 0, 0, 0, 0, 1, 0, 0, 0, 1),
(96, '2013-02-27 06:00:00', '11-14', 'Bakamuna-S-IN', '68-7094', 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-27 06:00:00', '11-14', 'Bakamuna-S-IN', '68-7094', 4, 5, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(96, '2013-02-27 06:00:00', '14-17', 'Bakamuna-S-IN', '68-7094', 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 2),
(96, '2013-02-27 06:00:00', '14-17', 'Bakamuna-S-IN', '68-7094', 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-27 06:00:00', '14-17', 'Bakamuna-S-IN', '68-7094', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-27 06:00:00', '14-17', 'Bakamuna-S-IN', '68-7094', 3, 4, 0, 0, 0, 0, 1, 0, 0, 0, 1),
(96, '2013-02-27 06:00:00', '14-17', 'Bakamuna-S-IN', '68-7094', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-25 03:30:00', '11-14', 'Bakamuna-S-IN', '48-9093', 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1),
(96, '2013-02-25 03:30:00', '11-14', 'Bakamuna-S-IN', '48-9093', 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-25 03:30:00', '11-14', 'Bakamuna-S-IN', '48-9093', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-25 03:30:00', '11-14', 'Bakamuna-S-IN', '48-9093', 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-25 03:30:00', '11-14', 'Bakamuna-S-IN', '48-9093', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-25 03:30:00', '14-17', 'Bakamuna-S-IN', '48-9093', 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 1),
(96, '2013-02-25 03:30:00', '14-17', 'Bakamuna-S-IN', '48-9093', 1, 2, 1, 0, 0, 0, 0, 0, 0, 0, 1),
(96, '2013-02-25 03:30:00', '14-17', 'Bakamuna-S-IN', '48-9093', 2, 3, 0, 0, 1, 0, 0, 0, 0, 0, 1),
(96, '2013-02-25 03:30:00', '14-17', 'Bakamuna-S-IN', '48-9093', 3, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(96, '2013-02-25 03:30:00', '14-17', 'Bakamuna-S-IN', '48-9093', 4, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-24 06:55:00', '11-14', '', '48-9093', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-24 06:55:00', '11-14', '', '48-9093', 1, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-24 06:55:00', '11-14', '', '48-9093', 2, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(100, '2013-02-24 06:55:00', '11-14', '', '48-9093', 3, 4, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(100, '2013-02-24 06:55:00', '11-14', '', '48-9093', 4, 5, 0, 1, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `qa_small_crsData`
--

CREATE TABLE IF NOT EXISTS `qa_small_crsData` (
  `id` int(10) NOT NULL,
  `project` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `vehicleNo` varchar(10) NOT NULL,
  `smallFruit` varchar(10) NOT NULL,
  `largeFruit` varchar(10) NOT NULL,
  `melonFlyAttack` varchar(10) NOT NULL,
  `peeledOff` varchar(10) NOT NULL,
  `boreAttacked` varchar(10) NOT NULL,
  `sandEmbedded` varchar(10) NOT NULL,
  `shrivelled` varchar(10) NOT NULL,
  `mechanicalDamaged` varchar(10) NOT NULL,
  `yellowish` varchar(10) NOT NULL,
  `RustPatches` varchar(10) NOT NULL,
  `accepted` varchar(5) NOT NULL,
  `spoiled` varchar(10) NOT NULL,
  PRIMARY KEY (`id`,`date`,`vehicleNo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_small_crsData`
--

INSERT INTO `qa_small_crsData` (`id`, `project`, `date`, `vehicleNo`, `smallFruit`, `largeFruit`, `melonFlyAttack`, `peeledOff`, `boreAttacked`, `sandEmbedded`, `shrivelled`, `mechanicalDamaged`, `yellowish`, `RustPatches`, `accepted`, `spoiled`) VALUES
(109, 'Green House-S-IN', '2013-02-11 15:05:00', '48-0443', '-', '-', '-', '-', '-', '-', '5-0.55', '-', '-', '-', '-', '1-0.11'),
(109, 'Green House-S-IN', '2013-02-13 16:00:00', '48-0443', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(109, 'Green House-S-IN', '2013-02-13 13:20:00', '48-0443', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(109, 'Green House-S-IN', '2013-02-14 14:11:00', '43-4050', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(109, 'Green House-S-IN', '2013-02-16 16:24:00', 'YP-4142', '-', '-', '3-0.12', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(100, '', '2013-02-24 06:55:00', '48-9093', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(100, 'Ampara-S-IN', '2013-02-26 06:30:00', '68-7094', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(100, 'Ampara-S-IN', '2013-02-28 05:00:00', '48-9093', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(96, 'Bakamuna-S-IN', '2013-02-27 06:00:00', '68-7094', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(96, 'Bakamuna-S-IN', '2013-02-25 03:30:00', '48-9093', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-'),
(100, 'Ampara-S-IN', '2013-03-04 07:05:00', '88-8888', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `qa_small_crsSampleData`
--

CREATE TABLE IF NOT EXISTS `qa_small_crsSampleData` (
  `id` int(10) NOT NULL,
  `project` varchar(80) NOT NULL,
  `date` datetime NOT NULL,
  `vehicleNo` varchar(10) NOT NULL,
  `sampleId` int(3) NOT NULL,
  `fruitCount` int(5) NOT NULL,
  `smallFruit` int(5) NOT NULL,
  `largeFruit` int(5) NOT NULL,
  `melonFlyAttacked` int(5) NOT NULL,
  `peeledOff` int(5) NOT NULL,
  `boreAttacked` int(5) NOT NULL,
  `sandEmbeded` int(5) NOT NULL,
  `shrivelled` int(5) NOT NULL,
  `mechanicalDamaged` int(5) NOT NULL,
  `yellowish` int(5) NOT NULL,
  `rustPatches` int(5) NOT NULL,
  `AC/RE` char(3) NOT NULL,
  `spoiled` int(5) NOT NULL,
  PRIMARY KEY (`id`,`date`,`vehicleNo`,`sampleId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_small_crsSampleData`
--

INSERT INTO `qa_small_crsSampleData` (`id`, `project`, `date`, `vehicleNo`, `sampleId`, `fruitCount`, `smallFruit`, `largeFruit`, `melonFlyAttacked`, `peeledOff`, `boreAttacked`, `sandEmbeded`, `shrivelled`, `mechanicalDamaged`, `yellowish`, `rustPatches`, `AC/RE`, `spoiled`) VALUES
(109, 'Green House-S-IN', '2013-02-11 15:05:00', '48-0443', 0, 61, 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 'AC', 1),
(109, 'Green House-S-IN', '2013-02-11 15:05:00', '48-0443', 1, 59, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-11 15:05:00', '48-0443', 2, 63, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-13 16:00:00', '48-0443', 0, 59, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-13 13:20:00', '48-0443', 0, 54, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-14 14:11:00', '43-4050', 0, 61, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-16 16:24:00', 'YP-4142', 4, 104, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-16 16:24:00', 'YP-4142', 3, 115, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-16 16:24:00', 'YP-4142', 2, 98, 0, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-16 16:24:00', 'YP-4142', 1, 109, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0),
(109, 'Green House-S-IN', '2013-02-16 16:24:00', 'YP-4142', 0, 95, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'AC', 0);

-- --------------------------------------------------------

--
-- Table structure for table `qa_small_subGrade`
--

CREATE TABLE IF NOT EXISTS `qa_small_subGrade` (
  `gradeName` varchar(8) NOT NULL,
  `definition` int(40) NOT NULL,
  PRIMARY KEY (`gradeName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_small_subGrade`
--

INSERT INTO `qa_small_subGrade` (`gradeName`, `definition`) VALUES
('11-14', 0),
('14-17', 0),
('17-29', 0),
('29-44', 0),
('crs', 0);

-- --------------------------------------------------------

--
-- Table structure for table `qa_station`
--

CREATE TABLE IF NOT EXISTS `qa_station` (
  `stationId` varchar(20) NOT NULL,
  `stationName` varchar(100) NOT NULL,
  `inchargePersonId` varchar(20) NOT NULL,
  PRIMARY KEY (`stationId`,`stationName`,`inchargePersonId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_station`
--

INSERT INTO `qa_station` (`stationId`, `stationName`, `inchargePersonId`) VALUES
('1', 'HJS', 'jeewantha'),
('1', 'HJS', 'kasun'),
('2', 'Alawwa', 'keerthi'),
('3', 'Padiyathalawa', 'amila');

-- --------------------------------------------------------

--
-- Table structure for table `qa_stock`
--

CREATE TABLE IF NOT EXISTS `qa_stock` (
  `id` int(5) NOT NULL,
  `areaId` varchar(50) NOT NULL,
  `quantity` decimal(8,2) NOT NULL,
  `vehicleNo` varchar(20) NOT NULL,
  `handovering` tinyint(1) NOT NULL,
  `lorryCovering` tinyint(1) NOT NULL,
  `badSmell` tinyint(1) NOT NULL,
  `otherGoods` tinyint(1) NOT NULL,
  `labelling` tinyint(1) NOT NULL,
  `qualityReports` tinyint(1) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`,`vehicleNo`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_stock`
--

INSERT INTO `qa_stock` (`id`, `areaId`, `quantity`, `vehicleNo`, `handovering`, `lorryCovering`, `badSmell`, `otherGoods`, `labelling`, `qualityReports`, `date`) VALUES
(60, 'SystemB-mix-IN', 1782.00, '22-2222', 1, 1, 0, 0, 1, 1, '2012-08-19 00:00:00'),
(87, 'Ampara', 3834.00, '22-2222', 1, 1, 0, 0, 1, 1, '2012-09-21 03:00:00'),
(87, 'Ampara', 232.00, '2323', 1, 1, 0, 0, 1, 1, '2012-12-11 00:00:00'),
(94, 'Kathnoruwa-M-IN', 459.00, 'PS-1226', 1, 1, 0, 0, 1, 0, '2012-12-19 04:21:00'),
(94, 'Kathnoruwa-M-IN', 566.50, 'PS-1226', 1, 1, 0, 0, 1, 1, '2012-12-17 05:45:00'),
(94, 'Kathnoruwa-M-IN', 862.50, 'PS-1226', 1, 1, 0, 0, 1, 1, '2012-10-15 05:00:00'),
(86, '', 696.00, '2333', 1, 1, 0, 0, 1, 1, '2012-12-29 09:00:00'),
(106, '', 232.00, '223', 1, 1, 0, 0, 1, 1, '2013-02-23 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `qa_stockImages`
--

CREATE TABLE IF NOT EXISTS `qa_stockImages` (
  `id` int(20) NOT NULL,
  `project` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `vehicleNo` varchar(10) NOT NULL,
  `image1` varchar(100) NOT NULL,
  `image2` varchar(100) NOT NULL,
  `image3` varchar(100) NOT NULL,
  `image_desc1` varchar(150) NOT NULL,
  `image_desc2` varchar(150) NOT NULL,
  `image_desc3` varchar(150) NOT NULL,
  PRIMARY KEY (`id`,`date`,`vehicleNo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_stockImages`
--

INSERT INTO `qa_stockImages` (`id`, `project`, `date`, `vehicleNo`, `image1`, `image2`, `image3`, `image_desc1`, `image_desc2`, `image_desc3`) VALUES
(87, 'Ampara', '2012-09-21 03:00:00', '22-2222', '', '', '', '', '', ''),
(87, 'Ampara', '2012-12-11 00:00:00', '2323', '', '', '', '', '', ''),
(94, 'Kathnoruwa-M-IN', '2012-12-19 04:21:00', 'PS-1226', '', '', '', '', '', ''),
(94, 'Kathnoruwa-M-IN', '2012-12-17 05:45:00', 'PS-1226', '', '', '', '', '', ''),
(94, 'Kathnoruwa-M-IN', '2012-10-15 05:00:00', 'PS-1226', '', '', '', '', '', ''),
(86, 'Mahiyanganaya', '2012-12-29 00:00:00', '2333', '', '', '', '', '', ''),
(106, 'Ajith-L-EX', '2013-02-23 11:00:00', '223', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `qa_stockImagesSmall`
--

CREATE TABLE IF NOT EXISTS `qa_stockImagesSmall` (
  `id` int(10) NOT NULL,
  `project` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `vehicleNo` varchar(10) NOT NULL,
  `image1` varchar(100) NOT NULL,
  `image2` varchar(100) NOT NULL,
  `image3` varchar(100) NOT NULL,
  `image_desc1` varchar(150) NOT NULL,
  `image_desc2` varchar(150) NOT NULL,
  `image_desc3` varchar(150) NOT NULL,
  PRIMARY KEY (`id`,`date`,`vehicleNo`),
  UNIQUE KEY `id` (`id`,`date`,`vehicleNo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_stockImagesSmall`
--

INSERT INTO `qa_stockImagesSmall` (`id`, `project`, `date`, `vehicleNo`, `image1`, `image2`, `image3`, `image_desc1`, `image_desc2`, `image_desc3`) VALUES
(109, 'Green House-S-IN', '2013-02-11 15:05:00', '48-0443', '', '', '', '', '', ''),
(109, 'Green House-S-IN', '2013-02-13 16:00:00', '48-0443', '', '', '', '', '', ''),
(109, 'Green House-S-IN', '2013-02-13 13:20:00', '48-0443', '', '', '', '', '', ''),
(109, 'Green House-S-IN', '2013-02-14 14:11:00', '43-4050', '', '', '', '', '', ''),
(109, 'Green House-S-IN', '2013-02-16 16:24:00', 'YP-4142', '', '', '', '', '', ''),
(100, 'Ampara-S-IN', '2013-02-26 06:30:00', '68-7094', '', '', '', '', '', ''),
(100, 'Ampara-S-IN', '2013-02-28 05:00:00', '48-9093', '', '', '', '', '', ''),
(95, 'Medirigiriya-S-IN', '2013-02-27 06:00:00', '48-9093', '', '', '', '', '', ''),
(95, 'Medirigiriya-S-IN', '2013-02-25 03:30:00', '48-9093', '', '', '', '', '', ''),
(96, 'Bakamuna-S-IN', '2013-02-27 06:00:00', '68-7094', '', '', '', '', '', ''),
(96, 'Bakamuna-S-IN', '2013-02-25 03:30:00', '48-9093', '', '', '', '', '', ''),
(100, 'Ampara-S-IN', '2013-03-04 07:05:00', '88-8888', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `qa_stockUpdates`
--

CREATE TABLE IF NOT EXISTS `qa_stockUpdates` (
  `vehicleNo` varchar(20) NOT NULL,
  `userId` varchar(20) NOT NULL,
  `stationId` varchar(20) NOT NULL,
  `date` datetime NOT NULL,
  `areaId` varchar(20) NOT NULL,
  PRIMARY KEY (`vehicleNo`,`userId`,`stationId`,`date`,`areaId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_stockUpdates`
--

INSERT INTO `qa_stockUpdates` (`vehicleNo`, `userId`, `stationId`, `date`, `areaId`) VALUES
('22-2222', 'kasun', '1', '2012-09-21 03:00:00', '87'),
('223', 'kasun', '1', '2013-02-23 11:00:00', '106'),
('2323', 'kasun', '1', '2012-12-11 00:00:00', '87'),
('2333', 'kasun', '1', '2012-12-29 09:00:00', '86'),
('PS-1226', 'kasun', '1', '2012-10-15 05:00:00', '94'),
('PS-1226', 'kasun', '1', '2012-12-17 05:45:00', '94'),
('PS-1226', 'kasun', '1', '2012-12-19 04:21:00', '94');

-- --------------------------------------------------------

--
-- Table structure for table `qa_stockUpdates_small`
--

CREATE TABLE IF NOT EXISTS `qa_stockUpdates_small` (
  `vehicleNo` varchar(10) NOT NULL,
  `userId` varchar(20) NOT NULL,
  `stationId` varchar(5) NOT NULL,
  `date` datetime NOT NULL,
  `areaId` varchar(20) NOT NULL,
  PRIMARY KEY (`vehicleNo`,`userId`,`stationId`,`date`,`areaId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_stockUpdates_small`
--

INSERT INTO `qa_stockUpdates_small` (`vehicleNo`, `userId`, `stationId`, `date`, `areaId`) VALUES
('43-4050', 'kasun', '1', '2013-02-14 14:11:00', '109'),
('48-0443', 'kasun', '1', '2013-02-11 15:05:00', '109'),
('48-0443', 'kasun', '1', '2013-02-13 13:20:00', '109'),
('48-0443', 'kasun', '1', '2013-02-13 16:00:00', '109'),
('48-9093', 'kasun', '1', '2013-02-24 06:55:00', '100'),
('48-9093', 'kasun', '1', '2013-02-25 03:30:00', '95'),
('48-9093', 'kasun', '1', '2013-02-25 03:30:00', '96'),
('48-9093', 'kasun', '1', '2013-02-27 06:00:00', '95'),
('48-9093', 'kasun', '1', '2013-02-28 05:00:00', '100'),
('68-7094', 'kasun', '1', '2013-02-26 06:30:00', '100'),
('68-7094', 'kasun', '1', '2013-02-27 06:00:00', '96'),
('88-8888', 'keerthi', '2', '2013-03-04 07:05:00', '100'),
('YP-4142', 'kasun', '1', '2013-02-16 16:24:00', '109');

-- --------------------------------------------------------

--
-- Table structure for table `qa_user`
--

CREATE TABLE IF NOT EXISTS `qa_user` (
  `userId` varchar(20) NOT NULL,
  `userType` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `areaId` varchar(20) NOT NULL,
  `position` varchar(150) NOT NULL,
  `mobileNo` varchar(20) NOT NULL,
  `avatar` varchar(50) NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userId` (`userId`),
  UNIQUE KEY `userId_2` (`userId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `qa_user`
--

INSERT INTO `qa_user` (`userId`, `userType`, `password`, `fname`, `lname`, `areaId`, `position`, `mobileNo`, `avatar`) VALUES
('kasun', 'SuperAdministrator', '7a7db99b90940efb17ca3c9346c42e71', 'Kasun', 'Rathnayake', 'HJS', 'Executive', '0777551176', 'kasun.jpg'),
('indunil', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Ajith', 'Indunil', 'System-B', 'In-Charge', '1234', 'avatar4.png'),
('rizvi', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Rizvi', 'Zaheed', 'Hayleys Agriculture ', 'Managing Director', '', 'Rizvi.bmp'),
('ananda', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Ananda', 'Pathirage', 'HJS/SF', 'Director', '0773295017', 'ananda.JPG'),
('gamini', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Gamini', 'Prathapasinghe', 'Sunfrost Limited', 'General Manager', '0773295011', 'Gamini.JPG'),
('anusha', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Anusha', 'Rajapakshe', 'HJS', 'Production-Manager', '0773950692', 'Anusha.JPG'),
('athula', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Athula', 'Jayarathne', 'Sunfrost Limited', 'Manager-Supply Chain', '0772440867', 'avatar4.png'),
('deepal', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Deepal', 'Pathirana', 'HJS', 'R&D-Assi.Manager ', '0773484465', 'avatar4.png'),
('santha', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Santha ', 'Yatiwala', 'HJS', 'Quality Assu.-Assi. Manager', '0773483728', 'avatar4.png'),
('nadeesha', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Nadeesha', 'Jayawardena', 'Sunfrost Limited', 'Executive', 'Supply chain', 'nadeesha.jpg'),
('kumara', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Kumara', 'perera', 'Sunfrost Limited', 'Executive-supply chain', '0772394042', 'avatar4.png'),
('keerthi', 'StationUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Keerthi', 'Marage', 'Alawwa', 'Factory Manager', 'Alawwa', 'keerthi.jpg'),
('amila', 'StationUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Amila', 'Baddegama', 'Padiyathalwa', 'Executive In charge', '0773521502', 'Amila.jpg'),
('jeewantha', 'StationUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Jeewantha', 'Chandrasena', 'HJS', 'Executive-Vat Yard', '0777551180', 'avatar4.png'),
('sarath', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'AMNG', 'Sarath', 'Mahiyanganaya', 'Executive', 'Mahiyanganaya', 'avatar4.png'),
('fernando-s', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'SV', 'Fernando-S', 'Welikanda', 'Executive', 'Supply Chain', 'avatar4.png'),
('rathnayaka', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'RMKB', 'Rathnayaka', 'Girithale', 'External Supplier', '0773771263', 'avatar4.png'),
('dissanayake', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'DMHB', 'Dissanayake', 'Puththalama', 'External supplier', '0773790945', 'avatar4.png'),
('wijewardhana', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Sarath', 'Wijewardhana', 'Galgamuwa', 'External Supplier', '', 'avatar4.png'),
('dayarathna', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'AK', 'Dayarathna', 'Godakawela', 'Godakawela', '', 'avatar4.png'),
('karunarathne', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Tennision', 'Karunarathne', 'Bakamuna', 'padawiya', '0777062273', 'avatar4.png'),
('pathiranage', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'LA', 'Pathiranage', 'Mahawa', 'Mahawa', '', 'avatar4.png'),
('kulathunga', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Dammika', 'Kulathunga', 'Bakamuna', 'External supplier', '', 'avatar4.png'),
('wikramasinghe', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'RA', 'Wikramasinghe', 'Kollonna', 'Kollonna', '', 'avatar4.png'),
('bandara', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'MC', 'Bandara', 'Badulla', 'Badulla', '', 'avatar4.png'),
('wikramanayaka', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'WPVW', 'Wickramanayaka', 'Nikaweratiya', 'External Supplier', '', 'avatar4.png'),
('ajith', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Ajith', 'Kumara', 'Galenbindunuwewa', 'External-supplier', '', 'avatar4.png'),
('senevirathne-L', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'WS', 'Senevirathne_W-L', 'Wahalkada', 'Assi.Manager', 'Supply Chain', 'avatar4.png'),
('athugala', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'MAS', 'Fabric Park', 'MAS_Fabric_Park', 'EX', 'EX', 'avatar4.png'),
('gunarathne', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Gunarathne', 'Banda', 'Green house', 'Manager', '0773295013', 'avatar4.png'),
('nalaka', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Green', 'House', 'Green_House-IN', 'Alawwa', '0773521503', 'avatar4.png'),
('attanayaka', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'G', 'Attanayaka', 'Ampara', 'Executive', '', 'avatar4.png'),
('senevirathne', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'WS', 'Senevirathne_M-S', 'Medirigiriya', 'Assi.Manager', '', 'avatar4.png'),
('fernando', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'SV', 'Fernando-L', 'Galenbindunuwewa', 'Executive', '', 'avatar4.png'),
('mannapperuma', 'Supplier', 'a3ec6dd8d538712a581e5b24726ce062', 'Mannapperuma', 'EX', 'Nikaweratiya', 'Externaler Supplier', '', 'mannapperuma.JPG'),
('mahendraj', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Mahend', 'raj', 'North & East', 'Deputy General Manager', '', 'avatar4.png'),
('cyril', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Cyril', 'Kariyawasam', 'Wellawa', 'External Supplier', '', 'avatar4.png'),
('indunil-s', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Ajith', 'Indunil-S', 'Mahiyanganaya', 'In-charge', '', 'avatar4.png'),
('senevirathne-p', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'WS', 'Senevirathne_P-L', 'Puttlam', 'Assi.manager', '', 'avatar4.png'),
('senevirathne-k', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'WS', 'Senevirathne_K-L', 'Kathnoruwa', '', '', 'avatar4.png'),
('asiri', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Asiri', 'Jayabodhi', 'HJS', 'Assi.Manager-Finance', '', 'avatar4.png'),
('nandana', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Nandana ', 'Udaya', 'Sunfrost-Biyagama', 'Accountant', '', 'avatar4.png'),
('ajitha', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Ajitha', 'Perera', 'Sunfrost', 'DGM-SF', '', 'avatar4.png'),
('lalith', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Lalith', 'Senanayake', 'HJS', 'GM-HJS', '', 'avatar4.png'),
('charmani', 'SuperUser', '81dc9bdb52d04dc20036dbd8313ed055', 'Charmani', 'Senanayake', 'HJS', 'secretary', '', 'avatar4.png'),
('fernandosv', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'SV', 'Fernando', 'Welikanda', 'Executive', '', 'avatar4.png'),
('senevirathnews', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'WS', 'Senevirathne', 'Wahalkada', 'Assi.manager', '', 'avatar4.png'),
('dforz', 'SuperAdministrator', '81dc9bdb52d04dc20036dbd8313ed055', 'Dforz', 'user', 'HJS', 'Executive', '', 'dforz.jpg'),
('demo', 'SuperAdministrator', '81dc9bdb52d04dc20036dbd8313ed055', 'Demo', 'User', 'CMB', 'User', 'xxx-xxxxxxxxx', 'avatar4.png'),
('Upul', 'Supplier', '81dc9bdb52d04dc20036dbd8313ed055', 'Upul', 'Siriniwasa', 'Rideegama', 'Supplier', '', 'avatar4.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

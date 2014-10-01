-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: 10.246.16.214:3306
-- Generation Time: Oct 01, 2014 at 11:15 AM
-- Server version: 5.5.39-MariaDB-1~wheezy
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dannberger_com`
--
CREATE DATABASE `dannberger_com` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `dannberger_com`;

-- --------------------------------------------------------

--
-- Table structure for table `Boat`
--

CREATE TABLE IF NOT EXISTS `Boat` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `boatTypeID` int(11) unsigned NOT NULL COMMENT 'Foreign key',
  `memberID` int(11) unsigned NOT NULL,
  `length` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `boatTypeID` (`boatTypeID`),
  KEY `memberID` (`memberID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Boat`
--

INSERT INTO `Boat` (`ID`, `boatTypeID`, `memberID`, `length`) VALUES
(1, 1, 1, 300),
(2, 3, 1, 200),
(3, 4, 3, 200),
(4, 2, 2, 100);

-- --------------------------------------------------------

--
-- Table structure for table `BoatType`
--

CREATE TABLE IF NOT EXISTS `BoatType` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `boatType` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `BoatType`
--

INSERT INTO `BoatType` (`ID`, `boatType`) VALUES
(1, 'Segelbåt'),
(2, 'Motorseglare'),
(3, 'Motorbåt'),
(4, 'Kajak/Kanot'),
(5, 'Övrigt');

-- --------------------------------------------------------

--
-- Table structure for table `Member`
--

CREATE TABLE IF NOT EXISTS `Member` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key',
  `firstName` varchar(30) NOT NULL,
  `lastName` varchar(30) NOT NULL,
  `identityNumber` varchar(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Member`
--

INSERT INTO `Member` (`ID`, `firstName`, `lastName`, `identityNumber`) VALUES
(1, 'Hasse', 'Aro', '123456-1111'),
(2, 'Lasse', 'Kronberg', '987654-2222'),
(3, 'Lena', 'Handén', '666666-6666');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Boat`
--
ALTER TABLE `Boat`
  ADD CONSTRAINT `Boat_ibfk_2` FOREIGN KEY (`boatTypeID`) REFERENCES `BoatType` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Boat_ibfk_1` FOREIGN KEY (`memberID`) REFERENCES `Member` (`ID`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

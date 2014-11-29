-- phpMyAdmin SQL Dump
-- version 4.0.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2013 at 12:54 PM
-- Server version: 5.5.33a-MariaDB-log
-- PHP Version: 5.5.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `oblig4`
--

-- --------------------------------------------------------

--
-- Table structure for table `Building`
--

CREATE TABLE IF NOT EXISTS `Building` (
  `buildingId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the building',
  `shortName` varchar(50) NOT NULL COMMENT 'A short version of the name',
  `longName` varchar(255) NOT NULL COMMENT 'Long version of the name',
  `streetId` int(11) NOT NULL COMMENT 'The ID of the street the building is on (referenced for zip code and state)',
  `streetNo` int(11) NOT NULL COMMENT 'The street number of the building',
  `description` text,
  PRIMARY KEY (`buildingId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `EquipmentInstallation`
--

CREATE TABLE IF NOT EXISTS `EquipmentInstallation` (
  `installationId` int(11) NOT NULL AUTO_INCREMENT,
  `buildingId` int(11) NOT NULL,
  `floorId` int(11) NOT NULL,
  `floorSectionNo` int(11) NOT NULL,
  `interiorSpaceId` int(11) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `installationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text NOT NULL,
  PRIMARY KEY (`installationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Floor`
--

CREATE TABLE IF NOT EXISTS `Floor` (
  `buildingId` int(11) NOT NULL COMMENT 'ID of the building this floor is in',
  `verticalOrder` int(11) NOT NULL COMMENT 'Number of the floor (from the bottom up)',
  `shortName` varchar(100) NOT NULL COMMENT 'Short name of this floor',
  `elevationM` int(11) NOT NULL COMMENT 'Meters above ground',
  `description` text NOT NULL COMMENT 'Description of the floor',
  PRIMARY KEY (`buildingId`,`verticalOrder`),
  KEY `floorNumber` (`verticalOrder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `FloorSection`
--

CREATE TABLE IF NOT EXISTS `FloorSection` (
  `buildingId` int(11) NOT NULL,
  `sectionNo` int(11) NOT NULL,
  `shortName` varchar(100) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `InteriorSpace`
--

CREATE TABLE IF NOT EXISTS `InteriorSpace` (
  `spaceId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the area',
  `floorId` int(11) NOT NULL COMMENT 'ID of the floor this space is found on',
  `floorSectionId` int(11) NOT NULL COMMENT 'ID of the section of the floor this space is at',
  `spaceCategoryCode` varchar(11) NOT NULL COMMENT 'Space Category Code',
  `shortName` varchar(50) NOT NULL COMMENT 'Short name for this area',
  `longName` varchar(100) NOT NULL DEFAULT '' COMMENT 'Long name for this area',
  `occupancy` tinyint(1) NOT NULL COMMENT 'Whether or not this space is occupied',
  `capacity` int(11) NOT NULL COMMENT 'How many people this space is meant for',
  `description` text NOT NULL COMMENT 'Description of this space',
  PRIMARY KEY (`spaceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `OwnershipModel`
--

CREATE TABLE IF NOT EXISTS `OwnershipModel` (
  `code` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ParkingGarage`
--

CREATE TABLE IF NOT EXISTS `ParkingGarage` (
  `garageId` int(11) NOT NULL,
  `buildingId` int(11) NOT NULL DEFAULT '0' COMMENT 'ID of the building the garage belongs to (or 0 if none)',
  `openToPublic` tinyint(1) NOT NULL,
  `noOfSpaces` int(11) NOT NULL,
  PRIMARY KEY (`garageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `PostalCode`
--

CREATE TABLE IF NOT EXISTS `PostalCode` (
  `postalCode` int(11) NOT NULL COMMENT 'Zip Code',
  `countryId` int(11) NOT NULL COMMENT 'Country (makes key together with zip code)',
  `state` varchar(100) NOT NULL COMMENT 'Name of the state for this zipcode in the country with countryId',
  PRIMARY KEY (`postalCode`,`countryId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `SpaceCategory`
--

CREATE TABLE IF NOT EXISTS `SpaceCategory` (
  `code` varchar(5) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Street`
--

CREATE TABLE IF NOT EXISTS `Street` (
  `streetId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the street',
  `streetName` varchar(255) NOT NULL COMMENT 'Name of the street',
  `postalCode` int(11) NOT NULL COMMENT 'Zip Code (foreign key for state)',
  `countryId` int(11) NOT NULL COMMENT 'ID of the country (foreign key for country name, and state)',
  PRIMARY KEY (`streetId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

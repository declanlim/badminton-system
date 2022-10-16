-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2018 at 09:45 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.1.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `badmintonsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `locationID` int(9) NOT NULL,
  `name` varchar(50) NOT NULL,
  `address` varchar(80) NOT NULL,
  `postcode` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`locationID`, `name`, `address`, `postcode`) VALUES
(14, 'Anchor Green Primary School Hall', '31 Anchorvale Drive', 544969),
(15, 'Anderson Secondary School Hall', '10 Ang Mo Kio Street 53', 569206),
(16, 'Ang Mo Kio Primary School Hall', '20 Ang Mo Kio Avenue 3	', 569920),
(17, 'Ang Mo Kio Secondary School Hall', '6 Ang Mo Kio Street 22', 569362),
(18, 'Beatty Secondary School Hall', '1 Toa Payoh North', 318990),
(19, 'Bedok North Secondary School Hall', '20 Jalan Damai', 419612),
(20, 'Bedok South Secondary School Hall', '1 Jalan Langgar Bedok', 468585),
(21, 'Bedok View Secondary School Hall', '6 Bedok South Avenue 3', 469293),
(22, 'Bendemeer Primary School Hall', '91 Bendemeer Road', 339948),
(23, 'Bendemeer Secondary School Hall', '1 St Wilfred Road', 327919),
(24, 'Bishan Sports Hall', '5 Bishan Street 14', 579783),
(25, 'Blangah Rise Primary School Hall', '91 Telok Blangah Heights', 109100),
(26, 'Boon Lay Secondary School Hall ', '11 Jurong West Street 65', 648354),
(27, 'Bowen Secondary School Hall', '2 Lorong Napiri', 547529),
(28, 'Bukit Gombak Sports Hall', '810 Bukit Batok West Avenue 5', 659088),
(29, 'Bukit Panjang Govt High School Hall ', '7 Choa Chu Kang Avenue 4', 689809),
(30, 'Bukit Panjang Primary School Hall', '109 Cashew Road', 679676),
(31, 'Bukit View Secondary School Hall', '16 Bukit Batok Street', 659633),
(32, 'Canberra Primary School Hall', '21 Admirality Drive', 757714),
(33, 'Canberra Secondary School Hall', '51 Sembawang Drive', 757699);

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `playerID` int(8) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(30) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `ability` int(1) NOT NULL,
  `organiser` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`playerID`, `firstName`, `lastName`, `username`, `password`, `dateOfBirth`, `ability`, `organiser`) VALUES
(1, 'declan', 'lim', 'declim', 'password', '4567-03-12', 3, 0),
(2, 'q', 'w', 'e', 'r', '0045-03-12', 3, 0),
(3, 'alsdkjl', 'lkjsdlkfj', 'sdflkj', 'sldkfj', '5678-04-23', 3, 0),
(4, 'var', 'g', 'vgop', 'password', '0000-00-00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `playertournament`
--

CREATE TABLE `playertournament` (
  `playerID` int(9) NOT NULL,
  `tournamentID` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
--

CREATE TABLE `tournament` (
  `tournamentID` int(9) NOT NULL,
  `organiserID` int(8) NOT NULL,
  `tournamentName` varchar(40) NOT NULL,
  `description` varchar(150) NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `locationID` int(9) NOT NULL,
  `numCourts` int(2) NOT NULL,
  `contactNum` int(8) NOT NULL,
  `minAge` int(2) NOT NULL,
  `maxAge` int(2) NOT NULL,
  `experience` int(1) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tournament`
--

INSERT INTO `tournament` (`tournamentID`, `organiserID`, `tournamentName`, `description`, `startDate`, `endDate`, `locationID`, `numCourts`, `contactNum`, `minAge`, `maxAge`, `experience`, `price`) VALUES
(5, 1, 'sdkfljsd', 'sldkfjlj', '2018-12-01', '2018-12-01', 18, 12, 12341234, 12, 13, 3, 0),
(6, 1, 'sdlfkj', 'slkdjflfk', '2018-11-29', '2018-11-30', 18, 12, 12389712, 12, 12, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tournamentdaytime`
--

CREATE TABLE `tournamentdaytime` (
  `tournamentID` int(9) NOT NULL,
  `day` date NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`locationID`),
  ADD UNIQUE KEY `postcode` (`postcode`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`playerID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `playertournament`
--
ALTER TABLE `playertournament`
  ADD PRIMARY KEY (`playerID`,`tournamentID`);

--
-- Indexes for table `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`tournamentID`);

--
-- Indexes for table `tournamentdaytime`
--
ALTER TABLE `tournamentdaytime`
  ADD PRIMARY KEY (`tournamentID`,`day`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `locationID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `playerID` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `tournamentID` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

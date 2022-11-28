-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2022 at 06:39 AM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `pwd` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `aid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`pwd`, `uname`, `name`, `aid`) VALUES
('admin', 'admin', 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `applied`
--

CREATE TABLE `applied` (
  `appid` int(11) NOT NULL,
  `jid` int(11) NOT NULL,
  `appdate` date NOT NULL DEFAULT current_timestamp(),
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `applied`
--

INSERT INTO `applied` (`appid`, `jid`, `appdate`, `sid`) VALUES
(2, 3, '2022-07-19', 1),
(5, 7, '2022-11-09', 1),
(6, 8, '2022-11-18', 1),
(7, 8, '2022-11-21', 4);

-- --------------------------------------------------------

--
-- Table structure for table `appstatus`
--

CREATE TABLE `appstatus` (
  `appid` int(11) NOT NULL,
  `appstatus` varchar(12) NOT NULL DEFAULT 'under review',
  `message` varchar(255) DEFAULT NULL,
  `up_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appstatus`
--

INSERT INTO `appstatus` (`appid`, `appstatus`, `message`, `up_date`) VALUES
(2, 'accepted', NULL, '2022-07-19 17:56:08'),
(5, 'rejected', '', '2022-11-09 23:01:51'),
(6, 'under review', NULL, '2022-11-18 12:20:22'),
(7, 'under review', NULL, '2022-11-21 09:33:08');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `pwd` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cname` varchar(255) NOT NULL,
  `loc` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `ceo` varchar(50) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`pwd`, `email`, `cname`, `loc`, `cid`, `ceo`, `website`, `status`) VALUES
('123', 'rahulreghu@gmail.com', 'Rahul', 'Kochi', 1, 'Shekhar', 'www.google.com', 'accepted'),
('111', 'rah@gmail.com', 'ass', 'sss', 2, NULL, NULL, 'rejected'),
('Adhi1234', 'thappzz2001@gmail.com', 'wipro', 'kalamassery', 3, NULL, NULL, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `courseid` int(11) NOT NULL,
  `coursename` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`courseid`, `coursename`) VALUES
(1, 'BCA'),
(2, 'BSC'),
(3, 'MCA'),
(4, 'MSC');

-- --------------------------------------------------------

--
-- Table structure for table `job`
--

CREATE TABLE `job` (
  `jid` int(11) NOT NULL,
  `jname` varchar(255) NOT NULL,
  `cid` int(11) NOT NULL,
  `jdesc` varchar(255) NOT NULL,
  `jdate` date NOT NULL DEFAULT current_timestamp(),
  `vacancy_no` int(11) NOT NULL,
  `salary` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job`
--

INSERT INTO `job` (`jid`, `jname`, `cid`, `jdesc`, `jdate`, `vacancy_no`, `salary`) VALUES
(3, 'backend developer', 1, 'ghsghshgh', '2022-07-10', 25, 500000),
(7, 'full stack developer', 1, 'jshdhlhsbvjhvdjhv\r\ndshaghdgahsgd', '2022-11-09', 10, 50000),
(8, 'hr', 1, 'good  human resource manager', '2022-11-18', 12, 5000000),
(9, 'accountant', 3, 'tally is a technology & innovation company,,delivery business software for smbs for over 3 decades.', '2022-11-21', 4, 200000);

-- --------------------------------------------------------

--
-- Table structure for table `offeredjobs`
--

CREATE TABLE `offeredjobs` (
  `oid` int(11) NOT NULL,
  `jid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `odate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `offeredjobs`
--

INSERT INTO `offeredjobs` (`oid`, `jid`, `sid`, `message`, `status`, `odate`) VALUES
(5, 3, 1, NULL, 'rejected', '2022-11-08'),
(7, 9, 4, 'hi, we would like to have you on our team.', 'accepted', '2022-11-21'),
(9, 8, 4, 'hi', 'pending', '2022-11-22');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `pwd` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `sid` int(11) NOT NULL,
  `stat` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`pwd`, `email`, `fname`, `lname`, `sid`, `stat`) VALUES
('123', 'rahulreghu@gmail.com', 'Rahul', 'Reghu', 1, 'accepted'),
('THappu123', 'thoufeela2000@gmail.com', 'thoufeela', 'vs', 4, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `student_academic`
--

CREATE TABLE `student_academic` (
  `coursename` varchar(20) NOT NULL,
  `percentage` int(11) NOT NULL,
  `semail` varchar(255) NOT NULL,
  `sname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_academic`
--

INSERT INTO `student_academic` (`coursename`, `percentage`, `semail`, `sname`) VALUES
('BSC CS', 72, 'rahulreghu@gmail.com', 'rahul reghu'),
('BSC CS', 80, 'thoufeela2000@gmail.com', 'Thoufeela VS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD UNIQUE KEY `uname` (`uname`);

--
-- Indexes for table `applied`
--
ALTER TABLE `applied`
  ADD PRIMARY KEY (`appid`),
  ADD KEY `jid` (`jid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `appstatus`
--
ALTER TABLE `appstatus`
  ADD UNIQUE KEY `appid` (`appid`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD UNIQUE KEY `coursename` (`coursename`);

--
-- Indexes for table `job`
--
ALTER TABLE `job`
  ADD UNIQUE KEY `jid` (`jid`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `offeredjobs`
--
ALTER TABLE `offeredjobs`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `jid` (`jid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`sid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `student_academic`
--
ALTER TABLE `student_academic`
  ADD UNIQUE KEY `semail` (`semail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applied`
--
ALTER TABLE `applied`
  MODIFY `appid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `job`
--
ALTER TABLE `job`
  MODIFY `jid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `offeredjobs`
--
ALTER TABLE `offeredjobs`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applied`
--
ALTER TABLE `applied`
  ADD CONSTRAINT `applied_ibfk_1` FOREIGN KEY (`jid`) REFERENCES `job` (`jid`),
  ADD CONSTRAINT `applied_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`);

--
-- Constraints for table `appstatus`
--
ALTER TABLE `appstatus`
  ADD CONSTRAINT `appstatus_ibfk_1` FOREIGN KEY (`appid`) REFERENCES `applied` (`appid`);

--
-- Constraints for table `job`
--
ALTER TABLE `job`
  ADD CONSTRAINT `job_ibfk_1` FOREIGN KEY (`cid`) REFERENCES `company` (`cid`);

--
-- Constraints for table `offeredjobs`
--
ALTER TABLE `offeredjobs`
  ADD CONSTRAINT `offeredjobs_ibfk_1` FOREIGN KEY (`jid`) REFERENCES `job` (`jid`),
  ADD CONSTRAINT `offeredjobs_ibfk_2` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`email`) REFERENCES `student_academic` (`semail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2018 at 03:20 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_srm_lib`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookmaster`
--

CREATE TABLE `bookmaster` (
  `book_id` int(11) NOT NULL,
  `book_title` text NOT NULL,
  `edition` text NOT NULL,
  `author1` text NOT NULL,
  `author2` text NOT NULL,
  `author3` text NOT NULL,
  `price` int(11) NOT NULL,
  `publisher` text NOT NULL,
  `book_type` text NOT NULL,
  `book_status` text NOT NULL,
  `branch` text NOT NULL,
  `loc` text NOT NULL,
  `library_name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookmaster`
--

INSERT INTO `bookmaster` (`book_id`, `book_title`, `edition`, `author1`, `author2`, `author3`, `price`, `publisher`, `book_type`, `book_status`, `branch`, `loc`, `library_name`) VALUES
(29, 'Thoousands', '1', 'Mr India', '', '', 899, 'Sejal Publishing co.', 'Romantic', '', '', '', ''),
(30, '1', 'SOme', 'None', '', '', 52, 'kljadns', 'typ1', '', '', '', ''),
(31, 'Story', '1', 'Someone', '', '', 499, 'hello', 'action', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `book_issue_details`
--

CREATE TABLE `book_issue_details` (
  `book_issue_id` int(11) NOT NULL,
  `book_issue_date` date NOT NULL,
  `book_due_date` date NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book_issue_details`
--

INSERT INTO `book_issue_details` (`book_issue_id`, `book_issue_date`, `book_due_date`, `book_id`, `user_id`) VALUES
(1, '2018-04-03', '2018-04-10', 29, 'RA1511008010392');

-- --------------------------------------------------------

--
-- Table structure for table `dept_master`
--

CREATE TABLE `dept_master` (
  `Dept_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `librarian`
--

CREATE TABLE `librarian` (
  `lib_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `librarian`
--

INSERT INTO `librarian` (`lib_id`, `name`, `username`, `password`) VALUES
(5, 'amay', 'amey', '123456'),
(6, 'Snehasish Dawn', 'dawn29', '39041997');

-- --------------------------------------------------------

--
-- Table structure for table `library_master`
--

CREATE TABLE `library_master` (
  `Library_Name` varchar(100) NOT NULL,
  `Location` varchar(100) NOT NULL,
  `Building` varchar(100) NOT NULL,
  `Mail_ID` varchar(100) NOT NULL,
  `Phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_master`
--

CREATE TABLE `user_master` (
  `User_ID` varchar(50) NOT NULL,
  `User_name` varchar(50) NOT NULL,
  `User_Desc` varchar(50) NOT NULL,
  `User_PWD` varchar(50) NOT NULL,
  `User_Type` varchar(50) NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Dept` varchar(100) NOT NULL,
  `Mail_ID` varchar(100) NOT NULL,
  `Phone` varchar(50) NOT NULL,
  `Library_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_master`
--

INSERT INTO `user_master` (`User_ID`, `User_name`, `User_Desc`, `User_PWD`, `User_Type`, `Gender`, `Dept`, `Mail_ID`, `Phone`, `Library_Name`) VALUES
('RA1511008010392', 'dawn29', 'Student', '29041997', 'Student', 'Male', 'IT', 'snehasishdawn29@gmail.com', '9884206629', 'SRM University'),
('RA1511008010398', 'Anu', 'Student', 'aws', 'Student', 'female', 'IT', 'ecmakm@gmail.com', '98842654995', 'SRM University');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookmaster`
--
ALTER TABLE `bookmaster`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `book_issue_details`
--
ALTER TABLE `book_issue_details`
  ADD PRIMARY KEY (`book_issue_id`),
  ADD KEY `book_id` (`book_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dept_master`
--
ALTER TABLE `dept_master`
  ADD PRIMARY KEY (`Dept_name`);

--
-- Indexes for table `librarian`
--
ALTER TABLE `librarian`
  ADD PRIMARY KEY (`lib_id`),
  ADD UNIQUE KEY `lib_id` (`lib_id`),
  ADD UNIQUE KEY `lib_id_2` (`lib_id`);

--
-- Indexes for table `user_master`
--
ALTER TABLE `user_master`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookmaster`
--
ALTER TABLE `bookmaster`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `book_issue_details`
--
ALTER TABLE `book_issue_details`
  MODIFY `book_issue_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `librarian`
--
ALTER TABLE `librarian`
  MODIFY `lib_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_issue_details`
--
ALTER TABLE `book_issue_details`
  ADD CONSTRAINT `book_issue_details_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `bookmaster` (`book_id`),
  ADD CONSTRAINT `book_issue_details_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user_master` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

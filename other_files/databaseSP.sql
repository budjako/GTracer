-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 18, 2014 at 02:53 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mydb`
--
CREATE DATABASE IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `mydb`;

-- --------------------------------------------------------

--
-- Table structure for table `ability`
--

CREATE TABLE IF NOT EXISTS `ability` (
  `studentno` varchar(10) NOT NULL,
  `ability` varchar(45) NOT NULL COMMENT 'can be skill, talent, expertise',
  PRIMARY KEY (`studentno`,`ability`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ability`
--

INSERT INTO `ability` (`studentno`, `ability`) VALUES
('2011-12345', 'cook'),
('2011-12345', 'singing'),
('2011-12346', 'work fast'),
('2011-12347', 'hide'),
('2011-29712', 'code'),
('2011-33788', 'design'),
('2011-36586', 'draw'),
('2011-36586', 'paint'),
('2011-53005', 'teach'),
('2012-12345', 'multitasking');

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

CREATE TABLE IF NOT EXISTS `association` (
  `studentno` varchar(10) NOT NULL,
  `assocname` varchar(60) NOT NULL COMMENT 'includes organizations/foundations, etc. ',
  PRIMARY KEY (`studentno`,`assocname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `association`
--

INSERT INTO `association` (`studentno`, `assocname`) VALUES
('2011-12346', 'UP Oroquieta'),
('2011-12347', 'Computer Science Society'),
('2011-36586', 'Painter''s Club');

-- --------------------------------------------------------

--
-- Table structure for table `award`
--

CREATE TABLE IF NOT EXISTS `award` (
  `awardno` int(11) NOT NULL AUTO_INCREMENT,
  `studentno` varchar(10) NOT NULL,
  `awardtitle` varchar(45) NOT NULL,
  `awardbody` varchar(60) DEFAULT NULL,
  `dategiven` date DEFAULT NULL,
  PRIMARY KEY (`awardno`,`studentno`),
  KEY `fk_award_graduate1` (`studentno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `award`
--

INSERT INTO `award` (`awardno`, `studentno`, `awardtitle`, `awardbody`, `dategiven`) VALUES
(1, '2011-36586', 'Cum Laude', 'University of the Philippines Los Banos', NULL),
(2, '2011-12345', 'Valedictorian', NULL, NULL),
(3, '2011-12347', 'Salutatorian', NULL, NULL),
(4, '2011-33788', 'Honor Roll', 'University of the Philippines Los Banos', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `companyno` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`companyno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`companyno`, `name`, `address`) VALUES
(1, 'University of the Philippines Los Banos', 'Los Banos, Laguna'),
(2, 'Azeus Systems Philippines', 'Ortigas'),
(3, 'PCCARD', 'Los Banos, Laguna'),
(4, 'Google', 'Menlo Park, California, United States');

-- --------------------------------------------------------

--
-- Table structure for table `educationalbg`
--

CREATE TABLE IF NOT EXISTS `educationalbg` (
  `bgno` int(11) NOT NULL AUTO_INCREMENT,
  `studentno` varchar(10) NOT NULL,
  `school` int(11) NOT NULL,
  `yearstart` year(4) NOT NULL,
  `yearend` year(4) NOT NULL,
  `level` varchar(45) NOT NULL COMMENT 'primary, secondary, tertiary',
  `graduate` tinyint(1) NOT NULL COMMENT '1 - graduated0 - not',
  `course` varchar(45) DEFAULT NULL COMMENT 'if level is tertiary, course is required\n\nthis includes masters and doctorate degrees',
  PRIMARY KEY (`bgno`,`studentno`),
  KEY `fk_educationalbg_school1_idx` (`school`),
  KEY `fk_educationalbg_graduate1` (`studentno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `educationalbg`
--

INSERT INTO `educationalbg` (`bgno`, `studentno`, `school`, `yearstart`, `yearend`, `level`, `graduate`, `course`) VALUES
(1, '2011-29712', 2, 2001, 2007, 'primary', 1, NULL),
(2, '2011-29712', 4, 2007, 2011, 'secondary', 1, NULL),
(3, '2011-29712', 1, 2011, 2015, 'tertiary', 1, 'BS Computer Science'),
(4, '2011-12345', 3, 2007, 2011, 'secondary', 1, NULL),
(5, '2011-12345', 1, 2011, 2015, 'tertiary', 1, 'BS Computer Science'),
(6, '2011-53005', 5, 2007, 2011, 'secondary', 1, NULL),
(7, '2011-33788', 5, 2007, 2011, 'secondary', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `graduate`
--

CREATE TABLE IF NOT EXISTS `graduate` (
  `student_no` varchar(10) NOT NULL,
  `password` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `midname` varchar(45) DEFAULT NULL,
  `sex` varchar(6) NOT NULL,
  `bdate` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `mobileno` varchar(11) NOT NULL,
  `telno` int(8) DEFAULT NULL,
  `field` varchar(45) NOT NULL,
  `major` varchar(45) DEFAULT NULL,
  `graduatedate` char(7) NOT NULL,
  PRIMARY KEY (`student_no`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `graduate`
--

INSERT INTO `graduate` (`student_no`, `password`, `firstname`, `lastname`, `midname`, `sex`, `bdate`, `email`, `mobileno`, `telno`, `field`, `major`, `graduatedate`) VALUES
('2011-12345', 'mpassword', 'Mia Camille', 'Milambiling', NULL, 'female', '1994-09-17', 'mcmilambiling@gmail.com', '09101234567', NULL, 'Computer Science', NULL, '2015-06'),
('2011-12346', 'opassword', 'Odyzza Faye', 'Daleon', NULL, 'female', '1994-09-17', 'ofdaleon@gmail.com', '09101234567', NULL, 'Computer Science', NULL, '2015-06'),
('2011-12347', 'cpassword', 'Cris Joseph', 'Ramos', NULL, 'male', '1994-09-17', 'cjramos@gmail.com', '09101234567', NULL, 'Computer Science', NULL, '2015-06'),
('2011-29712', 'dpassword', 'Dyanara', 'Dela Rosa', 'Madayag', 'female', '1994-07-29', 'budjako@gmail.com', '09105802984', NULL, 'Computer Science', NULL, '2015-06'),
('2011-33788', 'gpassword', 'Gwyn', 'Contreras', NULL, 'male', '1994-09-17', 'gbcontreras@gmail.com', '09101234567', NULL, 'Computer Science', NULL, '2015-06'),
('2011-36586', 'tpassword', 'Thea Abigail', 'Lomibao', 'Yu', 'female', '1994-09-17', 'taylomibao@gmail.com', '09101234567', NULL, 'Computer Science', NULL, '2015-06'),
('2011-53005', 'lpassword', 'Sheena Lara', 'De Guzman', NULL, 'female', '1994-11-14', 'sldeguzman@gmail.com', '09101234568', NULL, 'Computer Science', NULL, '2015-06'),
('2012-12345', 'spassword', 'Sabrina', 'Salvan', 'Maceda', 'female', '1995-02-23', 'smsalvan@up.edu.ph', '09169326193', NULL, 'Sociology', NULL, '2016-06');

-- --------------------------------------------------------

--
-- Table structure for table `grant`
--

CREATE TABLE IF NOT EXISTS `grant` (
  `studentno` varchar(10) NOT NULL,
  `grantname` varchar(45) NOT NULL,
  `grantor` varchar(45) DEFAULT NULL,
  `granttype` varchar(45) DEFAULT NULL COMMENT '* personal\n* government\n* others',
  `grantyear` year(4) DEFAULT NULL COMMENT 'year effective of grant',
  PRIMARY KEY (`studentno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `grant`
--

INSERT INTO `grant` (`studentno`, `grantname`, `grantor`, `granttype`, `grantyear`) VALUES
('2011-12346', 'STFAP', 'University of the Philippines Los Banos', NULL, 2011),
('2011-12347', 'STFAP', 'University of the Philippines Los Banos', NULL, 2013),
('2011-29712', 'CHED Half-Merit Scholarship', 'CHED', NULL, 2011),
('2011-12345', 'STFAP', 'University of the Philippines Los Banos', NULL, 2011), 
('2011-12346', 'STFAP', 'University of the Philippines Los Banos', NULL, 2012), 
('2011-12347', 'STFAP', 'University of the Philippines Los Banos', NULL, 2013), 
('2011-33788', 'STFAP', 'University of the Philippines Los Banos', NULL, 2014),
('2011-36586', 'STFAP', 'University of the Philippines Los Banos', NULL, 2011),
('2011-53005', 'STFAP', 'University of the Philippines Los Banos', NULL, 2012),
('2012-12345', 'STFAP', 'University of the Philippines Los Banos', NULL, 2014);

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `studentno` varchar(10) NOT NULL,
  `language` varchar(45) NOT NULL,
  PRIMARY KEY (`studentno`,`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`studentno`, `language`) VALUES
('2011-12345', 'Filipino'),
('2011-12346', 'Filipino'),
('2011-12347', 'Filipino'), 
('2011-29712', 'Filipino'), 
('2011-33788', 'Filipino'),
('2011-36586', 'Filipino'), 
('2011-53005', 'Filipino'),
('2012-12345', 'Filipino'),
('2011-12345', 'English');
('2011-12346', 'English');
('2011-12347', 'English'); 
('2011-29712', 'English');
('2011-33788', 'English');
('2011-36586', 'English'); 
('2011-53005', 'English');
('2012-12345', 'English');
('2011-29712', 'Bicol'),
('2011-53005', 'Batangueno'),
('2011-53005', 'Japanese'),
('2011-33788', 'Batangueno'),
('2012-12345', 'Korean'),
('2011-12345', 'Korean');

-- --------------------------------------------------------

--
-- Table structure for table `profexam`
--

CREATE TABLE IF NOT EXISTS `profexam` (
  `studentno` varchar(10) NOT NULL,
  `profexamname` varchar(60) NOT NULL,
  `datetaken` date NOT NULL,
  `rating` decimal(10,0) NOT NULL,
  PRIMARY KEY (`studentno`,`profexamname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `profexam`
--

INSERT INTO `profexam` (`studentno`, `profexamname`, `datetaken`, `rating`) VALUES
('2011-12345', 'Civil Service Exam', '2014-11-18', '90%'),
('2011-12346', 'Civil Service Exam', '2014-11-18', '90%'),
('2011-12347', 'Civil Service Exam', '2014-11-18', '100%'),
('2011-29712', 'Civil Service Exam', '2014-11-18', '80%'),
('2011-33788', 'Civil Service Exam', '2014-11-18', '85%'),
('2011-36586', 'Civil Service Exam', '2014-11-18', '98%'),
('2011-53005', 'Civil Service Exam', '2014-11-18', '95%'),
('2012-12345', 'Civil Service Exam', '2014-11-18', '99%');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `studentno` varchar(10) NOT NULL,
  `projecttitle` varchar(60) NOT NULL,
  `projectdesc` varchar(300) DEFAULT NULL,
  `datestart` date DEFAULT NULL,
  `dateend` date DEFAULT NULL,
  PRIMARY KEY (`studentno`,`projecttitle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE IF NOT EXISTS `publication` (
  `publicationno` int(11) NOT NULL AUTO_INCREMENT,
  `studentno` varchar(20) NOT NULL,
  `publicationtitle` varchar(60) NOT NULL,
  `publicationdate` date NOT NULL,
  `publicationdesc` varchar(300) DEFAULT NULL,
  `publicationbody` varchar(45) DEFAULT NULL,
  `publicationpeers` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`publicationno`,`studentno`),
  KEY `fk_publication_graduate1` (`studentno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`publicationno`, `studentno`, `publicationtitle`, `publicationdate`, `publicationdesc`, `publicationbody`, `publicationpeers`) VALUES
(1, '2011-29712', 'Scent and Taste Over the Internet', '2014-11-17', 'Transmitting taste and smell over the internet', 'University of the Philippines Los Banos', NULL),
(2, '2011-53005', 'Teleimmersion', '2014-11-03', 'Technology that makes topographically separated individuals interact in a single simulated environment.', NULL, NULL),
(3, '2011-36586', 'Computer Addiction', '2014-11-10', 'Dependency in computers', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `schoolno` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`schoolno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`schoolno`, `name`, `address`) VALUES
(1, 'University of the Philippines Los Banos', 'Los Banos, Laguna'),
(2, 'Naga City Central School I', 'Penafrancia Avenue, Naga City'),
(3, 'Kung Saan Mang School', NULL),
(4, 'Camarines Sur National High School', 'Penafrancia Avenue, Naga City'),
(5, 'Santa Theresa College', 'Kap. Ponso St. Bauan Batangas'),
(6, 'Good Tree International School', 'Bagtas Road, Brgy. Bagtas, Tansa Cavite');

-- --------------------------------------------------------

--
-- Table structure for table `update`
--

CREATE TABLE IF NOT EXISTS `update` (
  `studentno` varchar(10) NOT NULL,
  `updateindex` int(11) DEFAULT NULL,
  `body` varchar(255) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `author` varchar(140) DEFAULT NULL,
  PRIMARY KEY (`studentno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `work`
--

CREATE TABLE IF NOT EXISTS `work` (
  `workid` int(11) NOT NULL AUTO_INCREMENT,
  `studentno` varchar(10) NOT NULL,
  `companyno` int(11) NOT NULL,
  `position` varchar(45) NOT NULL,
  `salary` int(11) DEFAULT NULL,
  `supervisor` tinyint(1) DEFAULT NULL,
  `companytype` tinyint(1) NOT NULL COMMENT 'private-0 (including self-employed)\ngovernment-1',
  `employmentstatus` varchar(45) DEFAULT NULL COMMENT 'values check box on UI :)\nregular or permanent, temporary, casual, contractual, self-employed',
  PRIMARY KEY (`workid`,`studentno`),
  KEY `fk_work_graduate_idx` (`studentno`),
  KEY `fk_company_companyno_idx` (`companyno`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `work`
--

INSERT INTO `work` (`workid`, `studentno`, `companyno`, `position`, `salary`, `supervisor`, `companytype`, `employmentstatus`) VALUES
(1, '2011-29712', 1, 'Software Developer', 30000, NULL, 1, NULL),
(2, '2011-53005', 1, 'Psychologist', 25000, NULL, 1, NULL),
(3, '2011-36586', 1, 'Instructor', 15000, NULL, 1, NULL),
(4, '2011-12347', 1, 'Software Developer', 30000, NULL, 1, NULL),
(5, '2011-12346', 1, 'Engineer', 30000, NULL, 1, NULL),
(6, '2011-12345', 2, 'Mental Health Advisor', 50000, 1, 2, 'permanent'),
(7, '2012-12345', 4, 'Mental Health Advisor', 100000, 1, 2, 'permanent');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ability`
--
ALTER TABLE `ability`
  ADD CONSTRAINT `fk_ability_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `association`
--
ALTER TABLE `association`
  ADD CONSTRAINT `fk_association_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `award`
--
ALTER TABLE `award`
  ADD CONSTRAINT `fk_award_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `educationalbg`
--
ALTER TABLE `educationalbg`
  ADD CONSTRAINT `fk_educationalbg_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_educationalbg_school1` FOREIGN KEY (`school`) REFERENCES `school` (`schoolno`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `grant`
--
ALTER TABLE `grant`
  ADD CONSTRAINT `fk_grant_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `language`
--
ALTER TABLE `language`
  ADD CONSTRAINT `fk_language_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `profexam`
--
ALTER TABLE `profexam`
  ADD CONSTRAINT `fk_profexam_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `fk_project_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `publication`
--
ALTER TABLE `publication`
  ADD CONSTRAINT `fk_publication_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `update`
--
ALTER TABLE `update`
  ADD CONSTRAINT `fk_update_graduate1` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `work`
--
ALTER TABLE `work`
  ADD CONSTRAINT `fk_company_companyno` FOREIGN KEY (`companyno`) REFERENCES `company` (`companyno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_work_graduate` FOREIGN KEY (`studentno`) REFERENCES `graduate` (`student_no`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

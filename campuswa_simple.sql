-- phpMyAdmin SQL Dump
-- version 3.3.10.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 24, 2011 at 03:57 PM
-- Server version: 5.1.52
-- PHP Version: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `campuswa_simple`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `starttime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `creator` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_creator` (`creator`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `event`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `authentication` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `password`, `authentication`) VALUES
(2, 'yulin', 'yulin.chen.uw@gmail.com', '9065692614e384983f9d9380175d351de12826c6', ''),
(26, 'Sisun Lee', 'sisun1030@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'approved'),
(27, 'Sisun Lee', 'sisun1030@gmail.com', 'da39a3ee5e6b4b0d3255bfef95601890afd80709', 'approved');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_creator` FOREIGN KEY (`creator`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

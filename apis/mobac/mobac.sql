-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 16, 2016 at 01:19 PM
-- Server version: 5.5.44-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE Database mobac;

USE mobac;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mobac`
--

-- --------------------------------------------------------

--
-- Table structure for table `call_details`
--

CREATE TABLE IF NOT EXISTS `call_details` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(14) NOT NULL,
  `second_party` varchar(20) NOT NULL,
  `call_duration` time NOT NULL,
  `time` datetime NOT NULL,
  `type` enum('Incoming','Outgoing','Missed') DEFAULT NULL,
  `status` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(14) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `number` varchar(160) NOT NULL,
  `email` varchar(160) NOT NULL,
  `time` datetime NOT NULL,
  `type` enum('Inbox','Sent') NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(14) NOT NULL,
  `from_to` varchar(20) NOT NULL,
  `message_text` varchar(160) NOT NULL,
  `time` datetime NOT NULL,
  `type` enum('Inbox','Sent') NOT NULL,
  `status` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
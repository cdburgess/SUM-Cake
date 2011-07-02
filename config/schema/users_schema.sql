-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2011 at 06:57 PM
-- Server version: 5.1.44
-- PHP Version: 5.2.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `sum-cake`
--

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` char(36) NOT NULL,
  `name` varchar(60) NOT NULL,
  `role` enum('Admin','User','Manager','Guest') NOT NULL,
  `copied_from` enum('Admin','User','Manager','Guest') DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `role` (`role`),
  KEY `copied_from` (`copied_from`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c5b18b3-1774-41ad-b46d-3007e4ca782d', '*', 'Admin', NULL, '2010-08-05 14:01:55', '2010-08-05 14:21:32');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c5e4476-8260-4c6e-a790-45cde4ca782d', 'Users:login', 'User', NULL, '2010-08-07 23:45:26', '2010-08-07 23:45:26');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c67450e-5ea8-415b-8c0b-119de4ca782d', 'Users:reset_password', 'User', NULL, '2010-08-14 19:38:22', '2010-08-14 19:38:22');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c674516-0b8c-4dc4-b5bc-119de4ca782d', 'Users:password_request', 'User', NULL, '2010-08-14 19:38:30', '2010-08-14 19:38:30');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c674521-7120-4458-9fb0-119de4ca782d', 'Users:register', 'User', NULL, '2010-08-14 19:38:41', '2010-08-14 19:38:41');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c67452c-715c-4b73-968f-119de4ca782d', 'Users:index', 'User', NULL, '2010-08-14 19:38:52', '2010-08-14 19:38:52');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c674534-e200-4b6b-843f-119de4ca782d', 'Users:view', 'User', NULL, '2010-08-14 19:39:00', '2010-08-14 19:39:00');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c67453b-684c-4530-b5b8-119de4ca782d', 'Users:edit', 'User', NULL, '2010-08-14 19:39:07', '2010-08-14 19:39:07');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c6751af-d284-4449-8f8b-12f8e4ca782d', 'Users:change_password', 'User', NULL, '2010-08-14 20:32:15', '2010-08-14 20:32:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(36) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `role` enum('Admin','User','Manager','Guest') NOT NULL DEFAULT 'User',
  `active` enum('1','0') NOT NULL DEFAULT '0',
  `disabled` enum('1','0') NOT NULL DEFAULT '0',
  `password_requested` char(36) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`email_address`),
  KEY `disabled` (`disabled`),
  KEY `active` (`active`),
  KEY `password_requested` (`password_requested`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES('4c5b1927-5e14-4379-95d1-3009e4ca782d', 'admin@example.com', '5cca727f3f7ee0c868a1980cdf9252415fd7a1d1', 'Admin', 'User', 'Admin', '1', '0', '0', '2010-08-05 14:03:51', '2011-07-02 09:46:42');
INSERT INTO `users` VALUES('4dfec325-c338-49e5-983c-43a8e4ca782d', 'user@example.com', '5cca727f3f7ee0c868a1980cdf9252415fd7a1d1', 'Example', 'User', 'User', '1', '0', '0', '2011-06-19 21:48:53', '2011-07-02 09:43:53');

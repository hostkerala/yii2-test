-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2015 at 05:49 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yii2-final-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Web Development'),
(2, 'Android Development');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userId` int(11) DEFAULT NULL,
  `topicId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_topic1_idx` (`topicId`),
  KEY `fk_comments_user1_idx` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `createdAt`, `updatedAt`, `userId`, `topicId`) VALUES
(16, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', '2015-04-22 05:08:11', '2015-04-22 10:08:11', 32, 27),
(17, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum', '2015-04-22 05:18:13', '2015-04-22 10:18:13', 31, 27),
(19, 'Test Comment', '2015-04-24 01:13:57', '2015-04-24 06:13:57', 31, 32),
(20, 'Test comment', '2015-04-24 01:14:11', '2015-04-24 06:14:11', 31, 32),
(25, 'dsfdsfsdfsdfsdf', '2015-04-24 05:31:19', '2015-04-24 10:31:19', 31, 32),
(26, 'tttttttttttttttttttt', '2015-04-24 05:31:25', '2015-04-24 10:31:25', 31, 32);

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param` varchar(128) NOT NULL,
  `value` varchar(255) NOT NULL,
  `default_value` varchar(255) NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_iso_2` varchar(2) NOT NULL,
  `country_iso_3` varchar(3) NOT NULL,
  `country_name_en` varchar(64) NOT NULL,
  `country_name_ru` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_iso_2`, `country_iso_3`, `country_name_en`, `country_name_ru`) VALUES
(11, 'in', 'in', 'INDIA', 'INDIA-RU'),
(12, 'gr', 'gr', 'GERMANY', 'GERMANY-RU');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1428928768),
('m140209_132017_init', 1428928775),
('m140403_174025_create_account_table', 1428928776),
('m140504_113157_update_tables', 1428928782),
('m140504_130429_create_token_table', 1428928783),
('m140830_171933_fix_ip_field', 1428928784),
('m140830_172703_change_account_table_name', 1428928784),
('m141222_110026_update_ip_field', 1428928784);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` text,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_UNIQUE` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `status`) VALUES
(1, 'Test', NULL, 'Test', 1),
(2, 'About the website', NULL, '<p><strong>This is the website&#39;s about page. This page contains the information regarding the company history, management and the projects.</strong></p>\r\n', 1);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(32) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_topic_category`
--

CREATE TABLE IF NOT EXISTS `rel_topic_category` (
  `categories_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`categories_id`,`topic_id`),
  KEY `fk_categories_has_topic_topic1_idx` (`topic_id`),
  KEY `fk_categories_has_topic_categories1_idx` (`categories_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rel_topic_skills`
--

CREATE TABLE IF NOT EXISTS `rel_topic_skills` (
  `skill_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`skill_id`,`topic_id`),
  KEY `fk_skill_has_topic_topic1_idx` (`topic_id`),
  KEY `fk_skill_has_topic_skill1_idx` (`skill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_topic_skills`
--

INSERT INTO `rel_topic_skills` (`skill_id`, `topic_id`) VALUES
(109, 27),
(111, 27),
(113, 27),
(109, 28),
(112, 28),
(109, 29),
(110, 29),
(109, 30),
(111, 30),
(109, 31),
(110, 31),
(111, 31),
(109, 32),
(110, 32);

-- --------------------------------------------------------

--
-- Table structure for table `rel_user_skills`
--

CREATE TABLE IF NOT EXISTS `rel_user_skills` (
  `skill_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`skill_id`,`user_id`),
  KEY `fk_skill_has_user_user1_idx` (`user_id`),
  KEY `fk_skill_has_user_skill1_idx` (`skill_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- Dumping data for table `rel_user_skills`
--

INSERT INTO `rel_user_skills` (`skill_id`, `user_id`) VALUES
(116, 31);

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE IF NOT EXISTS `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `counter` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=117 ;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`id`, `name`, `counter`) VALUES
(109, 'yii2', 6),
(110, 'php', 3),
(111, 'mysql', 3),
(112, 'bootstrap', 2),
(113, 'jquery', 1),
(114, 'dsfdsfs', 0),
(115, 'dsfdsf', 0),
(116, 'te', 0);

-- --------------------------------------------------------

--
-- Table structure for table `social_account`
--

CREATE TABLE IF NOT EXISTS `social_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `provider` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_unique` (`provider`,`client_id`),
  KEY `fk_user_account` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state_code` varchar(64) COLLATE utf8_danish_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_name_en` varchar(64) COLLATE utf8_danish_ci NOT NULL,
  `state_name_ru` varchar(64) COLLATE utf8_danish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_states_countries1_idx` (`country_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_danish_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state_code`, `country_id`, `state_name_en`, `state_name_ru`) VALUES
(12, 'KE', 11, 'Kerala', 'Kerala-RU'),
(13, 'MH', 11, 'Maharashtra', 'Maharashtra-RU'),
(14, 'GRS1', 12, 'GRState1', 'GRState1-Ru'),
(15, 'GRS2', 12, 'GRState2', 'GRState2-RU');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE IF NOT EXISTS `token` (
  `user_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `created_at` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  UNIQUE KEY `token_unique` (`user_id`,`code`,`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`user_id`, `code`, `created_at`, `type`) VALUES
(17, '4JC2HZyW4XYiTraPoowo_QYLsSllIQjg', 1429180916, 1),
(17, 'DkNOVMayTxifbncLAo4cthlaEw-y_xbk', 1429180267, 1),
(17, 'fIg61gYUyqJwv3Qldww_QEYnnsVt9Bo8', 1428991340, 0),
(17, 'k09Pw4vzR1ZIkT8i1wn-Z4pVTM1LWJ7l', 1429180579, 1),
(19, '6GukXiTWaM5UIqC1s1uBpEh9pz171rnl', 1429190044, 0),
(21, 'tulI_9TYp8QcjvvcmhT7OoWUPpdqBaP4', 1429190630, 0),
(30, 'LLH7g7WkFk0SHo92v85Wte65pFW-94FX', 1429502884, 0),
(31, 'cvx03d4F09shSzZmuNNSMh-tfK6G17Ew', 1429518497, 0),
(32, 'CSVktpvJk5cEo3MiCSaX9XfLUx6fhszt', 1429518660, 0),
(32, 'peWQq8ghgDoxlhtcmH9G8Z_guWMjtsIA', 1429797101, 1),
(33, 'grSb8jYo1Y7_r0Sy3vCC4_rKp0uLXVhC', 1429793041, 0),
(35, 'lmmc25Q1yQBoAJ3n4XhfudaDDe_3e-ly', 1429794010, 0),
(36, '-CfTlkek9XxAOveM-e_LSHd8myFexYL-', 1429603272, 0),
(37, 'tB40OCpZB059FnwXWGwHXmvSwJ7PGWia', 1429795921, 0),
(37, 'Y7XwRZlYGkFbraRJtZJ7sHaqMXRPlMA2', 1429696383, 0),
(38, '5kYFBCyPdU0fDtMGHwsjQJOfTv-ow-Si', 1429696517, 0),
(38, 'RHBd6v9Hn6xHolWniNntl7vQ_lX3tD6_', 1429796131, 0),
(39, '9_ddIdZcBtpSpQC0sNUcRKY_rBwt_cDT', 1429796307, 0),
(40, 'M6ln5ZRaElkHeyBH2Asg0c0z98pweY3I', 1429796571, 0),
(41, 'Ew6GjGwB4IP9KT1Uc2tTBEdSSq7_fe-X', 1429796678, 0);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `created_at` bigint(20) NOT NULL,
  `topic_end` bigint(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `status` int(11) DEFAULT NULL,
  `thumbnail` varchar(250) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`created_at`, `topic_end`, `user_id`, `category_id`, `title`, `content`, `status`, `thumbnail`, `id`) VALUES
(1429522707, 1459486800, 31, 1, 'Relational Query Building in Yii2 - by admin', 'Relational Query Building in Yii2 ', NULL, '', 27),
(1429529037, 1459486800, 31, 1, 'Theming in Yii2 - by admin', 'Theming in Yii2', NULL, '', 28),
(1429621324, 1459486800, 31, 1, 'Console Scripts in Yii2 - by admin', 'Console Scripts in Yii2', NULL, '', 29),
(1429621352, 1430370000, 31, 1, 'Grid view Date filter in yii2 - by admin', 'Grid view Date filter in yii2', NULL, '', 30),
(1429623034, 1459486800, 32, 1, 'Sql Dataprovider in Yii2 - by user', 'Sql Dataprovider in Yii2', NULL, '', 31),
(1429623049, 1459486800, 32, 1, 'Url Redirection in Yii2 - by user', 'Url Redirection in Yii2', NULL, '', 32);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `password_hash` varchar(60) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `confirmed_at` int(11) NOT NULL,
  `unconfirmed_email` varchar(255) NOT NULL,
  `blocked_at` int(11) NOT NULL,
  `registration_ip` varchar(45) NOT NULL,
  `flags` int(11) NOT NULL,
  `first_name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `username` varchar(128) NOT NULL,
  `role` int(11) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `address` int(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `secret_key` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `state_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_user_states1_idx` (`state_id`),
  KEY `fk_user_zipareas2_idx` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `flags`, `first_name`, `last_name`, `email`, `username`, `role`, `password`, `address`, `city_id`, `created_at`, `updated_at`, `phone`, `secret_key`, `avatar`, `state_id`) VALUES
(31, '$2y$10$AfUzM970hKDXy4lBAX.wiuKJOVAn.AC4Bj6D8XXdNKSCDqoBhktE6', 'QOipvTBl5Zh-H4e8JBQniSVTuDsrO5c_', 1429793527, '', 0, '127.0.0.1', 0, NULL, NULL, 'roopankanhanagad@gmail.com', 'admin', 1, NULL, NULL, 10, 1429518497, 1429861507, NULL, NULL, '31.jpg', 14),
(32, '$2y$10$MGiftI/NovwxxI6KT4NZF.hS3MqIpp7jmUovZk51WZ6qpwcPHHCyy', '8vXwuK3a6YI70EPrvcCTjeRq6sPBJjKr', 1429793530, '', 0, '127.0.0.1', 0, NULL, NULL, 'yiioverflow@gmail.com', 'user', 1, NULL, NULL, 6, 1429518660, 1429871523, NULL, NULL, '32.jpg', 12);

-- --------------------------------------------------------

--
-- Table structure for table `zipareas`
--

CREATE TABLE IF NOT EXISTS `zipareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zip` varchar(5) NOT NULL,
  `state` varchar(2) NOT NULL,
  `city` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `old_lng` varchar(255) NOT NULL,
  `old_lat` varchar(255) NOT NULL,
  `updated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `zipareas`
--

INSERT INTO `zipareas` (`id`, `zip`, `state`, `city`, `latitude`, `longitude`, `old_lng`, `old_lat`, `updated`) VALUES
(6, '11', '12', 'Kasargod', '', '', '', '', 0),
(7, '11', '12', 'Kannur', '', '', '', '', 0),
(8, '11', '12', 'Wayanad', '', '', '', '', 0),
(9, '222', '13', 'Mumbai', '', '', '', '', 0),
(10, '12345', '14', 'GRCity1', '', '', '', '', 0),
(11, '12345', '15', 'GRCity2', '', '', '', '', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_topic1` FOREIGN KEY (`topicId`) REFERENCES `topic` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comments_user1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rel_topic_category`
--
ALTER TABLE `rel_topic_category`
  ADD CONSTRAINT `fk_categories_has_topic_categories1` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_categories_has_topic_topic1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rel_topic_skills`
--
ALTER TABLE `rel_topic_skills`
  ADD CONSTRAINT `fk_skill_has_topic_skill1` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_skill_has_topic_topic1` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `fk_states_countries1` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_states1` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_zipareas2` FOREIGN KEY (`city_id`) REFERENCES `zipareas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 05, 2018 at 04:08 PM
-- Server version: 5.5.58-0+deb8u1-log
-- PHP Version: 5.6.33-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xru_slim`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE IF NOT EXISTS `admins` (
`ad_id` tinyint(1) unsigned NOT NULL,
  `ad_log` varchar(30) CHARACTER SET utf8 NOT NULL,
  `ad_pass` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ad_id`, `ad_log`, `ad_pass`) VALUES
(1, 'maxiMir', '$2y$10$p5JoCbuQURP6Uoglc2ZCiemrFvSMMi/UAUOU1mJKBAEGQyeBw4q9W');

-- --------------------------------------------------------
--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` tinyint(4) unsigned NOT NULL,
  `user_fullName` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `user_adress` varchar(70) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fullName`, `user_email`, `user_adress`) VALUES
(1, 'Mireeva Julia Viktorovna', 'jmv@yandex.ru', 'Tula, Margelova, 5, 394'),
(2, 'Mister Robot', 'mr-robot@gmail.com', 'Secret information'),
(3, 'Anchenko Matvei Maksimovich', 'mm@mail.ru', 'Pyatigorsk, Mira, 3, 20'),
(4, 'Kozlov Evgenii Aleksandrovich', 'evg-koz@ya.ru', 'Tula,1-pereulok,1, 1a'),
(5, 'Sokolov Matvei Maksimovich', 'aaaaaam@gmail.com', 'Pyatigorsk, Mira, 3, 20'),
(7, 'Sherbakov Roman Viktorovich', 'sherbakov@inbox.ru', 'Tula, Lenina, 5, 10'),
(8, 'Zhikov Alexand Valentinovich', 'zhikov@mail.ru', 'Shekino, Mira, 5, 10'),
(9, 'Mr. Anderson', 'anderson@gmail.com', 'Matrix'),
(10, 'Mihalich', 'mihalich@mail.ru', 'Not known'),
(11, 'Entony Hopkins', 'hanibal@lekter.ru', 'Rome, undefined'),
(12, 'Maximus', 'maximus@yandex.ru', 'Coliseum, undefined'),
(13, 'Mr. Anderson', 'anderson@gmail.com', 'Matrix'),
(14, 'Hopkins Entony', 'hanibal@lekter.ru', 'Tula, Lenina, 5, 10'),
(15, 'Mirrev Maxim Aleksandrovich', 'mmirrev@mail.ru', 'mmirrev@mail.ru'),
(16, 'Minchenko Julia Viktorovna', 'julia@mail.ru', 'St. Petersburg, Mira, 10'),
(17, 'Sherbakov Roman Viktorovich', 'sherbakov@gmail.com', 'Tula, Mira,19, 129'),
(18, 'Mister Robot', 'mr-robot@gmail.com', 'Secret information'),
(32, 'Kozlov Igor Mihalich', 'mihalich@mail.ru', 'Rostov, Kutuzova,5, 39a'),
(33, 'Entony Hopkins', 'hanibal@lekter.ru', 'Florence, undefined'),
(34, 'Bobby Newmark', 'countzer0@icebreaker.com', 'New Jersey');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
 ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
MODIFY `ad_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `enc_keys`
--
ALTER TABLE `enc_keys`
MODIFY `key_id` tinyint(1) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

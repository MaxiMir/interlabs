-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2018 at 03:58 PM
-- Server version: 5.5.62-0+deb8u1-log
-- PHP Version: 5.6.38-0+deb8u1

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
-- Table structure for table `enc_keys`
--

CREATE TABLE IF NOT EXISTS `enc_keys` (
`key_id` tinyint(1) unsigned NOT NULL,
  `key_val` varchar(32) CHARACTER SET utf8 NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `enc_keys`
--

INSERT INTO `enc_keys` (`key_id`, `key_val`) VALUES
(1, '[�Mx��!<�Ж���J���T��TWaaLO�%');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` tinyint(4) unsigned NOT NULL,
  `user_fullName` varchar(50) NOT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_adress` varchar(70) DEFAULT NULL,
  `user_pos` tinyint(4) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_fullName`, `user_email`, `user_adress`, `user_pos`) VALUES
(2, 'Jorn Smit', 'mmirrev@gmail.com', 'New Jersey', 1),
(3, 'Onchenko Matvei Maksimovich', 'omm@mail.ru', 'Pyatigorsk, Mira, 3, 20', 5),
(4, 'Kozlov Evgenii Aleksandrovich', 'evgkoz@ya.ru', 'Tula,1-pereulok,1, 1a', 3),
(5, 'Sokolov Matvei Maksimovich', 'yy@gmail.com', 'Pyatigorsk, Mira, 3, 20', 4),
(7, 'Sherbakov Roman Viktorovich', 'sherbakov@inbox.ru', 'Tula, Lenina, 5, 10', 2),
(8, 'Zhikov Alexand Valentinovich', 'zhikov@mail.ru', 'Shekino, Mira, 5, 10', 6),
(9, 'Mr. Anderson', 'anderson@gmail.com', 'new Matrix', 7),
(10, 'Mihalich', 'mihalich@mail.ru', 'Not known', 8),
(11, 'Entony Hopkins', 'hanibal@lekter.ru', 'Rome, undefined', 9),
(12, 'Maximus', 'maximus@yandex.ru', 'Coliseum, undefined', 10),
(13, 'Mr. Anderson', 'anderson@gmail.eu', 'Matrix', 11),
(14, 'Hopkins Entony', 'hanibal@lekter.ru', 'Tula, Lenina, 5, 10', 12),
(15, 'Mirrev Maxim Aleksandrovich', 'mmirrev@mail.ru', 'mmirrev@mail.ru', 13),
(16, 'Min Julia Viktorovna', 'julia@mail.ru', 'St. Petersburg, Mira, 10', 14),
(17, 'Sherbakov Roman Viktorovich', 'sherbakov@gmail.com', 'Tula, Mira,19, 129', 15),
(18, 'Mister Robot', 'mr-robot@gmail.com', 'Secret information', 16),
(19, 'Kozlov Igor Mihalich', 'mihalich@mail.ru', 'Rostov, Kutuzova,5, 39a', 17),
(20, 'Entony Hopkins', 'hanibal@lekter.ru', 'Florence, undefined', 18),
(21, 'Bobby Newmark', 'countzer0@icebreaker.com', 'New Jersey', 19),
(22, 'Ded-Moroz', 'dd@moroz.ru', 'Sev. Polus', 20),
(23, 'Boroda', 'bb@ya.ru', 'null', 21),
(24, 'Михаил', 'mmirrev@gmail.com', '-- 404 --', 22),
(25, 'Юлия Минченко', 'mmirrev@gmail.com', 'г. Тула', 23),
(26, 'Ареев Арсен', 'ar@gmail.com', 'Москва, мира, 4, 3', 24),
(27, 'Scarling', 'sc@fbr.com', 'not found', 25),
(29, 'Юлия Минченко', 'mmirrev@gmail.com', 'Город Пряник', 26);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
 ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `enc_keys`
--
ALTER TABLE `enc_keys`
 ADD PRIMARY KEY (`key_id`);

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
MODIFY `user_id` tinyint(4) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 13, 2021 at 02:11 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_hatedspotshare`
--
CREATE DATABASE IF NOT EXISTS `db_hatedspotshare` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_hatedspotshare`;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `name`) VALUES
(004, 'bowl'),
(008, 'flatground'),
(006, 'gap'),
(007, 'halfpipe'),
(001, 'ledge'),
(002, 'miniramp'),
(003, 'rail'),
(005, 'stairs');

-- --------------------------------------------------------

--
-- Table structure for table `spots`
--

CREATE TABLE `spots` (
  `code` int(10) UNSIGNED NOT NULL,
  `image` text NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `neighborhood` varchar(50) NOT NULL,
  `street` varchar(45) NOT NULL,
  `number` int(5) UNSIGNED DEFAULT NULL,
  `users_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spots`
--

INSERT INTO `spots` (`code`, `image`, `country`, `state`, `city`, `neighborhood`, `street`, `number`, `users_id`) VALUES
(64, 'https://live.staticflickr.com/4055/4309997644_dc3a66aff0.jpg', 'Brasil', 'Santa Catarina', 'Joinville', 'Floresta', 'Elly Soares', 111, 2),
(65, 'https://galaxypro.s3.amazonaws.com/spot-media/353/353-jkwonledges-usa.jpg', 'Brazil', 'Paraná', 'Curitiba', 'Matriz', 'Jaime Balão', 739, 2),
(66, 'https://img.redbull.com/images/c_crop,x_0,y_258,h_1686,w_2999/c_fill,w_1500,h_1000/q_auto,f_auto/redbullcom/2015/09/28/1331750377350_2/andrey-ryzhov-backside-bluntslide-barcelona-julien-deniau', 'Brazil', 'Minas Gerais', 'Uberlândia', 'Canaã', 'Tebas', 98, 1),
(67, 'https://i.ytimg.com/vi/4GFIXrybfKg/maxresdefault.jpg', 'Brazil', 'Tocantins', 'Palmas', 'Santa Fé', 'Mario Lobo', 90, 1);

-- --------------------------------------------------------

--
-- Table structure for table `spots_has_features`
--

CREATE TABLE `spots_has_features` (
  `spots_code` int(10) UNSIGNED NOT NULL,
  `features_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `spots_has_features`
--

INSERT INTO `spots_has_features` (`spots_code`, `features_id`) VALUES
(64, 001),
(64, 003),
(64, 005),
(64, 008),
(65, 001),
(65, 005),
(65, 006),
(66, 001),
(66, 005),
(66, 006),
(66, 008),
(67, 005),
(67, 006);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `permission` tinyint(1) UNSIGNED NOT NULL COMMENT '0 - Adm\n1 - Common'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `permission`) VALUES
(1, 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', 0),
(2, 'user', 'user@user.com', 'ee11cbb19052e40b07aac0ca060c23ee', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Indexes for table `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`code`),
  ADD KEY `fk_spots_users_idx` (`users_id`);

--
-- Indexes for table `spots_has_features`
--
ALTER TABLE `spots_has_features`
  ADD PRIMARY KEY (`spots_code`,`features_id`),
  ADD KEY `fk_spots_has_features_features1_idx` (`features_id`),
  ADD KEY `fk_spots_has_features_spots1_idx` (`spots_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `spots`
--
ALTER TABLE `spots`
  MODIFY `code` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `spots`
--
ALTER TABLE `spots`
  ADD CONSTRAINT `fk_spots_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `spots_has_features`
--
ALTER TABLE `spots_has_features`
  ADD CONSTRAINT `fk_spots_has_features_features1` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_spots_has_features_spots1` FOREIGN KEY (`spots_code`) REFERENCES `spots` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

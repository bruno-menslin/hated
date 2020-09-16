-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 10-Set-2020 às 17:07
-- Versão do servidor: 10.4.13-MariaDB
-- versão do PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_hatedspotshare`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `features`
--

CREATE TABLE `features` (
  `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `features`
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
-- Estrutura da tabela `spots`
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
-- Extraindo dados da tabela `spots`
--

INSERT INTO `spots` (`code`, `image`, `country`, `state`, `city`, `neighborhood`, `street`, `number`, `users_id`) VALUES
(63, 'https://live.staticflickr.com/4055/4309997644_dc3a66aff0.jpg', 'Brazil', 'Santa Catarina', 'Joinville', 'América', 'Paraná', 503, 1),
(64, 'https://galaxypro.s3.amazonaws.com/spot-media/353/353-jkwonledges-usa.jpg', 'Brazil', 'Paraná', 'Pontal do Paraná', 'Centro', 'ângelo', NULL, 1),
(65, 'https://img.redbull.com/images/c_crop,x_0,y_258,h_1686,w_2999/c_fill,w_1500,h_1000/q_auto,f_auto/redbullcom/2015/09/28/1331750377350_2/andrey-ryzhov-backside-bluntslide-barcelona-julien-deniau', 'Canada', 'Acre', 'Rio Branco', 'Bosque', 'Ceará Avenue', 482, 9),
(66, 'https://i.ytimg.com/vi/4GFIXrybfKg/maxresdefault.jpg', 'Russia', 'Piauí', 'Rio Grande', 'Paraná', 'Teresinha', 983, 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `spots_has_features`
--

CREATE TABLE `spots_has_features` (
  `spots_code` int(10) UNSIGNED NOT NULL,
  `features_id` tinyint(3) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `spots_has_features`
--

INSERT INTO `spots_has_features` (`spots_code`, `features_id`) VALUES
(63, 001),
(63, 003),
(63, 005),
(63, 006),
(63, 008),
(64, 001),
(64, 005),
(64, 006),
(65, 001),
(65, 005),
(65, 006),
(66, 005),
(66, 006);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(32) NOT NULL,
  `permission` tinyint(1) UNSIGNED NOT NULL COMMENT '0 - Adm\n1 - Common'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `permission`) VALUES
(1, 'senha123', 'menslin@gmail.com', '202cb962ac59075b964b07152d234b70', 0),
(9, 'jacson', 'jacson@gmail.com', 'cd4b478aeed6c1bc43c0b974024fc34f', 1);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name_UNIQUE` (`name`);

--
-- Índices para tabela `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`code`),
  ADD KEY `fk_spots_users_idx` (`users_id`);

--
-- Índices para tabela `spots_has_features`
--
ALTER TABLE `spots_has_features`
  ADD PRIMARY KEY (`spots_code`,`features_id`),
  ADD KEY `fk_spots_has_features_features1_idx` (`features_id`),
  ADD KEY `fk_spots_has_features_spots1_idx` (`spots_code`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `features`
--
ALTER TABLE `features`
  MODIFY `id` tinyint(3) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `spots`
--
ALTER TABLE `spots`
  MODIFY `code` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `spots`
--
ALTER TABLE `spots`
  ADD CONSTRAINT `fk_spots_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `spots_has_features`
--
ALTER TABLE `spots_has_features`
  ADD CONSTRAINT `fk_spots_has_features_features1` FOREIGN KEY (`features_id`) REFERENCES `features` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_spots_has_features_spots1` FOREIGN KEY (`spots_code`) REFERENCES `spots` (`code`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

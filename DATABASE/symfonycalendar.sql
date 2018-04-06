-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creato il: Apr 06, 2018 alle 20:20
-- Versione del server: 5.7.21-0ubuntu0.17.10.1
-- Versione PHP: 7.1.15-0ubuntu0.17.10.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symfonycalendar`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `booking`
--

DROP TABLE IF EXISTS `booking`;
CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `event` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `arrivale` datetime NOT NULL,
  `departure` datetime NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deposit` double NOT NULL,
  `created` datetime NOT NULL,
  `usertype` int(11) NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

DROP TABLE IF EXISTS `evento`;
CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `teacher` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `place` int(11) NOT NULL,
  `topic` int(11) NOT NULL,
  `coursetype` int(11) NOT NULL,
  `body` longtext COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`id`, `date`, `title`, `teacher`, `start`, `end`, `place`, `topic`, `coursetype`, `body`, `active`) VALUES
(1, '2018-01-29 00:00:00', 'Orto Sinergico', 1, '2013-01-01 00:00:00', '2013-01-01 00:00:00', 5, 1, 5, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id diam condimentum turpis dapibus sagittis et ut augue. Pellentesque posuere, velit quis dictum imperdiet, neque sapien ultrices libero, eu ultricies sapien sapien id nisl. Maecenas quis est vel neque feugiat ultrices. Donec mi sapien, ultricies ut hendrerit eu, cursus non quam. Quisque ac lobortis leo, in gravida tellus. Praesent felis felis, finibus ac turpis condimentum, volutpat pretium leo. Nunc eget maximus sem, id pretium mauris.</p>\r\n<p>Fusce porttitor felis sit amet quam viverra, at sollicitudin diam maximus. Nam in faucibus lacus, at pretium lacus. Vestibulum nibh ipsum, blandit eget gravida venenatis, condimentum a augue. Pellentesque mollis eget est sit amet faucibus. In at ipsum in mi sodales dignissim sit amet sit amet leo. Nunc nibh lectus, eleifend eu magna pretium, sodales pulvinar purus. Suspendisse ac finibus nibh. Sed eget tellus pellentesque, cursus eros vel, tristique nunc. Pellentesque sit amet cursus nulla. Sed iaculis auctor faucibus. Duis commodo eget nunc suscipit maximus. Mauris vitae vulputate sem. Pellentesque lacinia, lectus sit amet porttitor sagittis, urna tortor accumsan elit, ut scelerisque felis velit id libero. </p>', 0),
(3, '2018-01-29 00:00:00', 'Reiki I Livello', 1, '2018-05-01 09:30:00', '2018-05-01 19:30:00', 1, 3, 3, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id diam condimentum turpis dapibus sagittis et ut augue. Pellentesque posuere, velit quis dictum imperdiet, neque sapien ultrices libero, eu ultricies sapien sapien id nisl. Maecenas quis est vel neque feugiat ultrices. Donec mi sapien, ultricies ut hendrerit eu, cursus non quam. Quisque ac lobortis leo, in gravida tellus. Praesent felis felis, finibus ac turpis condimentum, volutpat pretium leo. Nunc eget maximus sem, id pretium mauris.</p>\r\n<p>Fusce porttitor felis sit amet quam viverra, at sollicitudin diam maximus. Nam in faucibus lacus, at pretium lacus. Vestibulum nibh ipsum, blandit eget gravida venenatis, condimentum a augue. Pellentesque mollis eget est sit amet faucibus. In at ipsum in mi sodales dignissim sit amet sit amet leo. Nunc nibh lectus, eleifend eu magna pretium, sodales pulvinar purus. Suspendisse ac finibus nibh. Sed eget tellus pellentesque, cursus eros vel, tristique nunc. Pellentesque sit amet cursus nulla. Sed iaculis auctor faucibus. Duis commodo eget nunc suscipit maximus. Mauris vitae vulputate sem. Pellentesque lacinia, lectus sit amet porttitor sagittis, urna tortor accumsan elit, ut scelerisque felis velit id libero. </p>', 1),
(4, '2018-02-12 00:00:00', 'Costellazioni Familiari Sistemiche', 1, '2013-01-01 00:00:00', '2013-01-01 00:00:00', 1, 1, 3, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id diam condimentum turpis dapibus sagittis et ut augue. Pellentesque posuere, velit quis dictum imperdiet, neque sapien ultrices libero, eu ultricies sapien sapien id nisl. Maecenas quis est vel neque feugiat ultrices. Donec mi sapien, ultricies ut hendrerit eu, cursus non quam. Quisque ac lobortis leo, in gravida tellus. Praesent felis felis, finibus ac turpis condimentum, volutpat pretium leo. Nunc eget maximus sem, id pretium mauris.</p>\r\n<p>Fusce porttitor felis sit amet quam viverra, at sollicitudin diam maximus. Nam in faucibus lacus, at pretium lacus. Vestibulum nibh ipsum, blandit eget gravida venenatis, condimentum a augue. Pellentesque mollis eget est sit amet faucibus. In at ipsum in mi sodales dignissim sit amet sit amet leo. Nunc nibh lectus, eleifend eu magna pretium, sodales pulvinar purus. Suspendisse ac finibus nibh. Sed eget tellus pellentesque, cursus eros vel, tristique nunc. Pellentesque sit amet cursus nulla. Sed iaculis auctor faucibus. Duis commodo eget nunc suscipit maximus. Mauris vitae vulputate sem. Pellentesque lacinia, lectus sit amet porttitor sagittis, urna tortor accumsan elit, ut scelerisque felis velit id libero. </p>', 1),
(5, '2018-02-12 00:00:00', 'Costellazioni Familiari Sistemiche', 1, '2013-01-01 00:00:00', '2013-01-01 00:00:00', 1, 1, 3, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id diam condimentum turpis dapibus sagittis et ut augue. Pellentesque posuere, velit quis dictum imperdiet, neque sapien ultrices libero, eu ultricies sapien sapien id nisl. Maecenas quis est vel neque feugiat ultrices. Donec mi sapien, ultricies ut hendrerit eu, cursus non quam. Quisque ac lobortis leo, in gravida tellus. Praesent felis felis, finibus ac turpis condimentum, volutpat pretium leo. Nunc eget maximus sem, id pretium mauris.</p>\r\n<p>Fusce porttitor felis sit amet quam viverra, at sollicitudin diam maximus. Nam in faucibus lacus, at pretium lacus. Vestibulum nibh ipsum, blandit eget gravida venenatis, condimentum a augue. Pellentesque mollis eget est sit amet faucibus. In at ipsum in mi sodales dignissim sit amet sit amet leo. Nunc nibh lectus, eleifend eu magna pretium, sodales pulvinar purus. Suspendisse ac finibus nibh. Sed eget tellus pellentesque, cursus eros vel, tristique nunc. Pellentesque sit amet cursus nulla. Sed iaculis auctor faucibus. Duis commodo eget nunc suscipit maximus. Mauris vitae vulputate sem. Pellentesque lacinia, lectus sit amet porttitor sagittis, urna tortor accumsan elit, ut scelerisque felis velit id libero. </p>', 1),
(6, '2018-02-25 00:00:00', 'Costellazioni Familiari Sistemiche', 1, '2018-05-02 09:30:00', '2018-05-02 19:30:00', 1, 1, 3, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id diam condimentum turpis dapibus sagittis et ut augue. Pellentesque posuere, velit quis dictum imperdiet, neque sapien ultrices libero, eu ultricies sapien sapien id nisl. Maecenas quis est vel neque feugiat ultrices. Donec mi sapien, ultricies ut hendrerit eu, cursus non quam. Quisque ac lobortis leo, in gravida tellus. Praesent felis felis, finibus ac turpis condimentum, volutpat pretium leo. Nunc eget maximus sem, id pretium mauris.</p>\r\n<p>Fusce porttitor felis sit amet quam viverra, at sollicitudin diam maximus. Nam in faucibus lacus, at pretium lacus. Vestibulum nibh ipsum, blandit eget gravida venenatis, condimentum a augue. Pellentesque mollis eget est sit amet faucibus. In at ipsum in mi sodales dignissim sit amet sit amet leo. Nunc nibh lectus, eleifend eu magna pretium, sodales pulvinar purus. Suspendisse ac finibus nibh. Sed eget tellus pellentesque, cursus eros vel, tristique nunc. Pellentesque sit amet cursus nulla. Sed iaculis auctor faucibus. Duis commodo eget nunc suscipit maximus. Mauris vitae vulputate sem. Pellentesque lacinia, lectus sit amet porttitor sagittis, urna tortor accumsan elit, ut scelerisque felis velit id libero. </p>', 1),
(7, '2018-03-02 18:16:44', 'Costellazioni Familiari Sistemiche', 1, '2013-01-01 00:00:00', '2013-01-01 00:00:00', 1, 1, 3, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id diam condimentum turpis dapibus sagittis et ut augue. Pellentesque posuere, velit quis dictum imperdiet, neque sapien ultrices libero, eu ultricies sapien sapien id nisl. Maecenas quis est vel neque feugiat ultrices. Donec mi sapien, ultricies ut hendrerit eu, cursus non quam. Quisque ac lobortis leo, in gravida tellus. Praesent felis felis, finibus ac turpis condimentum, volutpat pretium leo. Nunc eget maximus sem, id pretium mauris.</p>\r\n<p>Fusce porttitor felis sit amet quam viverra, at sollicitudin diam maximus. Nam in faucibus lacus, at pretium lacus. Vestibulum nibh ipsum, blandit eget gravida venenatis, condimentum a augue. Pellentesque mollis eget est sit amet faucibus. In at ipsum in mi sodales dignissim sit amet sit amet leo. Nunc nibh lectus, eleifend eu magna pretium, sodales pulvinar purus. Suspendisse ac finibus nibh. Sed eget tellus pellentesque, cursus eros vel, tristique nunc. Pellentesque sit amet cursus nulla. Sed iaculis auctor faucibus. Duis commodo eget nunc suscipit maximus. Mauris vitae vulputate sem. Pellentesque lacinia, lectus sit amet porttitor sagittis, urna tortor accumsan elit, ut scelerisque felis velit id libero. </p>', 1),
(8, '2018-03-02 18:18:35', 'Costellazioni Familiari Sistemiche PR', 1, '2013-01-01 00:00:00', '2013-01-01 00:00:00', 1, 1, 2, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id diam condimentum turpis dapibus sagittis et ut augue. Pellentesque posuere, velit quis dictum imperdiet, neque sapien ultrices libero, eu ultricies sapien sapien id nisl. Maecenas quis est vel neque feugiat ultrices. Donec mi sapien, ultricies ut hendrerit eu, cursus non quam. Quisque ac lobortis leo, in gravida tellus. Praesent felis felis, finibus ac turpis condimentum, volutpat pretium leo. Nunc eget maximus sem, id pretium mauris.</p>\r\n<p>Fusce porttitor felis sit amet quam viverra, at sollicitudin diam maximus. Nam in faucibus lacus, at pretium lacus. Vestibulum nibh ipsum, blandit eget gravida venenatis, condimentum a augue. Pellentesque mollis eget est sit amet faucibus. In at ipsum in mi sodales dignissim sit amet sit amet leo. Nunc nibh lectus, eleifend eu magna pretium, sodales pulvinar purus. Suspendisse ac finibus nibh. Sed eget tellus pellentesque, cursus eros vel, tristique nunc. Pellentesque sit amet cursus nulla. Sed iaculis auctor faucibus. Duis commodo eget nunc suscipit maximus. Mauris vitae vulputate sem. Pellentesque lacinia, lectus sit amet porttitor sagittis, urna tortor accumsan elit, ut scelerisque felis velit id libero. </p>', 1),
(9, '2018-04-06 10:49:08', 'Reiki I Livello', 1, '2018-07-01 00:00:00', '2018-01-01 00:00:00', 3, 3, 3, 'prova', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20180314125238'),
('20180403084342'),
('20180404101224'),
('20180406073110'),
('20180406073913'),
('20180406074419'),
('20180406093651');

-- --------------------------------------------------------

--
-- Struttura della tabella `place`
--

DROP TABLE IF EXISTS `place`;
CREATE TABLE `place` (
  `id` int(11) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `place`
--

INSERT INTO `place` (`id`, `address`, `city`, `country`, `name`, `active`) VALUES
(1, 'via Porcozzone, 17', 'Trecastelli', 'AN', 'La Città della Luce', 1),
(2, 'via Lonate, 6', 'Turbigo', 'MI', 'La Città della Luce', 1),
(3, 'Via Nicolò Bettoni, 7', 'Roma', 'RM', 'La Città della Luce', 1),
(5, 'Via Ottorino Manni, 1', 'Senigallia', 'AN', 'Biblioteca Comunale di Senigallia', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `teacher`
--

DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `teacher`
--

INSERT INTO `teacher` (`id`, `name`, `active`) VALUES
(1, 'Jahnu Silvio Crispiatico', 1),
(2, 'Zavaroni Pierluigi', 0),
(3, 'Dhara Janneke Gisolf', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `topic`
--

DROP TABLE IF EXISTS `topic`;
CREATE TABLE `topic` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `gallery` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `topic`
--

INSERT INTO `topic` (`id`, `name`, `active`, `gallery`, `weight`) VALUES
(1, 'Costellazioni Familiari Sistemiche', 1, 'costellazionifamiliari.png', 9),
(2, 'Agricoltura Consapevole', 1, 'agricolturaconsapevole.png', 3),
(3, 'Reiki Sistema Usui', 1, 'reiki.png', 0),
(4, 'Astrologia Archetipica', 1, 'astrologia.png', 0),
(5, 'Il Viaggio dell\'Eroe', 1, 'viaggioeroe.png', 1),
(7, 'Fiori di Bach', 1, 'fioridibach.png', 0),
(8, 'Runologia', 0, '5-RAIDO-esagono_S-RED-50-logo.png', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `type`
--

DROP TABLE IF EXISTS `type`;
CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `coursetype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `type`
--

INSERT INTO `type` (`id`, `coursetype`, `active`) VALUES
(1, 'Conferenza - Workshop', 1),
(2, 'Consulti e Trattamenti', 1),
(3, 'Corso - Seminario', 1),
(4, 'Evento', 1),
(5, 'Ritiro', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `roles` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `recoverpasswordlink` varchar(60) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `is_active`, `roles`, `recoverpasswordlink`) VALUES
(1, 'test', 'test', 'nolitaweb@gmail.com', 1, 'ROLES_ADMIN', '758bec263c8d7bd4');

-- --------------------------------------------------------

--
-- Struttura della tabella `usertype`
--

DROP TABLE IF EXISTS `usertype`;
CREATE TABLE `usertype` (
  `id` int(11) NOT NULL,
  `usertype` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `usertype`
--

INSERT INTO `usertype` (`id`, `usertype`) VALUES
(1, 'Esterno'),
(3, 'Scuola Olistica'),
(4, 'Interno'),
(6, 'Generoso');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indici per le tabelle `place`
--
ALTER TABLE `place`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `topic`
--
ALTER TABLE `topic`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_8D93D649B63E2EC7` (`roles`),
  ADD UNIQUE KEY `UNIQ_8D93D649337C9155` (`recoverpasswordlink`);

--
-- Indici per le tabelle `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT per la tabella `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT per la tabella `place`
--
ALTER TABLE `place`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT per la tabella `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT per la tabella `topic`
--
ALTER TABLE `topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT per la tabella `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT per la tabella `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT per la tabella `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

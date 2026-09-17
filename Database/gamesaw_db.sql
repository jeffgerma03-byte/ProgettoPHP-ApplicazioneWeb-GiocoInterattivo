-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 25, 2026 alle 17:54
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamesaw_db`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `punteggi`
--

CREATE TABLE `punteggi` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `punteggio` int(11) NOT NULL,
  `data_partita` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `punteggi`
--

INSERT INTO `punteggi` (`id`, `id_utente`, `punteggio`, `data_partita`) VALUES
(1, 2, 170, '2025-12-10 16:16:05'),
(2, 8, 160, '2025-12-10 16:19:13'),
(3, 8, 90, '2025-12-10 16:25:50'),
(4, 8, 40, '2025-12-10 16:41:55'),
(5, 9, 170, '2025-12-10 16:46:07'),
(6, 9, 230, '2025-12-11 15:18:46'),
(7, 9, 160, '2025-12-11 15:19:24'),
(8, 9, 190, '2025-12-11 15:22:53'),
(9, 9, 320, '2025-12-11 15:45:21'),
(10, 9, 440, '2025-12-11 15:49:47'),
(11, 9, 340, '2025-12-11 16:02:28'),
(12, 9, 1695, '2025-12-11 16:04:57'),
(13, 9, 1355, '2025-12-11 16:09:50'),
(14, 9, 530, '2025-12-11 16:29:07'),
(15, 9, 2395, '2025-12-11 16:33:13'),
(16, 9, 1210, '2025-12-11 17:14:02'),
(17, 9, 1075, '2025-12-11 17:19:22'),
(18, 9, 1170, '2025-12-11 17:31:23'),
(20, 2, 1840, '2025-12-16 14:00:30'),
(21, 2, 3305, '2026-01-20 15:06:06'),
(22, 2, 6330, '2026-01-21 13:01:30'),
(23, 2, 5550, '2026-01-21 13:18:32'),
(24, 2, 2055, '2026-01-24 15:50:20');

-- --------------------------------------------------------

--
-- Struttura della tabella `utenti`
--

CREATE TABLE `utenti` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cognome` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ruolo` enum('user','admin') DEFAULT 'user',
  `data_registrazione` timestamp NOT NULL DEFAULT current_timestamp(),
  `bannato` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `utenti`
--

INSERT INTO `utenti` (`id`, `nome`, `cognome`, `email`, `password`, `ruolo`, `data_registrazione`, `bannato`) VALUES
(2, 'Mario', 'Rossi', 'mariorossi92@gmail.com', '$2y$10$op7NDAJrxTYrwcuXuJYDoOUBCTl7TUA4JuuOSYU7IrMU7JcSBWbra', 'user', '2025-12-09 16:40:46', 0),
(5, 'Admin', 'Admin', 'admin@gamesaw.com', '$2y$10$t54lLwbUCHRRYEVbqamO5e4WDaMqqCMrWqmmfOOp2A5P8L10Bixw.', 'admin', '2025-12-09 17:13:35', 0),
(6, 'Luigi', 'Bianchi', 'luigibianchi92@gmail.com', '$2y$10$etV48VRw9qV2LjOY3FVeVeMGJke5PcIBR1kBrNtO2ET9rPtWiFQ9.', 'user', '2025-12-09 17:30:27', 1),
(8, 'Marco', 'Polo', 'marcopolo@gmail.com', '$2y$10$cPO0rt.luldOCumP5ABfh.lhmmw96RsE3EUJRb3lPIv6WqgIr9V96', 'user', '2025-12-10 16:17:44', 0),
(9, 'Enrico', 'Moretti', 'enricomoretti@gmail.com', '$2y$10$Tns2xHPrJ8a99X4Vdv1qFuy/0o6wvQ3PARg5KM3CzgYys4DwD08o6', 'user', '2025-12-10 16:44:42', 0),
(15, 'Lucia', 'Pitoldi', 'pitoldi.lucia@gmail.com', '$2y$10$i0oSAXjy4n5FjxFEA9oOJunMWAvjZ69jsJb8QoMgrOF6cfhEp0Kou', 'user', '2026-01-25 16:25:02', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `punteggi`
--
ALTER TABLE `punteggi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

--
-- Indici per le tabelle `utenti`
--
ALTER TABLE `utenti`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `punteggi`
--
ALTER TABLE `punteggi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT per la tabella `utenti`
--
ALTER TABLE `utenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `punteggi`
--
ALTER TABLE `punteggi`
  ADD CONSTRAINT `punteggi_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `utenti` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

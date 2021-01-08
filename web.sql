-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Pát 08. led 2021, 10:20
-- Verze serveru: 10.4.17-MariaDB
-- Verze PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `web`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `clanky`
--

CREATE TABLE `clanky` (
  `clanky_id` int(11) NOT NULL,
  `titulek` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `obsah` text COLLATE utf8mb4_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `popisek` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `klicova_slova` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `soubor_cesta` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `autor` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `publikovani` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `recenze`
--

CREATE TABLE `recenze` (
  `recenze_id` int(11) NOT NULL,
  `titulek` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `hodnoceni_zajimavost` int(11) NOT NULL,
  `hodnoceni_pravdivost` int(11) NOT NULL,
  `hodnoceni_gramatika` int(11) NOT NULL,
  `hodnoceni` int(11) NOT NULL,
  `autor` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `datum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatel`
--

CREATE TABLE `uzivatel` (
  `uzivatel_id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `jmeno` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `prijmeni` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `admin` int(1) NOT NULL DEFAULT 0,
  `recenzent` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `uzivatel`
--

INSERT INTO `uzivatel` (`uzivatel_id`, `login`, `jmeno`, `prijmeni`, `email`, `heslo`, `admin`, `recenzent`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@seznam.cu', '$2y$10$ew/faqoUOSV6Gnv7.L/aLuARFz1RvPmPl38n8gakFTSDzre1/L9mW', 1, 0),
(2, 'recenzent', 'recenzent', 'recenzent', 'recenzent@seznam.cz', '$2y$10$LTU.Rftj/rQ//IUbXzl68u.arOaBC.frfXjtHQCgh3gjVy0AIWTRi', 0, 1),
(6, 'aaa', 'aaa', 'aaa', 'Cifka.D@seznam.cz', '$2y$10$3xV9AKX1LDPdB/nj.Z6i0Odxn9oBagaKPVwysXg0aACdfekbCjT0W', 0, 0);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `clanky`
--
ALTER TABLE `clanky`
  ADD PRIMARY KEY (`clanky_id`),
  ADD UNIQUE KEY `clanek_id` (`clanky_id`,`url`);

--
-- Klíče pro tabulku `recenze`
--
ALTER TABLE `recenze`
  ADD PRIMARY KEY (`recenze_id`);

--
-- Klíče pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  ADD PRIMARY KEY (`uzivatel_id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `clanky`
--
ALTER TABLE `clanky`
  MODIFY `clanky_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `recenze`
--
ALTER TABLE `recenze`
  MODIFY `recenze_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `uzivatel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

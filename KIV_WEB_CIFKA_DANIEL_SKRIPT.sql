-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Sob 09. led 2021, 21:44
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
CREATE DATABASE IF NOT EXISTS `web` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;
USE `web`;

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

--
-- Vypisuji data pro tabulku `clanky`
--

INSERT INTO `clanky` (`clanky_id`, `titulek`, `obsah`, `url`, `popisek`, `klicova_slova`, `soubor_cesta`, `autor`, `publikovani`) VALUES
(1, 'Počítačové sítě', '<p>Jedn&aacute; se o čl&aacute;nek o z&aacute;kladech poč&iacute;tačov&yacute;ch s&iacute;t&iacute; a jejich funkčnosti. S&aacute;m jsem přečetl a hodně jsem se přiučil o poč&iacute;tačov&yacute;c sit&iacute; a jejich protokolech.</p>\r\n\r\n<p>Pokud jsou tu lidi co se o toto zaj&iacute;maj&iacute; doporučuji přeč&iacute;st a str&aacute;vit nějak&yacute; čas nad t&iacute;m</p>\r\n', 'pocitacove_site', 'Základní věci o sítích', 'Sítě, základy, přehled', 'clankypdf/KTPS_1_FINAL.pdf', 'jvom32', 1),
(2, 'Atleticky seminář', '<p>Tady je nejak&yacute; zakladn&iacute; přehled informac&iacute; z předn&aacute;&scaron;ky z fakulty FTVS, kde bylo možn&yacute; dodělat kurz tr&eacute;novan&iacute; dět&iacute;. Pr tren&eacute;ry, kteř&iacute; hodlaj&iacute; na tento kurz j&iacute; doporučuji přeč&iacute;st před zač&aacute;tkem kurzu.</p>\r\n\r\n<p>Velmi mnoho mi toto dalo do m&eacute; tren&eacute;rsk&eacute; funkce a je to velmi dobr&yacute; čl&aacute;nek zde.</p>\r\n', 'atletika_seminar', 'Odborný atletický seminář', 'atletika, děti, trenink', 'clankypdf/FTVS-732-version1-zakladyatletiky.pdf', 'jvom32', 0),
(3, 'Atletika Mládeže', '<p>Toto j zakladn&iacute; čl&aacute;nek o trenov&aacute;n&iacute; ml&aacute;deže v atletice, pro zač&iacute;najc&iacute; tren&eacute;ry dobr&aacute; přiručka pro z&iacute;skan&iacute; informac&iacute; jak skl&aacute;dat treninky.</p>\r\n\r\n<p>D&aacute;le je zde nejak&yacute; naznak př&iacute;stupu tren&eacute;ra k dětem. Pro tren&eacute;ry mohu doporučit k přečten&iacute;.</p>\r\n', 'atletika_mladeze', 'Informace o trénovaní atletické mládeže', 'atletika, děti, trenink, složení', 'clankypdf/metodika-treninku-mladeze-v-prikladech.pdf', 'jvom32', 0);

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

--
-- Vypisuji data pro tabulku `recenze`
--

INSERT INTO `recenze` (`recenze_id`, `titulek`, `url`, `hodnoceni_zajimavost`, `hodnoceni_pravdivost`, `hodnoceni_gramatika`, `hodnoceni`, `autor`, `datum`) VALUES
(1, 'Počítačové sítě', 'pocitacove_site', 8, 7, 5, 6, 'kajka2005', '2021-01-09'),
(2, 'Počítačové sítě', 'pocitacove_site', 5, 5, 5, 5, 'ludinka2001', '2021-01-09'),
(3, 'Počítačové sítě', 'pocitacove_site', 8, 7, 8, 8, 'darksam', '2021-01-09');

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
(1, 'dandy1141', 'Daniel', 'Cífka', 'Cifka.D@seznam.cz', '$2y$10$kAX/ipCATLJYTwtgLJREiO4hqPP9zRgLuI5draB4iTzTCSfDUbz6C', 1, 0),
(2, 'jvom32', 'Jan', 'Vomáčka', 'janvormik@seznam.cz', '$2y$10$bTBPK4LiZh9IfjyMGDrYdO1seDqap1a2DT5K7TwvT1uXWSTjmLyOq', 0, 0),
(3, 'ludinka2001', 'Linda', 'Hartlova', 'liduHart@Gmail.com', '$2y$10$dTFB43N7pAVxOcGyDgbHYOyOnqmr3F8Uz3cFv314nK5M/wC/.V4.u', 0, 1),
(4, 'darksam', 'Jan', 'Doubrava', 'darksam1999@seznam.cz', '$2y$10$m59SJtz4opy04MnU9rLEgu8sb45gmJWPGFnCo3NrnuhlJWqfjNaBa', 0, 1),
(5, 'kajka2005', 'Karolína', 'Cífková', 'Cifkova.K@seznam.cz', '$2y$10$fn7SIJXXWDnH91stc.2W2.tI41odeusAG6ECVNKArZnqZeXbFzjU.', 0, 1);

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
  MODIFY `clanky_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `recenze`
--
ALTER TABLE `recenze`
  MODIFY `recenze_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `uzivatel`
--
ALTER TABLE `uzivatel`
  MODIFY `uzivatel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

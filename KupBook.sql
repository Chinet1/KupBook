-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 02 Cze 2019, 17:51
-- Wersja serwera: 5.7.26-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.33-0ubuntu0.16.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `KupBook`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Authors`
--

CREATE TABLE `Authors` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Authors`
--

INSERT INTO `Authors` (`ID`, `name`, `last_name`) VALUES
(1, 'Bolesław', 'Prus'),
(2, 'George', 'Orwell'),
(3, 'Mario', 'Puzo'),
(4, 'Andrzej', 'Stasiuk'),
(5, 'Adam', 'Mickiewicz'),
(6, 'Julian', 'Tuwim'),
(7, 'Daniel', 'Defoe'),
(8, 'Arthur Conan', 'Doyle'),
(9, 'Remigiusz', 'Mróz');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Books`
--

CREATE TABLE `Books` (
  `ID` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `title` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `year` int(4) NOT NULL,
  `price` decimal(4,2) NOT NULL,
  `publisher` int(11) NOT NULL,
  `genre` int(11) NOT NULL,
  `cover` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `amount` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Books`
--

INSERT INTO `Books` (`ID`, `author`, `title`, `year`, `price`, `publisher`, `genre`, `cover`, `amount`) VALUES
(1, 1, 'Lalka', 2015, '31.99', 2, 1, 'bp_lalka.jpg', 6),
(2, 2, 'Rok 1984', 2017, '39.90', 3, 1, 'go_rok1984.jpg', 72),
(3, 3, 'Ojciec chrzestny', 2018, '35.50', 1, 1, 'pm_ojciecchrzestny.jpg', 47),
(4, 4, 'Grochów', 2012, '31.50', 4, 1, 'as_grochow.jpg', 0),
(6, 5, 'Pan Tadeusz', 2017, '34.50', 6, 3, 'am_pantadeusz.jpg', 47),
(7, 7, 'Przypadki Robinsona Kruzoe', 2015, '22.00', 7, 1, 'dd_przypadkirobinsonakruzoe.jpg', 150),
(8, 8, 'Przygody Sherlocka Holmesa', 2017, '18.99', 6, 1, 'dac_przygodysherlockaholmesa.jpg', 120),
(9, 8, 'Studium w szkarłacie', 2019, '24.95', 9, 1, 'dac_studiumwszkarlacie.jpg', 120),
(10, 9, 'Listy zza grobu', 2019, '39.90', 10, 1, 'rm_listyzzagroby.jpg', 100);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Clients`
--

CREATE TABLE `Clients` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `last_name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Clients`
--

INSERT INTO `Clients` (`ID`, `name`, `last_name`, `address`, `user_id`) VALUES
(1, 'Mateusz', 'Zbylut', 'ul. Testowa 10, 00-000 Testowo', 1),
(2, 'Mateusz', 'Klient', 'ul. Testowa 7, 33-100 Tarnów', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Genre`
--

CREATE TABLE `Genre` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Genre`
--

INSERT INTO `Genre` (`ID`, `name`) VALUES
(1, 'Powieść'),
(2, 'Liryka'),
(3, 'Poezja');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Orders`
--

CREATE TABLE `Orders` (
  `ID` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `products` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `order_date` date NOT NULL,
  `send_date` date DEFAULT NULL,
  `status` varchar(15) COLLATE utf8_polish_ci NOT NULL,
  `final_amount` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Orders`
--

INSERT INTO `Orders` (`ID`, `user`, `products`, `order_date`, `send_date`, `status`, `final_amount`) VALUES
(1, 1, '[1,2]', '2019-05-31', '2019-06-02', 'wysłane', '86.89'),
(2, 1, '[1,2]', '2019-05-31', NULL, 'opłacone', '86.89'),
(4, 2, '[1,6]', '2019-06-02', NULL, 'opłacone', '81.49'),
(5, 2, '[3]', '2019-06-02', NULL, 'opłacone', '50.50');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Publishers`
--

CREATE TABLE `Publishers` (
  `ID` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Publishers`
--

INSERT INTO `Publishers` (`ID`, `name`) VALUES
(1, 'Albatros'),
(2, 'Mg'),
(3, 'MUZA S.A.'),
(4, 'Czarne'),
(5, 'WAZA'),
(6, 'Siedmioróg'),
(7, 'S.K.A.'),
(9, 'Dragon'),
(10, 'Filia');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE `Users` (
  `ID` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `role` varchar(20) COLLATE utf8_polish_ci NOT NULL,
  `activation_code` varchar(50) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `Users`
--

INSERT INTO `Users` (`ID`, `email`, `password`, `role`, `activation_code`) VALUES
(1, 'chinetcom@gmail.com', '$2y$10$K6cq4wULAHupsE6XOjvxXOcKrHn/mburVsS7ubvb.ktTR7/w681ya', 'admin', 'activated'),
(2, 'contact@mateuszzbylut.com', '$2y$10$O0QuwFP2V35jWV94ti2Hwe8bLVjT.FnO5dtymY..PvhE33ifk/uSS', 'user', 'activated');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `Authors`
--
ALTER TABLE `Authors`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Books`
--
ALTER TABLE `Books`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Author` (`author`),
  ADD KEY `Publisher` (`publisher`),
  ADD KEY `Genre` (`genre`);

--
-- Indexes for table `Clients`
--
ALTER TABLE `Clients`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Genre`
--
ALTER TABLE `Genre`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `User` (`user`);

--
-- Indexes for table `Publishers`
--
ALTER TABLE `Publishers`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `Authors`
--
ALTER TABLE `Authors`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT dla tabeli `Books`
--
ALTER TABLE `Books`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `Clients`
--
ALTER TABLE `Clients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT dla tabeli `Genre`
--
ALTER TABLE `Genre`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT dla tabeli `Orders`
--
ALTER TABLE `Orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT dla tabeli `Publishers`
--
ALTER TABLE `Publishers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT dla tabeli `Users`
--
ALTER TABLE `Users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Books`
--
ALTER TABLE `Books`
  ADD CONSTRAINT `Books_ibfk_1` FOREIGN KEY (`author`) REFERENCES `Authors` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Books_ibfk_2` FOREIGN KEY (`publisher`) REFERENCES `Publishers` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `Books_ibfk_3` FOREIGN KEY (`genre`) REFERENCES `Genre` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

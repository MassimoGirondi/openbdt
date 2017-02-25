-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Lug 15, 2015 alle 17:44
-- Versione del server: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `openbdt`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `abilita`
--

CREATE TABLE IF NOT EXISTS `abilita` (
`ID` int(11) NOT NULL,
  `User_id` int(11) NOT NULL,
  `Categoria` int(11) NOT NULL,
  `SubCategoria` int(11) NOT NULL,
  `Note` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `bug_reports`
--

CREATE TABLE IF NOT EXISTS `bug_reports` (
  `ID` int(11) NOT NULL,
  `Descrizione` varchar(250) NOT NULL,
  `Data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `Categorie`
--

CREATE TABLE IF NOT EXISTS `Categorie` (
`ID` int(11) NOT NULL,
  `Nome` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Categorie`
--

INSERT INTO `Categorie` (`ID`, `Nome`) VALUES
(0, 'ALTRO'),
(1, 'ASSISTENZA'),
(2, 'BENESSERE E CURA DELLA PERSONA'),
(3, 'CASA'),
(4, 'CONSULENZE'),
(5, 'CUCINA'),
(6, 'HOBBY'),
(7, 'INFORMATICA'),
(8, 'LEZIONI'),
(9, 'ORTO E GIARDINO');

-- --------------------------------------------------------

--
-- Struttura della tabella `feed`
--

CREATE TABLE IF NOT EXISTS `feed` (
  `Titolo` varchar(50) NOT NULL,
  `Contenuto` text NOT NULL,
  `Data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
`ID` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `scambi`
--

CREATE TABLE IF NOT EXISTS `scambi` (
`id` int(11) NOT NULL,
  `fornitore` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `ore` decimal(11,2) NOT NULL,
  `data` date NOT NULL,
  `descrizione` text NOT NULL,
  `ok` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `subCategorie`
--

CREATE TABLE IF NOT EXISTS `subCategorie` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(150) NOT NULL,
  `Padre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `subCategorie`
--

INSERT INTO `subCategorie` (`ID`, `Nome`, `Padre`) VALUES
(0, 'Prestito Oggetti', 0),
(0, 'Accompagnamento cinema/mostre/musei', 1),
(0, 'Iniezioni Intramuscolari', 2),
(0, 'Gestione della cantina', 3),
(0, 'Bollette energetiche', 4),
(0, 'Assistenza cucina e dolci', 5),
(0, 'Decoupage', 6),
(0, 'Assistenza PC', 7),
(0, 'Inglese', 8),
(0, 'Giardinaggio', 9),
(1, 'Attivit&agrave; gestionali BDT', 0),
(1, 'Assitenza ospedaliera', 1),
(1, 'Iridologia, naturopatia e floriterapia', 2),
(1, 'Manutenzione Tapparelle', 3),
(1, 'Design - interni - arredo', 4),
(1, 'Pasticceria casalinga', 5),
(1, 'Disegno tecnica quadri', 6),
(1, 'Consulenza Informatica', 7),
(1, 'Office', 8),
(1, 'Orti Siniergici', 9),
(2, 'Attivit&agrave; non in elenco', 0),
(2, 'Baby Sitter', 1),
(2, 'Messa in piega', 2),
(2, 'Manutenzioni casalinghe', 3),
(2, 'Risparmio eneregetico', 4),
(2, 'Intaglio su carta', 6),
(2, 'Consulenza network marketing', 7),
(2, 'Ripetizioni per scuole elementari', 8),
(3, 'Car Pooling', 0),
(3, 'Compagnia anziani', 1),
(3, 'Piccole manutenzioni elettriche', 3),
(3, 'Lavori a maglia base', 6),
(3, 'Dattilografia', 7),
(3, 'Ripetizioni per scuole medie', 8),
(4, 'Dog Sitter', 1),
(4, 'Piccole manutenzioni idrauliche', 3),
(4, 'Lavoro a ferri', 6),
(4, 'Social Network', 7),
(5, 'Lettura storie bimbi', 1),
(5, 'Ristrutturazione bagno', 3),
(5, 'Mastro birraio', 6),
(6, 'Pianificazione viaggi', 1),
(6, 'Origami', 6),
(7, 'Spesa', 1),
(7, 'Punto croce', 6),
(8, 'Trasporto persone', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `login` varchar(11) NOT NULL,
  `nome` varchar(15) NOT NULL,
  `cognome` varchar(15) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `cellulare` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `data_rinnovo` date NOT NULL,
  `tassa` int(15) NOT NULL DEFAULT 0,
  `priv` int(11) NOT NULL DEFAULT -1,
  `cf` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `login`, `nome`, `cognome`, `mail`, `cellulare`, `password`, `data_rinnovo`, `tassa`, `priv`, `cf`) VALUES
(-1, 'Eliminato', 'Utente', 'Rimosso', 'eliminato@eliminato.el', '123456', '123456', '2014-11-12', 0, -1, 'CodiceFiscale123'),
(1, 'banca', 'Banca del tempo', 'Nome Paese', 'bdt@bdt.org', '1234', 'passworddellabanca', '2014-09-26', 0, -1, 'CodiceFiscale123'),
(2, 'admin', 'Admin', 'Admin', 'admin@bdt.org', '123123123', '5f4dcc3b5aa765d61d8327deb882cf99', '2014-09-27', 0, 2, 'CodiceFiscale123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abilita`
--
ALTER TABLE `abilita`
 ADD PRIMARY KEY (`ID`), ADD KEY `user` (`User_id`), ADD KEY `SubCategoria` (`SubCategoria`,`Categoria`), ADD KEY `cat` (`Categoria`,`SubCategoria`);

--
-- Indexes for table `bug_reports`
--
ALTER TABLE `bug_reports`
 ADD PRIMARY KEY (`ID`,`Data`);

--
-- Indexes for table `Categorie`
--
ALTER TABLE `Categorie`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `scambi`
--
ALTER TABLE `scambi`
 ADD PRIMARY KEY (`id`), ADD KEY `f` (`fornitore`), ADD KEY `c` (`cliente`);

--
-- Indexes for table `subCategorie`
--
ALTER TABLE `subCategorie`
 ADD PRIMARY KEY (`ID`,`Padre`), ADD KEY `ID` (`ID`), ADD KEY `Padre` (`Padre`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abilita`
--
ALTER TABLE `abilita`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `Categorie`
--
ALTER TABLE `Categorie`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `scambi`
--
ALTER TABLE `scambi`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `abilita`
--
ALTER TABLE `abilita`
ADD CONSTRAINT `abilita_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `users` (`id`),
ADD CONSTRAINT `cat` FOREIGN KEY (`Categoria`, `SubCategoria`) REFERENCES `subCategorie` (`Padre`, `ID`);

--
-- Limiti per la tabella `bug_reports`
--
ALTER TABLE `bug_reports`
ADD CONSTRAINT `bug_reports_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `scambi`
--
ALTER TABLE `scambi`
ADD CONSTRAINT `scambi_ibfk_1` FOREIGN KEY (`fornitore`) REFERENCES `users` (`id`),
ADD CONSTRAINT `scambi_ibfk_2` FOREIGN KEY (`cliente`) REFERENCES `users` (`id`);

--
-- Limiti per la tabella `subCategorie`
--
ALTER TABLE `subCategorie`
ADD CONSTRAINT `subCategorie_ibfk_1` FOREIGN KEY (`Padre`) REFERENCES `Categorie` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

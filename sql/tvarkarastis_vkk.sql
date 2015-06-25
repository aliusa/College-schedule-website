SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `auditorija` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(45) NOT NULL,
  `skyrius_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `dalykas` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `arPaskaita` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `destytojas` (
  `id` int(11) NOT NULL,
  `vardas` varchar(45) NOT NULL,
  `pavarde` varchar(45) NOT NULL,
  `elpastas` varchar(255) DEFAULT NULL,
  `prisijungimas` char(8) DEFAULT NULL,
  `slaptazodis` varchar(255) DEFAULT NULL,
  `teises` tinyint(1) NOT NULL DEFAULT '0',
  `paslepti` tinyint(1) DEFAULT '0',
  `tekstas` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `forma` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `grupe` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(10) NOT NULL,
  `elpastas` varchar(255) DEFAULT NULL,
  `skyrius_id` int(11) NOT NULL,
  `forma_id` int(11) NOT NULL,
  `studijos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pabaigoslaikas` (
  `id` int(11) NOT NULL,
  `laikas` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `paskaitos_tipas` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `pradzioslaikas` (
  `id` int(11) NOT NULL,
  `laikas` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `skyrius` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `studijos` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tvarkarastis` (
  `id` int(11) NOT NULL,
  `diena` date DEFAULT NULL,
  `pradzioslaikas_id` int(11) NOT NULL,
  `pabaigoslaikas_id` int(11) NOT NULL,
  `grupe_id` int(11) DEFAULT NULL,
  `pogrupis` tinyint(1) NOT NULL DEFAULT '0',
  `dalykas_id` int(11) NOT NULL,
  `destytojas_id` int(11) NOT NULL,
  `auditorija_id` int(11) NOT NULL,
  `paskaitos_tipas_id` int(11) NOT NULL,
  `pasirenkamasis` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `auditorija`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_auditorija_skyrius1_idx` (`skyrius_id`);

ALTER TABLE `dalykas`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `pavadinimas_UNIQUE` (`pavadinimas`);

ALTER TABLE `destytojas`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `prisijungimas` (`prisijungimas`), ADD UNIQUE KEY `slaptazodis` (`slaptazodis`);

ALTER TABLE `forma`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `pavadinimas_UNIQUE` (`pavadinimas`);

ALTER TABLE `grupe`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_grupe_skyrius1_idx` (`skyrius_id`), ADD KEY `fk_grupe_forma1_idx` (`forma_id`), ADD KEY `fk_grupe_studijos1_idx` (`studijos_id`);

ALTER TABLE `pabaigoslaikas`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `laikas_UNIQUE` (`laikas`);

ALTER TABLE `paskaitos_tipas`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `pavadinimas_UNIQUE` (`pavadinimas`);

ALTER TABLE `pradzioslaikas`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `laikas_UNIQUE` (`laikas`);

ALTER TABLE `skyrius`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `pavadinimas_UNIQUE` (`pavadinimas`);

ALTER TABLE `studijos`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `pavadinimas_UNIQUE` (`pavadinimas`);

ALTER TABLE `tvarkarastis`
  ADD PRIMARY KEY (`id`), ADD KEY `fk_tvarkarastis_dalykas_idx` (`dalykas_id`), ADD KEY `fk_tvarkarastis_destytojas1_idx` (`destytojas_id`), ADD KEY `fk_tvarkarastis_auditorija1_idx` (`auditorija_id`), ADD KEY `fk_tvarkarastis_grupe1_idx` (`grupe_id`), ADD KEY `fk_tvarkarastis_paskaitos_tipas1_idx` (`paskaitos_tipas_id`), ADD KEY `fk_tvarkarastis_pradzioslaikas1_idx` (`pradzioslaikas_id`), ADD KEY `fk_tvarkarastis_pabaigoslaikas1_idx` (`pabaigoslaikas_id`);


ALTER TABLE `auditorija`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `dalykas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `destytojas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `forma`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `grupe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pabaigoslaikas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `paskaitos_tipas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pradzioslaikas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `skyrius`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `studijos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `tvarkarastis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

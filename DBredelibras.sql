-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 02, 2020 at 06:29 PM
-- Server version: 10.1.26-MariaDB-0+deb9u1
-- PHP Version: 7.0.33-0+deb9u3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `DBredelibras`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbCidades`
--

CREATE TABLE `tbCidades` (
	  `ID` int(11) NOT NULL,
	  `id_estado` int(11) DEFAULT NULL,
	  `nome_cidade` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbEmail`
--

CREATE TABLE `tbEmail` (
	  `ID` int(11) NOT NULL,
	  `id_sprestador` int(11) NOT NULL,
	  `email` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbEndereco`
--

CREATE TABLE `tbEndereco` (
	  `ID` int(11) NOT NULL,
	  `id_sprestador` int(11) NOT NULL,
	  `endereco` varchar(150) DEFAULT NULL,
	  `complemento` varchar(20) DEFAULT NULL,
	  `bairro` varchar(50) DEFAULT NULL,
	  `id_cidade` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbEspecialidades`
--

CREATE TABLE `tbEspecialidades` (
	  `ID` int(11) NOT NULL,
	  `especialidade` varchar(512) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbEstados`
--

CREATE TABLE `tbEstados` (
	  `ID` int(11) NOT NULL,
	  `id_capital` int(11) DEFAULT NULL,
	  `nome_estado` varchar(20) DEFAULT NULL,
	  `sigla_estado` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbPEspecialidade`
--

CREATE TABLE `tbPEspecialidade` (
	  `ID` int(11) NOT NULL,
	  `id_sprestador` int(11) NOT NULL,
	  `id_especialidade` int(11) NOT NULL,
	  `descricao` varchar(256) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbTelefone`
--

CREATE TABLE `tbTelefone` (
	  `ID` int(11) NOT NULL,
	  `id_sprestador` int(11) NOT NULL,
	  `telefone` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbUsuario`
--

CREATE TABLE `tbUsuario` (
	  `ID` int(11) NOT NULL,
	  `login` varchar(64) NOT NULL,
	  `senha` varchar(256) NOT NULL,
	  `nome` varchar(256) DEFAULT NULL,
	  `foto` blob NOT NULL,
	  `rank` decimal(1,1) DEFAULT NULL,
	  `tipo` char(1) DEFAULT NULL,
	  `ativo` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbCidades`
--
ALTER TABLE `tbCidades`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indexes for table `tbEmail`
--
ALTER TABLE `tbEmail`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_sprestador` (`id_sprestador`);

--
-- Indexes for table `tbEndereco`
--
ALTER TABLE `tbEndereco`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_sprestador` (`id_sprestador`),
  ADD KEY `id_cidade` (`id_cidade`);

--
-- Indexes for table `tbEspecialidades`
--
ALTER TABLE `tbEspecialidades`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbEstados`
--
ALTER TABLE `tbEstados`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbPEspecialidade`
--
ALTER TABLE `tbPEspecialidade`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_sprestador` (`id_sprestador`),
  ADD KEY `id_especialidade` (`id_especialidade`);

--
-- Indexes for table `tbTelefone`
--
ALTER TABLE `tbTelefone`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `id_sprestador` (`id_sprestador`);

--
-- Indexes for table `tbUsuario`
--
ALTER TABLE `tbUsuario`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbCidades`
--
ALTER TABLE `tbCidades`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5539;
--
-- AUTO_INCREMENT for table `tbEmail`
--
ALTER TABLE `tbEmail`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=561;
--
-- AUTO_INCREMENT for table `tbEndereco`
--
ALTER TABLE `tbEndereco`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT for table `tbEspecialidades`
--
ALTER TABLE `tbEspecialidades`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tbEstados`
--
ALTER TABLE `tbEstados`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `tbPEspecialidade`
--
ALTER TABLE `tbPEspecialidade`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=390;
--
-- AUTO_INCREMENT for table `tbTelefone`
--
ALTER TABLE `tbTelefone`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=625;
--
-- AUTO_INCREMENT for table `tbUsuario`
--
ALTER TABLE `tbUsuario`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=583;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbCidades`
--
ALTER TABLE `tbCidades`
  ADD CONSTRAINT `tbCidades_ibfk_1` FOREIGN KEY (`id_estado`) REFERENCES `tbEstados` (`ID`);

--
-- Constraints for table `tbEmail`
--
ALTER TABLE `tbEmail`
  ADD CONSTRAINT `tbEmail_ibfk_1` FOREIGN KEY (`id_sprestador`) REFERENCES `tbUsuario` (`ID`);

--
-- Constraints for table `tbEndereco`
--
ALTER TABLE `tbEndereco`
  ADD CONSTRAINT `tbEndereco_ibfk_1` FOREIGN KEY (`id_sprestador`) REFERENCES `tbUsuario` (`ID`),
  ADD CONSTRAINT `tbEndereco_ibfk_2` FOREIGN KEY (`id_cidade`) REFERENCES `tbCidades` (`ID`);

--
-- Constraints for table `tbPEspecialidade`
--
ALTER TABLE `tbPEspecialidade`
  ADD CONSTRAINT `tbPEspecialidade_ibfk_1` FOREIGN KEY (`id_sprestador`) REFERENCES `tbUsuario` (`ID`),
  ADD CONSTRAINT `tbPEspecialidade_ibfk_2` FOREIGN KEY (`id_especialidade`) REFERENCES `tbEspecialidades` (`ID`);

--
-- Constraints for table `tbTelefone`
--
ALTER TABLE `tbTelefone`
  ADD CONSTRAINT `tbTelefone_ibfk_1` FOREIGN KEY (`id_sprestador`) REFERENCES `tbUsuario` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


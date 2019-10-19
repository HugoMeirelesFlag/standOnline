-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 08-Jan-2019 às 22:26
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `standvirtual`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `automoveis`
--

CREATE TABLE `automoveis` (
  `marca` tinyint(3) UNSIGNED NOT NULL,
  `modelo` tinyint(3) UNSIGNED NOT NULL,
  `ano` varchar(4) NOT NULL,
  `mes` varchar(2) NOT NULL,
  `cilindrada` varchar(10) NOT NULL,
  `potencia` varchar(10) NOT NULL,
  `combustivel` varchar(1) NOT NULL,
  `kms` varchar(9) NOT NULL,
  `preco` varchar(12) NOT NULL,
  `cor` varchar(40) NOT NULL,
  `n_portas` varchar(1) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `titulo` varchar(80) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `destaque` varchar(1) NOT NULL,
  `jantes_liga_leve` varchar(1) NOT NULL,
  `direcao_assistida` varchar(1) NOT NULL,
  `fecho_central` varchar(1) NOT NULL,
  `eps` varchar(1) NOT NULL,
  `ar_condicionado` varchar(1) NOT NULL,
  `vidros_eletricos` varchar(1) NOT NULL,
  `computador_bordo` varchar(1) NOT NULL,
  `farois_nevoeiro` varchar(1) NOT NULL,
  `livro_revisoes` varchar(1) NOT NULL,
  `foto1` varchar(30) NOT NULL,
  `foto2` varchar(30) NOT NULL,
  `foto3` varchar(30) NOT NULL,
  `foto4` varchar(30) NOT NULL,
  `foto5` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE `marcas` (
  `cod_marca` tinyint(3) UNSIGNED NOT NULL,
  `marca` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `marcas`
--

INSERT INTO `marcas` (`cod_marca`, `marca`) VALUES
(1, 'Alfa Romeo'),
(2, 'Aston Martin'),
(3, 'Audi'),
(4, 'Austin Morris'),
(5, 'Bentley'),
(6, 'BMW'),
(7, 'Chevrolet'),
(8, 'Chrysler'),
(9, 'Citroën'),
(10, 'Dacia'),
(11, 'Daewoo'),
(12, 'Daihatsu'),
(13, 'Dodge'),
(14, 'DS'),
(15, 'Ferrari'),
(16, 'Fiat'),
(17, 'Ford'),
(18, 'GMC'),
(19, 'Honda'),
(20, 'Hummer'),
(21, 'Hyundai'),
(22, 'Isuzu'),
(23, 'Jaguar'),
(24, 'Jeep'),
(25, 'Kia'),
(26, 'Lada'),
(27, 'Lamborghini'),
(28, 'Lancia'),
(29, 'Land Rover'),
(30, 'Lexus'),
(31, 'Lotus'),
(32, 'Maserati'),
(33, 'Mazda'),
(34, 'Mercedes-Benz'),
(35, 'MG'),
(36, 'MINI'),
(37, 'Mitsubishi'),
(38, 'Nissan'),
(39, 'Opel'),
(40, 'Peugeot'),
(41, 'Porsche'),
(42, 'Renault'),
(43, 'Rolls Royce'),
(44, 'Rover'),
(45, 'Saab'),
(46, 'Seat'),
(47, 'Skoda'),
(48, 'Smart'),
(49, 'SsangYong'),
(50, 'Subaru'),
(51, 'Suzuki'),
(52, 'Tata'),
(53, 'Toyota'),
(54, 'UMM'),
(55, 'Vauxhall'),
(56, 'Volvo'),
(57, 'VW');

-- --------------------------------------------------------

--
-- Estrutura da tabela `modelos`
--

CREATE TABLE `modelos` (
  `cod_modelo` tinyint(3) UNSIGNED NOT NULL,
  `modelo` varchar(20) NOT NULL,
  `marca` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `modelos`
--

INSERT INTO `modelos` (`cod_modelo`, `modelo`, `marca`) VALUES
(1, '146', 1),
(2, '156', 1),
(3, 'Giulia', 1),
(4, 'Série 1', 6),
(5, 'Série 2', 6),
(6, 'Série 3', 6),
(7, 'Série 4', 6),
(8, 'Série 5', 6),
(9, 'Série 6', 6),
(10, 'Série 7', 6),
(11, 'Clio', 42),
(12, 'Mégane', 42);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizadores`
--

CREATE TABLE `utilizadores` (
  `codigo_utilizador` mediumint(8) UNSIGNED NOT NULL,
  `nome_utilizador` varchar(80) NOT NULL,
  `email` varchar(40) NOT NULL,
  `morada_utilizador` varchar(80) NOT NULL,
  `localidade_utilizador` varchar(40) NOT NULL,
  `cp_utilizador` varchar(40) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `estado` varchar(1) NOT NULL,
  `perfil` varchar(1) NOT NULL,
  `data_registo` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Extraindo dados da tabela `utilizadores`
--

INSERT INTO `utilizadores` (`codigo_utilizador`, `nome_utilizador`, `email`, `morada_utilizador`, `localidade_utilizador`, `cp_utilizador`, `telefone`, `senha`, `estado`, `perfil`, `data_registo`) VALUES
(3, 'hugos', 'hugos@gmail.com', 'ruas', 'perafitas', '4444-555rafitas', '912191410', '$2y$10$ohA6yMKHS7d4NkcUJ4sGEeC48bzkPRP0DXRGKxOb5JyCKs5I.uoEm', 'R', 'A', '2019-01-08 20:47:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `automoveis`
--
ALTER TABLE `automoveis`
  ADD KEY `modelo` (`modelo`);

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`cod_marca`);

--
-- Indexes for table `modelos`
--
ALTER TABLE `modelos`
  ADD PRIMARY KEY (`cod_modelo`),
  ADD KEY `marca` (`marca`);

--
-- Indexes for table `utilizadores`
--
ALTER TABLE `utilizadores`
  ADD PRIMARY KEY (`codigo_utilizador`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `utilizadores`
--
ALTER TABLE `utilizadores`
  MODIFY `codigo_utilizador` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `modelos`
--
ALTER TABLE `modelos`
  ADD CONSTRAINT `marca` FOREIGN KEY (`marca`) REFERENCES `marcas` (`cod_marca`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

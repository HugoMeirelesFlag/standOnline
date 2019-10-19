-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 04-Fev-2016 às 20:16
-- Versão do servidor: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `standvirtual`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `marcas`
--

CREATE TABLE IF NOT EXISTS `marcas` (
`cod_marca` tinyint(3) unsigned NOT NULL,
  `marca` varchar(20) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `marcas`
--
ALTER TABLE `marcas`
 ADD PRIMARY KEY (`cod_marca`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `marcas`
--
ALTER TABLE `marcas`
MODIFY `cod_marca` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=58;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

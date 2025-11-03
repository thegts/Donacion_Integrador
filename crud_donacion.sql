-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-06-2025 a las 13:36:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `crud_donacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donaciones`
--

CREATE TABLE `donaciones` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `donacion` varchar(50) NOT NULL,
  `monto` varchar(50) NOT NULL,
  `zona` varchar(50) NOT NULL,
  `comentario` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `donaciones`
--

INSERT INTO `donaciones` (`id`, `name`, `donacion`, `monto`, `zona`, `comentario`) VALUES
(20, 'Jorge', 'Artículos de limpieza', '50', 'Zona 6', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `donadores`
--

CREATE TABLE `donadores` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(20) NOT NULL,
  `fono` varchar(20) NOT NULL,
  `direccion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `donadores`
--

INSERT INTO `donadores` (`id`, `name`, `lastname`, `email`, `fono`, `direccion`) VALUES
(30, 'Sebastian', 'Bermudes', 'samirco@gmail.com', '9832312838', 'Los Olivos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zonas`
--

CREATE TABLE `zonas` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `zona` varchar(50) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `zonas`
--

INSERT INTO `zonas` (`id`, `name`, `zona`, `descripcion`) VALUES
(20, 'Sebastian', 'Zona 2', 'Caja de agua (C6), Chacarilla de Otero (C7), Las F');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `donadores`
--
ALTER TABLE `donadores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `zonas`
--
ALTER TABLE `zonas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `donadores`
--
ALTER TABLE `donadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `zonas`
--
ALTER TABLE `zonas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

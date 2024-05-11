-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 192.168.10.202
-- Tiempo de generación: 09-05-2024 a las 16:43:06
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
-- Base de datos: `insviladegracia`
--
CREATE DATABASE IF NOT EXISTS `insviladegracia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `insviladegracia`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `idProfesor` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`idProfesor`, `nombre`, `apellidos`, `id`) VALUES
(1, 'sergi', 'espuch', 1),
(2, 'bernat', 'torrent', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `faltas_estudiantes`
--

CREATE TABLE `faltas_estudiantes` (
  `idEstudiante` int(11) NOT NULL,
  `Historia` int(11) NOT NULL,
  `Ingles` int(11) NOT NULL,
  `Ciencias` int(11) NOT NULL,
  `Castellano` int(11) NOT NULL,
  `Informatica` int(11) NOT NULL,
  `Catalan` int(11) NOT NULL,
  `Tecnologia` int(11) NOT NULL,
  `Geografia` int(11) NOT NULL,
  `EF` int(11) NOT NULL,
  `Matematicas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `faltas_estudiantes`
INSERT INTO `faltas_estudiantes` (`idEstudiante`, `Historia`, `Ingles`, `Ciencias`, `Castellano`, `Informatica`, `Catalan`, `Tecnologia`, `Geografia`, `EF`, `Matematicas`) VALUES (1, 14, 2, 9, 0, 0, 4, 0, 0, 4, 0);

-- Estructura de tabla para la tabla `horas-asignaturas`
CREATE TABLE `horas_asignaturas` (
  `Historia` int(11) NOT NULL,
  `Ingles` int(11) NOT NULL,
  `Ciencias` int(11) NOT NULL,
  `Castellano` int(11) NOT NULL,
  `Informatica` int(11) NOT NULL,
  `Catalan` int(11) NOT NULL,
  `EF` int(11) NOT NULL,
  `Tecnologia` int(11) NOT NULL,
  `Geografia` int(11) NOT NULL,
  `Matematicas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horas-asignaturas`
--

INSERT INTO `horas_asignaturas` (`Historia`, `Ingles`, `Ciencias`, `Castellano`, `Informatica`, `Catalan`, `EF`, `Tecnologia`, `Geografia`, `Matematicas`) VALUES
(10, 10, 10, 10, 10, 10, 10, 10, 10, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `horario` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `usuario`, `pass`, `horario`) VALUES
(1, 'profesor1', 'contraseña1', 'horario.json'),
(2, 'profesor2', 'contraseña2', 'horario2.json'),
(3, 'profesor3', 'contraseña3', 'horario3.json');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `faltas_estudiantes`
--
ALTER TABLE `faltas_estudiantes`
  ADD PRIMARY KEY (`idEstudiante`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `faltas_estudiantes`
--
ALTER TABLE `faltas_estudiantes`
  ADD CONSTRAINT `faltas_estudiantes_ibfk_1` FOREIGN KEY (`idEstudiante`) REFERENCES `estudiante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
CREATE USER 'admin'@'%' IDENTIFIED BY '12345aA'; 
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%';
ALTER USER 'admin'@'%' IDENTIFIED BY '12345aA';
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

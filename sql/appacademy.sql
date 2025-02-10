-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 19-03-2012 a las 04:55:21
-- Versión del servidor: 5.5.16
-- Versión de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `appacademy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aula`
--

CREATE TABLE IF NOT EXISTS `aula` (
  `idaula` int(2) NOT NULL AUTO_INCREMENT,
  `grado` int(2) NOT NULL,
  `grupo` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idaula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE IF NOT EXISTS `clase` (
  `idmateria` int(2) NOT NULL,
  `idaula` int(2) NOT NULL,
  `iddocente` int(2) NOT NULL,
  `aniolectivo` year(4) NOT NULL,
  PRIMARY KEY (`idmateria`,`idaula`,`iddocente`,`aniolectivo`),
  KEY `idaula_fk` (`idaula`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE IF NOT EXISTS `docente` (
  `iddocente` varchar(10) NOT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) DEFAULT NULL,
  `nombre1` varchar(20) NOT NULL,
  `nombre2` varchar(20) DEFAULT NULL,
  `profesion` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`iddocente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`iddocente`, `apellido1`, `apellido2`, `nombre1`, `nombre2`, `profesion`) VALUES
('123456', 'karen', NULL, 'oliva', NULL, 'ING. DE SISTEMAS'),
('87946029', 'CORTES', 'DIAZ', 'WILLIAM', 'EDUARDO', 'ING. DE SISTEMAS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escala_de_calificacion`
--

CREATE TABLE IF NOT EXISTS `escala_de_calificacion` (
  `tipo_escala` varchar(2) NOT NULL,
  `rango_inferior` decimal(2,0) NOT NULL,
  `rango_superior` decimal(2,0) NOT NULL,
  PRIMARY KEY (`tipo_escala`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE IF NOT EXISTS `estudiante` (
  `idestudiante` varchar(10) NOT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) DEFAULT NULL,
  `nombre1` varchar(20) NOT NULL,
  `nombre2` varchar(20) DEFAULT NULL,
  `sexo` char(1) NOT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `direccion` varchar(20) DEFAULT NULL,
  `fechanac` date DEFAULT NULL,
  `habilitado` char(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idestudiante`),
  KEY `idestudiante_fk` (`idestudiante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

CREATE TABLE IF NOT EXISTS `indicadores` (
  `idindicador` varchar(10) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `idpropietario` varchar(10) NOT NULL,
  `idmateria` int(2) NOT NULL,
  `aniolectivo` year(4) NOT NULL,
  `habilitado` char(1) NOT NULL DEFAULT 'S',
  `compartido` char(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`idindicador`,`tipo`,`idpropietario`,`idmateria`,`aniolectivo`),
  KEY `idpropietario_fk` (`idpropietario`),
  KEY `idmateria_fk2` (`idmateria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia`
--

CREATE TABLE IF NOT EXISTS `materia` (
  `idmateria` int(2) NOT NULL AUTO_INCREMENT,
  `nombre_materia` varchar(30) NOT NULL,
  PRIMARY KEY (`idmateria`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matricula`
--

CREATE TABLE IF NOT EXISTS `matricula` (
  `idestudiante` varchar(10) NOT NULL,
  `tipo_matricula` char(1) NOT NULL DEFAULT 'R',
  `aniolectivo` year(4) NOT NULL,
  `idaula` int(2) NOT NULL,
  PRIMARY KEY (`idestudiante`,`tipo_matricula`,`aniolectivo`,`idaula`),
  KEY `idaula_fk2` (`idaula`),
  KEY `idestudiante_fk2` (`idestudiante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notas`
--

CREATE TABLE IF NOT EXISTS `notas` (
  `idestudiante` varchar(10) NOT NULL,
  `periodo` int(1) NOT NULL,
  `vn` float NOT NULL,
  `fj` int(2) DEFAULT NULL,
  `fsj` int(2) DEFAULT NULL,
  `comportamiento` varchar(2) NOT NULL,
  `observaciones` varchar(50) DEFAULT NULL,
  `tipo_nota` char(1) NOT NULL DEFAULT 'R',
  `aniolectivo` year(4) NOT NULL,
  `idmateria` int(2) NOT NULL,
  PRIMARY KEY (`idestudiante`,`periodo`,`tipo_nota`,`aniolectivo`,`idmateria`),
  KEY `idmateria_fk3` (`idmateria`),
  KEY `idestudiante_fk` (`idestudiante`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `tipousuario` char(1) NOT NULL,
  `idusuario` varchar(10) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `habilitado` char(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`tipousuario`,`idusuario`),
  KEY `idusuario_fk` (`idusuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`tipousuario`, `idusuario`, `contrasena`, `habilitado`) VALUES
('A', '123456', 'e10adc3949ba59abbe56e057f20f883e', 'S'),
('D', '87946029', '72b613b5707b08eeb420f1052665034a', 'S');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `idmateria_fk` FOREIGN KEY (`idmateria`) REFERENCES `materia` (`idmateria`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `idaula_fk` FOREIGN KEY (`idaula`) REFERENCES `aula` (`idaula`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `idpropietario_fk` FOREIGN KEY (`idpropietario`) REFERENCES `docente` (`iddocente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `idmateria_fk2` FOREIGN KEY (`idmateria`) REFERENCES `materia` (`idmateria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `idestudiante_fk2` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`idestudiante`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `idaula_fk2` FOREIGN KEY (`idaula`) REFERENCES `aula` (`idaula`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `notas`
--
ALTER TABLE `notas`
  ADD CONSTRAINT `idestudiante_fk` FOREIGN KEY (`idestudiante`) REFERENCES `estudiante` (`idestudiante`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `idmateria_fk3` FOREIGN KEY (`idmateria`) REFERENCES `materia` (`idmateria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `idusuario_fk` FOREIGN KEY (`idusuario`) REFERENCES `docente` (`iddocente`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

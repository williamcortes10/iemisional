-- phpMyAdmin SQL Dump
-- version 2.9.0.1
-- http://www.phpmyadmin.net
-- 
-- Servidor: localhost
-- Tiempo de generación: 12-04-2012 a las 19:22:17
-- Versión del servidor: 5.0.24
-- Versión de PHP: 5.1.6
-- 
-- Base de datos: `appacademy`
-- 

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `appconfig`
-- 

CREATE TABLE `appconfig` (
  `item` varchar(15) NOT NULL,
  `valor` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `appconfig`
-- 

INSERT INTO `appconfig` VALUES ('aniolect', '2012');
INSERT INTO `appconfig` VALUES ('index_docen_ful', 'of');
INSERT INTO `appconfig` VALUES ('index_docen_nv', 'on');
INSERT INTO `appconfig` VALUES ('index_mi', 'of');
INSERT INTO `appconfig` VALUES ('periodon', '4');
INSERT INTO `appconfig` VALUES ('periodo_hab', '1');
INSERT INTO `appconfig` VALUES ('ie', 'NUESTRA SEÃ‘ORA DE LAS LAJAS');
INSERT INTO `appconfig` VALUES ('direccion', 'CALLE NARIÃ‘O');
INSERT INTO `appconfig` VALUES ('telefono', '234567');
INSERT INTO `appconfig` VALUES ('nit', '123456');
INSERT INTO `appconfig` VALUES ('Lema', 'UN COLEGIO QUE EDUCA A NIÃ‘OS Y JOVENES');
INSERT INTO `appconfig` VALUES ('resol', 'REGISTRO EDUCATIVO No. 35283579611');
INSERT INTO `appconfig` VALUES ('nrector', 'JENNY CARABALI CASTRO');
INSERT INTO `appconfig` VALUES ('dsmin', '');
INSERT INTO `appconfig` VALUES ('dsmax', '');
INSERT INTO `appconfig` VALUES ('damin', '');
INSERT INTO `appconfig` VALUES ('damax', '');
INSERT INTO `appconfig` VALUES ('dbmin', '');
INSERT INTO `appconfig` VALUES ('dbmax', '');
INSERT INTO `appconfig` VALUES ('dbamin', '');
INSERT INTO `appconfig` VALUES ('dbamax', '');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `aula`
-- 

CREATE TABLE `aula` (
  `idaula` int(2) NOT NULL auto_increment,
  `grado` int(2) NOT NULL,
  `grupo` int(1) NOT NULL default '1',
  PRIMARY KEY  (`idaula`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `aula`
-- 

INSERT INTO `aula` VALUES (1, 1, 1);
INSERT INTO `aula` VALUES (2, 2, 1);
INSERT INTO `aula` VALUES (3, 3, 1);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `clase`
-- 

CREATE TABLE `clase` (
  `idmateria` int(2) NOT NULL,
  `idaula` int(2) NOT NULL,
  `iddocente` varchar(10) NOT NULL,
  `ih` int(2) NOT NULL,
  `aniolectivo` year(4) NOT NULL,
  PRIMARY KEY  (`idmateria`,`idaula`,`iddocente`,`aniolectivo`),
  KEY `idaula_fk` (`idaula`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `clase`
-- 

INSERT INTO `clase` VALUES (1, 1, '87946029', 3, 2012);
INSERT INTO `clase` VALUES (2, 1, '87946029', 1, 2012);
INSERT INTO `clase` VALUES (2, 3, '59685059', 3, 2012);
INSERT INTO `clase` VALUES (1, 2, '87946029', 2, 2012);
INSERT INTO `clase` VALUES (2, 3, '87946029', 1, 2012);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `docente`
-- 

CREATE TABLE `docente` (
  `iddocente` varchar(10) NOT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) default NULL,
  `nombre1` varchar(20) NOT NULL,
  `nombre2` varchar(20) default NULL,
  `profesion` varchar(50) default NULL,
  `email` varchar(30) default NULL,
  PRIMARY KEY  (`iddocente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `docente`
-- 

INSERT INTO `docente` VALUES ('59685059', 'ANGULO', 'CASTILLO', 'DIANA', 'MONICA', 'AUX CONTABLE', NULL);
INSERT INTO `docente` VALUES ('87946029', 'CORTES', 'DIAZ', 'WILLIAM', 'EDUARDO', 'ING. DE SISTEMAS', NULL);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `escala_de_calificacion`
-- 

CREATE TABLE `escala_de_calificacion` (
  `tipo_escala` varchar(2) NOT NULL,
  `rango_inferior` decimal(2,0) NOT NULL,
  `rango_superior` decimal(2,0) NOT NULL,
  PRIMARY KEY  (`tipo_escala`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `escala_de_calificacion`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `estudiante`
-- 

CREATE TABLE `estudiante` (
  `idestudiante` varchar(10) NOT NULL,
  `apellido1` varchar(20) NOT NULL,
  `apellido2` varchar(20) default NULL,
  `nombre1` varchar(20) NOT NULL,
  `nombre2` varchar(20) default NULL,
  `sexo` char(1) NOT NULL,
  `telefono` varchar(10) default NULL,
  `direccion` varchar(20) default NULL,
  `fechanac` date default NULL,
  `habilitado` char(1) NOT NULL default 'S',
  PRIMARY KEY  (`idestudiante`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `estudiante`
-- 

INSERT INTO `estudiante` VALUES ('5555555555', 'CORTES2', 'PRECIADO', 'KAREN', 'OLIVA', 'M', NULL, NULL, '0000-00-00', 'S');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `indicadores`
-- 

CREATE TABLE `indicadores` (
  `idindicador` int(11) NOT NULL auto_increment,
  `tipo` varchar(2) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `idpropietario` varchar(10) NOT NULL,
  `idmateria` int(2) NOT NULL,
  `idaula` int(2) NOT NULL,
  `habilitado` char(1) NOT NULL default 'S',
  `compartido` char(1) NOT NULL default 'S',
  PRIMARY KEY  (`idindicador`,`tipo`,`idpropietario`,`idmateria`),
  KEY `idpropietario_fk` (`idpropietario`),
  KEY `idmateria_fk2` (`idmateria`),
  KEY `idaula_fk2` (`idaula`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- 
-- Volcar la base de datos para la tabla `indicadores`
-- 

INSERT INTO `indicadores` VALUES (8, 'DS', 'Reconoce pronombres personales', '87946029', 1, 2, 'S', 'S');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `indicadoresboletin`
-- 

CREATE TABLE `indicadoresboletin` (
  `idindicador` int(11) NOT NULL,
  `iddocente` varchar(10) NOT NULL,
  `aniolectivo` year(4) NOT NULL,
  `periodo` int(11) NOT NULL,
  PRIMARY KEY  (`idindicador`),
  KEY `iddocente_fk` (`iddocente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `indicadoresboletin`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `materia`
-- 

CREATE TABLE `materia` (
  `idmateria` int(2) NOT NULL auto_increment,
  `nombre_materia` varchar(30) NOT NULL,
  PRIMARY KEY  (`idmateria`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Volcar la base de datos para la tabla `materia`
-- 

INSERT INTO `materia` VALUES (1, 'INGLES');
INSERT INTO `materia` VALUES (2, 'LENGUAJE');
INSERT INTO `materia` VALUES (3, 'FISICA');

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `matricula`
-- 

CREATE TABLE `matricula` (
  `idestudiante` varchar(10) NOT NULL,
  `tipo_matricula` char(1) NOT NULL default 'R',
  `aniolectivo` year(4) NOT NULL,
  `idaula` int(2) NOT NULL,
  `periodo` int(1) NOT NULL default '0',
  PRIMARY KEY  (`idestudiante`,`tipo_matricula`,`aniolectivo`,`periodo`),
  KEY `idaula_fk2` (`idaula`),
  KEY `idestudiante_fk2` (`idestudiante`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `matricula`
-- 

INSERT INTO `matricula` VALUES ('5555555555', 'R', 2012, 1, 0);
INSERT INTO `matricula` VALUES ('5555555555', 'N', 2012, 1, 1);
INSERT INTO `matricula` VALUES ('5555555555', 'N', 2012, 1, 2);

-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `notas`
-- 

CREATE TABLE `notas` (
  `idestudiante` varchar(10) NOT NULL,
  `periodo` int(1) NOT NULL,
  `vn` float NOT NULL,
  `fj` int(2) default NULL,
  `fsj` int(2) default NULL,
  `comportamiento` varchar(2) NOT NULL,
  `observaciones` varchar(50) default NULL,
  `tipo_nota` char(1) NOT NULL default 'R',
  `aniolectivo` year(4) NOT NULL,
  `idmateria` int(2) NOT NULL,
  PRIMARY KEY  (`idestudiante`,`periodo`,`tipo_nota`,`aniolectivo`,`idmateria`),
  KEY `idmateria_fk3` (`idmateria`),
  KEY `idestudiante_fk` (`idestudiante`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `notas`
-- 


-- --------------------------------------------------------

-- 
-- Estructura de tabla para la tabla `usuario`
-- 

CREATE TABLE `usuario` (
  `tipousuario` char(1) NOT NULL,
  `idusuario` varchar(10) NOT NULL,
  `contrasena` varchar(100) NOT NULL,
  `habilitado` char(1) NOT NULL default 'S',
  PRIMARY KEY  (`tipousuario`,`idusuario`),
  KEY `idusuario_fk` (`idusuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Volcar la base de datos para la tabla `usuario`
-- 

INSERT INTO `usuario` VALUES ('D', '87946029', 'e6fdc11e47fdb617c7a08a9a7ba4dec4', 'S');

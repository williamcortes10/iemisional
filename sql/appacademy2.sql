SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `mydb`;

-- -----------------------------------------------------
-- Table `mydb`.`estudiante`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`estudiante` (
  `idestudiante` VARCHAR(10) NOT NULL ,
  `apellido1` VARCHAR(20) NOT NULL ,
  `apellido2` VARCHAR(20) NULL ,
  `nombre1` VARCHAR(20) NOT NULL ,
  `nombre2` VARCHAR(20) NULL ,
  `sexo` CHAR(1) NOT NULL ,
  `telefono` VARCHAR(10) NULL ,
  `direccion` VARCHAR(20) NULL ,
  `fechanac` DATE NULL ,
  `habilitado` CHAR(1) NOT NULL DEFAULT 'S' ,
  PRIMARY KEY (`idestudiante`))
ENGINE = InnoDB;

CREATE INDEX `idestudiante_fk` ON `mydb`.`estudiante` (`idestudiante` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`docente`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`docente` (
  `iddocente` VARCHAR(10) NOT NULL ,
  `apellido1` VARCHAR(20) NOT NULL ,
  `apellido2` VARCHAR(20) NULL ,
  `nombre1` VARCHAR(20) NOT NULL ,
  `nombre2` VARCHAR(20) NULL ,
  `profesion` VARCHAR(50) NULL ,
  PRIMARY KEY (`iddocente`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`aula`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`aula` (
  `idaula` INT(2) NOT NULL AUTO_INCREMENT ,
  `grado` INT(2) NOT NULL ,
  `grupo` INT(1) NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`idaula`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`materia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`materia` (
  `idmateria` INT(2) NOT NULL AUTO_INCREMENT ,
  `nombre_materia` VARCHAR(30) NOT NULL ,
  PRIMARY KEY (`idmateria`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`clase`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`clase` (
  `idmateria` INT(2) NOT NULL ,
  `idaula` INT(2) NOT NULL ,
  `iddocente` INT(2) NOT NULL ,
  `aniolectivo` YEAR NOT NULL ,
  PRIMARY KEY (`idmateria`, `idaula`, `iddocente`, `aniolectivo`) ,
  CONSTRAINT `idmateria_fk`
    FOREIGN KEY (`idmateria` )
    REFERENCES `mydb`.`materia` (`idmateria` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `idaula_fk`
    FOREIGN KEY (`idaula` )
    REFERENCES `mydb`.`aula` (`idaula` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`escala_de_calificacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`escala_de_calificacion` (
  `tipo_escala` VARCHAR(2) NOT NULL ,
  `rango_inferior` DECIMAL(2) NOT NULL ,
  `rango_superior` DECIMAL(2) NOT NULL ,
  PRIMARY KEY (`tipo_escala`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`matricula`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`matricula` (
  `idestudiante` VARCHAR(10) NOT NULL ,
  `tipo_matricula` CHAR(1) NOT NULL DEFAULT 'R' ,
  `aniolectivo` YEAR NOT NULL ,
  `idaula` INT(2) NOT NULL ,
  PRIMARY KEY (`idestudiante`, `tipo_matricula`, `aniolectivo`, `idaula`) ,
  CONSTRAINT `idestudiante_fk2`
    FOREIGN KEY (`idestudiante` )
    REFERENCES `mydb`.`estudiante` (`idestudiante` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `idaula_fk2`
    FOREIGN KEY (`idaula` )
    REFERENCES `mydb`.`aula` (`idaula` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `idestudiante_fk2` ON `mydb`.`matricula` (`idestudiante` ASC) ;

CREATE INDEX `idaula_fk2` ON `mydb`.`matricula` (`idaula` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`notas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`notas` (
  `idestudiante` VARCHAR(10) NOT NULL ,
  `periodo` INT(1) NOT NULL ,
  `vn` FLOAT NOT NULL ,
  `fj` INT(2) NULL ,
  `fsj` INT(2) NULL ,
  `comportamiento` VARCHAR(2) NOT NULL ,
  `observaciones` VARCHAR(50) NULL ,
  `tipo_nota` CHAR(1) NOT NULL DEFAULT 'R' ,
  `aniolectivo` YEAR NOT NULL ,
  `idmateria` INT(2) NOT NULL ,
  PRIMARY KEY (`idestudiante`) ,
  CONSTRAINT `idestudiante_fk`
    FOREIGN KEY (`idestudiante` )
    REFERENCES `mydb`.`estudiante` (`idestudiante` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE,
  CONSTRAINT `idmateria_fk3`
    FOREIGN KEY (`idmateria` )
    REFERENCES `mydb`.`materia` (`idmateria` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `idestudiante_fk` ON `mydb`.`notas` (`idestudiante` ASC) ;

CREATE INDEX `idmateria_fk3` ON `mydb`.`notas` () ;

CREATE INDEX `idmateria_fk3` ON `mydb`.`notas` () ;


-- -----------------------------------------------------
-- Table `mydb`.`usuario`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`usuario` (
  `tipousuario` CHAR(1) NOT NULL ,
  `idusuario` VARCHAR(10) NOT NULL ,
  `contasena` VARCHAR(100) NOT NULL ,
  `habilitado` CHAR(1) NOT NULL DEFAULT 'S' ,
  PRIMARY KEY (`tipousuario`, `idusuario`) ,
  CONSTRAINT `idusuario_fk`
    FOREIGN KEY (`idusuario` )
    REFERENCES `mydb`.`docente` (`iddocente` )
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `idusuario_fk` ON `mydb`.`usuario` (`idusuario` ASC) ;


-- -----------------------------------------------------
-- Table `mydb`.`indicadores`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`indicadores` (
  `idindicador` VARCHAR(10) NOT NULL ,
  `tipo` VARCHAR(2) NOT NULL ,
  `descripcion` VARCHAR(100) NOT NULL ,
  `idpropietario` VARCHAR(10) NOT NULL ,
  `idmateria` INT(2) NOT NULL ,
  `aniolectivo` YEAR NOT NULL ,
  `habilitado` CHAR(1) NOT NULL DEFAULT 'S' ,
  `compartido` CHAR(1) NOT NULL DEFAULT 'S' ,
  PRIMARY KEY (`idindicador`, `tipo`, `idpropietario`, `idmateria`, `aniolectivo`) ,
  CONSTRAINT `idpropietario_fk`
    FOREIGN KEY (`idpropietario` )
    REFERENCES `mydb`.`docente` (`iddocente` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `idmateria_fk2`
    FOREIGN KEY (`idmateria` )
    REFERENCES `mydb`.`materia` (`idmateria` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `idpropietario_fk` ON `mydb`.`indicadores` (`idpropietario` ASC) ;

CREATE INDEX `idmateria_fk2` ON `mydb`.`indicadores` (`idmateria` ASC) ;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

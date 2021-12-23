
-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/

-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-11-2020 a las 04:05:16
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.5
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


-- Base de datos: `NOTITAS `

CREATE DATABASE `notitas3` ;
-- ----------------------------------------------------------------

-- Estructura de tabla para la tabla `usuarios`


CREATE TABLE `usuarios`(
  `pasword` varchar(255) PRIMARY KEY NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `username` varchar(40) DEFAULT NULL,
  UNIQUE (`username`)

 ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Estructura de tabla para la tabla `tarea`


CREATE TABLE `tarea` (
 `IDtarea` INT NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL, 
  `fecha` datetime DEFAULT NULL,
  `FecVencimiento` datetime DEFAULT NULL,
   `pasword` varchar(255) NOT NULL,
    PRIMARY KEY (`IDtarea`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Estructura de tabla para la tabla `detalle_tarea` dependiente (tarea)


CREATE TABLE `detalle_tarea` (
   `ID_tarea` INT NOT NULL,
   `prioridad` varchar(15) DEFAULT NULL,
    PRIMARY KEY (`ID_tarea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Indices de la tabla `tarea`
-- usamos cascade para eliminar y actualizar datos en cascada

ALTER TABLE `tarea`
  ADD CONSTRAINT  fk_tarea FOREIGN KEY (`pasword`) REFERENCES usuarios(`pasword`)
   ON DELETE CASCADE
   ON UPDATE CASCADE;

-- Indices de la tabla `detalle_tarea`
-- ALTER TABLE `tarea` ADD UNIQUE(`IDtarea`)
ALTER TABLE `detalle_tarea`
   ADD CONSTRAINT fk_tareasDetalle FOREIGN KEY (`ID_tarea`) REFERENCES  tarea(`IDtarea`)
   ON DELETE CASCADE
   ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;








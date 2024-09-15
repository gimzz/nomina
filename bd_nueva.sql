-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para nomina
CREATE DATABASE IF NOT EXISTS `nomina` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `nomina`;

-- Volcando estructura para tabla nomina.asignaciones
CREATE TABLE IF NOT EXISTS `asignaciones` (
  `id_asignacion` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_asignacion` varchar(50) DEFAULT NULL,
  `valor_asignacion` decimal(10,2) DEFAULT NULL,
  `id_cargos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_asignacion`),
  KEY `id_cargos` (`id_cargos`),
  CONSTRAINT `FK_asignaciones_cargos` FOREIGN KEY (`id_cargos`) REFERENCES `cargos` (`id_cargos`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.asignaciones: ~11 rows (aproximadamente)
INSERT INTO `asignaciones` (`id_asignacion`, `tipo_asignacion`, `valor_asignacion`, `id_cargos`) VALUES
	(1, 'Bono de Referencias de Clientes', 100.00, 1),
	(2, 'Bono de Productividad', 60.00, 1),
	(3, 'Bono de Referencias de Clientes', 50.00, 2),
	(4, 'Bono de Cumplimiento de objetivos', 75.00, 2),
	(5, 'Bono de Productividad', 50.00, 3),
	(6, 'Bonificacion por cumplimiento de objetivos', 100.00, 4),
	(7, 'Bonificacion por referencia de clientes', 75.00, 4),
	(9, 'Bonificacion por Productividad', 75.00, 6),
	(10, 'Bono de Referencias de Clientes', 100.00, 7),
	(11, 'Bono de Cumplimiento de objetivos', 150.00, 7),
	(12, 'Bono de Productividad', 75.00, 8);

-- Volcando estructura para tabla nomina.asignaciones_empleados
CREATE TABLE IF NOT EXISTS `asignaciones_empleados` (
  `id_empleados_asig` int(11) NOT NULL AUTO_INCREMENT,
  `valor_asignacion` decimal(10,0) DEFAULT NULL,
  `cedula_empleado` bigint(20) DEFAULT NULL,
  `fecha_asignacion` date DEFAULT NULL,
  `id_nomina` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_empleados_asig`),
  KEY `cedula_empleado` (`cedula_empleado`),
  KEY `FK_asignaciones_empleados_nomina` (`id_nomina`),
  CONSTRAINT `FK_asignaciones_empleados_empleado` FOREIGN KEY (`cedula_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_asignaciones_empleados_nomina` FOREIGN KEY (`id_nomina`) REFERENCES `nomina` (`id_nomina`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.asignaciones_empleados: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nomina.asistencia
CREATE TABLE IF NOT EXISTS `asistencia` (
  `id_asistencia` int(11) NOT NULL AUTO_INCREMENT,
  `cedula_empleado` bigint(20) DEFAULT NULL,
  `hora_llegada` time DEFAULT NULL,
  `hora_salida` time DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`id_asistencia`),
  KEY `cedula_empleado` (`cedula_empleado`),
  CONSTRAINT `FK_asistencia_empleado` FOREIGN KEY (`cedula_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.asistencia: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nomina.cargos
CREATE TABLE IF NOT EXISTS `cargos` (
  `id_cargos` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cargos` varchar(50) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `monto_a_gana` decimal(10,2) DEFAULT NULL,
  `estado` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`id_cargos`),
  UNIQUE KEY `nombre_cargos` (`nombre_cargos`),
  KEY `id_departamento` (`id_departamento`),
  CONSTRAINT `FK_cargos_departamentos` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departament`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.cargos: ~8 rows (aproximadamente)
INSERT INTO `cargos` (`id_cargos`, `nombre_cargos`, `id_departamento`, `monto_a_gana`, `estado`) VALUES
	(1, 'Gerente de Recursos Humanos', 1, 1500.00, 'Activo'),
	(2, 'Reclutador', 1, 800.00, 'Activo'),
	(3, 'Asistente de Nomina', 1, 700.00, 'Activo'),
	(4, 'Gerente de Asistente Vrituales', 2, 1200.00, 'Activo'),
	(6, 'Asistente virtual Multilingue', 2, 800.00, 'Activo'),
	(7, 'Gerente de Configuracion de Citas', 3, 1300.00, 'Activo'),
	(8, 'Especialista en configuracion de citas', 3, 850.00, 'Activo'),
	(9, 'coordinador', 3, 800.00, 'Activo');

-- Volcando estructura para tabla nomina.deducciones
CREATE TABLE IF NOT EXISTS `deducciones` (
  `id_deducciones` bigint(20) NOT NULL AUTO_INCREMENT,
  `nombre_deduccion` varchar(50) DEFAULT NULL,
  `valor_deduccion` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_deducciones`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.deducciones: ~1 rows (aproximadamente)
INSERT INTO `deducciones` (`id_deducciones`, `nombre_deduccion`, `valor_deduccion`) VALUES
	(1, 'ISLR', 4.00);

-- Volcando estructura para tabla nomina.deducciones_empleado
CREATE TABLE IF NOT EXISTS `deducciones_empleado` (
  `id_deducciones_e` int(11) NOT NULL AUTO_INCREMENT,
  `cedula_empleado` bigint(20) DEFAULT NULL,
  `valor_de_deduccion` varchar(50) DEFAULT NULL,
  `id_nomina` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_deducciones_e`),
  KEY `cedula_empleado` (`cedula_empleado`),
  KEY `FK_deducciones_empleado_nomina` (`id_nomina`),
  CONSTRAINT `FK_deducciones_empleado_empleado` FOREIGN KEY (`cedula_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_deducciones_empleado_nomina` FOREIGN KEY (`id_nomina`) REFERENCES `nomina` (`id_nomina`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.deducciones_empleado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nomina.departamentos
CREATE TABLE IF NOT EXISTS `departamentos` (
  `id_departament` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_departament` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_departament`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.departamentos: ~3 rows (aproximadamente)
INSERT INTO `departamentos` (`id_departament`, `nombre_departament`) VALUES
	(1, 'Recursos Humanos'),
	(2, 'Asistentes Virtuales'),
	(3, 'Configuracion de Citas');

-- Volcando estructura para tabla nomina.empleado
CREATE TABLE IF NOT EXISTS `empleado` (
  `id_empleado` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` bigint(20) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `segundo_n` varchar(50) DEFAULT '  ',
  `apellido` varchar(50) DEFAULT NULL,
  `segundo_a` varchar(50) DEFAULT '  ',
  `direccion` varchar(150) DEFAULT NULL,
  `telefono_fijo` varchar(50) DEFAULT NULL,
  `telefono_personal` varchar(50) DEFAULT NULL,
  `id_cargos` int(11) DEFAULT NULL,
  `id_departamento` int(11) DEFAULT NULL,
  `num_cuenta` varchar(50) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `estados` int(11) DEFAULT NULL,
  `municipio` int(11) DEFAULT NULL,
  `estatus` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`id_empleado`) USING BTREE,
  KEY `cedula` (`cedula`),
  KEY `FK_empleado_cargos` (`id_cargos`),
  KEY `municipio` (`municipio`),
  KEY `FK_empleado_departamentos` (`id_departamento`),
  KEY `estado` (`estados`) USING BTREE,
  CONSTRAINT `FK_empleado_cargos` FOREIGN KEY (`id_cargos`) REFERENCES `cargos` (`id_cargos`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_empleado_departamentos` FOREIGN KEY (`id_departamento`) REFERENCES `departamentos` (`id_departament`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_empleado_estado` FOREIGN KEY (`estados`) REFERENCES `estado` (`id_estado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_empleado_municipio` FOREIGN KEY (`municipio`) REFERENCES `municipio` (`id_municipio`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.empleado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nomina.estado
CREATE TABLE IF NOT EXISTS `estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_estado` varchar(50) DEFAULT NULL,
  `Estatus` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.estado: ~24 rows (aproximadamente)
INSERT INTO `estado` (`id_estado`, `nombre_estado`, `Estatus`) VALUES
	(1, 'Amazonas', 'Activo'),
	(2, 'Anzoategui', 'Activo'),
	(3, 'Apure', 'Activo'),
	(4, 'Aragua', 'Activo'),
	(5, 'Barinas', 'Activo'),
	(6, 'Bolívar', 'Activo'),
	(7, 'Carabobo', 'Activo'),
	(8, 'Cojedes', 'Activo'),
	(9, 'Delta Amacuro', 'Activo'),
	(10, 'Distrito Capital', 'Activo'),
	(11, 'Falcón', 'Activo'),
	(12, 'Guárico', 'Activo'),
	(13, 'Lara', 'Activo'),
	(14, 'Mérida', 'Activo'),
	(15, 'Miranda', 'Activo'),
	(16, 'Monagas', 'Activo'),
	(17, 'Nueva Esparta', 'Activo'),
	(18, 'Portuguesa', 'Activo'),
	(19, 'Sucre', 'Activo'),
	(20, 'Táchira', 'Activo'),
	(21, 'Trujillo', 'Activo'),
	(22, 'La Guaira', 'Activo'),
	(23, 'Yaracuy', 'Activo'),
	(24, 'Zulia', 'Activo');

-- Volcando estructura para tabla nomina.municipio
CREATE TABLE IF NOT EXISTS `municipio` (
  `id_municipio` int(11) NOT NULL AUTO_INCREMENT,
  `id_estado` int(11) DEFAULT NULL,
  `nombre_municipio` varchar(100) DEFAULT NULL,
  `estatus` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`id_municipio`),
  KEY `id_estado` (`id_estado`),
  CONSTRAINT `FK_municipio_estado` FOREIGN KEY (`id_estado`) REFERENCES `estado` (`id_estado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.municipio: ~154 rows (aproximadamente)
INSERT INTO `municipio` (`id_municipio`, `id_estado`, `nombre_municipio`, `estatus`) VALUES
	(1, 1, 'Alto Orinoco (La Esmeralda)', 'Activo'),
	(2, 1, 'Atabapo (San Fernando de Atabapo)', 'Activo'),
	(3, 1, 'Atures (Puerto Ayacucho)', 'Activo'),
	(4, 1, 'Autana (Isla Ratón)  ', 'Activo'),
	(5, 1, 'Manapiare (San Juan de Manapiare)', 'Activo'),
	(6, 1, 'Maroa (Maroa)  ', 'Activo'),
	(7, 1, 'Río Negro (San Carlos de Río Negro)  ', 'Activo'),
	(8, 2, 'Anaco (Anaco)', 'Activo'),
	(9, 2, 'Aragua (Aragua de Barcelona)  ', 'Activo'),
	(10, 2, 'Diego Bautista Urbaneja (Lechería) ', 'Activo'),
	(11, 2, 'Fernando de Peñalver (Puerto Píritu)', 'Activo'),
	(12, 2, 'Francisco de Carmen Carvajal (Valle de Guanape)', 'Activo'),
	(13, 2, 'Francisco de Miranda (Pariaguán)  ', 'Activo'),
	(14, 2, 'Guanta', 'Activo'),
	(15, 2, 'Independencia (Soledad) ', 'Activo'),
	(16, 2, 'José Gregorio Monagas (Mapire)', 'Activo'),
	(17, 2, 'Juan Antonio Sotillo (Puerto la Cruz)', 'Activo'),
	(18, 2, 'Juan Manuel Cajigal (Onoto)', 'Activo'),
	(19, 2, 'Libertad (San Mateo)', 'Activo'),
	(20, 2, 'Manuel Ezequiel Bruzual (Clarines) ', 'Activo'),
	(21, 2, 'Pedro María Freites (Cantaura)', 'Activo'),
	(22, 2, 'Píritu', 'Activo'),
	(23, 2, 'San José de Guanipa ( El Tigrito)', 'Activo'),
	(24, 2, 'San Juan de Capistrano (Boca de Uchire)', 'Activo'),
	(25, 2, 'Santa Ana (Santa Ana)  ', 'Activo'),
	(26, 2, 'Simón Bolívar (Barcelona)', 'Activo'),
	(27, 2, 'Simón Rodríguez (El Tigre)', 'Activo'),
	(28, 2, 'Sir Artur McGregor (El Chaparro)', 'Activo'),
	(29, 3, 'Achaguas', 'Activo'),
	(30, 3, 'Biruaca', 'Activo'),
	(31, 3, 'Muñoz', 'Activo'),
	(32, 3, 'Páez (Guasdualito)  ', 'Activo'),
	(33, 3, 'Pedro Camejo (San Juan de Payara)', 'Activo'),
	(34, 3, 'Rómulo Gallegos (Elorza)', 'Activo'),
	(35, 3, 'San Fernando', 'Activo'),
	(36, 4, 'Bolívar (San Mateo)', 'Activo'),
	(37, 4, 'Camatagua', 'Activo'),
	(38, 4, 'Francisco Linares Alcántara (Santa Rita)', 'Activo'),
	(39, 4, 'Girardot (Maracay)', 'Activo'),
	(40, 4, 'Municipio José Ángel Lamas (Santa Cruz) ', 'Activo'),
	(41, 4, 'José Félix Ribas (La Victoria) ', 'Activo'),
	(42, 4, 'José Rafael Revenga (El Consejo)  ', 'Activo'),
	(43, 4, 'Libertador (Palo Negro)', 'Activo'),
	(44, 4, 'Mario Briceño Iragorry (El Limón) ', 'Activo'),
	(45, 4, 'Ocumare de la Costa de Oro (Ocumare de la Costa) ', 'Activo'),
	(46, 4, 'San Casimiro (San Casimiro)', 'Activo'),
	(47, 4, 'San Sebastián', 'Activo'),
	(48, 4, 'Santiago Mariño (Turmero) ', 'Activo'),
	(49, 4, 'Santos Michelena (Las Tejerías) ', 'Activo'),
	(50, 4, 'Sucre (Cagua)', 'Activo'),
	(51, 4, 'Tovar (Colonia Tovar)', 'Activo'),
	(52, 4, 'Urdaneta (Barbacoas)', 'Activo'),
	(53, 4, 'Zamora (Villa de Cura) ', 'Activo'),
	(54, 5, 'Alberto Arvelo Torrealba (Sabaneta)', 'Activo'),
	(55, 5, 'Andrés Eloy Blanco (El Cantón) ', 'Activo'),
	(56, 5, 'Antonio José de Sucre (Socopo)  ', 'Activo'),
	(57, 5, 'Arismendi', 'Activo'),
	(58, 5, 'Barinas', 'Activo'),
	(59, 5, 'Bolívar', 'Activo'),
	(60, 5, 'Cruz Paredes', 'Activo'),
	(61, 5, 'Ezequiel Zamora (Santa Bárbara)', 'Activo'),
	(62, 5, 'Obispos', 'Activo'),
	(63, 5, 'Pedraza (Ciudad Bolivia)', 'Activo'),
	(64, 5, 'Rojas (Libertad)', 'Activo'),
	(65, 5, 'Sosa (Ciudad de Nutrias)', 'Activo'),
	(66, 6, 'Caroní (Ciudad Guayana)', 'Activo'),
	(67, 6, 'Cedeño (Caicara del Orinoco)', 'Activo'),
	(68, 6, 'El Callao (El Callao) ', 'Activo'),
	(69, 6, 'Gran Sabana (Santa Elena de Uairén)', 'Activo'),
	(70, 6, 'Heres (Ciudad Bolívar)  ', 'Activo'),
	(71, 6, 'Padre Pedro Chien (El Palmar)', 'Activo'),
	(72, 6, 'Piar (Upata)', 'Activo'),
	(73, 6, 'Raúl Leoni (Ciudad Piar)', 'Activo'),
	(74, 6, 'Roscio (Guasipati)  ', 'Activo'),
	(75, 6, 'Sifontes (Tumeremo)', 'Activo'),
	(76, 6, 'Sucre (Maripa)', 'Activo'),
	(77, 7, 'Bejuma', 'Activo'),
	(78, 7, 'Carlos Arvelo (Güigüe)', 'Activo'),
	(79, 7, 'Diego Ibarra (Mariara) ', 'Activo'),
	(80, 7, 'Guacara', 'Activo'),
	(81, 7, 'Juan José Mora (Morón)', 'Activo'),
	(82, 7, 'Libertador (Tocuyito)  ', 'Activo'),
	(83, 7, 'Los Guayos', 'Activo'),
	(84, 7, 'Miranda', 'Activo'),
	(85, 7, 'Montalbán', 'Activo'),
	(86, 7, 'Naguanagua', 'Activo'),
	(87, 7, 'Puerto Cabello', 'Activo'),
	(88, 7, 'San Diego', 'Activo'),
	(89, 7, 'San Joaquín', 'Activo'),
	(90, 7, 'Valencia', 'Activo'),
	(91, 8, 'Anzoátegui (Cojedes)  ', 'Activo'),
	(92, 8, 'El Pao de San Juan Bautista (El Pao)', 'Activo'),
	(93, 8, 'Falcón (Tinaquillo)', 'Activo'),
	(94, 8, 'Girardot (El Baúl)', 'Activo'),
	(95, 8, 'Lima Blanco (Macapo)', 'Activo'),
	(96, 8, 'Ricaurte (Libertad)', 'Activo'),
	(97, 8, 'Rómulo Gallegos (Las Vegas) ', 'Activo'),
	(98, 8, 'San Carlos de Austria (San Carlos)  ', 'Activo'),
	(99, 8, 'Tinaco (Tinaco)', 'Activo'),
	(100, 9, 'Antonio Díaz (Curiapo)  ', 'Activo'),
	(101, 9, 'Casacoima (Sierra Imanominanominanominataca)', 'Activo'),
	(102, 9, 'Pedernales', 'Activo'),
	(103, 9, 'Tucupita', 'Activo'),
	(104, 10, 'Municipio Libertador', 'Activo'),
	(105, 11, 'Acosta (San Juan de los Cayos)', 'Activo'),
	(106, 11, 'Bolívar (San Luis)  ', 'Activo'),
	(107, 11, 'Buchivacoa (Capatárida) ', 'Activo'),
	(108, 11, 'Cacique Manaure (Yaracal)', 'Activo'),
	(109, 11, 'Carirubana (Punto Fijo) ', 'Activo'),
	(110, 11, 'Colina (La Vela de Coro) ', 'Activo'),
	(111, 11, 'Dabajuro', 'Activo'),
	(112, 11, 'Democracia (Pedregal)', 'Activo'),
	(113, 11, 'Falcón (Pueblo Nuevo)', 'Activo'),
	(114, 11, 'Federación (Churuguara)', 'Activo'),
	(115, 11, 'Jacura (Jacura)  ', 'Activo'),
	(116, 11, 'Los Taques (Santa Cruz de Los Taques)', 'Activo'),
	(117, 11, 'Mauroa (Mene de Mauroa)', 'Activo'),
	(118, 11, 'Miranda (Santa Ana de Coro) ', 'Activo'),
	(119, 11, 'Monseñor Iturriza (Chichiriviche)', 'Activo'),
	(120, 11, 'Palmasola', 'Activo'),
	(121, 11, 'Petit (Cabure)', 'Activo'),
	(122, 11, 'Píritu', 'Activo'),
	(123, 11, 'San Francisco', 'Activo'),
	(124, 11, 'Silva (Tucacas)  ', 'Activo'),
	(125, 11, 'San Francisco (Mirimire)', 'Activo'),
	(126, 11, 'Sucre (La Cruz de Taratara)', 'Activo'),
	(127, 11, 'Tocópero (Tocópero)  ', 'Activo'),
	(128, 11, 'Unión (Santa Cruz de Bucaral)', 'Activo'),
	(129, 11, 'Urumaco (Urumaco) ', 'Activo'),
	(130, 11, 'Zamora (Puerto Cumarebo)  ', 'Activo'),
	(131, 12, 'Camaguán', 'Activo'),
	(132, 12, 'Chaguaramas', 'Activo'),
	(133, 12, 'El Socorro', 'Activo'),
	(134, 12, 'Francisco de Miranda (Calabozo)  ', 'Activo'),
	(135, 12, 'José Félix Ribas (Tucupido)  ', 'Activo'),
	(136, 12, 'José Tadeo Monagas (Altagracia de Orituco)', 'Activo'),
	(137, 12, 'Juan Germán Roscio (San Juan de los Morros) ', 'Activo'),
	(138, 12, 'Julián Mellado (El Sombrero)  ', 'Activo'),
	(139, 12, 'Las Mercedes (Las Mercedes)', 'Activo'),
	(140, 12, 'Leonardo Infante (Valle de la Pascua)  ', 'Activo'),
	(141, 12, 'Ortiz', 'Activo'),
	(142, 12, 'Pedro Zaraza (Zaraza)  ', 'Activo'),
	(143, 12, 'San Gerónimo de Guayabal', 'Activo'),
	(144, 12, 'San José de Guaribe', 'Activo'),
	(145, 12, 'Santa María de Ipire', 'Activo'),
	(146, 13, 'Andrés Eloy Blanco (Sanare)  ', 'Activo'),
	(147, 13, 'Crespo (Duaca)', 'Activo'),
	(148, 13, 'Iribarren (Barquisimeto)', 'Activo'),
	(149, 13, 'Jiménez (Quíbor)', 'Activo'),
	(150, 13, 'Morán (El Tocuyo)', 'Activo'),
	(151, 13, 'Palavecino (Cabudare) ', 'Activo'),
	(152, 13, 'Simón Planas (Sarare)', 'Activo'),
	(153, 13, 'Torres (Carora) ', 'Activo'),
	(154, 13, 'Urdaneta (Siquisique)', 'Activo');

-- Volcando estructura para tabla nomina.nomina
CREATE TABLE IF NOT EXISTS `nomina` (
  `id_nomina` int(11) NOT NULL,
  `cedula_empleado` bigint(20) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `total_pago` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_nomina`),
  KEY `cedula_empleado` (`cedula_empleado`),
  CONSTRAINT `FK__empleado` FOREIGN KEY (`cedula_empleado`) REFERENCES `empleado` (`cedula`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.nomina: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nomina.reposo_empleado
CREATE TABLE IF NOT EXISTS `reposo_empleado` (
  `id_reposo` int(11) NOT NULL AUTO_INCREMENT,
  `cedula_reposo` bigint(20) DEFAULT NULL,
  `fecha_final` date DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_reposo`),
  KEY `cedula` (`cedula_reposo`) USING BTREE,
  CONSTRAINT `FK_reposo_empleado_empleado` FOREIGN KEY (`cedula_reposo`) REFERENCES `empleado` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.reposo_empleado: ~0 rows (aproximadamente)

-- Volcando estructura para tabla nomina.rol
CREATE TABLE IF NOT EXISTS `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_rol` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.rol: ~2 rows (aproximadamente)
INSERT INTO `rol` (`id_rol`, `nombre_rol`) VALUES
	(1, 'Administrador'),
	(2, 'Usuario');

-- Volcando estructura para tabla nomina.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `cedula` bigint(20) NOT NULL DEFAULT 0,
  `usuario` varchar(50) DEFAULT NULL,
  `clave` varchar(50) DEFAULT NULL,
  `rol` int(11) DEFAULT 2,
  `estatus` varchar(50) DEFAULT 'Activo',
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `rol` (`rol`),
  CONSTRAINT `FK_usuario_rol` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla nomina.usuario: ~0 rows (aproximadamente)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

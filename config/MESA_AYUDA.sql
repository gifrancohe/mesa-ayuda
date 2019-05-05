-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 05-05-2019 a las 13:21:15
-- Versión del servidor: 5.7.26-0ubuntu0.18.04.1
-- Versión de PHP: 5.6.40-1+ubuntu18.04.1+deb.sury.org+2+will+reach+end+of+life+in+april+2019

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `MESA_AYUDA`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `AREA`
--

CREATE TABLE `AREA` (
  `IDAREA` int(11) NOT NULL,
  `NOMBRE` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `FKEMPLE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `AREA`
--

INSERT INTO `AREA` (`IDAREA`, `NOMBRE`, `FKEMPLE`) VALUES
(1, 'Sistemas', 7),
(2, 'Gestiï¿½n Humana', 1),
(3, 'Mantenimiento', 3),
(4, 'Comercial', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `DETALLEREQ`
--

CREATE TABLE `DETALLEREQ` (
  `IDDETALLEREQ` int(11) NOT NULL,
  `FECHA` date NOT NULL,
  `OBSERVACION` varchar(4000) COLLATE utf8_unicode_ci NOT NULL,
  `FKEMPLE` int(11) NOT NULL,
  `FKREQ` int(11) NOT NULL,
  `FKESTADO` int(11) NOT NULL,
  `FKEMPLEASIG` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `DETALLEREQ`
--

INSERT INTO `DETALLEREQ` (`IDDETALLEREQ`, `FECHA`, `OBSERVACION`, `FKEMPLE`, `FKREQ`, `FKESTADO`, `FKEMPLEASIG`) VALUES
(1, '2019-03-31', 'Primer requisito radicado en la mesa de ayuda', 1, 1, 1, 1),
(2, '2019-03-31', 'Test del radicado', 1, 2, 1, NULL),
(3, '2019-03-31', 'Esto es una prueba de requisito', 1, 3, 1, NULL),
(4, '2019-03-31', 'Test de prueba', 1, 4, 1, NULL),
(5, '2019-03-31', 'Esto es una prueba de requisito, creado desde la mesa de ayuda.', 1, 5, 1, NULL),
(6, '2019-03-31', 'Esto es un test, con toast incluido.', 1, 6, 1, NULL),
(7, '2019-03-31', 'Esto es una prueba de test', 1, 7, 1, NULL),
(8, '2019-03-31', 'Esto es otra pruab', 1, 8, 1, NULL),
(9, '2019-03-31', 'PRueba', 1, 9, 1, NULL),
(10, '2019-04-02', 'Esto es la prueba de un requisito en la mesa de ayuda', 1, 10, 1, 1),
(11, '2019-04-02', 'Test de mensaje', 1, 11, 1, NULL),
(12, '2019-04-02', 'Test fadeOut', 1, 12, 1, NULL),
(13, '2019-04-03', 'Test', 1, 2, 2, NULL),
(14, '2019-04-03', 'Test', 1, 4, 2, NULL),
(15, '2019-04-03', 'Test de requisito de prueba Andres ', 1, 2, 2, NULL),
(16, '2019-04-03', 'Test de requisito de prueba Andres ', 1, 4, 2, NULL),
(17, '2019-04-04', 'Este es el mensaje de soluciÃ³n del caso', 1, 1, 3, NULL),
(18, '2019-04-04', 'Asignado a Giovanny', 1, 10, 2, NULL),
(19, '2019-04-04', 'Se soluciono', 1, 10, 4, 1),
(20, '2019-04-04', 'Se cancelan los requisitos por una prueba', 1, 2, 5, NULL),
(21, '2019-04-04', 'Se cancelan los requisitos por una prueba', 1, 10, 5, NULL),
(22, '2019-04-04', 'Se cancela el requisito', 1, 7, 5, NULL),
(23, '2019-04-04', 'Se cancela el requisito 7 para la prueba de cancelaciÃ³n', 1, 7, 5, NULL),
(24, '2019-04-04', 'Se asigna correctamente el requisito a Giovanny', 1, 4, 2, NULL),
(25, '2019-04-04', 'Se asigna a Gio', 1, 6, 2, 1),
(26, '2019-04-06', 'ttttttttttttttttttttttttttt', 1, 14, 1, NULL),
(27, '2019-04-06', 'Segundo Text', 1, 15, 1, NULL),
(28, '2019-04-06', 'AsignaciÃ³n de prueba', 1, 2, 2, 1),
(29, '2019-04-06', 'AsignaciÃ³n de prueba', 1, 10, 2, 1),
(30, '2019-04-06', 'Primeros casos solucionados', 1, 10, 3, NULL),
(31, '2019-04-06', 'Test de requisito solucionado total', 1, 10, 4, NULL),
(32, '2019-04-06', 'Esto lo debe solucionar Isis', 5, 14, 2, 5),
(33, '2019-04-06', 'Esto ya esta solucionado', 5, 14, 3, NULL),
(34, '2019-04-06', 'Esto es requisito', 1, 16, 1, NULL),
(35, '2019-04-06', 'Este es mi primer requisito', 6, 17, 1, NULL),
(36, '2019-04-06', 'Nuevo requisito', 6, 18, 1, NULL),
(37, '2019-05-04', 'Esto es un nuevo requisito', 1, 19, 1, NULL),
(38, '2019-05-04', 'Esto es un requisito del admin', 7, 20, 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `EMPLEADO`
--

CREATE TABLE `EMPLEADO` (
  `IDEMPLEADO` int(11) NOT NULL,
  `NOMBRE` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `TELEFONO` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `CARGO` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `EMAIL` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `FKAREA` int(11) NOT NULL,
  `FKEMPLE` int(11) DEFAULT NULL,
  `FKUSUARIO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `EMPLEADO`
--

INSERT INTO `EMPLEADO` (`IDEMPLEADO`, `NOMBRE`, `TELEFONO`, `CARGO`, `EMAIL`, `FKAREA`, `FKEMPLE`, `FKUSUARIO`) VALUES
(1, 'Giovanny Franco Herrera', '5047456', 'Web Developer', 'giovannyfrancoherrera@gmail.com', 1, NULL, 8),
(2, 'Natalia Franco Herrera', '3004724127', 'Gerente General', 'natalia@gmail.com', 2, 1, 19),
(3, 'Pipe', '312456', 'Web Developer', 'pipe@gmail.com', 1, NULL, 24),
(4, 'Pipe', '312456', 'Web Developer', 'pipe@unal.edu.co', 1, 1, 25),
(5, 'Isis', '3004724127', 'Ronronear ', 'isis@cat.edu.co', 4, 2, 27),
(6, 'Felipe Restrepo', '3045841519', 'Web Developer', 'pipe@mesaayuda.com', 1, 1, 28),
(7, 'Felipe Ramirez', '3104256640', 'Administrar Sistemas', 'feliperamirez0786@gmail.com', 1, NULL, 29);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ESTADO`
--

CREATE TABLE `ESTADO` (
  `IDESTADO` int(11) NOT NULL,
  `NOMBRE` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `ESTADO`
--

INSERT INTO `ESTADO` (`IDESTADO`, `NOMBRE`) VALUES
(1, 'Radicado'),
(2, 'Asignado'),
(3, 'Solucionado Parcial'),
(4, 'Solucionado Total'),
(5, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `REQUISITO`
--

CREATE TABLE `REQUISITO` (
  `IDREQ` int(11) NOT NULL,
  `FKAREA` int(11) DEFAULT NULL,
  `FKESTADO` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `REQUISITO`
--

INSERT INTO `REQUISITO` (`IDREQ`, `FKAREA`, `FKESTADO`) VALUES
(1, 3, 3),
(2, 1, 2),
(3, 2, 1),
(4, 1, 2),
(5, 2, 1),
(6, 1, 2),
(7, 1, 5),
(8, 2, 1),
(9, 2, 1),
(10, 1, 4),
(11, 2, 1),
(12, 3, 1),
(13, 1, 1),
(14, 4, 3),
(15, 3, 1),
(16, 1, 1),
(17, 3, 1),
(18, 1, 1),
(19, 1, 1),
(20, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `USUARIO`
--

CREATE TABLE `USUARIO` (
  `IDUSUARIO` int(11) NOT NULL,
  `USUARIO` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PASSWORD` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `FECHA_CREADO` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `USUARIO`
--

INSERT INTO `USUARIO` (`IDUSUARIO`, `USUARIO`, `PASSWORD`, `FECHA_CREADO`) VALUES
(1, 'gifrancohe27', 'Mattelsa.2018*', '2019-04-05 05:00:00'),
(8, 'gifrancohe', '$2y$10$7kY9Etei5eh7l69mm2Wpo.l9UA5ZAADm1iEPyiMnCDMMWmlZ7/UDm', '2019-04-05 15:47:47'),
(10, 'lfcruzs', '$2y$10$hBeAmQCZTd2rX/Qdmm0w4eq1/lrgnYvph9ZuoMPHtKeNejgjBP99y', '2019-04-05 19:45:42'),
(13, 'santy', '$2y$10$Z6yUGss41Mi.oWszwM/yDOiMfTB0mkV7yG/cKcBPuFZ4Fo5jbfDWu', '2019-04-05 19:54:12'),
(14, 'stella', '$2y$10$mr1vJcIrDG7clO81yzqVY.M78xFN0zDxoEAweofwdG2AgLhk1pHWq', '2019-04-05 20:01:17'),
(15, 'octavio', '$2y$10$F495wUx01emoxB.LAHJoeu..D035oQsuy9BY7KOVV0RYVFfS7a3g6', '2019-04-05 20:05:58'),
(18, 'natalia', '$2y$10$.uI6GEjUUNT4CRtLrry6RuNsz2FzDDU5GMG6VEHFgEEZDRQykFVNK', '2019-04-05 20:07:44'),
(19, 'natalia1', '$2y$10$x18L/fDijZGCm2KnvHsSj.CHRpmvUO.F9RB7d83fZ4MNbJNpIKLau', '2019-04-05 20:08:49'),
(20, 'pipe', '$2y$10$AqkECnGUjheujm8BviwoGe8LtabHC0Gxntcp2zCKuEmyOn5i2ibf.', '2019-04-05 20:12:29'),
(21, 'pipe1', '$2y$10$hEKxqRCwAfpMGYd8rIoAA.0SzL0/ZjZpYQDFkdPvgVWKSPhOu8TZm', '2019-04-05 20:13:43'),
(22, 'pipe2', '$2y$10$7qqJow5F8UReYIdCrvwRxO7h6y9G0fnL8XWz0Q67brMnS2JZE7mGu', '2019-04-05 20:14:36'),
(23, 'pipe3', '$2y$10$FeL6RDMOuz/MwEnLUp0uueX/eLeBYUCC4F6/YUJyZAOqPtLpMXTPq', '2019-04-05 20:15:16'),
(24, 'pipe4', '$2y$10$2Y7KeylyWUtMQmV4LL71Ke94zZJHHF5gLNRvSaWf8X4L1K07jYOWS', '2019-04-05 20:17:53'),
(25, 'pipe5', '$2y$10$zkj3FS/U3WT1pkABvf1lnuUSEGM4.Kf739JJgVO5OoiqfVDO3N3O6', '2019-04-05 20:18:27'),
(27, 'isis', '$2y$10$6wctKmt4ITqvsD0rbH0G..sHd34pLwvwTdzCrWAMihAvoh11bz6ti', '2019-04-06 13:05:09'),
(28, 'pipeAdmin', '$2y$10$K6XpkCCEWGTvb2gFOx0ZsuXFVC.yTz09eJEuolvUrcNqnwKTUpxD2', '2019-04-06 14:30:45'),
(29, 'admin', '$2y$10$1dj8oAtC9/c2q84XE7qcF.D8NeZQZtQBs5MRhLK5JjuOmGm98f9L6', '2019-05-04 09:47:02');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `AREA`
--
ALTER TABLE `AREA`
  ADD PRIMARY KEY (`IDAREA`),
  ADD KEY `CONS_FKEMPLE` (`FKEMPLE`);

--
-- Indices de la tabla `DETALLEREQ`
--
ALTER TABLE `DETALLEREQ`
  ADD PRIMARY KEY (`IDDETALLEREQ`),
  ADD KEY `CONS_FKEMPLE2` (`FKEMPLE`),
  ADD KEY `CONS_FKREQ` (`FKREQ`),
  ADD KEY `CONS_ESTADO` (`FKESTADO`),
  ADD KEY `CONS_FKEMPLEASIG` (`FKEMPLEASIG`);

--
-- Indices de la tabla `EMPLEADO`
--
ALTER TABLE `EMPLEADO`
  ADD PRIMARY KEY (`IDEMPLEADO`),
  ADD KEY `CONS_FKAREA` (`FKAREA`),
  ADD KEY `CONS_FKEMPLE1` (`FKEMPLE`),
  ADD KEY `CONS_FKUSUARIO` (`FKUSUARIO`);

--
-- Indices de la tabla `ESTADO`
--
ALTER TABLE `ESTADO`
  ADD PRIMARY KEY (`IDESTADO`);

--
-- Indices de la tabla `REQUISITO`
--
ALTER TABLE `REQUISITO`
  ADD PRIMARY KEY (`IDREQ`),
  ADD KEY `CONS_FKAREA1` (`FKAREA`),
  ADD KEY `CONS_FKESTADO` (`FKESTADO`);

--
-- Indices de la tabla `USUARIO`
--
ALTER TABLE `USUARIO`
  ADD PRIMARY KEY (`IDUSUARIO`),
  ADD UNIQUE KEY `USUARIO` (`USUARIO`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `AREA`
--
ALTER TABLE `AREA`
  MODIFY `IDAREA` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `DETALLEREQ`
--
ALTER TABLE `DETALLEREQ`
  MODIFY `IDDETALLEREQ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT de la tabla `EMPLEADO`
--
ALTER TABLE `EMPLEADO`
  MODIFY `IDEMPLEADO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `REQUISITO`
--
ALTER TABLE `REQUISITO`
  MODIFY `IDREQ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT de la tabla `USUARIO`
--
ALTER TABLE `USUARIO`
  MODIFY `IDUSUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `AREA`
--
ALTER TABLE `AREA`
  ADD CONSTRAINT `CONS_FKEMPLE` FOREIGN KEY (`FKEMPLE`) REFERENCES `EMPLEADO` (`IDEMPLEADO`);

--
-- Filtros para la tabla `DETALLEREQ`
--
ALTER TABLE `DETALLEREQ`
  ADD CONSTRAINT `CONS_ESTADO` FOREIGN KEY (`FKESTADO`) REFERENCES `ESTADO` (`IDESTADO`),
  ADD CONSTRAINT `CONS_FKEMPLE2` FOREIGN KEY (`FKEMPLE`) REFERENCES `EMPLEADO` (`IDEMPLEADO`),
  ADD CONSTRAINT `CONS_FKEMPLEASIG` FOREIGN KEY (`FKEMPLEASIG`) REFERENCES `EMPLEADO` (`IDEMPLEADO`),
  ADD CONSTRAINT `CONS_FKREQ` FOREIGN KEY (`FKREQ`) REFERENCES `REQUISITO` (`IDREQ`);

--
-- Filtros para la tabla `EMPLEADO`
--
ALTER TABLE `EMPLEADO`
  ADD CONSTRAINT `CONS_FKAREA` FOREIGN KEY (`FKAREA`) REFERENCES `AREA` (`IDAREA`),
  ADD CONSTRAINT `CONS_FKEMPLE1` FOREIGN KEY (`FKEMPLE`) REFERENCES `EMPLEADO` (`IDEMPLEADO`),
  ADD CONSTRAINT `CONS_FKUSUARIO` FOREIGN KEY (`FKUSUARIO`) REFERENCES `USUARIO` (`IDUSUARIO`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `REQUISITO`
--
ALTER TABLE `REQUISITO`
  ADD CONSTRAINT `CONS_FKAREA1` FOREIGN KEY (`FKAREA`) REFERENCES `AREA` (`IDAREA`),
  ADD CONSTRAINT `CONS_FKESTADO` FOREIGN KEY (`FKESTADO`) REFERENCES `ESTADO` (`IDESTADO`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

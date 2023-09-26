-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-09-2023 a las 06:23:14
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lisp1`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `gen_balance_general` ()   begin


declare mov_final integer default 0;
declare mov_fecha date;
declare mov_monto decimal(12,2);
declare mov_tipo varchar(50);
declare mov_mtipo varchar(5);
declare mov_entrada decimal(12,2);
declare mov_salida decimal(12,2);
declare mov_id integer;

declare saldo_anterior decimal(12,2) default 0.0;
declare saldo_actual decimal(12,2);





declare b1 cursor for select id,tipo,fecha,monto,mtipo from movimientos order by fecha asc;

declare continue handler for not found set mov_final=1;

drop TEMPORARY table if exists bal_gen;
create TEMPORARY TABLE bal_gen(
bal_saldo_anterior decimal(18,2),
bal_fecha date,
bal_entrada decimal(18,2),
bal_salida decimal(18,2),
bal_saldo_actual decimal(18,2)
);

open b1;
bucle: LOOP

FETCH b1 into mov_id,mov_tipo,mov_fecha,mov_monto,mov_mtipo;
if mov_final=1 THEN
leave bucle;
end if;

if mov_mtipo='E' THEN
set saldo_actual=saldo_anterior+mov_monto;
set mov_entrada=mov_monto;
set mov_salida=0.0;
ELSE
set saldo_actual=saldo_anterior-mov_monto;
set mov_entrada=0.0;
set mov_salida=mov_monto;
end if;

insert into bal_gen(bal_saldo_anterior,bal_fecha,bal_entrada,bal_salida,bal_saldo_actual) values(saldo_anterior,mov_fecha,mov_entrada,mov_salida,saldo_actual);
set saldo_anterior=saldo_actual;
end loop bucle;
close b1;

select * from bal_gen;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `gen_balance_general_fecha` (IN `fecha_ini` DATE, `fecha_fini` DATE)   begin


declare mov_final integer default 0;
declare mov_fecha date;
declare mov_monto decimal(12,2);
declare mov_tipo varchar(50);
declare mov_mtipo varchar(5);
declare mov_entrada decimal(12,2);
declare mov_salida decimal(12,2);
declare mov_id integer;

declare saldo_anterior decimal(12,2) default 0.0;
declare saldo_actual decimal(12,2);





declare b1 cursor for select id,tipo,fecha,monto,mtipo from movimientos where fecha between fecha_ini and fecha_fini order by fecha asc;

declare continue handler for not found set mov_final=1;

drop TEMPORARY table if exists bal_gen;
create TEMPORARY TABLE bal_gen(
bal_saldo_anterior decimal(18,2),
bal_fecha date,
bal_entrada decimal(18,2),
bal_salida decimal(18,2),
bal_saldo_actual decimal(18,2)
);

open b1;
bucle: LOOP

FETCH b1 into mov_id,mov_tipo,mov_fecha,mov_monto,mov_mtipo;
if mov_final=1 THEN
leave bucle;
end if;

if mov_mtipo='E' THEN
set saldo_actual=saldo_anterior+mov_monto;
set mov_entrada=mov_monto;
set mov_salida=0.0;
ELSE
set saldo_actual=saldo_anterior-mov_monto;
set mov_entrada=0.0;
set mov_salida=mov_monto;
end if;

insert into bal_gen(bal_saldo_anterior,bal_fecha,bal_entrada,bal_salida,bal_saldo_actual) values(saldo_anterior,mov_fecha,mov_entrada,mov_salida,saldo_actual);
set saldo_anterior=saldo_actual;
end loop bucle;
close b1;

select * from bal_gen;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_usuario`
--

CREATE TABLE `datos_usuario` (
  `dus_id` int(11) NOT NULL,
  `dus_usuario` int(11) NOT NULL,
  `dus_nombre` varchar(100) NOT NULL,
  `dus_edad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `datos_usuario`
--

INSERT INTO `datos_usuario` (`dus_id`, `dus_usuario`, `dus_nombre`, `dus_edad`) VALUES
(1, 1, 'EVELING JANETH SANTOS', 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrada`
--

CREATE TABLE `entrada` (
  `ent_id` int(11) NOT NULL,
  `ent_tipo` varchar(50) NOT NULL,
  `ent_monto` decimal(12,2) NOT NULL,
  `ent_fecha` datetime NOT NULL,
  `ent_factura` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `entrada`
--

INSERT INTO `entrada` (`ent_id`, `ent_tipo`, `ent_monto`, `ent_fecha`, `ent_factura`) VALUES
(1, 'PAGO DE SALARIO', '500.00', '2023-09-01 00:00:00', '');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `movimientos`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `movimientos` (
`id` int(11)
,`tipo` varchar(50)
,`fecha` datetime
,`monto` decimal(12,2)
,`mtipo` varchar(1)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `salida`
--

CREATE TABLE `salida` (
  `sal_id` int(11) NOT NULL,
  `sal_tipo` varchar(10) NOT NULL,
  `sal_monto` decimal(12,2) NOT NULL,
  `sal_fecha` datetime NOT NULL,
  `sal_factura` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `salida`
--

INSERT INTO `salida` (`sal_id`, `sal_tipo`, `sal_monto`, `sal_fecha`, `sal_factura`) VALUES
(1, 'FACTURA', '10.00', '2023-09-02 00:00:00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_mov`
--

CREATE TABLE `tipo_mov` (
  `tip_id` int(11) NOT NULL,
  `tip_codigo` varchar(5) NOT NULL,
  `tip_descripcion` varchar(50) NOT NULL,
  `tip_movimiento` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `usr_id` int(11) NOT NULL,
  `usr_nombre` varchar(50) NOT NULL,
  `usr_password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usr_id`, `usr_nombre`, `usr_password`) VALUES
(1, 'esantos', '123');

-- --------------------------------------------------------

--
-- Estructura para la vista `movimientos`
--
DROP TABLE IF EXISTS `movimientos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `movimientos`  AS SELECT `entrada`.`ent_id` AS `id`, `entrada`.`ent_tipo` AS `tipo`, `entrada`.`ent_fecha` AS `fecha`, `entrada`.`ent_monto` AS `monto`, 'E' AS `mtipo` FROM `entrada` union select `salida`.`sal_id` AS `id`,`salida`.`sal_tipo` AS `tipo`,`salida`.`sal_fecha` AS `fecha`,`salida`.`sal_monto` AS `monto`,'S' AS `mtipo` from `salida`  ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  ADD PRIMARY KEY (`dus_id`);

--
-- Indices de la tabla `entrada`
--
ALTER TABLE `entrada`
  ADD PRIMARY KEY (`ent_id`);

--
-- Indices de la tabla `salida`
--
ALTER TABLE `salida`
  ADD PRIMARY KEY (`sal_id`);

--
-- Indices de la tabla `tipo_mov`
--
ALTER TABLE `tipo_mov`
  ADD PRIMARY KEY (`tip_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `datos_usuario`
--
ALTER TABLE `datos_usuario`
  MODIFY `dus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `entrada`
--
ALTER TABLE `entrada`
  MODIFY `ent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `salida`
--
ALTER TABLE `salida`
  MODIFY `sal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_mov`
--
ALTER TABLE `tipo_mov`
  MODIFY `tip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

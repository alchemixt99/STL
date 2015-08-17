-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 17-08-2015 a las 22:25:29
-- Versión del servidor: 5.6.25
-- Versión de PHP: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_stl_logistica`
--
CREATE DATABASE IF NOT EXISTS `bd_stl_logistica` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `bd_stl_logistica`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tb_cancelar_remisiones`
--

CREATE TABLE IF NOT EXISTS `tb_cancelar_remisiones` (
  `cr_id` int(11) NOT NULL,
  `cr_rf_id` int(11) NOT NULL,
  `cr_codigo` int(11) NOT NULL COMMENT 'codigo a cancelar',
  `cr_motivo` varchar(180) NOT NULL,
  `cr_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cr_created` int(11) NOT NULL,
  `cr_estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_fincas`
--

CREATE TABLE IF NOT EXISTS `tbl_fincas` (
  `fi_id` int(11) NOT NULL,
  `fi_codigo` varchar(10) NOT NULL,
  `fi_nombre` varchar(60) NOT NULL,
  `fi_supervisor` varchar(60) NOT NULL,
  `fi_ciudad` varchar(30) NOT NULL,
  `fi_dir` varchar(90) NOT NULL,
  `fi_tel` varchar(30) NOT NULL,
  `fi_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fi_created` int(11) NOT NULL,
  `fi_estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_fincas`
--

INSERT INTO `tbl_fincas` (`fi_id`, `fi_codigo`, `fi_nombre`, `fi_supervisor`, `fi_ciudad`, `fi_dir`, `fi_tel`, `fi_timestamp`, `fi_created`, `fi_estado`) VALUES
(1, '1A008', 'finca 1', 'supervisor 1', 'Cali', 'Cll busquela con KR encuentrela', '55555', '2015-08-17 07:44:51', 1, 1),
(2, '1A002', 'finca abc', 'supervisor abc', 'Sevilla', 'Kr 123', '123456', '2015-08-17 07:45:08', 1, 1),
(3, '1A006', '123', '123', '123', '123', '123', '2015-08-17 07:45:04', 1, 1),
(8, '1A007', '1asd', 'asd', 'asd', 'asd', 'asd', '2015-08-17 07:45:00', 1, 1),
(9, '1A009', '2', '123', '123', '123', '123', '2015-08-17 07:44:25', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_inventario`
--

CREATE TABLE IF NOT EXISTS `tbl_inventario` (
  `in_id` int(11) NOT NULL,
  `in_fi_id` int(11) NOT NULL,
  `in_mt_cubico` int(11) NOT NULL,
  `in_lote` varchar(20) NOT NULL,
  `in_tipo_materia` int(11) NOT NULL COMMENT 'tipo de materia prima: 1=troza , 2=pulpa',
  `in_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `in_created` int(11) NOT NULL,
  `in_estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_inventario`
--

INSERT INTO `tbl_inventario` (`in_id`, `in_fi_id`, `in_mt_cubico`, `in_lote`, `in_tipo_materia`, `in_timestamp`, `in_created`, `in_estado`) VALUES
(1, 1, 400, 'L504', 1, '2015-08-17 08:18:55', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_modulos`
--

CREATE TABLE IF NOT EXISTS `tbl_modulos` (
  `mo_id` int(11) NOT NULL,
  `mo_nombre` varchar(30) NOT NULL,
  `mo_ruta` varchar(60) NOT NULL,
  `mo_descripcion` varchar(180) NOT NULL,
  `mo_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mo_created` int(11) NOT NULL,
  `mo_estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_modulos`
--

INSERT INTO `tbl_modulos` (`mo_id`, `mo_nombre`, `mo_ruta`, `mo_descripcion`, `mo_timestamp`, `mo_created`, `mo_estado`) VALUES
(1, 'Inicio', '../panel/panel.php', 'Inicio', '2015-08-17 17:04:46', 1, 1),
(2, 'Fincas', '../fincas/fincas.php', 'Fincas', '2015-08-17 17:04:51', 1, 1),
(3, 'Inventarios', '../inventarios/inventarios.php', 'Inventarios', '2015-08-17 17:05:02', 1, 1),
(4, 'Remisiones', '../rfisicas/rfisicas.php', 'Remisiones F&iacute;sicas', '2015-08-17 17:05:33', 1, 1),
(5, 'cremisiones', '../cremisiones/cremisiones.php', 'Cancelar Remisi&oacute;n', '2015-08-17 17:07:04', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_per_x_usu`
--

CREATE TABLE IF NOT EXISTS `tbl_per_x_usu` (
  `pxu_id` int(11) NOT NULL,
  `pxu_us_id` int(11) NOT NULL,
  `pxu_pe_id` int(11) NOT NULL,
  `pxu_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pxu_created` int(11) NOT NULL,
  `pxu_estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_per_x_usu`
--

INSERT INTO `tbl_per_x_usu` (`pxu_id`, `pxu_us_id`, `pxu_pe_id`, `pxu_timestamp`, `pxu_created`, `pxu_estado`) VALUES
(1, 1, 1, '2015-08-16 18:34:20', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisos`
--

CREATE TABLE IF NOT EXISTS `tbl_permisos` (
  `pe_id` int(11) NOT NULL,
  `pe_permiso` int(11) NOT NULL,
  `pe_descripcion` varchar(11) NOT NULL,
  `pe_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pe_created` int(11) NOT NULL,
  `pe_estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_permisos`
--

INSERT INTO `tbl_permisos` (`pe_id`, `pe_permiso`, `pe_descripcion`, `pe_timestamp`, `pe_created`, `pe_estado`) VALUES
(1, 1, 'Super Admin', '2015-08-16 18:32:36', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_permisos_x_modulo`
--

CREATE TABLE IF NOT EXISTS `tbl_permisos_x_modulo` (
  `pxm_id` int(11) NOT NULL,
  `pxm_pe_id` int(11) NOT NULL COMMENT 'Id del permiso',
  `pxm_mo_id` int(11) NOT NULL COMMENT 'id del modulo',
  `pxm_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pxm_created` int(11) NOT NULL,
  `pxm_estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_permisos_x_modulo`
--

INSERT INTO `tbl_permisos_x_modulo` (`pxm_id`, `pxm_pe_id`, `pxm_mo_id`, `pxm_timestamp`, `pxm_created`, `pxm_estado`) VALUES
(1, 1, 1, '2015-08-16 18:33:30', 1, 1),
(2, 1, 2, '2015-08-16 22:40:11', 1, 1),
(3, 1, 3, '2015-08-17 08:07:03', 1, 1),
(4, 1, 4, '2015-08-17 08:59:20', 1, 1),
(5, 1, 5, '2015-08-17 17:06:45', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_remisiones_fisicas`
--

CREATE TABLE IF NOT EXISTS `tbl_remisiones_fisicas` (
  `rf_id` int(11) NOT NULL,
  `rf_tipo_doc` varchar(60) NOT NULL,
  `rf_dig_ini` int(11) NOT NULL,
  `rf_dig_fin` int(11) NOT NULL,
  `rf_cant_usados` int(11) NOT NULL,
  `rf_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rf_created` int(11) NOT NULL,
  `rf_estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_remisiones_fisicas`
--

INSERT INTO `tbl_remisiones_fisicas` (`rf_id`, `rf_tipo_doc`, `rf_dig_ini`, `rf_dig_fin`, `rf_cant_usados`, `rf_timestamp`, `rf_created`, `rf_estado`) VALUES
(1, 'ICA Agosto 2015', 5000, 15000, 7500, '2015-08-17 09:19:16', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_usuarios`
--

CREATE TABLE IF NOT EXISTS `tbl_usuarios` (
  `us_id` int(11) NOT NULL,
  `us_cc` bigint(20) NOT NULL,
  `us_tipo` int(11) NOT NULL,
  `us_nombre` varchar(50) NOT NULL,
  `us_usuario` varchar(20) NOT NULL,
  `us_clave` varchar(60) NOT NULL,
  `us_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `us_created` int(11) NOT NULL,
  `us_estado` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tbl_usuarios`
--

INSERT INTO `tbl_usuarios` (`us_id`, `us_cc`, `us_tipo`, `us_nombre`, `us_usuario`, `us_clave`, `us_timestamp`, `us_created`, `us_estado`) VALUES
(1, 1234567890, 0, 'Usuario de pruebas uno', 'uno', 'admin', '2015-08-15 08:35:38', 1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tb_cancelar_remisiones`
--
ALTER TABLE `tb_cancelar_remisiones`
  ADD PRIMARY KEY (`cr_id`);

--
-- Indices de la tabla `tbl_fincas`
--
ALTER TABLE `tbl_fincas`
  ADD PRIMARY KEY (`fi_id`);

--
-- Indices de la tabla `tbl_inventario`
--
ALTER TABLE `tbl_inventario`
  ADD PRIMARY KEY (`in_id`);

--
-- Indices de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  ADD PRIMARY KEY (`mo_id`);

--
-- Indices de la tabla `tbl_per_x_usu`
--
ALTER TABLE `tbl_per_x_usu`
  ADD PRIMARY KEY (`pxu_id`);

--
-- Indices de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  ADD PRIMARY KEY (`pe_id`);

--
-- Indices de la tabla `tbl_permisos_x_modulo`
--
ALTER TABLE `tbl_permisos_x_modulo`
  ADD PRIMARY KEY (`pxm_id`);

--
-- Indices de la tabla `tbl_remisiones_fisicas`
--
ALTER TABLE `tbl_remisiones_fisicas`
  ADD PRIMARY KEY (`rf_id`);

--
-- Indices de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  ADD PRIMARY KEY (`us_id`),
  ADD UNIQUE KEY `us_cc` (`us_cc`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tb_cancelar_remisiones`
--
ALTER TABLE `tb_cancelar_remisiones`
  MODIFY `cr_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `tbl_fincas`
--
ALTER TABLE `tbl_fincas`
  MODIFY `fi_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT de la tabla `tbl_inventario`
--
ALTER TABLE `tbl_inventario`
  MODIFY `in_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_modulos`
--
ALTER TABLE `tbl_modulos`
  MODIFY `mo_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tbl_per_x_usu`
--
ALTER TABLE `tbl_per_x_usu`
  MODIFY `pxu_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_permisos`
--
ALTER TABLE `tbl_permisos`
  MODIFY `pe_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_permisos_x_modulo`
--
ALTER TABLE `tbl_permisos_x_modulo`
  MODIFY `pxm_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tbl_remisiones_fisicas`
--
ALTER TABLE `tbl_remisiones_fisicas`
  MODIFY `rf_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `tbl_usuarios`
--
ALTER TABLE `tbl_usuarios`
  MODIFY `us_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

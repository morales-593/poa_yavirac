-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-12-2025 a las 03:29:19
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `nuevo_poa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos`
--

CREATE TABLE `archivos` (
  `id_archivo` int(11) NOT NULL,
  `id_medio` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `ruta` varchar(500) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecucion`
--

CREATE TABLE `ejecucion` (
  `id_ejecucion` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `cumplimiento` enum('SI','NO','PARCIAL') DEFAULT 'NO',
  `resultado` text DEFAULT NULL,
  `fecha_ejecucion` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejes`
--

CREATE TABLE `ejes` (
  `id_eje` int(11) NOT NULL,
  `nombre_eje` varchar(150) NOT NULL,
  `descripcion_objetivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

CREATE TABLE `indicadores` (
  `id_indicador` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `id_eje` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medios_verificacion`
--

CREATE TABLE `medios_verificacion` (
  `id_medio` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `detalle_medio` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id_plan` int(11) NOT NULL,
  `nombre_elaborado` varchar(150) NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` enum('PENDIENTE','EN_PROCESO','COMPLETADO','INCOMPLETO') DEFAULT 'PENDIENTE',
  `fecha_elaboracion` date NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plan_detalle`
--

CREATE TABLE `plan_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `id_indicador` int(11) NOT NULL,
  `actividades` text NOT NULL,
  `politicas` text DEFAULT NULL,
  `linea_base` decimal(5,2) DEFAULT NULL CHECK (`linea_base` between 0 and 100),
  `metas` text DEFAULT NULL,
  `id_plazo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plazos`
--

CREATE TABLE `plazos` (
  `id_plazo` int(11) NOT NULL,
  `nombre_plazo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id_responsable` int(11) NOT NULL,
  `nombre_responsable` varchar(150) NOT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id_seguimiento` int(11) NOT NULL,
  `id_detalle` int(11) NOT NULL,
  `porcentaje_avance` decimal(5,2) DEFAULT NULL CHECK (`porcentaje_avance` between 0 and 100),
  `observaciones` text DEFAULT NULL,
  `fecha_seguimiento` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas_poa`
--

CREATE TABLE `temas_poa` (
  `id_tema` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombres`, `usuario`, `password`, `estado`, `fecha_creacion`) VALUES
(1, 'Administrador POA', 'admin', '$2y$10$2m0o2vC6UWjtHC6dTbW7bu56f1yZpM4XoV7kRIp/8aG2JRnsO85QC', 'ACTIVO', '2025-12-25 02:27:53');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD PRIMARY KEY (`id_archivo`),
  ADD KEY `id_medio` (`id_medio`);

--
-- Indices de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  ADD PRIMARY KEY (`id_ejecucion`),
  ADD KEY `id_detalle` (`id_detalle`);

--
-- Indices de la tabla `ejes`
--
ALTER TABLE `ejes`
  ADD PRIMARY KEY (`id_eje`);

--
-- Indices de la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD PRIMARY KEY (`id_indicador`),
  ADD KEY `id_eje` (`id_eje`);

--
-- Indices de la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  ADD PRIMARY KEY (`id_medio`),
  ADD KEY `id_detalle` (`id_detalle`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id_plan`),
  ADD KEY `id_responsable` (`id_responsable`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `plan_detalle`
--
ALTER TABLE `plan_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_plan` (`id_plan`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_indicador` (`id_indicador`),
  ADD KEY `id_plazo` (`id_plazo`);

--
-- Indices de la tabla `plazos`
--
ALTER TABLE `plazos`
  ADD PRIMARY KEY (`id_plazo`);

--
-- Indices de la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id_responsable`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`id_seguimiento`),
  ADD KEY `id_detalle` (`id_detalle`);

--
-- Indices de la tabla `temas_poa`
--
ALTER TABLE `temas_poa`
  ADD PRIMARY KEY (`id_tema`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos`
--
ALTER TABLE `archivos`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  MODIFY `id_ejecucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejes`
--
ALTER TABLE `ejes`
  MODIFY `id_eje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `indicadores`
--
ALTER TABLE `indicadores`
  MODIFY `id_indicador` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  MODIFY `id_medio` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plan_detalle`
--
ALTER TABLE `plan_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `plazos`
--
ALTER TABLE `plazos`
  MODIFY `id_plazo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `temas_poa`
--
ALTER TABLE `temas_poa`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos`
--
ALTER TABLE `archivos`
  ADD CONSTRAINT `archivos_ibfk_1` FOREIGN KEY (`id_medio`) REFERENCES `medios_verificacion` (`id_medio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  ADD CONSTRAINT `ejecucion_ibfk_1` FOREIGN KEY (`id_detalle`) REFERENCES `plan_detalle` (`id_detalle`) ON DELETE CASCADE;

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `indicadores_ibfk_1` FOREIGN KEY (`id_eje`) REFERENCES `ejes` (`id_eje`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  ADD CONSTRAINT `medios_verificacion_ibfk_1` FOREIGN KEY (`id_detalle`) REFERENCES `plan_detalle` (`id_detalle`) ON DELETE CASCADE;

--
-- Filtros para la tabla `planes`
--
ALTER TABLE `planes`
  ADD CONSTRAINT `planes_ibfk_1` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  ADD CONSTRAINT `planes_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `plan_detalle`
--
ALTER TABLE `plan_detalle`
  ADD CONSTRAINT `plan_detalle_ibfk_1` FOREIGN KEY (`id_plan`) REFERENCES `planes` (`id_plan`) ON DELETE CASCADE,
  ADD CONSTRAINT `plan_detalle_ibfk_2` FOREIGN KEY (`id_tema`) REFERENCES `temas_poa` (`id_tema`) ON DELETE CASCADE,
  ADD CONSTRAINT `plan_detalle_ibfk_3` FOREIGN KEY (`id_indicador`) REFERENCES `indicadores` (`id_indicador`) ON DELETE CASCADE,
  ADD CONSTRAINT `plan_detalle_ibfk_4` FOREIGN KEY (`id_plazo`) REFERENCES `plazos` (`id_plazo`) ON DELETE SET NULL;

--
-- Filtros para la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`id_detalle`) REFERENCES `plan_detalle` (`id_detalle`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

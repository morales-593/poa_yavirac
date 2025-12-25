-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-12-2025 a las 00:24:58
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

--
-- Volcado de datos para la tabla `ejes`
--

INSERT INTO `ejes` (`id_eje`, `nombre_eje`, `descripcion_objetivo`) VALUES
(1, 'DOCENCIA', 'Capacitar técnica y tecnológicamente a la sociedarl en el áren de turis*co, patrimonio cultural y cai“ieras afines, propiciar la inserción laboral y apoyar el desariollo de las matrices  productivas  y de servicios.'),
(2, 'VINCULACIÓN', 'No cumple con el  elemento esencial 1 referente a la articulación de la planificación de la vinculación con el PEDI.\r\nNo cumple con el elemento esencial 3 referente a la participación de los actores relevantes de la sociedad para la elaboración de la planificación de la vinculación. '),
(3, 'ORGANIZACION', 'El Instituto cumple con todos los elementos esenciales y complementarios de este indicador. Planifica y ejecuta sus relaciones interinstitucionales sobre la base de aprovechar las potencialidades de las mismas para elevar su calidad educativa, y su planificación es coherente con el PEDI y POA en lo que se refiere a la resolución de necesidades institucionales en el área de innovación, capacitación, infraestructura y equipamiento técnico. La planificación de cada acción cuenta con objetivos, procedimientos, participantes y cronograma de ejecución. Las acciones desarrolladas son coherentes con las necesidades institucionales, garantizando el cumplimiento de los objetivos propuestos. Los convenios firmados han sido subidos al aplicativo SIESS, su número cumple con los objetivos trazados en la planificación y sus resultados incluyen homologación de carreras, capacitación de docentes, equipamiento técnico y fortalecimiento de la imagen institucional a través de la red de Arte Culinario. Cuenta con una normativa interna aprobada y vigente, y en el marco de su competencia ha desarrollado acciones de movilidad con resultados tangibles. La Institución presenta convenios con instituciones extranjeras tanto para homologación como para capacitación, garantizando así el cumplimiento de los objetivos trazados en su planificación. ');

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

--
-- Volcado de datos para la tabla `indicadores`
--

INSERT INTO `indicadores` (`id_indicador`, `codigo`, `descripcion`, `id_eje`) VALUES
(1, '1.1.1', 'Planificación estratégica y operativa', 3);

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
  `nombre_plazo` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plazos`
--

INSERT INTO `plazos` (`id_plazo`, `nombre_plazo`, `fecha_inicio`, `fecha_fin`, `estado`) VALUES
(1, 'ANUAL', '0000-00-00', '0000-00-00', 'ACTIVO'),
(2, 'SEMANAL', '0000-00-00', '0000-00-00', 'ACTIVO'),
(3, 'MENSUAL', '0000-00-00', '0000-00-00', 'ACTIVO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id_responsable` int(11) NOT NULL,
  `nombre_responsable` varchar(150) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `responsables`
--

INSERT INTO `responsables` (`id_responsable`, `nombre_responsable`, `estado`) VALUES
(1, 'COORDINACION / SOFTWARE', 'ACTIVO');

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

--
-- Volcado de datos para la tabla `temas_poa`
--

INSERT INTO `temas_poa` (`id_tema`, `descripcion`, `estado`) VALUES
(1, 'ELABORACION POA 2024', 'ACTIVO'),
(2, 'ELABORACION POA 2025', 'ACTIVO');

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
(1, 'Administrador POA', 'admin', '$2y$10$2m0o2vC6UWjtHC6dTbW7bu56f1yZpM4XoV7kRIp/8aG2JRnsO85QC\n\n', 'ACTIVO', '2025-12-25 23:00:58'),
(3, 'Administrador POA', 'wiliam', '$2y$10$2m0o2vC6UWjtHC6dTbW7bu56f1yZpM4XoV7kRIp/8aG2JRnsO85QC', 'ACTIVO', '2025-12-25 23:05:19'),
(4, 'coordinador', 'wiliam23', '$2y$10$xWqNCnO0tmp1yWbffnQsGePndbRBac5Dca0TPdTRgme1fXE6Z8Wdq', 'ACTIVO', '2025-12-25 23:06:55');

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
  MODIFY `id_eje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `indicadores`
--
ALTER TABLE `indicadores`
  MODIFY `id_indicador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id_plazo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `temas_poa`
--
ALTER TABLE `temas_poa`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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

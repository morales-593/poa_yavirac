-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-01-2026 a las 06:20:46
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
-- Base de datos: `amigo_poa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_ejecucion`
--

CREATE TABLE `archivos_ejecucion` (
  `id_archivo_ejec` int(11) NOT NULL,
  `id_ejecucion` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo_archivo` enum('ARCHIVO_1','ARCHIVO_2','ARCHIVO_3') NOT NULL,
  `descripcion_archivo` varchar(200) DEFAULT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp(),
  `orden_archivo_ejec` int(11) DEFAULT NULL COMMENT 'Orden de archivos por ejecución'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_seguimiento`
--

CREATE TABLE `archivos_seguimiento` (
  `id_archivo_seg` int(11) NOT NULL,
  `id_seguimiento` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo_archivo` enum('INFORME','EVIDENCIA','OTRO') NOT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp(),
  `orden_archivo_seg` int(11) DEFAULT NULL COMMENT 'Orden de archivos por seguimiento'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecucion`
--

CREATE TABLE `ejecucion` (
  `id_ejecucion` int(11) NOT NULL,
  `id_seguimiento` int(11) NOT NULL,
  `nombre_ejecucion` varchar(100) NOT NULL,
  `resultado_final` enum('APROBADO','RECHAZADO','PENDIENTE') DEFAULT 'PENDIENTE',
  `observaciones_ejecucion` text DEFAULT NULL,
  `fecha_ejecucion` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `orden_ejecucion` int(11) DEFAULT NULL COMMENT 'Orden de ejecuciones'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejes`
--

CREATE TABLE `ejes` (
  `id_eje` int(11) NOT NULL,
  `nombre_eje` varchar(150) NOT NULL,
  `objetivo` text NOT NULL,
  `orden_eje` int(11) NOT NULL COMMENT 'Orden visual de ejes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejes`
--

INSERT INTO `ejes` (`id_eje`, `nombre_eje`, `objetivo`, `orden_eje`) VALUES
(1, 'wili', 'fasdfasdfas', 1),
(2, 'DOCENCIA', 'nombre descriptivo para el eje estratégico.', 2),
(3, 'Eje de Desarrollo Institucional', 'Fortalecer la capacidad institucional para mejorar la gestión pública', 3),
(4, 'Eje de Desarrollo Social', 'Promover el bienestar social y la reducción de la pobreza', 4),
(5, 'Eje de Desarrollo Económico', 'Impulsar el crecimiento económico sostenible e inclusivo', 5),
(6, 'Eje de Gobernanza', 'Fortalecer la transparencia y participación ciudadana en la gestión pública', 6),
(7, 'Eje de Desarrollo Sostenible', 'Promover el crecimiento económico equilibrado con protección ambiental', 7),
(8, 'Eje 1: Desarrollo Institucional', 'Fortalecer las capacidades institucionales para una gestión pública eficiente y transparente', 8),
(9, 'Eje 2: Desarrollo Social', 'Mejorar la calidad de vida de la población mediante programas sociales inclusivos', 9),
(10, 'Eje 3: Desarrollo Económico', 'Promover el crecimiento económico sostenible y la generación de empleo', 10),
(11, 'Eje 4: Gestión Ambiental', 'Implementar políticas para la conservación y uso sostenible de recursos naturales', 11),
(12, 'miu', 'dasdcascas', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `elaboracion`
--

CREATE TABLE `elaboracion` (
  `id_elaboracion` int(11) NOT NULL,
  `id_tema` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `id_indicador` int(11) NOT NULL,
  `linea_base` varchar(255) NOT NULL,
  `politicas` text DEFAULT NULL,
  `metas` text DEFAULT NULL,
  `actividades` text NOT NULL,
  `indicador_resultado` text DEFAULT NULL,
  `id_medio` int(11) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_responsable` int(11) NOT NULL,
  `orden_elaboracion` int(11) DEFAULT NULL COMMENT 'Orden de elaboraciones'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `elaboracion`
--

INSERT INTO `elaboracion` (`id_elaboracion`, `id_tema`, `id_plan`, `id_indicador`, `linea_base`, `politicas`, `metas`, `actividades`, `indicador_resultado`, `id_medio`, `fecha_creacion`, `id_responsable`, `orden_elaboracion`) VALUES
(2, 1, 2, 20, 'csadcs', 'asdfacasdcasdcasdc', 'casdasdasd', 'ascasd', 'cascasdcasdcasdcsadc', NULL, '2026-01-03 04:22:49', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

CREATE TABLE `indicadores` (
  `id_indicador` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `id_eje` int(11) NOT NULL,
  `orden_indicador` int(11) DEFAULT NULL COMMENT 'Orden de indicadores dentro del eje'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `indicadores`
--

INSERT INTO `indicadores` (`id_indicador`, `codigo`, `descripcion`, `id_eje`, `orden_indicador`) VALUES
(1, '1.1.1', 'ELABORACION POA 2024', 1, 1),
(2, '2.1.4', 'código único para identificar el indicador.', 2, 1),
(3, '1.1.2', 'Ingrese un código único para identificar el indicador.', 2, 2),
(4, 'GOV-001', 'Porcentaje de procesos públicos transparentados', 1, 2),
(5, 'GOV-002', 'Número de consultas ciudadanas realizadas', 1, 3),
(6, 'DS-001', 'Tasa de crecimiento económico sostenible', 2, 3),
(7, 'DS-002', 'Reducción de huella de carbono institucional', 2, 4),
(8, 'IND-001', 'Porcentaje de personal capacitado en gestión pública', 1, 4),
(9, 'IND-002', 'Número de sistemas informáticos implementados', 1, 5),
(10, 'IND-003', 'Nivel de satisfacción de usuarios en servicios públicos', 1, 6),
(11, 'IND-004', 'Tiempo promedio de respuesta a trámites', 1, 7),
(12, 'IND-005', 'Tasa de cobertura de programas sociales', 2, 5),
(13, 'IND-006', 'Número de beneficiarios de programas de alimentación', 2, 6),
(14, 'IND-007', 'Porcentaje de población con acceso a servicios básicos', 2, 7),
(15, 'IND-008', 'Índice de desarrollo humano local', 2, 8),
(16, 'IND-009', 'Número de emprendimientos apoyados', 3, 1),
(17, 'IND-010', 'Tasa de empleo generado por programas de fomento', 3, 2),
(18, 'IND-011', 'Volumen de inversión pública ejecutada', 3, 3),
(19, 'IND-012', 'Número de ferias comerciales realizadas', 3, 4),
(20, 'IND-013', 'Porcentaje de residuos sólidos reciclados', 4, 1),
(21, 'IND-014', 'Número de árboles sembrados en áreas verdes', 4, 2),
(22, 'IND-015', 'Reducción del consumo de energía eléctrica', 4, 3),
(23, 'IND-016', 'Número de campañas de educación ambiental', 4, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medios_verificacion`
--

CREATE TABLE `medios_verificacion` (
  `id_medio` int(11) NOT NULL,
  `detalle` text NOT NULL,
  `id_plazo` int(11) DEFAULT NULL,
  `id_elaboracion` int(11) NOT NULL,
  `orden_medio` int(11) DEFAULT NULL COMMENT 'Orden de medios de verificación'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medios_verificacion`
--

INSERT INTO `medios_verificacion` (`id_medio`, `detalle`, `id_plazo`, `id_elaboracion`, `orden_medio`) VALUES
(7, 'casdcas', 4, 2, 1),
(8, 'casdc', 6, 2, 2),
(9, 'casdca', 6, 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planes`
--

CREATE TABLE `planes` (
  `id_plan` int(11) NOT NULL,
  `nombre_elaborado` varchar(50) NOT NULL,
  `nombre_responsable` varchar(50) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` enum('PENDIENTE','ACTIVO','INACTIVO','COMPLETADO') DEFAULT 'PENDIENTE',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `orden_plan` int(11) DEFAULT NULL COMMENT 'Orden de planes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id_plan`, `nombre_elaborado`, `nombre_responsable`, `id_usuario`, `estado`, `fecha_creacion`, `orden_plan`) VALUES
(2, 'wiliam', 'COORDINACION / SOFTWARE', 1, 'PENDIENTE', '2026-01-02 20:28:11', 1),
(3, 'wiliam', 'andres', 1, 'PENDIENTE', '2026-01-02 20:36:56', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plazos`
--

CREATE TABLE `plazos` (
  `id_plazo` int(11) NOT NULL,
  `nombre_plazo` varchar(50) NOT NULL,
  `orden_plazo` int(11) DEFAULT NULL COMMENT 'Orden de plazos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plazos`
--

INSERT INTO `plazos` (`id_plazo`, `nombre_plazo`, `orden_plazo`) VALUES
(1, 'anual', 1),
(2, 'SEMANAL', 2),
(3, 'Corto plazo (1-3 meses)', 3),
(4, 'Mediano plazo (4-6 meses)', 4),
(5, 'Largo plazo (7-12 meses)', 5),
(6, 'Anual', 6),
(7, 'Semestral', 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id_responsable` int(11) NOT NULL,
  `nombre_responsable` varchar(50) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `orden_responsable` int(11) DEFAULT NULL COMMENT 'Orden de responsables'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `responsables`
--

INSERT INTO `responsables` (`id_responsable`, `nombre_responsable`, `estado`, `orden_responsable`) VALUES
(1, 'COORDINACION / SOFTWARE', 'ACTIVO', 1),
(2, 'Juan Pérez', 'ACTIVO', 2),
(3, 'María García', 'ACTIVO', 3),
(4, 'Carlos López', 'ACTIVO', 4),
(5, 'Ana Martínez', 'ACTIVO', 5),
(6, 'Pedro Sánchez', 'ACTIVO', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id_seguimiento` int(11) NOT NULL,
  `id_elaboracion` int(11) NOT NULL,
  `id_medio` int(11) NOT NULL,
  `cumplimiento` enum('CUMPLE','NO_CUMPLE','PARCIAL') DEFAULT 'NO_CUMPLE',
  `observaciones` text DEFAULT NULL,
  `fecha_seguimiento` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `orden_seguimiento` int(11) DEFAULT NULL COMMENT 'Orden de seguimientos'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas_poa`
--

CREATE TABLE `temas_poa` (
  `id_tema` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `orden_tema` int(11) DEFAULT NULL COMMENT 'Orden de temas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temas_poa`
--

INSERT INTO `temas_poa` (`id_tema`, `descripcion`, `estado`, `orden_tema`) VALUES
(1, 'ELABORACION POA 2024', 'ACTIVO', 1),
(2, 'ELABORACION POA 2025', 'ACTIVO', 2),
(3, 'Capacitación del personal', 'ACTIVO', 3),
(4, 'Infraestructura educativa', 'ACTIVO', 4),
(5, 'Programas de salud', 'ACTIVO', 5),
(6, 'Fomento productivo', 'ACTIVO', 6),
(7, 'Gestión de residuos', 'ACTIVO', 7),
(8, 'Modernización administrativa', 'ACTIVO', 8);

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
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `orden_usuario` int(11) DEFAULT NULL COMMENT 'Orden de usuarios'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombres`, `usuario`, `password`, `estado`, `fecha_creacion`, `orden_usuario`) VALUES
(1, 'Administrador POA', 'admin', '$2y$10$2m0o2vC6UWjtHC6dTbW7bu56f1yZpM4XoV7kRIp/8aG2JRnsO85QC', 'ACTIVO', '2026-01-02 19:32:21', 1),
(2, 'admins', 'wiliam', '$2y$10$pDiu1cZEHiEvwkl/KRl/9ueVvm7ijcbP0IC8vPVnygrvPJL4XtS3i', 'ACTIVO', '2026-01-02 19:34:54', 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos_ejecucion`
--
ALTER TABLE `archivos_ejecucion`
  ADD PRIMARY KEY (`id_archivo_ejec`),
  ADD KEY `idx_archivos_ejec_ejecucion` (`id_ejecucion`),
  ADD KEY `idx_archivos_ejec_orden` (`orden_archivo_ejec`);

--
-- Indices de la tabla `archivos_seguimiento`
--
ALTER TABLE `archivos_seguimiento`
  ADD PRIMARY KEY (`id_archivo_seg`),
  ADD KEY `idx_archivos_seg_seguimiento` (`id_seguimiento`),
  ADD KEY `idx_archivos_seg_orden` (`orden_archivo_seg`);

--
-- Indices de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  ADD PRIMARY KEY (`id_ejecucion`),
  ADD KEY `idx_ejecucion_seguimiento` (`id_seguimiento`),
  ADD KEY `idx_ejecucion_orden` (`orden_ejecucion`);

--
-- Indices de la tabla `ejes`
--
ALTER TABLE `ejes`
  ADD PRIMARY KEY (`id_eje`),
  ADD KEY `idx_ejes_orden` (`orden_eje`);

--
-- Indices de la tabla `elaboracion`
--
ALTER TABLE `elaboracion`
  ADD PRIMARY KEY (`id_elaboracion`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_plan` (`id_plan`),
  ADD KEY `id_indicador` (`id_indicador`),
  ADD KEY `id_responsable` (`id_responsable`),
  ADD KEY `id_medio` (`id_medio`),
  ADD KEY `idx_elaboracion_orden` (`orden_elaboracion`);

--
-- Indices de la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD PRIMARY KEY (`id_indicador`),
  ADD KEY `id_eje` (`id_eje`),
  ADD KEY `idx_indicadores_orden` (`orden_indicador`);

--
-- Indices de la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  ADD PRIMARY KEY (`id_medio`),
  ADD KEY `id_plazo` (`id_plazo`),
  ADD KEY `fk_medios_elab` (`id_elaboracion`),
  ADD KEY `idx_medios_orden` (`orden_medio`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id_plan`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `idx_planes_orden` (`orden_plan`);

--
-- Indices de la tabla `plazos`
--
ALTER TABLE `plazos`
  ADD PRIMARY KEY (`id_plazo`),
  ADD KEY `idx_plazos_orden` (`orden_plazo`);

--
-- Indices de la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id_responsable`),
  ADD KEY `idx_responsables_orden` (`orden_responsable`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`id_seguimiento`),
  ADD KEY `idx_seguimiento_elaboracion` (`id_elaboracion`),
  ADD KEY `idx_seguimiento_medio` (`id_medio`),
  ADD KEY `idx_seguimiento_orden` (`orden_seguimiento`);

--
-- Indices de la tabla `temas_poa`
--
ALTER TABLE `temas_poa`
  ADD PRIMARY KEY (`id_tema`),
  ADD KEY `idx_temas_orden` (`orden_tema`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `idx_usuarios_orden` (`orden_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivos_ejecucion`
--
ALTER TABLE `archivos_ejecucion`
  MODIFY `id_archivo_ejec` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `archivos_seguimiento`
--
ALTER TABLE `archivos_seguimiento`
  MODIFY `id_archivo_seg` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  MODIFY `id_ejecucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejes`
--
ALTER TABLE `ejes`
  MODIFY `id_eje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `elaboracion`
--
ALTER TABLE `elaboracion`
  MODIFY `id_elaboracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `indicadores`
--
ALTER TABLE `indicadores`
  MODIFY `id_indicador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  MODIFY `id_medio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `plazos`
--
ALTER TABLE `plazos`
  MODIFY `id_plazo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `temas_poa`
--
ALTER TABLE `temas_poa`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos_ejecucion`
--
ALTER TABLE `archivos_ejecucion`
  ADD CONSTRAINT `archivos_ejecucion_ibfk_1` FOREIGN KEY (`id_ejecucion`) REFERENCES `ejecucion` (`id_ejecucion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `archivos_seguimiento`
--
ALTER TABLE `archivos_seguimiento`
  ADD CONSTRAINT `archivos_seguimiento_ibfk_1` FOREIGN KEY (`id_seguimiento`) REFERENCES `seguimiento` (`id_seguimiento`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  ADD CONSTRAINT `ejecucion_ibfk_1` FOREIGN KEY (`id_seguimiento`) REFERENCES `seguimiento` (`id_seguimiento`) ON DELETE CASCADE;

--
-- Filtros para la tabla `elaboracion`
--
ALTER TABLE `elaboracion`
  ADD CONSTRAINT `elaboracion_ibfk_1` FOREIGN KEY (`id_tema`) REFERENCES `temas_poa` (`id_tema`) ON DELETE CASCADE,
  ADD CONSTRAINT `elaboracion_ibfk_2` FOREIGN KEY (`id_plan`) REFERENCES `planes` (`id_plan`) ON DELETE CASCADE,
  ADD CONSTRAINT `elaboracion_ibfk_3` FOREIGN KEY (`id_indicador`) REFERENCES `indicadores` (`id_indicador`) ON DELETE CASCADE,
  ADD CONSTRAINT `elaboracion_ibfk_4` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  ADD CONSTRAINT `elaboracion_ibfk_5` FOREIGN KEY (`id_medio`) REFERENCES `medios_verificacion` (`id_medio`) ON DELETE SET NULL;

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `indicadores_ibfk_1` FOREIGN KEY (`id_eje`) REFERENCES `ejes` (`id_eje`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  ADD CONSTRAINT `fk_medios_elab` FOREIGN KEY (`id_elaboracion`) REFERENCES `elaboracion` (`id_elaboracion`) ON DELETE CASCADE,
  ADD CONSTRAINT `medios_verificacion_ibfk_1` FOREIGN KEY (`id_plazo`) REFERENCES `plazos` (`id_plazo`) ON DELETE SET NULL;

--
-- Filtros para la tabla `planes`
--
ALTER TABLE `planes`
  ADD CONSTRAINT `planes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD CONSTRAINT `seguimiento_ibfk_1` FOREIGN KEY (`id_elaboracion`) REFERENCES `elaboracion` (`id_elaboracion`) ON DELETE CASCADE,
  ADD CONSTRAINT `seguimiento_ibfk_2` FOREIGN KEY (`id_medio`) REFERENCES `medios_verificacion` (`id_medio`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
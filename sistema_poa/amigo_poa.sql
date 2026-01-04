-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-01-2026 a las 21:03:33
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
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
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
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
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
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejes`
--

CREATE TABLE `ejes` (
  `id_eje` int(11) NOT NULL,
  `nombre_eje` varchar(150) NOT NULL,
  `objetivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ejes`
--

INSERT INTO `ejes` (`id_eje`, `nombre_eje`, `objetivo`) VALUES
(1, 'wili', 'fasdfasdfas'),
(2, 'DOCENCIA', 'nombre descriptivo para el eje estratégico.'),
(3, 'Eje de Desarrollo Institucional', 'Fortalecer la capacidad institucional para mejorar la gestión pública'),
(4, 'Eje de Desarrollo Social', 'Promover el bienestar social y la reducción de la pobreza'),
(5, 'Eje de Desarrollo Económico', 'Impulsar el crecimiento económico sostenible e inclusivo'),
(6, 'Eje de Gobernanza', 'Fortalecer la transparencia y participación ciudadana en la gestión pública'),
(7, 'Eje de Desarrollo Sostenible', 'Promover el crecimiento económico equilibrado con protección ambiental'),
(8, 'Eje 1: Desarrollo Institucional', 'Fortalecer las capacidades institucionales para una gestión pública eficiente y transparente'),
(9, 'Eje 2: Desarrollo Social', 'Mejorar la calidad de vida de la población mediante programas sociales inclusivos'),
(10, 'Eje 3: Desarrollo Económico', 'Promover el crecimiento económico sostenible y la generación de empleo'),
(11, 'Eje 4: Gestión Ambiental', 'Implementar políticas para la conservación y uso sostenible de recursos naturales'),
(12, 'miu', 'dasdcascas');

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
  `id_responsable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `elaboracion`
--

INSERT INTO `elaboracion` (`id_elaboracion`, `id_tema`, `id_plan`, `id_indicador`, `linea_base`, `politicas`, `metas`, `actividades`, `indicador_resultado`, `id_medio`, `fecha_creacion`, `id_responsable`) VALUES
(2, 2, 2, 3, '87%', 'almacenado', 'casdasdasd', 'ascasdfasdfas', 'cascasdcasdcasdcsadc', NULL, '2026-01-03 04:22:49', 1);

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
(1, '1.1.1', 'ELABORACION POA 2024', 1),
(2, '2.1.4', 'código único para identificar el indicador.', 2),
(3, '1.1.2', 'Ingrese un código único para identificar el indicador.', 2),
(4, 'GOV-001', 'Porcentaje de procesos públicos transparentados', 1),
(5, 'GOV-002', 'Número de consultas ciudadanas realizadas', 1),
(6, 'DS-001', 'Tasa de crecimiento económico sostenible', 2),
(7, 'DS-002', 'Reducción de huella de carbono institucional', 2),
(8, 'IND-001', 'Porcentaje de personal capacitado en gestión pública', 1),
(9, 'IND-002', 'Número de sistemas informáticos implementados', 1),
(10, 'IND-003', 'Nivel de satisfacción de usuarios en servicios públicos', 1),
(11, 'IND-004', 'Tiempo promedio de respuesta a trámites', 1),
(12, 'IND-005', 'Tasa de cobertura de programas sociales', 2),
(13, 'IND-006', 'Número de beneficiarios de programas de alimentación', 2),
(14, 'IND-007', 'Porcentaje de población con acceso a servicios básicos', 2),
(15, 'IND-008', 'Índice de desarrollo humano local', 2),
(16, 'IND-009', 'Número de emprendimientos apoyados', 3),
(17, 'IND-010', 'Tasa de empleo generado por programas de fomento', 3),
(18, 'IND-011', 'Volumen de inversión pública ejecutada', 3),
(19, 'IND-012', 'Número de ferias comerciales realizadas', 3),
(20, 'IND-013', 'Porcentaje de residuos sólidos reciclados', 4),
(21, 'IND-014', 'Número de árboles sembrados en áreas verdes', 4),
(22, 'IND-015', 'Reducción del consumo de energía eléctrica', 4),
(23, 'IND-016', 'Número de campañas de educación ambiental', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medios_verificacion`
--

CREATE TABLE `medios_verificacion` (
  `id_medio` int(11) NOT NULL,
  `detalle` text NOT NULL,
  `id_plazo` int(11) DEFAULT NULL,
  `id_elaboracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medios_verificacion`
--

INSERT INTO `medios_verificacion` (`id_medio`, `detalle`, `id_plazo`, `id_elaboracion`) VALUES
(31, 'casdcas', 4, 2),
(32, 'casdc', 6, 2),
(33, 'wiliamaqui', 3, 2);

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
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id_plan`, `nombre_elaborado`, `nombre_responsable`, `id_usuario`, `estado`, `fecha_creacion`) VALUES
(2, 'wiliam', 'COORDINACION / SOFTWARE', 1, 'PENDIENTE', '2026-01-02 20:28:11'),
(3, 'wiliam', 'andres', 1, 'PENDIENTE', '2026-01-02 20:36:56');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plazos`
--

CREATE TABLE `plazos` (
  `id_plazo` int(11) NOT NULL,
  `nombre_plazo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `plazos`
--

INSERT INTO `plazos` (`id_plazo`, `nombre_plazo`) VALUES
(1, 'anual'),
(2, 'SEMANAL'),
(3, 'Corto plazo (1-3 meses)'),
(4, 'Mediano plazo (4-6 meses)'),
(5, 'Largo plazo (7-12 meses)'),
(6, 'Anual'),
(7, 'Semestral');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id_responsable` int(11) NOT NULL,
  `nombre_responsable` varchar(50) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `responsables`
--

INSERT INTO `responsables` (`id_responsable`, `nombre_responsable`, `estado`) VALUES
(1, 'COORDINACION / SOFTWARE', 'ACTIVO'),
(2, 'Juan Pérez', 'ACTIVO'),
(3, 'María García', 'ACTIVO'),
(4, 'Carlos López', 'ACTIVO'),
(5, 'Ana Martínez', 'ACTIVO'),
(6, 'Pedro Sánchez', 'ACTIVO');

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
(2, 'ELABORACION POA 2025', 'ACTIVO'),
(3, 'Capacitación del personal', 'ACTIVO'),
(4, 'Infraestructura educativa', 'ACTIVO'),
(5, 'Programas de salud', 'ACTIVO'),
(6, 'Fomento productivo', 'ACTIVO'),
(7, 'Gestión de residuos', 'ACTIVO'),
(8, 'Modernización administrativa', 'ACTIVO');

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
(1, 'Administrador POA', 'admin', '$2y$10$2m0o2vC6UWjtHC6dTbW7bu56f1yZpM4XoV7kRIp/8aG2JRnsO85QC', 'ACTIVO', '2026-01-02 19:32:21'),
(2, 'admins', 'wiliam', '$2y$10$pDiu1cZEHiEvwkl/KRl/9ueVvm7ijcbP0IC8vPVnygrvPJL4XtS3i', 'ACTIVO', '2026-01-02 19:34:54');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivos_ejecucion`
--
ALTER TABLE `archivos_ejecucion`
  ADD PRIMARY KEY (`id_archivo_ejec`),
  ADD KEY `idx_archivos_ejec_ejecucion` (`id_ejecucion`);

--
-- Indices de la tabla `archivos_seguimiento`
--
ALTER TABLE `archivos_seguimiento`
  ADD PRIMARY KEY (`id_archivo_seg`),
  ADD KEY `idx_archivos_seg_seguimiento` (`id_seguimiento`);

--
-- Indices de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  ADD PRIMARY KEY (`id_ejecucion`),
  ADD KEY `idx_ejecucion_seguimiento` (`id_seguimiento`);

--
-- Indices de la tabla `ejes`
--
ALTER TABLE `ejes`
  ADD PRIMARY KEY (`id_eje`);

--
-- Indices de la tabla `elaboracion`
--
ALTER TABLE `elaboracion`
  ADD PRIMARY KEY (`id_elaboracion`),
  ADD KEY `id_tema` (`id_tema`),
  ADD KEY `id_plan` (`id_plan`),
  ADD KEY `id_indicador` (`id_indicador`),
  ADD KEY `id_responsable` (`id_responsable`),
  ADD KEY `id_medio` (`id_medio`);

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
  ADD KEY `id_plazo` (`id_plazo`),
  ADD KEY `fk_medios_elab` (`id_elaboracion`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id_plan`),
  ADD KEY `id_usuario` (`id_usuario`);

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
  ADD KEY `idx_seguimiento_elaboracion` (`id_elaboracion`),
  ADD KEY `idx_seguimiento_medio` (`id_medio`);

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
  MODIFY `id_medio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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

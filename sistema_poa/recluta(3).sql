-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-01-2026 a las 02:17:23
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
-- Base de datos: `recluta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivos_ejecucion`
--

CREATE TABLE `archivos_ejecucion` (
  `id_archivo_ejec` int(11) NOT NULL,
  `id_ejecucion` int(11) NOT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `tipo_archivo` enum('ELABORACION','SEGUIMIENTO','ADICIONAL') NOT NULL,
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
  `tipo_archivo` varchar(50) DEFAULT NULL,
  `ruta_archivo` varchar(500) NOT NULL,
  `fecha_subida` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones_medios`
--

CREATE TABLE `calificaciones_medios` (
  `id_calificacion` int(11) NOT NULL,
  `id_seguimiento` int(11) NOT NULL,
  `id_medio` int(11) NOT NULL,
  `calificacion_individual` varchar(50) DEFAULT NULL,
  `cumplimiento` enum('SI','NO') DEFAULT 'NO',
  `observacion` text DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones_medios`
--

INSERT INTO `calificaciones_medios` (`id_calificacion`, `id_seguimiento`, `id_medio`, `calificacion_individual`, `cumplimiento`, `observacion`, `fecha_registro`) VALUES
(1, 1, 11, 'CUMPLE - Medio verificado correctamente', 'SI', '', '2026-01-05 01:00:02'),
(2, 1, 12, 'CUMPLE - Medio verificado correctamente', 'SI', '', '2026-01-05 01:00:02'),
(3, 1, 13, 'CUMPLE - Medio verificado correctamente', 'SI', '', '2026-01-05 01:00:02'),
(7, 2, 8, 'CUMPLE - Medio verificado correctamente', 'SI', 'CUMPLE - Medio verificado correctamente', '2026-01-05 01:05:18'),
(8, 2, 9, 'CUMPLE - Medio verificado correctamente', 'SI', 'CUMPLE - Medio verificado correctamente', '2026-01-05 01:05:18'),
(9, 2, 10, 'CUMPLE - Medio verificado correctamente', 'SI', 'NO CUMPLE - Medio no verificado', '2026-01-05 01:05:18');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejecucion`
--

CREATE TABLE `ejecucion` (
  `id_ejecucion` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `nombre_ejecucion` varchar(100) NOT NULL,
  `resultado_final` enum('APROBADO','RECHAZADO','PENDIENTE') DEFAULT 'PENDIENTE',
  `observaciones_ejecucion` text DEFAULT NULL,
  `persona_responsable` varchar(100) NOT NULL,
  `fecha_ejecucion` date NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `calificacion_final` varchar(20) DEFAULT NULL,
  `porcentaje_final` int(11) DEFAULT 0
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
(1, 'INFRAESTRUCTURA', 'fasdfasdfas'),
(2, 'DOCENCIA', 'nombre descriptivo para el eje estratégico.'),
(3, 'ORGANIZACIÓN', 'Fortalecer la capacidad institucional para mejorar la gestión pública'),
(4, 'INVESTIGACIÓN', 'Promover el bienestar social y la reducción de la pobreza'),
(5, 'INNOVACIÓN', 'Impulsar el crecimiento económico sostenible e inclusivo'),
(6, 'VINCULACIÓN', 'Fortalecer la transparencia y participación ciudadana en la gestión pública'),
(7, 'PROFESORES', 'seccion de profesores \r\n');

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
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_responsable` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `elaboracion`
--

INSERT INTO `elaboracion` (`id_elaboracion`, `id_tema`, `id_plan`, `id_indicador`, `linea_base`, `politicas`, `metas`, `actividades`, `indicador_resultado`, `fecha_creacion`, `id_responsable`) VALUES
(3, 1, 1, 1, 'NFORMACIÓN BASE', 'NFORMACIÓN BASE', 'NFORMACIÓN BASE', 'NFORMACIÓN BASE', 'NFORMACIÓN BASE', '2026-01-04 23:12:59', 1),
(4, 1, 2, 1, '56%', 'cascasca', ' zdvzdfv', 'vsdva', 'xzvzxvcvv ', '2026-01-05 00:29:36', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indicadores`
--

CREATE TABLE `indicadores` (
  `id_indicador` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `descripcion` text NOT NULL,
  `id_eje` int(11) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `indicadores`
--

INSERT INTO `indicadores` (`id_indicador`, `codigo`, `descripcion`, `id_eje`, `estado`, `fecha_creacion`) VALUES
(1, '4.1.1.', 'INDICADOR PROGRAMAS DE ESTUDIO DE LAS ASIGNATURAS', 2, 'ACTIVO', '2026-01-04 22:19:22'),
(2, '4.1.2.', 'INDICADOR AFINIDAD FORMACIÓN- DOCENCIA', 2, 'ACTIVO', '2026-01-04 22:20:05'),
(3, '4.1.3.', 'INDICADOR SEGUIMIENTO, CONTROL Y EVALUACIÓN DEL PROCESO DOCENTE', 2, 'ACTIVO', '2026-01-04 22:20:46'),
(4, '4.1.4', 'ASIGNATURAS CON COBERTURA BIBLIOGRÁFICA ADECUADA', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(5, '4.1.5', 'PUBLICACIONES DOCENTES', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(6, '4.1.6', 'AULAS', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(7, '4.1.7', 'FORMACIÓN COMPLEMENTARIA', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(8, '4.1.8', 'ACOMPAÑAMIENTO PEDAGÓGICO A ESTUDIANTES', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(9, '4.1.9', 'RELACIÓN CON LOS GRADUADOS', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(10, '4.2.1', 'ENTORNO VIRTUAL DE APRENDIZAJE', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(11, '4.2.2', 'INFORMATIZACIÓN EN EL APRENDIZAJE', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(12, '4.3.1', 'EDUCACIÓN AMBIENTAL Y DESARROLLO SOSTENIBLE', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(13, '4.3.2', 'FORMACIÓN EN VALORES Y DESARROLLO DE HABILIDADES BLANDAS', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(14, '4.4.1', 'FORMACIÓN PRÁCTICA EN EL ENTORNO ACADÉMICO', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(15, '4.4.2', 'FORMACIÓN PRÁCTICA EN EL ENTORNO LABORAL REAL', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(16, '4.5.1', 'FUNCIONAMIENTO DE LA BIBLIOTECA', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(17, '4.5.2', 'ACERVO DE LA BIBLIOTECA Y RELACIÓN DE LA BIBLIOTECA CON', 2, 'ACTIVO', '2026-01-04 22:26:11'),
(18, '2.1.1', 'PUESTOS DE TRABAJO DE LOS PROFESORES', 1, 'ACTIVO', '2026-01-04 22:30:03'),
(19, '2.1.2', 'SEGURIDAD Y SALUD OCUPACIONAL, INFRAESTRUCTURA', 1, 'ACTIVO', '2026-01-04 22:30:03'),
(20, '2.1.3', 'ACCESIBILIDAD FISICA Y ESPARCIMIENTO', 1, 'ACTIVO', '2026-01-04 22:30:03'),
(21, '2.1.4', 'ANCHO DE BANDA', 1, 'ACTIVO', '2026-01-04 22:30:03'),
(22, '5.1.1', 'PLANIFICACION Y EJECUCION DE VINCULACION CON LA SOCIEDAD', 6, 'ACTIVO', '2026-01-04 22:34:13'),
(23, '6.2.1', 'PRESENCIA DE LA INSTITUCION EN LA COMUNIDAD', 6, 'ACTIVO', '2026-01-04 22:34:13'),
(24, '5.1.1', 'INVESTIGACION Y DESARROLLO', 4, 'ACTIVO', '2026-01-04 22:35:09'),
(25, '5.2.1', 'PUBLICACIONES Y EVENTOS CIENTIFICOS Y TECNICOS', 4, 'ACTIVO', '2026-01-04 22:35:09'),
(26, '5.3.1', 'INNOVACION Y CAPACIDAD DE ABSORCION', 4, 'ACTIVO', '2026-01-04 22:35:09'),
(27, '1.1.1', 'PLANIFICACIÓN ESTRATÉGICA Y OPERATIVA', 3, 'ACTIVO', '2026-01-04 22:35:31'),
(28, '1.1.2', 'RELACIONES INTERINSTITUCIONALES PARA EL DESARROLLO', 3, 'ACTIVO', '2026-01-04 22:35:31'),
(29, '1.1.3', 'ASEGURAMIENTO INTERNO DE LA CALIDAD', 3, 'ACTIVO', '2026-01-04 22:35:31'),
(30, '1.1.4', 'SISTEMA INFORMÁTICO DE GESTIÓN', 3, 'ACTIVO', '2026-01-04 22:35:31'),
(31, '1.2.1', 'IGUALDAD DE OPORTUNIDADES', 3, 'ACTIVO', '2026-01-04 22:35:31'),
(32, '1.2.2', 'ÉTICA Y TRANSPARENCIA', 3, 'ACTIVO', '2026-01-04 22:35:31'),
(33, '1.2.3', 'BIENESTAR PSICOLÓGICO', 3, 'ACTIVO', '2026-01-04 22:35:31'),
(34, '3.1.1', 'SELECCIÓN DE PROFESORES', 7, 'ACTIVO', '2026-01-04 22:39:51'),
(35, '3.1.2', 'FORMACIÓN DE POSGRADO', 7, 'ACTIVO', '2026-01-04 22:39:51'),
(36, '3.1.3', 'EXPERIENCIA PROFESIONAL PRÁCTICA DE PROFESORES TC DE CONI', 7, 'ACTIVO', '2026-01-04 22:39:51'),
(37, '3.1.4', 'EJERCICIO PROFESIONAL PRÁCTICO DE PROFESORES MT Y TP DE CC', 7, 'ACTIVO', '2026-01-04 22:39:51'),
(38, '3.2.1', 'TITULARIDAD DE PROFESORES TC Y MT', 7, 'ACTIVO', '2026-01-04 22:39:51'),
(39, '3.2.2', 'CARGA HORARIA SEMANAL DE LOS PROFESORES TC', 7, 'ACTIVO', '2026-01-04 22:39:51'),
(40, '3.2.3', 'EVALUACIÓN DE LOS PROFESORES', 7, 'ACTIVO', '2026-01-04 22:39:51'),
(41, '3.2.4', 'FORMACIÓN ACADÉMICA EN CURSO Y CAPACITACIÓN', 7, 'ACTIVO', '2026-01-04 22:39:51'),
(42, '3.3.1', 'REMUNERACIÓN PROMEDIO MENSUAL TC', 7, 'ACTIVO', '2026-01-04 22:39:51');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medios_verificacion`
--

CREATE TABLE `medios_verificacion` (
  `id_medio` int(11) NOT NULL,
  `detalle` text NOT NULL,
  `id_plazo` int(11) DEFAULT NULL,
  `id_elaboracion` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `medios_verificacion`
--

INSERT INTO `medios_verificacion` (`id_medio`, `detalle`, `id_plazo`, `id_elaboracion`, `fecha_creacion`) VALUES
(8, 'vsdvdf', 2, 4, '2026-01-05 00:29:36'),
(9, 'sdcdsv', 2, 4, '2026-01-05 00:29:36'),
(10, 'casdca', 4, 4, '2026-01-05 00:29:36'),
(11, 'NFORMACIÓN BASE', 1, 3, '2026-01-05 00:47:25'),
(12, 'NFORMACIÓN BASE', 6, 3, '2026-01-05 00:47:25'),
(13, 'casdc', 5, 3, '2026-01-05 00:47:25');

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
  `estado_seguimiento` enum('PENDIENTE','COMPLETADO') DEFAULT 'PENDIENTE',
  `estado_ejecucion` enum('PENDIENTE','COMPLETADO') DEFAULT 'PENDIENTE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `planes`
--

INSERT INTO `planes` (`id_plan`, `nombre_elaborado`, `nombre_responsable`, `id_usuario`, `estado`, `fecha_creacion`, `estado_seguimiento`, `estado_ejecucion`) VALUES
(1, 'wiliam', 'andres carvajal ', 1, 'PENDIENTE', '2026-01-04 22:04:26', 'COMPLETADO', 'PENDIENTE'),
(2, 'miau ', 'miau 2', 1, 'PENDIENTE', '2026-01-05 00:27:09', 'COMPLETADO', 'PENDIENTE');

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
(1, 'ANUAL'),
(2, 'SEMANAL'),
(3, 'Corto plazo (1-3 meses)'),
(4, 'Mediano plazo (4-6 meses)'),
(5, 'Largo plazo (7-12 meses)'),
(6, 'SEMESTRAL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id_responsable` int(11) NOT NULL,
  `nombre_responsable` varchar(50) NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `responsables`
--

INSERT INTO `responsables` (`id_responsable`, `nombre_responsable`, `estado`, `fecha_creacion`) VALUES
(1, 'COORDINACION / SOFTWARE', 'ACTIVO', '2026-01-04 22:18:30');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguimiento`
--

CREATE TABLE `seguimiento` (
  `id_seguimiento` int(11) NOT NULL,
  `id_elaboracion` int(11) NOT NULL,
  `id_medio` int(11) DEFAULT NULL,
  `fecha_seguimiento` date NOT NULL,
  `estado` enum('COMPLETADO','PENDIENTE') DEFAULT 'PENDIENTE',
  `observacion_general` text DEFAULT NULL,
  `calificacion` varchar(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `porcentaje_cumplimiento` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `seguimiento`
--

INSERT INTO `seguimiento` (`id_seguimiento`, `id_elaboracion`, `id_medio`, `fecha_seguimiento`, `estado`, `observacion_general`, `calificacion`, `fecha_registro`, `porcentaje_cumplimiento`) VALUES
(1, 3, 11, '2026-01-05', 'COMPLETADO', 'egrfwegfvwegvrveb', 'EXCELENTE', '2026-01-04 23:14:20', 100),
(2, 4, 8, '2026-01-05', 'COMPLETADO', 'sv adv d v', 'EXCELENTE', '2026-01-05 01:02:43', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas_poa`
--

CREATE TABLE `temas_poa` (
  `id_tema` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `estado` enum('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temas_poa`
--

INSERT INTO `temas_poa` (`id_tema`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(1, 'ELABORACION POA 2025', 'ACTIVO', '2026-01-04 22:11:10');

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
(1, 'Administrador POA', 'admin', '$2y$10$2m0o2vC6UWjtHC6dTbW7bu56f1yZpM4XoV7kRIp/8aG2JRnsO85QC', 'ACTIVO', '2026-01-04 22:03:42'),
(2, 'wiliam', 'wilcom', '$2y$10$J7YYDRFKBhTt.VrKBcLVh.IzDQXxOw2lolcWgh96/xbWlfZ5xCFwq', 'ACTIVO', '2026-01-04 22:05:16');

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
  ADD KEY `id_seguimiento` (`id_seguimiento`);

--
-- Indices de la tabla `calificaciones_medios`
--
ALTER TABLE `calificaciones_medios`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `idx_calificacion_seguimiento` (`id_seguimiento`),
  ADD KEY `idx_calificacion_medio` (`id_medio`);

--
-- Indices de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  ADD PRIMARY KEY (`id_ejecucion`),
  ADD KEY `idx_ejecucion_plan` (`id_plan`);

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
  ADD KEY `idx_elaboracion_tema` (`id_tema`),
  ADD KEY `idx_elaboracion_plan` (`id_plan`),
  ADD KEY `idx_elaboracion_indicador` (`id_indicador`),
  ADD KEY `idx_elaboracion_responsable` (`id_responsable`);

--
-- Indices de la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD PRIMARY KEY (`id_indicador`),
  ADD KEY `idx_indicadores_eje` (`id_eje`),
  ADD KEY `idx_indicadores_codigo` (`codigo`),
  ADD KEY `idx_indicadores_estado` (`estado`);

--
-- Indices de la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  ADD PRIMARY KEY (`id_medio`),
  ADD KEY `idx_medios_plazo` (`id_plazo`),
  ADD KEY `idx_medios_elaboracion` (`id_elaboracion`);

--
-- Indices de la tabla `planes`
--
ALTER TABLE `planes`
  ADD PRIMARY KEY (`id_plan`),
  ADD KEY `idx_planes_usuario` (`id_usuario`),
  ADD KEY `idx_planes_estado` (`estado`),
  ADD KEY `idx_planes_fecha` (`fecha_creacion`);

--
-- Indices de la tabla `plazos`
--
ALTER TABLE `plazos`
  ADD PRIMARY KEY (`id_plazo`);

--
-- Indices de la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id_responsable`),
  ADD KEY `idx_responsables_estado` (`estado`);

--
-- Indices de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD PRIMARY KEY (`id_seguimiento`),
  ADD KEY `idx_seguimiento_elaboracion` (`id_elaboracion`),
  ADD KEY `fk_seguimiento_medio` (`id_medio`);

--
-- Indices de la tabla `temas_poa`
--
ALTER TABLE `temas_poa`
  ADD PRIMARY KEY (`id_tema`),
  ADD KEY `idx_temas_estado` (`estado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `uk_usuarios_usuario` (`usuario`),
  ADD KEY `idx_usuarios_estado` (`estado`);

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
-- AUTO_INCREMENT de la tabla `calificaciones_medios`
--
ALTER TABLE `calificaciones_medios`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  MODIFY `id_ejecucion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ejes`
--
ALTER TABLE `ejes`
  MODIFY `id_eje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `elaboracion`
--
ALTER TABLE `elaboracion`
  MODIFY `id_elaboracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `indicadores`
--
ALTER TABLE `indicadores`
  MODIFY `id_indicador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  MODIFY `id_medio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `planes`
--
ALTER TABLE `planes`
  MODIFY `id_plan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `plazos`
--
ALTER TABLE `plazos`
  MODIFY `id_plazo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  MODIFY `id_seguimiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `temas_poa`
--
ALTER TABLE `temas_poa`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivos_ejecucion`
--
ALTER TABLE `archivos_ejecucion`
  ADD CONSTRAINT `fk_archivos_ejecucion_ejecucion` FOREIGN KEY (`id_ejecucion`) REFERENCES `ejecucion` (`id_ejecucion`) ON DELETE CASCADE;

--
-- Filtros para la tabla `archivos_seguimiento`
--
ALTER TABLE `archivos_seguimiento`
  ADD CONSTRAINT `archivos_seguimiento_ibfk_1` FOREIGN KEY (`id_seguimiento`) REFERENCES `seguimiento` (`id_seguimiento`) ON DELETE CASCADE;

--
-- Filtros para la tabla `calificaciones_medios`
--
ALTER TABLE `calificaciones_medios`
  ADD CONSTRAINT `calificaciones_medios_ibfk_1` FOREIGN KEY (`id_seguimiento`) REFERENCES `seguimiento` (`id_seguimiento`) ON DELETE CASCADE,
  ADD CONSTRAINT `calificaciones_medios_ibfk_2` FOREIGN KEY (`id_medio`) REFERENCES `medios_verificacion` (`id_medio`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ejecucion`
--
ALTER TABLE `ejecucion`
  ADD CONSTRAINT `fk_ejecucion_plan` FOREIGN KEY (`id_plan`) REFERENCES `planes` (`id_plan`) ON DELETE CASCADE;

--
-- Filtros para la tabla `elaboracion`
--
ALTER TABLE `elaboracion`
  ADD CONSTRAINT `fk_elaboracion_indicador` FOREIGN KEY (`id_indicador`) REFERENCES `indicadores` (`id_indicador`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_elaboracion_plan` FOREIGN KEY (`id_plan`) REFERENCES `planes` (`id_plan`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_elaboracion_responsable` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_elaboracion_tema` FOREIGN KEY (`id_tema`) REFERENCES `temas_poa` (`id_tema`) ON DELETE CASCADE;

--
-- Filtros para la tabla `indicadores`
--
ALTER TABLE `indicadores`
  ADD CONSTRAINT `fk_indicadores_eje` FOREIGN KEY (`id_eje`) REFERENCES `ejes` (`id_eje`) ON DELETE CASCADE;

--
-- Filtros para la tabla `medios_verificacion`
--
ALTER TABLE `medios_verificacion`
  ADD CONSTRAINT `fk_medios_elaboracion` FOREIGN KEY (`id_elaboracion`) REFERENCES `elaboracion` (`id_elaboracion`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_medios_plazo` FOREIGN KEY (`id_plazo`) REFERENCES `plazos` (`id_plazo`) ON DELETE SET NULL;

--
-- Filtros para la tabla `planes`
--
ALTER TABLE `planes`
  ADD CONSTRAINT `fk_planes_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `seguimiento`
--
ALTER TABLE `seguimiento`
  ADD CONSTRAINT `fk_seguimiento_elaboracion` FOREIGN KEY (`id_elaboracion`) REFERENCES `elaboracion` (`id_elaboracion`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_seguimiento_medio` FOREIGN KEY (`id_medio`) REFERENCES `medios_verificacion` (`id_medio`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

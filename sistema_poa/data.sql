CREATE DATABASE poa_yavirac
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE poa_yavirac;

-- =====================
-- USUARIOS (LOGIN)
-- =====================
CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    estado ENUM('ACTIVO','INACTIVO') DEFAULT 'ACTIVO',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================
-- RESPONSABLES DE ÁREA
-- =====================
CREATE TABLE responsables (
    id_responsable INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cargo VARCHAR(100)
);

-- =====================
-- EJES
-- =====================
CREATE TABLE ejes (
    id_eje INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- =====================
-- OBJETIVOS
-- =====================
CREATE TABLE objetivos (
    id_objetivo INT AUTO_INCREMENT PRIMARY KEY,
    id_eje INT NOT NULL,
    descripcion TEXT NOT NULL,
    FOREIGN KEY (id_eje) REFERENCES ejes(id_eje)
);

-- =====================
-- TEMAS POA
-- =====================
CREATE TABLE temas_poa (
    id_tema INT AUTO_INCREMENT PRIMARY KEY,
    id_objetivo INT NOT NULL,
    nombre VARCHAR(150) NOT NULL,
    FOREIGN KEY (id_objetivo) REFERENCES objetivos(id_objetivo)
);

-- =====================
-- INDICADORES
-- =====================
CREATE TABLE indicadores (
    id_indicador INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(20),
    descripcion TEXT NOT NULL,
    id_eje INT NOT NULL,
    FOREIGN KEY (id_eje) REFERENCES ejes(id_eje)
);

-- =====================
-- PLAZOS
-- =====================
CREATE TABLE plazos (
    id_plazo INT AUTO_INCREMENT PRIMARY KEY,
    fecha_inicio DATE,
    fecha_fin DATE
);

-- =====================
-- PLAN OPERATIVO
-- =====================
CREATE TABLE planes (
    id_plan INT AUTO_INCREMENT PRIMARY KEY,
    nombre_elaborado VARCHAR(100),
    id_responsable INT NOT NULL,
    id_usuario INT NOT NULL,
    estado ENUM('PENDIENTE','INCOMPLETO','COMPLETADO') DEFAULT 'PENDIENTE',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_responsable) REFERENCES responsables(id_responsable),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- =====================
-- DETALLE DEL PLAN (ELABORACIÓN)
-- =====================
CREATE TABLE plan_detalle (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_plan INT NOT NULL,
    id_tema INT NOT NULL,
    id_indicador INT NOT NULL,
    meta TEXT,
    id_plazo INT,
    FOREIGN KEY (id_plan) REFERENCES planes(id_plan),
    FOREIGN KEY (id_tema) REFERENCES temas_poa(id_tema),
    FOREIGN KEY (id_indicador) REFERENCES indicadores(id_indicador),
    FOREIGN KEY (id_plazo) REFERENCES plazos(id_plazo)
);

-- =====================
-- SEGUIMIENTO
-- =====================
CREATE TABLE seguimiento (
    id_seguimiento INT AUTO_INCREMENT PRIMARY KEY,
    id_detalle INT NOT NULL,
    porcentaje_avance DECIMAL(5,2),
    observaciones TEXT,
    fecha DATE,
    FOREIGN KEY (id_detalle) REFERENCES plan_detalle(id_detalle)
);

-- =====================
-- EJECUCIÓN
-- =====================
CREATE TABLE ejecucion (
    id_ejecucion INT AUTO_INCREMENT PRIMARY KEY,
    id_detalle INT NOT NULL,
    cumplimiento ENUM('SI','NO'),
    resultado TEXT,
    fecha DATE,
    FOREIGN KEY (id_detalle) REFERENCES plan_detalle(id_detalle)
);

-- =====================
-- MEDIOS DE VERIFICACIÓN
-- =====================
CREATE TABLE medios_verificacion (
    id_medio INT AUTO_INCREMENT PRIMARY KEY,
    id_detalle INT NOT NULL,
    descripcion TEXT NOT NULL,
    FOREIGN KEY (id_detalle) REFERENCES plan_detalle(id_detalle)
);

-- =====================
-- ARCHIVOS
-- =====================
CREATE TABLE archivos (
    id_archivo INT AUTO_INCREMENT PRIMARY KEY,
    id_medio INT NOT NULL,
    nombre_archivo VARCHAR(255),
    ruta VARCHAR(255),
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_medio) REFERENCES medios_verificacion(id_medio)
);


INSERT INTO usuarios (nombres, usuario, password)
VALUES (
  'Administrador POA',
  'admin',
  '$2y$10$yYvUQJq8Jqj5lF0QkXWcxe3kZlVnHf1Z1JcLQ9d8g8h1Gm7ZbO6xW'
);

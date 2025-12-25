# nota

la base de datos cojer y copiar 

usuario: admin
contraseña: admin123


responsable cargo

ejes descripcion y relacion con poa 

poa ejesfk 

planes id_responsable


INSERT INTO usuarios (nombres, usuario, password)
VALUES (
  'Administrador POA',
  'admin',
  '$2y$10$2m0o2vC6UWjtHC6dTbW7bu56f1yZpM4XoV7kRIp/8aG2JRnsO85QC'
);
$2y$10$2m0o2vC6UWjtHC6dTbW7bu56f1yZpM4XoV7kRIp/8aG2JRnsO85QC




-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombres VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    estado ENUM('ACTIVO', 'INACTIVO') DEFAULT 'ACTIVO',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de ejes (contiene eje y objetivo)
CREATE TABLE ejes (
    id_eje INT PRIMARY KEY AUTO_INCREMENT,
    nombre_eje VARCHAR(150) NOT NULL,
    descripcion_objetivo TEXT NOT NULL,
);

-- Tabla de temas POA
CREATE TABLE temas_poa (
    id_tema INT PRIMARY KEY AUTO_INCREMENT,
    descripcion TEXT NOT NULL,
    estado ENUM('ACTIVO', 'INACTIVO') DEFAULT 'ACTIVO',
);

-- Tabla de responsables de área
CREATE TABLE responsables (
    id_responsable INT PRIMARY KEY AUTO_INCREMENT,
    nombre_responsable VARCHAR(150) NOT NULL,
    estado ENUM('ACTIVO', 'INACTIVO') DEFAULT 'ACTIVO'
);

-- Tabla de indicadores
CREATE TABLE indicadores (
    id_indicador INT PRIMARY KEY AUTO_INCREMENT,
    codigo VARCHAR(20) NOT NULL,
    descripcion TEXT NOT NULL,
    id_eje INT NOT NULL,
    FOREIGN KEY (id_eje) REFERENCES ejes(id_eje) ON DELETE CASCADE
);

-- Tabla de plazos
CREATE TABLE plazos (
    id_plazo INT PRIMARY KEY AUTO_INCREMENT,
    nombre_plazo VARCHAR(100) NOT NULL,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    estado ENUM('ACTIVO', 'INACTIVO') DEFAULT 'ACTIVO'
);

-- Tabla de planes operativos
CREATE TABLE planes (
    id_plan INT PRIMARY KEY AUTO_INCREMENT,
    nombre_elaborado VARCHAR(150) NOT NULL,
    id_responsable INT NOT NULL,
    id_usuario INT NOT NULL,
    estado ENUM('PENDIENTE', 'EN_PROCESO', 'COMPLETADO', 'INCOMPLETO') DEFAULT 'PENDIENTE',
    fecha_elaboracion DATE NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_responsable) REFERENCES responsables(id_responsable) ON DELETE CASCADE,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- Tabla de detalles del plan
CREATE TABLE plan_detalle (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_plan INT NOT NULL,
    id_tema INT NOT NULL,
    id_indicador INT NOT NULL,
    actividades TEXT NOT NULL,
    politicas TEXT,
    linea_base DECIMAL(5,2) CHECK (linea_base BETWEEN 0 AND 100),
    metas TEXT,
    id_plazo INT,
    FOREIGN KEY (id_plan) REFERENCES planes(id_plan) ON DELETE CASCADE,
    FOREIGN KEY (id_tema) REFERENCES temas_poa(id_tema) ON DELETE CASCADE,
    FOREIGN KEY (id_indicador) REFERENCES indicadores(id_indicador) ON DELETE CASCADE,
    FOREIGN KEY (id_plazo) REFERENCES plazos(id_plazo) ON DELETE SET NULL
);

-- Tabla de medios de verificación
CREATE TABLE medios_verificacion (
    id_medio INT PRIMARY KEY AUTO_INCREMENT,
    id_detalle INT NOT NULL,
    descripcion TEXT NOT NULL,
    detalle_medio TEXT,
    FOREIGN KEY (id_detalle) REFERENCES plan_detalle(id_detalle) ON DELETE CASCADE
);

-- Tabla de archivos adjuntos para medios de verificación
CREATE TABLE archivos (
    id_archivo INT PRIMARY KEY AUTO_INCREMENT,
    id_medio INT NOT NULL,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta VARCHAR(500) NOT NULL,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_medio) REFERENCES medios_verificacion(id_medio) ON DELETE CASCADE
);

-- Tabla de seguimiento
CREATE TABLE seguimiento (
    id_seguimiento INT PRIMARY KEY AUTO_INCREMENT,
    id_detalle INT NOT NULL,
    porcentaje_avance DECIMAL(5,2) CHECK (porcentaje_avance BETWEEN 0 AND 100),
    observaciones TEXT,
    fecha_seguimiento DATE NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_detalle) REFERENCES plan_detalle(id_detalle) ON DELETE CASCADE
);

-- Tabla de ejecución
CREATE TABLE ejecucion (
    id_ejecucion INT PRIMARY KEY AUTO_INCREMENT,
    id_detalle INT NOT NULL,
    cumplimiento ENUM('SI', 'NO', 'PARCIAL') DEFAULT 'NO',
    resultado TEXT,
    fecha_ejecucion DATE NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_detalle) REFERENCES plan_detalle(id_detalle) ON DELETE CASCADE
);

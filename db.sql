-- Crear base de datos
CREATE DATABASE IF NOT EXISTS misas_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE misas_db;

-- =========================
-- Tabla: Ciudades
-- =========================
CREATE TABLE Ciudades (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    UNIQUE (Nombre)
) ENGINE=InnoDB;

-- =========================
-- Tabla: Roles
-- =========================
CREATE TABLE Roles (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(255),
    UNIQUE (Nombre)
) ENGINE=InnoDB;

-- =========================
-- Tabla: TipoLocaciones
-- =========================
CREATE TABLE TipoLocaciones (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL,
    Descripcion VARCHAR(255),
    UNIQUE (Nombre)
) ENGINE=InnoDB;

-- =========================
-- Tabla: Colonias
-- =========================
CREATE TABLE Colonias (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(100) NOT NULL,
    CiudadId INT NOT NULL,
    UNIQUE (Nombre, CiudadId),
    CONSTRAINT FK_Colonias_Ciudades
        FOREIGN KEY (CiudadId)
        REFERENCES Ciudades(Id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =========================
-- Tabla: Usuarios
-- =========================
CREATE TABLE Usuarios (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Usuario VARCHAR(20) NOT NULL,
    Nombre VARCHAR(100) NOT NULL,
    Password VARCHAR(255) NOT NULL,
    RolId INT NOT NULL,
    UNIQUE (Usuario),
    CONSTRAINT FK_Usuarios_Roles
        FOREIGN KEY (RolId)
        REFERENCES Roles(Id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =========================
-- Tabla: Locaciones
-- =========================
CREATE TABLE Locaciones (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(150) NOT NULL,
    Direccion VARCHAR(500) NOT NULL,
    ColoniaId INT NOT NULL,
    Telefono VARCHAR(20),
    TipoLocacionId INT NOT NULL,
    UNIQUE (Nombre, TipoLocacionId, ColoniaId),
    INDEX IDX_Locaciones_Nombre (Nombre),
    CONSTRAINT FK_Locaciones_Colonias
        FOREIGN KEY (ColoniaId)
        REFERENCES Colonias(Id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE,
    CONSTRAINT FK_Locaciones_TipoLocaciones
        FOREIGN KEY (TipoLocacionId)
        REFERENCES TipoLocaciones(Id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =========================
-- Tabla: UsuariosLocaciones
-- =========================
CREATE TABLE UsuariosLocaciones (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    UsuarioId INT NOT NULL,
    LocacionId INT NOT NULL,
    UNIQUE (UsuarioId, LocacionId),
    CONSTRAINT FK_UsuariosLocaciones_Usuarios
        FOREIGN KEY (UsuarioId)
        REFERENCES Usuarios(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT FK_UsuariosLocaciones_Locaciones
        FOREIGN KEY (LocacionId)
        REFERENCES Locaciones(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- =========================
-- Tabla: Horarios
-- =========================
CREATE TABLE Horarios (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    LocacionId INT NOT NULL,
    DiaSemana TINYINT NOT NULL,
    Hora TIME NOT NULL,
    Activo TINYINT(1) NOT NULL DEFAULT 1,
    Notas TEXT,
    UNIQUE (LocacionId, DiaSemana, Hora),
    INDEX IDX_Horarios_Locacion_Dia (LocacionId, DiaSemana),
    INDEX IDX_Horarios_Dia_Hora (DiaSemana, Hora),
    CONSTRAINT FK_Horarios_Locaciones
        FOREIGN KEY (LocacionId)
        REFERENCES Locaciones(Id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;
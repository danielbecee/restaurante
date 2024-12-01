-- Eliminar la base de datos si ya existe
DROP DATABASE IF EXISTS `DB_restaurante`;

-- Crear la base de datos
CREATE DATABASE `DB_restaurante` DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;
USE `DB_restaurante`;

-- Crear tabla Sala
CREATE TABLE Sala (
    ID_sala INT PRIMARY KEY AUTO_INCREMENT,
    nombre_sala VARCHAR(50) NOT NULL UNIQUE,
    tipo_sala VARCHAR(20) NOT NULL,
    capacidad_total INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla Camarero
CREATE TABLE Camarero (
    ID_camarero INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    usuario VARCHAR(30) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla Mesa
CREATE TABLE Mesa (
    ID_mesa INT PRIMARY KEY AUTO_INCREMENT,
    ID_sala INT NOT NULL,
    capacidad INT NOT NULL,
    estado ENUM('libre', 'ocupada') NOT NULL DEFAULT 'libre',
    FOREIGN KEY (ID_sala) REFERENCES Sala(ID_sala) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla Ocupacion
CREATE TABLE Ocupacion (
    ID_ocupacion INT AUTO_INCREMENT PRIMARY KEY,
    ID_mesa INT NOT NULL,
    ID_camarero INT NOT NULL,
    fecha_hora_inicio DATETIME NOT NULL,
    fecha_hora_final DATETIME DEFAULT NULL,
    estado_anterior VARCHAR(50) NOT NULL,
    estado_actual VARCHAR(50) NOT NULL,
    FOREIGN KEY (ID_mesa) REFERENCES Mesa(ID_mesa),
    FOREIGN KEY (ID_camarero) REFERENCES Camarero(ID_camarero)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuarios con contraseñas hasheadas
INSERT INTO Camarero (nombre, usuario, contrasena) VALUES
    ('Daniel Becerra', 'daniel', '$2y$10$idwVgm9zxwp9jJR4435i8uclqcuejIx5j2t8f3BbR53nlAOPpIo2S'),
    ('Laura Rodríguez', 'laura', '$2y$10$idwVgm9zxwp9jJR4435i8uclqcuejIx5j2t8f3BbR53nlAOPpIo2S'),
    ('Pedro Gómez', 'pedro', '$2y$10$idwVgm9zxwp9jJR4435i8uclqcuejIx5j2t8f3BbR53nlAOPpIo2S');

-- Insertar nuevas Salas
INSERT INTO Sala (nombre_sala, tipo_sala, capacidad_total) VALUES
    ('Sala Comedor Este', 'Comedor Este', 12),
    ('Sala Comedor Oeste', 'Comedor Oeste', 10),
    ('Sala Privada Este', 'Privada Este', 18),
    ('Sala Privada Oeste', 'Privada Oeste', 12),
    ('Sala Privada Sud', 'Privada Sud', 14),
    ('Sala Terraza Este', 'Terraza Este', 20),
    ('Sala Terraza Oeste', 'Terraza Oeste', 16),
    ('Sala Terraza Sud', 'Terraza Sud', 15);

-- Insertar nuevas Mesas usando los IDs de salas directamente (sin subconsultas)
INSERT INTO Mesa (ID_sala, capacidad, estado) VALUES
    -- Comedor Este
    (1, 6, 'libre'),
    (1, 6, 'libre'),
    -- Comedor Oeste
    (2, 4, 'libre'),
    (2, 6, 'libre'),
    -- Privada Este
    (3, 9, 'libre'),
    (3, 9, 'libre'),
    -- Privada Oeste
    (4, 6, 'libre'),
    (4, 6, 'libre'),
    -- Privada Sud
    (5, 5, 'libre'),
    (5, 9, 'libre'),
    -- Terraza Este
    (6, 10, 'libre'),
    (6, 10, 'libre'),
    -- Terraza Oeste
    (7, 10, 'libre'),
    (7, 6, 'libre'),
    -- Terraza Sud
    (8, 5, 'libre'),
    (8, 10, 'libre');

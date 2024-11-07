-- Eliminar la base de datos si ya existe
DROP DATABASE IF EXISTS `DB_restaurante`;

-- Crear la base de datos
CREATE DATABASE `DB_restaurante` DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;
USE `DB_restaurante`;

-- Crear tabla Sala
CREATE TABLE Sala (
                      ID_sala INT PRIMARY KEY AUTO_INCREMENT,
                      nombre_sala VARCHAR(50) NOT NULL UNIQUE,
                      tipo_sala VARCHAR(20) NOT NULL,
                      capacidad_total INT NOT NULL CHECK (capacidad_total > 0)
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
                      capacidad INT NOT NULL CHECK (capacidad > 0),
                      estado ENUM('libre', 'ocupada') NOT NULL DEFAULT 'libre',
                      FOREIGN KEY (ID_sala) REFERENCES Sala(ID_sala) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Crear tabla Ocupacion
CREATE TABLE Ocupacion (
                           ID_ocupacion INT PRIMARY KEY AUTO_INCREMENT,
                           ID_mesa INT NOT NULL,
                           ID_camarero INT NOT NULL,
                           fecha_hora_inicio DATETIME NOT NULL,
                           fecha_hora_final DATETIME,
                           FOREIGN KEY (ID_mesa) REFERENCES Mesa(ID_mesa) ON DELETE CASCADE ON UPDATE CASCADE,
                           FOREIGN KEY (ID_camarero) REFERENCES Camarero(ID_camarero) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar usuarios con contraseñas hasheadas (como "daniel15!")
INSERT INTO Camarero (nombre, usuario, contrasena) VALUES
                                                       ('Daniel Becerra', 'daniel', '$2y$10$idwVgm9zxwp9jJR4435i8uclqcuejIx5j2t8f3BbR53nlAOPpIo2S'),
                                                       ('Don', 'don', '$2y$10$idwVgm9zxwp9jJR4435i8uclqcuejIx5j2t8f3BbR53nlAOPpIo2S'),
                                                       ('Algo', 'algo', '$2y$10$idwVgm9zxwp9jJR4435i8uclqcuejIx5j2t8f3BbR53nlAOPpIo2S');

-- Insertar datos en Sala
INSERT INTO Sala (nombre_sala, tipo_sala, capacidad_total) VALUES
                                                               ('Sala Comedor 1', 'Comedor', 30),
                                                               ('Sala Comedor 2', 'Comedor', 25),
                                                               ('Sala Terraza 1', 'Terraza', 50),
                                                               ('Sala Terraza 2', 'Terraza', 50),
                                                               ('Sala Terraza 3', 'Terraza', 50),
                                                               ('Sala Privada 1', 'Privada', 25),
                                                               ('Sala Privada 2', 'Privada', 15),
                                                               ('Sala Privada 3', 'Privada', 10)
                                                    ;

-- Insertar nuevas Mesas usando las IDs de salas que existen
INSERT INTO Mesa (ID_sala, capacidad, estado) VALUES
                                                  (1, 4, 'libre'), -- Sala Principal
                                                  (1, 4, 'ocupada'), -- Sala Principal
                                                  (2, 2, 'libre'), -- Sala Privada
                                                  (3, 6, 'libre'), -- Sala Terraza
                                                  (4, 10, 'libre'); -- Sala Conferencias

-- Insertar datos en Ocupacion
INSERT INTO Ocupacion (ID_mesa, ID_camarero, fecha_hora_inicio, fecha_hora_final) VALUES
                                                                                      (1, 1, NOW(), NULL),
                                                                                      (2, 2, NOW(), NULL),
                                                                                      (3, 3, NOW(), NULL),
                                                                                      (4, 1, NOW(), NULL),
                                                                                      (5, 2, NOW(), NULL);
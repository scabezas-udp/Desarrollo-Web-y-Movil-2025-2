CREATE TABLE apellido_orden (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO apellido_orden (nombre, activo) VALUES ('Apellido Paterno Primero', 1), ('Apellido Materno Primero', 1);

CREATE TABLE documento_identidad_tipo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO documento_identidad_tipo (nombre, activo) VALUES ('Cédula de Identidad', 1), ('Licencia de Conducir', 1);

CREATE TABLE genero (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO genero (nombre, activo) VALUES ('Femenino', 1), ('Masculino', 1);

CREATE TABLE nacionalidad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO nacionalidad (nombre, activo) VALUES ('Chilena', 1), ('Venezolana', 1), ('Colombiana', 1), ('Peruana', 1), ('Haitiana', 1);

-- PERSONA
CREATE TABLE persona (
    id INT PRIMARY KEY AUTO_INCREMENT,
    fecha_nacimiento DATE NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0
);

CREATE TABLE documento_identidad (
    id INT PRIMARY KEY AUTO_INCREMENT,
    valor VARCHAR(50) NOT NULL,
    persona_id INT NOT NULL,
    nombres VARCHAR(50) NOT NULL,
    apellido_paterno VARCHAR(50) NOT NULL, 
    apellido_materno VARCHAR(50) NOT NULL, 
    orden_apeliido_id INT(1) NOT NULL, 
    nacionalidad_id INT NOT NULL,
    genero_id INT NOT NULL, 
    documento_tipo_id INT NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (persona_id) REFERENCES persona(id),
    FOREIGN KEY (orden_apeliido_id) REFERENCES apellido_orden(id),
    FOREIGN KEY (nacionalidad_id) REFERENCES nacionalidad(id),
    FOREIGN KEY (genero_id) REFERENCES genero(id),
    FOREIGN KEY (documento_tipo_id) REFERENCES documento_identidad_tipo(id)
);

INSERT INTO persona (id, fecha_nacimiento,activo) VALUES (1, '1987-08-06', 1);
INSERT INTO documento_identidad (valor, persona_id, nombres, apellido_paterno, apellido_materno, orden_apeliido_id, nacionalidad_id, genero_id, documento_tipo_id, activo) VALUES
('16.571.375-3', 1, 'Sebastian Alejandro', 'Cabezas', 'Ríos', 1, 1, 2, 1, 1),
('123.123-1', 1, 'Sebastian Alejandro', 'Cabezas', 'Ríos', 1, 1, 2, 2, 1);
    

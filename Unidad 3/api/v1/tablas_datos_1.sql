-- entidades debiles
CREATE TABLE nacionalidad (
    id INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0
);

CREATE TABLE genero (
    id INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0
);

CREATE TABLE documento_identidad_tipo (
    id INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0
);

CREATE TABLE apellido_orden (
    id INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0
);

CREATE TABLE medio_contacto (
    id INT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0
);

CREATE TABLE persona (
    id INT PRIMARY KEY AUTO_INCREMENT,
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

CREATE TABLE persona_medios_contacto (
    id INT PRIMARY KEY AUTO_INCREMENT,
    persona_id INT NOT NULL,
    medio_contacto_id INT NOT NULL,
    valor VARCHAR(100) NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0
);

-- INSERTS

INSERT INTO persona (id, activo) VALUES (1,1);
INSERT INTO documento_identidad (valor, persona_id, nombres, apellido_paterno, apellido_materno, orden_apeliido_id, nacionalidad_id, genero_id, documento_tipo_id, activo) 
VALUES('16.571.375-3', 1, 'Sebastian Alejandro', 'Cabezas', 'Ríos', 1, 1, 2, 1, 1); 
INSERT INTO persona_medios_contacto (persona_id, medio_contacto_id, valor, activo) 
VALUES (1, 2, 'sebastian.cabezas@umayor.cl', 1);

-- SELECT
SELECT 
	per.id persona_id, 
    docid.id documento_identidad_id, 
    docid.valor documento_identidad_valor,
    docid.nombres documento_identidad_nombres, 
    docid.apellido_paterno documento_identidad_apellido_paterno, 
    docid.apellido_materno documento_identidad_apellido_materno, 
    docid.orden_apeliido_id documento_identidad_orden_apellido_id,
    apor.nombre documento_identidad_orden_apellido_nombre,
    docid.nacionalidad_id documento_identidad_nacionalidad_id,
    naci.nombre documento_identidad_nacionalidad_nombre,
    docid.genero_id documento_identidad_genero_id,
    gene.nombre documento_identidad_genero_nombre,
    docid.documento_tipo_id documento_identidad_tipo_id,
    docidti.nombre documento_identidad_tipo_nombre
FROM persona per 
	INNER JOIN documento_identidad docid ON per.id = docid.persona_id
    INNER JOIN apellido_orden apor ON docid.orden_apeliido_id = apor.id
    INNER JOIN nacionalidad naci ON docid.nacionalidad_id = naci.id
    INNER JOIN genero gene ON docid.genero_id = gene.id
    INNER JOIN documento_identidad_tipo docidti ON docid.documento_tipo_id = docidti.id;
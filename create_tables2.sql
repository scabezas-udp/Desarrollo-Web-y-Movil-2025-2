CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL,
    persona_id INT NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (persona_id) REFERENCES persona(id)
);
INSERT INTO usuario (username, password, persona_id, activo) VALUES ('sebastian.cabezas@mail.udp.cl', MD5('holaUDP'), 1, 1);

CREATE TABLE billetera (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL UNIQUE,
    saldo INT(9) NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuario (id)
);
INSERT INTO billetera (usuario_id, saldo, activo) VALUES (1, 10000, 1);

CREATE TABLE bill_hist_reg_tipo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    suma INT(1) NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO bill_hist_reg_tipo (nombre, suma, activo) VALUES ('Bono Bienvenida', 1, 1),('Apuesta', -1 , 1), ('Retiro', -1, 1), ('Abono', 1, 1), ('Gana',1,1);

CREATE TABLE juego_color (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO juego_color (nombre, activo) VALUES ('Negro', 1), ('Rojo', 1), ('Verde', 1);

CREATE TABLE juego (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(5000) NOT NULL,
    reglas_url VARCHAR(5000),
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO juego (nombre, descripcion, reglas_url) VALUES ('Ruleta UDP','Una ruleta de que hizo el profe Seba Cabezas como prueba', 'https://#');

CREATE TABLE juego_opcion_apuesta (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    pago INT NOT NULL,
    juego_id INT NOT NULL,
    color_id INT,
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (juego_id) REFERENCES juego (id),
    FOREIGN KEY (color_id) REFERENCES juego_color (id)
);

INSERT INTO juego_opcion_apuesta (nombre, pago, juego_id, color_id, activo) VALUES 
('Rojo', 1, 1, 2, 1),
('Negro', 1, 1, 1, 1),
('Bajos (1 al 18)', 1, 1, null, 1),
('Altos (19 al 36)', 1, 1, null, 1),
('Primera Docena (1 al 12)', 2, 1, null, 1),
('Segunda Docena (13 al 24)', 2, 1, null, 1),
('Tercera Docena (25 al 36)', 2, 1, null, 1),
('Columna 1', 2, 1, null, 1),
('Columna 2', 2, 1, null, 1),
('Columna 3', 2, 1, null, 1),
('0 Pleno', 35, 1, null, 1),
('1 Pleno', 35, 1, null, 1),
('2 Pleno', 35, 1, null, 1),
('3 Pleno', 35, 1, null, 1),
('4 Pleno', 35, 1, null, 1),
('5 Pleno', 35, 1, null, 1),
('6 Pleno', 35, 1, null, 1),
('7 Pleno', 35, 1, null, 1),
('8 Pleno', 35, 1, null, 1),
('9 Pleno', 35, 1, null, 1),
('10 Pleno', 35, 1, null, 1),
('11 Pleno', 35, 1, null, 1),
('12 Pleno', 35, 1, null, 1),
('13 Pleno', 35, 1, null, 1),
('14 Pleno', 35, 1, null, 1),
('15 Pleno', 35, 1, null, 1),
('16 Pleno', 35, 1, null, 1),
('17 Pleno', 35, 1, null, 1),
('18 Pleno', 35, 1, null, 1),
('19 Pleno', 35, 1, null, 1),
('20 Pleno', 35, 1, null, 1),
('21 Pleno', 35, 1, null, 1),
('22 Pleno', 35, 1, null, 1),
('23 Pleno', 35, 1, null, 1),
('24 Pleno', 35, 1, null, 1),
('25 Pleno', 35, 1, null, 1),
('26 Pleno', 35, 1, null, 1),
('27 Pleno', 35, 1, null, 1),
('28 Pleno', 35, 1, null, 1),
('29 Pleno', 35, 1, null, 1),
('30 Pleno', 35, 1, null, 1),
('31 Pleno', 35, 1, null, 1),
('32 Pleno', 35, 1, null, 1),
('33 Pleno', 35, 1, null, 1),
('34 Pleno', 35, 1, null, 1),
('35 Pleno', 35, 1, null, 1),
('36 Pleno', 35, 1, null, 1)
;

CREATE TABLE mesa_estado (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO mesa_estado (nombre, activo) VALUES 
('Disponible', 1),
('Cerrada', 1);

CREATE TABLE mesa (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    juego_id INT NOT NULL,
    monto_min INT NOT NULL,
    monto_max INT NOT NULL,
    estado_id INT NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (juego_id) REFERENCES juego (id),
    FOREIGN KEY (estado_id) REFERENCES mesa_estado (id)
);
INSERT INTO mesa (nombre, juego_id, monto_min, monto_max, estado_id, activo) VALUES
('Mesa Ruleta 5.000', 1, 5000, 50000, 1, 1),
('Mesa Ruleta 10.000', 1,10000, 100000, 1, 1);

CREATE TABLE mesa_historico (
    id INT PRIMARY KEY AUTO_INCREMENT,
    mesa_id INT NOT NULL,
    numero INT NOT NULL,
    fecha_hora DATETIME NOT NULL DEFAULT NOW(),
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (mesa_id) REFERENCES mesa (id)
);

CREATE TABLE partida_estado (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO partida_estado (nombre, activo) VALUES ('Apuestas', 1), ('Esperando resultado', 1), ('Pagando', 1);

CREATE TABLE partida_resultado (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    activo INT(1) NOT NULL DEFAULT 0
);
INSERT INTO partida_resultado (nombre, activo) VALUES ('Casa Gana', 1), ('Jugador Gana', 1);

CREATE TABLE partida (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    mesa_id INT NOT NULL,
    estado_Id INT NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuario (id),
    FOREIGN KEY (mesa_id) REFERENCES mesa (id),
    FOREIGN KEY (estado_Id) REFERENCES partida_estado (id)
);

CREATE TABLE partida_detalle (
    id INT PRIMARY KEY AUTO_INCREMENT,
    partida_id INT NOT NULL,
    opcion_id INT NOT NULL,
    resultado_id INT NOT NULL,
    fecha_hora DATETIME NOT NULL DEFAULT NOW(),
    cantidad INT NOT NULL,
    monto INT NOT NULL,
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (partida_id) REFERENCES partida (id),
    FOREIGN KEY (opcion_id) REFERENCES juego_opcion_apuesta (id),
    FOREIGN KEY (resultado_id) REFERENCES partida_resultado (id)
);

CREATE TABLE billetera_historial (
    id INT PRIMARY KEY AUTO_INCREMENT,
    billetera_id INT NOT NULL,
    fecha DATETIME NOT NULL,
    tipo_id INT NOT NULL,
    monto INT(9) NOT NULL,
    partida_id INT,
    activo INT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (billetera_id) REFERENCES billetera (id),
    FOREIGN KEY (tipo_id) REFERENCES bill_hist_reg_tipo (id),
	FOREIGN KEY (partida_id) REFERENCES partida (id)
);

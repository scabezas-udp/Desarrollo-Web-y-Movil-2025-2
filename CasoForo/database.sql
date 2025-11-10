-- TABLA 'foro_usuario'
CREATE TABLE foro_usuario (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    username    VARCHAR(50) NOT NULL UNIQUE,
    password    VARCHAR(32) NOT NULL,
    email       VARCHAR(50) NOT NULL UNIQUE,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    activo      TINYINT(1) DEFAULT 0 NOT NULL
);

-- TABLA 'foro_categoria'
CREATE TABLE foro_categoria (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    nombre      VARCHAR(50) NOT NULL UNIQUE,
    descripcion VARCHAR(500) NOT NULL UNIQUE,
    super_id    INT,
    activo      TINYINT(1) DEFAULT 0 NOT NULL,
    CONSTRAINT FK_CATE_SUPER_ID FOREIGN KEY (super_id) REFERENCES foro_categoria(id)
);

-- TABLA 'foro_entrada'
CREATE TABLE foro_entrada (
    id              INT PRIMARY KEY AUTO_INCREMENT,
    titulo          VARCHAR(50) NOT NULL UNIQUE,
    contenido       VARCHAR(500) NOT NULL UNIQUE,
    created_at      DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    categoria_id    INT NOT NULL,
    usuario_id      INT NOT NULL,
    activo          TINYINT(1) DEFAULT 0 NOT NULL,
    CONSTRAINT FK_ENTR_CATE_ID FOREIGN KEY (categoria_id) REFERENCES foro_categoria(id),
    CONSTRAINT FK_ENTR_USUA_ID FOREIGN KEY (usuario_id) REFERENCES foro_usuario(id)
);

-- TABLA 'foro_comentario'
CREATE TABLE foro_comentario (
    id          INT PRIMARY KEY AUTO_INCREMENT,
    entrada_id  INT NOT NULL,
    texto       VARCHAR(500) NOT NULL UNIQUE,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    usuario_id  INT NOT NULL,
    activo      TINYINT(1) DEFAULT 0 NOT NULL,
    CONSTRAINT FK_COME_ENTR_ID FOREIGN KEY (entrada_id) REFERENCES foro_entrada(id),
    CONSTRAINT FK_COME_USUA_ID FOREIGN KEY (usuario_id) REFERENCES foro_usuario(id)
);


-- DML para MySQL
-- Se omiten las SECUENCIAS y el campo ID en el INSERT para usar AUTO_INCREMENT
-- Los IDs generados serán 1, 2, 3, ...

-- INSERCIÓN EN foro_usuario
INSERT INTO foro_usuario (username, password, email, activo)
VALUES ('scabezas', md5('hola'),'scabezas@scabezas.cl', 1); -- ID 1
INSERT INTO foro_usuario (username, password, email, activo)
VALUES ('lcalquin', md5('hola'), 'lcalquin@um.cl', 1); -- ID 2
INSERT INTO foro_usuario (username, password, email, activo)
VALUES ('ehenriquez', md5('hola'), 'ehenriquez@um.cl', 1); -- ID 3
INSERT INTO foro_usuario (username, password, email, activo)
VALUES ('rgres', md5('hola'), 'rgres@um.cl', 1); -- ID 4
INSERT INTO foro_usuario (username, password, email, activo)
VALUES ('nrios', md5('hola'), 'nrios@um.cl', 1); -- ID 5
INSERT INTO foro_usuario (username, password, email, activo)
VALUES ('amontaner', md5('hola'), 'amontaner@um.cl', 1); -- ID 6

-- INSERCIÓN EN foro_categoria
INSERT INTO foro_categoria (nombre, descripcion, super_id, activo)
VALUES ('Hagalo Ud Mismo', 'Ven y comparte tus creaciones, ideas o soluciones. Aquí encontraras datos y tips, de como fabricar novedosos inventos en tu hogar, entre y disfrute creando!...', NULL, 1); -- ID 1
INSERT INTO foro_categoria (nombre, descripcion, super_id, activo)
VALUES ('Hogar', 'Cosas del hogar', 1, 1); -- ID 2
INSERT INTO foro_categoria (nombre, descripcion, super_id, activo)
VALUES ('Entretencion', 'Jueguitos', 1, 1); -- ID 3

-- INSERCIÓN EN foro_entrada
-- **CORRECCIÓN DE ID:** El valor '21' en la entrada original de Oracle parece ser un error de copia.
-- Si la categoría se insertó como ID=1, ID=2 e ID=3 (como se espera con las secuencias), usaré los IDs 2 y 3.
-- Usaré los IDs que generó la inserción anterior: Categoria ID 2 y Categoria ID 3.
-- Usuario ID 1 y Usuario ID 2.
INSERT INTO foro_entrada (titulo, contenido, categoria_id, usuario_id, activo)
VALUES ('Jardin Flotante', 'Hagalo asi, uno dos', 2, 1, 1); -- ID 1
INSERT INTO foro_entrada (titulo, contenido, categoria_id, usuario_id, activo)
VALUES ('Mesa de Pool', 'Hagalo de esta otra forma', 3, 2, 1); -- ID 2

-- INSERCIÓN EN foro_comentario
-- Entrada ID 1, Usuario ID 3
INSERT INTO foro_comentario (entrada_id, texto, usuario_id, activo)
VALUES (1, 'No es flotante, está en tierra', 3, 1); -- ID 1
-- Entrada ID 1, Usuario ID 4
INSERT INTO foro_comentario (entrada_id, texto, usuario_id, activo)
VALUES (1, 'Si es flotante, está en el agua', 4, 1); -- ID 2
-- Entrada ID 1, Usuario ID 5
INSERT INTO foro_comentario (entrada_id, texto, usuario_id, activo)
VALUES (1, 'Me aburro, prefiero jugar en el telefono', 5, 1); -- ID 3
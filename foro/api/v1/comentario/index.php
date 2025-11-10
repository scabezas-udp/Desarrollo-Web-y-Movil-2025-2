<?php

include_once '../version.php';

switch ($_method) {
    case 'GET':
        if ($_authorization === 'Bearer udp.2025') {

            include_once '../conexion.php';
            include_once 'modelo.php';

            $modelo = new Comentario();

            if (isset($_parametroID)) {
                //echo '-'.$_parametroID;
                $data = $modelo->getByEntradaId($_parametroID);

                if (count($data) > 0) {
                    http_response_code(200);
                    echo json_encode($data);
                    die();
                }
                http_response_code(404);
                echo json_encode(['error' => 'No encontrado']);
                die();
            } else {
                //echo 'son todos';
                http_response_code(200);
                echo json_encode($data);
                die();
            }
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'El cliente no posee los permisos necesarios para cierto contenido, por lo que el servidor está rechazando otorgar una respuesta apropiada.']);
            die();
        }
        break;
    case 'POST':
        if ($_authorization === 'Bearer udp.2025') {
            include_once '../conexion.php';
            include_once 'modelo.php';

            $modelo = new Comentario();
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $body = json_decode(file_get_contents("php://input", true));

            $modelo->setTexto($body->texto);
            $modelo->setEntradaId($body->entrada_id);
            $modelo->setUsuarioId($body->usuario_id);

            $respuesta = $modelo->add($modelo);

            if ($respuesta) {
                http_response_code(201);
                echo json_encode(['mensaje' => 'Creado Exitosamente']);
                die();
            }
            http_response_code(409);
            echo json_encode(['error' => 'No se logró crear el registro']);
            die();
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'El cliente no posee los permisos necesarios para cierto contenido, por lo que el servidor está rechazando otorgar una respuesta apropiada.']);
            die();
        }
        break;
    case 'PUT':
        if ($_authorization === 'Bearer udp.2025') {
            include_once '../conexion.php';
            include_once 'modelo.php';

            $modelo = new Comentario();
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $body = json_decode(file_get_contents("php://input", true));

            $modelo->setId($body->id);
            $modelo->setTexto($body->texto);
            $modelo->setEntradaId($body->entrada_id);
            $modelo->setUsuarioId($body->usuario_id);

            $respuesta = $modelo->update($modelo);

            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Actualizado Exitosamente']);
                die();
            }
            http_response_code(409);
            echo json_encode(['error' => 'No se logró actualizar el registro']);
            die();
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'El cliente no posee los permisos necesarios para cierto contenido, por lo que el servidor está rechazando otorgar una respuesta apropiada.']);
            die();
        }
        break;
    case 'DELETE':
        if ($_authorization === 'Bearer udp.2025') {
            include_once '../conexion.php';
            include_once 'modelo.php';

            $modelo = new Comentario();
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $body = json_decode(file_get_contents("php://input", true));

            $modelo->setId($body->id);
            $respuesta = $modelo->disable($modelo);

            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Eliminado Exitosamente']);
                die();
            }
            http_response_code(409);
            echo json_encode(['error' => 'No se logró eliminar el registro']);
            die();
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'El cliente no posee los permisos necesarios para cierto contenido, por lo que el servidor está rechazando otorgar una respuesta apropiada.']);
            die();
        }
        break;
    case 'PATCH':
        if ($_authorization === 'Bearer udp.2025') {
            include_once '../conexion.php';
            include_once 'modelo.php';

            $modelo = new Comentario();
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $body = json_decode(file_get_contents("php://input", true));

            $modelo->setId($body->id);
            $respuesta = $modelo->enable($modelo);

            if ($respuesta) {
                http_response_code(200);
                echo json_encode(['mensaje' => 'Habilitado Exitosamente']);
                die();
            }
            http_response_code(409);
            echo json_encode(['error' => 'No se logró habilitar el registro']);
            die();
        } else {
            http_response_code(403);
            echo json_encode(['error' => 'El cliente no posee los permisos necesarios para cierto contenido, por lo que el servidor está rechazando otorgar una respuesta apropiada.']);
            die();
        }
        break;
    default:
        http_response_code(501);
        echo json_encode(['error' => 'Método [' . $_method . '] no implementado']);
        break;
}

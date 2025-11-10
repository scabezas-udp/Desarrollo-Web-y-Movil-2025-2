<?php

include_once '../version.php';

switch ($_method) {
    case 'POST':
        if ($_authorization === 'Bearer udp.2025') {

            include_once '../conexion.php';
            include_once 'modelo.php';

            $modelo = new Usuario();

            $body = json_decode(file_get_contents("php://input", true));

            // si tiene usuario y contraseña
            if (isset($body->username) && isset($body->password)) {
                $existe = $modelo->getByUsernamePassword($body->username, $body->password);
                if ($existe['activo']) {
                    http_response_code(200);
                    echo json_encode(['usuario' => $existe]);
                    die();
                } else {
                    http_response_code(404);
                    echo json_encode(['usuario' => "No encontrado"]);
                    die();
                }
            }
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

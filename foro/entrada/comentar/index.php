<?php
session_start();
//var_dump($_POST);
// var_dump($_POST['id']);

// 1. Verificar que el usuario esté logueado Y que los datos existan
if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true && isset($_SESSION['user_data'])) {
    // 2. Asignar el ID
    // Asumo que la API devuelve el ID en una clave 'id'. 
    // Si la API lo entrega como 'usuario_id' o similar, cambia 'id' aquí:
    if (isset($_SESSION['user_data']['id'])) {
        $user_id_actual = $_SESSION['user_data']['id'];
        // var_dump($user_id_actual);
        $api_url = 'https://udp.coningenio.cl/foro/api/v1/comentario/';
        $auth_token = 'udp.2025'; // ¡El token secreto!
        $post_data = null;
        if (isset($_POST['accion'])  && $_POST['accion'] == 'nuevo') {
            $post_data = json_encode([
                'entrada_id' => $_POST['entrada_id'],
                'texto' => $_POST['comentario'],
                'usuario_id' => $user_id_actual
            ]);

            // 3. Inicializar cURL
            $ch = curl_init($api_url);

            // 4. Configurar las opciones de cURL para la petición POST
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

            // **¡ACTUALIZACIÓN CRÍTICA AQUÍ!**
            // Se añade la cabecera Authorization: Bearer <token>
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($post_data),
                'Authorization: Bearer ' . $auth_token // <--- ESTA ES LA LÍNEA CLAVE
            ]);

            // 5. Ejecutar la petición y obtener el resultado
            $response = curl_exec($ch);

            // 6. Obtener el código de estado HTTP
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // 7. Cerrar la sesión cURL
            curl_close($ch);
        } else if (isset($_POST['accion']) && $_POST['accion'] == 'editar') {
            // echo 'editando...';
            $post_data = json_encode([
                'id' => $_POST['id'],
                'texto' => $_POST['comentario'],
                'usuario_id' => $user_id_actual
            ]);
            // var_dump($_POST);

            // 3. Inicializar cURL
            $ch = curl_init($api_url);

            // 4. Configurar las opciones de cURL para la petición PUT
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($ch, CURLOPT_PUT, true); // <--- ESTA LÍNEA ES INCORRECTA para enviar datos
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // <-- ESTA ES LA LÍNEA CORRECTA
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

            // **¡ACTUALIZACIÓN CRÍTICA AQUÍ!**
            // Se añade la cabecera Authorization: Bearer <token>
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($post_data),
                'Authorization: Bearer ' . $auth_token // <--- ESTA ES LA LÍNEA CLAVE
            ]);

            // 5. Ejecutar la petición y obtener el resultado
            $response = curl_exec($ch);

            // var_dump($response);

            // 6. Obtener el código de estado HTTP
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            // 7. Cerrar la sesión cURL
            curl_close($ch);
        }

        header('Location: ../?id=' . $_POST['entrada_id']); // retorna al mismo id de entrada
    } else {
        // Manejar error si la sesión está corrupta o la API no trajo 'id'
        // echo "Error: La sesión es válida pero no se encontró el 'id' del usuario.";
        echo 'Error: Usuario no encontrado';
    }
} else {
    // El usuario no está logueado o la sesión expiró
    // Aquí podrías redirigir al login:
    // header('Location: /login.php');
    // exit();
    echo 'Error: Usuario sin login';
}

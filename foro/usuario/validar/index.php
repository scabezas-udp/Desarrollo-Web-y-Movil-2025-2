<?php
// 1. Iniciar la sesión de PHP
session_start();

// 2. Definir el endpoint, los datos y el token
$api_url = 'https://udp.coningenio.cl/foro/api/v1/usuario/';
$auth_token = 'udp.2025'; // ¡El token secreto!

// Asegúrate de que los parámetros POST existen antes de usarlos
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    header('Location: login.php?error=missing_fields');
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

$post_data = json_encode([
    'username' => $username,
    'password' => $password
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

// 8. Procesar la respuesta
if ($http_code == 200) {
    // **Usuario Válido**
    $user_data = json_decode($response, true);
    $_SESSION['is_logged_in'] = true;
    $_SESSION['user_data'] = $user_data; 
    
    header('Location: ../../');
    exit();
    
} elseif ($http_code == 404) {
    // **Usuario No Válido**
    $error_message = "Credenciales incorrectas. Inténtalo de nuevo.";
    header('Location: login.php?error=' . urlencode($error_message));
    exit();

} elseif ($http_code == 401 || $http_code == 403) {
    // Manejar errores de autorización (401 Unauthorized o 403 Forbidden)
    // Esto suele indicar un token Bearer incorrecto o faltante.
    $error_message = "Error de autorización. No se pudo acceder al servicio de validación.";
    header('Location: login.php?error=' . urlencode($error_message));
    exit();
    
} else {
    // Otro error HTTP (ej: 500, 400, etc.)
    $error_message = "Error en la comunicación con el servidor. Código: " . $http_code;
    header('Location: login.php?error=' . urlencode($error_message));
    exit();
}
?>
<?php
// /logout.php

// 1. Iniciar la sesión
session_start();

// 2. Eliminar las variables de sesión
session_unset();

// 3. Destruir la sesión por completo
session_destroy();

// 4. Redirigir al usuario (ejemplo: a la página principal o de login)
header('Location: ../../'); 
exit();
?>
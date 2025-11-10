<?php
// var_dump($_SERVER);
// echo $_SERVER['REQUEST_URI'];
$ruta = '../';
$entrada_id = explode('?id=', $_SERVER['REQUEST_URI'])[1];

include_once '../consumoEndpoint.php';

$endpoint1 = 'https://udp.coningenio.cl/foro/api/v1/entrada/?id=' . $entrada_id;
$token = 'udp.2025';

$endpoint2 = 'https://udp.coningenio.cl/foro/api/v1/comentario/?id=' . $entrada_id;

$entrada = getApiData($endpoint1, $token);
$listaComentarios = getApiData($endpoint2, $token);
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UDP | Foro demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="../dist/css/estilo.css" rel="stylesheet">
</head>

<body>
    <?php include_once '../layout/header.php'; ?>
    <section class="container my-4">
        <div class="card">
            <div class="card-header">
                Entrada
                <h5 class="card-title"><?php echo $entrada['titulo'] ?></h5>
            </div>
            <ul class="list-group list-group-flush">
                <?php
                foreach ($listaComentarios as $comentario) {
                    if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
                        $usuario_crea = ' | Usuario: [' . $comentario['created']['user']['username'] . ']';
                        if ($_SESSION['user_data']['id'] == $comentario['created']['user']['id']) {
                            $usuario_crea .= ' <button class="btn btn-sm btn-primary" onclick="editarComentario(' . $comentario['id'] . ', ' . $entrada['id'] . ',\'' . $comentario['texto'] . '\')">Editar Comentario</button>';
                            if ($comentario['activo']) {
                                $usuario_crea .= ' <button class="btn btn-sm btn-danger" onclick="eliminarComentario(' . $comentario['id'] . ', ' . $entrada['id'] . ')">Eliminar Comentario</button>';
                            } else {
                                $usuario_crea .= ' <button class="btn btn-sm btn-info" onclick="habilitarComentario(' . $comentario['id'] . ')">Habilitar Comentario</button>';
                            }
                        }
                    } else {
                        $usuario_crea = ' | [--inicie sesión para ver más información--]';
                    }
                    echo '
                    <li class="list-group-item">' . $comentario['texto'] . '<br><small>Fecha: ' . $comentario['created']['date'] . $usuario_crea . '</small></li>  
                ';
                }
                ?>
            </ul>
            <?php
            if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
            ?>
                <div class="card-footer">
                    <button type="button" class="btn btn-primary mb-4" onclick="nuevoComentario('<?php echo $entrada_id ?>')">Nuevo Comentario</button>
                    <form id="formulario" class="d-none">

                    </form>
                </div>
            <?php
            }
            ?>
        </div>
        <script>
            function nuevoComentario(_entrada_id) {
                const form = document.getElementById('formulario');
                form.classList.remove('d-none');
                form.action = 'comentar/';
                form.method = 'POST';
                form.innerHTML = '<div class="mb-3"><label for="exampleFormControlTextarea1" class="form-label">Nuevo Comentario</label><input type="hidden" name="entrada_id" value="' + _entrada_id + '"><input type="hidden" name="accion" value="nuevo"><textarea name="comentario" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea></div><button type="submit" class="btn btn-primary">Comentar</button>';
            }

            function editarComentario(_id, _entrada_id, _texto) {
                // console.log('Comentario ID: ' + _id);
                // console.log('Comentario Texto: ' + _texto);
                const form = document.getElementById('formulario');
                form.classList.remove('d-none');
                form.action = 'comentar/';
                form.method = 'POST';
                form.innerHTML = '<div class="mb-3"><label for="exampleFormControlTextarea1" class="form-label">Editar Comentario</label><input type="hidden" name="id" value="' + _id + '"><input type="hidden" name="entrada_id" value="' + _entrada_id + '"><input type="hidden" name="accion" value="editar"><textarea name="comentario" class="form-control" id="exampleFormControlTextarea1" rows="3">' + _texto + '</textarea></div><button type="submit" class="btn btn-primary">Comentar</button>';
            }

            async function eliminarComentario(_id, _entrada_id) {
                // 1. La URL de la API real
                const url = `https://udp.coningenio.cl/foro/api/v1/comentario/?id=${_id}`;

                // 2. 🚨 ¡EL TOKEN SECRETO EXPUESTO!
                // Cualquiera puede ver esto en el "Inspeccionar Elemento" (Pestaña Red o Fuentes).
                const authToken = 'udp.2025';

                try {
                    // 3. Configurar fetch con método DELETE y cabeceras
                    const response = await fetch(url, {
                        method: 'DELETE',
                        headers: {
                            // 4. Aquí se envía el token
                            'Authorization': `Bearer ${authToken}`
                        }
                    });

                    // 5. Manejar la respuesta de la API
                    // (Un DELETE exitoso a menudo no devuelve contenido, código 204)
                    if (response.ok) { // Códigos 200-299
                        alert('Comentario eliminado (mediante JS directo).');

                        // 6. Redirigir como pediste
                        window.location.href = '../entrada/?id=' + _entrada_id;
                    } else {
                        // Si la API devuelve un error (401, 404, 500)
                        const errorData = await response.json().catch(() => ({})); // Intenta leer el error
                        alert(`Error de la API: ${response.status} ${response.statusText}. ` + (errorData.error || ''));
                    }

                } catch (error) {
                    // Captura errores de red (ej. no hay conexión)
                    console.error('Error en la función eliminarComentarioDirecto:', error);
                    alert('Error de conexión. No se pudo completar la solicitud.');
                }
            }

            async function habilitarComentario(_id) {
                // 1. La URL de la API real
                const url = `https://udp.coningenio.cl/foro/api/v1/comentario/?id=${_id}`;

                // 2. 🚨 ¡EL TOKEN SECRETO EXPUESTO!
                // Cualquiera puede ver esto en el "Inspeccionar Elemento" (Pestaña Red o Fuentes).
                const authToken = 'udp.2025';

                try {
                    // 3. Configurar fetch con método DELETE y cabeceras
                    const response = await fetch(url, {
                        method: 'PATCH',
                        headers: {
                            // 4. Aquí se envía el token
                            'Authorization': `Bearer ${authToken}`
                        }
                    });

                    // 5. Manejar la respuesta de la API
                    // (Un PATCH exitoso a menudo no devuelve contenido, código 204)
                    if (response.ok) { // Códigos 200-299
                        alert('Comentario habilitado (mediante JS directo).');

                        // 6. Redirigir como pediste
                        window.location.href = '../';
                    } else {
                        // Si la API devuelve un error (401, 404, 500)
                        const errorData = await response.json().catch(() => ({})); // Intenta leer el error
                        alert(`Error de la API: ${response.status} ${response.statusText}. ` + (errorData.error || ''));
                    }

                } catch (error) {
                    // Captura errores de red (ej. no hay conexión)
                    console.error('Error en la función habilitarComentario:', error);
                    alert('Error de conexión. No se pudo completar la solicitud.');
                }
            }
        </script>
    </section>
</body>
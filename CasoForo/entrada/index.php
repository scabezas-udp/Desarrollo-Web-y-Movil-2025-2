<?php
// var_dump($_SERVER);
// echo $_SERVER['REQUEST_URI'];
$id = explode('?id=', $_SERVER['REQUEST_URI'])[1];

include_once '../consumoEndpoint.php';

$endpoint = 'https://udp.coningenio.cl/foro/api/v1/comentario/?id=' . $id;
$token = 'udp.2025';

$listaComentarios = getApiData($endpoint, $token);
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UDP | Foro demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <div class="card" style="width: 18rem;">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Titulo Entrada: </li>
    <?php
    foreach ($listaComentarios as $comentario) {
        echo '
                <li class="list-group-item">'.$comentario['texto'].'</li>
        ';
    }
    ?>  
    </ul>
            <div class="card-footer">
                Card footer
            </div>
        </div>
</body>
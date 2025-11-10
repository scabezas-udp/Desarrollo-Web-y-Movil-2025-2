<?php
$ruta = '';
include_once('consumoEndpoint.php');
$endpoint = 'https://udp.coningenio.cl/foro/api/v1/entrada/';
$token = 'udp.2025';

$listaEntradas = getApiData($endpoint, $token);
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UDP | Foro demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="dist/css/estilo.css" rel="stylesheet">
</head>

<body>
    <?php include_once 'layout/header.php'; ?>
    <section class="container">
        <h1>Entradas del Foro UDP</h1>
        <hr>
        <?php
        if ($listaEntradas !== null) {
            // echo 'hay entradas';
            foreach ($listaEntradas as $entrada) {
                if ($entrada['activo']) {
                    // echo 'hay entrada para mostrar :)';
                    echo '
                <div class="card my-4">
                    <div class="card-header">
                        Entrada del Foro
                        <h5 class="card-title">' . $entrada['titulo'] . '</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">' . $entrada['contenido'] . '</p>
                        <a href="entrada/?id=' . $entrada['id'] . '" class="btn btn-primary">Ver Comentarios</a>
                    </div>
                </div>
                ';
                }
            }
        }
        ?>
    </section>
    <?php include_once 'layout/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>
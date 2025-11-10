<?php
// var_dump($_SERVER);
// echo $_SERVER['REQUEST_URI'];
$ruta = '../';
$id = explode('?id=', $_SERVER['REQUEST_URI'])[1];

include_once '../consumoEndpoint.php';

$endpoint1 = 'https://udp.coningenio.cl/foro/api/v1/entrada/?id=' . $id;
$token = 'udp.2025';

$endpoint2 = 'https://udp.coningenio.cl/foro/api/v1/comentario/?id=' . $id;

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
                    echo '
                    <li class="list-group-item">' . $comentario['texto'] . '<br><small>Fecha: ' . $comentario['created']['date'] . ' | Usuario: ' . $comentario['created']['usuario'] . '</small></li>
                ';
                }
                ?>
            </ul>
            <?php
            if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
            ?>
                <div class="card-footer">
                    <form action="comentar" method="POST">
                        <div class="mb-3">
                            <label for="exampleFormControlTextarea1" class="form-label">Nuevo Comentario</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Comentar</button>
                    </form>
                </div>
            <?php
            }
            ?>
        </div>
    </section>
</body>
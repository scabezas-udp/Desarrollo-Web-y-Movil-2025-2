<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="bg-dark ">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img class="mx-auto d-block" src="https://www.udp.cl/cms/wp-content/uploads/2021/06/UDP_LogoRGB_2lineas_Blanco_SinFondo.png" width="150px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarText">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link nav-link-active" aria-current="page" href="<?php echo $ruta ?>../foro">Foro</a>
                        </li>
                        <li class="nav-item">
                            <?php
                            // 1. Verificación de la Sesión
                            // Si la variable 'is_logged_in' existe y es verdadera, el usuario está logueado.
                            if (isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true) {
                                // Muestra el botón de CERRAR SESIÓN
                            ?>
                                <a href="<?php echo $ruta ?>usuario/logout/" class="btn btn-danger">
                                    <?php echo $_SESSION['user_data']['username'] ?> | Cerrar Sesión
                                </a>
                            <?php
                            } else {
                                // Muestra el botón de INICIAR SESIÓN
                            ?>
                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#loginModal">
                                    Iniciar Sesión
                                </button>
                            <?php
                            }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="loginModalLabel">Iniciar Sesión</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?php echo $ruta; ?>../foro/usuario/validar/">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Usuario</label>
                        <input type="text" name="username" class="form-control" id="exampleFormControlInput1" placeholder="usuario" value="scabezas">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="exampleFormControlInput1" placeholder="******" value="hola">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Salir</button>
                        <button type="submit" class="btn btn-primary">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
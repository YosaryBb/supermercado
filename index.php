<?php include __DIR__ . '/app/utiles/global.php';?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MercadoAndes</title>
    <!-- Incluye las hojas de estilo de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= assets('css/index.css') ?>">
</head>
<body>
    <div class="container">
        <?php if (sesion()->has('status')): ?>
            <div class="alert alert-danger">
                <?= sesion()->temporal('status')?>
            </div>
        <?php endif;?>
        <div class="row">
            <div class="co l-md-6 offset-md-3 login-container">
                <img src="<?= assets('disco/super.jpg') ?>" alt="SUPERMERCADO" width="150">
                <h2 class="text-center">MercadoAndes</h2>
                <form id="frmLogin" method="POST" action="<?= controller('AutenticarControlador') ?>">
                    <div class="mb-3">
                        <label for="usuario" class="form-label fw-bold">Usuario</label>
                        <input type="text" class="form-control" id="usuario" name="usuario">
                    </div>
                    <div class="mb-3">
                        <label for="clave" class="form-label fw-bold">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave">
                    </div>
                    <button type="submit" class="btn btn-primary form-control btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Incluye los scripts de Bootstrap (jQuery y Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="<?= assets('js/index.js') ?>"></script>
</body>
</html>

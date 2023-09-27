<?php

require __DIR__ ."/../../autoload.php";

use App\Modelos\Autenticacion;
use App\Utiles\Log;

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ../../?status=1500');
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data)) {
        header('Location:../../?status=1230');
        exit;
    }

    if (!isset($data['usuario'])) {
        header('Location:../../?status=1231');
        exit;
    }

    if (!isset($data['clave'])) {
        header('Location:../../?status=1232');
        exit;
    }

    $autenticar = new Autenticacion();

    $respuesta = $autenticar->autenticar($data);
} catch (\Exception $th) {
    Log::set($th);

    header('Location: ../../?status=500');
    exit;
}

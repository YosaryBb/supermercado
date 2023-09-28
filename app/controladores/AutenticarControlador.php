<?php

require __DIR__ ."/../../autoload.php";

use App\Modelos\Autenticacion;
use App\Utiles\Log;
use App\Utiles\Peticion;

try {
    $peticion = new Peticion();

    if (!$peticion->esPost()) {
        $peticion->redireccionar('../../', ['status' => '01-405']);
    }

    $data = $peticion->todo();

    if (empty($data)) {
        $peticion->redireccionar('../../', ['status' => '01-0101']);
    }

    if (isset($data['usuario']) && !strlen($data['usuario']) > 0) {
        $peticion->redireccionar('../../', ['status' => '01-0102']);
    }

    if (isset($data['clave']) && !strlen($data['clave']) > 0) {
        $peticion->redireccionar('../../', ['status' => '01-0103']);
    }

    $autenticar = new Autenticacion();

    $respuesta = $autenticar->autenticar($peticion->escaparArreglo($data));

    if (!$respuesta) {
        $peticion->redireccionar('../../', ['status' => '01-0111']);
    }

    $peticion->redireccionar('../../dashboard/home.html');
} catch (\Exception $th) {
    Log::set($th);

    header('Location: ../../?status=500');
    exit;
}

<?php

require __DIR__ . "/../../autoload.php";
require __DIR__ . "/../utiles/Global.php";

use App\Modelos\Autenticacion;
use App\Utiles\Log;
use App\Utiles\Peticion;

try {
    $peticion = new Peticion();

    if (!$peticion->esPost()) {
        $peticion->redireccionar('../../')->crearTemporal('status', 'El método no es valido.')->redirigir();
    }

    $data = $peticion->todo();

    if (empty($data)) {
        $peticion->redireccionar('../../')->crearTemporal('status', 'Los datos no pueden estar vacíos.')->redirigir();
    }

    if (isset($data['usuario']) && !strlen($data['usuario']) > 0) {
        $peticion->redireccionar('../../')->crearTemporal('status', 'El usuario no puede estar vació.')->redirigir();
    }

    if (isset($data['clave']) && !strlen($data['clave']) > 0) {
        $peticion->redireccionar('../../')->crearTemporal('status', 'La contraseña no puede estar vacía.')->redirigir();
    }

    $autenticar = new Autenticacion();

    $respuesta = $autenticar->autenticar($peticion->escaparArreglo($data));

    if (!$respuesta) {
        $peticion->redireccionar('../../')->crearTemporal('status', 'El usuario o la contraseña son incorrectos.')->redirigir();
    }

    $peticion->redireccionar('../../dashboard/home.html');
} catch (\Exception $th) {
    Log::set($th);

    $peticion->redireccionar('../../')->crearTemporal('status', $th->getMessage())->redirigir();
}

<?php

namespace App\Modelos;

require __DIR__ . '/../../autoload.php';

use DB\Conexion;

class Modelo 
{
    protected $conexion = null;

    public function __construct()
    {
        $conexion = new Conexion();
        $this->conexion = $conexion->obtenerConexion();
    }
}
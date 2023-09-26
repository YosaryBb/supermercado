<?php

namespace DB;

require __DIR__ . '/../config/env.php';
require __DIR__ . '/../autoload.php';

use App\Utiles\Log;
use mysqli;

class Conexion
{
    protected $conexion;

    public function __construct()
    {
        $this->conectar();
    }

    protected function conectar(): void
    {
        try {
            $this->conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE, DB_PORT);

            if($this->conexion->connect_errno){
                throw new \Exception($this->conexion->connect_errno);
            }   
        } catch (\Exception $th) {
            Log::set($th);
        }
    }

    public function obtenerConexion()
    {
        return $this->conexion;
    }

    public function cerrarConexion()
    {
        $this->conexion->close();
    }
}
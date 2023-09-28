<?php

namespace App\Utiles;

use App\Utiles\Log;

class Disco
{
    private $directorio;

    public function __construct()
    {
        $this->directorio = __DIR__ . '/../../recursos/disco/';

        if (!file_exists($this->directorio)) {
            mkdir($this->directorio, 0755, true);
        }
    }

    public function subirArchivo($archivo, $nombreArchivo = null, $subDirectorio = null)
    {
        try {
            if ($nombreArchivo === null) {
                $nombreArchivo = $archivo['name'];
            }

            if ($subDirectorio !== null) {
                $directorioDestino = $this->directorio . $subDirectorio . '/';
            } else {
                $directorioDestino = $this->directorio;
            }

            $rutaArchivo = $directorioDestino . $nombreArchivo;

            if (!file_exists($directorioDestino)) {
                mkdir($directorioDestino, 0755, true);
            }

            if (move_uploaded_file($archivo['tmp_name'], $rutaArchivo)) {
                return $rutaArchivo;
            }

            return false;
        } catch (\Exception $th) {
            Log::set($th);

            return false;
        }
    }
}

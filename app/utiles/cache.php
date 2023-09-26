<?php

namespace App\Utiles;

require __DIR__ . '/../../autoload.php';

class Cache
{
    protected static $directorio = __DIR__ . '/../../tmp/.cache/';
    protected static $expiracion = 86400;

    public function __construct()
    {
        if (!is_dir($this->directorio)) {
            mkdir($this->directorio, 0755, true);
        }
    }

    public static function asignar($llave, $valor, $tiempo = null): void
    {
        try {
            $nombreArchivo = self::generarNombreArchivo($llave);
            $tiempo = strlen($tiempo) > 0 ? $tiempo : self::$expiracion;

            $serializar = json_encode($valor);

            file_put_contents($nombreArchivo, $serializar);
            touch($nombreArchivo, time() + $tiempo);
        } catch (\Exception $th) {
            Log::set($th);
        }
    }
    
    public static function obtener($llave): ?array
    {
        try {
            $nombreArchivo = self::generarNombreArchivo($llave);

            if (file_exists($nombreArchivo) && filemtime($nombreArchivo) > time()) {
                $serializar = file_get_contents($nombreArchivo);

                return json_decode($serializar, true);
            }

            return null;
        } catch (\Exception $th) {
            Log::set($th);
            return null;
        }
    }

    public static function existe($llave): bool
    {
        try {
            return file_exists(self::generarNombreArchivo($llave));
        } catch (\Exception $th) {
            Log::set($th);
            return false;
        }
    }

    public static function borrar($llave): bool
    {
        try {
            $nombreArchivo = self::generarNombreArchivo($llave);

            if (file_exists($nombreArchivo)) {
                unlink($nombreArchivo);

                return true;
            }

            return false;
        } catch (\Exception $th) {
            Log::set($th);
            return false;
        }
    }

    public static function limpiar(): bool
    {
        try {
            $archivos = glob(self::$directorio . '*');

            foreach ($archivos as $archivo) {
                if (is_file($archivo)) {
                    unlink($archivo);
                }
            }

            return true;
        } catch (\Exception $th) {
            Log::set($th);
            return false;
        }
    }

    protected static function generarNombreArchivo($llave)
    {
        return self::$directorio . md5($llave);
    }
}

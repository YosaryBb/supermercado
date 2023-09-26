<?php

namespace App\Utiles;

use Exception;
use Throwable;

class Log
{
    protected static $directorio = __DIR__ . '/../../tmp/logs/';
    protected static $archivo = 'logs.log';

    public function __construct()
    {
        if (!file_exists($this->directorio)) {
            mkdir($this->directorio, 0755, true);
        }
    }

    public static function set(Exception | Throwable $exception, array $informacionAdicional = []): void
    {
        $directorioFinal = self::$directorio . '/' . self::$archivo;
        $tiempo = date('Y-m-d H:i:s');
        $mensaje = $exception->getMessage();
        $rastro = $exception->getTraceAsString();
        $localizacion = $exception->getFile() . ':' . $exception->getLine();

        $registro = "[$tiempo] local.ERROR: $mensaje at $localizacion\n";
        $registro .= "Stack trace:\n$rastro\n";

        foreach ($informacionAdicional as $key => $value) {
            $registro.= "$key: $value\n";
        }

        $registro .= "\n";
        

        file_put_contents($directorioFinal, $registro, FILE_APPEND);
    }
}

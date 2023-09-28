<?php

namespace App\Utiles;

require __DIR__ . '/../../autoload.php';
require __DIR__ . '/global.php';

use App\Utiles\Sesion;

class Peticion
{
    private $datos = [];
    private $archivos = [];

    public function __construct()
    {
        $this->datos = array_merge($_GET, $_POST);

        $this->archivos = $_FILES;
    }

    public function esPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function esGet(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    public function obtener($clave, $defecto = null)
    {
        return isset($this->datos[$clave]) ? $this->datos[$clave] : $defecto;
    }

    public function todo(): array
    {
        return $this->datos;
    }

    public function tieneArchivo($clave): bool
    {
        return isset($this->archivos[$clave]);
    }

    public function obtenerArchivo($clave): ?array
    {
        return $this->tieneArchivo($clave) ? $this->archivos[$clave] : null;
    }

    public function escapar($valor): string
    {
        return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
    }
    
    public function escaparArreglo($datos = []) :array
    {
        if (empty($datos)) {
            return $datos;
        }

        foreach ($datos as $clave => $valor) {
            $datos[$clave] = $this->escapar($valor);
        }

        return $datos;
    }

    public function establecerCookie($nombre, $valor, $expiracion = 0, $ruta = '/', $dominio = null, $seguro = false, $httponly = true)
    {
        setcookie($nombre, $valor, $expiracion, $ruta, $dominio, $seguro, $httponly);
    }

    public function obtenerCookie($nombre)
    {
        return isset($_COOKIE[$nombre]) ? $_COOKIE[$nombre] : null;
    }

    public function redireccionar($url, $parametros = [], $reemplazar = true, $salir = true)
    {
        if (!empty($parametros)) {
            $url = $url . '?' . http_build_query($parametros);
        }

        header('Location: ' . $url, $reemplazar);

        if ($salir) {
            exit;
        }
    }

    public function validarFormulario($datos, $reglas = []): array
    {
        $errores = [];

        foreach ($reglas as $campo => $regla) {
            $partesRegla = explode('|', $regla);

            foreach ($partesRegla as $parte) {
                if ($parte === 'required' && empty($datos[$campo])) {
                    $errores[$campo] = 'El campo ' . $campo . ' es obligatorio.';
                } elseif ($parte === 'email' && !filter_var($datos[$campo], FILTER_VALIDATE_EMAIL)) {
                    $errores[$campo] = 'El campo ' . $campo . ' debe ser una dirección de correo válida.';
                } elseif ($parte === 'min' && strlen($datos[$campo]) < $partesRegla[1]) {
                    $errores[$campo] = 'El campo ' . $campo . ' debe tener al menos '.$partesRegla[1].' caracteres.';
                } elseif ($parte === 'max' && strlen($datos[$campo]) > $partesRegla[1]) {
                    $errores[$campo] = 'El campo ' . $campo . ' debe tener como máximo '.$partesRegla[1].' caracteres.';
                }
            }
        }

        return $errores;
    }

    public function generarTokenCSRF(): string
    {
        $token = generarTokenAleatorio(65);
        $sesion = new Sesion();
        
        $sesion->set('csrf_token', $token);

        return $token;
    }

    public function verificarTokenCSRF($token): bool
    {
        $sesion = new Sesion();
        $csrf = $sesion->get('csrf_token');

        if (isset($csrf) && hash_equals($csrf, $token)) {
            return true;
        }

        return false;
    }
}
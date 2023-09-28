<?php

require __DIR__ . '/../../autoload.php';
require __DIR__ . '/../../config/params.php';

use App\Utiles\Sesion;

function storage_path(): string
{
    return __DIR__ . '/../../recursos/disco/';
}

function public_path(): string
{
    return __DIR__ . '/../../';
}

function url(): string
{
    $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

    return $protocolo . '://' . $_SERVER['HTTP_HOST'] . PATH_NAME;
}

function assets(string $ruta): string
{
    $webPath = rtrim(url(), '/') . '/recursos/';

    return $webPath . $ruta;
}

function controller(string $route): string
{
    return url() . PATH_APP . PATH_CONTROLLER . $route . '.php';
}

function sesion(): Sesion
{
    return new Sesion();
}

function generarNumeroAleatorio(int $minimo = 1, int $maximo = 100)
{
    return rand($minimo, $maximo);
}

function generarCadenaAleatoria(int $longitud = 10)
{
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $cadenaAleatoria = '';
    $caracteresLength = strlen($caracteres);

    for ($i = 0; $i < $longitud; $i++) {
        $indiceAleatorio = rand(0, $caracteresLength - 1);
        $cadenaAleatoria .= $caracteres[$indiceAleatorio];
    }

    return $cadenaAleatoria;
}

function generarTokenAleatorio(int $longitud = 32)
{
    return bin2hex(random_bytes($longitud));
}

function generarColorAleatorio()
{
    return '#' . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) .
        str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) .
        str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}

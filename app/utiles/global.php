<?php

function storage_path(): string
{
    return __DIR__ . '/../../recursos/disco/';
}

function public_path(): string
{
    return __DIR__ . '/../../';
}

function generarNumeroAleatorio($minimo = 1, $maximo = 100)
{
    return rand($minimo, $maximo);
}

function generarCadenaAleatoria($longitud = 10)
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

function generarTokenAleatorio($longitud = 32)
{
    return bin2hex(random_bytes($longitud));
}

function generarColorAleatorio()
{
    return '#' . str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) .
           str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) .
           str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
}
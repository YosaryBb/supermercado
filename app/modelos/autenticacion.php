<?php

namespace App\Modelos;

class Autenticacion extends Modelo
{
    protected $tabla = 'usuario';

    public function autenticar(array $datos = []): bool
    {
        $usuario = htmlspecialchars(mysqli_real_escape_string($this->conexion, $datos['usuario']));
        $clave = htmlspecialchars(mysqli_real_escape_string($this->conexion, $datos['clave']));

        $clave = md5($clave, true);

        $sql = "SELECT * FROM $this->tabla WHERE usuario = $usuario AND clave = $clave AND status = 1";

        $resultado = mysqli_query($this->conexion, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            // Guardar los datos del usuario en la sesion

            return true;
        }

        return false;
    }

    public function cerrarSesion() 
    {
        // Cerrar la sesion desde la clase Session
    }
}
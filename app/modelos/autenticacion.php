<?php

namespace App\Modelos;

class Autenticacion extends Modelo
{
    protected $tabla = 'usuarios';

    public function autenticar(array $datos = []): bool
    {
        $usuario =  $datos['usuario'];
        $clave = $datos['clave'];

        $clave = md5($clave);

        $sql = "SELECT idUsuario FROM $this->tabla WHERE usuario = '$usuario' AND clave = '$clave'";

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
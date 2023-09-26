<?php

namespace App\Utiles;

require __DIR__ . '/../../autoload.php';
require __DIR__ . '/global.php';

class Sesion
{
    protected $directorio = __DIR__ . '/../../tmp/sesiones/';
    protected $expiracion = 1800;

    public function __construct()
    {
        try {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                if (!file_exists($this->directorio)) {
                    mkdir($this->directorio, 0755, true);
                }

                session_save_path($this->directorio);
                ini_set('session.gc_probability', 1);
                ini_set('session.gc_divisor', 100);
                ini_set('session.gc_maxlifetime', $this->expiracion);

                session_start();
                $this->verificarExpiracion();
            }
        } catch (\Exception $th) {
            Log::set($th);
        }
    }

    public function set($llave, $valor): void
    {
        $this->restablecerTiempoExpiracion();
        $_SESSION[$llave] = $valor;
    }

    public function get($llave): mixed
    {
        $this->restablecerTiempoExpiracion();
        return $_SESSION[$llave] ?? null;
    }

    public function has($llave): bool
    {
        $this->restablecerTiempoExpiracion();
        return isset($_SESSION[$llave]);
    }

    public function destruir()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            $archivoSesion = $this->$directorio . '/sess_' . session_id();

            if (file_exists($archivoSesion)) {
                unlink($archivoSesion);
            }

            session_unset();
            session_destroy();
        }
    }

    protected function verificarExpiracion()
    {
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > $this->$expiracion) {
            $this->destruir();
            header('Location: ' . public_path() . '?status=not_logged', true, 302);
            exit;
        }

        $_SESSION['last_activity'] = time();
    }

    private function restablecerTiempoExpiracion(): void
    {
        if (isset($_SESSION['last_activity'])) {
            $_SESSION['last_activity'] = time();
        }
    }

    public function obtenerID(): string
    {
        return "sess_" . session_id();
    }

    public function __destruct()
    {
        session_commit();
    }
}
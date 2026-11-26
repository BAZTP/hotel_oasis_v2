<?php

namespace Core\Middleware;
use Core\Auth;

class Middleware
{
    public const MIDDLEWARES = [
        'auth' => Authenticated::class,
        'anon' => Anon::class,
        'administracion' => AdministracionMiddleware::class,
        'personal' => PersonalMiddleware::class,
        'marketing' => MarketingMiddleware::class,
        'seguridad' => SeguridadMiddleware::class,
        'ingresos' => IngresosMiddleware::class,
        'egresos' => EgresosMiddleware::class,
    ];

    public static function handle($middleware)
    {
        if (array_key_exists($middleware, self::MIDDLEWARES)) {
            $middleware = self::MIDDLEWARES[$middleware];
            (new $middleware())->handle();
        }
    }
}


class Authenticated
{
    public function handle()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit;
        }
    }
}

class Anon
{
    public function handle()
    {
        if (isset($_SESSION['user'])) {
            header('Location: /auth');
            exit;
        }
    }
}




class AdministracionMiddleware
{
    public function handle()
    {
        $auth = new Auth();
        if (!$auth->hasPermission('auth') && !$auth->hasPermission('administracion')) {
            header('Location: /acceso_denegado');
            exit;
        }
    }
}
class PersonalMiddleware
{
    public function handle()
    {
        $auth = new Auth();
        if (!$auth->hasPermission('auth') && !$auth->hasPermission('personal')) {
            header('Location: /acceso_denegado');
            exit;
        }
    }
}



class MarketingMiddleware
{
    public function handle()
    {
        $auth = new Auth();
        if (!$auth->hasPermission('auth') && !$auth->hasPermission('marketing')) {
            header('Location: /acceso_denegado');
            exit;
        }
    }
}

class SeguridadMiddleware
{
    public function handle()
    {
        $auth = new Auth();
        if (!$auth->hasPermission('auth') && !$auth->hasPermission('seguridad')) {
            header('Location: /acceso_denegado');
            exit;
        }
    }
}

class IngresosMiddleware
{
    public function handle()
    {
        $auth = new Auth();
        if (!$auth->hasPermission('auth') && !$auth->hasPermission('ingresos')) {
            header('Location: /acceso_denegado');
            exit;
        }
    }
}

class EgresosMiddleware
{
    public function handle()
    {
        $auth = new Auth();
        if (!$auth->hasPermission('auth') && !$auth->hasPermission('egresos')) {
            header('Location: /acceso_denegado');
            exit;
        }
    }
}


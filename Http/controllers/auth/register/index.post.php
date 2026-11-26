<?php
use Core\Auth;
use Core\ValidationException;

$attributes = [
    'email' => $_POST['email'] ?? '',
    'password' => $_POST['password'] ?? '',
    'role' => $_POST['role'] ?? ''
];

try {
    $auth = new Auth();
    if ($auth->register($attributes['email'], $attributes['password'], $attributes['role'])) {
        $_SESSION['success'] = "Registro exitoso. Por favor, inicia sesión.";
        redirect('/auth/seguridad');
    }
} catch (\InvalidArgumentException $e) {
    $_SESSION['errors'] = [$e->getMessage()];
} catch (\RuntimeException $e) {
    $_SESSION['errors'] = ["Ha ocurrido un error inesperado. Por favor, inténtalo de nuevo más tarde."];
    error_log($e->getMessage());
} catch (\Exception $e) {
    $_SESSION['errors'] = ["Error en el sistema. Contacte al administrador."];
    error_log($e->getMessage());
}

// Si llegamos aquí, hubo un error
redirect('/auth/register');
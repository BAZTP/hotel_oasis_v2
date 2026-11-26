<?php
use Core\Auth;

$auth = new Auth();

// Manejar actualización de usuario
if (isset($_POST['action']) && $_POST['action'] === 'update') {
    $userId = $_POST['userId'] ?? '';
    $email = $_POST['email'] ?? '';
    $role = $_POST['role'] ?? '';
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    try {
        if ($auth->updateUser($userId, $email, $role, $password)) {
            $_SESSION['_temp']['success'] = "Usuario actualizado con éxito.";
        }
    } catch (\Exception $e) {
        $_SESSION['_temp']['errors'][] = $e->getMessage();
    }
}

// Manejar eliminación de usuario
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $userId = $_POST['userId'] ?? '';

    try {
        if ($auth->deleteUser($userId)) {
            $_SESSION['_temp']['success'] = "Usuario eliminado con éxito.";
        }
    } catch (\Exception $e) {
        $_SESSION['_temp']['errors'][] = $e->getMessage();
    }
}

// Redireccionar de vuelta a la página de seguridad
redirect('/auth/seguridad');
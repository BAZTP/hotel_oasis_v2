<?php
use Core\Auth;

$auth = new Auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    // Redireccionar para evitar reenvío del formulario
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Obtener todos los usuarios para mostrar en la tabla
$users = $auth->getAllUsers();

view('auth/seguridad.view.php', [
    'head_title' => 'Administración de Usuarios',
    'users' => $users,
    'errors' => $_SESSION['_temp']['errors'] ?? [],
    'success' => $_SESSION['_temp']['success'] ?? null
]);


<?php
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Modificar la consulta para seleccionar datos de mark_promociones
    $result = $db
        ->query("
            SELECT *
            FROM mark_promociones
        ")
        ->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/marketing/promociones/index.view.php', [
    'head_title' => 'Promociones',
    'promociones' => $result  // Cambiar 'servicios' a 'promociones'
]);
?>

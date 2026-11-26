<?php
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();
    
    // Obtener los tipos de servicios
    $tipos_servicios = $db
        ->query("SELECT * FROM mark_tip_serv;")
        ->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/marketing/crear.view.php', [
    'head_title' => 'Crear Promociones',
    'tipos_servicios' => $tipos_servicios
]);
?>

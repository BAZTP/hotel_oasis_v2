<?php
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();
    
    // Obtener los tipos de eventos y servicios desde la base de datos
    $tipo_eventos = $db
        ->query("SELECT TIP_EVEN_ID, TIP_EVEN_DET FROM mark_tip_even;")
        ->fetchAll(PDO::FETCH_ASSOC);

    $tipo_servicios = $db
        ->query("SELECT TIP_SERV_ID, TIP_SERV_DET FROM mark_tip_serv;")
        ->fetchAll(PDO::FETCH_ASSOC);
} catch (DatabaseException $e) {
    die($e->getMessage()); // Manejo de errores
}

// Pasar datos a la vista
view('auth/marketing/promociones/crear.view.php', [
    'head_title' => 'Crear Promociones',
    'tipo_eventos' => $tipo_eventos,
    'tipo_servicios' => $tipo_servicios
]);
?>

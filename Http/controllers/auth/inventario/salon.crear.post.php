<?php

use Core\Database;
use Core\DatabaseException;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$attributes = [
    'seleccionar_salon'  => $_POST[ 'seleccionar_salon'],
    'seleccionar_inventario' => $_POST[ 'seleccionar_inventario' ],
    'stock' => $_POST[ 'stock' ]
];
 // Validate stock on the server side
 if ($attributes['stock'] <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'El valor del stock debe ser positivo']);
    exit;
}
try {
    $db = Database::getInstance();
    $result = $db
        ->prepare(
            "
        INSERT INTO adm_inv_sal (
            SAL_ID,
            INV_GEN_ID,
            INV_SAL_STOCK
        ) VALUES (
            :seleccionar_salon,
            :seleccionar_inventario,
            :stock
        )"
        )
        ->bind(':seleccionar_salon', $attributes['seleccionar_salon'])
        ->bind(':seleccionar_inventario', $attributes['seleccionar_inventario'])
        ->bind(':stock', $attributes['stock'])
        ->execute();
       // If successful, return success response
       echo json_encode(['status' => 'success', 'message' => 'Formulario enviado correctamente']);
    } catch (DatabaseException $e) {
        // Catch the exception and return error response
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

// Load views
require base_path('views/partials/head.php');
require base_path('views/partials/auth_header.php');
require base_path('views/partials/routes_aside.php');
require base_path('views/partials/auth_footer.php');
require base_path('views/partials/end.php');
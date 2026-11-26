<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Obtener el parámetro de búsqueda, si existe
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

    // Consulta SQL para obtener los egresos inactivos, con filtro por proveedor si se proporciona
    $query = "
        SELECT
            EGR_ID,
            EGR_DES,
            EGR_MON,
            EGR_FEC,
            EGR_TIP_ID,
            EGR_PROVEEDOR,
            EGR_RUC
        FROM 
            egr_egreso
        WHERE
            EGR_ESTADO = 'inactivo'
    ";

    // Agregar el filtro de búsqueda si se ha proporcionado
    if (!empty($searchTerm)) {
        $query .= " AND EGR_PROVEEDOR LIKE :searchTerm";
    }

    $query .= " ORDER BY EGR_ID DESC";

    // Preparar la consulta
    $stmt = $db->prepare($query);

    // Vincular el parámetro de búsqueda si es necesario
    if (!empty($searchTerm)) {
        $stmt->bind(':searchTerm', '%' . $searchTerm . '%');
    }

    // Ejecutar la consulta
    $stmt->execute();
    $result = $stmt->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

// Obtener tipos de egreso para mostrar en la vista
$tiposEgreso = $db->query("
    SELECT * FROM egr_tipo_egreso
")->fetchAll();

// Mostrar formulario para egresos inactivos
view('auth/egresos/egresos_inactivos.view.php', [
    'head_title' => 'Egresos Inactivos',
    'egresos' => $result,
    'tiposEgreso' => $tiposEgreso
]);
?>

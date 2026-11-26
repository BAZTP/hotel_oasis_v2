<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Si se ha enviado un término de búsqueda
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
        $searchTerm = '%' . $_GET['search'] . '%';

        // Consulta SQL para filtrar los egresos por proveedor y que estén activos
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
                EGR_PROVEEDOR LIKE :searchTerm AND EGR_ESTADO = 'activo'
            ORDER BY EGR_ID DESC
        ";

        // Ejecutar la consulta con el parámetro vinculado
        $stmt = $db->prepare($query);
        $stmt->bind(':searchTerm', $searchTerm);
        $stmt->execute();
        $result = $stmt->fetchAll();
    } else {
        // Consulta original sin filtro de búsqueda, solo egresos activos
        $result = $db->query("
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
                EGR_ESTADO = 'activo'
            ORDER BY EGR_ID DESC
        ")->fetchAll();
    }
} catch (DatabaseException $e) {
    die($e->getMessage());
}

// Obtener tipos de egreso para mostrar en la vista
$tiposEgreso = $db->query("
    SELECT * FROM egr_tipo_egreso
")->fetchAll();

// Mostrar formulario para egresos
view('auth/egresos/index.view.php', [
    'head_title' => 'Egresos',
    'egresos' => $result,
    'tiposEgreso' => $tiposEgreso
]);
?>

<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Si se ha enviado un término de búsqueda
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
        $searchTerm = '%' . $_GET['search'] . '%';

        // Consulta SQL para filtrar los pagos por nombre o apellido
        $query = "
            SELECT
                PERS_NOM,
                PERS_APE,
                PERS_CED,
                APOR_PERSONAL_CANTIDAD,
                FECHA_PAGO
            FROM 
                pers_unido
            WHERE
                PERS_NOM LIKE :searchTerm OR
                PERS_APE LIKE :searchTerm
            ORDER BY ID DESC
        ";

        // Ejecutar la consulta con el parámetro vinculado
        $stmt = $db->prepare($query);
        $stmt->bind(':searchTerm', $searchTerm);
        $stmt->execute();
        $result = $stmt->fetchAll();

        // Obtener datos agregados para el gráfico filtrado
        $aggregateQuery = "
            SELECT 
                DATE_FORMAT(FECHA_PAGO, '%Y-%m') AS month,
                SUM(SUELDO) AS total_aportes_personales
            FROM 
                pers_unido
            WHERE
                PERS_NOM LIKE :searchTerm OR
                PERS_APE LIKE :searchTerm
            GROUP BY 
                DATE_FORMAT(FECHA_PAGO, '%Y-%m')
            ORDER BY 
                DATE_FORMAT(FECHA_PAGO, '%Y-%m')
        ";

        $aggregateStmt = $db->prepare($aggregateQuery);
        $aggregateStmt->bind(':searchTerm', $searchTerm);
        $aggregateStmt->execute();
        $aggregateResult = $aggregateStmt->fetchAll();
    } else {
        // Consulta original sin filtro de búsqueda
        $result = $db->query("
            SELECT
                PERS_NOM,
                PERS_APE,
                PERS_CED,
                APOR_PERSONAL_CANTIDAD,
                FECHA_PAGO
            FROM 
                pers_unido
            ORDER BY ID DESC
        ")->fetchAll();

        // Obtener datos agregados para el gráfico sin filtro de búsqueda
        $aggregateResult = $db->query("
            SELECT 
                DATE_FORMAT(FECHA_PAGO, '%Y-%m') AS month,
                SUM(SUELDO) AS total_aportes_personales
            FROM 
                pers_unido
            GROUP BY 
                DATE_FORMAT(FECHA_PAGO, '%Y-%m')
            ORDER BY 
                DATE_FORMAT(FECHA_PAGO, '%Y-%m')
        ")->fetchAll();
    }
} catch (DatabaseException $e) {
    die($e->getMessage());
}

// Mostrar formulario para pagos
view('auth/egresos/pago_aporte_personal.view.php', [
    'head_title' => 'Aportes Personales',
    'pagos' => $result,
    'aggregateData' => $aggregateResult
]);

?>

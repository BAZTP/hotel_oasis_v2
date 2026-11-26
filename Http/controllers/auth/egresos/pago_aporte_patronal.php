<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();
    
    // Parámetros de búsqueda
    $searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : null;
    $startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
    $endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

    // Consulta para buscar aportes patronales
    $query = "
        SELECT
            PERS_NOM,
            PERS_APE,
            PERS_CED,
            APOR_PATRONAL_CANTIDAD AS APOR_CANTIDAD,
            FECHA_PAGO
        FROM 
            pers_unido
        WHERE 1=1
    ";

    if ($searchTerm) {
        $query .= " AND (PERS_NOM LIKE :searchTerm OR PERS_APE LIKE :searchTerm)";
    }

    if ($startDate && $endDate) {
        $query .= " AND FECHA_PAGO BETWEEN :startDate AND :endDate";
    }

    $query .= " ORDER BY ID DESC";

    $stmt = $db->prepare($query);

    if ($searchTerm) {
        $stmt->bind(':searchTerm', $searchTerm);
    }

    if ($startDate && $endDate) {
        $stmt->bind(':startDate', $startDate);
        $stmt->bind(':endDate', $endDate);
    }

    $stmt->execute();
    $result = $stmt->fetchAll();

    // Consulta para datos agregados del gráfico
    $aggregateQuery = "
        SELECT 
            DATE_FORMAT(FECHA_PAGO, '%Y-%m') AS month,
            SUM(APOR_PATRONAL_CANTIDAD) AS total_aportes
        FROM 
            pers_unido
        WHERE 1=1
    ";

    if ($searchTerm) {
        $aggregateQuery .= " AND (PERS_NOM LIKE :searchTerm OR PERS_APE LIKE :searchTerm)";
    }

    if ($startDate && $endDate) {
        $aggregateQuery .= " AND FECHA_PAGO BETWEEN :startDate AND :endDate";
    }

    $aggregateQuery .= " GROUP BY DATE_FORMAT(FECHA_PAGO, '%Y-%m')
                         ORDER BY DATE_FORMAT(FECHA_PAGO, '%Y-%m')";

    $stmt = $db->prepare($aggregateQuery);

    if ($searchTerm) {
        $stmt->bind(':searchTerm', $searchTerm);
    }

    if ($startDate && $endDate) {
        $stmt->bind(':startDate', $startDate);
        $stmt->bind(':endDate', $endDate);
    }

    $stmt->execute();
    $aggregateResult = $stmt->fetchAll();

    // Si se solicita actualización AJAX
    if (isset($_GET['ajax'])) {
        echo json_encode([
            'pagos' => $result,
            'aggregateData' => $aggregateResult
        ]);
        exit;
    }

} catch (DatabaseException $e) {
    die($e->getMessage());
}

// Mostrar vista con datos
view('auth/egresos/pago_aporte_patronal.view.php', [
    'head_title' => 'Aportes Patronales Realizados',
    'pagos' => $result,
    'aggregateData' => $aggregateResult
]);

?>

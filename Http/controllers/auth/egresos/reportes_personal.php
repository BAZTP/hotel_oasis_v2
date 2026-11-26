<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];

        // Validar fechas
        if (!DateTime::createFromFormat('Y-m-d', $startDate) || !DateTime::createFromFormat('Y-m-d', $endDate)) {
            throw new Exception("Fechas inválidas");
        }

        $query = "
            SELECT
                DATE(FECHA_PAGO) AS fecha,
                SUM(APOR_PERSONAL_CANTIDAD) AS total_aportes
            FROM
                pers_unido
            WHERE
                FECHA_PAGO BETWEEN :startDate AND :endDate
            GROUP BY
                DATE(FECHA_PAGO)
            ORDER BY
                DATE(FECHA_PAGO)
        ";

        $stmt = $db->prepare($query);
        $stmt->bind(':startDate', $startDate);
        $stmt->bind(':endDate', $endDate);
        $stmt->execute();
        $reportData = $stmt->fetchAll();

        // Datos para el gráfico
        $aggregateQuery = "
            SELECT
                DATE(FECHA_PAGO) AS fecha,
                SUM(APOR_PERSONAL_CANTIDAD) AS total_aportes
            FROM
                pers_unido
            WHERE
                FECHA_PAGO BETWEEN :startDate AND :endDate
            GROUP BY
                DATE(FECHA_PAGO)
            ORDER BY
                DATE(FECHA_PAGO)
        ";

        $aggregateStmt = $db->prepare($aggregateQuery);
        $aggregateStmt->bind(':startDate', $startDate);
        $aggregateStmt->bind(':endDate', $endDate);
        $aggregateStmt->execute();
        $aggregateData = $aggregateStmt->fetchAll();

        view('auth/egresos/reportes_personal.view.php', [
            'reportData' => $reportData,
            'aggregateData' => $aggregateData, // Cambiar aquí
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    } else {
        throw new Exception("Rango de fechas no especificado");
    }

} catch (DatabaseException $e) {
    echo "Error de base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

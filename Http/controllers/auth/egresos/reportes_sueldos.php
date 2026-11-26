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
                SUM(SUELDO) AS total_sueldos
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

        // Obtener datos agregados para el gráfico
        $aggregateQuery = "
            SELECT
                DATE_FORMAT(FECHA_PAGO, '%Y-%m-%d') AS month,
                SUM(SUELDO) AS total_sueldo
            FROM
                pers_unido
            WHERE
                FECHA_PAGO BETWEEN :startDate AND :endDate
            GROUP BY
                DATE_FORMAT(FECHA_PAGO, '%Y-%m-%d')
            ORDER BY
                DATE_FORMAT(FECHA_PAGO, '%Y-%m-%d')
        ";

        $aggregateStmt = $db->prepare($aggregateQuery);
        $aggregateStmt->bind(':startDate', $startDate);
        $aggregateStmt->bind(':endDate', $endDate);
        $aggregateStmt->execute();
        $aggregateResult = $aggregateStmt->fetchAll();

        view('auth/egresos/reportes_sueldos.view.php', [
            'reportData' => $reportData,
            'aggregateData' => $aggregateResult,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    } else {
        throw new Exception("Rango de fechas no especificado");
    }

} catch (DatabaseException $e) {
    die($e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}
?>

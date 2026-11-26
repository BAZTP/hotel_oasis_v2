<?php

use Core\Database;
use Core\DatabaseException;

// Controlador para manejar el reporte de egresos
try {
    function generarReporteEgresos($startDate, $endDate) {
        // Verificar que las fechas sean válidas
        if (!$startDate || !$endDate || strtotime($startDate) > strtotime($endDate)) {
            // Manejar error de fechas inválidas
            return [
                'error' => 'Fechas inválidas. Por favor ingrese un rango de fechas correcto.',
                'reportData' => [],
                'aggregateData' => [],
                'totalAmount' => 0
            ];
        }

        // Obtener la instancia de la base de datos
        $db = Database::getInstance();

        // Obtener la fecha actual
        $currentDate = date('Y-m-d');

        // Consulta SQL para obtener los totales generales de egresos hasta la fecha actual, agrupados por tipo de egreso
        $query = "
            SELECT 
                'Sueldo' AS tipo_egreso,
                SUM(SUELDO) AS total_egreso,
                :currentDate AS fecha
            FROM pers_unido
            WHERE FECHA_PAGO <= :currentDate
            
            UNION ALL
            
            SELECT 
                'Aporte Personal' AS tipo_egreso,
                SUM(APOR_PERSONAL_CANTIDAD) AS total_egreso,
                :currentDate AS fecha
            FROM pers_unido
            WHERE FECHA_PAGO <= :currentDate
            
            UNION ALL
            
            SELECT 
                'Aporte Patronal' AS tipo_egreso,
                SUM(APOR_PATRONAL_CANTIDAD) AS total_egreso,
                :currentDate AS fecha
            FROM pers_unido
            WHERE FECHA_PAGO <= :currentDate
            
            UNION ALL
            
            SELECT 
                te.EGR_NOM AS tipo_egreso,
                SUM(e.EGR_MON) AS total_egreso,
                :currentDate AS fecha
            FROM egr_egreso e
            JOIN egr_tipo_egreso te ON e.EGR_TIP_ID = te.EGR_TIPO_ID
            WHERE e.EGR_FEC <= :currentDate
            GROUP BY te.EGR_NOM
        ";

        // Preparar y ejecutar la consulta
        $stmt = $db->prepare($query);
        $stmt->bind(':currentDate', $currentDate);
        $stmt->execute();
        $reportData = $stmt->fetchAll();

        // Datos para el gráfico, actualizados para considerar todos los tipos de egresos
        $aggregateQuery = "
            SELECT
                'Sueldo' AS tipo_egreso,
                SUM(SUELDO) AS total_egreso
            FROM pers_unido
            WHERE FECHA_PAGO BETWEEN :startDate AND :endDate

            UNION ALL

            SELECT
                'Aporte Personal' AS tipo_egreso,
                SUM(APOR_PERSONAL_CANTIDAD) AS total_egreso
            FROM pers_unido
            WHERE FECHA_PAGO BETWEEN :startDate AND :endDate

            UNION ALL

            SELECT
                'Aporte Patronal' AS tipo_egreso,
                SUM(APOR_PATRONAL_CANTIDAD) AS total_egreso
            FROM pers_unido
            WHERE FECHA_PAGO BETWEEN :startDate AND :endDate

            UNION ALL

            SELECT
                te.EGR_NOM AS tipo_egreso,
                SUM(e.EGR_MON) AS total_egreso
            FROM
                egr_egreso e
            JOIN
                egr_tipo_egreso te ON e.EGR_TIP_ID = te.EGR_TIPO_ID
            WHERE
                e.EGR_FEC BETWEEN :startDate AND :endDate
            GROUP BY
                te.EGR_NOM
            ORDER BY
                tipo_egreso
        ";

        // Preparar y ejecutar la consulta para los datos agregados
        $aggregateStmt = $db->prepare($aggregateQuery);
        $aggregateStmt->bind(':startDate', $startDate);
        $aggregateStmt->bind(':endDate', $endDate);
        $aggregateStmt->execute();
        $aggregateData = $aggregateStmt->fetchAll();

        // Calcular el total general de egresos
        $totalAmount = array_sum(array_column($aggregateData, 'total_egreso'));

        // Renderizar la vista con los datos obtenidos
        view('auth/egresos/egresos_totales_reportes.view.php', [
            'reportData' => $reportData,
            'aggregateData' => $aggregateData,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalAmount' => $totalAmount
        ]);
    }

    // Verificar si el método de solicitud es GET y si se han proporcionado las fechas de inicio y fin
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['start_date']) && isset($_GET['end_date'])) {
        $startDate = $_GET['start_date'];
        $endDate = $_GET['end_date'];

        // Validar el formato de las fechas
        if (!DateTime::createFromFormat('Y-m-d', $startDate) || !DateTime::createFromFormat('Y-m-d', $endDate)) {
            throw new Exception("Fechas inválidas");
        }

        // Generar el reporte de egresos
        generarReporteEgresos($startDate, $endDate);
    } else {
        throw new Exception("Rango de fechas no especificado");
    }
} catch (DatabaseException $e) {
    echo "Error de base de datos: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<?php

use Core\Database;
use Core\DatabaseException;

try {
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

    // Calcular el total general de todos los egresos
    $totalEgreso = 0;
    foreach ($reportData as $item) {
        $totalEgreso += $item['total_egreso'];
    }

    // Mostrar la vista con los datos del reporte y la fecha actual
    view('auth/egresos/egresos_totales.view.php', [
        'reportData' => $reportData,
        'totalEgreso' => $totalEgreso, // Pasar el total general a la vista
        'currentDate' => $currentDate // Pasar la fecha actual a la vista
    ]);

} catch (DatabaseException $e) {
    die($e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

    // Crear un nuevo objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Agregar la cabecera del hotel centrada
    $sheet->setCellValue('A1', 'HOTEL OASIS');
    $sheet->mergeCells('A1:C1'); // Fusionar celdas para la cabecera
    $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal('center'); // Centrar el contenido
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16); // Estilo de la cabecera

    // Agregar el título del reporte centrado
    $sheet->setCellValue('A2', 'EGRESOS TOTALES');
    $sheet->mergeCells('A2:C2'); // Fusionar celdas para el título
    $sheet->getStyle('A2:C2')->getAlignment()->setHorizontal('center'); // Centrar el contenido
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14); // Estilo del título

    // Definir encabezados de columna
    $sheet->setCellValue('A3', 'Tipo de Egreso');
    $sheet->setCellValue('B3', 'Fecha');
    $sheet->setCellValue('C3', 'Total Egreso');

    // Llenar datos desde la base de datos
    $row = 4;
    foreach ($reportData as $item) {
        $sheet->setCellValue('A' . $row, $item['tipo_egreso']);
        $sheet->setCellValue('B' . $row, $item['fecha']);
        $sheet->setCellValue('C' . $row, $item['total_egreso']);
        $row++;
    }

    // Agregar la fila con el total general
    $sheet->setCellValue('A' . $row, 'Total General');
    $sheet->mergeCells('A' . $row . ':B' . $row); // Fusionar celdas para el total general
    $sheet->setCellValue('C' . $row, $totalEgreso);
    $sheet->getStyle('C' . $row)->getFont()->setBold(true); // Estilo del total general

    // Auto tamaño para las columnas
    foreach (range('A', 'C') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Estilo para los encabezados de las columnas
    $sheet->getStyle('A3:C3')->getFont()->setBold(true);

    // Configurar el tipo de contenido y la descarga del archivo
    $fileName = 'reporte_egresos_totales.xlsx';

    // Limpiar cualquier búfer de salida previo
    if (ob_get_length()) {
        ob_end_clean();
    }

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    header('Expires: Fri, 01 Jan 1990 00:00:00 GMT');
    header('Pragma: public');

    // Escribir el archivo Excel en el flujo de salida
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    // Detener la ejecución después de la descarga
    exit();

} catch (DatabaseException $e) {
    die('Error de base de datos: ' . $e->getMessage());
} catch (Exception $e) {
    die('Error al generar el archivo Excel: ' . $e->getMessage());
}
?>

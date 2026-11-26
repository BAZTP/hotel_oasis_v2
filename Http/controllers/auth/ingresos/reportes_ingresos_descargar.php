<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Consulta original sin filtro de búsqueda
    $result = $db->query("
        SELECT
            t.TIP_ING_DESC AS TIPO_INGRESO,
            i.ING_MONT AS MONTO,
            i.ING_FECH AS FECHA_INGRESO,
            i.ing_concepto_ing AS CONCEPTO_INGRESO
        FROM 
            ing_ingresos i
            JOIN ing_tipo_ingreso t ON i.TIP_ING_ID = t.TIP_ING_ID
        ORDER BY i.ING_ID DESC
    ")->fetchAll();

    // Crear un nuevo objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Definir encabezados de columna
    $sheet->setCellValue('A1', 'Tipo de Ingreso');
    $sheet->setCellValue('B1', 'Monto');
    $sheet->setCellValue('C1', 'Fecha de Ingreso');
    $sheet->setCellValue('D1', 'Concepto de Ingreso');

    // Llenar datos desde la base de datos
    $row = 2;
    foreach ($result as $item) {
        $sheet->setCellValue('A' . $row, $item['TIPO_INGRESO']);
        $sheet->setCellValue('B' . $row, $item['MONTO']);
        $sheet->setCellValue('C' . $row, $item['FECHA_INGRESO']);
        $sheet->setCellValue('D' . $row, $item['CONCEPTO_INGRESO']);
        $row++;
    }

    // Configurar el tipo de contenido y la descarga del archivo
    $fileName = 'reporte_ingresos.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');

    // Escribir el archivo Excel en el flujo de salida
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

} catch (DatabaseException $e) {
    die($e->getMessage());
} catch (Exception $e) {
    die('Error al generar el archivo Excel: ' . $e->getMessage());
}
?>

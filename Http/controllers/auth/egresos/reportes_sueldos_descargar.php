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
            PERS_NOM,
            PERS_APE,
            PERS_CED,
            SUELDO,
            FECHA_PAGO
        FROM 
            pers_unido
        ORDER BY ID DESC
    ")->fetchAll();

    // Crear un nuevo objeto Spreadsheet
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Agregar la cabecera del hotel centrada
    $sheet->setCellValue('A1', 'HOTEL OASIS');
    $sheet->mergeCells('A1:E1'); // Fusionar celdas para la cabecera
    $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('center'); // Centrar el contenido
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16); // Estilo de la cabecera

    // Agregar el título del reporte centrado
    $sheet->setCellValue('A2', 'REPORTES DE SUELDOS');
    $sheet->mergeCells('A2:E2'); // Fusionar celdas para el título
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14); // Estilo del título

    // Definir encabezados de columna
    $sheet->setCellValue('A3', 'Nombre');
    $sheet->setCellValue('B3', 'Apellido');
    $sheet->setCellValue('C3', 'Cédula');
    $sheet->setCellValue('D3', 'Sueldo');
    $sheet->setCellValue('E3', 'Fecha de Pago');

    // Llenar datos desde la base de datos
    $row = 4; // Comenzar desde la fila 4 después de cabecera y título
    foreach ($result as $item) {
        $sheet->setCellValue('A' . $row, $item['PERS_NOM']);
        $sheet->setCellValue('B' . $row, $item['PERS_APE']);
        $sheet->setCellValue('C' . $row, $item['PERS_CED']);
        $sheet->setCellValue('D' . $row, $item['SUELDO']);
        $sheet->setCellValue('E' . $row, $item['FECHA_PAGO']);
        $row++;
    }

    // Auto tamaño para las columnas
    foreach (range('A', 'E') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Estilo para los encabezados de las columnas
    $sheet->getStyle('A3:E3')->getFont()->setBold(true);

    // Configurar el tipo de contenido y la descarga del archivo
    $fileName = 'reporte_sueldos_pagados.xlsx';

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
    die($e->getMessage());
} catch (Exception $e) {
    die('Error al generar el archivo Excel: ' . $e->getMessage());
}
?>

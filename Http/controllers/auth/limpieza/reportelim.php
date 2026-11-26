<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Obtener los datos del inventario
    $result = $db->query("    SELECT * 
        FROM adm_lim_prog AI
        JOIN adm_est_lim_prog ATI ON AI.EST_LIM_PROG_ID = ATI.EST_LIM_PROG_ID
        JOIN pers_personal AU ON AI.PERS_ID = AU.PERS_ID")->fetchAll();
    
    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Limpieza Programada');

    // Añadir el título y el subtítulo
    $sheet->setCellValue('A1', 'HOTEL OASIS');
    $sheet->mergeCells('A1:D1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A2', 'Limpieza Programada Reporte');
    $sheet->mergeCells('A2:D2');
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Añadir los encabezados de las columnas
    $sheet->setCellValue('A4', 'N° DE HABITACIÓN');
    $sheet->setCellValue('B4', 'ESTADO');
    $sheet->setCellValue('C4', 'PERSONAL');
    $sheet->setCellValue('D4', 'LIMPIEZA FECHA');
    $sheet->getStyle('A4:D4')->getFont()->setBold(true); // Hacer los encabezados en negrita

    // Añadir los datos
    $row = 5; // La fila inicial para los datos
    foreach ($result as $item) {
        $sheet->setCellValue('A' . $row, $item['HAB_ID']);
        $sheet->setCellValue('B' . $row, $item['EST_LIM_PROG_DET']);
        $sheet->setCellValue('C' . $row, $item['PERS_NOM']);
        $sheet->setCellValue('D' . $row, $item['LIM_PROG_FECH']);
        $row++;
    }

    // Evitar cualquier salida antes de los encabezados
    ob_clean();
    ob_start();

    // Configurar el tipo de contenido y la descarga del archivo
    $fileName = 'limpieza.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');

    // Escribir el archivo Excel en el flujo de salida
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    ob_end_flush();
    
    exit;

} catch (DatabaseException $e) {
    die($e->getMessage());
} catch (Exception $e) {
    die('Error al generar el archivo Excel: ' . $e->getMessage());
}
?>

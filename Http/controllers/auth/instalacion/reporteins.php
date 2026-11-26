<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Obtener los datos del inventario
    $result = $db->query(" SELECT *
    FROM adm_instalacion ai
    JOIN adm_tip_ins ati ON ai.tip_ins_id = ati.tip_ins_id
    JOIN adm_est_ins au ON ai.est_ins_id = au.est_ins_id")->fetchAll();
    
    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Instalacion Horario');

    // Añadir el título y el subtítulo
    $sheet->setCellValue('A1', 'HOTEL OASIS');
    $sheet->mergeCells('A1:D1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A2', 'Instalacion Horario Reporte');
    $sheet->mergeCells('A2:D2');
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Añadir los encabezados de las columnas
    $sheet->setCellValue('A4', 'NOMBRE DE LA INSTALACION');
    $sheet->setCellValue('B4', 'ESTADO');
    $sheet->setCellValue('C4', 'HORA INICIO');
    $sheet->setCellValue('D4', 'HORA FIN');
    $sheet->getStyle('A4:D4')->getFont()->setBold(true); // Hacer los encabezados en negrita

    // Añadir los datos
    $row = 5; // La fila inicial para los datos
    foreach ($result as $item) {
        $sheet->setCellValue('A' . $row, $item['TIP_INS_DES']);
        $sheet->setCellValue('B' . $row, $item['EST_INS_DES']);
        $sheet->setCellValue('C' . $row, $item['INS_HOR_INI']);
        $sheet->setCellValue('D' . $row, $item['INS_HOR_FIN']);
        $row++;
    }

    // Evitar cualquier salida antes de los encabezados
    ob_clean();
    ob_start();

    // Configurar el tipo de contenido y la descarga del archivo
    $fileName = 'instalacion_horario.xlsx';
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

<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Obtener los datos del inventario
    $result = $db->query("SELECT * FROM adm_ins_per AI
            JOIN pers_personal AU ON AI.PERS_ID = AU.PERS_ID
            JOIN adm_instalacion EO ON AI.INS_ID = EO.INS_ID
            JOIN adm_tip_ins TI ON EO.TIP_INS_ID = TI.TIP_INS_ID")->fetchAll();
    
    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Personal Instalacion');

    // Añadir el título y el subtítulo
    $sheet->setCellValue('A1', 'HOTEL OASIS');
    $sheet->mergeCells('A1:D1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A2', 'Personal Instalacion Reporte');
    $sheet->mergeCells('A2:D2');
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Añadir los encabezados de las columnas
    $sheet->setCellValue('A4', 'NOMBRE DEL PERSONAL');
    $sheet->setCellValue('B4', 'INSTALACION');
    $sheet->getStyle('A4:B4')->getFont()->setBold(true); // Hacer los encabezados en negrita

    // Añadir los datos
    $row = 5; // La fila inicial para los datos
    foreach ($result as $item) {
        $sheet->setCellValue('A' . $row, $item['PERS_NOM']);
        $sheet->setCellValue('B' . $row, $item['TIP_INS_DES']);
        $row++;
    }

    // Evitar cualquier salida antes de los encabezados
    ob_clean();
    ob_start();

    // Configurar el tipo de contenido y la descarga del archivo
    $fileName = 'instalacion_personal.xlsx';
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

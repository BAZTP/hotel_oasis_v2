<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Obtener los datos del inventario
    $result = $db->query("  SELECT 
            AI.INV_INS_ID,
            AI.INS_ID,
            T.TIP_INS_DES,
            AI.INV_INS_STOCK,
            AG.INV_GEN_DES,
            SUM(AI.INV_INS_STOCK) AS INV_INS_STOCK
        FROM adm_inv_ins AI
        JOIN adm_instalacion A ON AI.INS_ID = A.INS_ID
        JOIN adm_inv_gen AG ON AI.INV_GEN_ID = AG.INV_GEN_ID
        JOIN adm_tip_ins T ON A.TIP_INS_ID = T.TIP_INS_ID
        GROUP BY AI.INS_ID, AG.INV_GEN_DES, T.TIP_INS_DES, AI.INV_INS_ID, AI.INV_INS_STOCK")->fetchAll();
    
    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Inventario Instalacion');

    // Añadir el título y el subtítulo
    $sheet->setCellValue('A1', 'HOTEL OASIS');
    $sheet->mergeCells('A1:D1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A2', 'Inventario Instalacion Reporte');
    $sheet->mergeCells('A2:D2');
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Añadir los encabezados de las columnas
    $sheet->setCellValue('A4', 'NOMBRE DE LA INSTALACIÓN');
    $sheet->setCellValue('B4', 'NOMBRE DEL PRODUCTO');
    $sheet->setCellValue('C4', 'CANTIDAD');
    $sheet->getStyle('A4:C4')->getFont()->setBold(true); // Hacer los encabezados en negrita

    // Añadir los datos
    $row = 5; // La fila inicial para los datos
    foreach ($result as $item) {
        $sheet->setCellValue('A' . $row, $item['TIP_INS_DES']);
        $sheet->setCellValue('B' . $row, $item['INV_GEN_DES']);
        $sheet->setCellValue('C' . $row, $item['INV_INS_STOCK']);
      
        $row++;
    }

    // Evitar cualquier salida antes de los encabezados
    ob_clean();
    ob_start();

    // Configurar el tipo de contenido y la descarga del archivo
    $fileName = 'inventario_instalacion.xlsx';
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

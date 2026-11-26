<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Obtener los datos del inventario
    $result = $db->query("   SELECT 
			AI.INV_SAL_ID,
			AI.SAL_ID,
			T.TIP_SAL_DES,
			AG.INV_GEN_DES,
			SUM(AI.INV_SAL_STOCK) AS INV_SAL_STOCK
			FROM adm_inv_sal AI
			JOIN adm_inv_gen AG ON AI.INV_GEN_ID = AG.INV_GEN_ID
			JOIN adm_salon S ON AI.SAL_ID = S.SAL_ID
			JOIN adm_tip_sal T ON S.TIP_SAL_ID = T.TIP_SAL_ID 
			GROUP BY AI.SAL_ID, AG.INV_GEN_DES, T.TIP_SAL_DES, AI.INV_SAL_ID")->fetchAll();
    
    // Crear una nueva hoja de cálculo
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Inventario Salon');

    // Añadir el título y el subtítulo
    $sheet->setCellValue('A1', 'HOTEL OASIS');
    $sheet->mergeCells('A1:D1');
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    $sheet->setCellValue('A2', 'Inventario Salon Reporte');
    $sheet->mergeCells('A2:D2');
    $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
    $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    // Añadir los encabezados de las columnas
    $sheet->setCellValue('A4', 'NOMBRE DEL SALÓN');
    $sheet->setCellValue('B4', 'NOMBRE DEL PRODUCTO');
    $sheet->setCellValue('C4', 'CANTIDAD');
    $sheet->getStyle('A4:C4')->getFont()->setBold(true); // Hacer los encabezados en negrita

    // Añadir los datos
    $row = 5; // La fila inicial para los datos
    foreach ($result as $item) {
        $sheet->setCellValue('A' . $row, $item['TIP_SAL_DES']);
        $sheet->setCellValue('B' . $row, $item['INV_GEN_DES']);
        $sheet->setCellValue('C' . $row, $item['INV_SAL_STOCK']);
      
        $row++;
    }

    // Evitar cualquier salida antes de los encabezados
    ob_clean();
    ob_start();

    // Configurar el tipo de contenido y la descarga del archivo
    $fileName = 'inventario_salon.xlsx';
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

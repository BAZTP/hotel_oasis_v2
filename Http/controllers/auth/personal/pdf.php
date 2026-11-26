<?php
use Core\PDF;
use Core\Database;
use Core\DatabaseException;

$pers_id = isset($_GET['PERS_ID']) ? intval($_GET['PERS_ID']) : null;
$start_month = isset($_GET['start_month']) ? intval($_GET['start_month']) : null;
$start_year = isset($_GET['start_year']) ? intval($_GET['start_year']) : null;
$end_month = isset($_GET['end_month']) ? intval($_GET['end_month']) : null;
$end_year = isset($_GET['end_year']) ? intval($_GET['end_year']) : null;

if (!$pers_id || !$start_month || !$start_year || !$end_month || !$end_year) {
    die('Parámetros inválidos.');
}

try {
    $db = Database::getInstance();
    $start_date = "$start_year-$start_month-01";
    $end_date = "$end_year-$end_month-" . date('t', strtotime("$end_year-$end_month-01"));

    $sql_unido = '
        SELECT DISTINCT 
            p.PERS_NOM, 
            p.PERS_APE, 
            p.PERS_CED, 
            u.SUELDO, 
            u.FECHA_PAGO,
            u.APOR_PATRONAL_CANTIDAD,
            u.APOR_PERSONAL_CANTIDAD,
            c.TIP_CAR_DES,
            c.TIP_CAR_SUELD AS SUELDO_COMPLETO
        FROM 
            pers_unido u
            INNER JOIN pers_personal p ON u.PERS_ID = p.PERS_ID
            INNER JOIN pers_tipo_cargo c ON p.TIP_CAR_ID = c.TIP_CAR_ID
        WHERE 
            u.PERS_ID = :pers_id
            AND u.FECHA_PAGO BETWEEN :start_date AND :end_date
        ORDER BY 
            u.FECHA_PAGO DESC
    ';

    $result_unido = $db->prepare($sql_unido)
        ->bind(':pers_id', $pers_id)
        ->bind(':start_date', $start_date)
        ->bind(':end_date', $end_date)
        ->execute()
        ->fetchAll();

    $detalles = $db->prepare('
        SELECT 
            PRES_DECI_III, 
            PRES_DECI_IV, 
            PERS_FOND_RES,
            PERS_DETALLES_FECHA
        FROM 
            pers_pagos_detalles 
        WHERE 
            PERS_ID = :pers_id
            AND PERS_DETALLES_FECHA BETWEEN :start_date AND :end_date
    ')->bind(':pers_id', $pers_id)
    ->bind(':start_date', $start_date)
    ->bind(':end_date', $end_date)
    ->execute()
    ->fetchAll();

} catch (DatabaseException $e) {
    die('Error al conectar a la base de datos: ' . $e->getMessage());
}

// Calcular el total
$total_sueldo = 0;
$total_aporte_patronal = 0;
$total_aporte_personal = 0;

foreach ($result_unido as $row) {
    $total_sueldo += $row['SUELDO'];
    $total_aporte_patronal += $row['APOR_PATRONAL_CANTIDAD'];
    $total_aporte_personal += $row['APOR_PERSONAL_CANTIDAD'];
}

$total_adicionales = 0;
foreach ($detalles as $detalle) {
    $total_adicionales += $detalle['PRES_DECI_III'] + $detalle['PRES_DECI_IV'] + $detalle['PERS_FOND_RES'];
}

$total_general = $total_sueldo + $total_adicionales;

// Crear PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Datos personales
if (count($result_unido) > 0) {
    $row = $result_unido[0];
    $pdf->Cell(0, 10, $pdf->convertText('Empleado: ') . $pdf->convertText($row['PERS_NOM']) . ' ' . $pdf->convertText($row['PERS_APE']), 0, 1);
    $pdf->Cell(0, 10, $pdf->convertText('Cédula: ') . $row['PERS_CED'], 0, 1);
    $pdf->Cell(0, 10, $pdf->convertText('Cargo: ') . $pdf->convertText($row['TIP_CAR_DES']), 0, 1);
    $pdf->Cell(0, 10, $pdf->convertText('Sueldo Completo: $') . $row['SUELDO_COMPLETO'], 0, 1);
} else {
    die('No se encontraron registros para el empleado en el rango de fechas proporcionado.');
}

// Historial de pagos y aportes
$pdf->Ln(10);
$pdf->Cell(0, 10, $pdf->convertText('Historial de Pagos y Aportes'), 0, 1);
$pdf->SetFont('Arial', '', 10);

// Cabecera de la tabla
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(40, 10, $pdf->convertText('Aporte Personal'), 1);
$pdf->Cell(30, 10, $pdf->convertText('Total a recibir'), 1);
$pdf->Cell(30, 10, $pdf->convertText('Fecha de Pago'), 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
foreach ($result_unido as $row) {
    $pdf->Cell(40, 10, '$' . $row['APOR_PERSONAL_CANTIDAD'], 1);
    $pdf->Cell(30, 10, '$' . $row['SUELDO'], 1);
    $pdf->Cell(30, 10, $row['FECHA_PAGO'], 1);
    $pdf->Ln();
}

// Verificar si hay datos en pers_pagos_detalles y agregarlos al PDF si existen
if ($detalles) {
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, $pdf->convertText('Detalles de Pagos Adicionales'), 0, 1);
    $pdf->SetFont('Arial', 'B', 10);

    // Cabecera de la tabla para los pagos adicionales
    $pdf->Cell(40, 10, $pdf->convertText('Décimo Tercero'), 1);
    $pdf->Cell(40, 10, $pdf->convertText('Décimo Cuarto'), 1);
    $pdf->Cell(40, 10, $pdf->convertText('Fondos de Reserva'), 1);
    $pdf->Cell(40, 10, $pdf->convertText('Fecha de Inserción'), 1);
    $pdf->Ln();

    // Mostrar cada detalle
    $pdf->SetFont('Arial', '', 10);
    foreach ($detalles as $detalle) {
        $pdf->Cell(40, 10, '$' . $detalle['PRES_DECI_III'], 1);
        $pdf->Cell(40, 10, '$' . $detalle['PRES_DECI_IV'], 1);
        $pdf->Cell(40, 10, '$' . $detalle['PERS_FOND_RES'], 1);
        $pdf->Cell(40, 10, $detalle['PERS_DETALLES_FECHA'], 1);
        $pdf->Ln();
    }
}

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, $pdf->convertText('Total Sueldo: $') . $total_sueldo, 0, 1);
$pdf->Cell(0, 10, $pdf->convertText('Total Aporte Personal: $') . $total_aporte_personal, 0, 1);
$pdf->Cell(0, 10, $pdf->convertText('Total General: $') . $total_general, 0, 1);

$pdf->Output();
?>

<?php
require_once('../vendor/autoload.php'); // Si usas Composer para TCPDF

// Crear instancia de TCPDF
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Datos de ejemplo, reemplaza con los datos reales
$cliente = [
    'CLI_CED' => '1234567890',
    'CLI_NOM' => 'Juan Pérez',
    'CLI__NUM' => 'Calle Falsa 123'
];
$reservas = [
    [
        'RES_ID' => '1',
        'HAB_ID' => '101',
        'RES_FECH' => '2024-07-10',
        'RES_FECH_INI' => '2024-07-11',
        'RES_FECH_FIN' => '2024-07-13'
    ]
];
$metodo_pago = 'tarjeta';
$numero_tarjeta = '1234 5678 9876 5432';
$fecha_expiracion = '12/24';
$cvv = '123';

// Establecer contenido HTML
$html = '<h1>Factura</h1>';
$html .= '<img src="http://localhost/hoteloasis/images/logo.png" alt="Logo Hotel Oasis" style="max-height: 100px; margin-bottom: 10px;">'; // Ruta absoluta al logo
$html .= '<p>Fecha: ' . date('Y-m-d') . '</p>';
$html .= '<h2>Datos del Cliente</h2>';
$html .= '<table border="1" cellpadding="4">';
$html .= '<tr><th>Cédula</th><td>' . htmlspecialchars($cliente['CLI_CED']) . '</td></tr>';
$html .= '<tr><th>Nombre</th><td>' . htmlspecialchars($cliente['CLI_NOM']) . '</td></tr>';
$html .= '<tr><th>Dirección</th><td>' . htmlspecialchars($cliente['CLI__NUM']) . '</td></tr>';
$html .= '<tr><th>Teléfono</th><td>' . htmlspecialchars($cliente['CLI__NUM']) . '</td></tr>';
$html .= '</table>';

// Agregar reservas
$html .= '<h2>Detalles de las Reservas</h2>';
if (!empty($reservas)) {
    $html .= '<table border="1" cellpadding="4">';
    $html .= '<tr><th>ID Reserva</th><th>Habitación</th><th>Fecha Registro</th><th>Desde</th><th>Hasta</th></tr>';
    foreach ($reservas as $reserva) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($reserva['RES_ID']) . '</td>';
        $html .= '<td>' . htmlspecialchars($reserva['HAB_ID']) . '</td>';
        $html .= '<td>' . htmlspecialchars($reserva['RES_FECH']) . '</td>';
        $html .= '<td>' . htmlspecialchars($reserva['RES_FECH_INI']) . '</td>';
        $html .= '<td>' . htmlspecialchars($reserva['RES_FECH_FIN']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';
} else {
    $html .= '<div style="padding: 10px; border: 1px solid #f44336; background-color: #fce4e4; color: #f44336; border-radius: 5px;">';
    $html .= '<div style="display: flex; align-items: center; justify-content: center;">';
    $html .= '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right: 8px;"><path d="M9 12h6m-6 4h6m-6-8h6m1 2V5h4v4m-1-4H16m1 0V5m-1 0V4m-1 0h-6a1 1 0 00-1 1v1h-4v4h1v5m-1 5v-5H5v5m0-8h1v-3H5m0 3h2v5h-2m8 0V8h-2v5m2 0h-1V8h1v5m-1 5v-2h-1v2" stroke="#f44336" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    $html .= '<span>No hay reservas para este cliente.</span>';
    $html .= '</div>';
    $html .= '</div>';
}

// Agregar método de pago
$html .= '<h2>Método de Pago</h2>';
$html .= '<table border="1" cellpadding="4">';
$html .= '<tr><th>Método de Pago</th><td>' . htmlspecialchars($metodo_pago) . '</td></tr>';
if ($metodo_pago === 'tarjeta') {
    $html .= '<tr><th>Número de Tarjeta</th><td>' . htmlspecialchars($numero_tarjeta) . '</td></tr>';
    $html .= '<tr><th>Fecha de Expiración</th><td>' . htmlspecialchars($fecha_expiracion) . '</td></tr>';
    $html .= '<tr><th>CVV</th><td>' . htmlspecialchars($cvv) . '</td></tr>';
}
$html .= '</table>';
$html .= '<p>Gracias por su preferencia.</p>';

// Escribir el contenido HTML
$pdf->writeHTML($html);

// Salida del PDF
$pdf->Output('factura.pdf', 'I');
?>

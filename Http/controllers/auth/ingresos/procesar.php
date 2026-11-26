<?php

use Core\Auth;
use Core\Database;
use Core\DatabaseException;

// Recoger los datos del formulario
$data = $_POST;

// Verificar si se recibieron los datos
if (empty($data)) {
    echo json_encode([
        'error' => 'No se han proporcionado datos en el formulario',
    ]);
    die();
}

if (!isset($data['cedula'])) {
    echo json_encode([
        'error' => 'No se ha proporcionado la cédula del cliente'
    ]);
    die();
}

$attributes = [
    'cedula' => $data['cedula'],
    'nombre' => $data['nombre'],
    'direccion' => $data['direccion'],
    'telefono' => $data['telefono'],
    'email' => $data['email'],
    'metodo_pago' => $data['metodo_pago'],
    'montoTotal' => $data['montoTotal'],
    'montoPagar' => $data['montoPagar']
];

// Recoger los datos de las reservas
$reservas = [];
foreach ($data as $key => $value) {
    if (strpos($key, 'monto_reserva_') === 0) {
        $reserva_id = str_replace('monto_reserva_', '', $key);
        $reservas[] = [
            'reserva_id' => $reserva_id,
            'monto_reserva' => $value
        ];
    }
}

// Recoger los datos de los servicios
$servicios = [];
foreach ($data as $key => $value) {
    if (strpos($key, 'monto_servicio_') === 0) {
        $servicio_id = str_replace('monto_servicio_', '', $key);
        $servicios[] = [
            'servicio_id' => $servicio_id,
            'monto_servicio' => $value
        ];
    }
}

try {
    $db = Database::getInstance();

    // Iniciar una transacción SQL manualmente
    $db->query("START TRANSACTION");

    // Insertar en ing_reg_ingresos
    $db->prepare(
        "
        INSERT INTO ing_reg_ingresos (
            ing_reg_ced, ing_reg_nom, ing_reg_direccion, ing_reg_telefono, 
            ing_reg_email, ing_reg_metodo_pago, ing_reg_monto_total, ing_reg_monto_pagar
        ) VALUES (
            :cedula, :nombre, :direccion, :telefono, :email, :metodo_pago, :montoTotal, :montoPagar
        )
        "
    )
    ->bind(':cedula', $attributes['cedula'])
    ->bind(':nombre', $attributes['nombre'])
    ->bind(':direccion', $attributes['direccion'])
    ->bind(':telefono', $attributes['telefono'])
    ->bind(':email', $attributes['email'])
    ->bind(':metodo_pago', $attributes['metodo_pago'])
    ->bind(':montoTotal', $attributes['montoTotal'])
    ->bind(':montoPagar', $attributes['montoPagar'])
    ->execute();

    // Obtener el ID del ingreso recién insertado
    $result = $db->query("SELECT LAST_INSERT_ID() as last_id")->fetch();
    $ingreso_id = $result['last_id'];

    // Insertar reservas asociadas
    foreach ($reservas as $reserva) {
        $db->prepare(
            "
            INSERT INTO ing_reg_reservas (ing_reg_id, res_reserva_id, ing_reserva_monto)
            VALUES (:ingreso_id, :reserva_id, :monto_reserva)
            "
        )
        ->bind(':ingreso_id', $ingreso_id)
        ->bind(':reserva_id', $reserva['reserva_id'])
        ->bind(':monto_reserva', $reserva['monto_reserva'])
        ->execute();
    }

    // Insertar servicios asociados
    foreach ($servicios as $servicio) {
        $db->prepare(
            "
            INSERT INTO ing_reg_servicios (ing_reg_id, tip_serv_id, ing_servicio_monto)
            VALUES (:ingreso_id, :servicio_id, :monto_servicio)
            "
        )
        ->bind(':ingreso_id', $ingreso_id)
        ->bind(':servicio_id', $servicio['servicio_id'])
        ->bind(':monto_servicio', $servicio['monto_servicio'])
        ->execute();
    }

    // Confirmar la transacción
    $db->query("COMMIT");

    Auth::logAction("Ingreso registrado (#$ingreso_id, {$attributes['nombre']}, \${$attributes['montoPagar']})");

    // Enviar respuesta de éxito
    echo json_encode([
        'success' => 'Ingreso registrado exitosamente'
    ]);
// Redirigir de vuelta a la página de registro de ingresos
header("Location: /auth/ingresos/registrar");
exit;
} catch (DatabaseException $e) {
    // Revertir la transacción en caso de error
    $db->query("ROLLBACK");
    echo json_encode([
        'error' => $e->getMessage()
    ]);
}

?>
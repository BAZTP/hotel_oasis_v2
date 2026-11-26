<?php

use Core\Database;
use Core\DatabaseException;

// Verificar que los datos POST existen y no están vacíos
if (!isset($_POST['egreso_id'], $_POST['descripcion'], $_POST['monto'], $_POST['fecha'], $_POST['tipo']) ||
    empty($_POST['egreso_id']) || empty($_POST['descripcion']) || empty($_POST['monto']) || empty($_POST['fecha']) || empty($_POST['tipo'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

// Sanitizar y validar los datos
$id = filter_var($_POST['egreso_id'], FILTER_SANITIZE_NUMBER_INT);
$descripcion = filter_var($_POST['descripcion'], FILTER_SANITIZE_STRING);
$monto = filter_var($_POST['monto'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
$fecha = filter_var($_POST['fecha'], FILTER_SANITIZE_STRING);
$tipo = filter_var($_POST['tipo'], FILTER_SANITIZE_NUMBER_INT);

// Validar el monto como decimal
if (!is_numeric($monto) || $monto <= 0) {
    echo json_encode(['success' => false, 'message' => 'Monto inválido']);
    exit;
}

// Validar que la fecha tiene el formato correcto (YYYY-MM-DD)
if (!DateTime::createFromFormat('Y-m-d', $fecha)) {
    echo json_encode(['success' => false, 'message' => 'Fecha inválida']);
    exit;
}

try {
    $db = Database::getInstance();
    $query = 'UPDATE egr_egreso SET EGR_DES = :descripcion, EGR_MON = :monto, EGR_FEC = :fecha, EGR_TIP_ID = :tipo WHERE EGR_ID = :id';

    // Preparar la consulta
    $stmt = $db->prepare($query);

    // Vincular parámetros
    $stmt->bind(':id', $id, PDO::PARAM_INT);
    $stmt->bind(':descripcion', $descripcion, PDO::PARAM_STR);
    $stmt->bind(':monto', $monto, PDO::PARAM_STR); // Usar PDO::PARAM_STR para manejar decimales
    $stmt->bind(':fecha', $fecha, PDO::PARAM_STR);
    $stmt->bind(':tipo', $tipo, PDO::PARAM_INT);

    // Ejecutar la consulta
    $stmt->execute();

    // Redirigir a la lista de egresos
    header('Location: /auth/egresos');
    exit;
} catch (DatabaseException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el egreso: ' . $e->getMessage()]);
}

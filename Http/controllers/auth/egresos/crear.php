<?php

use Core\Database;
use Core\DatabaseException;

// Verificar si la sesión ya está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Función para validar el RUC
function validateRuc($ruc) {
    // El RUC debe tener exactamente 13 dígitos y terminar en '001'
    if (strlen($ruc) != 13) {
        return "El RUC debe tener exactamente 13 dígitos.";
    }
    if (!ctype_digit($ruc)) {
        return "El RUC debe contener solo dígitos.";
    }
    if (substr($ruc, -3) != '001') {
        return "El RUC debe terminar en '001'.";
    }
    return true;
}

// Consultar los tipos de egreso disponibles antes de procesar la solicitud
try {
    $db = Database::getInstance([
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'oasis',
        'charset' => 'utf8mb4',
        'ssl-mode' => 'preferred'
    ]);

    $tiposEgreso = $db->query("SELECT EGR_TIPO_ID, EGR_NOM FROM egr_tipo_egreso")->fetchAll();
} catch (DatabaseException $e) {
    die("Error al obtener los tipos de egreso: " . $e->getMessage());
}

// Verificar si el método de solicitud es POST para procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha = date('Y-m-d'); // Obtener la fecha actual automáticamente
    $monto = $_POST['monto'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $proveedor = $_POST['proveedor'];
    $ruc = $_POST['ruc'];

    // Validar el RUC
    $rucValidation = validateRuc($ruc);
    if ($rucValidation !== true) {
        $_SESSION['error'] = $rucValidation;
        header('Location: /auth/egresos/crear');
        exit();
    }

    // Validar que el monto sea un número positivo
    if ($monto <= 0) {
        $_SESSION['error'] = "El monto debe ser un valor positivo mayor que cero.";
        header('Location: /auth/egresos/crear');
        exit();
    }

    try {
        // Preparar la consulta SQL usando el método prepare() de Database
        $query = "
            INSERT INTO egr_egreso (EGR_PROVEEDOR, EGR_RUC, EGR_FEC, EGR_MON, EGR_TIP_ID, EGR_DES)
            VALUES (:proveedor, :ruc, :fecha, :monto, :tipo, :descripcion)
        ";

        // Preparar y ejecutar la consulta
        $stmt = $db->prepare($query);

        // Vincular los parámetros usando el método bind() de tu clase Database
        $stmt->bind(':proveedor', $proveedor)
             ->bind(':ruc', $ruc)
             ->bind(':fecha', $fecha)
             ->bind(':monto', $monto)
             ->bind(':tipo', $tipo)
             ->bind(':descripcion', $descripcion)
             ->execute();

        // Establecer mensaje de éxito en la sesión y redirigir
        $_SESSION['success'] = "Egreso añadido exitosamente.";
        header('Location: /auth/egresos');
        exit();
    } catch (DatabaseException $e) {
        // Establecer mensaje de error en la sesión y redirigir
        $_SESSION['error'] = "Error en la consulta SQL: " . $e->getMessage();
        header('Location: /auth/egresos/crear');
        exit();
    }
}

// Mostrar formulario para crear egreso
require base_path('views/auth/egresos/crear.view.php');

?>

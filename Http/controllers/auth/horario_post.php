<?php
use Core\Database;
use Core\DatabaseException;

header('Content-Type: application/json');

// Configurar la zona horaria
date_default_timezone_set('America/Guayaquil');

$data = json_decode(file_get_contents('php://input'), true);
$tipo = $data['tipo'] ?? null;
$timeString = $data['timeString'] ?? null;
$cedula = $data['cedula'] ?? null;

if (!$tipo || !$timeString || !$cedula) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

try {
    $db = Database::getInstance();

    // Buscar el pers_id y nombre basado en la cédula
    $query = $db->prepare("SELECT PERS_ID, PERS_NOM FROM pers_personal WHERE PERS_CED = :cedula");
    $query->bind(':cedula', $cedula);
    $query->execute();
    $pers = $query->fetch();

    if (!$pers) {
        echo json_encode(['success' => false, 'message' => 'No se encontró un usuario con la cédula ingresada']);
        exit;
    }

    $pers_id = $pers['PERS_ID'];
    $nombre = $pers['PERS_NOM'];

    // Determinar el campo a actualizar
    $campo = '';
    switch ($tipo) {
        case 'llegada':
            $campo = 'ASIST_HORA_LLEGADA';
            break;
        case 'inicio_almuerzo':
            $campo = 'ASIST_HORA_ALMU_INI';
            break;
        case 'fin_almuerzo':
            $campo = 'ASIST_HORA_ALMU_FIN';
            break;
        case 'salida':
            $campo = 'ASIST_HORA_SALIDA';
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Tipo de evento no válido']);
            exit;
    }

    // Buscar si ya existe un registro de asistencia para hoy
    $query = $db->prepare("SELECT ASIST_ID FROM pers_asistencia WHERE PERS_ID = :pers_id AND DATE(ASIST_HORA_LLEGADA) = CURDATE()");
    $query->bind(':pers_id', $pers_id);
    $query->execute();
    $asistencia = $query->fetch();

    if ($asistencia) {
        // Actualizar el registro existente
        $query = $db->prepare("UPDATE pers_asistencia SET $campo = :timeString WHERE ASIST_ID = :asist_id");
        $query->bind(':timeString', $timeString);
        $query->bind(':asist_id', $asistencia['ASIST_ID']);
    } else {
        // Insertar un nuevo registro
        $query = $db->prepare("INSERT INTO pers_asistencia (PERS_ID, $campo) VALUES (:pers_id, :timeString)");
        $query->bind(':pers_id', $pers_id);
        $query->bind(':timeString', $timeString);
    }

    $query->execute();
    
    // Obtener registros de asistencia del día actual
    $query = $db->prepare("SELECT PERS_CED, PERS_NOM, ASIST_HORA_LLEGADA, ASIST_HORA_ALMU_INI, ASIST_HORA_ALMU_FIN, ASIST_HORA_SALIDA FROM pers_asistencia JOIN pers_personal ON pers_asistencia.PERS_ID = pers_personal.PERS_ID WHERE DATE(ASIST_HORA_LLEGADA) = CURDATE()");
    $query->execute();
    $registros = $query->fetchAll();

    echo json_encode(['success' => true, 'nombre' => $nombre, 'registros' => $registros]);
} catch (DatabaseException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>

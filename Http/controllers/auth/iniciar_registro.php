<?php
use Core\Database;
use Core\DatabaseException;

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$cedula = $data['cedula'] ?? null;

if (!$cedula) {
    echo json_encode(['success' => false, 'message' => 'Cédula no proporcionada']);
    exit;
}

try {
    $db = Database::getInstance();

    // Buscar el pers_id basado en la cédula
    $query = $db->prepare("SELECT PERS_ID FROM pers_personal WHERE PERS_CED = :cedula");
    $query->bindParam(':cedula', $cedula);
    $query->execute();
    $pers = $query->fetch();

    if (!$pers) {
        echo json_encode(['success' => false, 'message' => 'No se encontró un usuario con la cédula ingresada']);
        exit;
    }

    $pers_id = $pers['PERS_ID'];

    // Verificar si ya existe un registro en curso
    $query = $db->prepare("SELECT ASIST_ID FROM pers_asistencia WHERE PERS_ID = :pers_id AND ASIST_HORA_SALIDA IS NULL");
    $query->bindParam(':pers_id', $pers_id);
    $query->execute();
    $asistencia = $query->fetch();

    if ($asistencia) {
        // Si existe un registro en curso, devolver su ID
        $asistenciaId = $asistencia['ASIST_ID'];
    } else {
        // Crear un nuevo registro de asistencia
        $query = $db->prepare("INSERT INTO pers_asistencia (PERS_ID) VALUES (:pers_id)");
        $query->bindParam(':pers_id', $pers_id);
        $query->execute();

        // Obtener el ID del nuevo registro de asistencia
        $asistenciaId = $db->lastInsertId();
    }

    echo json_encode(['success' => true, 'asistenciaId' => $asistenciaId]);
} catch (DatabaseException $e) {
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error general: ' . $e->getMessage()]);
}
?>

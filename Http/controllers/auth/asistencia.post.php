<?php
use Core\Database;
use Core\DatabaseException;

header('Content-Type: application/json');

$response = ['success' => false, 'error' => ''];

// Eliminar asistencia si se solicita
if (($_POST['action'] ?? '') === 'delete_asistencia') {
    $asist_id = $_POST['asist_id'] ?? null;
    if (!$asist_id) {
        $response['error'] = 'Error: ID de asistencia no proporcionado.';
        echo json_encode($response);
        exit;
    }
    try {
        $db = Database::getInstance();
        $db->prepare("DELETE FROM pers_asistencia WHERE ASIST_ID = :asist_id")
            ->bind(':asist_id', $asist_id)
            ->execute();
        $response['success'] = true;
    } catch (DatabaseException $e) {
        $response['error'] = $e->getMessage();
    }
    echo json_encode($response);
    exit;
}

// Recolección de los atributos desde el formulario
$attributes = [
    'asist_id' => $_POST['asist_id'] ?? null,
    'pers_ced' => $_POST['pers_ced'] ?? null,
    'asist_hora_llegada' => $_POST['asist_hora_llegada'] ?? null,
    'asist_hora_almu_ini' => ($_POST['asist_hora_almu_ini'] ?? '') !== '' ? $_POST['asist_hora_almu_ini'] : null,
    'asist_hora_almu_fin' => ($_POST['asist_hora_almu_fin'] ?? '') !== '' ? $_POST['asist_hora_almu_fin'] : null,
    'asist_hora_salida' => ($_POST['asist_hora_salida'] ?? '') !== '' ? $_POST['asist_hora_salida'] : null,
    'asist_hora_extra' => ($_POST['asist_hora_extra'] ?? '') !== '' ? (int)$_POST['asist_hora_extra'] : 0
];

// Verifica que los campos obligatorios estén presentes
if (empty($attributes['pers_ced']) || empty($attributes['asist_hora_llegada'])) {
    $response['error'] = "Error: La cédula y la hora de llegada son obligatorias.";
    echo json_encode($response);
    exit;
}

try {
    $db = Database::getInstance();
    
    // Buscar el pers_id basado en la pers_ced
    $query = $db->prepare("SELECT PERS_ID FROM pers_personal WHERE PERS_CED = :pers_ced");
    $query->bind(':pers_ced', $attributes['pers_ced']);
    $query->execute();
    $pers = $query->fetch();
    
    if (!$pers) {
        $response['error'] = "Error: No se encontró un usuario con la cédula ingresada.";
        echo json_encode($response);
        exit;
    }
    
    $attributes['pers_id'] = $pers['PERS_ID'];
    
    if (isset($attributes['asist_id']) && !empty($attributes['asist_id'])) {
        // Actualiza la asistencia existente
        $result = $db->prepare(
            "
            UPDATE pers_asistencia 
            SET 
                PERS_ID = :pers_id, 
                ASIST_HORA_LLEGADA = :asist_hora_llegada, 
                ASIST_HORA_ALMU_INI = :asist_hora_almu_ini, 
                ASIST_HORA_ALMU_FIN = :asist_hora_almu_fin, 
                ASIST_HORA_SALIDA = :asist_hora_salida, 
                ASIST_HORA_EXTRA = :asist_hora_extra
            WHERE ASIST_ID = :asist_id
            "
        )
        ->bind(':asist_id', $attributes['asist_id'])
        ->bind(':pers_id', $attributes['pers_id'])
        ->bind(':asist_hora_llegada', $attributes['asist_hora_llegada'])
        ->bind(':asist_hora_almu_ini', $attributes['asist_hora_almu_ini'])
        ->bind(':asist_hora_almu_fin', $attributes['asist_hora_almu_fin'])
        ->bind(':asist_hora_salida', $attributes['asist_hora_salida'])
        ->bind(':asist_hora_extra', $attributes['asist_hora_extra'])
        ->execute();
    } else {
        // Inserta una nueva asistencia
        $result = $db->prepare(
            "
            INSERT INTO pers_asistencia (
                PERS_ID, 
                ASIST_HORA_LLEGADA, 
                ASIST_HORA_ALMU_INI, 
                ASIST_HORA_ALMU_FIN, 
                ASIST_HORA_SALIDA, 
                ASIST_HORA_EXTRA
            )
            VALUES (
                :pers_id, 
                :asist_hora_llegada, 
                :asist_hora_almu_ini, 
                :asist_hora_almu_fin, 
                :asist_hora_salida, 
                :asist_hora_extra
            );
            "
        )
        ->bind(':pers_id', $attributes['pers_id'])
        ->bind(':asist_hora_llegada', $attributes['asist_hora_llegada'])
        ->bind(':asist_hora_almu_ini', $attributes['asist_hora_almu_ini'])
        ->bind(':asist_hora_almu_fin', $attributes['asist_hora_almu_fin'])
        ->bind(':asist_hora_salida', $attributes['asist_hora_salida'])
        ->bind(':asist_hora_extra', $attributes['asist_hora_extra'])
        ->execute();
    }

    $response['success'] = true;
} catch (DatabaseException $e) {
    $response['error'] = $e->getMessage();
}

echo json_encode($response);


?>

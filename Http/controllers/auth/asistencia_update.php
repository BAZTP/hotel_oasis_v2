<?php
use Core\Database;
use Core\DatabaseException;

// Recolección de los atributos desde el formulario
$attributes = [
    'asist_id' => $_POST['asist_id'] ?? null,
    'pers_ced' => $_POST['pers_ced'] ?? null,
    'asist_hora_llegada' => $_POST['asist_hora_llegada'] ?? null,
    'asist_hora_almu_ini' => $_POST['asist_hora_almu_ini'] ?? null,
    'asist_hora_almu_fin' => $_POST['asist_hora_almu_fin'] ?? null,
    'asist_hora_salida' => $_POST['asist_hora_salida'] ?? null,
    'asist_hora_extra' => $_POST['asist_hora_extra'] ?? null
];

// Verifica que todos los campos requeridos estén presentes
foreach ($attributes as $key => $value) {
    if ($value === null && $key != 'asist_id') { // asist_id puede ser nulo
        die("Error: el campo $key no está definido en el formulario.");
    }
}

try {
    $db = Database::getInstance();
    
    // Buscar el pers_id basado en la pers_ced
    $query = $db->prepare("SELECT PERS_ID FROM pers_personal WHERE PERS_CED = :pers_ced");
    $query->bind(':pers_ced', $attributes['pers_ced']);
    $query->execute();
    $pers = $query->fetch();
    
    if (!$pers) {
        die("Error: No se encontró un usuario con la cédula ingresada.");
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
} catch (DatabaseException $e) {
    die($e->getMessage());
}

redirect('/auth/personal/asistencia');
?>

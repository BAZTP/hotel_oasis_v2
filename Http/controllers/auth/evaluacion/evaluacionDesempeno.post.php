<?php
use Core\Database;
use Core\DatabaseException;

$attributes = [
    'idpersona' => strtoupper($_POST['idpersona']),
    'cedula' => strtoupper($_POST['cedula']),
    'nombre' => strtoupper($_POST['nombre']),
    'apellido' => strtoupper($_POST['apellido']),
    'cargo' => strtoupper($_POST['cargo']),
    'evaluacion' => strtoupper($_POST['evaluacion'])
];
// Recolección de atributos adicionales
foreach ($_POST as $key => $value) {
    if (str_starts_with($key, 'field_')) {
        $attributes[$key] = $value;
    }
}

try {
    $db = Database::getInstance();
    $result = $db
        ->prepare(
            "INSERT INTO pers_evaluacion_desempeno (
            PERS_ID, 
            EVA_CED_EMPL, 
            EVA_NOM_EMPL, 
            EVA_APE_EMPL, 
            EVA_CAR_EMPL, 
            EVA_DESEMPENO_EMPL
        ) VALUES (:idpersona, :cedula, :nombre, :apellido, :cargo, :evaluacion);"
        )
        ->bind(':idpersona', $attributes['idpersona'])
        ->bind(':cedula', $attributes['cedula'])
        ->bind(':nombre', $attributes['nombre'])
        ->bind(':apellido', $attributes['apellido'])
        ->bind(':cargo', $attributes['cargo'])
        ->bind(':evaluacion', $attributes['evaluacion'])
        ->execute();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

redirect('/auth/evaluacion');
?>

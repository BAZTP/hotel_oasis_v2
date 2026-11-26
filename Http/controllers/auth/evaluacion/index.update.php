<?php
use Core\Database;
use Core\DatabaseException;

$attributes = [
    'updateIdEva' => strtoupper($_POST['updateIdEva']),
    'updateEva' => strtoupper($_POST['updateEva'])
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
            "UPDATE pers_evaluacion_desempeno SET EVA_DESEMPENO_EMPL = :updateEva WHERE EVA_ID = :updateIdEva"
        )
        ->bind(':updateEva', $attributes['updateEva'])
        ->bind(':updateIdEva', $attributes['updateIdEva'])
        ->execute();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

redirect('/auth/evaluacion');
?>

<?php

use Core\Database;
use Core\DatabaseException;

$attributes = [
    'tipo_instalaciones' => $_POST['tipo_instalaciones'],
    'tipo_personales' => $_POST['tipo_personales']
];
foreach ($_POST as $key => $value) {
    if (str_contains($key, 'field_')) {
        $attributes['additional_fields'][$key] = $value;
    }
}

try {
    $db = Database::getInstance();
    $result = $db
        ->prepare(
            "
        INSERT INTO adm_ins_per (
            INS_ID,
            PERS_ID
        ) VALUES (
            :tipo_instalaciones,
            :tipo_personales
        )"
        )
        ->bind(':tipo_instalaciones', $attributes['tipo_instalaciones'])
        ->bind(':tipo_personales', $attributes['tipo_personales'])
        ->execute();


} catch (DatabaseException $e) {
    die($e->getMessage());
}

redirect('/auth/instalacion/seleccionarpersonal');
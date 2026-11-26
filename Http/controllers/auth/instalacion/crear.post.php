<?php

use Core\Database;
use Core\DatabaseException;

$attributes = [
    'tip_instal' => $_POST['tip_instal'],
    'start_time' => $_POST['start_time'],
    'end_time' => $_POST['end_time']
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
        INSERT INTO adm_instalacion (
            TIP_INS_ID,
            INS_HOR_INI,
            INS_HOR_FIN
        ) VALUES (
            :tip_instal,
            :start_time,
            :end_time
        )"
        )
        ->bind(':tip_instal', $attributes['tip_instal'])
        ->bind(':start_time', $attributes['start_time'])
        ->bind(':end_time', $attributes['end_time'])
        ->execute();
    
} catch (DatabaseException $e) {
    die($e->getMessage());
}

redirect('/auth/instalacion');

?>

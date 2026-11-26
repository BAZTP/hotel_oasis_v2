<?php

use Core\Database;
use Core\DatabaseException;
$attributes = [
    'nuevainstalacion' => strtoupper($_POST['nuevainstalacion'])
];

try {
    $db = Database::getInstance();
    $result = $db
        ->prepare(
            "
        INSERT INTO adm_tip_ins (
            TIP_INS_DES
        ) VALUES (
            :nuevainstalacion
        )"
        )
        ->bind(':nuevainstalacion', $attributes['nuevainstalacion'])
        ->execute();
    
} catch (DatabaseException $e) {
    die($e->getMessage());
}

redirect('/auth/instalacion');

?>

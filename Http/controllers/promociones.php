<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();
    $result = $db
        ->query(
            "
            SELECT * FROM mark_promociones
            ;"
        )
        ->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('promociones.view.php', [
    'head_title' => 'Promociones',
    'promociones' => $result
]);

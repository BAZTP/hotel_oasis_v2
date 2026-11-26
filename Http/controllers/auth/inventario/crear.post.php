<?php

use Core\Database;
use Core\DatabaseException;

$attributes = [
    'descripcion' => strtoupper($_POST['descripcion']),
    'stock' => $_POST['stock'],
   
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
        INSERT INTO adm_inv_gen (
            INV_GEN_DES,
            INV_GEN_STOCK
          
        ) VALUES (
            :descripcion,
            :stock
           
        )"
        )
        ->bind(':descripcion', $attributes['descripcion'])
        ->bind(':stock', $attributes['stock'])
        ->execute();
    
} catch (DatabaseException $e) {
    die($e->getMessage());
}

redirect('/auth/inventario');
?>
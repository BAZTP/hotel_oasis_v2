<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();
    $tipo_instalaciones = $db
        ->query("
            SELECT 
                th.TIP_INS_ID, 
                th.TIP_INS_DES,
                COUNT(h.TIP_INS_ID) AS installation_count
            FROM 
                adm_tip_ins th
            LEFT JOIN 
                adm_instalacion h 
            ON 
                h.TIP_INS_ID = th.TIP_INS_ID 
            GROUP BY 
                th.TIP_INS_ID, th.TIP_INS_DES;
        ")
        ->fetchAll();
    $seleccionar_estados = $db
        ->query("SELECT * FROM adm_est_ins;")
        ->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/instalacion/crear.nueva.php', [
    'head_title' => 'Crear Instalacion',
   
]);

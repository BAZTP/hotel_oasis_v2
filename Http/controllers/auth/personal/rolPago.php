<?php

use Core\Database;
use Core\DatabaseException;

$pers_id = $_GET['PERS_ID'] ?? null;
if (!$pers_id) {
    header('Location: /auth/personal');
    exit;
}

try {
    $db = Database::getInstance();
    $result = $db->prepare('
    SELECT DISTINCT 
        p.PERS_NOM, 
        p.PERS_APE, 
        p.PERS_CED, 
        p.PERS_FECH,
        u.SUELDO, 
        u.FECHA_PAGO,
        u.APOR_PATRONAL_CANTIDAD,
        u.APOR_PERSONAL_CANTIDAD,
        d.PRES_DECI_III,
        d.PRES_DECI_IV,
        d.PERS_FOND_RES,
        d.PERS_DETALLES_FECHA,
        c.TIP_CAR_DES,
        c.TIP_CAR_SUELD
    FROM 
        pers_unido u
        JOIN pers_personal p ON u.PERS_ID = p.PERS_ID
        JOIN pers_tipo_cargo c ON p.TIP_CAR_ID = c.TIP_CAR_ID
        LEFT JOIN (
            SELECT 
                PERS_ID, 
                MAX(PRES_DECI_III) AS PRES_DECI_III, 
                MAX(PRES_DECI_IV) AS PRES_DECI_IV, 
                MAX(PERS_FOND_RES) AS PERS_FOND_RES, 
                MAX(PERS_DETALLES_FECHA) AS PERS_DETALLES_FECHA
            FROM 
                pers_pagos_detalles 
            GROUP BY 
                PERS_ID
        ) d ON u.PERS_ID = d.PERS_ID
    WHERE 
        u.PERS_ID = :pers_id
    ORDER BY 
        u.FECHA_PAGO DESC
    ')->bind(':pers_id', $pers_id)
        ->execute()
        ->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

$attributes = [
  'pers_id' => $pers_id
];

view('auth/personal/rol.php', [
    'head_title' => 'roles',
    'result' => $result,
    'attributes' => $attributes,
]);
?>

<?php

use Core\Database;
use Core\DatabaseException;

try {
	$db = Database::getInstance();

    $seleccionar_instalacion = $db
        ->query("SELECT 
            th.INS_ID, 
            th.TIP_INS_ID,
            ti.TIP_INS_DES
        FROM 
            adm_instalacion th
        JOIN 
            adm_tip_ins ti ON th.TIP_INS_ID = ti.TIP_INS_ID
        GROUP BY 
            th.INS_ID, 
            th.TIP_INS_ID,
            ti.TIP_INS_DES;")
        ->fetchAll();
    $seleccionar_inventario = $db
        ->query("SELECT * FROM adm_inv_gen WHERE EST_INV_GEN_ID = 1;")
        ->fetchAll();
} catch (DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario/crear.instalacion.php', [
	'head_title' => 'Crear Inventario',

    'seleccionar_instalacion' => $seleccionar_instalacion,
    'seleccionar_inventario' => $seleccionar_inventario
    

]);

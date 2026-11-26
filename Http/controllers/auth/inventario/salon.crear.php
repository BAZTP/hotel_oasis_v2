<?php

use Core\Database;
use Core\DatabaseException;

try {
	$db = Database::getInstance();
	$seleccionar_salon = $db
    ->query("SELECT
	 	th.SAL_ID,
		th.TIP_SAL_ID,
		ti.TIP_SAL_DES
		FROM 
		adm_salon th
		JOIN 
		adm_tip_sal ti ON th.TIP_SAL_ID = ti.TIP_SAL_ID
		GROUP BY
		th.SAL_ID
		,th.TIP_SAL_ID
		,ti.TIP_SAL_DES
		
		
		;")
    ->fetchAll();

	$seleccionar_inventario = $db

		->query("SELECT * FROM adm_inv_gen WHERE EST_INV_GEN_ID = 1;")
		->fetchAll();


} catch (DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario/crear.salon.php', [
	'head_title' => 'Crear Inventario',
	'seleccionar_salon' => $seleccionar_salon,
	'seleccionar_inventario' => $seleccionar_inventario
]);

<?php

use Core\Database;
use Core\DatabaseException;

try {
	$db = Database::getInstance();
	$seleccionar_habitacion = $db
    ->query("SELECT * FROM adm_habitacion WHERE EST_HAB_ID = 1;")
    ->fetchAll();

	$seleccionar_inventario = $db

		->query("SELECT * FROM adm_inv_gen  WHERE EST_INV_GEN_ID = 1;")
		->fetchAll();


} catch (DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario/crear.habitacion.php', [
	'head_title' => 'Crear Inventario',
	'seleccionar_habitacion' => $seleccionar_habitacion,
	'seleccionar_inventario' => $seleccionar_inventario
]);

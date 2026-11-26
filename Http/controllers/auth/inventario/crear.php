<?php

use Core\Database;
use Core\DatabaseException;

try {
	$db = Database::getInstance();

	$tipo_inventario = $db
		->query(
			"
    SELECT INV_GEN_DES
           
    FROM 
        adm_inv_gen 
   "
		)
		->fetchAll();
} catch (DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario/crear.view.php', [
	'head_title' => 'Crear Inventario',
	'tipo_inventario' => $tipo_inventario

]);

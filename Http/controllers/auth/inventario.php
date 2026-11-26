<?php

use Core\Database;

try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
            SELECT * FROM adm_inv_gen"
		)
		->fetchAll();
} catch (\Core\DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario.view.php', [
	'head_title' => 'Inventario',
	'reservas' => $result
]);

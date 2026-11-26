<?php

use Core\Database;

try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
            SELECT * FROM adm_inv_gen AI
			JOIN adm_est_inv_gen A ON AI.EST_INV_GEN_ID = A.EST_INV_GEN_ID;"
		)
		->fetchAll();
	$modalCantidadd = $db
		->query(
			"
			SELECT * FROM adm_est_inv_gen;"
		)
		->fetchAll();
		$estados = $db
		->query(
			"
			SELECT * FROM adm_est_inv_gen;"
		)
		->fetchAll();
} catch (\Core\DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario/index.view.php', [
	'head_title' => 'Inventario',
	'modalCantidad' => $modalCantidadd,
	'reservas' => $result,
	'estados' => $estados
]);

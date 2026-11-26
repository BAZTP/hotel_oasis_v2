<?php

use Core\Database;

try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
            SELECT *
             FROM adm_instalacion ai
             JOIN adm_tip_ins ati ON ai.ins_id = ati.tip_ins_id
              JOIN adm_est_ins au ON ai.ins_id = au.est_ins_id"
		)
		->fetchAll();
} catch (\Core\DatabaseException $e) {
	die($e->getMessage());
}

view('auth/instalacion.view.php', [
	'head_title' => 'Instalacion',
	'reservas' => $result
]);

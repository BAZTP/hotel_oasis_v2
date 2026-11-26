<?php

use Core\Database;

try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
         SELECT *
FROM adm_instalacion ai
JOIN adm_tip_ins ati ON ai.tip_ins_id = ati.tip_ins_id
JOIN adm_est_ins au ON ai.est_ins_id = au.est_ins_id;

"
		)
		->fetchAll();
		$estados = $db
		->query(
			"
			SELECT * FROM adm_est_ins;"
		)
		->fetchAll();
		$tipo_instalaciones = $db
        ->query("
            SELECT 
                th.TIP_INS_ID, 
                th.TIP_INS_DES
            FROM 
                adm_tip_ins th
             
            GROUP BY 
                th.TIP_INS_ID, th.TIP_INS_DES;
        ")
        ->fetchAll();
} catch (\Core\DatabaseException $e) {
	die($e->getMessage());
}

view('auth/instalacion/index.view.php', [
	'head_title' => 'Instalacion',
	'reservas' => $result,
	'estados' => $estados,
	'tipo_instalaciones' => $tipo_instalaciones
]);

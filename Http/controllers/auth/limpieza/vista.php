<?php

use Core\Database;

try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
           SELECT * 
        FROM ADM_LIM_PROG AI
        JOIN ADM_EST_LIM_PROG AEL ON AI.LIM_PROG_ID = AEL.EST_LIM_PROG_ID
        JOIN ADM_TIP_INS PP ON AI.LIM_PROG_ID = PP.TIP_INS_ID;

"
			
		)
		->fetchAll();
} catch (\Core\DatabaseException $e) {
	die($e->getMessage());
}

view('auth/limpieza/vista.view.php', [
	'head_title' => 'Limpieza',
	'limpieza' => $result
]);

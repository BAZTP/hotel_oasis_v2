<?php

use Core\Database;
use Core\DatabaseException;
try {
    $db = Database::getInstance();
   	$result = $db
		->query("
     SELECT * 
        FROM adm_lim_prog AI
        JOIN adm_est_lim_prog ATI ON AI.EST_LIM_PROG_ID = ATI.EST_LIM_PROG_ID
        JOIN pers_personal AU ON AI.PERS_ID = AU.PERS_ID
        ;")
    ->fetchAll();
    $estados = $db
    ->query(
        "
        SELECT * FROM adm_est_lim_prog;"
    )
    ->fetchAll();
    $tipo_personales = $db
        ->query(
            "
            SELECT 
                th.PERS_ID,
                th.PERS_NOM,
                COUNT(h.PERS_ID) AS personal_count
            FROM
                pers_personal th
            LEFT JOIN
                adm_lim_prog h
            ON
                h.PERS_ID = th.PERS_ID
            WHERE
                th.tip_car_id = 4
            GROUP BY
                th.PERS_ID, th.PERS_NOM;
            "
        )
        ->fetchAll();
} catch (DatabaseException $e) {
	die($e->getMessage());
}

view('auth/limpieza/index.view.php', [
    'head_title' => 'Limpieza',
    'reservas' => $result,
    'estados' => $estados,
    'tipo_personales' => $tipo_personales
]);
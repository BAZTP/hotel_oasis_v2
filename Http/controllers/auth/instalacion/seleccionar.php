<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();
    $result = $db
		->query(
			"
            SELECT * FROM adm_ins_per AI
            JOIN pers_personal AU ON AI.PERS_ID = AU.PERS_ID
            JOIN adm_instalacion EO ON AI.INS_ID = EO.INS_ID
            JOIN adm_tip_ins TI ON EO.TIP_INS_ID = TI.TIP_INS_ID
           "
		)
		->fetchAll();
        $tipo_instalaciones = $db
        ->query("
        SELECT 
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
            ti.TIP_INS_DES;

        ")
        ->fetchAll();
         // Obtener el tipo de personal
         $tipo_personales = $db
         ->query(" SELECT 
                th.PERS_ID,
                th.PERS_NOM,
                COUNT(h.PERS_ID) AS personal_count
            FROM
                pers_personal th
            LEFT JOIN
                adm_ins_per h
            ON
                h.PERS_ID = th.PERS_ID
            WHERE
                th.tip_car_id = 3
            GROUP BY
                th.PERS_ID, th.PERS_NOM;
            ")
         ->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/instalacion/per.view.php', [
    'head_title' => ' Asignar Personal',
   'reservas' => $result,
    'tipo_instalaciones' => $tipo_instalaciones,
    'tipo_personales' => $tipo_personales
]);

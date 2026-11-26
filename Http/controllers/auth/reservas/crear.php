<?php

use Core\Database;
use Core\DatabaseException;

try {
	$db = Database::getInstance();
	$tipo_habitaciones = $db
		->query(
			"
    SELECT 
        h.TIP_HAB_ID, 
        th.TIP_HAB_DES,
        th.TIP_HAB_CAP,
        COUNT(DISTINCT h.HAB_ID) AS cantidad,
        COALESCE(SUM(ser.SER_VAL_UNI), 0) AS total
    FROM 
        adm_habitacion h
        JOIN adm_tip_hab th ON h.TIP_HAB_ID = th.TIP_HAB_ID
        LEFT JOIN adm_def_tip_hab_ser dth ON th.TIP_HAB_ID = dth.TIP_HAB_ID
        LEFT JOIN adm_servicio ser ON dth.SER_ID = ser.SER_ID
    WHERE 
        h.EST_HAB_ID = 1 
    GROUP BY 
        h.TIP_HAB_ID, th.TIP_HAB_DES, th.TIP_HAB_CAP;"
		)
		->fetchAll();

	$tipo_salones = $db
		->query(
			"
    SELECT 
        s.TIP_SAL_ID, 
        ts.TIP_SAL_DES, 
        COUNT(DISTINCT s.SAL_ID) AS cantidad,
        COALESCE(SUM(ser.SER_VAL_UNI), 0) AS total
    FROM 
        adm_salon s
        JOIN adm_tip_sal ts ON s.TIP_SAL_ID = ts.TIP_SAL_ID
        LEFT JOIN adm_def_tip_sal_ser dts ON ts.TIP_SAL_ID = dts.TIP_SAL_ID
        LEFT JOIN adm_servicio ser ON dts.SER_ID = ser.SER_ID
    WHERE 
        s.EST_SAL_ID = 1
    GROUP BY 
        s.TIP_SAL_ID, ts.TIP_SAL_DES;"
		)
		->fetchAll();
} catch (DatabaseException $e) {
	die($e->getMessage());
}

view('auth/reservas/crear.view.php', [
	'head_title' => 'Crear Reserva',
	'tipo_habitaciones' => $tipo_habitaciones,
	'tipo_salones' => $tipo_salones
]);

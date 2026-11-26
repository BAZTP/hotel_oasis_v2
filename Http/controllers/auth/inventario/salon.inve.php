<?php

use Core\Database;

try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
            SELECT 
			AI.INV_SAL_ID,
			AI.SAL_ID,
			T.TIP_SAL_DES,
			AG.INV_GEN_DES,
			SUM(AI.INV_SAL_STOCK) AS INV_SAL_STOCK
			FROM adm_inv_sal AI
			JOIN adm_inv_gen AG ON AI.INV_GEN_ID = AG.INV_GEN_ID
			JOIN adm_salon S ON AI.SAL_ID = S.SAL_ID
			JOIN adm_tip_sal T ON S.TIP_SAL_ID = T.TIP_SAL_ID 
			GROUP BY AI.SAL_ID, AG.INV_GEN_DES, T.TIP_SAL_DES, AI.INV_SAL_ID
			
        ;
			
			"
		)
		->fetchAll();
		$seleccionar_inventario = $db

		->query("SELECT * FROM adm_inv_gen  WHERE EST_INV_GEN_ID = 1;")
		->fetchAll();
		$seleccionar_salon = $db
    ->query("SELECT
	 	th.SAL_ID,
		th.TIP_SAL_ID,
		ti.TIP_SAL_DES
		FROM 
		adm_salon th
		JOIN 
		adm_tip_sal ti ON th.TIP_SAL_ID = ti.TIP_SAL_ID
		GROUP BY
		th.SAL_ID
		,th.TIP_SAL_ID
		,ti.TIP_SAL_DES
		
		
		;")
    ->fetchAll();
} catch (\Core\DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario/salon.view.php', [
	'head_title' => 'Salon',
	'reservas' => $result,
	'seleccionar_inventario' => $seleccionar_inventario,
	'seleccionar_salon' => $seleccionar_salon
]);

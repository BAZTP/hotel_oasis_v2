<?php

use Core\Database;

try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
			  SELECT 
            AI.INV_INS_ID,
            AI.INS_ID,
            T.TIP_INS_DES,
            AI.INV_INS_STOCK,
            AG.INV_GEN_DES,
            SUM(AI.INV_INS_STOCK) AS INV_INS_STOCK
        FROM adm_inv_ins AI
        JOIN adm_instalacion A ON AI.INS_ID = A.INS_ID
        JOIN adm_inv_gen AG ON AI.INV_GEN_ID = AG.INV_GEN_ID
        JOIN adm_tip_ins T ON A.TIP_INS_ID = T.TIP_INS_ID
        GROUP BY AI.INS_ID, AG.INV_GEN_DES, T.TIP_INS_DES, AI.INV_INS_ID, AI.INV_INS_STOCK
 
        ;
			
			"
		)
		->fetchAll();
	
		$seleccionar_inventario = $db

		->query("SELECT * FROM adm_inv_gen  WHERE EST_INV_GEN_ID = 1;")
		->fetchAll();
		$seleccionar_instalacion = $db
        ->query("SELECT 
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
            ti.TIP_INS_DES;")
        ->fetchAll();
} catch (\Core\DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario/instalacion.view.php', [
	'head_title' => 'Inventario',
	'reservas' => $result,
	'seleccionar_inventario' => $seleccionar_inventario,
	'seleccionar_instalacion' => $seleccionar_instalacion
]);

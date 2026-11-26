<?php

use Core\Database;

try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
	SELECT
    AI.INV_HAB_ID, 
    AI.HAB_ID, 
    AI.INV_HAB_STOCK,
    AI.INV_GEN_ID,
    AG.INV_GEN_DES, 
    SUM(AI.INV_HAB_STOCK) AS INV_HAB_STOCK_TOTAL
FROM 
    adm_inv_hab AI
JOIN 
    adm_habitacion AH ON AI.HAB_ID = AH.HAB_ID
JOIN 
    adm_inv_gen AG ON AI.INV_GEN_ID = AG.INV_GEN_ID
GROUP BY 
    AI.INV_HAB_ID, AI.HAB_ID, AI.INV_HAB_STOCK, AI.INV_GEN_ID, AG.INV_GEN_DES;

			"
		)
		->fetchAll();

    $seleccionar_habitacion = $db
    ->query("SELECT * FROM adm_habitacion WHERE EST_HAB_ID = 1;")
    ->fetchAll();
    $seleccionar_inventario = $db

	->query("SELECT * FROM adm_inv_gen  WHERE EST_INV_GEN_ID = 1;")
	->fetchAll();
} catch (\Core\DatabaseException $e) {
	die($e->getMessage());
}

view('auth/inventario/habitacion.view.php', [
	'head_title' => 'Inventario',
	'reservas' => $result,
    'seleccionar_habitacion' => $seleccionar_habitacion,
    'seleccionar_inventario' => $seleccionar_inventario
]);

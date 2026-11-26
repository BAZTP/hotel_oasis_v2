<?php

use Core\Database;
use Core\DatabaseException;



try {
	$db = Database::getInstance();
	$result = $db
		->query(
			"
    SELECT
      RES_ID,
      HAB_ID,
      SAL_ID,
      RES_FECH,
      RES_FECH_INI,
      RES_FECH_FIN,
      adm_reserva.CLI_ID,
      CLI_NOM,
      CLI_CED,
      PERS_ID,
      adm_reserva.EST_RES_ID,
      EST_RES_DES 
    from 
      adm_reserva,
      mark_cliente,
      adm_est_res
    where adm_reserva.CLI_ID = mark_cliente.CLI_ID
    and adm_reserva.EST_RES_ID = adm_est_res.EST_RES_ID
    order by RES_ID desc"
		)
		->fetchAll();
  $estados = $db
    ->query(
      "
    SELECT
      EST_RES_ID,
      EST_RES_DES
    from 
      adm_est_res"
    )->fetchAll();
} catch (DatabaseException $e) {
	die($e->getMessage());
}

view('auth/reservas/index.view.php', [
	'head_title' => 'Reservas',
	'reservas' => $result,
  'estados' => $estados,
]);

<?php

use Core\Database;
use Core\DatabaseException;

$search = $_GET['search'] ?? '';

try {
	$db = Database::getInstance();
	$result = $db
		->prepare(
			"
        SELECT
          pp.PERS_ID,
          pp.PERS_CED,
          pp.PERS_NOM,
          pp.PERS_APE,
          ptc.TIP_CAR_DES
        FROM
          pers_personal pp
        JOIN 
          pers_tipo_cargo ptc
        ON
          ptc.TIP_CAR_ID = pp.TIP_CAR_ID
        WHERE
          pp.PERS_NOM LIKE CONCAT('%', :search, '%')
        OR 
          pp.PERS_CED LIKE CONCAT('%', :search, '%')
        LIMIT 100
      "
    )
    ->bind(':search', $search)
		->execute()
    ->fetchAll();
} catch (DatabaseException $e) {
	die($e->getMessage());
}

echo json_encode([
  'success' => true,
  'data' => $result
]);



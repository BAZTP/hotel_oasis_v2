


<?php

use Core\Database;
use Core\DatabaseException;

$cedula = $_GET['cedula'] ?? '';

try {
	$db = Database::getInstance();
	$result = $db
		->prepare(
			"
        SELECT
            COUNT(*)
        FROM
          pers_personal
        WHERE
          PERS_CED LIKE CONCAT('%', :cedula, '%')
        LIMIT 100
      "
    )
    ->bind(':cedula', $cedula)
		->execute()
    ->fetchAll();
} catch (DatabaseException $e) {
	die($e->getMessage());
}

echo json_encode([
  'success' => true
]);



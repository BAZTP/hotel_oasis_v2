<?php
header('Content-Type: application/json');

use Core\Database;
use Core\DatabaseException;

$search = $_GET['search'] ?? '';

try {
	$db = Database::getInstance();
	$result = $db
		->prepare(
			"
            SELECT
                CLI_ID,
                CLI_NOM,
                CLI_CED,
                CLI__NUM
            FROM
                mark_cliente
            WHERE
                CLI_NOM LIKE CONCAT('%', :search, '%')
            OR 
                CLI_CED LIKE CONCAT('%', :search, '%')
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

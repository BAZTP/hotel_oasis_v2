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
                SER_ID,
                EST_SER_ID,
                SER_DES,
                SER_VAL_UNI
            FROM
                adm_servicio
            WHERE
                SER_DES LIKE CONCAT('%', :search, '%')
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
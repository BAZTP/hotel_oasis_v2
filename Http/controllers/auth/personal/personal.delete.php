<?php
use Core\Database;

$id = $_POST['delete_personal_id'];

try {
  $db = Database::getInstance();
  $db->prepare('UPDATE pers_personal SET PERS_EST_ID = 2 WHERE PERS_ID = :id')
    ->bind(':id', $id)
    ->execute();
  redirect('/auth/personal');
} catch (Exception $e) {
  echo $e->getMessage();
}

redirect('/auth/personal');
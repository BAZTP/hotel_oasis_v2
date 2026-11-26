<?php
use Core\Database;

$id = $_GET['delete_reserva_id'];

try {
  $db = Database::getInstance();
  $db->prepare('UPDATE adm_reserva SET EST_RES_ID = 4 WHERE RES_ID = :id')
    ->bind(':id', $id)
    ->execute();
  redirect('/auth/reservas');
} catch (Exception $e) {
  echo $e->getMessage();
}

redirect('/auth/reservas');
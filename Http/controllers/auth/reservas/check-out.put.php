<?php

use Core\Database;
use Core\DatabaseException;

$attributes = [
  'reserva_id' => $_POST['reserva_id'],
  'habitacion' => $_POST['hab_id']?? null,
  'salon' => $_POST['sal_id']?? null,
];

if ($attributes['habitacion']==null){
  foreach ($_POST as $key => $value) {
    if (str_contains($key, 'client_')) {
      $attributes['client'][] = $value;
    }
  }
}

try {
  $db = Database::getInstance();
  $db->prepare('UPDATE adm_reserva SET EST_RES_ID = 3 WHERE RES_ID = :id')
    ->bind(':id', $attributes['reserva_id'])
    ->execute();

  if ($attributes['habitacion'] != null) {
    $db->prepare('INSERT INTO adm_registro(TIP_REG_ID, HAB_ID, REG_FECH)
                       VALUES(2, :habitacion, now())')
      ->bind(':habitacion', $attributes['habitacion'])
      ->execute();
    if (isset($attributes['client'])) {
      foreach ($attributes['client'] as $client) {
        $db->prepare('INSERT INTO adm_reg_cli(REG_ID, CLI_ID) VALUES ((SELECT REG_ID FROM adm_registro WHERE HAB_ID = :habitacion ORDER BY REG_ID DESC LIMIT 1), :client)')
          ->bind(':habitacion', $attributes['habitacion'])
          ->bind(':client', $client)
          ->execute();
      }
    }
  }
} catch (DatabaseException $e) {
  die($e->getMessage());
}

redirect('/auth/reservas');
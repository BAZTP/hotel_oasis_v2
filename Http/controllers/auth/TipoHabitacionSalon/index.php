<?php

use Core\Database;
use Core\DatabaseException;

try {
  $db = Database::getInstance();
  $habitaciones = $db
    ->query(
      "
    SELECT
        TIP_HAB_ID,
        TIP_HAB_DES
    from 
      adm_tip_hab"
    )
    ->fetchAll();

  $salones = $db
    ->query(
      "
      SELECT
        TIP_SAL_ID,
        TIP_SAL_DES
      from
        adm_tip_sal"
    )->fetchAll();
} catch (DatabaseException $e) {
  die($e->getMessage());
}

view('auth/TipoHabitacionSalon/index.view.php', [
  'head_title' => 'Tipo de Habitaciones/Salones',
  'habitaciones' => $habitaciones,
  'salones' => $salones
]);
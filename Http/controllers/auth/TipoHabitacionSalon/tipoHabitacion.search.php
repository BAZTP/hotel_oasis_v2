<?php
use Core\Database;
use Core\DatabaseException;

$tip_hab_id = $_GET['id'];

try {
  $db = Database::getInstance();
  $tipoHabitacion = $db->prepare("
    SELECT
      TIP_HAB_ID,
      TIP_HAB_DES
    FROM
       adm_tip_hab
    WHERE
        TIP_HAB_ID = :id")
    ->bind(':id', $tip_hab_id)
    ->execute()->fetch();
  $Servicios = $db->prepare("
    SELECT
        dt.DEF_TIP_HAB_SER_ID,
        s.SER_ID,
        SER_DES,
        s.SER_VAL_UNI
    FROM
        adm_servicio s,
        adm_def_tip_hab_ser dt
    WHERE
        s.SER_ID = dt.SER_ID AND
        dt.TIP_HAB_ID= :id")
    ->bind(':id', $tip_hab_id)
    ->execute()->fetchAll();
} catch (DatabaseException $e) {
  die($e->getMessage());
}

echo json_encode([
    'success' => true,
    'data' => [
      'tipoHabitacion' => $tipoHabitacion,
      'servicios' => $Servicios?? []
      ]
  ]
);
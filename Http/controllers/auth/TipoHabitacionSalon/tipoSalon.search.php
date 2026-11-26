<?php

use Core\Database;
use Core\DatabaseException;

$tip_sal_id = $_GET['id'];

try {
  $db = Database::getInstance();
  $tipoSalon = $db->prepare("
    SELECT
      TIP_SAL_ID,
      TIP_SAL_DES
    FROM
       adm_tip_sal
    WHERE
      TIP_SAL_ID = :id")
    ->bind(':id', $tip_sal_id)
    ->execute()->fetch();
  $servicios  = $db->prepare("
    SELECT
        dt.DEF_TIP_SAL_SER_ID,
        s.SER_ID,
        SER_DES,
        s.SER_VAL_UNI
    FROM
        adm_servicio s,
        adm_def_tip_sal_ser dt
    WHERE
        s.SER_ID = dt.SER_ID AND
        dt.TIP_SAL_ID= :id")
    ->bind(':id', $tip_sal_id)
    ->execute()->fetchAll();
} catch (DatabaseException $e) {
  die($e->getMessage());
}

echo json_encode([
    'success' => true,
    'data' => [
      'tipoSalon' => $tipoSalon,
      'servicios' => $servicios?? []
    ]
  ]);
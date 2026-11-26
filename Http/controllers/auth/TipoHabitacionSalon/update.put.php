<?php

use Core\Database;
use Core\DatabaseException;

header('Content-Type: application/json');

$_PUT = json_decode(file_get_contents('php://input'), true);

if (!isset($_PUT['id'])) {
  echo json_encode([
    'error' => 'No se ha seleccionado un tipo de habitación/salón'
  ]);
  die();
}

$attributes = [
  'id' => $_PUT['id'],
  'salon' => $_PUT['salon'],
  'description' => $_PUT['description']
];

foreach ($_PUT as $key => $value) {
  if (str_contains($key, 'servicio_')) {
    $attributes['services'][] = $value;
  }
}

try {
  $db = Database::getInstance();
  if($attributes['salon'] == 1){
    $db->prepare('UPDATE adm_tip_hab SET TIP_HAB_DES = :description WHERE TIP_HAB_ID = :id')
      ->bind(':description', $attributes['description'])
      ->bind(':id', $attributes['id'])
      ->execute();

    if(isset($attributes['services'])){
      $db->prepare('DELETE FROM adm_def_tip_hab_ser WHERE TIP_HAB_ID = :id')
        ->bind(':id', $attributes['id'])
        ->execute();

      foreach ($attributes['services'] as $service) {
        $db->prepare('INSERT INTO adm_def_tip_hab_ser (TIP_HAB_ID, SER_ID) VALUES (:id, :service)')
          ->bind(':id', $attributes['id'])
          ->bind(':service', $service)
          ->execute();
      }
    }
  }else{
    $db->prepare('UPDATE adm_tip_sal SET TIP_SAL_DES = :description WHERE TIP_SAL_ID = :id')
      ->bind(':description', $attributes['description'])
      ->bind(':id', $attributes['id'])
      ->execute();

    if (isset($attributes['services'])){
      $db->prepare('DELETE FROM adm_def_tip_sal_ser WHERE TIP_SAL_ID = :id')
        ->bind(':id', $attributes['id'])
        ->execute();

      foreach ($attributes['services'] as $service) {
        $db->prepare('INSERT INTO adm_def_tip_sal_ser (TIP_SAL_ID, SER_ID) VALUES (:id, :service)')
          ->bind(':id', $attributes['id'])
          ->bind(':service', $service)
          ->execute();
      }
    }
  }

  echo json_encode([
    'success' => 'Tipo de habitación/salón actualizado correctamente'
  ]);
} catch (DatabaseException $e) {
  echo json_encode([
    'error' => 'Error al actualizar el tipo de habitación/salón'
  ]);
}


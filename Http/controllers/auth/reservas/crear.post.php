<?php

use Core\Database;
use Core\DatabaseException;

$_POST = json_decode(file_get_contents('php://input'), true);

if(!isset($_POST['client_id'])){
  echo json_encode([
    'error' => 'No se ha seleccionado un cliente'
  ]);
  die();
}

$attributes = [
  'initial_date' => $_POST['initial_date'],
  'final_date' => $_POST['final_date'],
  'principal_room' => $_POST['principal_room'],
  'principal_num_rooms' => $_POST['principal_num_rooms'],
  'client_id' => $_POST['client_id']
];

foreach ($_POST as $key => $value) {
  if(str_contains($key, 'room_'))
  {
    $attributes['more_rooms_tip'][$key] = $value;
  }
  if(str_contains($key, 'quantity_'))
  {
    $attributes['more_rooms_num'][$key] = $value;
  }
}

/*Hacer despues no olvidar*/
// $form = ReservaForm::validate($attributes);

try {
  $db = Database::getInstance();
  /* Verificar si hay suficientes habitaciones disponibles */
  /* Verificación del primer tipo de habitación */
  if (str_contains($attributes['principal_room'], '-hab')){
    $rooms = $db->prepare('Select HAB_ID from adm_habitacion where TIP_HAB_ID = :principal_room and EST_HAB_ID = 1')
      ->bind(':principal_room', explode('-', $attributes['principal_room'])[0])
      ->execute()
      ->fetchAll();

    if(count($rooms) < $attributes['principal_num_rooms'])
    {
      echo json_encode([
        'error' => 'No hay suficientes habitaciones disponibles para el primer tipo de habitación/salón',
      ]);
      die();
    }
  } else {
    $rooms = $db->prepare('Select SAL_ID from adm_salon where TIP_SAL_ID = :principal_salon and EST_SAL_ID = 1')
      ->bind(':principal_salon', explode('-', $attributes['principal_room'])[0])
      ->execute()
      ->fetchAll();

    if(count($rooms) < $attributes['principal_num_rooms'])
    {
      echo json_encode([
        'error' => 'No hay suficientes salones disponibles para el primer tipo de habitación/salón',
      ]);
      die();
    }
  }

  if(count(@$attributes['more_rooms_tip']? $attributes['more_rooms_tip']:[]) > 0){
    /* Verificación de los tipos de habitaciones adicionales */
    for ($i = 1; $i <= count($attributes['more_rooms_tip']); $i++){
      if (str_contains($attributes['more_rooms_tip']['room_' . $i], '-hab')){
        $rooms = $db->prepare('Select HAB_ID from adm_habitacion where TIP_HAB_ID = :room and EST_HAB_ID = 1')
          ->bind(':room', explode('-', $attributes['more_rooms_tip']['room_' . $i])[0])
          ->execute()
          ->fetchAll();

        if($attributes['more_rooms_num']['quantity_' . $i] > count($rooms))
        {
          echo json_encode([
            'error' => 'No hay suficientes habitaciones disponibles de las adicionales para el tipo '. $i .' de habitación/salón de las adicionales',
          ]);
          die();
        }
      } else {
        $rooms = $db->prepare('Select SAL_ID from adm_salon where TIP_SAL_ID = :room and EST_SAL_ID = 1')
          ->bind(':room', explode('-', $attributes['more_rooms_tip']['room_' . $i])[0])
          ->execute()
          ->fetchAll();

        if($attributes['more_rooms_num']['quantity_' . $i] > count($rooms))
        {
          echo json_encode([
            'error' => 'No hay suficientes salones disponibles de las adicionales',
          ]);
          die();
        }
      }
    }
  }

  /*Ingreso del primer tipo de habitación*/
  if (str_contains($attributes['principal_room'], '-hab')){
    $query = '
      Insert into adm_reserva(
                              PERS_ID,
                              CLI_ID,
                              HAB_ID,
                              RES_FECH,
                              RES_FECH_INI,
                              RES_FECH_FIN
      )
      values(
              1,
              :client_id,
              :principal_room,
              now(),
              :initial_date,
              :final_date
      )';
    $rooms = $db->prepare('Select HAB_ID from adm_habitacion where TIP_HAB_ID = :principal_room and EST_HAB_ID = 1')
      ->bind(':principal_room', explode('-', $attributes['principal_room'])[0])
      ->execute()
      ->fetchAll();
    $def_servicios = $db->prepare('Select SER_ID from adm_def_tip_hab_ser where TIP_HAB_ID = :principal_room')
      ->bind(':principal_room', explode('-', $attributes['principal_room'])[0])
      ->execute()
      ->fetchAll();
  } else {
    $query = '
      Insert into adm_reserva(PERS_ID,
                              CLI_ID,
                              SAL_ID,
                              RES_FECH,
                              RES_FECH_INI,
                              RES_FECH_FIN
      )
      values(
              1,
              :client_id,
              :principal_room,
              now(),
              :initial_date,
              :final_date
      )';
    $rooms = $db->prepare('Select SAL_ID from adm_salon where TIP_SAL_ID = :principal_salon and EST_SAL_ID = 1')
      ->bind(':principal_salon', explode('-', $attributes['principal_room'])[0])
      ->execute()
      ->fetchAll();
    $def_servicios = $db->prepare('Select SER_ID from adm_def_tip_sal_ser where TIP_SAL_ID = :principal_room')
      ->bind(':principal_room', explode('-', $attributes['principal_room'])[0])
      ->execute()
      ->fetchAll();
  }


  $dateIni = new DateTime($attributes['initial_date']);
  $dateFin = new DateTime($attributes['final_date']);
  $diff = $dateIni->diff($dateFin);
  $days = $diff->days;

  for($i = 1; $i <= $attributes['principal_num_rooms']; $i++) {
    $result = $db->prepare($query)
      ->bind(':client_id', $attributes['client_id'])
      ->bind(':principal_room', $rooms[$i - 1]['HAB_ID'] ?? $rooms[$i - 1]['SAL_ID'])
      ->bind(':initial_date', $attributes['initial_date'])
      ->bind(':final_date', $attributes['final_date'])
      ->execute();

    $get_id = $db->prepare('Select max(RES_ID) as id from adm_reserva where CLI_ID = :client_id')
      ->bind(':client_id', $attributes['client_id'])
      ->execute()
      ->fetch();

    foreach ($def_servicios as $def_servicio) {
      $db->prepare('Insert into adm_ser_res(RES_ID, SER_ID, SER_RES_CANT) values(:res_id, :ser_id, :quantity)')
        ->bind(':res_id', $get_id['id'])
        ->bind(':ser_id', $def_servicio['SER_ID'])
        ->bind(':quantity', $days)
        ->execute();
    }
  }
  if(count(@$attributes['more_rooms_tip']? $attributes['more_rooms_tip']:[]) == 0)
  {
    echo json_encode([
      'success' => 'Reserva creada exitosamente'
    ]);
    die();
  }

  /*Ingreso de los tipos de habitaciones adicionales*/
  for ($i = 1; $i <= count($attributes['more_rooms_tip']); $i++){
    if (str_contains($attributes['more_rooms_tip']['room_' . $i], '-hab')){
      $query = '
        Insert into adm_reserva(
                                PERS_ID,
                                CLI_ID,
                                HAB_ID,
                                RES_FECH,
                                RES_FECH_INI,
                                RES_FECH_FIN
        )
        values(
                1,
                :client_id,
                :room,
                now(),
                :initial_date,
                :final_date
        )';
      $rooms = $db->prepare('Select HAB_ID from adm_habitacion where TIP_HAB_ID = :room and EST_HAB_ID = 1')
        ->bind(':room', explode('-', $attributes['more_rooms_tip']['room_' . $i])[0])
        ->execute()
        ->fetchAll();
      $def_servicios = $db->prepare('Select SER_ID from adm_def_tip_hab_ser where TIP_HAB_ID = :room')
        ->bind(':room', explode('-', $attributes['more_rooms_tip']['room_' . $i])[0])
        ->execute()
        ->fetchAll();
    } else {
      $query = '
        Insert into adm_reserva(PERS_ID,
                                CLI_ID,
                                SAL_ID,
                                RES_FECH,
                                RES_FECH_INI,
                                RES_FECH_FIN
        )
        values(
                1,
                :client_id,
                :room,
                now(),
                :initial_date,
                :final_date
        )';
      $rooms = $db->prepare('Select SAL_ID from adm_salon where TIP_SAL_ID = :room and EST_SAL_ID = 1')
        ->bind(':room', explode('-', $attributes['more_rooms_tip']['room_' . $i])[0])
        ->execute()
        ->fetchAll();
      $def_servicios = $db->prepare('Select SER_ID from adm_def_tip_sal_ser where TIP_SAL_ID = :room')
        ->bind(':room', explode('-', $attributes['more_rooms_tip']['room_' . $i])[0])
        ->execute()
        ->fetchAll();
    }

    for($j = 1; $j <= $attributes['more_rooms_num']['quantity_' . $i]; $j++) {
      $result = $db->prepare($query)
        ->bind(':client_id', $attributes['client_id'])
        ->bind(':room', $rooms[$j - 1]['HAB_ID'] ?? $rooms[$j - 1]['SAL_ID'])
        ->bind(':initial_date', $attributes['initial_date'])
        ->bind(':final_date', $attributes['final_date'])
        ->execute();

      $get_id = $db->prepare('Select max(RES_ID) as id from adm_reserva where CLI_ID = :client_id')
        ->bind(':client_id', $attributes['client_id'])
        ->execute()
        ->fetch();

      foreach ($def_servicios as $def_servicio) {
        $db->prepare('Insert into adm_ser_res(RES_ID, SER_ID, SER_RES_CANT) values(:res_id, :ser_id, :quantity)')
          ->bind(':res_id', $get_id['id'])
          ->bind(':ser_id', $def_servicio['SER_ID'])
          ->bind(':quantity', $days)
          ->execute();
      }
    }
  }

} catch (DatabaseException $e) {
  die($e->getMessage());
}

echo json_encode([
  'success' => 'Reserva creada exitosamente'
]);
<?php

use Core\Auth;
use Core\Database;
use Core\DatabaseException;

$_POST = json_decode(file_get_contents('php://input'), true);

if (empty($_POST['client_id'])) {
  echo json_encode([
    'error' => 'No se ha seleccionado un cliente'
  ]);
  die();
}

if (empty($_POST['initial_date']) || empty($_POST['final_date']) || $_POST['final_date'] <= $_POST['initial_date']) {
  echo json_encode([
    'error' => 'La fecha de salida debe ser posterior a la fecha de entrada'
  ]);
  die();
}

if (empty($_POST['principal_room']) || (int)($_POST['principal_num_rooms'] ?? 0) < 1) {
  echo json_encode([
    'error' => 'Seleccione una habitación/salón y una cantidad válida'
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
  /* Verificar si hay suficientes habitaciones disponibles en el rango de fechas */
  if (str_contains($attributes['principal_room'], '-hab')){
    $rooms = $db->prepare('
        SELECT h.HAB_ID FROM adm_habitacion h
        WHERE h.TIP_HAB_ID = :principal_room AND h.EST_HAB_ID = 1
          AND h.HAB_ID NOT IN (
              SELECT r.HAB_ID FROM adm_reserva r
              WHERE r.HAB_ID IS NOT NULL AND r.EST_RES_ID IN (1, 2)
                AND NOT (r.RES_FECH_FIN <= :ini OR r.RES_FECH_INI >= :fin)
          )
      ')
      ->bind(':principal_room', explode('-', $attributes['principal_room'])[0])
      ->bind(':ini', $attributes['initial_date'])
      ->bind(':fin', $attributes['final_date'])
      ->execute()
      ->fetchAll();

    if(count($rooms) < $attributes['principal_num_rooms'])
    {
      echo json_encode([
        'error' => 'No hay suficientes habitaciones disponibles en esas fechas para el tipo seleccionado',
      ]);
      die();
    }
  } else {
    $rooms = $db->prepare('
        SELECT s.SAL_ID FROM adm_salon s
        WHERE s.TIP_SAL_ID = :principal_salon AND s.EST_SAL_ID = 1
          AND s.SAL_ID NOT IN (
              SELECT r.SAL_ID FROM adm_reserva r
              WHERE r.SAL_ID IS NOT NULL AND r.EST_RES_ID IN (1, 2)
                AND NOT (r.RES_FECH_FIN <= :ini OR r.RES_FECH_INI >= :fin)
          )
      ')
      ->bind(':principal_salon', explode('-', $attributes['principal_room'])[0])
      ->bind(':ini', $attributes['initial_date'])
      ->bind(':fin', $attributes['final_date'])
      ->execute()
      ->fetchAll();

    if(count($rooms) < $attributes['principal_num_rooms'])
    {
      echo json_encode([
        'error' => 'No hay suficientes salones disponibles en esas fechas para el tipo seleccionado',
      ]);
      die();
    }
  }

  if(count(@$attributes['more_rooms_tip']? $attributes['more_rooms_tip']:[]) > 0){
    /* Verificación de los tipos de habitaciones adicionales */
    for ($i = 1; $i <= count($attributes['more_rooms_tip']); $i++){
      if (str_contains($attributes['more_rooms_tip']['room_' . $i], '-hab')){
        $roomsAdd = $db->prepare('
            SELECT h.HAB_ID FROM adm_habitacion h
            WHERE h.TIP_HAB_ID = :room AND h.EST_HAB_ID = 1
              AND h.HAB_ID NOT IN (
                  SELECT r.HAB_ID FROM adm_reserva r
                  WHERE r.HAB_ID IS NOT NULL AND r.EST_RES_ID IN (1, 2)
                    AND NOT (r.RES_FECH_FIN <= :ini OR r.RES_FECH_INI >= :fin)
              )
          ')
          ->bind(':room', explode('-', $attributes['more_rooms_tip']['room_' . $i])[0])
          ->bind(':ini', $attributes['initial_date'])
          ->bind(':fin', $attributes['final_date'])
          ->execute()
          ->fetchAll();

        if($attributes['more_rooms_num']['quantity_' . $i] > count($roomsAdd))
        {
          echo json_encode([
            'error' => 'No hay suficientes habitaciones disponibles en esas fechas para el tipo adicional ' . $i,
          ]);
          die();
        }
      } else {
        $roomsAdd = $db->prepare('
            SELECT s.SAL_ID FROM adm_salon s
            WHERE s.TIP_SAL_ID = :room AND s.EST_SAL_ID = 1
              AND s.SAL_ID NOT IN (
                  SELECT r.SAL_ID FROM adm_reserva r
                  WHERE r.SAL_ID IS NOT NULL AND r.EST_RES_ID IN (1, 2)
                    AND NOT (r.RES_FECH_FIN <= :ini OR r.RES_FECH_INI >= :fin)
              )
          ')
          ->bind(':room', explode('-', $attributes['more_rooms_tip']['room_' . $i])[0])
          ->bind(':ini', $attributes['initial_date'])
          ->bind(':fin', $attributes['final_date'])
          ->execute()
          ->fetchAll();

        if($attributes['more_rooms_num']['quantity_' . $i] > count($roomsAdd))
        {
          echo json_encode([
            'error' => 'No hay suficientes salones disponibles en esas fechas para el tipo adicional ' . $i,
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
    Auth::logAction("Reserva creada (Cliente ID: {$attributes['client_id']}, {$attributes['initial_date']} a {$attributes['final_date']})");
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

Auth::logAction("Reserva múltiple creada (Cliente ID: {$attributes['client_id']}, {$attributes['initial_date']} a {$attributes['final_date']})");
echo json_encode([
  'success' => 'Reserva creada exitosamente'
]);
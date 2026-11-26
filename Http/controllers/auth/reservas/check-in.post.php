<?php

  use Core\Database;
  use Core\DatabaseException;

  $_POST = json_decode(file_get_contents('php://input'), true);
  $attributes = [
    'reserva_id' => $_POST['reserva_id'],
    'seleccion' => $_POST['seleccion'],
  ];

  try{
   $db = Database::getInstance();
   $result = $db->prepare('SELECT * FROM adm_reserva WHERE RES_ID = :id')
     ->bind(':id', $attributes['reserva_id'])
     ->execute()
     ->fetch();

   if($result['HAB_ID'] == null){
     $query = 'UPDATE adm_reserva SET SAL_ID = :salon, EST_RES_ID = 2  WHERE RES_ID = :id';
   }else{
     $query = 'UPDATE adm_reserva SET HAB_ID = :habitacion, EST_RES_ID = 2 WHERE RES_ID = :id';
   }

   $db->prepare($query)
      ->bind(':id', $attributes['reserva_id'])
      ->bind($result['HAB_ID'] == null? ':salon' : ':habitacion', explode('_', $attributes['seleccion'])[1])
      ->execute();

   if($result['HAB_ID'] != null){
     $db->prepare('INSERT INTO adm_registro(TIP_REG_ID, HAB_ID, REG_FECH)
                        VALUES(1, :habitacion, now())')
        ->bind(':habitacion', explode('_', $attributes['seleccion'])[1])
        ->execute();


      $db->prepare('INSERT INTO adm_reg_cli(REG_ID, CLI_ID) VALUES ((SELECT REG_ID FROM adm_registro WHERE HAB_ID = :habitacion ORDER BY REG_ID DESC LIMIT 1), :client)')
        ->bind(':habitacion', explode('_', $attributes['seleccion'])[1])
        ->bind(':client', $result['CLI_ID'])
        ->execute();
   }

  }catch (DatabaseException $e){
    die($e->getMessage());
  }

  echo json_encode(['success' => 'Check-in realizado con éxito']);
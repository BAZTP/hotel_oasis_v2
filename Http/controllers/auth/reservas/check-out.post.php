<?php


use Core\Database;
use Core\DatabaseException;

$id = $_POST['reserva_id'];


try {
  $db = Database::getInstance();
  $result = $db->prepare(
    'SELECT * FROM 
             adm_reserva, mark_cliente
         WHERE 
             adm_reserva.CLI_ID = mark_cliente.CLI_ID
           AND 
             RES_ID = :id')
    ->bind(':id', $id)
    ->execute()
    ->fetch();
  if ($result['SAL_ID'] == null) {
    $habitacion = $db->prepare('SELECT * FROM adm_habitacion WHERE EST_HAB_ID in (1,5) AND TIP_HAB_ID = (SELECT TIP_HAB_ID FROM adm_habitacion WHERE HAB_ID = :id)')
      ->bind(':id', $result['HAB_ID'])
      ->execute()
      ->fetchAll();
    $habitacion = @$habitacion['HAB_ID'] ? [$habitacion] : $habitacion;
    $clientes = $db->prepare('Select * from mark_cliente, adm_reg_cli where adm_reg_cli.CLI_ID = mark_cliente.CLI_ID and REG_ID = (SELECT REG_ID FROM adm_registro WHERE HAB_ID = :habitacion ORDER BY REG_ID DESC LIMIT 1)')
      ->bind(':habitacion', $result['HAB_ID'])
      ->execute()
      ->fetchAll();
  } else {
    $salon = $db->prepare('SELECT * FROM adm_salon WHERE EST_SAL_ID in (1,5) AND TIP_SAL_ID = (SELECT TIP_SAL_ID FROM adm_salon WHERE SAL_ID = :id)')
      ->bind(':id', $result['SAL_ID'])
      ->execute()
      ->fetchAll();
    $salon = @$salon['SAL_ID'] ? [$salon] : $salon;
  }
} catch (DatabaseException $e) {
  die($e->getMessage());
}

view('auth/reservas/check-out.view.php', [
  'head_title' => 'Reserva ' . $id,
  'reserva' => $result,
  'select' => @$result['HAB_ID'] ? $habitacion : $salon,
  'clientes' => @$clientes?? []
]);
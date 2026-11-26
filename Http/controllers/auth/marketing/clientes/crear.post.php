<?php

use Core\Database;
use Core\DatabaseException;

$_POST = json_decode(file_get_contents('php://input'), true);

$attributes = [
  'cedula' => $_POST['cedula'],
  'nombre' => $_POST['nombre'],
  'telefono' => $_POST['telefono'],
  'email' => $_POST['email'],
  'direccion' => $_POST['direccion'],
];

try {
  $db = Database::getInstance();
  $db->prepare('INSERT INTO mark_cliente(CLI_CED, CLI_NOM, CLI__NUM, CLI_EMAIL, direccion, EST_CLI_ID) VALUES(:cedula, :nombre, :telefono, :email, :direccion, 1)')
    ->bind(':cedula', $attributes['cedula'])
    ->bind(':nombre', $attributes['nombre'])
    ->bind(':telefono', $attributes['telefono'])
    ->bind(':email', $attributes['email'])
    ->bind(':direccion', $attributes['direccion'])
    ->execute();
} catch (DatabaseException $e) {
  echo json_encode(['error' => $e->getMessage()]);
  die();
}

echo json_encode(['success' => 'Cliente registrado con éxito']);
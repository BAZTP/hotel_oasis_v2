<?php

use Core\Database;
use Core\DatabaseException;

$id = $_POST['pers_id'];

try {
    $db = Database::getInstance();
    
    // Obtener los datos del personal
    $personal = $db->prepare(
        'SELECT * FROM pers_personal 
         WHERE PERS_ID = :id'
    )->bind(':id', $id)
    ->execute()
    ->fetch();
    
    $tipo_cargo = $db
        ->query("SELECT * FROM pers_tipo_cargo;")
        ->fetchAll();
    $tipo_banco = $db
        ->query("SELECT * FROM pers_tipo_banco;")
        ->fetchAll();
    $tipo_cuenta = $db
        ->query("SELECT * FROM pers_tipo_cuenta;")
        ->fetchAll();
    $tipo_relacion = $db
        ->query("SELECT * FROM pers_relacion_emergencia;")
        ->fetchAll();
    $estado = $db
        ->query("SELECT * FROM pers_estado;")
        ->fetchAll();

} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('/auth/personal/update.view.php', [
    'head_title' => 'Actualizar Personal ' . $id,
    'personal' => $personal,
    'tipo_cargo'  => $tipo_cargo,
    'tipo_banco'  => $tipo_banco,
    'tipo_cuenta'  => $tipo_cuenta,
    'tipo_relacion' => $tipo_relacion,
    'estado' => $estado
    // 'tiposEgreso' => $tiposEgreso
]);

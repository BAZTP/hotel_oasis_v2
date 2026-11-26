<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();
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
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/personal/add_personal.php', [
    'head_title' => 'Añadir Personal',
    'tipo_cargo'  => $tipo_cargo,
    'tipo_banco'  => $tipo_banco,
    'tipo_cuenta'  => $tipo_cuenta,
    'tipo_relacion' => $tipo_relacion,
    'error' => $_SESSION['error'] ?? null,
]);

unset($_SESSION['error']);

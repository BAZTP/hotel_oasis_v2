<?php

use Core\Auth;
use Core\Database;
use Core\DatabaseException;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cli_id'])) {
    $id = (int)$_POST['cli_id'];
    $nombre = strtoupper(trim($_POST['cli_nom'] ?? ''));
    $telefono = trim($_POST['cli_num'] ?? '');
    $email = trim($_POST['cli_email'] ?? '');
    $direccion = strtoupper(trim($_POST['direccion'] ?? ''));
    $estado = (int)($_POST['est_cli_id'] ?? 1);

    try {
        $db = Database::getInstance();
        $db->prepare("
            UPDATE mark_cliente
            SET CLI_NOM = :nombre,
                CLI__NUM = :telefono,
                CLI_EMAIL = :email,
                direccion = :direccion,
                EST_CLI_ID = :estado
            WHERE CLI_ID = :id
        ")
        ->bind(':nombre', $nombre)
        ->bind(':telefono', $telefono)
        ->bind(':email', $email)
        ->bind(':direccion', $direccion)
        ->bind(':estado', $estado)
        ->bind(':id', $id)
        ->execute();

        Auth::logAction("Cliente actualizado (#$id: $nombre)");
    } catch (DatabaseException $e) {
        die($e->getMessage());
    }
}

redirect('/auth/marketing/clientes');

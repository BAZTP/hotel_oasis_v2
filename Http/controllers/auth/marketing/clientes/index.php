<?php

use Core\Database;
use Core\DatabaseException;

$search = trim($_GET['search'] ?? '');
$clientes = [];

try {
    $db = Database::getInstance();
    if ($search !== '') {
        $clientes = $db
            ->prepare(
                "
                SELECT CLI_ID, EST_CLI_ID, CLI_NOM, CLI_CED, CLI__NUM, CLI_EMAIL, direccion
                FROM mark_cliente
                WHERE CLI_NOM LIKE CONCAT('%', :search, '%')
                   OR CLI_CED LIKE CONCAT('%', :search, '%')
                   OR CLI_EMAIL LIKE CONCAT('%', :search, '%')
                ORDER BY CLI_ID DESC
                "
            )
            ->bind(':search', $search)
            ->execute()
            ->fetchAll();
    } else {
        $clientes = $db
            ->query(
                "
                SELECT CLI_ID, EST_CLI_ID, CLI_NOM, CLI_CED, CLI__NUM, CLI_EMAIL, direccion
                FROM mark_cliente
                ORDER BY CLI_ID DESC
                "
            )
            ->fetchAll();
    }
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/marketing/clientes/index.view.php', [
    'head_title' => 'Clientes - Marketing',
    'clientes' => $clientes,
]);

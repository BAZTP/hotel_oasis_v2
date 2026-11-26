<?php

use Core\Database;
use Core\DatabaseException;

$search = trim($_GET['search'] ?? '');
$registros = [];

try {
    $db = Database::getInstance();
    if ($search !== '') {
        $registros = $db
            ->prepare(
                "
                SELECT a.ACC_ID, a.USU_ID, a.ACC_DES, a.ACC_FEC, u.USU_NOM, u.USU_ROL
                FROM seg_registro_accion a
                LEFT JOIN seg_usuario u ON a.USU_ID = u.USU_ID
                WHERE a.ACC_DES LIKE CONCAT('%', :search, '%')
                   OR u.USU_NOM LIKE CONCAT('%', :search, '%')
                ORDER BY a.ACC_ID DESC
                LIMIT 200
                "
            )
            ->bind(':search', $search)
            ->execute()
            ->fetchAll();
    } else {
        $registros = $db
            ->query(
                "
                SELECT a.ACC_ID, a.USU_ID, a.ACC_DES, a.ACC_FEC, u.USU_NOM, u.USU_ROL
                FROM seg_registro_accion a
                LEFT JOIN seg_usuario u ON a.USU_ID = u.USU_ID
                ORDER BY a.ACC_ID DESC
                LIMIT 200
                "
            )
            ->fetchAll();
    }
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/auditoria.view.php', [
    'head_title' => 'Auditoría de Seguridad',
    'registros' => $registros,
]);

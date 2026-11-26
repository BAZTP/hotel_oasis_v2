<?php

use Core\Database;
use Core\DatabaseException;

$search = trim($_GET['search'] ?? '');
$result = [];

try {
    $db = Database::getInstance();
    if ($search !== '') {
        $result = $db
            ->prepare(
                "
                SELECT ai.*, ati.TIP_SERV_DET FROM mark_prom_serv ai
                JOIN mark_tip_serv ati ON ai.tip_serv_id = ati.tip_serv_id
                WHERE ai.prom_serv_est = 'activo'
                  AND (
                      ai.PROM_SERV_DET LIKE CONCAT('%', :search, '%')
                      OR ai.PROM_SERV_DESC LIKE CONCAT('%', :search, '%')
                      OR ati.TIP_SERV_DET LIKE CONCAT('%', :search, '%')
                  )
                ORDER BY ai.PROM_SERV_ID DESC
                "
            )
            ->bind(':search', $search)
            ->execute()
            ->fetchAll();
    } else {
        $result = $db
            ->query(
                "
                SELECT ai.*, ati.TIP_SERV_DET FROM mark_prom_serv ai
                JOIN mark_tip_serv ati ON ai.tip_serv_id = ati.tip_serv_id
                WHERE ai.prom_serv_est = 'activo'
                ORDER BY ai.PROM_SERV_ID DESC
                "
            )
            ->fetchAll();
    }
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/marketing/index.view.php', [
    'head_title' => 'Servicios - Marketing',
    'servicios' => $result
]);

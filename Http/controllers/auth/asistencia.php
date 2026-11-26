<?php

use Core\Database;
use Core\DatabaseException;

$asistencia = [];

try {
    $db = Database::getInstance();
    $asistencia = $db->query("
        SELECT pa.ASIST_ID, pa.PERS_ID, pa.ASIST_HORA_LLEGADA, pa.ASIST_HORA_ALMU_INI, pa.ASIST_HORA_ALMU_FIN, pa.ASIST_HORA_SALIDA, pa.ASIST_HORA_EXTRA, pp.PERS_CED, pp.PERS_NOM, pp.PERS_APE
        FROM pers_asistencia pa
        JOIN pers_personal pp ON pa.PERS_ID = pp.PERS_ID
        ORDER BY pa.ASIST_HORA_LLEGADA DESC
    ")->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/personal/asistencia.view.php', [
    'head_title' => 'Gestion de Asistencia',
    'asistencia' => $asistencia,
]);

<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['updateId'];
$tipo = $_POST['updateTipo'];
$estado = $_POST['updateEstado'];
$horaInicio = $_POST['updateHoraInicio'];
$horaFin = $_POST['updateHoraFin'];

try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_instalacion SET TIP_INS_ID = :tipo, EST_INS_ID = :estado, INS_HOR_INI = :horaInicio, INS_HOR_FIN = :horaFin WHERE INS_ID = :id')
        ->bind(':id', $id)
        ->bind(':tipo', $tipo)
        ->bind(':estado', $estado)
        ->bind(':horaInicio', $horaInicio)
        ->bind(':horaFin', $horaFin)
        ->execute();

    // Redirecciona después de la actualización
    redirect('/auth/instalacion');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}
redirect('/auth/instalacion');
?>

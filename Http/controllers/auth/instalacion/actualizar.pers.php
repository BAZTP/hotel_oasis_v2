<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['update_instalacion_id'];
$nombrePersonal = $_POST['nombre_personal'];
$instalacion = $_POST['instalacion'];

try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_ins_per SET PERS_ID = :nombre, INS_ID = :instalacion WHERE ADM_INS_PER_ID = :id')
        ->bind(':id', $id)
        ->bind(':nombre', $nombrePersonal)
        ->bind(':instalacion', $instalacion)
        ->execute();

    // Redirecciona después de la actualización
    redirect('/auth/instalacion/seleccionarpersonal');
    exit();
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/instalacion/seleccionarpersonal');
?>

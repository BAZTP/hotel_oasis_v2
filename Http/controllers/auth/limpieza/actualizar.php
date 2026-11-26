<?php
use Core\Database;
use Core\DatabaseException;

// Validar y sanitizar la entrada
$id = $_POST['limpieza_id'];
$estado = $_POST['estado'];
$personal = $_POST['personal'];
$fecha =$_POST[ 'fecha'];


try {
    $db = Database::getInstance();
   $db->prepare('UPDATE adm_lim_prog SET EST_LIM_PROG_ID = :estado, PERS_ID = :personal, LIM_PROG_FECH = :fecha WHERE LIM_PROG_ID = :id')
    ->bind(':id', $id)
    ->bind(':estado', $estado)
    ->bind(':personal', $personal)
    ->bind(':fecha', $fecha)
   ->execute();
    redirect('/auth/limpieza');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/limpieza');
?>

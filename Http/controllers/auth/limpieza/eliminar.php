<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['delete_limpieza_id'];

try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_lim_prog SET EST_LIM_PROG_ID = 2 WHERE lim_prog_id = :id')
        ->bind(':id', $id)
        ->execute();
    redirect('/auth/limpieza');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/limpieza');
?>




<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['delete_instalacion_id'];

try {
    $db = Database::getInstance();
    $db->prepare('DELETE FROM adm_ins_per WHERE  adm_ins_per_id= :id')
        ->bind(':id', $id)
        ->execute();
    redirect('/auth/instalacion/seleccionarpersonal');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/instalacion/seleccionarpersonal');
?>

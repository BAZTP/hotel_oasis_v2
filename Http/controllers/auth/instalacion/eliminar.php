<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['delete_instalacion_id'];

try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_instalacion SET EST_INS_ID = 3 WHERE ins_id = :id')
        ->bind(':id', $id)
        ->execute();
    redirect('/auth/instalacion');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/instalacion');
?>

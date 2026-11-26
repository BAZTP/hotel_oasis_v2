<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['delete_egreso_id'];

try {
    $db = Database::getInstance();
    $db->prepare('DELETE FROM egr_egreso WHERE egr_id = :id')
        ->bind(':id', $id)
        ->execute();
    redirect('/auth/egresos');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/egresos');
?>

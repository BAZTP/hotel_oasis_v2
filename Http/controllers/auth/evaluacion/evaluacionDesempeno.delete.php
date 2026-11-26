<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['delete_evluacion_id'];

try {
    $db = Database::getInstance();
    $db->prepare('DELETE FROM pers_evaluacion_desempeno WHERE  EVA_ID= :id')
        ->bind(':id', $id)
        ->execute();
    redirect('/auth/evaluacion');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/evaluacion');
?>
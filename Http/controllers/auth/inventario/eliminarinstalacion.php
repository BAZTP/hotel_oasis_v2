<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['delete_inventario_id'];

try {
    $db = Database::getInstance();
    $db->prepare('DELETE  from adm_inv_ins where INV_INS_ID = :id')
        ->bind(':id', $id)
        ->execute();
    redirect('/auth/inventario/instalacion');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/inventario/instalacion');
?>

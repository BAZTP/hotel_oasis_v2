<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['delete_inventario_id'];

try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_inv_gen SET EST_INV_GEN_ID = 3 WHERE INV_GEN_ID = :id')
        ->bind(':id', $id)
        ->execute();
    redirect('/auth/inventario');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/inventario');
?>

<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['delete_inventario_id'];

try {
    $db = Database::getInstance();
    $db->prepare('DELETE  from adm_inv_sal where INV_SAL_ID = :id')
        ->bind(':id', $id)
        ->execute();
    redirect('/auth/inventario/salon');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/inventario/salon');
?>

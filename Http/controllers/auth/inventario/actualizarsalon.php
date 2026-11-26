<?php
use Core\Database;
use Core\DatabaseException;
$id = $_POST['id'];
$habitacion = $_POST['habitacion'];
$producto = $_POST['producto'];
$stock = $_POST['stock'];
try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_inv_sal SET SAL_ID = :habitacion, INV_GEN_ID = :producto, INV_SAL_STOCK = :stock WHERE INV_SAL_ID = :id')
        ->bind(':id', $id)
        ->bind(':habitacion', $habitacion)
        ->bind(':producto', $producto)
        ->bind(':stock', $stock)
        ->execute();
    redirect('/auth/inventario/salon');
} catch (DatabaseException $e) {
    echo $e->getMessage();  
}
redirect('/auth/inventario/salon');
?>
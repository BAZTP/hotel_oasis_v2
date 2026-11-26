<?php
use Core\Database;
use Core\DatabaseException;
$id = $_POST['id'];
$habitacion = $_POST['habitacion'];
$producto = $_POST['producto'];
$stock = $_POST['stock'];
try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_inv_ins SET INS_ID = :habitacion, INV_GEN_ID = :producto, INV_INS_STOCK = :stock WHERE INV_INS_ID = :id')
        ->bind(':id', $id)
        ->bind(':habitacion', $habitacion)
        ->bind(':producto', $producto)
        ->bind(':stock', $stock)
        ->execute();
    redirect('/auth/inventario/instalacion');
} catch (DatabaseException $e) {
    echo $e->getMessage();  
}
redirect('/auth/inventario/instalacion');
?>
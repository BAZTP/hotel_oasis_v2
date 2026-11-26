<?php
use Core\Database;
use Core\DatabaseException;

// Input data
$id = $_POST['id'];
$habitacion = $_POST['habitacion'];
$producto = $_POST['producto'];
$stock = $_POST['stock'];


try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_inv_hab SET HAB_ID = :habitacion, INV_GEN_ID = :producto, INV_HAB_STOCK = :stock WHERE INV_HAB_ID = :id')
        ->bind(':id', $id)
        ->bind(':habitacion', $habitacion)
        ->bind(':producto', $producto)
        ->bind(':stock', $stock)
        ->execute();
    redirect('/auth/inventario/habitacion');
} catch (DatabaseException $e) {
    echo $e->getMessage();  
}
redirect('/auth/inventario/habitacion');
?>
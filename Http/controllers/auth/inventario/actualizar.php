<?php
use Core\Database;
use Core\DatabaseException;

$id = $_POST['id'];
$descripcion = $_POST['descripcion'];
$cantidad = $_POST['cantidad'];
$stock = $_POST['stock'];


try {
    $db = Database::getInstance();
    $db->prepare('UPDATE adm_inv_gen SET INV_GEN_DES = :descripcion, EST_INV_GEN_ID = :cantidad,INV_GEN_STOCK =:stock WHERE INV_GEN_ID = :id')
        ->bind(':id', $id)
        ->bind(':descripcion', $descripcion)
        ->bind(':cantidad', $cantidad)
        ->bind(':stock', $stock)
      
        ->execute();
    redirect('/auth/inventario');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/inventario');
?>

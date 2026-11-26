<?php
use Core\Database;
use Core\DatabaseException;

// Validar y sanitizar la entrada
$id = $_POST['update_prom_serv_id'];

$det_servicio = isset($_POST['update_prom_serv_det']) ? $_POST['update_prom_serv_det'] : '';
$desc_servicio = isset($_POST['update_prom_serv_desc']) ? $_POST['update_prom_serv_desc'] : '';
$fec_servicio = isset($_POST['update_prom_serv_fec']) ? $_POST['update_prom_serv_fec'] : '';
$costo_servicio = isset($_POST['update_prom_serv_costo']) ? $_POST['update_prom_serv_costo'] : '';

try {
    $db = Database::getInstance();
    $db->prepare('
        UPDATE mark_prom_serv 
        SET  
            PROM_SERV_DET = :det_servicio, 
            PROM_SERV_DESC = :desc_servicio, 
            PROM_SERV_FEC = :fec_servicio, 
            PROM_SERV_COSTO = :costo_servicio 
        WHERE PROM_SERV_ID = :id
    ')
    ->bind(':id', $id)
    ->bind(':det_servicio', $det_servicio)
    ->bind(':desc_servicio', $desc_servicio)
    ->bind(':fec_servicio', $fec_servicio)
    ->bind(':costo_servicio', $costo_servicio)
    ->execute();
    redirect('/auth/marketing');
} catch (DatabaseException $e) {
    echo $e->getMessage();
}

redirect('/auth/marketing');
?>

<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();
    $result = $db
        ->query(
            "
            SELECT * FROM mark_prom_serv ai
            JOIN mark_tip_serv ati ON ai.tip_serv_id = ati.tip_serv_id
            WHERE ai.prom_serv_est = 'activo'
            ;"
        )
        ->fetchAll();
} catch (DatabaseException $e) {
    die($e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicio_id = $_POST['servicio_id'] ?? null;
    $ser_id = $_POST['ser_id'] ?? null;
    $cli_id = $_POST['cli_id'] ?? null;
    $pers_id = $_POST['pers_id'] ?? null;
    $fecha_reserva = $_POST['
    $fecha_reserva'] ?? null;
    $fecha_ini = $_POST['fecha_ini'] ?? null;
    $fecha_fin = $_POST['fecha_fin'] ?? null;
    $cantidad = $_POST['cantidad'] ?? 0;

    if ($servicio_id && $ser_id && $cli_id && $pers_id && $fecha_reserva && $fecha_ini && $fecha_fin && $cantidad > 0) {
        try {
            $db = Database::getInstance();
            
            // Inserta la reserva en la tabla adm_reserva
            $query_reserva = "
                INSERT INTO adm_reserva (EST_RES_ID, PERS_ID, CLI_ID, RES_FECH, RES_FECH_INI, RES_FECH_FIN)
                VALUES (1, :pers_id, :cli_id, :fecha_reserva, :fecha_ini, :fecha_fin)
            ";
            $stmt_reserva = $db->prepare($query_reserva);
            $stmt_reserva->execute([
                ':pers_id' => $pers_id,
                ':cli_id' => $cli_id,
                ':fecha_reserva' => $fecha_reserva,
                ':fecha_ini' => $fecha_ini,
                ':fecha_fin' => $fecha_fin,
            ]);

            // Obtén el ID de la reserva recién creada
            $reserva_id = $db->lastInsertId();

            // Inserta la relación de reserva de servicio en la tabla adm_ser_res
            $query_ser_res = "
                INSERT INTO adm_ser_res (RES_ID, SER_ID, SER_RES_CANT)
                VALUES (:res_id, :ser_id, :cantidad)
            ";
            $stmt_ser_res = $db->prepare($query_ser_res);
            $stmt_ser_res->execute([
                ':res_id' => $reserva_id,
                ':ser_id' => $ser_id,
                ':cantidad' => $cantidad,
            ]);

            header('Location: /servicios');
        } catch (DatabaseException $e) {
            die($e->getMessage());
        }
    } else {
        header('Location: /servicios');
    }
} else {
    try {
        $db = Database::getInstance();
        $result = $db
            ->query("
                SELECT * FROM mark_prom_serv ai
                JOIN mark_tip_serv ati ON ai.TIP_SERV_ID = ati.TIP_SERV_ID
                WHERE ai.PROM_SERV_EST = 'activo'
            ")
            ->fetchAll();
    } catch (DatabaseException $e) {
        die($e->getMessage());
    }

    $servicios = $result;
}

view('servicios.view.php', [
    'head_title' => 'Servicios',
    'servicios' => $result
]);

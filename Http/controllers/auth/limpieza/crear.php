<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Actualiza los estados de limpieza a 2 (inactivo) si la fecha de limpieza ya ha pasado
    $db->query(
        "
        UPDATE adm_lim_prog
        SET EST_LIM_PROG_ID = 
            CASE 
                WHEN LIM_PROG_FECH < CURDATE() THEN 2
                WHEN LIM_PROG_FECH = CURDATE() THEN 3
                ELSE EST_LIM_PROG_ID
            END
        "
    );

    // Obtener el tipo de personal
    $tipo_personales = $db
        ->query(
            "
            SELECT 
                th.PERS_ID,
                th.PERS_NOM,
                COUNT(h.PERS_ID) AS personal_count
            FROM
                pers_personal th
            LEFT JOIN
                adm_lim_prog h
            ON
                h.PERS_ID = th.PERS_ID
            WHERE
                th.tip_car_id = 4
            GROUP BY
                th.PERS_ID, th.PERS_NOM;
            "
        )
        ->fetchAll();

    // Obtener el tipo de habitaciones, excluyendo las que ya están programadas para limpieza hoy o en el futuro, excepto si están en estado 2
    $tipo_habitaciones = $db
    ->query(
        "
        SELECT 
            th.HAB_ID,
            th.TIP_HAB_ID,
            COUNT(h.HAB_ID) AS habitacion_count
        FROM
            adm_habitacion th
        LEFT JOIN
            adm_lim_prog h
        ON
            h.HAB_ID = th.HAB_ID
        WHERE
            th.EST_HAB_ID = 1
            AND th.HAB_ID NOT IN (
                SELECT 
                    h2.HAB_ID
                FROM 
                    adm_lim_prog h2
                WHERE
                    h2.LIM_PROG_FECH >= CURDATE() AND h2.EST_LIM_PROG_ID != 2
            )
        GROUP BY
            th.HAB_ID, th.TIP_HAB_ID;
        "
    )
    ->fetchAll();
    
    // Obtener los estados de limpieza actualizados
    $estado_limpiezas = $db
        ->query("SELECT * FROM adm_est_lim_prog;")
        ->fetchAll();

} catch (DatabaseException $e) {
    die($e->getMessage());
}

view('auth/limpieza/crear.view.php', [
    'head_title' => 'Crear limpieza',
    'tipo_personales' => $tipo_personales,
    'tipo_habitaciones' => $tipo_habitaciones,
    'estado_limpiezas' => $estado_limpiezas
]);

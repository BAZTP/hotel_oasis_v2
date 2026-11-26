<?php

use Core\Database;
use Core\DatabaseException;

try {
    // Obtener la instancia de la base de datos
    $db = Database::getInstance();

    // Actualizar estados de las instalaciones
    $db->query("
        UPDATE adm_instalacion
        SET EST_INS_ID = 
            CASE 
                WHEN EST_INS_ID = 1 AND INS_HOR_FIN < NOW() THEN 3  -- Cambiar a estado 3 si está activa y la hora de fin ha pasado
                WHEN EST_INS_ID = 1 AND NOW() BETWEEN INS_HOR_INI AND INS_HOR_FIN THEN 2  -- Cambiar a estado 2 si está activa y está en uso
                WHEN EST_INS_ID = 2 AND INS_HOR_FIN < NOW() THEN 3  -- Cambiar a estado 3 si está en uso y la hora de fin ha pasado   
                  WHEN EST_INS_ID = 3 AND NOW() BETWEEN INS_HOR_INI AND INS_HOR_FIN THEN 2  -- Cambiar a estado 2 si está en estado 3 y la hora actual está entre la hora de inicio y la hora de fin            
                ELSE EST_INS_ID  -- Mantener el estado actual en otros casos
            END
    ");

    // Seleccionar tipo_instalaciones excluyendo las activas y en uso
    $tipo_instalaciones = $db
        ->query("
            SELECT 
                th.TIP_INS_ID, 
                th.TIP_INS_DES
            FROM 
                adm_tip_ins th
             
            GROUP BY 
                th.TIP_INS_ID, th.TIP_INS_DES;
        ")
        ->fetchAll();

    // Seleccionar estados disponibles
    $seleccionar_estados = $db
        ->query("SELECT * FROM adm_est_ins;")
        ->fetchAll();

} catch (DatabaseException $e) {
    // Manejar la excepción de la base de datos
    die($e->getMessage());
}

// Renderizar la vista
view('auth/instalacion/crear.view.php', [
    'head_title' => 'Crear Instalacion',
    'tipo_instalaciones' => $tipo_instalaciones,
    'seleccionar_estados' => $seleccionar_estados
]);

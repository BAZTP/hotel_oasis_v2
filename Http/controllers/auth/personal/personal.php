<?php
use Core\Database;

try {
    $db = Database::getInstance();
    $result = $db
        ->query(
            "
            SELECT 
                pp.*, ptc.*, pe.*
            FROM 
                pers_personal pp
            JOIN 
                pers_tipo_cargo ptc ON pp.TIP_CAR_ID = ptc.TIP_CAR_ID
            JOIN 
                pers_estado pe ON pp.PERS_EST_ID = pe.PERS_EST_ID
            "
        )
        ->fetchAll();
    $estado = $db
        ->query(
            "
            SELECT 
                *
            FROM 
                pers_estado;
            "
        )
        ->fetchAll();
} catch (\Core\DatabaseException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

view('auth/personal/personal.view.php', [
    'head_title' => 'Gestion de Personal',
    'personal' => $result,
    'estado' => $estado,
    'success' => $_SESSION['success']?? null,
]);

unset($_SESSION['success']);
?>
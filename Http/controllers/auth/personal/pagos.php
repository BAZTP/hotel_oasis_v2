<?php
use Core\Database;

try {
    $db = Database::getInstance();
    $result = $db
        ->query(
            "
            SELECT 
                p.PERS_ID, p.PERS_CED, p.PERS_NOM, p.PERS_APE, p.PERS_EMAIL, p.PERS_TELF, 
                p.PERS_NUM_CUENT_BK, t.TIP_BANCO_DES, p.TIP_CAR_ID, c.TIP_CAR_SUELD, p.PERS_FECH
            FROM 
                pers_personal p
            JOIN 
                pers_tipo_banco t ON p.TIP_BANCO_ID = t.TIP_BANCO_ID
            JOIN
                pers_tipo_cargo c ON p.TIP_CAR_ID = c.TIP_CAR_ID;"
        )
        ->fetchAll();
} catch (\Core\DatabaseException $e) {
    die($e->getMessage());
}

view('auth/personal/Pagos.view.php', [
    'head_title' => 'Personal',
    'personal' => $result
]);
?>

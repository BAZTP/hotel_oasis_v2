<?php
use Core\Database;
use Core\DatabaseException;

$attributes = [
    'PERS_ID' => $_POST['PERS_ID'],
    'PERS_NOM' => $_POST['PERS_NOM'],
    'PERS_APE' => $_POST['PERS_APE'],
    'PERS_CED' => $_POST['PERS_CED'],
    'SUELDO' => $_POST['SUELDO'],
    'FECHA_PAGO' => date('Y-m-d'),
    'APOR_PATRONAL_CANTIDAD' => $_POST['APOR_PATRONAL_CANTIDAD'],
    'APOR_PERSONAL_CANTIDAD' => $_POST['APOR_PERSONAL_CANTIDAD'],
];

try {
    $db = Database::getInstance();

    $result_verificar_pers = $db
        ->prepare("SELECT COUNT(*) as count FROM pers_personal WHERE PERS_ID = :PERS_ID")
        ->bind(':PERS_ID', $attributes['PERS_ID'])
        ->execute()
        ->fetch();

    if ($result_verificar_pers['count'] == 0) {
        die("Error: El PERS_ID no existe en la tabla pers_personal.");
    }

    $result_verificar_pago = $db
        ->prepare("
            SELECT COUNT(*) as count 
            FROM pers_unido 
            WHERE PERS_ID = :PERS_ID 
            AND MONTH(FECHA_PAGO) = MONTH(CURDATE()) 
            AND YEAR(FECHA_PAGO) = YEAR(CURDATE());
        ")
        ->bind(':PERS_ID', $attributes['PERS_ID'])
        ->execute()
        ->fetch();

    if ($result_verificar_pago['count'] > 0) {
        die("Error: Ya se ha registrado un pago para este empleado en el mes actual.");
    }

    $result = $db
        ->prepare("
            INSERT INTO pers_unido (
                PERS_ID, 
                PERS_NOM, 
                PERS_APE, 
                PERS_CED, 
                SUELDO, 
                FECHA_PAGO,
                APOR_PATRONAL_CANTIDAD,
                APOR_PERSONAL_CANTIDAD
            )
            VALUES (
                :PERS_ID, 
                :PERS_NOM, 
                :PERS_APE, 
                :PERS_CED, 
                :SUELDO, 
                :FECHA_PAGO,
                :APOR_PATRONAL_CANTIDAD,
                :APOR_PERSONAL_CANTIDAD
            );
        ")
        ->bind(':PERS_ID', $attributes['PERS_ID'])
        ->bind(':PERS_NOM', $attributes['PERS_NOM'])
        ->bind(':PERS_APE', $attributes['PERS_APE'])
        ->bind(':PERS_CED', $attributes['PERS_CED'])
        ->bind(':SUELDO', $attributes['SUELDO'])
        ->bind(':FECHA_PAGO', $attributes['FECHA_PAGO'])
        ->bind(':APOR_PATRONAL_CANTIDAD', $attributes['APOR_PATRONAL_CANTIDAD'])
        ->bind(':APOR_PERSONAL_CANTIDAD', $attributes['APOR_PERSONAL_CANTIDAD'])
        ->execute();

    $db->commit();

    echo 'Pago realizado correctamente.';
} catch (DatabaseException $e) {
    $db->rollBack();
    die($e->getMessage());
}

redirect('/auth/Pagos');
?>

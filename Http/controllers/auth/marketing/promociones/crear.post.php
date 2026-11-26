<?php
use Core\Database;
use Core\DatabaseException;

// Verificar qué datos se están recibiendo del formulario
error_log(print_r($_POST, true));

$attributes = [
    'PROMO_TIT' => $_POST['PROMO_TIT'],
    'PROMO_DET' => $_POST['PROMO_DET'],
    'PROMO_DESCU' => $_POST['PROMO_DESCU'],
    'TIP_EVEN_ID' => isset($_POST['tipo']) && $_POST['tipo'] === 'evento' ? $_POST['TIP_EVEN_ID'] : null,
    'TIP_SERV_ID' => isset($_POST['tipo']) && $_POST['tipo'] === 'servicio' ? $_POST['TIP_SERV_ID'] : null
];

try {
    $db = Database::getInstance();

    $result = $db
        ->prepare("
            INSERT INTO mark_promociones (PROMO_TIT, PROMO_DET, PROMO_DESCU, TIP_EVEN_ID, TIP_SERV_ID)
            VALUES (:PROMO_TIT, :PROMO_DET, :PROMO_DESCU, :TIP_EVEN_ID, :TIP_SERV_ID)
        ")
        ->bind(':PROMO_TIT', $attributes['PROMO_TIT'])
        ->bind(':PROMO_DET', $attributes['PROMO_DET'])
        ->bind(':PROMO_DESCU', $attributes['PROMO_DESCU'])
        ->bind(':TIP_EVEN_ID', $attributes['TIP_EVEN_ID'])
        ->bind(':TIP_SERV_ID', $attributes['TIP_SERV_ID'])
        ->execute();
    
    // Redirigir después de insertar correctamente
    redirect('/auth/marketing/promociones');

} catch (DatabaseException $e) {
    echo $e->getMessage(); // Mostrar mensaje de error en caso de excepción
}
?>

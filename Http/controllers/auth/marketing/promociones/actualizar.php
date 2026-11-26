<?php
use Core\Database;
use Core\DatabaseException;

// Validar y sanitizar la entrada
$id = isset($_POST['PROMO_ID']) ? (int)$_POST['PROMO_ID'] : 0;
$titulo = isset($_POST['update_titulo']) ? strtoupper($_POST['update_titulo']) : '';
$detalle = isset($_POST['update_detalle']) ? strtoupper($_POST['update_detalle']) : '';
$descuento = isset($_POST['update_descuento']) ? (float)$_POST['update_descuento'] : 0.0;

try {
    $db = Database::getInstance();

    $query = '
        UPDATE mark_promociones 
        SET  
            PROMO_TIT = :titulo, 
            PROMO_DET = :detalle, 
            PROMO_DESCU = :descuento
        WHERE PROMO_ID = :id
    ';

    $stmt = $db->prepare($query);
    $stmt->bind(':id', $id);
    $stmt->bind(':titulo', $titulo);
    $stmt->bind(':detalle', $detalle);
    $stmt->bind(':descuento', $descuento);

    $stmt->execute();

    // Redirigir a la página de marketing con un mensaje de éxito
    session_start();
    $_SESSION['update_success'] = true;
    header('Location: /auth/marketing/promociones');
    exit();
} catch (DatabaseException $e) {
    echo $e->getMessage();
    // También puedes redirigir a una página de error si prefieres
}

// Redirige a la página de marketing si ocurre un error
header('Location: /auth/marketing/promociones');
exit();
?>

<?php

use Core\Database;
use Core\DatabaseException;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_promo_id'])) {
    $id = intval($_POST['delete_promo_id']); // Asegurarse de que el ID sea un número entero

    try {
        $db = Database::getInstance();
        
        $sql = 'DELETE FROM mark_promociones WHERE PROMO_ID = :id';
        $stmt = $db->prepare($sql);
        $stmt->bind(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'success']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['status' => 'error', 'message' => 'No se encontró la promoción.']);
        }
        exit();
    } catch (DatabaseException $e) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
        exit();
    } catch (Exception $e) {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => 'Error desconocido: ' . $e->getMessage()]);
        exit();
    }
}

redirect('/auth/marketing/promociones');
exit();
?>

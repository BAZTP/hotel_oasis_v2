<?php

use Core\Database;
use Core\DatabaseException;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_prom_serv_id'])) {
    $id = $_POST['delete_prom_serv_id'];

    try {
        // Obtener la instancia de la base de datos
        $db = Database::getInstance();
        
        // Preparar la consulta SQL para actualizar el estado a 'inactivo'
        $sql = 'UPDATE mark_prom_serv SET prom_serv_est = "inactivo" WHERE PROM_SERV_ID = :id';
        $stmt = $db->prepare($sql);
        $stmt->bind(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success']);
        redirect('/auth/marketing');
    } catch (PDOException $e) {
        // Devolver una respuesta JSON con el estado de error
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    exit();
}

redirect('/auth/marketing');
?>

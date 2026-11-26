<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['egreso_id'])) {
        $id = $_POST['egreso_id'];

        // Consulta SQL para marcar el egreso como inactivo
        $query = "UPDATE egr_egreso SET EGR_ESTADO = 'inactivo' WHERE EGR_ID = :id";
        $stmt = $db->prepare($query);
        $stmt->bind(':id', $id);
        $stmt->execute();

        // Redirigir después de la actualización
        header('Location: /auth/egresos');
        exit();
    } else {
        // Manejar el caso en que el ID no está presente en la solicitud
        throw new Exception('ID de egreso no proporcionado.');
    }
} catch (DatabaseException $e) {
    die($e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}

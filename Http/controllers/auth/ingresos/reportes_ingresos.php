<?php

use Core\Database;
use Core\DatabaseException;

try {
    $db = Database::getInstance();

    // Si se ha enviado un término de búsqueda
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
        $searchTerm = '%' . $_GET['search'] . '%';

        // Consulta SQL para filtrar los ingresos por descripción del tipo de ingreso
        $query = "
            SELECT
                t.TIP_ING_DESC AS TIPO_INGRESO,
                i.ING_MONT AS MONTO,
                i.ING_FECH AS FECHA_INGRESO,
                i.ing_concepto_ing AS CONCEPTO_INGRESO
            FROM 
                ing_ingresos i
                JOIN ing_tipo_ingreso t ON i.TIP_ING_ID = t.TIP_ING_ID
            WHERE
                t.TIP_ING_DESC LIKE :searchTerm OR
                i.ing_concepto_ing LIKE :searchTerm
            ORDER BY i.ING_ID DESC
        ";

        // Ejecutar la consulta con el parámetro vinculado
        $stmt = $db->prepare($query);
        $stmt->bind(':searchTerm', $searchTerm);
        $stmt->execute();
        $result = $stmt->fetchAll();
    } else {
        // Consulta original sin filtro de búsqueda
        $result = $db->query("
            SELECT
                t.TIP_ING_DESC AS TIPO_INGRESO,
                i.ING_MONT AS MONTO,
                i.ING_FECH AS FECHA_INGRESO,
                i.ing_concepto_ing AS CONCEPTO_INGRESO
            FROM 
                ing_ingresos i
                JOIN ing_tipo_ingreso t ON i.TIP_ING_ID = t.TIP_ING_ID
            ORDER BY i.ING_ID DESC
        ")->fetchAll();
    }
} catch (DatabaseException $e) {
    die($e->getMessage());
}

// Pasar datos a la vista
view('auth/ingresos/ingresos_realizados.view.php', [
    'head_title' => 'Ingresos Realizados',
    'ingresos' => $result
]);

?>

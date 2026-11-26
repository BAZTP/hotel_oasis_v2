<?php

use Core\Database;
use Core\DatabaseException;

$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? 'all';
$date = $_GET['date'] ?? '';

// Construir la cláusula WHERE en función de los filtros seleccionados
$whereClause = "1 = 1";
$params = [];

if (!empty($search)) {
    $whereClause .= " AND (ing_reg_ingresos.ing_reg_metodo_pago LIKE CONCAT('%', :search, '%') OR CONCAT(ing_reg_ingresos.ing_reg_nom, ' - ', ing_reg_ingresos.ing_reg_direccion) LIKE CONCAT('%', :search, '%') OR ing_reg_ingresos.ing_reg_ced LIKE CONCAT('%', :search, '%'))";
    $params[':search'] = $search;
}

if ($filter == 'day' && !empty($date)) {
    $whereClause .= " AND DATE(ing_reg_ingresos.ing_reg_created_at) = :date";
    $params[':date'] = $date;
} elseif ($filter == 'month' && !empty($date)) {
    $whereClause .= " AND MONTH(ing_reg_ingresos.ing_reg_created_at) = MONTH(:date) AND YEAR(ing_reg_ingresos.ing_reg_created_at) = YEAR(:date)";
    $params[':date'] = $date;
} elseif ($filter == 'year' && !empty($date)) {
    $whereClause .= " AND YEAR(ing_reg_ingresos.ing_reg_created_at) = YEAR(:date)";
    $params[':date'] = $date;
}

try {
    $db = Database::getInstance();

    // Consulta para obtener los ingresos
    $query = "
        SELECT 
            ing_reg_ingresos.ing_reg_id AS ID,
            ing_reg_ingresos.ing_reg_metodo_pago AS TIPO_INGRESO,
            ing_reg_ingresos.ing_reg_monto_total AS MONTO,
            ing_reg_ingresos.ing_reg_created_at AS FECHA_INGRESO,
            CONCAT(ing_reg_ingresos.ing_reg_nom, ' - ', ing_reg_ingresos.ing_reg_direccion) AS DESCRIPCION,
            ing_reg_ingresos.ing_reg_ced AS CEDULA
        FROM 
            ing_reg_ingresos
        WHERE 
            $whereClause
        ORDER BY 
            ing_reg_ingresos.ing_reg_created_at DESC
    ";

    $stmt = $db->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bind($key, $value);
    }
    $ingresos = $stmt->execute()->fetchAll();

} catch (DatabaseException $e) {
    die($e->getMessage());
}

// Pasar datos a la vista
view('auth/ingresos/ingresos_realizados.view.php', [
    'head_title' => 'Ver Ingresos',
    'ingresos' => $ingresos,
    'search' => $search,
    'filter' => $filter,
    'date' => $date,
]);

?>

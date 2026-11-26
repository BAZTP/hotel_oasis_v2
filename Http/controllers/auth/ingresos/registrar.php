<?php
use Core\Database;
use Core\DatabaseException;

$tipos_ingresos = [];
$clientes = [];
$tipos_servicios = [];

try {
    $db = Database::getInstance();
    
    // Obtener clientes
    $search = $_GET['search'] ?? '';
    $clientes = $db
        ->prepare(
            "
            SELECT
                CLI_ID,
                CLI_NOM,
                CLI_CED,
                CLI__NUM,
                CLI_EMAIL,
                direccion
            FROM
                mark_cliente
            WHERE
                CLI_NOM LIKE CONCAT('%', :search, '%')
            OR 
                CLI_CED LIKE CONCAT('%', :search, '%')
            LIMIT 100
            "
        )
        ->bind(':search', $search)
        ->execute()
        ->fetchAll();

    // Obtener reservas asociadas a los clientes encontrados
    foreach ($clientes as &$cliente) {
        $reservas = $db
            ->prepare(
                "
                SELECT
                    RES_ID,
                    HAB_ID,
                    RES_FECH,
                    RES_FECH_INI,
                    RES_FECH_FIN
                FROM
                    adm_reserva
                WHERE
                    CLI_ID = :cli_id
                "
            )
            ->bind(':cli_id', $cliente['CLI_ID'])
            ->execute()
            ->fetchAll();

        $cliente['reservas'] = $reservas;
    }
    
    // Obtener tipos de servicios
    $tipos_servicios = $db
        ->query("SELECT * FROM mark_tip_serv;")
        ->fetchAll();

} catch (DatabaseException $e) {
    die($e->getMessage());
}

// Pasar datos a la vista
view('auth/ingresos/registrar.view.php', [
    'head_title' => 'Crear Ingresos',
    'clientes' => $clientes,
    'tipos_servicios' => $tipos_servicios,
]);

?>

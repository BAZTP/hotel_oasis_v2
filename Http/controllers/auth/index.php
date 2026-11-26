<?php

use Core\Database;
use Core\DatabaseException;

$stats = [
    'reservas' => 0,
    'habitaciones' => 0,
    'salones' => 0,
    'personal' => 0,
    'clientes' => 0,
    'servicios_mkt' => 0,
    'ingresos_count' => 0,
    'ingresos_total' => 0.00,
    'egresos_count' => 0,
    'egresos_total' => 0.00,
    'balance' => 0.00,
];

$estados_habitaciones = [];
$ultimas_reservas = [];
$ultimos_ingresos = [];
$ultimos_egresos = [];
$ultimos_clientes = [];
$ultimas_asistencias = [];

try {
    $db = Database::getInstance();

    $stats['reservas'] = (int)($db->query("SELECT COUNT(*) as total FROM adm_reserva")->fetch()['total'] ?? 0);
    $stats['habitaciones'] = (int)($db->query("SELECT COUNT(*) as total FROM adm_habitacion")->fetch()['total'] ?? 0);
    $stats['salones'] = (int)($db->query("SELECT COUNT(*) as total FROM adm_salon")->fetch()['total'] ?? 0);
    $stats['personal'] = (int)($db->query("SELECT COUNT(*) as total FROM pers_personal")->fetch()['total'] ?? 0);
    $stats['clientes'] = (int)($db->query("SELECT COUNT(*) as total FROM mark_cliente")->fetch()['total'] ?? 0);
    $stats['servicios_mkt'] = (int)($db->query("SELECT COUNT(*) as total FROM mark_prom_serv WHERE prom_serv_est = 'activo'")->fetch()['total'] ?? 0);

    $ing = $db->query("SELECT COUNT(*) as cnt, COALESCE(SUM(ing_reg_monto_pagar), 0) as total FROM ing_reg_ingresos")->fetch();
    $stats['ingresos_count'] = (int)($ing['cnt'] ?? 0);
    $stats['ingresos_total'] = (float)($ing['total'] ?? 0);

    $egr = $db->query("SELECT COUNT(*) as cnt, COALESCE(SUM(EGR_MON), 0) as total FROM egr_egreso WHERE EGR_ESTADO = 'activo'")->fetch();
    $stats['egresos_count'] = (int)($egr['cnt'] ?? 0);
    $stats['egresos_total'] = (float)($egr['total'] ?? 0);

    $stats['balance'] = $stats['ingresos_total'] - $stats['egresos_total'];

    $estados_habitaciones = $db->query("
        SELECT eh.EST_HAB_DES, COUNT(h.HAB_ID) as cantidad
        FROM adm_est_hab eh
        LEFT JOIN adm_habitacion h ON eh.EST_HAB_ID = h.EST_HAB_ID
        GROUP BY eh.EST_HAB_ID, eh.EST_HAB_DES
        ORDER BY eh.EST_HAB_ID ASC
    ")->fetchAll();

    $ultimas_reservas = $db->query("
        SELECT r.RES_ID, r.HAB_ID, r.SAL_ID, r.RES_FECH, r.RES_FECH_INI, r.RES_FECH_FIN, c.CLI_NOM, er.EST_RES_DES
        FROM adm_reserva r
        LEFT JOIN mark_cliente c ON r.CLI_ID = c.CLI_ID
        LEFT JOIN adm_est_res er ON r.EST_RES_ID = er.EST_RES_ID
        ORDER BY r.RES_ID DESC
        LIMIT 5
    ")->fetchAll();

    $ultimos_ingresos = $db->query("
        SELECT ing_reg_id, ing_reg_nom, ing_reg_metodo_pago, ing_reg_monto_pagar, ing_reg_created_at
        FROM ing_reg_ingresos
        ORDER BY ing_reg_id DESC
        LIMIT 5
    ")->fetchAll();

    $ultimos_egresos = $db->query("
        SELECT EGR_ID, EGR_DES, EGR_FEC, EGR_MON, EGR_MOD
        FROM egr_egreso
        WHERE EGR_ESTADO = 'activo'
        ORDER BY EGR_ID DESC
        LIMIT 5
    ")->fetchAll();

    $ultimos_clientes = $db->query("
        SELECT CLI_ID, CLI_NOM, CLI_CED, CLI_EMAIL, EST_CLI_ID
        FROM mark_cliente
        ORDER BY CLI_ID DESC
        LIMIT 5
    ")->fetchAll();

    $ultimas_asistencias = $db->query("
        SELECT pa.ASIST_HORA_LLEGADA, pa.ASIST_HORA_SALIDA, pp.PERS_NOM, pp.PERS_APE
        FROM pers_asistencia pa
        JOIN pers_personal pp ON pa.PERS_ID = pp.PERS_ID
        ORDER BY pa.ASIST_ID DESC
        LIMIT 5
    ")->fetchAll();
} catch (DatabaseException $e) {
    // Mantener valores por defecto si ocurre algún error de consulta
}

view('auth/index.view.php', [
    'head_title' => 'Panel Principal - Hotel Oasis',
    'stats' => $stats,
    'estados_habitaciones' => $estados_habitaciones,
    'ultimas_reservas' => $ultimas_reservas,
    'ultimos_ingresos' => $ultimos_ingresos,
    'ultimos_egresos' => $ultimos_egresos,
    'ultimos_clientes' => $ultimos_clientes,
    'ultimas_asistencias' => $ultimas_asistencias,
]);

<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<?php
$usuario = $_SESSION['user']['USU_NOM'] ?? 'Administrador';
$rol = $_SESSION['user']['USU_ROL'] ?? 'auth';
?>

<main class="relative w-full px-8 pt-20 pb-24 min-h-dvh bg-background-950">
    <div class="max-w-7xl mx-auto">
        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-background-800 pb-6">
            <div>
                <h1 class="text-3xl sm:text-4xl font-semibold text-text-50">Panel Principal</h1>
                <p class="mt-1 text-sm text-text-200">
                    Bienvenido, <span class="font-semibold text-accent-400"><?= htmlspecialchars($usuario) ?></span>
                    <span class="ml-2 inline-flex items-center rounded-full bg-secondary-800/40 px-2.5 py-0.5 text-xs font-medium text-text-100 uppercase"><?= htmlspecialchars($rol) ?></span>
                </p>
            </div>
            <div class="text-sm text-text-300">
                <?= date('d/m/Y H:i') ?>
            </div>
        </div>

        <!-- Tarjetas de resumen (KPIs) -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="/auth/reservas" class="rounded-xl bg-background-900 border border-background-800 hover:border-accent-600 p-5 transition-colors">
                <p class="text-sm text-text-200">Reservas Totales</p>
                <p class="mt-2 text-3xl font-bold text-text-50"><?= $stats['reservas'] ?></p>
                <p class="mt-1 text-xs text-accent-400">Gestionar reservas &rarr;</p>
            </a>

            <a href="/auth/tipohabsal" class="rounded-xl bg-background-900 border border-background-800 hover:border-accent-600 p-5 transition-colors">
                <p class="text-sm text-text-200">Habitaciones / Salones</p>
                <p class="mt-2 text-3xl font-bold text-text-50"><?= $stats['habitaciones'] ?> <span class="text-lg font-normal text-text-300">/ <?= $stats['salones'] ?></span></p>
                <p class="mt-1 text-xs text-accent-400">Ver tipos y estados &rarr;</p>
            </a>

            <a href="/auth/personal" class="rounded-xl bg-background-900 border border-background-800 hover:border-accent-600 p-5 transition-colors">
                <p class="text-sm text-text-200">Personal</p>
                <p class="mt-2 text-3xl font-bold text-text-50"><?= $stats['personal'] ?></p>
                <p class="mt-1 text-xs text-accent-400">Ver empleados &rarr;</p>
            </a>

            <a href="/auth/marketing/clientes" class="rounded-xl bg-background-900 border border-background-800 hover:border-accent-600 p-5 transition-colors">
                <p class="text-sm text-text-200">Clientes / Servicios Mkt</p>
                <p class="mt-2 text-3xl font-bold text-text-50"><?= $stats['clientes'] ?> <span class="text-lg font-normal text-text-300">/ <?= $stats['servicios_mkt'] ?></span></p>
                <p class="mt-1 text-xs text-accent-400">Ver clientes &rarr;</p>
            </a>
        </div>

        <!-- Resumen Financiero y Estado de Habitaciones -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 rounded-xl bg-background-900 border border-background-800 p-5">
                <h2 class="text-lg font-semibold text-text-50 mb-4">Resumen Financiero</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="/auth/ingresos/ingresos_realizados" class="rounded-lg bg-background-950 border border-background-800 p-4 hover:border-emerald-700 transition-colors">
                        <p class="text-xs text-text-300 uppercase">Ingresos (<?= $stats['ingresos_count'] ?>)</p>
                        <p class="mt-1 text-2xl font-bold text-emerald-400">$<?= number_format($stats['ingresos_total'], 2) ?></p>
                    </a>
                    <a href="/auth/egresos" class="rounded-lg bg-background-950 border border-background-800 p-4 hover:border-red-700 transition-colors">
                        <p class="text-xs text-text-300 uppercase">Egresos Activos (<?= $stats['egresos_count'] ?>)</p>
                        <p class="mt-1 text-2xl font-bold text-red-400">$<?= number_format($stats['egresos_total'], 2) ?></p>
                    </a>
                    <div class="rounded-lg bg-background-950 border border-background-800 p-4">
                        <p class="text-xs text-text-300 uppercase">Balance Neto</p>
                        <p class="mt-1 text-2xl font-bold <?= $stats['balance'] >= 0 ? 'text-emerald-400' : 'text-red-400' ?>">
                            $<?= number_format($stats['balance'], 2) ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-background-900 border border-background-800 p-5">
                <h2 class="text-lg font-semibold text-text-50 mb-4">Estado de Habitaciones</h2>
                <div class="space-y-2">
                    <?php if (empty($estados_habitaciones)): ?>
                        <p class="text-sm text-text-300">Sin datos de estados.</p>
                    <?php else: ?>
                        <?php foreach ($estados_habitaciones as $est): ?>
                            <div class="flex items-center justify-between rounded-lg bg-background-950 px-3 py-2 border border-background-800">
                                <span class="text-sm text-text-200"><?= htmlspecialchars($est['EST_HAB_DES']) ?></span>
                                <span class="text-sm font-bold text-text-50"><?= (int)$est['cantidad'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Accesos Rápidos -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-text-50 mb-4">Accesos Rápidos</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
                <a href="/auth/reservas/crear" class="flex flex-col items-center justify-center gap-2 rounded-lg bg-background-900 border border-background-800 hover:bg-secondary-800/30 hover:border-secondary-700 p-4 text-center text-sm text-text-100 transition-colors">
                    <span class="font-medium">+ Nueva Reserva</span>
                </a>
                <a href="/auth/ingresos/registrar" class="flex flex-col items-center justify-center gap-2 rounded-lg bg-background-900 border border-background-800 hover:bg-secondary-800/30 hover:border-secondary-700 p-4 text-center text-sm text-text-100 transition-colors">
                    <span class="font-medium">Registrar Ingreso</span>
                </a>
                <a href="/auth/egresos/crear" class="flex flex-col items-center justify-center gap-2 rounded-lg bg-background-900 border border-background-800 hover:bg-secondary-800/30 hover:border-secondary-700 p-4 text-center text-sm text-text-100 transition-colors">
                    <span class="font-medium">Registrar Egreso</span>
                </a>
                <a href="/auth/personal/asistencia" class="flex flex-col items-center justify-center gap-2 rounded-lg bg-background-900 border border-background-800 hover:bg-secondary-800/30 hover:border-secondary-700 p-4 text-center text-sm text-text-100 transition-colors">
                    <span class="font-medium">Asistencia</span>
                </a>
                <a href="/auth/marketing/clientes" class="flex flex-col items-center justify-center gap-2 rounded-lg bg-background-900 border border-background-800 hover:bg-secondary-800/30 hover:border-secondary-700 p-4 text-center text-sm text-text-100 transition-colors">
                    <span class="font-medium">Clientes</span>
                </a>
                <a href="/auth/roles" class="flex flex-col items-center justify-center gap-2 rounded-lg bg-background-900 border border-background-800 hover:bg-secondary-800/30 hover:border-secondary-700 p-4 text-center text-sm text-text-100 transition-colors">
                    <span class="font-medium">Roles de Pago</span>
                </a>
            </div>
        </div>

        <!-- Últimas Reservas -->
        <div class="mt-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-text-50">Últimas Reservas</h2>
                <a href="/auth/reservas" class="text-sm text-accent-400 hover:underline">Ver todas</a>
            </div>
            <div class="overflow-x-auto rounded-lg border border-background-800">
                <table class="min-w-full divide-y divide-background-800">
                    <thead class="bg-background-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">Cliente</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase">Espacio</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase">Entrada</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase">Salida</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-background-950 divide-y divide-background-900">
                        <?php if (empty($ultimas_reservas)): ?>
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-sm text-text-300">No hay reservas registradas aún.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($ultimas_reservas as $res): ?>
                                <tr class="hover:bg-background-900 transition-colors">
                                    <td class="px-4 py-3 text-sm text-text-200">#<?= htmlspecialchars($res['RES_ID']) ?></td>
                                    <td class="px-4 py-3 text-sm text-text-50"><?= htmlspecialchars($res['CLI_NOM'] ?? 'Sin cliente') ?></td>
                                    <td class="px-4 py-3 text-sm text-text-100 text-center">
                                        <?= !empty($res['HAB_ID']) ? 'Hab. ' . htmlspecialchars($res['HAB_ID']) : 'Salón ' . htmlspecialchars($res['SAL_ID'] ?? '') ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-text-200 text-center"><?= htmlspecialchars($res['RES_FECH_INI']) ?></td>
                                    <td class="px-4 py-3 text-sm text-text-200 text-center"><?= htmlspecialchars($res['RES_FECH_FIN']) ?></td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        <span class="inline-flex items-center rounded-full bg-secondary-800/40 px-2.5 py-0.5 text-xs font-medium text-text-100">
                                            <?= htmlspecialchars($res['EST_RES_DES'] ?? 'Activa') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Movimientos Recientes: Ingresos y Egresos -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-text-50">Últimos Ingresos</h2>
                    <a href="/auth/ingresos/ingresos_realizados" class="text-xs text-accent-400 hover:underline">Ver todos</a>
                </div>
                <div class="overflow-x-auto rounded-lg border border-background-800">
                    <table class="min-w-full divide-y divide-background-800">
                        <thead class="bg-background-900">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-text-200 uppercase">Cliente</th>
                                <th class="px-3 py-2 text-center text-xs font-semibold text-text-200 uppercase">Método</th>
                                <th class="px-3 py-2 text-right text-xs font-semibold text-text-200 uppercase">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="bg-background-950 divide-y divide-background-900">
                            <?php if (empty($ultimos_ingresos)): ?>
                                <tr><td colspan="3" class="px-3 py-4 text-center text-sm text-text-300">Sin ingresos registrados.</td></tr>
                            <?php else: ?>
                                <?php foreach ($ultimos_ingresos as $ing): ?>
                                    <tr class="hover:bg-background-900">
                                        <td class="px-3 py-2 text-sm text-text-50"><?= htmlspecialchars($ing['ing_reg_nom']) ?></td>
                                        <td class="px-3 py-2 text-xs text-text-300 text-center uppercase"><?= htmlspecialchars($ing['ing_reg_metodo_pago']) ?></td>
                                        <td class="px-3 py-2 text-sm font-semibold text-emerald-400 text-right">$<?= number_format((float)$ing['ing_reg_monto_pagar'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-text-50">Últimos Egresos</h2>
                    <a href="/auth/egresos" class="text-xs text-accent-400 hover:underline">Ver todos</a>
                </div>
                <div class="overflow-x-auto rounded-lg border border-background-800">
                    <table class="min-w-full divide-y divide-background-800">
                        <thead class="bg-background-900">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-text-200 uppercase">Descripción</th>
                                <th class="px-3 py-2 text-center text-xs font-semibold text-text-200 uppercase">Fecha</th>
                                <th class="px-3 py-2 text-right text-xs font-semibold text-text-200 uppercase">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="bg-background-950 divide-y divide-background-900">
                            <?php if (empty($ultimos_egresos)): ?>
                                <tr><td colspan="3" class="px-3 py-4 text-center text-sm text-text-300">Sin egresos registrados.</td></tr>
                            <?php else: ?>
                                <?php foreach ($ultimos_egresos as $egr): ?>
                                    <tr class="hover:bg-background-900">
                                        <td class="px-3 py-2 text-sm text-text-50"><?= htmlspecialchars($egr['EGR_DES']) ?></td>
                                        <td class="px-3 py-2 text-xs text-text-300 text-center"><?= htmlspecialchars($egr['EGR_FEC']) ?></td>
                                        <td class="px-3 py-2 text-sm font-semibold text-red-400 text-right">$<?= number_format((float)$egr['EGR_MON'], 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Clientes Recientes y Últimas Asistencias -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-text-50">Últimos Clientes (Contacto)</h2>
                    <a href="/auth/marketing/clientes" class="text-xs text-accent-400 hover:underline">Ver todos</a>
                </div>
                <div class="overflow-x-auto rounded-lg border border-background-800">
                    <table class="min-w-full divide-y divide-background-800">
                        <thead class="bg-background-900">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-text-200 uppercase">Nombre</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-text-200 uppercase">Cédula</th>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-text-200 uppercase">Email</th>
                            </tr>
                        </thead>
                        <tbody class="bg-background-950 divide-y divide-background-900">
                            <?php if (empty($ultimos_clientes)): ?>
                                <tr><td colspan="3" class="px-3 py-4 text-center text-sm text-text-300">Sin clientes registrados.</td></tr>
                            <?php else: ?>
                                <?php foreach ($ultimos_clientes as $cli): ?>
                                    <tr class="hover:bg-background-900">
                                        <td class="px-3 py-2 text-sm text-text-50"><?= htmlspecialchars($cli['CLI_NOM']) ?></td>
                                        <td class="px-3 py-2 text-xs font-mono text-text-200"><?= htmlspecialchars($cli['CLI_CED']) ?></td>
                                        <td class="px-3 py-2 text-xs text-text-300"><?= htmlspecialchars($cli['CLI_EMAIL'] ?? '—') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-text-50">Últimas Asistencias</h2>
                    <a href="/auth/personal/asistencia" class="text-xs text-accent-400 hover:underline">Ver todas</a>
                </div>
                <div class="overflow-x-auto rounded-lg border border-background-800">
                    <table class="min-w-full divide-y divide-background-800">
                        <thead class="bg-background-900">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-semibold text-text-200 uppercase">Empleado</th>
                                <th class="px-3 py-2 text-center text-xs font-semibold text-text-200 uppercase">Llegada</th>
                                <th class="px-3 py-2 text-center text-xs font-semibold text-text-200 uppercase">Salida</th>
                            </tr>
                        </thead>
                        <tbody class="bg-background-950 divide-y divide-background-900">
                            <?php if (empty($ultimas_asistencias)): ?>
                                <tr><td colspan="3" class="px-3 py-4 text-center text-sm text-text-300">Sin asistencias registradas.</td></tr>
                            <?php else: ?>
                                <?php foreach ($ultimas_asistencias as $asist): ?>
                                    <tr class="hover:bg-background-900">
                                        <td class="px-3 py-2 text-sm text-text-50"><?= htmlspecialchars($asist['PERS_NOM'] . ' ' . ($asist['PERS_APE'] ?? '')) ?></td>
                                        <td class="px-3 py-2 text-xs text-text-200 text-center"><?= htmlspecialchars($asist['ASIST_HORA_LLEGADA']) ?></td>
                                        <td class="px-3 py-2 text-xs text-text-300 text-center"><?= htmlspecialchars($asist['ASIST_HORA_SALIDA'] ?? '—') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

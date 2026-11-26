<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-24 min-h-dvh bg-background-950">
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-background-800 pb-4">
            <div>
                <h1 class="w-fit border-b py-1 text-3xl sm:text-4xl font-semibold text-text-50 border-b-accent-800">Auditoría del Sistema</h1>
                <p class="mt-1 text-sm text-text-300">Historial de acciones de seguridad y gestión de usuarios (`seg_registro_accion`).</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="/auth/seguridad" class="rounded-md px-4 py-2 text-sm font-medium bg-secondary-800 text-text-50 hover:bg-secondary-700 transition-colors">
                    Administrar Usuarios
                </a>
            </div>
        </div>

        <!-- Tarjetas de resumen -->
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="rounded-xl bg-background-900 border border-background-800 p-4">
                <p class="text-sm text-text-200">Eventos Registrados</p>
                <p class="mt-1 text-2xl font-bold text-text-50"><?= count($registros) ?></p>
            </div>
            <div class="rounded-xl bg-background-900 border border-background-800 p-4">
                <p class="text-sm text-text-200">Usuarios con Actividad</p>
                <p class="mt-1 text-2xl font-bold text-text-50"><?= count(array_unique(array_filter(array_column($registros, 'USU_NOM')))) ?></p>
            </div>
            <div class="rounded-xl bg-background-900 border border-background-800 p-4">
                <p class="text-sm text-text-200">Último Evento</p>
                <p class="mt-1 text-sm font-medium text-accent-400 truncate"><?= !empty($registros[0]) ? htmlspecialchars($registros[0]['ACC_FEC']) : 'Sin registros aún' ?></p>
            </div>
        </div>

        <!-- Buscador -->
        <div class="mt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <form action="/auth/auditoria" method="GET" class="relative flex h-10 w-full max-w-md items-center">
                <input name="search" type="text" class="rounded-r-none inp h-10 w-full" placeholder="Buscar por usuario o acción..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="grid aspect-square h-10 place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500" title="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="/auth/auditoria" class="ml-2 text-sm text-accent-400 hover:underline whitespace-nowrap">Limpiar</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Tabla de Auditoría -->
        <div class="mt-6 overflow-x-auto rounded-lg border border-background-800">
            <table class="min-w-full divide-y divide-background-800">
                <thead class="bg-background-900">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">Usuario</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase">Rol</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">Acción Realizada</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase">Fecha y Hora</th>
                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-900">
                    <?php if (empty($registros)): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-sm text-text-300">No hay eventos de auditoría registrados todavía.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($registros as $reg): ?>
                            <tr class="hover:bg-background-900 transition-colors">
                                <td class="px-4 py-3 text-sm text-text-300">#<?= htmlspecialchars($reg['ACC_ID']) ?></td>
                                <td class="px-4 py-3 text-sm font-medium text-text-50"><?= htmlspecialchars($reg['USU_NOM'] ?? 'Sistema / Eliminado') ?></td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <span class="inline-flex items-center rounded-full bg-secondary-800/40 px-2.5 py-0.5 text-xs font-medium text-text-100 uppercase">
                                        <?= htmlspecialchars($reg['USU_ROL'] ?? '—') ?>
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-text-100"><?= htmlspecialchars($reg['ACC_DES']) ?></td>
                                <td class="px-4 py-3 text-sm text-text-300 text-center font-mono"><?= htmlspecialchars($reg['ACC_FEC']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

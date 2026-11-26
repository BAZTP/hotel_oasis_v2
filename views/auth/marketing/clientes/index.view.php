<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-background-800 pb-4">
            <div>
                <h1 class="w-fit border-b py-1 text-3xl sm:text-4xl font-semibold text-text-50 border-b-accent-800">Clientes (Contacto)</h1>
                <p class="mt-1 text-sm text-text-300">Clientes registrados desde el formulario público de contacto y reservas.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="/auth/marketing" class="rounded-md px-4 py-2 text-sm font-medium bg-background-900 border border-background-800 text-text-100 hover:border-accent-600 transition-colors">
                    Servicios
                </a>
                <a href="/auth/marketing/promociones" class="rounded-md px-4 py-2 text-sm font-medium bg-background-900 border border-background-800 text-text-100 hover:border-accent-600 transition-colors">
                    Promociones
                </a>
            </div>
        </div>

        <!-- Barra de búsqueda y resumen -->
        <div class="mt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <form action="/auth/marketing/clientes" method="GET" class="relative flex h-10 w-full max-w-md items-center">
                <input name="search" type="text" class="rounded-r-none inp h-10 w-full" placeholder="Buscar por nombre, cédula o email..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="grid aspect-square h-10 place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500" title="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="/auth/marketing/clientes" class="ml-2 text-sm text-accent-400 hover:underline whitespace-nowrap">Limpiar</a>
                <?php endif; ?>
            </form>
            <div class="text-sm text-text-200">
                Total registrados: <span class="font-semibold text-text-50"><?= count($clientes) ?></span>
            </div>
        </div>

        <!-- Tabla de clientes -->
        <div class="mt-6 overflow-x-auto rounded-lg border border-background-800">
            <table class="min-w-full divide-y divide-background-800">
                <thead class="bg-background-900">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">Cédula</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">Nombre</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">Teléfono</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">Email</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase">Dirección</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase">Estado</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-900">
                    <?php if (empty($clientes)): ?>
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-sm text-text-300">No hay clientes registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clientes as $cli): ?>
                            <tr class="hover:bg-background-900 transition-colors">
                                <td class="px-4 py-3 text-sm text-text-300">#<?= htmlspecialchars($cli['CLI_ID']) ?></td>
                                <td class="px-4 py-3 text-sm text-text-50 font-mono"><?= htmlspecialchars($cli['CLI_CED']) ?></td>
                                <td class="px-4 py-3 text-sm font-medium text-text-50"><?= htmlspecialchars($cli['CLI_NOM']) ?></td>
                                <td class="px-4 py-3 text-sm text-text-100"><?= htmlspecialchars($cli['CLI__NUM'] ?? '—') ?></td>
                                <td class="px-4 py-3 text-sm text-text-200"><?= htmlspecialchars($cli['CLI_EMAIL'] ?? '—') ?></td>
                                <td class="px-4 py-3 text-sm text-text-200"><?= htmlspecialchars($cli['direccion'] ?? '—') ?></td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <?php if ((int)$cli['EST_CLI_ID'] === 1): ?>
                                        <span class="inline-flex items-center rounded-full bg-emerald-800/30 px-2.5 py-0.5 text-xs font-medium text-emerald-300">Primera Vez</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center rounded-full bg-secondary-800/40 px-2.5 py-0.5 text-xs font-medium text-text-100">Nuevo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <button type="button" onclick='openEditClientModal(<?= htmlspecialchars(json_encode($cli), ENT_QUOTES, "UTF-8") ?>)' class="inline-flex items-center justify-center h-8 w-8 rounded-md bg-secondary-800 hover:bg-secondary-700 text-text-50 transition-colors" title="Editar cliente">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Editar Cliente -->
    <div id="editClientModal" class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-xl border border-background-800 bg-background-900 shadow-xl overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-background-800">
                <h3 class="text-lg font-semibold text-text-50">Editar Cliente</h3>
                <button type="button" onclick="closeEditClientModal()" class="text-text-300 hover:text-text-50">&times;</button>
            </div>
            <form method="POST" action="/auth/marketing/clientes/actualizar" class="p-6 space-y-4">
                <input type="hidden" name="cli_id" id="edit_cli_id">
                <div>
                    <label class="block text-sm font-medium text-text-200 mb-1">Nombre</label>
                    <input type="text" name="cli_nom" id="edit_cli_nom" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm" required>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-text-200 mb-1">Teléfono</label>
                        <input type="text" name="cli_num" id="edit_cli_num" maxlength="10" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-200 mb-1">Estado</label>
                        <select name="est_cli_id" id="edit_est_cli_id" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm">
                            <option value="1">Primera Vez</option>
                            <option value="2">Nuevo</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-200 mb-1">Email</label>
                    <input type="email" name="cli_email" id="edit_cli_email" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-text-200 mb-1">Dirección</label>
                    <input type="text" name="direccion" id="edit_direccion" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm">
                </div>
                <div class="pt-3 border-t border-background-800 flex justify-end gap-3">
                    <button type="button" onclick="closeEditClientModal()" class="px-4 py-2 rounded-md text-sm font-medium bg-background-800 text-text-100 hover:bg-background-700">Cancelar</button>
                    <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium bg-secondary-800 text-text-50 hover:bg-secondary-700">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
function openEditClientModal(cli) {
    document.getElementById('edit_cli_id').value = cli.CLI_ID;
    document.getElementById('edit_cli_nom').value = cli.CLI_NOM || '';
    document.getElementById('edit_cli_num').value = cli.CLI__NUM || '';
    document.getElementById('edit_cli_email').value = cli.CLI_EMAIL || '';
    document.getElementById('edit_direccion').value = cli.direccion || '';
    document.getElementById('edit_est_cli_id').value = cli.EST_CLI_ID || 1;
    document.getElementById('editClientModal').classList.remove('hidden');
}
function closeEditClientModal() {
    document.getElementById('editClientModal').classList.add('hidden');
}
</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

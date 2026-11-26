<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Egresos</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <form action="/auth/egresos" method="GET" class="relative flex h-10 w-full max-w-sm items-center">
                <input id="search_name" name="search" type="text" class="rounded-r-none inp" placeholder="Buscar egresos por proveedor" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="grid aspect-square h-full place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
            <a href="/auth/egresos/crear" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Añadir Egreso +</a>
        </div>

        <?php if (count($egresos) > 0): ?>
        <div class="mt-4 grid grid-cols-1 gap-2 text-neutral-50 md:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3">
            <?php foreach ($egresos as $egreso): ?>
            <div class="relative flex h-28 w-full flex-row justify-between rounded-md px-3 py-3 drop-shadow-md bg-background-900">
                <div class="relative flex grow">
                    <div class="aspect-square h-full w-auto rounded-lg bg-accent-800">
                        <!-- Puedes personalizar la visualización del ícono aquí si es necesario -->
                    </div>
                    <div class="relative px-2 text-text-300">
                        <p class="text-lg font-semibold text-text-200">Proveedor: <?= htmlspecialchars($egreso['EGR_PROVEEDOR']) ?></p>
                        <p class="text-sm">RUC: <?= htmlspecialchars($egreso['EGR_RUC']) ?></p>
                        <p class="text-sm">Monto: $<?= htmlspecialchars(number_format($egreso['EGR_MON'], 2)) ?></p>
                    </div>
                </div>
                <div class="flex flex-col justify-between">
                    <button type="button" onclick="showUpdateModal(<?= htmlspecialchars($egreso['EGR_ID']) ?>, '<?= htmlspecialchars($egreso['EGR_PROVEEDOR']) ?>', '<?= htmlspecialchars($egreso['EGR_RUC']) ?>', '<?= htmlspecialchars($egreso['EGR_MON']) ?>')" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25A1.5 1.5 0 0 1 3.75 18V8.25a1.5 1.5 0 0 1 1.5-1.5H9a.75.75 0 0 0 0-1.5H5.25Z" />
                        </svg>
                    </button>
                    <button type="button" onclick="showConfirmModal(<?= htmlspecialchars($egreso['EGR_ID']) ?>)" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                  <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                </svg>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="w-full flex items-center justify-center">
            <p class="text-xl font-semibold text-text-50">No hay egresos registrados.</p>
        </div>
        <?php endif; ?>

        <!-- Modal de confirmación de inactivación -->
        <div id="confirmModal" class="fixed inset-0 flex items-center justify-center hidden bg-black/50">
            <div class="relative w-1/3 max-w-sm p-6 bg-background-800 rounded-md">
                <form id="confirmModalForm" action="/auth/egresos/inactivar" method="POST">
                    <input type="hidden" name="egreso_id" id="inactivate_egreso_id">
                    <h2 class="text-xl font-semibold text-text-50">Confirmación</h2>
                    <p class="mt-2 text-text-300">¿Está seguro que desea inactivar este egreso?</p>
                    <div class="mt-4 flex justify-end gap-2">
                        <button type="button" onclick="hideConfirmModal()" class="px-4 py-2 text-sm bg-secondary-800 text-text-50 rounded-md hover:bg-secondary-700">Cancelar</button>
                        <button type="submit" class="px-4 py-2 text-sm bg-accent-800 text-text-50 rounded-md hover:bg-accent-700">Inactivar</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal de actualización -->
        <div id="updateModal" class="fixed inset-0 flex items-center justify-center hidden bg-black/50">
            <div class="relative w-1/3 max-w-sm p-6 bg-background-800 rounded-md">
            <form action="/auth/egresos/actualizar" method="POST">
    <input type="hidden" name="egreso_id" id="update_egreso_id">
    <div class="mt-4">
        <label for="update_descripcion" class="block text-sm font-medium text-text-300">Descripción</label>
        <input type="text" id="update_descripcion" name="descripcion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    </div>
    <div class="mt-4">
        <label for="update_monto" class="block text-sm font-medium text-text-300">Monto</label>
        <input type="number" id="update_monto" name="monto" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    </div>
    <div class="mt-4">
        <label for="update_fecha" class="block text-sm font-medium text-text-300">Fecha</label>
        <input type="date" id="update_fecha" name="fecha" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    </div>
    <div class="mt-4">
        <label for="update_tipo" class="block text-sm font-medium text-text-300">Tipo</label>
        <input type="number" id="update_tipo" name="tipo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
    </div>
    <div class="mt-4 flex justify-end gap-2">
        <button type="button" onclick="hideUpdateModal()" class="px-4 py-2 text-sm bg-secondary-800 text-text-50 rounded-md hover:bg-secondary-700">Cancelar</button>
        <button type="submit" class="px-4 py-2 text-sm bg-accent-800 text-text-50 rounded-md hover:bg-accent-700">Actualizar</button>
    </div>
</form>

            </div>
        </div>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

<script src="/js/auth/egresos/index.js"></script>
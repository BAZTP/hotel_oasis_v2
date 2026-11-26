<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <!-- Encabezado -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-background-800 pb-4">
            <div>
                <h1 class="w-fit border-b py-1 text-3xl sm:text-4xl font-semibold text-text-50 border-b-accent-800">Servicios de Marketing</h1>
                <p class="mt-1 text-sm text-text-300">Gestiona los servicios activos disponibles para clientes y promociones.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="/auth/marketing/clientes" class="rounded-md px-4 py-2 text-sm font-medium bg-background-900 border border-background-800 text-text-100 hover:border-accent-600 transition-colors">
                    Clientes (Contacto)
                </a>
                <a href="/auth/marketing/promociones" class="rounded-md px-4 py-2 text-sm font-medium bg-background-900 border border-background-800 text-text-100 hover:border-accent-600 transition-colors">
                    Ver Promociones
                </a>
                <a href="/auth/marketing/crear" class="flex items-center gap-1 rounded-md px-4 py-2 text-sm font-medium transition-colors duration-200 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">
                    + Añadir Servicio
                </a>
            </div>
        </div>

        <!-- Barra de búsqueda y resumen -->
        <div class="mt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <form action="/auth/marketing" method="GET" class="relative flex h-10 w-full max-w-md items-center">
                <input id="search_name" name="search" type="text" class="rounded-r-none inp h-10 w-full" placeholder="Buscar por tipo, detalle o descripción..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="grid aspect-square h-10 place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500" title="Buscar">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="/auth/marketing" class="ml-2 text-sm text-accent-400 hover:underline whitespace-nowrap">Limpiar</a>
                <?php endif; ?>
            </form>
            <div class="text-sm text-text-200">
                Total servicios activos: <span class="font-semibold text-text-50"><?= count($servicios) ?></span>
            </div>
        </div>

        <!-- Grid de servicios -->
        <?php if (!empty($servicios)): ?>
            <div class="mt-6 grid grid-cols-1 gap-4 text-neutral-50 md:grid-cols-2 xl:grid-cols-3">
                <?php foreach ($servicios as $servicio): ?>
                    <div id="servicio-<?= htmlspecialchars($servicio['PROM_SERV_ID']) ?>" class="relative flex flex-col justify-between p-5 rounded-xl border border-background-800 bg-background-900 hover:border-accent-700 transition-colors shadow-md">
                        <div>
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <span class="inline-flex items-center rounded-full bg-secondary-800/40 px-2.5 py-0.5 text-xs font-medium text-text-100">
                                    <?= htmlspecialchars($servicio['TIP_SERV_DET']) ?>
                                </span>
                                <span class="text-lg font-bold text-emerald-400">
                                    $<?= number_format((float)$servicio['PROM_SERV_COSTO'], 2, '.', '') ?>
                                </span>
                            </div>

                            <h3 class="text-lg font-semibold text-text-50 mb-1">
                                <?= htmlspecialchars($servicio['PROM_SERV_DET']) ?>
                            </h3>
                            <p class="text-sm text-text-300 mb-3">
                                <?= htmlspecialchars($servicio['PROM_SERV_DESC']) ?>
                            </p>
                        </div>

                        <div class="pt-3 border-t border-background-800 flex items-center justify-between">
                            <span class="text-xs text-text-300">
                                #<?= htmlspecialchars($servicio['PROM_SERV_ID']) ?> &bull; <?= htmlspecialchars($servicio['PROM_SERV_FEC']) ?>
                            </span>
                            <div class="flex items-center gap-2">
                                <button type="button" onclick='showUpdateModal(<?= htmlspecialchars(json_encode($servicio), ENT_QUOTES, "UTF-8") ?>)' class="grid h-9 w-9 place-items-center rounded-md bg-secondary-800 hover:bg-secondary-700 text-text-50 transition-colors" title="Editar servicio">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                        <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                    </svg>
                                </button>
                                <button type="button" onclick="showConfirmModal(<?= (int)$servicio['PROM_SERV_ID'] ?>)" class="grid h-9 w-9 place-items-center rounded-md bg-red-800 hover:bg-red-700 text-text-50 transition-colors" title="Eliminar servicio">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                        <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mt-12 rounded-xl border border-background-800 bg-background-900 p-12 text-center">
                <p class="text-xl font-semibold text-text-200">No se encontraron servicios</p>
                <p class="mt-1 text-sm text-text-300">Prueba con otra búsqueda o añade un nuevo servicio.</p>
            </div>
        <?php endif; ?>
    </div>

<!-- Modal para confirmación de eliminación -->
<div class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4" aria-hidden="true" id="modal">
    <div class="relative w-full max-w-md rounded-xl border border-background-800 bg-background-900 shadow-xl overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-text-50">Confirmar eliminación</h3>
            <p class="mt-2 text-sm text-text-300">¿Está seguro que desea eliminar este servicio?</p>
        </div>
        <div class="bg-background-950 px-6 py-3 flex justify-end gap-3 border-t border-background-800">
            <button id="modal-close" type="button" class="px-4 py-2 rounded-md text-sm font-medium bg-background-800 text-text-100 hover:bg-background-700 transition-colors">
                Cancelar
            </button>
            <form method="POST" action="/auth/marketing/eliminar" class="m-0">
                <input type="hidden" name="delete_prom_serv_id" id="promo_id_delete" value="">
                <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium text-text-50 bg-red-800 hover:bg-red-700 transition-colors">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal para actualización -->
<div class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4" aria-hidden="true" id="updateModal">
    <div class="relative w-full max-w-lg rounded-xl border border-background-800 bg-background-900 shadow-xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-background-800">
            <h3 class="text-lg font-semibold text-text-50">Actualizar Servicio</h3>
            <button type="button" onclick="closeUpdateModal()" class="text-text-300 hover:text-text-50">&times;</button>
        </div>
        <form id="updateForm" action="/auth/marketing/actualizar" method="POST" onsubmit="return handleSubmit(event)" class="p-6 space-y-4">
            <input type="hidden" id="update_prom_serv_id" name="update_prom_serv_id" value="">
            <div>
                <label for="update_tip_serv_id" class="block text-sm font-medium text-text-200 mb-1">Tipo de Servicio</label>
                <input type="text" id="update_tip_serv_id" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-300 text-sm" readonly>
            </div>
            <div>
                <label for="update_prom_serv_det" class="block text-sm font-medium text-text-200 mb-1">Detalle del Servicio</label>
                <input type="text" id="update_prom_serv_det" name="update_prom_serv_det" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm" required>
            </div>
            <div>
                <label for="update_prom_serv_desc" class="block text-sm font-medium text-text-200 mb-1">Descripción</label>
                <input type="text" id="update_prom_serv_desc" name="update_prom_serv_desc" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm" required>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="update_prom_serv_fec" class="block text-sm font-medium text-text-200 mb-1">Fecha</label>
                    <input type="datetime-local" id="update_prom_serv_fec" name="update_prom_serv_fec" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm" required>
                </div>
                <div>
                    <label for="update_prom_serv_costo" class="block text-sm font-medium text-text-200 mb-1">Costo ($)</label>
                    <input type="number" id="update_prom_serv_costo" name="update_prom_serv_costo" step="0.01" min="0.01" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 text-sm" required>
                </div>
            </div>
            <div class="pt-4 border-t border-background-800 flex justify-end gap-3">
                <button type="button" onclick="closeUpdateModal()" class="px-4 py-2 rounded-md text-sm font-medium bg-background-800 text-text-100 hover:bg-background-700 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 rounded-md text-sm font-medium bg-secondary-800 text-text-50 hover:bg-secondary-700 transition-colors">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function convertToUpperCase(event) {
    event.target.value = event.target.value.toUpperCase();
}
document.getElementById('update_prom_serv_det').addEventListener('input', convertToUpperCase);
document.getElementById('update_prom_serv_desc').addEventListener('input', convertToUpperCase);

function showConfirmModal(serviceId) {
    document.getElementById('promo_id_delete').value = serviceId;
    document.getElementById('modal').classList.remove('hidden');
}

function closeConfirmModal() {
    document.getElementById('modal').classList.add('hidden');
}

document.getElementById('modal-close').addEventListener('click', closeConfirmModal);

function showUpdateModal(servicio) {
    document.getElementById('update_prom_serv_id').value = servicio.PROM_SERV_ID;
    document.getElementById('update_tip_serv_id').value = servicio.TIP_SERV_DET || servicio.TIP_SERV_ID;
    document.getElementById('update_prom_serv_det').value = servicio.PROM_SERV_DET || '';
    document.getElementById('update_prom_serv_desc').value = servicio.PROM_SERV_DESC || '';
    const fechaRaw = (servicio.PROM_SERV_FEC || '').replace(' ', 'T').slice(0, 16);
    document.getElementById('update_prom_serv_fec').value = fechaRaw;
    document.getElementById('update_prom_serv_costo').value = servicio.PROM_SERV_COSTO;
    document.getElementById('updateModal').classList.remove('hidden');
}

function closeUpdateModal() {
    document.getElementById('updateModal').classList.add('hidden');
}

async function handleSubmit(event) {
    event.preventDefault();

    const costoField = document.getElementById('update_prom_serv_costo');
    const costo = parseFloat(costoField.value);
    if (isNaN(costo) || costo <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Costo no válido',
            text: 'Por favor, ingrese un costo mayor que cero.'
        });
        costoField.focus();
        return false;
    }

    const form = event.target;
    const formData = new FormData(form);
    const response = await fetch(form.action, {
        method: form.method,
        body: formData
    });

    if (response.ok) {
        Swal.fire({
            icon: 'success',
            title: 'Actualización exitosa',
            text: 'El servicio se ha actualizado correctamente.',
        }).then(() => {
            closeUpdateModal();
            location.reload();
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error en la actualización',
            text: 'Hubo un problema al actualizar el servicio. Por favor, inténtalo de nuevo.',
        });
    }
    return false;
}
</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

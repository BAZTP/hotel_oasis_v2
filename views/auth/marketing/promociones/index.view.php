<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Promociones</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <form action="/auth/marketing/promociones" method="GET" class="relative flex h-10 w-full max-w-sm items-center">
                <input id="search_name" name="search" type="text" class="rounded-r-none inp" placeholder="Buscar Promociones" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                <button type="submit" class="grid aspect-square h-full place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
            <a href="/auth/marketing/promociones/crear" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Añadir +</a>
        </div>

        <?php if (!empty($promociones)): ?>
            <div class="mt-4 grid grid-cols-1 gap-4 text-neutral-50 md:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3">
                <?php foreach ($promociones as $promocion): ?>
                    <div class="relative flex flex-col justify-between h-auto p-4 rounded-md shadow-md bg-background-900">
                        <div class="relative flex flex-col">
                            <div class="mb-2 text-text-300">
                                <p class="text-lg font-semibold text-text-200">Promoción ID: <?= htmlspecialchars($promocion['PROMO_ID']) ?></p>
                                <p class="text-sm">Título: <?= htmlspecialchars($promocion['PROMO_TIT']) ?></p>
                                <p class="text-sm">Detalle: <?= htmlspecialchars($promocion['PROMO_DET']) ?></p>
                                <p class="text-sm">Descuento: <?= htmlspecialchars($promocion['PROMO_DESCU']) ?></p>
                                <!-- Agregar más campos según sea necesario -->
                            </div>
                        </div>
                        <div class="flex flex-row justify-between mt-2">
                            <button type="button" onclick="showUpdateModal(<?= htmlspecialchars(json_encode($promocion)) ?>)" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                </svg>
                            </button>
                            <button onclick="showConfirmModal(<?= $promocion['PROMO_ID'] ?>)" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-4xl font-semibold text-text-200">No hay promociones</p>
        <?php endif; ?>
    </div>

    <!-- Modal para confirmación de eliminación -->
    <div class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" id="modal">
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-background-950 text-left shadow-xl transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <div class="bg-accent-950 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-yellow-600 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-text-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-text-50" id="modal-title">
                                    Confirmar eliminación
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-text-300">¿Está seguro que desea eliminar esta promoción?</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-background-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form method="POST" action="/auth/marketing/promociones/eliminar" class="m-0 sm:mx-1">
                            <input type="hidden" name="PROMO_ID" id="promo_id_delete" value="">
                            <button type="submit" class="w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-text-50 bg-accent-800 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 sm:order-1 sm:ml-3 sm:w-auto sm:text-sm">
                                Eliminar
                            </button>
                        </form>
                        <button id="modal-close" type="button" class="mt-3 w-full justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-text-50 bg-secondary-800 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-500 sm:mt-0 sm:order-2 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal para actualizar promoción -->
<div class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" id="update-modal">
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-screen items-center justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-background-950 text-left shadow-xl transition-all sm:max-w-lg sm:w-full">
                <form action="/auth/marketing/promociones/actualizar" method="POST">
                    <div class="bg-accent-950 px-4 py-4 sm:p-6">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-text-50">Actualizar Promoción</h3>
                        </div>
                        <input type="hidden" name="PROMO_ID" id="promo_id_update" value="">
                        <div class="mb-4">
                            <label for="update_titulo" class="block text-sm font-medium text-text-300">Título</label>
                            <input type="text" name="update_titulo" id="update_titulo" class="inp" required>
                        </div>
                        <div class="mb-4">
                            <label for="update_detalle" class="block text-sm font-medium text-text-300">Detalle</label>
                            <textarea name="update_detalle" id="update_detalle" rows="3" class="inp" required></textarea>
                        </div>
                        <div class="mb-4">
                        <label for="update_descuento" class="block text-sm font-medium text-text-300">Descuento (%)</label>
                        <input type="number" name="update_descuento" id="update_descuento" step="0.01" min="0.01" class="inp" required>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-accent-800 text-text-50 rounded-md hover:bg-accent-700">Actualizar</button>
                            <button type="button" onclick="hideUpdateModal()" class="ml-2 px-4 py-2 bg-secondary-800 text-text-50 rounded-md hover:bg-secondary-700">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        </main>
<script>
// Función para mostrar el modal de confirmación
// Función para mostrar el modal de confirmación
// Mostrar el modal de confirmación
function showConfirmModal(promoId) {
    const modal = document.getElementById('modal');
    modal.classList.remove('hidden');
    document.getElementById('promo_id_delete').value = promoId;
}

// Ocultar el modal de confirmación
function closeConfirmModal() {
    const modal = document.getElementById('modal');
    modal.classList.add('hidden');
}

// Función para eliminar la promoción
function deleteServicio() {
    const promoId = document.getElementById('promo_id_delete').value;
    if (!promoId) return;

    fetch('/auth/marketing/promociones/eliminar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ PROMO_ID: promoId }) // Verificar el nombre del campo
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            Swal.fire({
                title: 'Eliminado!',
                text: 'La promoción ha sido eliminada.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'No se pudo completar la solicitud.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}

document.getElementById('modal-close').addEventListener('click', closeConfirmModal);
document.getElementById('confirm-delete').addEventListener('click', deleteServicio);


function validateForm() {
    const descuentoInput = document.getElementById('update_descuento');
    const descuentoValue = parseFloat(descuentoInput.value);
    
    // Validar que el valor sea mayor a 0
    if (isNaN(descuentoValue) || descuentoValue <= 0) {
        alert('El descuento debe ser un número positivo mayor a 0.');
        return false; // Previene el envío del formulario
    }
    
    // Validar que el valor tenga como máximo dos decimales
    if (descuentoValue.toFixed(2) !== descuentoInput.value) {
        alert('El descuento debe tener como máximo dos decimales.');
        return false; // Previene el envío del formulario
    }
    
    return true; // Permite el envío del formulario si todas las validaciones pasan
}
// Manejadores de eventos
document.getElementById('confirm-delete').addEventListener('click', deleteServicio);
document.getElementById('modal-close').addEventListener('click', closeConfirmModal);


function showUpdateModal(promocion) {
    console.log(promocion);  // Verifica qué datos están siendo pasados
    document.getElementById('promo_id_update').value = promocion.PROMO_ID;
    document.getElementById('update_titulo').value = promocion.PROMO_TIT;
    document.getElementById('update_detalle').value = promocion.PROMO_DET;
    document.getElementById('update_descuento').value = promocion.PROMO_DESCU;
    document.getElementById('update-modal').classList.remove('hidden');
}


function hideUpdateModal() {
    document.getElementById('update-modal').classList.add('hidden');
}

document.getElementById('modal-close').addEventListener('click', () => {
    document.getElementById('modal').classList.add('hidden');
});

document.addEventListener('click', (e) => {
    if (e.target === document.getElementById('modal')) {
        document.getElementById('modal').classList.add('hidden');
    }
    if (e.target === document.getElementById('update-modal')) {
        document.getElementById('update-modal').classList.add('hidden');
    }
});
<?php if (isset($_SESSION['update_success']) && $_SESSION['update_success']): ?>
        Swal.fire({
            icon: 'success',
            title: 'Promoción actualizada',
            text: 'La promoción se ha actualizado exitosamente.'
        });
        <?php unset($_SESSION['update_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['delete_success']) && $_SESSION['delete_success']): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Promoción eliminada',
                text: 'La promoción se ha eliminado exitosamente.'
            });
        </script>
        <?php unset($_SESSION['delete_success']); ?>
    <?php endif; ?>
</script>


<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

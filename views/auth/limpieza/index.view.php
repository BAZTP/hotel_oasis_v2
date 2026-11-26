<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full max-w-6xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Limpieza Programada</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <form class="relative flex h-10 w-full max-w-sm items-center" onsubmit="event.preventDefault(); buscarLimpieza();">
                <input id="search_name" type="text" class="rounded-r-none inp" placeholder="Buscar limpieza" onkeyup="buscarLimpieza()">
                <button type="submit" class="grid aspect-square h-full place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
            <div class="flex gap-x-4">
            <a href="/auth/limpieza/crear" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Añadir Limpieza +</a>
            </div>           
        </div>
        <div class="w-full mt-8 flex justify table-container">
			<div  class="flex gap-x-4">
				<label for="status" class="flex flex-row items-center font-semibold text-text-50 gap-x-2">Estados:
                    <select name="status" id="status" class="rounded-md inp" onchange="buscarLimpieza()">
                        <option value="0">Todos</option>
                        <?php foreach ($estados as $estado): ?>
                        <option value="<?= $estado['EST_LIM_PROG_ID'] ?>"><?= $estado['EST_LIM_PROG_DET'] ?></option>
                        <?php endforeach; ?>
                    </select>
				</label>
				<div class="flex gap-x-4">
				<a href="/auth/limpieza/excel" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Exportar a Excel</a>
				</div>
			</div>
		</div>

        <div class="w-full mt-8 flex justify-center table-container">
            <table class="min-w-full divide-y divide-background-800" id="limpiezaTable">
                <thead class="bg-background-900">
                    <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-text-200 uppercase tracking-wider text-center">N° DE HABITACIÓN</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-text-200 uppercase tracking-wider text-center">ESTADO</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-text-200 uppercase tracking-wider text-center">PERSONAL</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-text-200 uppercase tracking-wider text-center">LIMPIEZA FECHA</th>
                    <th scope="col" class="px-6 py-3 text-xs font-medium text-text-200 uppercase tracking-wider text-center">ACCIONES</th>

                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-800">
                    <?php if (!empty($reservas)): ?>
                        <?php foreach ($reservas as $row): ?>
                            <tr>
                                <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['HAB_ID']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['EST_LIM_PROG_DET']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_NOM']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['LIM_PROG_FECH']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'>
                                    <div class="flex justify-center items-center space-x-2">
                                        <button onclick="openUpdateModal(<?= $row['LIM_PROG_ID'] ?>, <?= $row['EST_LIM_PROG_ID'] ?>,<?= $row['PERS_ID'] ?>,'<?= $row['LIM_PROG_FECH'] ?>')" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800 mx-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                        </svg>
                                        </button> 
                                        <button onclick="showConfirmModal(<?= $row['LIM_PROG_ID'] ?>)" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-1 py-2 whitespace-nowrap text-center text-text-200 uppercase tracking-wider">No results found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>


    <!-- Modal para actualizar -->
    <div id="updateModal" class="hidden fixed z-50 inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="bg-background-950 rounded-lg overflow-hidden shadow-xl w-full max-w-xs">
                <div class="bg-accent-950 px-4 pb-4 pt-3 sm:p-4">
                    <div class="flex justify-center">
                        <div class="mx-auto flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-yellow-600 sm:mx-0 sm:h-8 sm:w-8">
                            <svg class="h-6 w-6 text-text-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-text-50" id="modal-title">
                                Actualizar Limpieza
                            </h3>
                            <div class="mt-2">
                                <form id="updateForm" method="POST" action="/auth/limpieza/actualizar">
                                    <input type="hidden" name="limpieza_id" id="limpieza_id">
                                    <div class="mb-4">
                                        <label for="estado" class="block mb-2 text-text-50">Estado:</label>
                                        <select name="estado" id="estado" class="w-full border-gray-300 rounded-md p-2">
                                            <?php foreach ($estados as $estado): ?>
                                                <option value="<?= $estado['EST_LIM_PROG_ID'] ?>"><?= $estado['EST_LIM_PROG_DET'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="personal" class="block mb-2 text-text-50">Personal:</label>
                                        <select name="personal" id="personal" class="w-full border-gray-300 rounded-md p-2">
                                            <?php foreach ($tipo_personales as $personal): ?>
                                                <option value="<?= $personal['PERS_ID'] ?>"><?= $personal['PERS_NOM'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="fecha" class="block mb-2 text-text-50">Fecha:</label>
                                        <input type="date" name="fecha" id="fecha" class="w-full border-gray-300 rounded-md p-2">
                                    </div>
                                    <div class="bg-accent-950 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-base font-medium text-text-50 shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            Actualizar
                                        </button>
                                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 bg-background-950 px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" id="closeUpdateModal">
                                            Cancelar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




    <!-- Modal para Eliminar -->
    <div class="hidden fixed z-50 inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" id="modal">
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-background-950 text-left shadow-xl transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <div class="bg-accent-950 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-yellow-600 sm:mx-0 sm:h-10 sm:w-10">
                                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-text-50" id="modal-title">
                                    Confirmar eliminación
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-text-300">
                                        ¿Estás seguro de que deseas eliminar la limpieza programada? Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-accent-950 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <form method="POST" action="limpieza/eliminar">
                            <input type="hidden" name="delete_limpieza_id" id="delete_limpieza_id">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-text-50 shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Eliminar
                            </button>
                        </form>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 bg-background-950 px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="closeModal()">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function showConfirmModal(limpiezaId) {
        document.getElementById('delete_limpieza_id').value = limpiezaId;
        document.getElementById('modal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }

    function buscarLimpieza() {
        const input = document.getElementById('search_name');
        const filter = input.value.toLowerCase();
        const estadoSelect = document.getElementById('status');
        const estado = estadoSelect.value;
        const table = document.getElementById('limpiezaTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td');
            let match = false;

            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                        match = true;
                        break;
                    }
                }
            }

            // Mostrar la fila si coincide el término de búsqueda y el estado seleccionado es "Todos" o coincide con el estado de la fila
            if (match && (estado === '0' || td[1].innerText === estadoSelect.options[estadoSelect.selectedIndex].text)) {
                tr[i].style.display = '';
            } else {
                tr[i].style.display = 'none';
            }
        }
    }
    function openUpdateModal(limpiezaId, estadoId, personalId, fecha) {
        document.getElementById('limpieza_id').value = limpiezaId;
        document.getElementById('estado').value = estadoId;
        document.getElementById('personal').value = personalId;
        document.getElementById('fecha').value = fecha;

        
        document.getElementById('updateModal').classList.remove('hidden');
    }

    document.getElementById('closeUpdateModal').addEventListener('click', function () {
        document.getElementById('updateModal').classList.add('hidden');
    });

</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<script src="/js/auth/limpieza/index.js"></script>
<?php require base_path('views/partials/end.php'); ?>

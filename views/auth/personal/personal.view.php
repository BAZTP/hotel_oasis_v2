<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Personal</h1>
    <div class="mt-3 flex-row block">
        <div class="mt-1 flex flex-row justify-between">
            <form class="flex items-center" onsubmit="return false;">
                <label class="px-2 text-m text-text-50">Buscar:</label>
                <input type="text" id="search_term" class="h-10 w-40 rounded-l-md p-2 outline-0 bg-background-900 text-text-50 sm:w-30 md:w-80" placeholder="Buscar empleado por nombre o cédula" onkeyup="buscarEmpleado()">
            </form>
            <div  class="flex gap-x-4">
                <label for="status" class="flex flex-row items-center font-semibold text-text-50 gap-x-2">Estados:
                    <select name="status" id="status" class="rounded-md inp" onchange="buscarEmpleado()">
                        <option value="0">Todos</option>
                        <?php foreach ($estado as $rows): ?>
                        <option value="<?= $rows['PERS_EST_ID'] ?>"><?= $rows['PERS_EST_DESC'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

            </div>
            <a href="/auth/personal/crear" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Añadir Personal</a>
        </div>
        <div class="w-full mt-8 flex justify-center">
            <table class="min-w-full divide-y divide-background-800" id="personalTable">
                <thead class="bg-background-900">
                    <tr>
                        <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Cédula</th>
                        <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Nombre</th>
                        <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Apellido</th>
                        <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Teléfono</th>
                        <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Email</th>
                        <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Cargo</th>
                        <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Estado</th>
                        <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-800">
                    <?php
                    // Mostrar los datos en la tabla
                    if (!empty($personal)): 
                        foreach ($personal as $row): ?>
                            <tr>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider' hidden><?= htmlspecialchars($row['PERS_ID']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_CED']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_NOM']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_APE']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_TELF']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 tracking-wider'><?= htmlspecialchars(strtolower($row['PERS_EMAIL'])) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['TIP_CAR_DES']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_EST_DESC']) ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'>
                                    <div class="flex justify-center items-center space-x-2">
                                    <form action="/auth/personal/actualizar" method="post">
                                        <input type="hidden" name="pers_id" id="pers_id" value="<?= htmlspecialchars($row['PERS_ID']) ?>">
                                        <button type="submit" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                            </svg>
                                        </button>
                                    </form>
                                        <button onclick="showConfirmModal(<?= $row['PERS_ID'] ?>)" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="7" class="px-1 py-2 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider">No resoult found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Modal para Eliminar -->
    <div class="hidden fixed inset-0 z-50 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" id="modal">
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
                                    <p class="text-sm text-text-300">
                                        ¿Estás seguro de que deseas eliminar este empleado? Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-accent-950 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <form method="POST" action="/auth/personal/eliminar">
                            <input type="hidden" name="delete_personal_id" id="delete_personal_id">
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

    
</script>
<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<script src="/js/auth/personal/personal.php.js"></script>
<?php require base_path('views/partials/end.php'); ?>

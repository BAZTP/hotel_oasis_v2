<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full relative max-w-5xl mx-auto">
        <div class="flex flex-row gap-x-2 justify-between">
            <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Crear Reserva</h1>
            <a href="/auth/reservas" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
        </div>
        <form id="form" class="mt-4 flex w-full flex-col" method="POST" action="/auth/reservas/crear">
            <div class="grid grid-cols-1 gap-2 md:grid-cols-2">
                <div class="flex flex-col">
                    <label for="initial_date" class="text-lg text-text-50">Fecha De Entrada:</label>
                    <input type="date" name="initial_date" id="initial_date" class="inp" placeholder="Fecha de Entrada" min="<?= date(
                    	'Y-m-d'
                    ) ?>" required>
                </div>
                <div class="flex flex-col">
                    <label for="final_date" class="text-lg text-text-50">Fecha De Salida:</label>
                    <input type="date" name="final_date" id="final_date" class="inp" placeholder="Fecha de Salida" min="<?= date(
                      'Y-m-d'
                    ) ?>" required>
                </div>
            </div>
            <div class="mt-2 grid grid-cols-4 gap-x-2 relative w-full">
                <label for="room" class="flex flex-col text-lg text-text-50 col-span-2 md:col-span-3">
                    <span>Habitación/Salón:</span>
                    <select name="principal_room"  id="room" class="inp appearance-none" onchange="handleSelectRoom(this)" required>
                        <option value="" selected disabled>Seleccione Una Habitación/salón</option>
                      <?php foreach ($tipo_habitaciones as $tipo_habitacion): ?>
                          <option data-cant="<?=$tipo_habitacion['cantidad']?>" value="<?= $tipo_habitacion['TIP_HAB_ID'] .
                          	'-hab' ?>">Habitación - <?= $tipo_habitacion['TIP_HAB_DES'] .
	' - Capacidad: ' .
	$tipo_habitacion['TIP_HAB_CAP'] . ' - Activas: ' . $tipo_habitacion['cantidad'] .' - Valor/Noche: '.$tipo_habitacion['total'] .' USD' ?></option>
                      <?php endforeach; ?>
                        <?php foreach ($tipo_salones as $tipo_salon): ?>
                            <option data-cant="<?=$tipo_salon['cantidad']?>" value="<?= $tipo_salon['TIP_SAL_ID'] .
                            	'-sal' ?>">Salón - <?= $tipo_salon['TIP_SAL_DES'] . ' Activos: ' . $tipo_salon['cantidad'] . ' - Valor/Noche: '.$tipo_salon['total'].' USD'?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
                <label for="number_rooms" class="relative flex flex-col text-lg text-text-50 col-span-2 md:col-span-1">
                    <span>
                        Cantidad Reservada:
                    </span>
                    <input type="number" name="principal_num_rooms" id="number_rooms" class="inp" min="1" max="" required>
                </label>

            </div>
            <div id="more_rooms" class="mt-2 grid-cols-4 gap-2 relative w-full hidden"></div>
            <button type="button" class="w-full text-text-50 bg-secondary-600 hover:bg-secondary-700 active:bg-accent-500 rounded-b-md mt-2 py-2" id="add_room">Añadir habitación +</button>
<!--            <p class="text-text-50">No se han encontrado resultados</p>-->

            <div class="flex flex-col relative w-full">
                <label for="client" class="relative flex flex-col text-lg text-text-50">
                    <span>Cliente:</span>
                    <input type="text" id="client" class="inp" placeholder="Nombre del Cliente" required>
                </label>
                <div id="search_result" class="flex flex-col bg-white rounded-md drop-shadow-md w-full mt-2 max-h-96 overflow-auto">
                </div>
            </div>
            <div id="client_select" class="hidden text-text-50 rounded-md p-2 bg-accent-950 border-2 border-accent-500">
                <input type="hidden" id="client_id" name="client_id">
                <p class="flex justify-center gap-x-4"><span class="font-semibold">Cédula: </span><span id="client_ced"></span></p>
                <p class="flex justify-center gap-x-4"><span class="font-semibold">Nombre: </span><span id="client_name"></span></p>
                <p class="flex justify-center gap-x-4"><span class="font-semibold">Número Celular: </span><span id="client_phone"></span></p>
                <button type="button" class="text-accent-500 hover:text-accent-700 active:text-accent-300" id="clear_client">Limpiar</button>
            </div>
            <button type="submit" id="submit" class="mt-2 grid h-10 w-52 place-items-center self-center rounded-md p-1 font-normal transition-colors duration-200 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">Crear Reserva</button>
        </form>
    </div>
    <!-- Modal -->
    <div class="hidden relative z-10" id="client_modal" role="dialog">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-background-950 text-left shadow-xl transition-all sm:my-8 sm:max-w-lg">
                        <form id="client_form" action="">
                            <div class="flex flex-col gap-y-2 p-4">
                                <h1 class="text-2xl font-semibold text-text-50">Registrar Cliente</h1>
                                <div class="flex flex-row gap-x-2 justify-between">
                                    <label for="cedula" class="flex flex-col text-text-50">
                                        <span>Cédula:</span>
                                        <input type="text" id="cedula" class="inp" placeholder="Cédula" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                    </label>
                                    <label for="nombre" class="flex flex-col text-text-50">
                                        <span>Nombre:</span>
                                        <input type="text" id="nombre" class="inp" placeholder="Nombre" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" required>
                                    </label>
                                </div>
                                <label for="telefono" class="flex flex-col text-text-50">
                                    <span>Número Celular:</span>
                                    <input type="text" id="telefono" class="inp" placeholder="Número Celular" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                </label>
                                <label for="email" class="flex flex-col text-text-50">
                                    <span>Email:</span>
                                    <input type="email" id="email" class="inp" placeholder="Email" required>
                                </label>
                                <label for="direccion" class="flex flex-col text-text-50">
                                    <span>Dirección:</span>
                                    <input type="text" id="direccion" class="inp" placeholder="Dirección" required>
                                </label>
                                <div class="flex flex-row gap-x-2">
                                    <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-text-50 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-text-300 active:bg-text-500 sm:mt-0 sm:w-auto" id="close_modal">Cancelar</button>
                                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-accent-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-accent-400 active:bg-accent-700 sm:ml-3 sm:w-auto">Registrar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<script src="/js/auth/reservas/crear.js"></script>
<?php require base_path('views/partials/end.php'); ?>

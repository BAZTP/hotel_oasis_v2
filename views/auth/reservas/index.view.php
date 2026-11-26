<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
	<div class="relative mx-auto w-full max-w-7xl py-8">
		<h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Reservas</h1>
		<div class="mt-4 flex flex-row justify-between gap-x-4">
			<div class="relative flex h-10 w-full max-w-sm items-center">
                <label for="search_name"></label>
				<input id="search_name" type="text" class="inp" placeholder="Buscar reservas por nombre del cliente">
<!--				<button-->
<!--					class="grid aspect-square h-full place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500">-->
<!--					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">-->
<!--						<path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />-->
<!--					</svg>-->
<!--				</button>-->
			</div>

            <label for="status" class="flex flex-row items-center font-semibold text-text-50 gap-x-2">Estados:
                <select name="status" id="status" class="rounded-md inp">
                    <option value="0">Todos</option>
                    <?php foreach ($estados as $estado): ?>
                        <option value="<?= $estado['EST_RES_ID'] ?>"><?= $estado['EST_RES_DES'] ?></option>
                    <?php endforeach; ?>
                </select>
            </label>


			<a href="/auth/reservas/crear" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Añadir Reservas +</a>
		</div>
    <?php if (count($reservas) > 0): ?>
			<div id="reservas_div" class="mt-4 grid grid-cols-1 gap-2 text-neutral-50 md:grid-cols-2 xl:grid-cols-2 2xl:grid-cols-3">
        <?php foreach ($reservas as $reserva): ?>
					<div data-name="<?=$reserva['CLI_NOM']?>" data-ced="<?=$reserva['CLI_CED']?>" class="relative flex flex-row <?=$reserva['EST_RES_ID']?> h-28 w-full justify-between rounded-md px-3 py-3 drop-shadow-md bg-background-900">
						<div class="relative flex grow">
							<div class="aspect-square h-full w-auto rounded-lg bg-accent-800">

							</div>
							<div class="relative px-2 text-text-300">
								<p class="text-lg font-semibold text-text-200"><?= $reserva[
                  'HAB_ID'
                  ] ? 'Habitación '.$reserva['HAB_ID'] : 'Salón '.$reserva['SAL_ID'] ?> | <?= $reserva['EST_RES_DES'] ?: 'No existe' ?></p>
								<p class="w-full overflow-hidden text-ellipsis whitespace-nowrap text-sm">Cliente: <?= $reserva[
                  'CLI_NOM'
                  ]
                    ? (strlen($reserva['CLI_NOM']) > 20
                      ? substr($reserva['CLI_NOM'], 0, 20) . '...'
                      : $reserva['CLI_NOM'])
                    : 'Miguel' ?></p>
								<p class="text-sm">Fecha: <?= $reserva['RES_FECH'] ?:
                    '0000-00-00' ?></p>
								<p class="text-sm"><?= $reserva['RES_FECH_INI'] ?:
                    '0000-00-00' ?> a <?= $reserva['RES_FECH_FIN'] ?: '0000-00-00' ?></p>
							</div>
							<!--                        <div class="relative px-2 text-text-300">-->
							<!--                            <p class="text-lg font-semibold text-text-200">Habitación --><?php
              //='-1'
              ?><!-- | --><?php
              //='No existe'
              ?><!--</p>-->
							<!--                            <p class="w-full overflow-hidden text-ellipsis whitespace-nowrap text-sm">Cliente: --><?php
              //='Miguel'
              ?><!--</p>-->
							<!--                            <p class="text-sm">Fecha: --><?php
              //='0000-00-00'
              ?><!--</p>-->
							<!--                            <p class="text-sm">--><?php
              //='0000-00-00'
              ?><!-- a --><?php
              //='0000-00-00'
              ?><!--</p>-->
							<!--                        </div>-->
						</div>
                        <?php switch ($reserva['EST_RES_ID']){
                            case 1:
                                ?>
                                <div class="flex flex-col justify-between">
                                    <form action="reservas/check-in" method="post">
                                        <input type="hidden" name="reserva_id" value="<?= $reserva['RES_ID'] ?>">
                                        <button type="submit" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path fill-rule="evenodd" d="M9 1.5H5.625c-1.036 0-1.875.84-1.875 1.875v17.25c0 1.035.84 1.875 1.875 1.875h12.75c1.035 0 1.875-.84 1.875-1.875V12.75A3.75 3.75 0 0 0 16.5 9h-1.875a1.875 1.875 0 0 1-1.875-1.875V5.25A3.75 3.75 0 0 0 9 1.5Zm6.61 10.936a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 14.47a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                                <path d="M12.971 1.816A5.23 5.23 0 0 1 14.25 5.25v1.875c0 .207.168.375.375.375H16.5a5.23 5.23 0 0 1 3.434 1.279 9.768 9.768 0 0 0-6.963-6.963Z" />
                                            </svg>
                                        </button>
                                    </form>

                                    <button onclick="handleDelete(<?=$reserva['RES_ID']?>)" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                        <?php break;
                            case 2:
                                ?>
                                <div class="flex justify-center">
                                    <form action="reservas/check-out" method="post">
                                        <input type="hidden" name="reserva_id" value="<?= $reserva['RES_ID'] ?>">
                                        <button type="submit" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                        <?php break;

                        }?>
              </div>
        <?php endforeach; ?>
			</div>
    <?php else: ?>
			<p class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-4xl font-semibold text-text-200">No hay reservas</p>
    <?php endif; ?>
	</div>
    <!-- Este es el primer intento de modal-->
    <div class="hidden relative z-10" id="modal" role="dialog">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-background-950 text-left shadow-xl transition-all sm:my-8 sm:max-w-lg">
                        <div class="bg-accent-950 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-yellow-600 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-text-50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                    <h3 class="text-base font-semibold leading-6 text-text-50" id="modal-title">¿Deseas Cancelar La Reserva?</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-text-200">¿Estás seguro que quieres cancelar la reserva? Este proceso no se podrá revertir.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-background-950 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <form action="reservas/eliminar" method="get">
                                <input type="hidden" name="delete_reserva_id" id="delete_reserva_id">
                                <button type="submit" id="btnCancel" class="inline-flex w-full justify-center rounded-md bg-accent-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-accent-400 active:bg-accent-700 sm:ml-3 sm:w-auto">Entiendo</button>
                            </form>
                            <button type="button" id="btnClose" class="mt-3 inline-flex w-full justify-center rounded-md bg-text-50 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-text-300 active:bg-text-500 sm:mt-0 sm:w-auto">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<script src="/js/auth/reservas/index.js"></script>
<?php require base_path('views/partials/end.php'); ?>

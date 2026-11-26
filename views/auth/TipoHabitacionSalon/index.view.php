<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="relative mx-auto w-full max-w-7xl py-8">
        <h1 class="text-3xl font-bold text-white">Tipo de Habitaciones/Salones</h1>
        <div class="flex justify-between items-center">
            <div class="w-full mt-8 flex flex-col justify-center table-container">
                <h2 class="text-xl font-semibold text-text-50">Habitaciones</h2>
                <table class="min-w-full divide-y divide-background-800">
                    <thead class="bg-background-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">N°</th>
                            <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">Descripción</th>
                            <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-background-950 divide-y divide-background-800">
                        <?php if (!empty($habitaciones)):
                          foreach ($habitaciones as $row):?>
                            <tr>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= $row['TIP_HAB_ID']?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= $row['TIP_HAB_DES'] ?></td>
                                <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'>
                                    <div class="flex justify-center items-center space-x-2">
                                        <button onclick="handleUpdateModal(<?= $row['TIP_HAB_ID']?>, 0)" class="grid h-10 w-fit px-2 place-items-center rounded-md bg-accent-800 mx-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach;
                          else:?>
                              <tr>
                                  <td colspan="5" class='px-1 py-2 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'>Vacio</td>
                              </tr>
                        <?php endif;?>
                    </tbody>
                </table>
                <h2 class="text-xl font-semibold text-text-50 mt-2">Salones</h2>
                <table class="min-w-full divide-y divide-background-800">
                    <thead class="bg-background-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">N°</th>
                        <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">Descripción</th>
                        <th scope="col" class="px-6 py-3 text-xs text-text-200 uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="bg-background-950 divide-y divide-background-800">
                        <?php if (!empty($salones)):
                          foreach ($salones as $row):?>
                              <tr>
                                  <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= $row['TIP_SAL_ID']?></td>
                                  <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'><?= $row['TIP_SAL_DES'] ?></td>
                                  <td class='px-1 py-1 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'>
                                      <div class="flex justify-center items-center space-x-2">
                                          <button onclick="handleUpdateModal(<?= $row['TIP_SAL_ID']?>, 1)" class="grid h-10 w-fit px-2 place-items-center rounded-md bg-accent-800 act mx-2">
                                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                                  <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                                  <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                              </svg>
                                          </button>
                                      </div>
                                  </td>
                              </tr>
                          <?php endforeach;
                        else:?>
                            <tr>
                                <td colspan="5" class='px-1 py-2 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'>Vacio</td>
                            </tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="hidden relative z-10" id="modal" role="dialog">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true">
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-background-950 text-left shadow-xl transition-all sm:my-8 sm:max-w-lg">
                        <form id="form">
                            <div class="bg-accent-950 px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:flex-col sm:items-start" id="modal_main">
                                </div>
                            </div>
                            <div class="bg-background-950 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <button type="submit" id="btnSubmit" class="inline-flex w-full justify-center rounded-md bg-accent-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-accent-400 active:bg-accent-700 sm:ml-3 sm:w-auto">Guardar</button>
                                <button type="button" id="btnClose" class="mt-3 inline-flex w-full justify-center rounded-md bg-text-50 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-text-300 active:bg-text-500 sm:mt-0 sm:w-auto">Cerrar</button>
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
<script src="/js/auth/TipoHabitacionSalon.js"></script>
<?php require base_path('views/partials/end.php'); ?>

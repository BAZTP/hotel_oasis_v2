<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
<div class="w-full max-w-6xl mx-auto">
<h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Evaluación Empleado</h1>
  <div class="mt-4 flex flex-row justify-between gap-x-4">
    <form class="relative flex h-10 w-full max-w-sm items-center">
      <input id="search_term" type="text" class="inp" placeholder="Buscar Inventario" onkeyup="buscarEmpleado()">
    </form>
    <div class="flex gap-x-4">
      <a href="/auth/evaluacion/evaluar" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Evaluar Empleado</a>
    </div>
  </div>
  

  <div class="w-full mt-8 flex justify-center table-container">
    <table class="min-w-full divide-y divide-background-800" id="personalTable">
      <thead class="bg-background-900">
        <tr>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center hidden">Id</th>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Id</th>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Cédula</th>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Nombre</th>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Apellido</th>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Cargo</th>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Fecha de Evaluación</th>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Nota</th>
          <th scope="col"class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Acciones</th>
        </tr>
      </thead>
      <tbody class="bg-background-950 divide-y divide-background-800">
        <?php if (!empty($evaluacion)): ?>
          <?php foreach ($evaluacion as $row): ?>
            <tr>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider hidden'><?= htmlspecialchars($row['EVA_ID']) ?></td>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_ID']) ?></td>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['EVA_CED_EMPL']) ?></td>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['EVA_NOM_EMPL']) ?></td>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['EVA_APE_EMPL']) ?></td>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['EVA_CAR_EMPL']) ?></td>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['EVA_FECH_EVA']) ?></td>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['EVA_DESEMPENO_EMPL']) ?></td>
              <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'>
                <div class="flex justify-center items-center space-x-2">
                  <button onclick="openUpdateModal('<?= $row['EVA_ID'] ?>', '<?= $row['PERS_ID'] ?>', '<?= $row['EVA_CED_EMPL'] ?>', '<?= $row['EVA_NOM_EMPL'] ?>', '<?= $row['EVA_APE_EMPL'] ?>', '<?= $row['EVA_CAR_EMPL'] ?>', '<?= $row['EVA_FECH_EVA'] ?>', '<?= $row['EVA_DESEMPENO_EMPL'] ?>')" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800 mx-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                      <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                      <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                    </svg>
                  </button>
                  <button onclick="showConfirmModal('<?= $row['EVA_ID'] ?>')" class="grid h-10 w-10 place-items-center rounded-md bg-accent-800">
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
            <td colspan="5" class='px-1 py-2 whitespace-nowrap  text-center text-text-200 uppercase tracking-wider'>No results found</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Update Modal -->
	<div id="updateModal" class="hidden fixed z-50 inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
    <div class="fixed inset-0 z-10 flex items-center justify-center">
      <div class="bg-background-950 rounded-lg overflow-hidden shadow-xl w-full max-w-md">
        <div class="p-4">
          <h3 class="text-lg font-medium leading-6 text-text-50">Actualizar Evaluación</h3>
          <form id="updateForm" method="POST" onsubmit="return employed_evaluate_update(event)" action="/auth/evaluacion/actualizar" class="mt-4">
              <div class="mt-1 flex flex-col" style="display: none;">
                  <label class="block text-m text-text-50">Id Eva:</label>
                  <input type="text" id="updateIdEva" name="updateIdEva" class="inp" placeholder="Cédula del Empleado">
              </div>
              <div class="mt-1 flex flex-col" style="display: none;">
                  <label class="block text-m text-text-50">Id Pers:</label>
                  <input type="text" id="updateId" name="updateId" class="inp" placeholder="Cédula del Empleado">
              </div>
              <div class="mt-1 flex flex-col">
                  <label class="block text-m text-text-50">Cédula:</label>
                  <input type="text" id="updateCedula" name="updateCedula" class="inp" placeholder="Cédula del Empleado" readOnly>
              </div>
              <div class="mt-1 flex flex-col">
                  <label class="block text-m text-text-50">Nombre:</label>
                  <input type="text" id="updateNombre" name="updateNombre" class="inp" placeholder="Nombre del Empleado" readOnly>
              </div>
              <div class="mt-1 flex flex-col">
                  <label class="block text-m text-text-50">Apellido:</label>
                  <input type="text" id="updateApellido" name="updateApellido" class="inp" placeholder="Apellido del Empleado" readOnly>
              </div>
              <div class="mt-1 flex flex-col">
                  <label class="block text-m text-text-50">Cargo:</label>
                  <input type="text" id="updateCargo" name="updateCargo" class="inp" placeholder="Cargo del Empleado" readOnly>
              </div>
              <div class="flex flex-col">
                  <label for="updateFechaEva" class="text-lg text-text-50">Fecha De Entrada:</label>
                  <input type="date" name="updateFechaEva" id="updateFechaEva" class="inp" placeholder="Fecha de Entrada" value="<?= date(
                      'Y-m-d'
                  ) ?>" readOnly>
              </div>
              <div class="mt-1 flex flex-col">
                  <label for="updateEva" class="block text-m text-text-50">Evaluación:</label>
                  <input type="number" min="0" max="10" step="0.01" id="updateEva" name="updateEva" class="inp" placeholder="Evaluación del Empleado">
              </div>
              <div class="bg-accent-950 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 justify-center">
                <button id="actualizar" type="submit" class="w-full inline-flex justify-center rounded-md border  bg-green-600 border-gray-300 px-4 py-2 text-base font-medium text-text-50 shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                  Actualizar
                </button>
                <button onclick="closeModal()" type="button" id="closeUpdateModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 text-text-50 bg-red-600 px-4 py-2 text-base font-medium shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                  Cancelar
                </button>
              </div>
          </form>
        </div>
      </div>
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
										¿Estás seguro de que deseas eliminar esta evaluación? Esta acción no se puede deshacer.
									</p>
								</div>
							</div>
						</div>
					</div>
					<div class="bg-accent-950 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
						<form method="POST" action="/auth/evaluacion/eliminar">
							<input type="hidden" name="delete_evluacion_id" id="delete_evluacion_id">
							<button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-text-50 shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
								Eliminar
							</button>
						</form>
						<button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 bg-background-950 px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm" onclick="closeModalDelete()">
							Cancelar
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<script src="/js/auth/evaluar/index.js"></script>
<?php require base_path('views/partials/end.php'); ?>

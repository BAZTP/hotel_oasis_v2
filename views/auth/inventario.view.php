<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
  <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Inventario General</h1>
  <div class="w-full mt-8 flex justify-center">
    <button onclick="openCreateModal()" class="mb-4 px-4 py-2 bg-secondary-800 text-white rounded-md">Crear Nuevo Producto</button>
  </div>
  <div class="w-full mt-8 flex justify-center">
    <table class="w-3/4 bg-white rounded-lg shadow overflow-hidden">
      <thead>
        <tr>
          <th class="py-2 px-4 bg-gray-200 text-center">ID</th>
          <th class="py-2 px-4 bg-gray-200 text-center">Nombre</th>
          <th class="py-2 px-4 bg-gray-200 text-center">Cantidad</th>
          <th class="py-2 px-4 bg-gray-200 text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($reservas)): ?>
          <?php foreach ($reservas as $row): ?>
            <tr>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['INV_GEN_ID']) ?></td>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['INV_GEN_DES']) ?></td>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['INV_GEN_CANT']) ?></td>
              <td class='py-2 px-4 border-b text-center'>
              <div class="flex justify-center">
                <button onclick="openUpdateModal('<?= htmlspecialchars($row['INV_GEN_ID']) ?>', '<?= htmlspecialchars($row['INV_GEN_DES']) ?>', '<?= htmlspecialchars($row['INV_GEN_CANT']) ?>')" class="grid h-10 place-items-center rounded-md p-1 font-normal transition-colors duration-200 w-30 bg-secondary-800 text-m text-text-50 hover:bg-secondary-700 active:bg-accent-500">Actualizar</button>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="py-2 px-4 border-b text-center">No results found</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <div id="updateModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="modal-dialog" role="document">
      <div class="modal-content relative bg-white rounded-lg shadow-lg p-8">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10">
          <h2 class="text-2xl font-semibold mb-4">Actualizar Inventario</h2>
          <form method="PUT">
            <input type="hidden" name="id" id="modalId">
            <div class="mb-4">
              <label for="modalDescripcion" class="block font-medium">Descripción:</label>
              <input type="text" name="descripcion" id="modalDescripcion" class="w-full border-gray-300 rounded-md p-2">
            </div>
            <div class="mb-4">
              <label for="modalCantidad" class="block font-medium">Cantidad:</label>
              <input type="number" name="cantidad" id="modalCantidad" class="w-full border-gray-300 rounded-md p-2">
            </div>
            <div class="flex justify-end">
              <button type="submit" class="px-4 py-2 bg-secondary-800 text-white rounded-md">Actualizar</button>
              <button type="button" id="closeUpdateModal" class="px-4 py-2 bg-secondary-800 text-white rounded-md ml-4">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="createModal" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="modal-dialog" role="document">
      <div class="modal-content relative bg-white rounded-lg shadow-lg p-8">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10">
          <h2 class="text-2xl font-semibold mb-4">Crear Nuevo Producto</h2>
          <form method="POST" action="create_product.php"> 
            <div class="mb-4">
              <label for="createDescripcion" class="block font-medium">Descripción:</label>
              <input type="text" name="descripcion" id="createDescripcion" class="w-full border-gray-300 rounded-md p-2">
            </div>
            <div class="mb-4">
              <label for="createCantidad" class="block font-medium">Cantidad:</label>
              <input type="number" name="cantidad" id="createCantidad" class="w-full border-gray-300 rounded-md p-2">
            </div>
            <div class="flex justify-end">
              <button type="submit" class="px-4 py-2 bg-secondary-800 text-white rounded-md">Crear</button>
              <button type="button" id="closeCreateModal" class="px-4 py-2 bg-secondary-800 text-white rounded-md ml-4">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

<script>
  function openUpdateModal(id, descripcion, cantidad) {
    document.getElementById('modalId').value = id;
    document.getElementById('modalDescripcion').value = descripcion;
    document.getElementById('modalCantidad').value = cantidad;
    document.getElementById('updateModal').classList.remove('hidden');
  }

  document.getElementById('closeUpdateModal').addEventListener('click', function() {
    document.getElementById('updateModal').classList.add('hidden');
  });

  function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
  }

  document.getElementById('closeCreateModal').addEventListener('click', function() {
    document.getElementById('createModal').classList.add('hidden');
  });
</script>

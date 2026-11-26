<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

  <main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
  <div class="w-full mt-8 flex justify-center">
  <a href="/auth/inventario/actualizar" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Añadir Inventario +</a>
  </div>
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
  </main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-white">Limpieza</h1>
       
    </div>
    <div class="w-full mt-8 flex justify-center">
  <a href="/auth/limpieza/crear" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Crear Limpieza +</a>
  </div>
    <div  class="w-full mt-8 flex justify-center">
    <table  class="w-3/4 bg-white rounded-lg shadow overflow-hidden">
            <thead>
                <tr>
                    <th class="py-2 px-4 bg-gray-200 text-center">ID LIMP PROG</th>
                    <th class="py-2 px-4 bg-gray-200 text-center">ID Habitacion</th>
                    <th class="py-2 px-4 bg-gray-200 text-center">Estado Limpieza programada ID</th>
                    <th class="py-2 px-4 bg-gray-200 text-center">Persona ID</th>
                    <th class="py-2 px-4 bg-gray-200 text-center">Limpieza detalle</th>
                    <th class="py-2 px-4 bg-gray-200 text-center">Limpieza fecha</th>
                </tr>
            </thead>
            <tbody>
        <?php if (!empty($limpieza)): ?>
          <?php foreach ($limpieza as $row): ?>
            <tr>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['LIM_PROG_ID']) ?></td>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['HAB_ID']) ?></td>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['EST_LIM_PROG_DET']) ?></td>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['PERS_ID']) ?></td>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['LIM_PROG_DET']) ?></td>
              <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['LIM_PROG_FECH']) ?></td>

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
</main>
<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

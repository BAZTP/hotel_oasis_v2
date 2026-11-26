<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
  <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Instalaciones</h1>
  <div class="w-full mt-8 flex justify-center">
  <table class="w-3/4 bg-white rounded-lg shadow overflow-hidden ">
    <thead>
      <tr>
        <th class="py-2 px-4 bg-gray-200">ID</th>
        <th class="py-2 px-4 bg-gray-200">Descripción</th>
        <th class="py-2 px-4 bg-gray-200">Estado</th>
        <th class="py-2 px-4 bg-gray-200">Hora Inicio</th>
        <th class="py-2 px-4 bg-gray-200">Hora Fin</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($reservas > 0)): ?>
        <?php foreach ($reservas as $row): ?>
          <tr>
            <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['INS_ID']) ?></td>
            <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['TIP_INS_DES']) ?></td>
            <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['EST_INS_DES']) ?></td>
            <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['INS_HOR_INI']) ?></td>
            <td class='py-2 px-4 border-b text-center'><?= htmlspecialchars($row['INS_HOR_FIN']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="py-2 px-4 border-b text-center">No results found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
  </div>
</main>

<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>
<?php require base_path('views/partials/routes_aside.php'); ?>
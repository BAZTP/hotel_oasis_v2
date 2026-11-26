<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Roles de Pago</h1>
    <div class="mt-3 flex-row block">
        <div class="mt-1 flex flex-row justify-between">
        <form class="flex items-center" onsubmit="return false;">
                <label class="px-2 text-m text-text-50">Buscar:</label>
                <input type="text" id="search_term" class="h-10 w-40 rounded-l-md p-2 outline-0 bg-background-900 text-text-50 sm:w-30 md:w-80" placeholder="Buscar empleado por nombre o cédula" onkeyup="buscarEmpleado()">
                <button class="grid h-10 w-10 place-items-center rounded-r-md transition-colors duration-200 bg-secondary-800 hover:bg-secondary-700 active:bg-accent-500">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-50">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </form>
        </div>
        <div class="w-full mt-8 flex justify-center">
            <table class="min-w-full divide-y divide-background-800" id="personalTable">
                <thead class="bg-background-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Cédula</th>
                        <th class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Apellido</th>
                        <th class="px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-800">
                    <?php
                    // Mostrar los datos en la tabla
                    if (!empty($personal)): 
                        foreach ($personal as $row): ?>
                            <tr>
                                <td class='px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center'><?= htmlspecialchars($row['PERS_CED']) ?></td>
                                <td class='px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center'><?= htmlspecialchars($row['PERS_NOM']) ?></td>
                                <td class='px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center'><?= htmlspecialchars($row['PERS_APE']) ?></td>
                                <td class='px-6 py-3 text-left text-xs  text-text-200 uppercase tracking-wider text-center'>
                                    <a href="/auth/roles/crear?PERS_ID=<?= $row['PERS_ID'] ?>" class="px-4 py-2 bg-secondary-800 text-white rounded-md">Ver Rol de Pagos</a>
                                </td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="4" class="py-2 px-4 border-b text-center">No se encontraron resultados</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
function buscarEmpleado() {
    const input = document.getElementById('search_term');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('employeeTable');
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

        if (match) {
            tr[i].style.display = '';
        } else {
            tr[i].style.display = 'none';
        }
    }
}
</script>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php if(isset($success)):?>
    <script src="/js/alertas/validacion_cedula/alertCedulaCorrecta.js"></script>
    <script src="/js/auth/personal/roles.js"></script>
<?php endif; ?>
<?php require base_path('views/partials/end.php'); ?>

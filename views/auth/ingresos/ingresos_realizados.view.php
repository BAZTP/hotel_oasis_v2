<?php require base_path('views/partials/head.php'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Ingresos Realizados</h1>

        <!-- Formulario de búsqueda -->
        <form action="/auth/ingresos/ingresos_realizados" method="GET" class="mt-6 mb-8">
            <label for="search" class="block text-lg text-text-50">Buscar por Tipo de Ingreso, Descripción o Cédula:</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" id="search" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Buscar por Tipo de Ingreso, Descripción o Cédula" class="focus:ring-accent-500 focus:border-accent-500 flex-1 block w-full rounded-md text-lg border-gray-300">
            </div>

            <label for="filter" class="block text-lg text-text-50 mt-4">Filtrar por:</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <select id="filter" name="filter" class="focus:ring-accent-500 focus:border-accent-500 flex-1 block w-1/3 rounded-md text-lg border-gray-300">
                    <option value="all" <?= $filter == 'all' ? 'selected' : '' ?>>Todos</option>
                    <option value="day" <?= $filter == 'day' ? 'selected' : '' ?>>Día</option>
                    <option value="month" <?= $filter == 'month' ? 'selected' : '' ?>>Mes</option>
                    <option value="year" <?= $filter == 'year' ? 'selected' : '' ?>>Año</option>
                </select>
                <input type="date" id="date" name="date" value="<?= htmlspecialchars($date) ?>" class="focus:ring-accent-500 focus:border-accent-500 flex-1 block w-1/3 rounded-md text-lg border-gray-300 ml-2" <?= $filter == 'all' ? 'disabled' : '' ?>>
            </div>

            <div class="mt-4 flex justify-end">
                <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-lg font-medium text-text-50 bg-secondary-800 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 sm:text-lg">
                    Buscar
                </button>
            </div>
        </form>

        <!-- Tabla de ingresos -->
        <div class="overflow-hidden border-b border-background-800 rounded-lg">
            <table class="min-w-full divide-y divide-background-800">
                <thead class="bg-background-900">
                    <tr>
                        <th scope="col" class="px-2 py-3 text-lg text-center text-text-50">
                            Tipo de Ingreso
                        </th>
                        <th scope="col" class="px-2 py-3 text-lg text-center text-text-50">
                            Descripción
                        </th>
                        <th scope="col" class="px-2 py-3 text-lg text-center text-text-50">
                            Monto
                        </th>
                        <th scope="col" class="px-2 py-3 text-lg text-center text-text-50">
                            Fecha de Ingreso
                        </th>
                        <th scope="col" class="px-2 py-3 text-lg text-center text-text-50">
                            Cédula
                        </th>
                        <th scope="col" class="px-2 py-3 text-lg text-center text-text-50">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-800">
                    <?php if (!empty($ingresos)): ?>
                        <?php foreach ($ingresos as $ingreso): ?>
                            <tr>
                                <td class="px-2 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= htmlspecialchars($ingreso['TIPO_INGRESO']) ?>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= htmlspecialchars($ingreso['DESCRIPCION']) ?>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    $<?= htmlspecialchars(number_format($ingreso['MONTO'], 2)) ?>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= htmlspecialchars($ingreso['FECHA_INGRESO']) ?>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= htmlspecialchars($ingreso['CEDULA']) ?>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap text-lg text-text-50 text-center flex justify-center gap-4">
                                    <a href="/auth/ingresos/editar/<?= $ingreso['ID'] ?>" class="text-accent-500 hover:text-accent-700">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </a>
                                    <a href="/auth/ingresos/eliminar/<?= $ingreso['ID'] ?>" class="text-accent-500 hover:text-accent-700" onclick="return confirm('¿Está seguro que desea eliminar este ingreso?')">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                    <a href="/auth/ingresos/imprimir/<?= $ingreso['ID'] ?>" class="text-accent-500 hover:text-accent-700">
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr id="detalle-<?= $ingreso['ID'] ?>" class="hidden">
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-lg text-text-50 bg-background-800">
                                    <strong>Detalles del Ingreso:</strong>
                                    <p>Cédula: <?= htmlspecialchars($ingreso['CEDULA']) ?></p>
                                    <p>Descripción: <?= htmlspecialchars($ingreso['DESCRIPCION']) ?></p>
                                    <p>Monto: $<?= htmlspecialchars(number_format($ingreso['MONTO'], 2)) ?></p>
                                    <p>Fecha de Ingreso: <?= htmlspecialchars($ingreso['FECHA_INGRESO']) ?></p>
                                    <p>Tipo de Ingreso: <?= htmlspecialchars($ingreso['TIPO_INGRESO']) ?></p>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                No se encontraron ingresos.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Contenedor para el gráfico -->
        <div class="mt-6 mb-8">
            <canvas id="ingresosChart"></canvas>
        </div>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('ingresosChart').getContext('2d');
        const reportData = <?= json_encode($ingresos) ?>;
        const labels = reportData.map(item => item.TIPO_INGRESO);
        const data = reportData.map(item => item.MONTO);

        const ingresosChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Ingresos',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });

    function mostrarDetalles(id) {
        const detalle = document.getElementById(id);
        detalle.classList.toggle('hidden');
    }

    document.getElementById('filter').addEventListener('change', function() {
        const dateInput = document.getElementById('date');
        if (this.value === 'all') {
            dateInput.disabled = true;
            dateInput.value = '';
        } else {
            dateInput.disabled = false;
        }
    });
</script>

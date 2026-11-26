<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Egresos Totales</h1>

        <div class="mt-8">
            
            <!-- Formulario de búsqueda por tipo de egreso y fecha actual -->
            <form action="/auth/egresos/egresos_totales" method="GET" class="mt-6 mb-8">
                <label for="search" class="block text-lg text-text-50">Buscar por Tipo de Egreso:</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input type="text" id="search" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" placeholder="Buscar por Tipo de Egreso" class="focus:ring-accent-500 focus:border-accent-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                    <input type="hidden" name="current_date" value="<?= date('Y-m-d') ?>">
                    <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-text-50 bg-secondary-800 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 sm:ml-3 sm:text-sm">
                        Buscar
                    </button>
                </div>
            </form>

            <!-- Tabla de egresos -->
            <div class="overflow-hidden border-b border-background-800 rounded-lg">
                <table class="min-w-full divide-y divide-background-800">
                    <thead class="bg-background-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">
                                TIPO DE EGRESO
                            </th>
                            <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">
                                FECHA ACTUAL
                            </th>
                            <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">
                                TOTAL EGRESOS
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-background-950 divide-y divide-background-800">
                        <?php foreach ($reportData as $item): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= htmlspecialchars($item['tipo_egreso']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= htmlspecialchars($item['fecha']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= number_format($item['total_egreso'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- Fila para la suma total -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center font-bold" colspan="2">
                                Total General
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center font-bold">
                                <?= number_format($totalEgreso, 2) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Formulario de reportes -->
            <form id="reportForm" action="/auth/egresos/egresos_totales/reportes" method="GET" class="mt-6 mb-8">
                <h2 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Generar Reportes</h2>
                <label for="start_date" class="block text-lg text-text-50">Desde:</label>
                <input type="date" id="start_date" name="start_date" value="<?= isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : '' ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-accent-500 focus:border-accent-500 sm:text-sm">
                
                <label for="end_date" class="block text-lg text-text-50 mt-4">Hasta:</label>
                <input type="date" id="end_date" name="end_date" value="<?= isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : '' ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-accent-500 focus:border-accent-500 sm:text-sm">
                
                <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-text-50 bg-secondary-800 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 sm:ml-3 sm:text-sm">
                    Generar
                </button>
            </form>

            <!-- Contenedor para el gráfico -->
            <div class="mt-6 mb-8">
                <canvas id="egresosChart"></canvas>
            </div>
        </div>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

<!-- Script para generar el gráfico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('egresosChart').getContext('2d');
        const reportData = <?= json_encode($reportData) ?>;
        const labels = reportData.map(item => item.tipo_egreso);
        const data = reportData.map(item => item.total_egreso);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total de Egresos',
                    data: data,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return 'Total: ' + tooltipItem.raw.toLocaleString('es-ES', { style: 'currency', currency: 'USD' });
                            }
                        }
                    }
                }
            }
        });
    });
</script>

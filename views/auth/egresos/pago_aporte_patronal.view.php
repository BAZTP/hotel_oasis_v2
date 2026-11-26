<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Aportes Patronales Realizados</h1>

        <!-- Formulario de búsqueda -->
        <form action="/auth/egresos/pago_aporte_patronal" method="GET" class="mt-6 mb-8">
            <label for="search" class="block text-lg text-text-50">Buscar por Nombre o Apellido:</label>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" id="search" name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" class="focus:ring-accent-500 focus:border-accent-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300">
                <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-text-50 bg-secondary-800 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 sm:ml-3 sm:text-sm">
                    Buscar
                </button>
            </div>
        </form>

        <!-- Tabla de pagos -->
        <div class="overflow-hidden border-b border-background-800 rounded-lg">
            <table class="min-w-full divide-y divide-background-800">
                <thead class="bg-background-900">
                <tr>
                        <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">
                            NOMBRE
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">
                            APELLIDO
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">
                            CÉDULA
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">
                            APORTE PATRONAL
                        </th>
                        <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">
                            FECHA DE PAGO
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-800">
                    <?php foreach ($pagos as $pago): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center"><?= htmlspecialchars($pago['PERS_NOM']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center"><?= htmlspecialchars($pago['PERS_APE']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center"><?= htmlspecialchars($pago['PERS_CED']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center"><?= htmlspecialchars($pago['APOR_CANTIDAD']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center"><?= htmlspecialchars($pago['FECHA_PAGO']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulario de reportes -->
        <form id="reportForm" action="/auth/egresos/pago_patronal_reportes" method="GET" class="mt-6 mb-8">
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
            <canvas id="aportesChart"></canvas>
        </div>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

<!-- Script para generar el gráfico y manejar la actualización -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('aportesChart').getContext('2d');
    let aportesChart = null;

    function fetchChartData() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const searchTerm = document.getElementById('search').value;

        const query = new URLSearchParams({
            start_date: startDate,
            end_date: endDate,
            search: searchTerm,
            ajax: true
        });

        fetch(`/auth/egresos/pago_aporte_patronal?${query.toString()}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.aggregateData.map(item => item.month);
                const chartData = data.aggregateData.map(item => item.total_aportes);

                if (aportesChart) {
                    aportesChart.data.labels = labels;
                    aportesChart.data.datasets[0].data = chartData;
                    aportesChart.update();
                } else {
                    aportesChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Total Aportes Patronales',
                                data: chartData,
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                borderColor: 'rgba(255, 99, 132, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    beginAtZero: true
                                },
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
    }

    // Inicializa el gráfico con datos por defecto
    fetchChartData();

    // Maneja el envío del formulario de reportes
    document.getElementById('reportForm').addEventListener('submit', function (event) {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (!startDate || !endDate) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Fecha requerida',
                text: 'Por favor, seleccione un rango de fechas.',
            });
            return;
        }

        if (new Date(startDate) > new Date(endDate)) {
            event.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Rango de fechas inválido',
                text: 'La fecha de inicio no puede ser posterior a la fecha de fin.',
            });
        } else {
            fetchChartData();
        }
    });

    // Maneja la búsqueda en el formulario de búsqueda
    document.getElementById('search').addEventListener('input', fetchChartData);
});
</script>

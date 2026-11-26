<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <div class="w-full max-w-5xl mx-auto">
        <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Reporte de Egresos Totales</h1>
        <div class="mt-4 flex flex-row justify-between gap-x-4">
            <div class="flex gap-x-7">
                <a href="/auth/egresos/egresos_totales" class="flex items-center justify-center rounded-md px-4 text-center transition-colors duration-200 py-1.5 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500">Regresar</a>
            </div>
        </div>

        <form id="reportForm" action="/auth/egresos/egresos_totales/reportes" method="GET" class="mt-6 mb-8">
            <div class="mb-4">
                <label for="start_date" class="block text-lg text-text-50">Desde:</label>
                <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($startDate ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-accent-500 focus:border-accent-500 sm:text-sm" required>
            </div>
            <div>
                <label for="end_date" class="block text-lg text-text-50">Hasta:</label>
                <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($endDate ?? '') ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-accent-500 focus:border-accent-500 sm:text-sm" required>
            </div>
            <button type="submit" class="ml-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-text-50 bg-secondary-800 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 sm:ml-3 sm:text-sm mt-4">
                Generar Reporte
            </button>
        </form>

        <!-- Botón para descargar en Excel -->
        <?php if (!empty($reportData)): ?>
            <form action="/auth/egresos/egresos_totales_descargar" method="GET" class="mb-4">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-text-50 bg-secondary-800 hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 sm:text-sm">
                    Descargar en Excel
                </button>
            </form>
        <?php endif; ?>

        <!-- Mensaje cuando no hay datos -->
        <?php if (empty($reportData) && empty($error)): ?>
            <div class="text-center text-lg text-text-50">No hay egresos disponibles para el rango de fechas seleccionado.</div>
        <?php endif; ?>

        <!-- Mensaje de error -->
        <?php if (!empty($error)): ?>
            <div class="text-center text-lg text-red-500"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Nueva Tabla para Datos Agregados -->
        <?php if (!empty($aggregateData)): ?>
            <div class="mt-8 overflow-hidden border-b border-background-800 rounded-lg">
                <h2 class="text-2xl font-semibold text-text-50 mb-4">Reportes de Egresos Totales</h2>
                <table class="min-w-full divide-y divide-background-800">
                    <thead class="bg-background-900">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">Tipo de Egreso</th>
                            <th scope="col" class="px-6 py-3 text-lg text-center text-text-50">Monto Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-background-950 divide-y divide-background-800">
                        <?php foreach ($aggregateData as $data): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= htmlspecialchars($data['tipo_egreso']) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center">
                                    <?= number_format($data['total_egreso'], 2, ',', '.') ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <!-- Fila para la suma total -->
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center font-bold" colspan="1">
                                Total General
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-lg text-text-50 text-center font-bold">
                                <?= number_format($totalAmount, 2, ',', '.') ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Contenedor para el gráfico -->
        <?php if (!empty($aggregateData)): ?>
            <div class="mt-6 mb-8">
                <canvas id="egresosChart"></canvas>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

<!-- Script para generar el gráfico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('egresosChart').getContext('2d');
    const aggregateData = <?= json_encode($aggregateData ?? []) ?>;
    const labels = aggregateData.map(item => item.tipo_egreso);
    const data = aggregateData.map(item => item.total_egreso);

    let egresosChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Egresos por Tipo',
                data: data,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
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

    // Validación del formulario de generación de reportes
    const reportForm = document.getElementById('reportForm');
    reportForm.addEventListener('submit', function (event) {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (!startDate || !endDate) {
            event.preventDefault(); // Evita el envío del formulario

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Por favor ingrese ambas fechas para generar el reporte.',
            });
        } else if (startDate > endDate) {
            event.preventDefault(); // Evita el envío del formulario

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'La fecha de inicio debe ser menor o igual a la fecha de fin.',
            });
        }
    });
});
</script>

<?php
require base_path('views/partials/head.php');
require base_path('views/partials/auth_header.php');


if (empty($result)) {
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            Swal.fire({
                icon: "error",
                title: "No se encontraron datos",
                text: "No hay registros en el rango de fechas proporcionado."
            }).then(() => {
                window.history.back();
            });
        });
    </script>';
    require base_path('views/partials/end.php');
    exit;
}
?>
<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
   <!-- Filtro por Mes y Año -->
   <form method="GET" class="mb-8">
        <input type="hidden" name="PERS_ID" value="<?php echo htmlspecialchars($attributes['pers_id']); ?>">
        <button type="button" onclick="showRangeForm()" class="bg-accent-800 text-white py-2 px-4 rounded ml-4">Imprimir por Rango</button>
        <a href="/auth/roles" class="bg-accent-800 text-white py-2 px-4 rounded ml-4">Regresar</a>
    </form>
    <div id="rangeForm" style="display: none;" class="mb-8">
        <form method="GET" onsubmit="return validateDates(event)">
            <input type="hidden" name="PERS_ID" value="<?php echo htmlspecialchars($attributes['pers_id']); ?>">
            <!-- Rango de Fechas -->
            <label for="start_month" class="mr-2 text-white">Mes de inicio:</label>
            <select name="start_month" id="start_month" class="mr-4">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 10)); ?></option>
                <?php endfor; ?>
            </select>
            <label for="start_year" class="mr-2 text-white">Año de inicio:</label>
            <select name="start_year" id="start_year" class="mr-4">
                <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <label for="end_month" class="mr-2 text-white">Mes de fin:</label>
            <select name="end_month" id="end_month" class="mr-4">
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0, 0, 0, $i, 10)); ?></option>
                <?php endfor; ?>
            </select>
            <label for="end_year" class="mr-2 text-white">Año de fin:</label>
            <select name="end_year" id="end_year" class="mr-4">
                <?php for ($i = date('Y'); $i >= 2000; $i--): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                <?php endfor; ?>
            </select>
            <button type="submit" formaction="/auth/pdf/crear" class="bg-accent-800 text-white py-2 px-4 rounded">Imprimir Rol</button>
        </form>
    </div>
    <!-- Sección: Historial de Pagos -->
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Historial de Pagos</h1>
    <div class="w-full mt-8 flex justify-center">
        <table class="min-w-full divide-y divide-background-800">
            <thead class="bg-background-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Cédula</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Apellido</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Cargo</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Sueldo</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Aporte Patronal</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Aporte Personal</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Total a recibir</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Fecha de Pago</th>
                </tr>
            </thead>
            <tbody class="bg-background-950 divide-y divide-background-900">
                <?php 
                $total_sueldo = 0;
                $total_aporte_patronal = 0;
                $total_aporte_personal = 0;
                $total = 0;
                foreach ($result as $row): 
                    $total_sueldo = $row['TIP_CAR_SUELD'];
                    $total_aporte_patronal += $row['APOR_PATRONAL_CANTIDAD'];
                    $total_aporte_personal += $row['APOR_PERSONAL_CANTIDAD'];
                    $total += $row['SUELDO'];
                ?>
                    <tr>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['PERS_CED']); ?></td>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['PERS_NOM']); ?></td>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['PERS_APE']); ?></td>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['TIP_CAR_DES']); ?></td>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['TIP_CAR_SUELD']); ?></td>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['APOR_PATRONAL_CANTIDAD']); ?></td>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['APOR_PERSONAL_CANTIDAD']); ?></td>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['SUELDO']); ?></td>
                        <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['FECHA_PAGO']); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="4" class="px-6 py-4 text-sm font-bold text-text-50 text-center">Total</td>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total_sueldo); ?></td>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total_aporte_patronal); ?></td>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total_aporte_personal); ?></td>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total); ?></td>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Nueva Sección: Aportes Adicionales -->
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800 mt-12">Aportes Adicionales</h1>
    <div class="w-full mt-8 flex justify-center">
        <table class="min-w-full divide-y divide-background-800">
            <thead class="bg-background-900">
                <tr>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Décimo Tercero</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Décimo Cuarto</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Fondos de Reserva</th>
                    <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Fecha de Inserción</th>
                </tr>
            </thead>
            <tbody class="bg-background-950 divide-y divide-background-900">
                <?php 
                $total_decimo_tercero = 0;
                $total_decimo_cuarto = 0;
                $total_fondos_reserva = 0;
                $unique_contributions = [];
                foreach ($result as $row) {
                    if (!in_array($row['PERS_DETALLES_FECHA'], $unique_contributions)) {
                        $unique_contributions[] = $row['PERS_DETALLES_FECHA'];
                        $total_decimo_tercero += $row['PRES_DECI_III'];
                        $total_decimo_cuarto += $row['PRES_DECI_IV'];
                        $total_fondos_reserva += $row['PERS_FOND_RES'];
                ?>
                        <tr>
                            <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['PRES_DECI_III']); ?></td>
                            <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['PRES_DECI_IV']); ?></td>
                            <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['PERS_FOND_RES']); ?></td>
                            <td class="px-6 py-4 text-sm text-text-50 text-center"><?php echo htmlspecialchars($row['PERS_DETALLES_FECHA']); ?></td>
                        </tr>
                <?php 
            }
        }
        ?>
        <td colspan="4" class="px-6 py-4 text-sm font-bold text-text-50 text-center">Total de Aportes Adicionales</td>
        <tr>
            <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total_decimo_tercero); ?></td>
            <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total_decimo_cuarto); ?></td>
            <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total_fondos_reserva); ?></td>
            <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"></td>
        </tr>
    </tbody>
        </table>
    </div>
    <!-- Suma Total de Todas las Tablas -->
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800 mt-12">Total de Ingresos del Empleado</h1>
    <div class="w-full mt-8 flex justify-center">
        <table class="min-w-full divide-y divide-background-800">
            <tbody class="bg-background-950 divide-y divide-background-900">
                <tr>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center">Total Aporte Patronal</td>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total_aporte_patronal); ?></td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center">Total Aporte Personal</td>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total_aporte_personal); ?></td>
                </tr>
                <tr>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center">Total General</td>
                    <td class="px-6 py-4 text-sm font-bold text-text-50 text-center"><?php echo htmlspecialchars($total + $total_decimo_tercero + $total_decimo_cuarto + $total_fondos_reserva); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</main>
<script>
function showRangeForm() {
    var form = document.getElementById('rangeForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}
function validateDates(event) {
    const startMonth = parseInt(document.getElementById('start_month').value);
    const startYear = parseInt(document.getElementById('start_year').value);
    const endMonth = parseInt(document.getElementById('end_month').value);
    const endYear = parseInt(document.getElementById('end_year').value);
    const startDate = new Date(startYear, startMonth - 1);
    const endDate = new Date(endYear, endMonth - 1);
    if (startDate > endDate) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error de Fecha',
            text: 'La fecha de inicio debe ser anterior a la fecha de fin.'
        });
        return false;
    }

    const persFech = new Date("<?php echo $result[0]['PERS_FECH']; ?>");
    const aprilDate = new Date(persFech.getFullYear(), 3, 1);

    if (startDate < aprilDate) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Error de Fecha',
            text: 'No se puede generar un PDF antes de la fecha de ingreso del empleado.'
        });
        return false;
    }

    // Verificación adicional para comprobar si hay datos en el rango de fechas
    const hasData = <?php echo !empty($result) ? 'true' : 'false'; ?>;
    if (!hasData) {
        event.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'No se encontraron datos',
            text: 'No hay registros en el rango de fechas proporcionado.'
        });
        return false;
    }

    return true;
}

document.querySelector('form').addEventListener('submit', validateDates);
</script>



<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php if(isset($success)):?>
    <script src="/js/alertas/validacion_cedula/alertCedulaCorrecta.js"></script>
<?php endif; ?>
<?php require base_path('views/partials/end.php'); ?>
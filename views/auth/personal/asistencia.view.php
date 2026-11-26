<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-white border-b-accent-800">Gestión Asistencia</h1>

    <!-- Barra de acciones -->
    <div class="mt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <!-- Búsqueda -->
        <div class="flex items-center">
            <label class="px-2 text-sm text-text-50">Buscar:</label>
            <div class="relative">
                <input type="text" class="h-10 w-64 rounded-md p-2 pl-10 outline-0 bg-background-900 text-text-50 border border-background-800 focus:border-accent-600 transition-colors" id="inputBuscar" placeholder="Buscar por cédula o nombre">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 fill-text-200 absolute left-3 top-1/2 -translate-y-1/2">
                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 1 0 0 13.5 6.75 6.75 0 0 0 0-13.5ZM2.25 10.5a8.25 8.25 0 1 1 14.59 5.28l4.69 4.69a.75.75 0 1 1-1.06 1.06l-4.69-4.69A8.25 8.25 0 0 1 2.25 10.5Z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <!-- Botones -->
        <div class="flex items-center gap-2">
            <button onclick="window.location.href='/auth/personal/asistencia/crear'" class="flex items-center gap-2 rounded-md px-4 py-2 transition-colors duration-200 bg-secondary-800 text-text-50 hover:bg-secondary-700 active:bg-accent-500 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z" clip-rule="evenodd" />
                </svg>
                Añadir Asistencia
            </button>
            <button onclick="imprimirReporte()" class="flex items-center gap-2 rounded-md px-4 py-2 transition-colors duration-200 bg-accent-800 text-text-50 hover:bg-accent-700 active:bg-accent-500 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M7.875 1.5C6.839 1.5 6 2.34 6 3.375v2.99c-.426.053-.851.11-1.274.174-1.454.218-2.476 1.483-2.476 2.917v6.294a3 3 0 0 0 3 3h.27l-.155 1.705A1.875 1.875 0 0 0 7.232 22.5h9.536a1.875 1.875 0 0 0 1.867-2.045l-.155-1.705h.27a3 3 0 0 0 3-3V9.456c0-1.434-1.022-2.7-2.476-2.917A48.716 48.716 0 0 0 18 6.366V3.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM16.5 6.205v-2.83A.375.375 0 0 0 16.125 3h-8.25a.375.375 0 0 0-.375.375v2.83a49.353 49.353 0 0 1 9 0Zm-.217 8.265c.178.018.317.16.333.337l.526 5.784a.375.375 0 0 1-.374.409H7.232a.375.375 0 0 1-.374-.409l.526-5.784a.373.373 0 0 1 .333-.337 41.741 41.741 0 0 1 8.566 0Zm.967-3.97a.75.75 0 0 1 .75-.75h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H18a.75.75 0 0 1-.75-.75V10.5Z" clip-rule="evenodd" />
                </svg>
                Imprimir Reporte
            </button>
        </div>
    </div>

    <!-- Estadísticas rápidas -->
    <?php
    $asistencia = $asistencia ?? [];
    $totalRegistros = count($asistencia);
    ?>

    <!-- Cards de resumen -->
    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-lg bg-background-900 border border-background-800 p-4">
            <p class="text-sm text-text-200">Total Registros</p>
            <p class="text-2xl font-bold text-text-50"><?php echo $totalRegistros; ?></p>
        </div>
        <div class="rounded-lg bg-background-900 border border-background-800 p-4">
            <p class="text-sm text-text-200">Empleados Registrados</p>
            <p class="text-2xl font-bold text-text-50"><?php echo count(array_unique(array_column($asistencia, 'PERS_CED'))); ?></p>
        </div>
        <div class="rounded-lg bg-background-900 border border-background-800 p-4">
            <p class="text-sm text-text-200">Con Horas Extra</p>
            <p class="text-2xl font-bold text-accent-500"><?php echo count(array_filter($asistencia, fn($r) => !empty($r['ASIST_HORA_EXTRA']) && $r['ASIST_HORA_EXTRA'] > 0)); ?></p>
        </div>
    </div>

    <!-- Tabla de asistencia -->
    <div id="tablaAsistencia" class="w-full mt-6 overflow-x-auto rounded-lg border border-background-800">
        <table class="min-w-full divide-y divide-background-800" id="employeeTable">
            <thead class="bg-background-900">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase tracking-wider">Cédula</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-text-200 uppercase tracking-wider">Nombre Completo</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase tracking-wider">Hora Llegada</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase tracking-wider">Inicio Almuerzo</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase tracking-wider">Fin Almuerzo</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase tracking-wider">Hora Salida</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase tracking-wider">Min. Extra</th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-text-200 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-background-950 divide-y divide-background-900">
                <?php if (empty($asistencia)): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-text-200">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-10 mx-auto mb-2 fill-text-300">
                                <path fill-rule="evenodd" d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z" clip-rule="evenodd" />
                            </svg>
                            No hay registros de asistencia
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($asistencia as $registro): ?>
                        <tr class="hover:bg-background-900 transition-colors">
                            <td class="px-4 py-3 text-sm text-text-50 font-mono"><?php echo htmlspecialchars($registro['PERS_CED']); ?></td>
                            <td class="px-4 py-3 text-sm text-text-50"><?php echo htmlspecialchars($registro['PERS_NOM'] . ' ' . ($registro['PERS_APE'] ?? '')); ?></td>
                            <td class="px-4 py-3 text-sm text-text-100 text-center"><?php echo htmlspecialchars($registro['ASIST_HORA_LLEGADA']); ?></td>
                            <td class="px-4 py-3 text-sm text-text-100 text-center"><?php echo htmlspecialchars($registro['ASIST_HORA_ALMU_INI'] ?? '—'); ?></td>
                            <td class="px-4 py-3 text-sm text-text-100 text-center"><?php echo htmlspecialchars($registro['ASIST_HORA_ALMU_FIN'] ?? '—'); ?></td>
                            <td class="px-4 py-3 text-sm text-text-100 text-center"><?php echo htmlspecialchars($registro['ASIST_HORA_SALIDA'] ?? '—'); ?></td>
                            <td class="px-4 py-3 text-sm text-center">
                                <?php if (!empty($registro['ASIST_HORA_EXTRA']) && $registro['ASIST_HORA_EXTRA'] > 0): ?>
                                    <span class="inline-flex items-center rounded-full bg-accent-800/20 px-2 py-0.5 text-xs font-medium text-accent-400"><?php echo htmlspecialchars($registro['ASIST_HORA_EXTRA']); ?> min</span>
                                <?php else: ?>
                                    <span class="text-text-300">0</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center items-center gap-2">
                                    <button class="grid h-9 w-9 place-items-center rounded-md text-text-50 bg-secondary-800 hover:bg-secondary-700 transition-colors" 
                                        data-toggle="modal" data-target="#editarModal" 
                                        data-id="<?php echo $registro['ASIST_ID']; ?>" 
                                        data-persid="<?php echo $registro['PERS_ID']; ?>" 
                                        data-persced="<?php echo $registro['PERS_CED']; ?>" 
                                        data-persnom="<?php echo $registro['PERS_NOM']; ?>" 
                                        data-llegada="<?php echo $registro['ASIST_HORA_LLEGADA']; ?>" 
                                        data-almuini="<?php echo $registro['ASIST_HORA_ALMU_INI']; ?>" 
                                        data-almufin="<?php echo $registro['ASIST_HORA_ALMU_FIN']; ?>" 
                                        data-salida="<?php echo $registro['ASIST_HORA_SALIDA']; ?>" 
                                        data-extra="<?php echo $registro['ASIST_HORA_EXTRA']; ?>"
                                        title="Editar">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                            <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                            <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                        </svg>
                                    </button>
                                    <button type="button" class="btn-eliminar-asistencia grid h-9 w-9 place-items-center rounded-md text-text-50 bg-red-800 hover:bg-red-700 transition-colors" data-id="<?php echo $registro['ASIST_ID']; ?>" data-persnom="<?php echo htmlspecialchars($registro['PERS_NOM'] . ' ' . ($registro['PERS_APE'] ?? '')); ?>" title="Eliminar">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                                            <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<!-- Modal Editar Asistencia -->
<div id="editarModal" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" id="modalOverlay" style="display:none;">
        <div class="bg-background-900 rounded-lg shadow-xl border border-background-800 w-full max-w-lg mx-4">
            <div class="flex items-center justify-between px-6 py-4 border-b border-background-800">
                <h5 class="text-lg font-semibold text-text-50" id="editarModalLabel">Editar Asistencia</h5>
                <button type="button" class="text-text-200 hover:text-text-50 transition-colors" id="closeModalBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <div class="px-6 py-4">
                <form id="editarForm" method="POST" action="/auth/personal/asistencia/crear">
                    <input type="hidden" name="asist_id" id="editarASIST_ID">
                    <input type="hidden" name="pers_id" id="editarPERS_ID">
                    <input type="hidden" name="pers_ced" id="editarPERS_CED">
                    <div class="mb-4">
                        <label for="editarPERS_NOM" class="block text-sm font-medium text-text-200 mb-1">Nombre</label>
                        <input type="text" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50" name="pers_nom" id="editarPERS_NOM" disabled>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="editarASIST_HORA_LLEGADA" class="block text-sm font-medium text-text-200 mb-1">Hora Llegada</label>
                            <input type="text" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 datetime-picker" name="asist_hora_llegada" id="editarASIST_HORA_LLEGADA" required>
                        </div>
                        <div>
                            <label for="editarASIST_HORA_SALIDA" class="block text-sm font-medium text-text-200 mb-1">Hora Salida</label>
                            <input type="text" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 datetime-picker" name="asist_hora_salida" id="editarASIST_HORA_SALIDA">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="editarASIST_HORA_ALMU_INI" class="block text-sm font-medium text-text-200 mb-1">Inicio Almuerzo</label>
                            <input type="text" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 datetime-picker" name="asist_hora_almu_ini" id="editarASIST_HORA_ALMU_INI">
                        </div>
                        <div>
                            <label for="editarASIST_HORA_ALMU_FIN" class="block text-sm font-medium text-text-200 mb-1">Fin Almuerzo</label>
                            <input type="text" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50 datetime-picker" name="asist_hora_almu_fin" id="editarASIST_HORA_ALMU_FIN">
                        </div>
                    </div>
                    <div class="mb-6">
                        <label for="editarASIST_HORA_EXTRA" class="block text-sm font-medium text-text-200 mb-1">Minutos Extra</label>
                        <input type="number" class="w-full rounded-md bg-background-950 border border-background-800 px-3 py-2 text-text-50" name="asist_hora_extra" id="editarASIST_HORA_EXTRA" min="0">
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" class="px-4 py-2 rounded-md bg-background-800 text-text-50 hover:bg-background-700 transition-colors" id="cancelModalBtn">Cancelar</button>
                        <button type="submit" class="px-4 py-2 rounded-md bg-secondary-800 text-text-50 hover:bg-secondary-700 transition-colors font-medium">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Flatpickr para los campos de fecha/hora
    flatpickr('.datetime-picker', {
        enableTime: true,
        dateFormat: 'Y-m-d H:i:S',
        time_24hr: true
    });

    // Búsqueda en tabla - busca por cédula y nombre
    const inputBuscar = document.getElementById('inputBuscar');
    inputBuscar.addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        const rows = document.querySelectorAll('#tablaAsistencia tbody tr');
        rows.forEach(function(row) {
            const cedula = row.cells[0]?.textContent.toLowerCase() || '';
            const nombre = row.cells[1]?.textContent.toLowerCase() || '';
            if (cedula.includes(value) || nombre.includes(value)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Modal custom (sin Bootstrap)
    const overlay = document.getElementById('modalOverlay');
    const closeBtn = document.getElementById('closeModalBtn');
    const cancelBtn = document.getElementById('cancelModalBtn');

    function openModal() { overlay.style.display = 'flex'; }
    function closeModal() { overlay.style.display = 'none'; }

    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
    overlay?.addEventListener('click', function(e) { if (e.target === overlay) closeModal(); });

    // Abrir modal desde botones de editar
    document.querySelectorAll('[data-target="#editarModal"]').forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('editarASIST_ID').value = this.dataset.id;
            document.getElementById('editarPERS_ID').value = this.dataset.persid;
            document.getElementById('editarPERS_CED').value = this.dataset.persced;
            document.getElementById('editarPERS_NOM').value = this.dataset.persnom;
            document.getElementById('editarASIST_HORA_LLEGADA').value = this.dataset.llegada;
            document.getElementById('editarASIST_HORA_ALMU_INI').value = this.dataset.almuini || '';
            document.getElementById('editarASIST_HORA_ALMU_FIN').value = this.dataset.almufin || '';
            document.getElementById('editarASIST_HORA_SALIDA').value = this.dataset.salida || '';
            document.getElementById('editarASIST_HORA_EXTRA').value = this.dataset.extra || '0';
            openModal();
        });
    });

    // Submit del formulario de edición
    document.getElementById('editarForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('/auth/personal/asistencia/crear', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeModal();
                location.reload();
            } else {
                alert(data.error || 'Error al actualizar la asistencia.');
            }
        })
        .catch(error => {
            alert('Error: ' + error);
        });
    });

    // Botones de eliminar
    document.querySelectorAll('.btn-eliminar-asistencia').forEach(function(button) {
        button.addEventListener('click', function() {
            const asistId = this.dataset.id;
            const nombre = this.dataset.persnom || 'este empleado';
            if (!confirm('¿Estás seguro de eliminar el registro de asistencia de ' + nombre + '?')) {
                return;
            }
            const formData = new FormData();
            formData.append('action', 'delete_asistencia');
            formData.append('asist_id', asistId);

            fetch('/auth/personal/asistencia/crear', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.error || 'Error al eliminar la asistencia.');
                }
            })
            .catch(error => {
                alert('Error: ' + error);
            });
        });
    });
});

function imprimirReporte() {
    var table = document.getElementById('tablaAsistencia');
    var printContents = table.outerHTML;

    var parser = new DOMParser();
    var doc = parser.parseFromString(printContents, 'text/html');
    var rows = doc.querySelectorAll('tr');

    rows.forEach(function(row) {
        var cells = row.cells;
        if (cells.length > 0) {
            row.removeChild(cells[cells.length - 1]);
        }
    });

    var printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Reporte de Asistencia</title>');
    printWindow.document.write('<style>body{font-family:sans-serif;padding:20px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #ccc;padding:8px;text-align:center;font-size:13px}th{background:#333;color:#fff}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h2>Reporte de Asistencia - Hotel Oasis</h2>');
    printWindow.document.write('<p>Fecha: ' + new Date().toLocaleDateString() + '</p>');
    printWindow.document.write(doc.body.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
</script>

</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php require base_path('views/partials/end.php'); ?>

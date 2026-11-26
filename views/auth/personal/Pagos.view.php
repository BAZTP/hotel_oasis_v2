<?php require base_path('views/partials/head.php'); ?>
<?php require base_path('views/partials/auth_header.php'); ?>

<main class="relative w-full px-8 pt-20 pb-16 min-h-dvh bg-background-950">
    <h1 class="w-fit border-b py-2 text-4xl font-semibold text-text-50 border-b-accent-800">Pagar a Empleados</h1>
    
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
            <div class="ml-auto">
                <button onclick="showPaymentForms()" class="px-4 py-2 bg-secondary-800 text-white rounded-md">Pagar a Seleccionados</button>
            </div>
        </div>
        <div class="w-full mt-8 flex justify-center table-container">
            <table class="min-w-full divide-y divide-background-800" id="employeeTable">
                <thead class="bg-background-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center"><input type="checkbox" id="selectAll"></th>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Cédula</th>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Apellido</th>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Email</th>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Cuenta Bancaria</th>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Tipo de Banco</th>
                        <th class="px-6 py-3 text-left text-xs text-text-200 uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-background-950 divide-y divide-background-800">
                <?php if (!empty($personal)): ?>
                    <?php foreach ($personal as $row): ?>
                        <tr>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><input type="checkbox" class="selectEmployee" value="<?= htmlspecialchars(json_encode($row)) ?>"></td>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_CED']) ?></td>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_NOM']) ?></td>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_APE']) ?></td>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 tracking-wider'><?= htmlspecialchars(strtolower($row['PERS_EMAIL'])) ?></td>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_TELF']) ?></td>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['PERS_NUM_CUENT_BK']) ?></td>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'><?= htmlspecialchars($row['TIP_BANCO_DES']) ?></td>
                            <td class='px-1 py-1 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'>
                                <div class="flex justify-center items-center space-x-2">
                                    <button onclick="showPaymentForm(<?= htmlspecialchars(json_encode($row)) ?>)" class="px-4 py-2 bg-secondary-800 text-white rounded-md">Detalles</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class='px-1 py-2 whitespace-nowrap text-center text-text-200 uppercase tracking-wider'>No results found</td>
                    </tr>
                <?php endif; ?> 
                </tbody>
            </table>  
        </div>
    </div>

 <!-- Formulario de Pago Oculto -->
<div id="paymentForm" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="modal-dialog" role="document">
        <div class="modal-content relative bg-secondary-800 rounded-lg shadow-lg p-8">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative z-10">
                <h2 class="text-white font-semibold mb-4">Pagar a Empleado</h2>
                <form id="pagarForm" method="POST" onsubmit="return realizarPago();" onsubmit="return realizarAportePersonal();" onsubmit="return realizarAportePatronal();">
                    <input type="hidden" name="PERS_ID" id="pagarPERS_ID">
                    <div class="mb-4">
                        <label for="pagarPERS_NOM" class="block font-medium text-white">Nombre:</label>
                        <input type="text" class="w-full border-gray-300 rounded-md p-2" name="PERS_NOM" id="pagarPERS_NOM" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="pagarPERS_APE" class="block font-medium text-white">Apellido:</label>
                        <input type="text" class="w-full border-gray-300 rounded-md p-2" name="PERS_APE" id="pagarPERS_APE" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="pagarPERS_CED" class="block font-medium text-white">Cédula:</label>
                        <input type="text" class="w-full border-gray-300 rounded-md p-2" name="PERS_CED" id="pagarPERS_CED" readonly>
                    </div>
                    <div class="mb-4">
                        <label for="pagarSUELDO" class="block font-medium text-white">Sueldo:</label>
                        <input type="number" step="0.01" class="w-full border-gray-300 rounded-md p-2" name="SUELDO" id="pagarSUELDO" required readonly>
                    </div>
                    <div class="mb-4">
                        <label for="pagarFECHA_PAGO" class="block font-medium text-white">Fecha de Pago:</label>
                        <input type="text" class="w-full border-gray-300 rounded-md p-2" name="FECHA_PAGO" id="pagarFECHA_PAGO" required readonly>
                    </div>
                    <div class="mb-4">
                        <label for="pagarIESS_PERSONAL" class="block font-medium text-white">IESS Personal:</label>
                        <input type="number" step="0.01" class="w-full border-gray-300 rounded-md p-2" name="IESS_PERSONAL" id="pagarIESS_PERSONAL" required readonly>
                    </div>
                    <div class="mb-4 hidden">
                        <label for="pagarIESS_PATRONAL" class="block font-medium text-white">IESS Patronal:</label>
                        <input type="number" step="0.01" class="w-full border-gray-300 rounded-md p-2" name="IESS_PATRONAL" id="pagarIESS_PATRONAL" required readonly>
                    </div>
                    <div class="mb-4">
                        <label for="pagarTOTAL" class="block font-medium text-white">Total:</label>
                        <input type="number" step="0.01" class="w-full border-gray-300 rounded-md p-2" name="TOTAL" id="pagarTOTAL" readonly>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-accent-600 text-white rounded-md">Confirmar Pago</button>
                        <button type="button" onclick="hidePaymentForm()" class="px-4 py-2 bg-accent-600 text-white rounded-md mr-1">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    
    <script>
document.getElementById('selectAll').addEventListener('change', function () {
        var checkboxes = document.querySelectorAll('.selectEmployee');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
    
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
function showPaymentForms() {
    var selectedEmployees = document.querySelectorAll(".selectEmployee:checked");

    if (selectedEmployees.length === 0) {
        alert("Por favor, seleccione al menos un empleado.");
        return;
    }

    selectedEmployees.forEach(function(checkbox) {
        var employeeData = JSON.parse(checkbox.value);
        insertPaymentData(employeeData);
    });
}

function insertPaymentData(employee) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/auth/Pagos/crear", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response.includes("Error: Ya se ha registrado un pago para este empleado en el mes actual.")) {
                Swal.fire({
                    icon: 'warning', 
                    title: 'Advertencia',
                    text: 'No se realizará el pago ya que existe un pago dentro del mes.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'El pago se ha realizado exitosamente.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }
    };

    var sueldo = employee.TIP_CAR_SUELD;
    var iessPersonal = (sueldo * 0.0945).toFixed(2);
    var iessPatronal = (sueldo * 0.1215).toFixed(2);
    var sueldoNeto = (sueldo - iessPersonal).toFixed(2);
    var fechaPago = new Date().toISOString().split('T')[0];

    var params = "PERS_ID=" + encodeURIComponent(employee.PERS_ID) +
        "&PERS_NOM=" + encodeURIComponent(employee.PERS_NOM) +
        "&PERS_APE=" + encodeURIComponent(employee.PERS_APE) +
        "&PERS_CED=" + encodeURIComponent(employee.PERS_CED) +
        "&SUELDO=" + encodeURIComponent(sueldoNeto) +
        "&FECHA_PAGO=" + encodeURIComponent(fechaPago) +
        "&APOR_PATRONAL_CANTIDAD=" + encodeURIComponent(iessPatronal) +
        "&APOR_PERSONAL_CANTIDAD=" + encodeURIComponent(iessPersonal);

    xhr.send(params);
}

function hidePaymentForm() {
    document.getElementById("paymentForm").classList.add("hidden");
}
function showPaymentForm(employee) {
    document.getElementById("pagarPERS_ID").value = employee.PERS_ID;
    document.getElementById("pagarPERS_NOM").value = employee.PERS_NOM;
    document.getElementById("pagarPERS_APE").value = employee.PERS_APE;
    document.getElementById("pagarPERS_CED").value = employee.PERS_CED;
    document.getElementById("pagarSUELDO").value = employee.TIP_CAR_SUELD;
    document.getElementById("pagarFECHA_PAGO").value = new Date().toISOString().split('T')[0];
    document.getElementById("pagarIESS_PERSONAL").value = (employee.TIP_CAR_SUELD * 0.0945).toFixed(2);
    document.getElementById("pagarIESS_PATRONAL").value = (employee.TIP_CAR_SUELD * 0.1215).toFixed(2);
    var sueldo = parseFloat(document.getElementById('pagarSUELDO').value);
    var iessPersonal = parseFloat(document.getElementById('pagarIESS_PERSONAL').value);

    var sueldoNeto = sueldo - iessPersonal;
    document.getElementById('pagarTOTAL').value = sueldoNeto.toFixed(2);
    document.getElementById("paymentForm").classList.remove("hidden");
}
function realizarPago() {
    var sueldoNeto = parseFloat(document.getElementById('pagarTOTAL').value);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/auth/Pagos/crear", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            if (response.includes("Error: Ya se ha registrado un pago para este empleado en el mes actual.")) {
                Swal.fire({
                    icon: 'warning', // Cambiado de 'error' a 'warning'
                    title: 'Advertencia',
                    text: 'No se realizará el pago ya que existe un pago dentro del mes.',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: 'El pago se ha realizado exitosamente.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }
    };

    var params = "PERS_ID=" + encodeURIComponent(document.getElementById('pagarPERS_ID').value) +
        "&PERS_NOM=" + encodeURIComponent(document.getElementById('pagarPERS_NOM').value) +
        "&PERS_APE=" + encodeURIComponent(document.getElementById('pagarPERS_APE').value) +
        "&PERS_CED=" + encodeURIComponent(document.getElementById('pagarPERS_CED').value) +
        "&SUELDO=" + encodeURIComponent(sueldoNeto.toFixed(2)) +
        "&FECHA_PAGO=" + encodeURIComponent(document.getElementById('pagarFECHA_PAGO').value) +
        "&APOR_PATRONAL_CANTIDAD=" + encodeURIComponent(document.getElementById('pagarIESS_PATRONAL').value) +
        "&APOR_PERSONAL_CANTIDAD=" + encodeURIComponent(document.getElementById('pagarIESS_PERSONAL').value);

    xhr.send(params);
    return false;
}
    </script>
</main>

<?php require base_path('views/partials/routes_aside.php'); ?>
<?php require base_path('views/partials/auth_footer.php'); ?>
<?php if(isset($success)):?>
    <script src="/js/alertas/validacion_cedula/alertCedulaCorrecta.js"></script>
    <script src="/js/auth/personal/pagos.js"></script>
<?php endif; ?>
<?php require base_path('views/partials/end.php'); ?>
